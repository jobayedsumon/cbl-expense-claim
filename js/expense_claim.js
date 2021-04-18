$(document).ready(function () {

    function calculateGrandTotal() {
        var grandTotal = 0;
        var grandTotalBDT = 0;
        $('#expenseDetailsTable tbody tr').each(function () {
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
    function calculateTotalAdjustmentAmount() {
        var totalAdjustmentAmount = 0;
        $('#advanceAdjustmentTable tbody tr').each(function () {
            $(this).find('.tableAdjustAmount').each(function () {
                var tableAdjustAmount = $(this).text();
                if (!isNaN(tableAdjustAmount) && tableAdjustAmount.length !== 0) {
                    totalAdjustmentAmount += parseFloat(tableAdjustAmount);
                }
            });
        });

        $('.totalAdjustmentAmount').text(totalAdjustmentAmount.toFixed(2));
    }

    calculateGrandTotal();
    calculateTotalAdjustmentAmount();

    $('#expenseClaimModal').on('show.bs.modal', function (e) {
        let selectedCurrency = $('select[name="currency"]').val();
        $('#modalCurrency').text(selectedCurrency);
    });

    $('#expenseClaimModalForm').on('submit', function (e) {
        e.preventDefault();

        let data = new FormData(this);

        $.ajax({
            url: 'excs/expense_information_store',
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

                var expenseInfo = JSON.parse(response);
                expenseInfo = removeNullFromObject(expenseInfo.data.details);

                var expenseDate = new Date(expenseInfo.expense_date)

                var dateString = ISODateString(expenseDate);

                var serial = $('#expenseDetailsTable tbody tr.tableLineItem').length;
                serial++;

                var lineTotalBDT = '<td class="text-right lineTotalBDT">'+parseFloat(expenseInfo.line_total_bdt).toFixed(2)+'</td>';

                if ($('#currency').val() === 'BDT') {
                    lineTotalBDT = '<td class="text-right lineTotalBDT bdtInfo">'+parseFloat(expenseInfo.line_total_bdt).toFixed(2)+'</td>';
                }

                var newRow = '<tr id="tableLineItemID'+serial+'" class="tableLineItem">\
                            <td class="tableSerial">'+'<a data-toggle="collapse" data-target="#lineItem'+serial+'" class="accordion-toggle">\
                        <i class="more-less glyphicon glyphicon-plus"></i> '+serial+'</td>\
                            <td class="tableExpenseDate">'+dateString+'</td>\
                            <td class="tablePurposeTitle">'+expenseInfo.product_name+'</td>\
                            <td class="tableProjectName">'+expenseInfo.project_name +'</td>\
                            <td class="text-right tableRate">'+parseFloat(expenseInfo.rate).toFixed(2)+'</td>\
                            <td class="text-right tableQuantity">'+expenseInfo.qty+'</td>\
                            <td class="text-right lineTotal">'+parseFloat(expenseInfo.line_total).toFixed(2)+lineTotalBDT+'</td>\
                            <td class="text-center">\
                            <a data-id="'+expenseInfo.exc_claim_details_id+'"data-line-item="'+serial+'" data-total-amount="'+expenseInfo.line_total_bdt+'" class="btn customBtn ccButton">CC</a>\
                            <a data-id="'+expenseInfo.exc_claim_details_id+'"data-serial="'+serial+'" data-purpose-details="'+expenseInfo.product_details+'" class="fa fa-edit text-success editExpense"></a>\
                            <a data-id="'+expenseInfo.exc_claim_details_id+'" class="fa fa-times text-danger deleteExpense"></a>\
                            </td></tr>';

                var nestedRow = '<tr><td colspan="9" class="hiddenRow"><div class="secondaryTable accordian-body collapse" id="lineItem'+serial+'">\
                        <table id="ccAllocationNestedTable'+serial+'" class="table table-bordered table-condensed table-hover table-striped"><thead><tr>\
                        <th>SL</th><th>SOL</th><th>CC</th><th>Ratio(%)</th><th>Budget Allocated</th><th>Budget Utilized</th><th>Budget Request</th><th>Action</th>\
                </tr></thead><tbody></tbody></table></div></td></tr>';


                $('#expenseDetailsTable tbody:first').append(newRow+nestedRow);
                $('#exchangeRate').prop('readonly', true);

                calculateGrandTotal();

                $('#expenseClaimModal').modal('hide');

            }

        });

    });

    $(document).on('click', '.deleteExpense', function () {
        var row = $(this).closest('tr');
        var expenseId = $(this).data('id');

        $.ajax({
            url: EXCS_URL+'/excs/claim_details/'+expenseId,
            type: 'DELETE',
            error: function(xhr, status, error) {
                console.log('xhr: ');
                console.log(xhr);
                console.log('status: ' + status);
                console.log('error: ' + error);
            },
            success: function (response) {
                row.remove();
            }

        });
    });

    $('#advanceAdjustmentForm').on('submit', function (e) {
        e.preventDefault();
        let data = new FormData(this);

        var object = {};
        data.forEach(function(value, key){
            object[key] = value;
        });
        var jsonData = JSON.stringify(object);

        $.ajax({
            url: EXCS_URL+'/excs/advance_adjustments',
            type: 'POST',
            processData: false,
            contentType: false,
            cache: false,
            data: jsonData,
            error: function(error) {
                console.log(error)
            },
            success: function(response) {
                console.log(response);

                const adjustment = removeNullFromObject(response.data.row);

                let lastSerial = $('#advanceAdjustmentTable tbody tr').length;
                lastSerial++;

                var remainingAmount = adjustment.advance_amount - adjustment.adjusted_amount;

                let newRow = "<tr>" +
                    "<td class='tableSerial'>" + lastSerial + "</td>" +
                    "<td class='tableClaimCode'>" + adjustment.claim_code + "</td>" +
                    "<td class='text-right tableAdvanceAmount'>" + parseFloat(adjustment.advance_amount).toFixed(2) + "</td>" +
                    "<td class='text-right tableAdjustedAmount'>" + parseFloat(adjustment.adjusted_amount).toFixed(2) + "</td>" +
                    "<td class='text-right tableAdjustAmount'>" + parseFloat(adjustment.adjust_amount).toFixed(2) + "</td>" +
                    "<td class='text-right tableRemainingAmount'>" + parseFloat(remainingAmount).toFixed(2) + "</td>" +
                    "<td class='tableRemarks'>" + adjustment.remarks + "</td>" +
                    "<td class='text-center'><a data-id='"+adjustment.exc_advance_adjustments_id+"' class='editAdjustment fa fa-edit text-success'></a>" +
                    "<a data-id='"+adjustment.exc_advance_adjustments_id+"' class='deleteAdjustment fa fa-times text-danger'></a></td>" +
                    "</tr>";

                $('#advanceAdjustmentTable tbody:last').append(newRow);

                calculateTotalAdjustmentAmount();

                $('#advanceReferenceModal').modal('hide');
            }

        });

    });

    $('#editAdvanceAdjustmentForm').on('submit', function (e) {
        e.preventDefault();
        let data = new FormData(this);
        var id = $('#editAdvanceAdjustmentID').val();
        var serial = $('#editAdjustmentSerial').val();

        var object = {};
        data.forEach(function(value, key){
            object[key] = value;
        });
        var jsonData = JSON.stringify(object);

        $.ajax({
            url: EXCS_URL+'/excs/advance_adjustments/'+id,
            type: 'PUT',
            processData: false,
            contentType: false,
            cache: false,
            data: jsonData,
            error: function(error) {
                console.log(error)
            },
            success: function(response) {

                const adjustment = removeNullFromObject(response.data.row);

                var remainingAmount = adjustment.advance_amount - adjustment.adjusted_amount;

                let newRow = "<tr>" +
                    "<td class='tableSerial'>" + serial + "</td>" +
                    "<td class='tableClaimCode'>" + adjustment.claim_code + "</td>" +
                    "<td class='text-right tableAdvanceAmount'>" + parseFloat(adjustment.advance_amount).toFixed(2) + "</td>" +
                    "<td class='text-right tableAdjustedAmount'>" + parseFloat(adjustment.adjusted_amount).toFixed(2) + "</td>" +
                    "<td class='text-right tableAdjustAmount'>" + parseFloat(adjustment.adjust_amount).toFixed(2) + "</td>" +
                    "<td class='text-right tableRemainingAmount'>" + parseFloat(remainingAmount).toFixed(2) + "</td>" +
                    "<td class='tableRemarks'>" + adjustment.remarks + "</td>" +
                    "<td><a data-id='"+adjustment.exc_advance_adjustments_id+"' class='editAdjustment fa fa-edit text-success'></a>" +
                    "<a data-id='"+adjustment.exc_advance_adjustments_id+"' class='deleteAdjustment fa fa-times text-danger'></a></td>" +
                    "</tr>";

                $('#advanceAdjustmentTable tbody').find('tr').eq(serial-1).replaceWith(newRow);

                calculateTotalAdjustmentAmount();

                $('#editAdvanceReferenceModal').modal('hide');
            }

        });

    });

    $(document).on('click', '.deleteAdjustment', function () {
        var id = $(this).data('id');
        var row = $(this).closest('tr');
        $.ajax({
            url: EXCS_URL+'/excs/advance_adjustments/'+id,
            type: 'DELETE',
            error: function(xhr, status, error) {
                console.log('xhr: ');
                console.log(xhr);
                console.log('status: ' + status);
                console.log('error: ' + error);
            },
            success: function (response) {
                row.remove();
                calculateTotalAdjustmentAmount();
            }

        });

    });

    $(document).on('click', '.editAdjustment', function () {
        var adjustmentID = $(this).data('id');
        var row = $(this).closest('tr');
        var tableSerial = row.find('.tableSerial').text();
        var tableClaimCode = row.find('.tableClaimCode').text();
        var tableAdvanceAmount = row.find('.tableAdvanceAmount').text();
        var tableAdjustedAmount = row.find('.tableAdjustedAmount').text();
        var tableAdjustAmount = row.find('.tableAdjustAmount').text();
        var tableRemarks = row.find('.tableRemarks').text();

        $('#editAdvanceAdjustmentID').val(adjustmentID);
        $('#editAdjustmentSerial').val(tableSerial);
        $('#editAdvanceReferenceID').text(tableClaimCode);
        $('#editAdvancePaidAmount').val(tableAdvanceAmount);
        $('#editAdjustedAmount').val(tableAdjustedAmount);
        $('#editWantToAdjust').val(tableAdjustAmount);
        $('#editAdvanceRefRemarks').val(tableRemarks);

        $('#editAdvanceRefNo option').filter(function() {
            return this.text === tableClaimCode;
        }).prop('selected', true);

        $('#editAdvanceRefNo').select2().trigger('change');

        $('#editAdvanceReferenceModal').modal('show');

    });

    $(document).on('click', '.ccButton', function (e) {
        $('#claimDetailsID').val($(this).data('id'));
        $('#ccLineItemInput').val($(this).data('line-item'));
        $('#totalClaimAmount').val($(this).data('total-amount'));
        $('.allocationAmount').val($(this).data('total-amount'));
        $('#costCenterModal').modal('show');
    });

    $('#costCenterModalForm').on('submit', function (e) {
        e.preventDefault();
        var data = new FormData(this);
        data.append('EXC_CLAIM_REQUESTS_ID', $('input[name="EXC_CLAIM_REQUESTS_ID"]').val());
        data.append('CREATED_BY', $('input[name="CREATED_BY"]').val());
        data.append('CLAIM_DATE', $('input[name="CLAIM_DATE"]').val());

        var object = {};
        data.forEach(function(value, key){
            object[key] = value;
        });
        var jsonData = JSON.stringify(object);

        $.ajax({
            url: EXCS_URL+'/excs/claims/cc_allocations',
            type: 'POST',
            processData: false,
            contentType: false,
            cache: false,
            data: jsonData,
            error: function(error) {
                console.log(error)
            },
            success: function(response) {
                const newData = removeNullFromObject(response.data.row);
                var newRow = '<tr>' +
                    '<td>'+newData.cost_center_name+'</td> ' +
                    '<td>'+newData.sol_name+'</td> ' +
                    '<td class="text-right">'+newData.allocation_ratio+'</td> ' +
                    '<td class="text-right">'+newData.allocation_amount+'</td> ' +
                    '<td class="text-right">'+newData.budget_allocated+'</td> ' +
                    '<td class="text-right">'+newData.budget_utilized+'</td> ' +
                    '</tr>';

                $('#allocationTable tbody:last').append(newRow);

                var lineItem = $('#ccLineItemInput').val();
                var totalAmount = $('#totalClaimAmount').val();
                var tableID = '#ccAllocationNestedTable'+lineItem;

                let lastSerial = $(tableID+' tbody tr').length;
                lastSerial++;
                var nestedRow = '<tr>' +
                    '<td>'+lastSerial+'</td> ' +
                    '<td>'+newData.sol_name+'</td> ' +
                    '<td>'+newData.cost_center_name+'</td> ' +
                    '<td class="text-right">'+parseFloat(newData.allocation_ratio).toFixed(2)+'</td> ' +
                    '<td class="text-right">'+parseFloat(newData.budget_allocated).toFixed(2)+'</td> ' +
                    '<td class="text-right">'+parseFloat(newData.actual+newData.in_transit).toFixed(2)+'</td> ' +
                    '<td class="text-right">'+parseFloat(newData.allocation_amount).toFixed(2)+'</td> ' +
                    '<td class="text-center">' +
                    '<a data-id="'+newData.exc_cc_allocations_id+'" data-details-id="'+newData.exc_claim_details_id+'" ' +
                    'data-line-item="'+lineItem+'" data-serial="'+lastSerial+'" data-total-amount="'+totalAmount+'" class="fa fa-edit text-success editCostCenter"></a>' +
                    '<a data-id="'+newData.exc_cc_allocations_id+'" class="fa fa-times text-danger deleteCostCenter"></a>' +
                    '</td> ' +
                    '</tr>';

                $(tableID+' tbody:last').append(nestedRow);

            }

        });
    });

    $('#editCostCenterModalForm').on('submit', function (e) {
        var id = $('#ccId').val();
        e.preventDefault();
        var data = new FormData(this);
        data.append('CLAIM_DATE', $('input[name="CLAIM_DATE"]').val());

        var object = {};
        data.forEach(function(value, key){
            object[key] = value;
        });
        var jsonData = JSON.stringify(object);

        $.ajax({
            url: EXCS_URL+'/excs/claims/cc_allocations/'+id,
            type: 'PUT',
            processData: false,
            contentType: false,
            cache: false,
            data: jsonData,
            error: function(error) {
                console.log(error)
            },
            success: function(response) {
                var newData = removeNullFromObject(response.data.row);
                var lineItem = $('#ccLineItem').val();
                var serial = $('#editCcSerial').val();
                var tableID = '#ccAllocationNestedTable'+lineItem;

                var nestedRow = '<tr>' +
                    '<td>'+serial+'</td> ' +
                    '<td>'+newData.sol_name+'</td> ' +
                    '<td>'+newData.cost_center_name+'</td> ' +
                    '<td class="text-right">'+parseFloat(newData.allocation_ratio).toFixed(2)+'</td> ' +
                    '<td class="text-right">'+parseFloat(newData.budget_allocated).toFixed(2)+'</td> ' +
                    '<td class="text-right">'+parseFloat(newData.actual+newData.in_transit).toFixed(2)+'</td> ' +
                    '<td class="text-right">'+parseFloat(newData.allocation_amount).toFixed(2)+'</td> ' +
                    '<td class="text-center">' +
                    '<a data-id="'+newData.exc_cc_allocations_id+'" data-details-id="'+newData.exc_claim_details_id+'" ' +
                    'data-line-item="'+lineItem+'" data-serial="'+serial+'" class="fa fa-edit text-success editCostCenter"></a>' +
                    '<a data-id="'+newData.exc_cc_allocations_id+'" class="fa fa-times text-danger deleteCostCenter"></a>' +
                    '</td> ' +
                    '</tr>';

                $(tableID+' tbody tr').eq(serial-1).replaceWith(nestedRow);

                $('#editCostCenterModal').modal('hide');
            }

        });
    });

    $('#costCenterModal').on('hidden.bs.modal', function (e) {
        $(this).find('table tbody').empty();
    });

    $(document).on('click', '.deleteCostCenter', function () {
        var ccID = $(this).data('id');
        var row = $(this).closest('tr');
        $.ajax({
            url: EXCS_URL+'/excs/claims/cc_allocations/'+ccID,
            type: 'DELETE',
            error: function(xhr, status, error) {
                console.log('xhr: ');
                console.log(xhr);
                console.log('status: ' + status);
                console.log('error: ' + error);
            },
            success: function (response) {
                row.remove();
            }

        });

    });

    $(document).on('click', '.editCostCenter', function () {
        var ccID = $(this).data('id');
        var detailsId = $(this).data('details-id');
        var ccLineItem = $(this).data('line-item');
        var editCcSerial = $(this).data('serial');
        var totalClaimAmount = $(this).data('total-amount');
        $.ajax({
            url: EXCS_URL+'/excs/claims/cc_allocations/'+ccID+'/edit',
            type: 'GET',
            error: function(xhr, status, error) {
                console.log('xhr: ');
                console.log(xhr);
                console.log('status: ' + status);
                console.log('error: ' + error);
            },
            success: function (response) {
                $('#editAllocationRatio').val(response.data.row.allocation_ratio);
                $('#editAllocationAmount').val(response.data.row.allocation_amount);
                $('#ccId').val(ccID);
                $('#editCcSerial').val(editCcSerial);
                $('#editCcDetailsId').val(detailsId);
                $('#ccLineItem').val(ccLineItem);
                $('#editTotalClaimAmount').val(totalClaimAmount);

                $('#editCcCode option').filter(function() {
                    return this.value === response.data.row.cost_center_code;
                }).prop('selected', true);

                $('#editSolCode option').filter(function() {
                    return this.value === response.data.row.sol_code;
                }).prop('selected', true);

                $('#editCcCode, #editSolCode').select2().trigger('change');

                $('#editCostCenterModal').modal('show');
            }

        });
    });

    $('.allocationRatio').on('keyup', function () {
        var ratio = $(this).val();
        var totalClaimAmount = $('#totalClaimAmount').val();
        var allocationAmount = (totalClaimAmount * ratio) / 100;
        $('.allocationAmount').val(allocationAmount.toFixed(2));
    });

    $('#editAllocationRatio').on('keyup', function () {
        var ratio = $(this).val();
        var totalClaimAmount = $('#editTotalClaimAmount').val();
        var allocationAmount = (totalClaimAmount * ratio) / 100;
        $('.allocationAmount').val(allocationAmount.toFixed(2));
    });

    $('.allocationAmount').on('keyup', function () {
        var allocationAmount = $(this).val();
        var totalClaimAmount = $('#totalClaimAmount').val();
        var ratio = (allocationAmount * 100) / totalClaimAmount;
        $('.allocationRatio').val(ratio.toFixed(2));
    });

    $('#editAllocationAmount').on('keyup', function () {
        var allocationAmount = $(this).val();
        var totalClaimAmount = $('#editTotalClaimAmount').val();
        var ratio = (allocationAmount * 100) / totalClaimAmount;
        $('.allocationRatio').val(ratio.toFixed(2));
    });

    $(document).on('change', '#advanceRefNo', function () {
        var code = $('#advanceRefNo option:selected').text();
        var adjustClaimID = $(this).val();
        var claimRequestID = $('input[name="EXC_CLAIM_REQUESTS_ID"]').val();

        $('#advanceReferenceID').text(code);

        var data = {
            "EXC_CLAIM_REQUESTS_ID": claimRequestID,
            "EXC_ADJUST_CLAIM_ID": adjustClaimID
        }

        var jsonData = JSON.stringify(data);

        $.ajax({
            url: EXCS_URL+'/excs/advance_adjustments/amount',
            type: 'POST',
            data: jsonData,
            success: function (response) {
                console.log(response);
                var data = response.data;
                $('#advancePaidAmount').val(data.advance_paid_amount);
                $('#adjustedAmount').val(data.adjusted_amount);
                var remainingAmount = data.advance_paid_amount - data.adjusted_amount;
                $('#remainingAmount').val(remainingAmount);
                $('#wantToAdjust').val(remainingAmount);
            },
            error: function (response) {
                console.log(response);
            }
        });


    });

    $(document).on('change', '#editAdvanceRefNo', function () {
        var code = $('#editAdvanceRefNo option:selected').text();
        var adjustClaimID = $(this).val();
        var claimRequestID = $('input[name="EXC_CLAIM_REQUESTS_ID"]').val();

        $('#editAdvanceReferenceID').text(code);

        var data = {
            "EXC_CLAIM_REQUESTS_ID": claimRequestID,
            "EXC_ADJUST_CLAIM_ID": adjustClaimID
        }

        var jsonData = JSON.stringify(data);

        $.ajax({
            url: EXCS_URL+'/excs/advance_adjustments/amount',
            type: 'POST',
            data: jsonData,
            success: function (response) {
                console.log(response);
                var data = response.data;
                $('#ediAdvancePaidAmount').val(data.advance_paid_amount);
                $('#editAdjustedAmount').val(data.adjusted_amount);
                var remainingAmount = data.advance_paid_amount - data.adjusted_amount;
                $('#editRemainingAmount').val(remainingAmount);
                $('#editWantToAdjust').val(remainingAmount);
            },
            error: function (response) {
                console.log(response);
            }
        });


    });

    $(document).on('click', '.editExpense', function () {
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

        $('#editExpenseClaimModal').modal('show');
    });

    $('#editExpenseClaimModalForm').on('submit', function (e) {
        e.preventDefault();

        var id = $('#editClaimDetailsID').val();
        var serial = $('#editSerial').val();

        let data = new FormData(this);

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

                var expenseInfo = removeNullFromObject(response.data.row);

                var expenseDate = new Date(expenseInfo.expense_date)

                var dateString = ISODateString(expenseDate);

                var lineTotalBDT = '<td class="text-right lineTotalBDT">'+parseFloat(expenseInfo.line_total_bdt).toFixed(2)+'</td>';

                if ($('#currency').val() === 'BDT') {
                    lineTotalBDT = '<td class="text-right lineTotalBDT bdtInfo">'+parseFloat(expenseInfo.line_total_bdt).toFixed(2)+'</td>';
                }


                var newRow = '<tr id="tableLineItemID'+serial+'" class="tableLineItem">\
                            <td class="tableSerial">'+'<a data-toggle="collapse" data-target="#lineItem'+serial+'" class="accordion-toggle">\
                        <i class="more-less glyphicon glyphicon-plus"></i> '+serial+'</td>\
                            <td class="tableExpenseDate">'+dateString+'</td>\
                            <td class="tablePurposeTitle">'+expenseInfo.product_name+'</td>\
                            <td class="tableProjectName">'+expenseInfo.project_name +'</td>\
                            <td class="text-right tableRate">'+parseFloat(expenseInfo.rate).toFixed(2)+'</td>\
                            <td class="text-right tableQuantity">'+expenseInfo.qty+'</td>\
                            <td class="text-right lineTotal">'+parseFloat(expenseInfo.line_total).toFixed(2)+lineTotalBDT+'</td>\
                            <td class="text-center">\
                            <a data-id="'+expenseInfo.exc_claim_details_id+'"data-line-item="'+serial+'" class="btn customBtn ccButton">CC</a>\
                            <a data-id="'+expenseInfo.exc_claim_details_id+'"data-serial="'+serial+'" data-purpose-details="'+expenseInfo.product_details+'" class="fa fa-edit text-success editExpense"></a>\
                            <a data-id="'+expenseInfo.exc_claim_details_id+'" class="fa fa-times text-danger deleteExpense"></a>\
                            </td></tr>';

                $('#tableLineItemID'+serial).replaceWith(newRow);

                calculateGrandTotal();

                $('#editExpenseClaimModal').modal('hide');

            }

        });


    });

    $('#expenseClaimModal, #costCenterModal, #advanceReferenceModal').on('hidden.bs.modal', function(event) {
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