jQuery(document).ready(function ($) {
    calculateGrandTotal();
    calculateTotalAdjustmentAmount();

    $('#addApprover').on('click', function () {

        if ($('#approver').val() === 'null') {
            return;
        }

        var approverName = $('#approver option:selected').text();

        var sameName = false;

        $('#approvalPersonTable tbody tr').each(function () {
            $(this).find('.approvalPersonName').each(function () {
                var approvalPersonName = $(this).text();
                if (approvalPersonName === approverName) {
                    sameName = true;
                }
            });
        });

        if (!sameName) {
            var approverID = $('#approver').val();
            var approverDesignation = $('#approver option:selected').data('designation');

            let lastSerial = $('#approvalPersonTable tbody tr').length;
            lastSerial++;

            var newRow = '<tr><td data-approver-id="'+approverID+'">'+lastSerial+'</td>\
            <td class="approvalPersonName">'+approverName+' ('+approverID+')</td>\
            <td>'+approverDesignation+'</td>\
            <td><a class="fa fa-times text-danger removeApprover"></a></td></tr>';

            $('#approvalPersonTable tbody:last').append(newRow);
        }

    });

    $(document).on('click', '.removeApprover', function () {
        $(this).closest('tr').remove();
    });

    $('#save').on('click', function () {

        bootbox.confirm({
            message: "Are you sure to change the approval persons?",
            buttons: {
                confirm: {
                    label: 'Yes',
                    className: 'btn-success'
                },
                cancel: {
                    label: 'No',
                    className: 'btn-danger'
                }
            },
            callback: function (isSure) {
                if (isSure) {
                    var APPROVERS = [];
                    $('#approvalPersonTable tbody tr').each(function() {
                        var approverId = $(this).find('td:first-child').data('approver-id');
                        var approvalStatus = $(this).find('td:first-child').data('approval-status');

                        if (!approvalStatus) {
                            APPROVERS.push(approverId);
                        }
                    });

                    var data = JSON.stringify({
                        "EXC_CLAIM_REQUESTS_ID": $('input[name="EXC_CLAIM_REQUESTS_ID"]').val(),
                        "APPROVAL_PERSON": APPROVERS
                    });

                    $.ajax({
                        url: EXCS_URL+'/excs/claims/change_approval_person',
                        type: 'POST',
                        data: data,
                        processData: false,
                        cache: false,
                        error: function(xhr, status, error) {
                            console.log('xhr: ');
                            console.log(xhr);
                            console.log('status: ' + status);
                            console.log('error: ' + error);
                        },
                        success: function(response) {
                            window.location.reload();
                        }

                    });
                }
            }
        });


    });

});

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
function removeNullFromObject(object) {
    return JSON.parse(JSON.stringify(object, (key, value) =>
        value === null || value === undefined
            ? 'N/A'
            : value
    ));
}

function claim_action(button) {

        bootbox.confirm({
            message: "Are you sure you want to "+button+" the claim?",
            buttons: {
                confirm: {
                    label: 'Yes',
                    className: 'btn-success'
                },
                cancel: {
                    label: 'No',
                    className: 'btn-danger'
                }
            },
            callback: function (shouldApprove) {
                if (shouldApprove) {

                    var data = JSON.stringify({
                        "CURRENT_APPROVAL_PERSON": $('#currentApprovalPerson').val(),
                        "EXC_CLAIM_REQUESTS_ID": $('#claimRequestId').val(),
                        "COMMENTS": $('#comments').val(),
                        "BUTTON": button
                    });
                    $.ajax({
                        url: EXCS_URL+'/excs/claims/process',
                        type: 'POST',
                        data: data,
                        error: function(xhr, status, error) {
                            console.log('xhr: ');
                            console.log(xhr);
                            console.log('status: ' + status);
                            console.log('error: ' + error);
                        },
                        success: function(response) {
                            bootbox.alert({
                                message: 'The claim has been '+button+'ED successfully.',
                                className: 'text-success',
                                callback: function () {
                                    var url = BASE_URL + 'excs/claim_approval_list';
                                    window.location.href = url;
                                }
                            });
                        }

                    });
                }
            }
        });

}