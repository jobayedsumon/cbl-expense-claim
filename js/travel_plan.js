$(document).ready(function () {
   $('button[name="TRAVEL_ACTION"]').on('click', function (e) {
      e.preventDefault();
      var form = $('#travelPlanStoreForm')[0];

      if($(this).val() === 'SEND' && $('#approvalPersonTable tbody tr').length <= 0) {
          bootbox.alert({
              message: 'No approval person added.',
              className: 'text-danger'
          });
      } else {
          var APPROVERS = [];
          $('#approvalPersonTable tbody tr').each(function () {
              var approverId = $(this).find('td:first-child').data('approver-id');
              APPROVERS.push(approverId);
          });

          var data = new FormData(form);
          var countryToVisited = '';
          $.each($('#countryToVisited').val(), function (index, value) {
              countryToVisited += value;
              countryToVisited += ',';
          });
          data.append('COUNTRY_TO_VISITED', countryToVisited);
          data.append('TRAVEL_ACTION', $(this).val());
          data.delete('REQUEST_ID');
          data.delete('ATTACHMENT_FOR');

          var object = {};
          data.forEach(function (value, key) {
              object[key] = value;
          });
          object['APPROVAL_PERSON'] = APPROVERS;
          var jsonData = JSON.stringify(object);

          $.ajax({
              url: EXCS_URL+'/excs/travel_plans/'+$('input[name="REQUEST_ID"]').val(),
              type: 'PUT',
              processData: false,
              contentType: false,
              data: jsonData,
              error: function(xhr, status, error) {
                  console.log('xhr: ');
                  console.log(xhr);
                  console.log('status: ' + status);
                  console.log('error: ' + error);
              },
              success: function(response) {
                  var url = BASE_URL + 'excs/plan_list';
                  bootbox.alert({
                      message: 'The Plan has been saved successfully.',
                      className: 'text-success',
                      callback: function () {
                          window.location.reload();
                      }
                  });
              }

          });
      }
   });
});