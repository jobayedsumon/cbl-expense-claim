$(document).ready(function () {

    function calculateGrandTotal() {
        var grandTotal = 0;
        var grandTotalBDT = 0;
        $('#advanceDetailsTable tbody tr').each(function () {
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

    $('#advanceInformationModalForm').on('submit', function (e) {
        e.preventDefault();

        var data = new FormData(this);

        $.ajax({
            url: 'excs/advance_information_store',
            type: 'POST',
            processData: false,
            contentType: false,
            data: data,
            error: function(xhr, status, error) {
                console.log('xhr: ');
                console.log(xhr);
                console.log('status: ' + status);
                console.log('error: ' + error);
            },
            success: function(response) {

                var advanceInfo = JSON.parse(response);

                advanceInfo = removeNullFromObject(advanceInfo.data.details)

                var expenseDate = new Date(advanceInfo.expense_date);

                var dateString = ISODateString(expenseDate);

                var lastSerial = $('#advanceDetailsTable tbody tr').length;
                lastSerial++;

                var lineTotalBDT = '<td class="text-right lineTotalBDT">'+parseFloat(advanceInfo.line_total_bdt).toFixed(2)+'</td>';

                if ($('#currency').val() === 'BDT') {
                    lineTotalBDT = '<td class="text-right lineTotalBDT bdtInfo">'+parseFloat(advanceInfo.line_total_bdt).toFixed(2)+'</td>';
                }

                var newRow = '<tr>\
                            <td class="tableSerial">'+lastSerial+'</td>\
                            <td class="tableExpenseDate">'+dateString+'</td>\
                            <td class="tablePurposeTitle">'+advanceInfo.product_name+'</td>\
                            <td class="tableProjectName">'+advanceInfo.project_name +'</td>\
                            <td class="text-right tableRate">'+parseFloat(advanceInfo.rate).toFixed(2)+'</td>\
                            <td class="text-right tableQuantity">'+advanceInfo.qty+'</td>\
                            <td class="text-right lineTotal">'+parseFloat(advanceInfo.line_total).toFixed(2)+lineTotalBDT+'</td>\
                            <td class="text-center">\
                            <a data-id="'+advanceInfo.exc_claim_details_id+'" data-serial="'+lastSerial+'" data-purpose-details="'+advanceInfo.product_details+'" class="fa fa-edit text-success editAdvanceDetail"></a>\
                            <a data-id="'+advanceInfo.exc_claim_details_id+'" class="fa fa-times text-danger deleteAdvanceDetail"></a>\
                            </td></tr>';


                $('#advanceDetailsTable tbody:last').append(newRow);
                $('#exchangeRate').prop('readonly', true);

                calculateGrandTotal();

                $('#advanceClaimModal').modal('hide');

            }

        });


    });

    $(document).on('click', '.editAdvanceDetail', function () {
        var row = $(this).closest('tr');
        var tableSerial = row.find('.tableSerial').text();
        var tableExpenseDate = row.find('.tableExpenseDate').text();
        var tablePurposeTitle = row.find('.tablePurposeTitle').text();
        var tablePurposeDetails = row.find('.tablePurposeDetails').text();
        var tableProjectName = row.find('.tableProjectName').text();
        var tableRate = row.find('.tableRate').text();
        var tableQuantity = row.find('.tableQuantity').text();
        var lineTotal = row.find('.lineTotal').text();
        var lineTotalBDT = row.find('.lineTotalBDT').text();


        $('#editPurposeDetails').val($(this).data('purpose-details'));
        $('#editClaimDetailsID').val($(this).data('id'));
        $('#editSerial').val($(this).data('serial'));
        $('#editExpenseDate').datepicker("setDate", new Date(tableExpenseDate));
        $('#editQuantity').val(tableQuantity);
        $('#editRate').val(tableRate);
        $('#editTotalAmount').val(lineTotal);
        $('#editTotalAmountBDT').val(lineTotalBDT);


        $('#editPurpose option').filter(function() {
            return this.text === tablePurposeTitle;
        }).prop('selected', true);

        $('#editProject option').filter(function() {
            return this.text === tableProjectName;
        }).prop('selected', true);

        $('#editPurpose').select2().trigger('change');
        $('#editProject').select2().trigger('change');

        $('#editAdvanceClaimModal').modal('show');
    });

    $('#editAdvanceInformationModalForm').on('submit', function (e) {
        e.preventDefault();

        var id = $('#editClaimDetailsID').val();
        var serial = $('#editSerial').val();

        var data = new FormData(this);

        var object = {};
        data.forEach(function(value, key){
            object[key] = value;
        });
        var jsonData = JSON.stringify(object);

        $.ajax({
            url: EXCS_URL+'/excs/claim_details/'+id,
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

                var advanceInfo = removeNullFromObject(response.data.row)

                var expenseDate = new Date(advanceInfo.expense_date);

                var dateString = ISODateString(expenseDate);

                var lineTotalBDT = '<td class="text-right lineTotalBDT">'+parseFloat(advanceInfo.line_total_bdt).toFixed(2)+'</td>';

                if ($('#currency').val() === 'BDT') {
                    lineTotalBDT = '<td class="text-right lineTotalBDT bdtInfo">'+advanceInfo.line_total_bdt+'</td>';
                }

                var serial = $('#advanceDetailsTable tbody').find('tr').eq(serial-1).children('td:first').text();


                var newRow = '<tr>\
                            <td class="tableSerial">'+serial+'</td>\
                            <td class="tableExpenseDate">'+dateString+'</td>\
                            <td class="tablePurposeTitle">'+advanceInfo.product_name+'</td>\
                            <td class="tableProjectName">'+advanceInfo.project_name +'</td>\
                            <td class="text-right tableRate">'+parseFloat(advanceInfo.rate).toFixed(2)+'</td>\
                            <td class="text-right tableQuantity">'+advanceInfo.qty+'</td>\
                            <td class="text-right lineTotal">'+parseFloat(advanceInfo.line_total).toFixed(2)+lineTotalBDT+'</td>\
                            <td class="text-center">\
                            <a data-id="'+advanceInfo.exc_claim_details_id+'" data-purpose-details="'+advanceInfo.purpose_details+'" class="fa fa-edit text-success editAdvanceDetail"></a>\
                            <a data-id="'+advanceInfo.exc_claim_details_id+'" class="fa fa-times text-danger deleteAdvanceDetail"></a>\
                            </td></tr>';

                $('#advanceDetailsTable tbody').find('tr').eq(serial-1).replaceWith(newRow);


                // $('#advanceDetailsTable tbody:last').append(newRow);

                calculateGrandTotal();

                $('#editAdvanceClaimModal').modal('hide');

            }

        });


    });

    $(document).on('click', '.deleteAdvanceDetail', function () {
        let advanceDetail = $(this);
        let claimDetailId = advanceDetail.data('id');

        $.ajax({
            url: EXCS_URL+'/excs/claim_details/'+claimDetailId,
            type: 'DELETE',
            processData: false,
            contentType: false,
            error: function(xhr, status, error) {
                console.log('xhr: ');
                console.log(xhr);
                console.log('status: ' + status);
                console.log('error: ' + error);
            },
            success: function(response) {

                advanceDetail.closest('tr').remove();
                if ($('#advanceDetailsTable tbody tr').length > 0) {
                    $('#currency').attr('disabled', true);
                    $('#exchangeRate').attr('disabled', true);
                } else {
                    $('#currency').attr('disabled', false);
                    $('#exchangeRate').attr('disabled', false);
                }

                calculateGrandTotal();


            }

        });

    });

    $('#advanceClaimModal').on('hidden.bs.modal', function(event) {
        $(this)
            .find("input[type=text],textarea")
            .val('')
            .end()
            .find("input[type=number]")
            .val(1)
            .end()
            .find('select')
            .val(null)
            .trigger('change')
            .end();
    });

});