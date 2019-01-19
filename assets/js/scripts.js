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

   $('#sort-halls').change(function(e) {
        e.preventDefault();

        var sortType = $(this).val();
        var sortInputs = {
            asc:  $('#catalog-filter input[name="sort[asc]"]'),
            desc: $('#catalog-filter input[name="sort[desc]"]')
        };

        sortInputs.asc.val('');
        sortInputs.desc.val('');

        if (sortType.length > 0) {
            var sortTypeArr = sortType.split('.');

            if (sortInputs[sortTypeArr[0]]) {
                sortInputs[sortTypeArr[0]].val(sortTypeArr[1]);
            }
        }

        $('#catalog-filter').submit();
   });

   $('#print-booking-report').click(function(e) {
       e.preventDefault();
       var dateFrom = $('[name="date[from]"]').val(),
           dateTo = $('[name="date[to]"]').val();

       var request = $.ajax({
           url: "/account/bookings/report/csv?date[from]=" + dateFrom + "&date[to]=" + dateTo,
           method: "GET",
       });

       request.done(function(response) {
           var date = new Date();
           var iso = date.toISOString().match(/(\d{4}\-\d{2}\-\d{2})T(\d{2}:\d{2}:\d{2})/);
           var filename = 'rezerwacje-raport' + iso[1] + 'T' + iso[2] + '.csv';
           var blob = new Blob([response], { type: 'text/csv' });
           var link = document.createElement('a');
           link.href = window.URL.createObjectURL(blob);
           link.download = filename;
           document.body.appendChild(link);
           link.click();
           document.body.removeChild(link);
       });
   });

   $('#print-rent-report').click(function(e) {
       e.preventDefault();

       var request = $.ajax({
           url: "/account/rent/report/csv",
           method: "GET",
       });

       request.done(function(response) {
           var date = new Date();
           var iso = date.toISOString().match(/(\d{4}\-\d{2}\-\d{2})T(\d{2}:\d{2}:\d{2})/);
           var filename = 'wynajecia-raport' + iso[1] + 'T' + iso[2] + '.csv';
           var blob = new Blob([response], { type: 'text/csv' });
           var link = document.createElement('a');
           link.href = window.URL.createObjectURL(blob);
           link.download = filename;
           document.body.appendChild(link);
           link.click();
           document.body.removeChild(link);
       });
   });
});