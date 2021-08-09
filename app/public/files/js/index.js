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

function delete_class(class_id) {

    var url = `${window.location.protocol}//${window.location.hostname}:${window.location.port}/admin/classes/delete/${class_id}`;

    ajax_user(class_id, url, 'DELETE');
}

function request_class(class_id) {

    var url = `${window.location.protocol}//${window.location.hostname}:${window.location.port}/admin/classes/request/${class_id}`;

    const btn = {
        'class': 'btn btn-warning btn-sm text-light disabled',
        'content': '<i class="fas fa-user-clock"></i>',
        'href': '',
        'onclick': ''
    }

    ajax_user(class_id, url, 'GET', false, btn);
}

function cancel_class(class_id) {

    var url = `${window.location.protocol}//${window.location.hostname}:${window.location.port}/admin/classes/request/cancel/${class_id}`;

    const btn = {
        'class': 'btn btn-success btn-sm text-light',
        'content': '<i class="fas fa-user-plus"></i>',
        'href': '',
        'onclick': `request_class(${class_id})`
    }

    ajax_user(class_id, url, 'DELETE', false, btn, true);
}

function accept_request_class(request_id) {

    var url = `${window.location.protocol}//${window.location.hostname}:${window.location.port}/admin/classes/students/1/${request_id}`;

    const btn = {
        'class': 'btn btn-success btn-sm text-light disabled',
        'content': '<i class="fas fa-user-check"></i>',
        'href': '',
        'onclick': ''
    }

    ajax_user(request_id, url, 'PUT', false, btn, true);
}

function close_notification(warning_id) {

    var url = `${window.location.protocol}//${window.location.hostname}:${window.location.port}/admin/notification/close/${warning_id}`;

    ajax_user(warning_id, url, 'PUT', false, {});
}

async function deny_request_class(request_id) {

    const { value: reason } = await Swal.fire({
        input: 'textarea',
        inputLabel: 'Porque está negando está solicitação?',
        inputPlaceholder: 'Escreva aqui o motivo...',
        inputAttributes: {
          'aria-label': 'Type your message here'
        },
        confirmButtonText:'<i class="fas fa-check"></i>',
        cancelButtonText: '<i class="fas fa-times"></i>',
        showCancelButton: true,
        confirmButtonColor: '#28a745',
        cancelButtonColor: '#dc3545',

      })
      
    if (reason) {
        var url = `${window.location.protocol}//${window.location.hostname}:${window.location.port}/admin/classes/students/0/${request_id}`;

        const btn = {
            'class': 'btn btn-danger btn-sm text-light disabled',
            'content': '<i class="fas fa-user-times"></i>',
            'href': '',
            'onclick': ''
        }

        const content = {
            'reason': reason
        }

        ajax_user(request_id, url, 'PUT', false, btn, true, content);
    }
}

function ajax_user(id, url, method, remove_tr = true, btn = {}, btn_aux = false, content = {}) {

    const Result = content_swal();

    $.ajax({
    
        url : url,
        type: method,
        data: content,
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    
    }).done(function(response){ 
        
        var opt_alert = {
            icon: 'success',
            title: `<p>${response}</p>`
        };

        Result.fire(opt_alert);

        if(remove_tr)
            $('#tr-user-id-' + id).remove();

        if(Object.keys(btn).length > 0){
            $('#btn-' + id).removeAttr('class')
                           .attr('class', btn.class)
                           .html(btn.content);

            if(btn.href != '')
                $('#btn-' + id).removeAttr('href').attr('href', btn.href);
            else
                $('#btn-' + id).removeAttr('href');
            
            if(btn.onclick != ''){
                console.log(btn.onclick);
                $('#btn-' + id).removeAttr('onclick').attr('onclick', btn.onclick);
            }
            else
                $('#btn-' + id).removeAttr('onclick');
        } 

        if(btn_aux)
            $('#btn-aux-' + id).remove();

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

function view_description_class(text){
    Swal.fire({
        text: text,
        showConfirmButton: false,
        showCancelButton: false,
        showCloseButton: true
    });
}