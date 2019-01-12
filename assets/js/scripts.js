const ALERT_TYPE_SUCCESS = 'success';
const ALERT_TYPE_WARNING = 'warning';
const ALERT_CLOSE_TIMEOUT = 1000;

function addAlert(msg, type)
{
    $('#alert-container')
        .append(
            '<div class="alert alert-' + type + '" role="alert">' +
                msg +
                '<button type="button" class="close" data-dismiss="alert" aria-label="Close">' +
                    '<span aria-hidden="true">&times;</span>' +
                '</button>' +
            '</div>'
        );

    $('#alert-container .alert').alert();
    setTimeout(function() {
        removeAlert();
    }, ALERT_CLOSE_TIMEOUT)
}


function removeAlert()
{
    $('#alert-container .alert').alert('close');
}


$(document).ready(function() {


   $('.add-to-card').click(function(e) {
       e.preventDefault();
       var $button = $(this);

       var request = $.ajax({
           url: "/basket/add",
           method: "POST",
           data: { id : $(this).attr('data-id') }
       });

       request.done(function( msg ) {
          if (msg.success) {
              $button.remove();
              addAlert(
                  'Oferta zostala dodana do koszyka',
                  ALERT_TYPE_SUCCESS
              );
          }
       });

   });

    $('.remove-from-card').click(function(e) {
        e.preventDefault();

        var request = $.ajax({
            url: "/basket/remove",
            method: "POST",
            data: { id : $(this).attr('data-id') }
        });

        request.done(function( msg ) {
            if (msg.success) {
                window.location.reload();
                addAlert(
                    'Oferta zostala usunienta z koszyka',
                    ALERT_TYPE_SUCCESS
                );
            }
        });

    });

});