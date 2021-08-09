function alertNotificationMessageExtLoadingContent() {
    var obj = JSON.parse(sessionStorage.getItem('alertNotificationMessageExt'));

    console.log(obj);

    if(obj !== null){
        $('#alertNotificationMessageExtContent').html(``);
        obj.reverse().slice(0,10).forEach(item => {
            var icon = alertNotificationMessageExtIcon(item);
            // var text_class = alertNotificationMessageExtTextStyle(item);
            var text_content = alertNotificationMessageExtTexContent(item);
            $('#alertNotificationMessageExtContent').append(`
                <div class="text-nowrap user-msg user-fix custom-bd-hover" style="cursor: default;" onclick="alertNotificationMessageExtPopUp('${item.type}','${item.id}','${text_content.content}')">
                    <span>${icon} - ${item.timestamp}</span>
                    <p>${text_content.text}</p>
                </div>
                <div class="dropdown-divider"></div>
            `);
        })
    } else {
        $('#alertNotificationMessageExtContent').html(``);
        $('#alertNotificationMessageExtContent').append(`
                <div class="text-nowrap user-msg user-fix">
                    Nenhuma notificação recente encontrada.
                </div>
        `);
    }
}

function alertNotificationMessageExtIcon(item) {

    var icons = [];

    if(item.type == 'solicitation'){
        icons.push('<i class="text-success fas fa-user-plus"></i>');
        icons.push('<i class="text-info fas fa-question-circle"></i>');

    } else {

        if(item.type_warning == 'reason'){
            icons.push('<i class="text-danger fas fa-user-times"></i>');
        } else {
            icons.push('<i class="fas fa-user-check"></i>');
        }

    }

    return icons.join(' ');
}

// function alertNotificationMessageExtTextStyle(item) {

//     var style = [];

//     switch(item.status){
//         case 'unread':
//             style.push('font-weight-bold');
//             break;
//     }

//     return style.join(' ');
// }

function alertNotificationMessageExtTexContent(item) {
    var str = '';

    if(item.type == 'solicitation'){
        str = `Nova solitação <br> Classe: <b>${item.class_name}</b> <br> Requisitante: <b>${item.user_request}</b>`
    } else {
        if(item.type_warning == 'active'){
            str = `Você foi aceito na Aula: <b>${item.class_name}</b>`
        } else {
            str = `Você não foi aceito na Aula: <b>${item.class_name}</b> </br> Motivo: <b>${item.solicitation_reason}</b>`
        }
    }
    console.log(str);
    return {
        'text': 'Clique para mais detalhes.',
        'content': str
    };
}


function alertNotificationMessageExtPopUp(type, id, item){

    const content = Swal.mixin({
        customClass: {
          confirmButton: 'btn btn-sm btn-success',
          denyButton: 'btn btn-sm btn-danger ml-2',
          input: 'alert-notification-message-ext-input-text'
        },
        buttonsStyling: false
      })
    
    if(type == 'solicitation'){

        content.fire({
            html: item,
            width: 450,
            showCloseButton: false,
            showConfirmButton: true,
            showDenyButton: true,
            confirmButtonText: '<i class="fas fa-check"></i>',
            denyButtonText: '<i class="fas fa-times"></i>'
        }).then((result) => {
            if (result.isConfirmed) {
                accept_request_class(id);
            } else if (result.isDenied) {
                deny_request_class(id);
            }
        });

    } else {

        content.fire({
            html: item,
            width: 450,
            showCloseButton: false,
            showConfirmButton: true,
            confirmButtonText: '<i class="fas fa-check"></i>'
        }).then((result) => {
            if (result.isConfirmed) {
                close_notification(id);
            }
        });

    }

}

class notification {

    constructor() {
        this.ping();
    }

    ping = () => {

        var interval = setInterval( async () => {

            var headers = {
                'X-CSRF-TOKEN': $('[name="_token"]').val()
            };
    
            var url = `${window.location.protocol}//${window.location.hostname}:${window.location.port}/admin/notification`;
    
            await $.ajax({
                type: 'GET',
                url: url,
                headers: headers,
                success: ( res ) => {

                    sessionStorage.removeItem('alertNotificationMessageExt');
                    
                    res.solicitations.forEach(item => {
                        this.alertNotificationMessageExtAddContent('solicitation', item)
                    });

                    res.warnings.forEach(item => {
                        this.alertNotificationMessageExtAddContent('warnings', item)
                    });

                    this.alertNotificationMessageExt(res.count_alerts);

                },
                error: ( error ) => {
    
                }
    
            });

        }, 3000);

    }

    alertNotificationMessageExtAddContent = (type, content) => {
        // let date = new Date();
        //     options = {
        //         year: 'numeric', month: 'numeric', day: 'numeric',
        //         hour: 'numeric', minute: 'numeric', second: 'numeric',
        //         hour12: false,
        //         timeZone: 'America/Los_Angeles'
        //     };
        // let time = new Intl.DateTimeFormat('pt-BR', options).format(date);
    
        if(sessionStorage.getItem('alertNotificationMessageExt') == null){

            if(type == 'solicitation'){
                var obj = [
                    {
                        'type':            type,  
                        'id':              content.solicitation_id,
                        'class_name':      content.class_name,
                        'user_request':    content.user_request,
                        'timestamp':       content.date
                    }
                ];
            } else {
                var obj = [
                    {
                        'type':                type,
                        'id':                  content.warning_id,
                        'class_name':          content.class_name,
                        'type_warning':        content.type_warning,
                        'solicitation_reason': content.solicitation_reason,
                        'timestamp':           content.date
                    }
                ];
            }
    
            sessionStorage.setItem('alertNotificationMessageExt', JSON.stringify(obj));
        } else {
            var obj = JSON.parse(sessionStorage.getItem('alertNotificationMessageExt'));

                if(type == 'solicitation'){
                    var ctn = {
                            'type':            type,
                            'id':              content.solicitation_id,
                            'class_name':      content.class_name,
                            'user_request':    content.user_request,
                            'timestamp':       content.date
                        }

                } else {
                    var ctn = {
                            'type':                type,
                            'id':                  content.warning_id,
                            'class_name':          content.class_name,
                            'type_warning':        content.type_warning,
                            'solicitation_reason': content.solicitation_reason,
                            'timestamp':           content.date
                        }
                }
    
            obj.push(ctn);
            sessionStorage.setItem('alertNotificationMessageExt', JSON.stringify(obj));
        }
    }

    alertNotificationMessageExt = (count_v = null) => {

        if(count_v !== null){

            $('#alert-notification-message-ext-count').html(count_v);

        } else {
            var obj = JSON.parse(sessionStorage.getItem('alertNotificationMessageExt'));
    
            var count = 0;
        
            if(obj !== null){
        
                obj.forEach(item => {
                    if(item.status == 'unread' || item.answer)
                        count++;
                });
        
                $('#alert-notification-message-ext-count').html(count);
            }
        }
        
    }

}