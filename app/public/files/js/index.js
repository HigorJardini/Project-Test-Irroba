function aprove_user(user_id) {

    var url = `${window.location.protocol}//${window.location.hostname}:${window.location.port}/admin/users/aproved/${user_id}`;

    ajax_user(user_id, url, 'PUT');
}

function delete_user(user_id) {

    var url = `${window.location.protocol}//${window.location.hostname}:${window.location.port}/admin/users/delete/${user_id}`;

    ajax_user(user_id, url, 'DELETE');
}

function delete_metter(metter_id) {

    var url = `${window.location.protocol}//${window.location.hostname}:${window.location.port}/admin/metters/delete/${metter_id}`;

    ajax_user(metter_id, url, 'DELETE');
}

function delete_class(classe_id) {

    var url = `${window.location.protocol}//${window.location.hostname}:${window.location.port}/admin/classes/delete/${classe_id}`;

    ajax_user(classe_id, url, 'DELETE');
}

function ajax_user(id, url, method) {

    const Result = content_swal();

    $.ajax({
    
        url : url,
        type: method,
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    
    }).done(function(response){ 
        
        var opt_alert = {
            icon: 'success',
            title: `<p>${response}</p>`
        };

        Result.fire(opt_alert);

        $('#tr-user-id-' + id).remove();

    }).fail(function(response) {

        var errors = '';

        Object.values(response.responseJSON.errors).forEach(item => {
            errors += "- " + item.join() + '</br>';
        });

        var opt_alert = {
            icon: 'error',
            title: `<p>${errors}</p>`
        };

        Result.fire(opt_alert);

    });

}

function content_swal(){
    return Swal.mixin({
        toast: true,
        width: 310,
        position: 'top-end',
        showConfirmButton: false,
        timer: 2600,
        timerProgressBar: true,
        didOpen: (toast) => {
            toast.addEventListener('mouseenter', Swal.stopTimer)
            toast.addEventListener('mouseleave', Swal.resumeTimer)
        },
        customClass: {
            title: 'title-alert-size',
        },

    });
}