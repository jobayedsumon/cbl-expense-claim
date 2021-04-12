function ISODateString(d){
    function pad(n){return n<10 ? '0'+n : n}
    return d.getUTCFullYear()+'-'
        + pad(d.getUTCMonth()+1)+'-'
        + pad(d.getUTCDate())
}

function removeNullFromObject(object) {
    return JSON.parse(JSON.stringify(object, (key, value) =>
        value === null || value === undefined
            ? 'N/A'
            : value
    ));
}

$(document).ready(function () {

    $("input[type='date']").datepicker({dateFormat: "yyyy-MM-dd"});

    $("input[type='date']").datepicker("setDate", new Date());

    $('.modalCalculation').on('keyup', function () {
        var totalAmount = 1;
        var exchangeRate = $('.exchangeRateInput').val();
        $('.modalCalculation').each(function () {
            totalAmount *= $(this).val();
            totalAmount = parseFloat(totalAmount).toFixed(2);
            $('#totalAmount').val(totalAmount);
            var totalAmountBDT = totalAmount * exchangeRate;
            totalAmountBDT = parseFloat(totalAmountBDT).toFixed(2);
            $('#totalAmountBDT').val(totalAmountBDT);

        });
    });

    $('.editModalCalculation').on('keyup', function () {
        var totalAmount = 1;
        var exchangeRate = $('.exchangeRateInput').val();
        $('.editModalCalculation').each(function () {
            totalAmount *= $(this).val();
            $('#editTotalAmount').val(totalAmount);
            var totalAmountBDT = totalAmount * exchangeRate;
            $('#editTotalAmountBDT').val(totalAmountBDT);

        });
    });

    $('#save').on('click', function (e) {
        e.preventDefault();

        if ($('#advanceDetailsTable tbody tr').length <= 0 && $('#expenseDetailsTable tbody tr').length <= 0) {

            bootbox.alert({
                message: 'Please add claim to submit.',
                className: 'text-danger'
            });

        } else if (!$('input[name="APPROVAL_PROCESS_TYPE"]').is(':checked')) {
            bootbox.alert({
                message: 'Select approval process',
                className: 'text-danger'
            });
        } else {
            var APPROVERS = [];
            $('#approvalPersonTable tbody tr').each(function() {
                var approverId = $(this).find('td:first-child').data('approver-id');
                APPROVERS.push(approverId);
            });
            // APPROVERS = JSON.stringify(APPROVERS);

            var data = JSON.stringify({
                'EXC_CLAIM_REQUESTS_ID': $('input[name="EXC_CLAIM_REQUESTS_ID"]').val(),
                'UPDATED_BY': $('input[name="UPDATED_BY"]').val(),
                'EMPLOYEE_ID': $('#onBehalfOf').val(),
                'CURRENCY_CODE': $('select[name="CURRENCY_CODE"]').val(),
                'EXCHANGE_RATE': $('input[name="EXCHANGE_RATE"]').val(),
                'CLAIM_DATE': $('input[name="CLAIM_DATE"]').val(),
                'MEMO_NO': $('select[name="MEMO_NO"]').val(),
                'REMARKS': $('textarea[name="REMARKS"]').val(),
                'APPROVAL_PROCESS_TYPE': $('input[name="APPROVAL_PROCESS_TYPE"]:checked').val(),
                'APPROVERS': APPROVERS,
                'CLAIM_ACTION': 'SAVE',
            });

            $.ajax({
                url: EXCS_URL+'/excs/claims/update',
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
                    var url = BASE_URL + 'excs/claim_list';
                    bootbox.alert({
                        message: 'The claim has been saved successfully.',
                        className: 'text-success',
                        callback: function () {
                            window.location.href = url;
                        }
                    });
                }

            });
        }

    });

    $('#sendForApproval').on('click', function (e) {
        e.preventDefault();

        if ($('#advanceDetailsTable tbody tr').length <= 0 && $('#expenseDetailsTable tbody tr').length <= 0) {
            bootbox.alert({
                message: 'Please add claim to submit.',
                className: 'text-danger'
            });

        } else if ($('#approvalPersonTable tbody tr').length <= 0) {
            bootbox.alert({
                message: 'No approval person added.',
                className: 'text-danger'
            });
        } else if(!$('input[name="APPROVAL_PROCESS_TYPE"]').is(':checked')) {
            bootbox.alert({
                message: 'Select approval process',
                className: 'text-danger'
            });
        }
        else {
            var APPROVERS = [];
            $('#approvalPersonTable tbody tr').each(function() {
                var approverId = $(this).find('td:first-child').data('approver-id');
                APPROVERS.push(approverId);
            });
            // APPROVERS = JSON.stringify(APPROVERS);

            var data = JSON.stringify({
                'EXC_CLAIM_REQUESTS_ID': $('input[name="EXC_CLAIM_REQUESTS_ID"]').val(),
                'UPDATED_BY': $('input[name="UPDATED_BY"]').val(),
                'EMPLOYEE_ID': $('#onBehalfOf').val(),
                'CURRENCY_CODE': $('select[name="CURRENCY_CODE"]').val(),
                'EXCHANGE_RATE': $('input[name="EXCHANGE_RATE"]').val(),
                'CLAIM_DATE': $('input[name="CLAIM_DATE"]').val(),
                'MEMO_NO': $('select[name="MEMO_NO"]').val(),
                'REMARKS': $('textarea[name="REMARKS"]').val(),
                'APPROVAL_PROCESS_TYPE': $('input[name="APPROVAL_PROCESS_TYPE"]:checked').val(),
                'APPROVERS': APPROVERS,
                'CLAIM_ACTION': 'SEND',
            });

            console.log(data);


            $.ajax({
                url: EXCS_URL+'/excs/claims/update',
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
                    var url = BASE_URL + 'excs/claim_list';
                    bootbox.alert({
                        message: "The claim has been saved and sent to the first approver.",
                        className: 'text-success',
                        callback: function () {
                            window.location.href = url;
                        }
                    });

                }

            });
        }

    });

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
            <td class="approvalPersonName">'+approverName+'</td>\
            <td>'+approverDesignation+'</td>\
            <td><a class="fa fa-times text-danger removeApprover"></a></td></tr>';

            $('#approvalPersonTable tbody:last').append(newRow);
        }

    });

    $(document).on('click', '.removeApprover', function () {
        $(this).closest('tr').remove();
    });

    $('#currency').on('change', function () {
        if ($('#advanceDetailsTable tbody tr').length > 0 || $('#expenseDetailsTable tbody tr').length > 0) {
            bootbox.alert({
                message: "Please remove all items in order to change this.",
                className: 'text-danger'
            });
        } else {
            var currencyCode = $(this).val();
            console.log(currencyCode);
            if (currencyCode !== 'BDT') {
                $('.bdtInfo').show();
            } else {
                $('#exchangeRate').val(1);
                $('.bdtInfo').hide();
            }
            $('#currencyCode').val(currencyCode);
            $('.currencyCodeText').text(currencyCode);
        }

    });

    $('#exchangeRate').on('change', function () {
        $('.exchangeRateInput').val($(this).val());
    });

    $('#onBehalfOf').on('change', function () {

        var employeeId = $(this).val();
        var memoRefNo = $('#memoRefNo');
        memoRefNo.empty().append(new Option()).trigger('change');

        var data = JSON.stringify({
            'EMPLOYEE_ID': employeeId
        });

        $.ajax({
            url: EXCS_URL+'/employee',
            type: 'POST',
            data: data,
            error: function(error) {
                console.log(error)
            },
            success: function(response) {
                // var employeeInformation = JSON.parse(response);
                var employee = response.data.employee;
                $('.employeeName').text(employee.employee_name ?? 'N/A');
                $('.employeeId').text(employee.employee_id ?? 'N/A');
                $('#designation').text(employee.designation_name ?? 'N/A');
                $('#organization').text(employee.organization ?? 'N/A');
                $('#supervisorsName').text(employee.supervisor_name ?? 'N/A');
                $('#grade').text(employee.grade ?? 'N/A');
                $('#solBranchInfo').text(employee.sol_name ?? 'N/A');
                $('#costCenterInfo').text(employee.cost_center_name ?? 'N/A');
                $('#typeOfTransaction').text(employee.transaction_type ?? 'N/A');
                $('#accountName').text(employee.account_name ?? 'N/A');
                $('#accountNumber').text(employee.account_number ?? 'N/A');
                $('#routingNumber').text(employee.routing_number ?? 'N/A');
                $('#bankName').text(employee.bank_name ?? 'N/A');
                $('#branchName').text(employee.branch_name ?? 'N/A');
                $('#contactNumber').text(employee.contact_number ?? 'N/A');

            }

        });

        $.ajax({
            url: 'excs/get_memo_references',
            type: 'POST',
            data: {employeeId: employeeId},
            error: function(error) {
                console.log(error)
            },
            success: function(response) {
                var memoReferences = JSON.parse(response);
                var memos = memoReferences.data.memos;
                var newOptions = '<option selected value="">Please select one</option>';
                $.each(memos, function (index, value) {
                    newOptions += '<option value="'+value.memo_archive_id+'">'+value.memo_ref+'</option>';
                });
                memoRefNo.append(newOptions);
                memoRefNo.trigger('change');

            }

        });

    });

    $('#attachment').on('change', function () {

        var data = new FormData();

        // Read selected files
        var totalfiles = $(this).prop('files').length;
        for (var index = 0; index < totalfiles; index++) {
            data.append("FILE_UPLOAD[]", $(this).prop('files')[index]);
        }

        data.append('CREATED_BY', $('input[name="UPDATED_BY"]').val());
        data.append('REQUEST_ID', $('input[name="EXC_CLAIM_REQUESTS_ID"]').val());
        data.append('MODULE_ID', 14); // EXC MODULE = 14
        data.append('ATTACHMENT_FOR', 7); // ATTACHMENT FOR = 7
        for (var pair of data.entries()) {
            console.log(pair[0]+ ', ' + pair[1]);
        }

        $.ajax({
            url: EXCS_URL+'/attachments/store',
            type: 'POST',
            cache: false,
            enctype: 'multipart/form-data',
            dataType: 'json',
            contentType: false,
            processData: false,
            data: data,
            success: function (response) {
                var files = response.data.rows;

                var newRows = '';

                $.each(files, function (index, item) {
                    newRows += '<tr><td>'+item.file_name+'</td><td>\
                            <a href="'+EXCS_URL+'/attachments/download?FILE_LOC='+item.file_loc+'" class="fa fa-download text-success downloadAttachment"></a>\
                            <a data-name="'+item.file_name+'" class="fa fa-times text-danger deleteAttachment"></a></td></tr>'
                });

                $('#attachmentsTable tbody:last').append(newRows);

                $('#attachment').val(null);

            },
            error: function (response) {
                console.log(response);

            }
        });
    });

    $(document).on('click', '.deleteAttachment', function (e) {
        var row = $(this).closest('tr');
        var data = {
            "REQUEST_ID": $('input[name="EXC_CLAIM_REQUESTS_ID"]').val(),
            "FILE_NAME": $(this).data('name'),
            "MODULE_ID": 14,
            "ATTACHMENT_FOR": 7
        }
        var jsonData = JSON.stringify(data);

        $.ajax({
            url: EXCS_URL+'/attachments/delete',
            type: 'POST',
            cache: false,
            dataType: 'json',
            contentType: false,
            processData: false,
            data: jsonData,
            success: function (response) {
                row.remove();
            },
            error: function (response) {
                console.log(response);
            }
        });
    })

    $('.accordian-body').on('shown.bs.collapse', function() {
        $(".more-less").addClass('glyphicon-minus').removeClass('glyphicon-plus');
    });

    $('.accordian-body').on('hidden.bs.collapse', function() {
        $(".more-less").addClass('glyphicon-plus').removeClass('glyphicon-minus');
    });

    $('#exchangeRate:read-only').on('click', function () {
        bootbox.alert({
            message: "Please remove all items in order to change this.",
            className: 'text-danger'
        });
    });

});