if ($('#currency').val() !== 'BDT') {
    $('.bdtInfo').show();
}

function calculateGrandTotal() {
    var grandTotal = 0;
    var grandTotalBDT = 0;
    $('#travelCostComponentTable tbody tr').each(function () {
        $(this).find('.lineTotal').each(function () {
            var lineTotal = $(this).text();
            if (!isNaN(lineTotal) && lineTotal.length !== 0) {
                grandTotal += parseFloat(lineTotal);
            }
        });
        $(this).find('.lineTotalBDT').each(function () {
            var lineTotalBDT = $(this).text();
            if (!isNaN(lineTotalBDT) && lineTotalBDT.length !== 0) {
                grandTotalBDT += parseFloat(lineTotalBDT);
            }
        });
    });

    $('.grandTotal').text(grandTotal.toFixed(2));
    $('.grandTotalBDT').text(grandTotalBDT.toFixed(2));
}

calculateGrandTotal();

$(document).ready(function () {

    $('#projectedAmount').on('keyup', function () {
      var projectedAmountBDT = $('#exchangeRate').val() * $('#projectedAmount').val();
      $('#projectedAmountBDT').val(projectedAmountBDT.toFixed(2));
    });

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
          var countryLength = $('#countryToVisited').val().length;
          $.each($('#countryToVisited').val(), function (index, value) {
              countryToVisited += value;
              if (index !== countryLength-1) {
                  countryToVisited += ',';
              }
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
                          window.location.href = url;
                      }
                  });
              }

          });
      }
   });

   $('#travelPassengerModalForm').on('submit', function (e) {
       e.preventDefault();

       var data = new FormData(this);
       var object = {};
       data.forEach(function (value, key) {
           object[key] = value;
       });
       var jsonData = JSON.stringify(object);

       $.ajax({
           url: EXCS_URL+'/excs/travel_passengers',
           type: 'POST',
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
               var passenger = removeNullFromObject(response.data.passenger);
               var passengerType = '';
               if (passenger.passenger_type === 'ADT') {
                   passengerType = 'Adult';
               } else if (passenger.passenger_type === 'CHD') {
                   passengerType = 'Child';
               } else if (passenger.passenger_type === 'INF') {
                   passengerType = 'Infant';
               }
               var serial = $('#travelPassengersTable tbody').find('tr').length;
               var newRow = '<tr>\n' +
                   '<td class="tableSerial">'+serial+'</td>\n' +
                   '<td>'+passenger.passenger_name+'</td>\n' +
                   '<td>'+passengerType+'</td>\n' +
                   '<td>'+ISODateString(new Date(passenger.dob))+'</td>\n' +
                   '<td>'+passenger.passport_no+'</td>\n' +
                   '<td>'+ISODateString(new Date(passenger.passport_exp_date))+'</td>\n' +
                   '<td class="text-center">\n' +
                   '<a data-id="'+passenger.exc_travel_passengers_id+'" class="editPassenger fa fa-edit text-success"></a>\n' +
                   '<a data-id="'+passenger.exc_travel_passengers_id+'" class="deletePassenger fa fa-times text-danger"></a>\n' +
                   '</td>\n' +
                   '</tr>';
               $('#travelPassengersTable tbody:last').append(newRow);

                   $('#travelPassengerModalForm').trigger('reset');

           }

       });

   });

    $('#editTravelPassengerModalForm').on('submit', function (e) {
        e.preventDefault();
        var id = $('#passengerDetailsId').val();

        var data = new FormData(this);
        var object = {};
        data.forEach(function (value, key) {
            object[key] = value;
        });
        var jsonData = JSON.stringify(object);

        $.ajax({
            url: EXCS_URL+'/excs/travel_passengers/'+id,
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
                var passenger = removeNullFromObject(response.data.passenger);
                var passengerType = '';
                if (passenger.passenger_type === 'ADT') {
                    passengerType = 'Adult';
                } else if (passenger.passenger_type === 'CHD') {
                    passengerType = 'Child';
                } else if (passenger.passenger_type === 'INF') {
                    passengerType = 'Infant';
                }
                var serial = $('#passengerDetailsId').data('row').find('td').eq(0).text();
                var newRow = '<tr>\n' +
                    '<td class="tableSerial">'+serial+'</td>\n' +
                    '<td>'+passenger.passenger_name+'</td>\n' +
                    '<td>'+passengerType+'</td>\n' +
                    '<td>'+ISODateString(new Date(passenger.dob))+'</td>\n' +
                    '<td>'+passenger.passport_no+'</td>\n' +
                    '<td>'+ISODateString(new Date(passenger.passport_exp_date))+'</td>\n' +
                    '<td class="text-center">\n' +
                    '<a data-id="'+passenger.exc_travel_passengers_id+'" class="editPassenger fa fa-edit text-success"></a>\n' +
                    '<a data-id="'+passenger.exc_travel_passengers_id+'" class="deletePassenger fa fa-times text-danger"></a>\n' +
                    '</td>\n' +
                    '</tr>';
                $('#passengerDetailsId').data('row').replaceWith(newRow);
                $('#editTravelPassengerModal').modal('hide');
            }

        });

    });

   $(document).on('click', '.editPassenger', function () {
      var id = $(this).data('id');
      var row = $(this).closest('tr');
       $.ajax({
           url: EXCS_URL+'/excs/travel_passengers/'+id+'/edit',
           type: 'GET',
           error: function(xhr, status, error) {
               console.log('xhr: ');
               console.log(xhr);
               console.log('status: ' + status);
               console.log('error: ' + error);
           },
           success: function(response) {
               var passenger = removeNullFromObject(response.data.passenger);
                $('.passengerName').val(passenger.passenger_name);
                $('.passportNo').val(passenger.passport_no);
                $('.dateOfBarth').datepicker('setDate', new Date(passenger.dob));
                $('.passportExpDate').datepicker('setDate', new Date(passenger.passport_exp_date));
                $('.passengerType').select2('val', passenger.passenger_type);
                $('#passengerDetailsId').val(id);
                $('#passengerDetailsId').data('row', row);

                $('#editTravelPassengerModal').modal('show');
           }

       });

   });

   $(document).on('click', '.deletePassenger', function () {
      var id = $(this).data('id');
      var row = $(this).closest('tr');
       $.ajax({
           url: EXCS_URL+'/excs/travel_passengers/'+id,
           type: 'DELETE',
           error: function(xhr, status, error) {
               console.log('xhr: ');
               console.log(xhr);
               console.log('status: ' + status);
               console.log('error: ' + error);
           },
           success: function(response) {
               row.remove();
           }

       });

   });

    $('#travelCcAllocationModalForm').on('submit', function (e) {
        e.preventDefault();
        var data = new FormData(this);

        var object = {};
        data.forEach(function(value, key){
            object[key] = value;
        });
        var jsonData = JSON.stringify(object);

        $.ajax({
            url: EXCS_URL+'/excs/travel_plans/tp_cc_allocations',
            type: 'POST',
            processData: false,
            contentType: false,
            cache: false,
            data: jsonData,
            error: function(error) {
                console.log(error)
            },
            success: function(response) {
                var cca = removeNullFromObject(response.data.row);
                var serial = $('#travelCcAllocationTable tbody').find('tr').length + 1;
                var newRow = '<tr>\n' +
                    '<td class="tableSerial">'+serial+'</td>\n' +
                    '<td>'+cca.sol_name+'</td>\n' +
                    '<td>'+cca.cost_center_name+'</td>\n' +
                    '<td class="text-right">'+parseFloat(cca.allocation_ratio).toFixed(2)+'</td>\n' +
                    '<td class="text-right">'+parseFloat(cca.budget_allocated).toFixed(2)+'</td>\n' +
                    '<td class="text-right">'+(parseFloat(cca.actual)+parseFloat(cca.in_transit)).toFixed(2)+'</td>\n' +
                    '<td class="text-right">'+parseFloat(cca.allocation_amount).toFixed(2)+'</td>\n' +
                    '<td class="text-center">\n' +
                    '<a data-id="'+cca.exc_tp_cc_allocations_id+'" class="fa fa-edit text-success editCcAllocation"></a>\n' +
                    '<a data-id="'+cca.exc_tp_cc_allocations_id+'" class="fa fa-times text-danger deleteCcAllocation"></a>\n' +
                    '</td>\n' +
                    '</tr>';

                $('#travelCcAllocationTable tbody:last').append(newRow);
                $('#travelCcAllocationModalForm').trigger('reset').find('select').trigger('change');
                $('.allocationAmount').val($('#projectedAmountBDT').val());

            }
        });
    });

    $('#editTravelCcAllocationModalForm').on('submit', function (e) {
        e.preventDefault();
        var data = new FormData(this);

        var object = {};
        data.forEach(function(value, key){
            object[key] = value;
        });
        var jsonData = JSON.stringify(object);

        $.ajax({
            url: EXCS_URL+'/excs/travel_plans/tp_cc_allocations/'+$('#ccAllocationId').val(),
            type: 'PUT',
            processData: false,
            contentType: false,
            cache: false,
            data: jsonData,
            error: function(error) {
                console.log(error)
            },
            success: function(response) {
                var cca = removeNullFromObject(response.data.row);
                var serial = $('#ccAllocationId').data('row').find('td').eq(0).text();
                var newRow = '<tr>\n' +
                    '<td class="tableSerial">'+serial+'</td>\n' +
                    '<td>'+cca.sol_name+'</td>\n' +
                    '<td>'+cca.cost_center_name+'</td>\n' +
                    '<td class="text-right">'+parseFloat(cca.allocation_ratio).toFixed(2)+'</td>\n' +
                    '<td class="text-right">'+parseFloat(cca.budget_allocated).toFixed(2)+'</td>\n' +
                    '<td class="text-right">'+(parseFloat(cca.actual)+parseFloat(cca.in_transit)).toFixed(2)+'</td>\n' +
                    '<td class="text-right">'+parseFloat(cca.allocation_amount).toFixed(2)+'</td>\n' +
                    '<td class="text-center">\n' +
                    '<a data-id="'+cca.exc_tp_cc_allocations_id+'" class="fa fa-edit text-success editCcAllocation"></a>\n' +
                    '<a data-id="'+cca.exc_tp_cc_allocations_id+'" class="fa fa-times text-danger deleteCcAllocation"></a>\n' +
                    '</td>\n' +
                    '</tr>';

                $('#ccAllocationId').data('row').replaceWith(newRow);

                $('#editTravelCcAllocationModal').modal('hide');
            }

        });
    });

    $(document).on('click', '.editCcAllocation', function () {
        var id = $(this).data('id');
        var row = $(this).closest('tr');
        $.ajax({
            url: EXCS_URL+'/excs/travel_plans/tp_cc_allocations/'+id+'/edit',
            type: 'GET',
            error: function(xhr, status, error) {
                console.log('xhr: ');
                console.log(xhr);
                console.log('status: ' + status);
                console.log('error: ' + error);
            },
            success: function(response) {
                var cca = removeNullFromObject(response.data.row);
                $('.allocationRatio').val(parseFloat(cca.allocation_ratio).toFixed(2));
                $('.allocationAmount').val(parseFloat(cca.allocation_amount).toFixed(2));
                $('.costCenter').select2('val', cca.cost_center_code);
                $('.sol').select2('val', cca.sol_code);
                $('#ccAllocationId').val(id);
                $('#ccAllocationId').data('row', row);
                $('#editTravelCcAllocationModal').modal('show');
            }

        });

    });

    $(document).on('click', '.deleteCcAllocation', function () {
        var id = $(this).data('id');
        var row = $(this).closest('tr');
        $.ajax({
            url: EXCS_URL+'/excs/travel_plans/tp_cc_allocations/'+id,
            type: 'DELETE',
            error: function(xhr, status, error) {
                console.log('xhr: ');
                console.log(xhr);
                console.log('status: ' + status);
                console.log('error: ' + error);
            },
            success: function(response) {
                row.remove();
            }

        });

    });

    $('.allocationRatio').on('keyup', function () {
        var ratio = $(this).val();
        var totalTravelAmount = $('#projectedAmountBDT').val();
        var allocationAmount = (totalTravelAmount * ratio) / 100;
        $('.allocationAmount').val(allocationAmount.toFixed(2));
    });

    $('.allocationAmount').on('keyup', function () {
        var allocationAmount = $(this).val();
        var totalTravelAmount = $('#projectedAmountBDT').val();
        var ratio = (allocationAmount * 100) / totalTravelAmount;
        $('.allocationRatio').val(ratio.toFixed(2));
    });

    $('#travelCcAllocationModal').on('show.bs.modal', function () {
        $('#travelCcAllocationModalForm').trigger('reset').find('select').trigger('change');
        $('.allocationAmount').val($('#projectedAmountBDT').val());
    });

    $('#travelCostComponentModalForm').on('submit', function (e) {
        e.preventDefault();
        var data = new FormData(this);

        var object = {};
        data.forEach(function(value, key){
            object[key] = value;
        });
        var jsonData = JSON.stringify(object);

        $.ajax({
            url: EXCS_URL+'/excs/travel_details',
            type: 'POST',
            processData: false,
            contentType: false,
            cache: false,
            data: jsonData,
            error: function(error) {
                console.log(error)
            },
            success: function(response) {
                var details = removeNullFromObject(response.data.details);
                var serial = $('#travelCostComponentTable tbody').find('tr').length + 1;
                var newRow = '<tr>\n' +
                    '<td class="tableSerial">'+serial+'</td>\n' +
                    '<td>'+ISODateString(new Date(details.expense_date))+'</td>\n' +
                    '<td>'+details.product_name+'</td>\n' +
                    '<td>'+details.project_name+'</td>\n' +
                    '<td class="text-right">'+parseFloat(details.rate).toFixed(2)+'</td>\n' +
                    '<td class="text-right">'+details.qty+'</td>\n' +
                    '<td class="text-right lineTotal">'+parseFloat(details.line_total).toFixed(2)+'</td>\n' +
                    '<td class="text-right lineTotalBDT">'+parseFloat(details.line_total_bdt).toFixed(2)+'</td>\n' +
                    '<td class="text-center">\n' +
                    '<a data-id="'+details.exc_travel_details_id+'" class="fa fa-edit text-success editCostComponent"></a>\n' +
                    '<a data-id="'+details.exc_travel_details_id+'" class="fa fa-times text-danger deleteCostComponent"></a>\n' +
                    '</td>\n' +
                    '</tr>';

                $('#travelCostComponentTable tbody:last').append(newRow);
                $('#travelCostComponentModalForm').trigger('reset').find('select').trigger('change');
                calculateGrandTotal();
            }
        });
    });

    $(document).on('click', '.deleteCostComponent', function () {
        var id = $(this).data('id');
        var row = $(this).closest('tr');
        $.ajax({
            url: EXCS_URL+'/excs/travel_details/'+id,
            type: 'DELETE',
            error: function(xhr, status, error) {
                console.log('xhr: ');
                console.log(xhr);
                console.log('status: ' + status);
                console.log('error: ' + error);
            },
            success: function(response) {
                row.remove();
                calculateGrandTotal();
            }

        });

    });

    $(document).on('click', '.editCostComponent', function () {
        var id = $(this).data('id');
        var row = $(this).closest('tr');
        $.ajax({
            url: EXCS_URL+'/excs/travel_details/'+id+'/edit',
            type: 'GET',
            error: function(xhr, status, error) {
                console.log('xhr: ');
                console.log(xhr);
                console.log('status: ' + status);
                console.log('error: ' + error);
            },
            success: function(response) {
                var costComponent = removeNullFromObject(response.data.row);
                $("#expenseDate").datepicker("setDate", new Date(costComponent.expense_date));
                $('#project').select2('val', costComponent.project_id);
                $('#purpose').select2('val', costComponent.product_id);
                $('#purposeDetails').select2('val', costComponent.product_details);
                $('#quantity').val(parseFloat(costComponent.qty).toFixed(2));
                $('#rate').val(parseFloat(costComponent.rate).toFixed(2));
                $('#editTotalAmount').val(parseFloat(costComponent.line_total).toFixed(2));
                $('#editTotalAmountBDT').val(parseFloat(costComponent.line_total_bdt).toFixed(2));
                $('#costComponentId').val(id);
                $('#costComponentId').data('row', row);
                $('#editTravelCostComponentModal').modal('show');
            }

        });

    });

    $('#editTravelCostComponentModalForm').on('submit', function (e) {
        e.preventDefault();
        var data = new FormData(this);
        var id = $('#costComponentId').val();
        var object = {};
        data.forEach(function(value, key){
            object[key] = value;
        });
        var jsonData = JSON.stringify(object);

        $.ajax({
            url: EXCS_URL+'/excs/travel_details/'+id,
            type: 'PUT',
            processData: false,
            contentType: false,
            cache: false,
            data: jsonData,
            error: function(error) {
                console.log(error)
            },
            success: function(response) {
                var details = removeNullFromObject(response.data.row);
                var serial = $('#costComponentId').data('row').find('td').eq(0).text();
                var newRow = '<tr>\n' +
                    '<td class="tableSerial">'+serial+'</td>\n' +
                    '<td>'+ISODateString(new Date(details.expense_date))+'</td>\n' +
                    '<td>'+details.product_name+'</td>\n' +
                    '<td>'+details.project_name+'</td>\n' +
                    '<td class="text-right">'+parseFloat(details.rate).toFixed(2)+'</td>\n' +
                    '<td class="text-right">'+details.qty+'</td>\n' +
                    '<td class="text-right lineTotal">'+parseFloat(details.line_total).toFixed(2)+'</td>\n' +
                    '<td class="text-right lineTotalBDT">'+parseFloat(details.line_total_bdt).toFixed(2)+'</td>\n' +
                    '<td class="text-center">\n' +
                    '<a data-id="'+details.exc_travel_details_id+'" class="fa fa-edit text-success editCostComponent"></a>\n' +
                    '<a data-id="'+details.exc_travel_details_id+'" class="fa fa-times text-danger deleteCostComponent"></a>\n' +
                    '</td>\n' +
                    '</tr>';

                $('#costComponentId').data('row').replaceWith(newRow);
                calculateGrandTotal();
                $('#editTravelCostComponentModal').modal('hide');
            }
        });
    });

});