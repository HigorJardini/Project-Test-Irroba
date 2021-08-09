<?php

namespace App\Repositories\Web;

use App\Models\ClassesSolicitation;
use App\Models\SolicitationWarn;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

use Laratrust\LaratrustFacade as Laratrust;

use Exception;

class NotificationRepository
{
    private $classesSolicitation;
    private $solicitationWarn;

    public function __construct(
                                    ClassesSolicitation $classesSolicitation,
                                    SolicitationWarn    $solicitationWarn
                               )
    {
        $this->classesSolicitation = $classesSolicitation;
        $this->solicitationWarn    = $solicitationWarn;
    }

    public function notifications()
    {
        try {
            $solicitations = $this->classesSolicitation
                                                       ->select(
                                                            'classes_solicitation.id as solicitation_id',
                                                            'classes.name as class_name',
                                                            'users.name as user_request'
                                                       )
                                                       ->selectRaw("DATE_FORMAT(classes_solicitation.created_at, \"%d/%m/%Y %H:%i:%s\") as date")
                                                       ->leftJoin('classes', 'classes.id', '=', 'classes_solicitation.class_id')
                                                       ->leftJoin('users', 'users.id', '=', 'classes_solicitation.user_id')
                                                       ->where('classes_solicitation.accept', false)
                                                       ->whereNull('classes_solicitation.reason')
                                                       ->where('classes.user_id', Auth::id())
                                                       ->get()
                                                       ->toArray();

            $warnings = $this->solicitationWarn->select(
                                                        'solicitation_warn.id as warning_id', 
                                                        'classes.name as class_name',
                                                        'classes_solicitation.reason as solicitation_reason'
                                                       )
                                               ->selectRaw("DATE_FORMAT(solicitation_warn.created_at, \"%d/%m/%Y %H:%i:%s\") as date")
                                               ->selectRaw("IF(classes_solicitation.reason IS NOT NULL, 'reason', 'active') as type_warning")
                                               ->leftJoin('classes_solicitation', 'classes_solicitation.id', '=', 'solicitation_warn.classe_solicitation_id')
                                               ->leftJoin('classes', 'classes.id', '=', 'classes_solicitation.class_id')
                                               ->where('solicitation_warn.warned', false)
                                               ->where('classes_solicitation.user_id', Auth::id())
                                               ->get()
                                               ->toArray();

            return [
                'solicitations' => $solicitations,
                'warnings'      => $warnings,
                'count_alerts'  => count($warnings) + count($solicitations)
            ];

        } catch (\Throwable $th) {
            return response('', 500);
        }
    }

    public function notificationsClose($warning_id)
    {
        DB::beginTransaction();

        try {

            $this->solicitationWarn->where('id', $warning_id)
                                   ->update([
                                       'warned' => true,
                                       'warned_at' => date('Y-m-d H:i:s')
                                   ]);

            DB::commit();

            return response(["Notificação visualizada"], 200);

        } catch (\Throwable $th) {

            DB::rollBack();

            return response(['errors' => [
                                'users' => [
                                    ['Error notificação']
                                ]
                            ]], 500);
        }
    }
    
}
