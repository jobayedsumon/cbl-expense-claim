<?php
if (isset($claim_information)) {
    $data = $claim_information->approvers;
    $bypass_approval_person_url = excs_url() . '/excs/claims/bypass_approval_person';
    $set_on_behalf_person_url = excs_url() . '/excs/claims/set_on_behalf_person';
    $data_attribute = "EXC_CLAIM_REQUESTS_ID";
} else {
    $data = $travel_plan->approval_persons;
    $bypass_approval_person_url = excs_url() . '/excs/travel_plans/bypass_approval_person';
    $set_on_behalf_person_url = excs_url() . '/excs/travel_plans/set_on_behalf_person';
    $data_attribute = "EXC_TRAVEL_PLANS_ID";
}
?>

<div class="row">

        <div class="col-md-12">
            <div class="panel panel-danger">
                <div class="panel-heading">
                    <h3 class="panel-title"><strong>Change Approval Person</strong></h3>
                </div>
                <div class="panel-body">
<!--                    <div class="row" style="margin-bottom: 10px">-->
<!--                        <div class="col-md-3 col-sm-3">-->
<!--                            <select id="approver">-->
<!--                                <option value="null">Please select one</option>-->
<!--                                --><?php
//                                if ($employee_list) {
//                                    foreach ($employee_list as $employee) {
//                                        ?>
<!--                                        <option data-designation="--><?php //echo $employee->designation_name; ?><!--"-->
<!--                                                value="--><?php //echo $employee->employee_id; ?><!--">-->
<!--                                            --><?php //echo $employee->employee_name.' ('.$employee->employee_id.')'; ?>
<!--                                        </option>-->
<!--                                    --><?php //}} ?>
<!--                            </select>-->
<!---->
<!--                        </div>-->
<!--                        <a id="addApprover" class="btn customBtn">Add</a>-->
<!---->
<!--                    </div>-->

                    <?php
                    if (isset($claim_information)) { ?>
                        <input type="hidden" name="EXC_CLAIM_REQUESTS_ID" id="excId" value="<?php echo $claim_information->claim->exc_claim_requests_id; ?>">
                   <?php } elseif (isset($travel_plan)) { ?>
                    <input type="hidden" name="EXC_TRAVEL_PLANS_ID" id="excId" value="<?php echo $travel_plan->plan->exc_travel_plans_id; ?>">
                    <?php } ?>

                    <input type="hidden" name="UPDATED_BY" value="<?php echo $this->user->EMPLOYEE_ID; ?>" class="updatedBy">

                    <div class="table-responsive">
                        <table id="approvalPersonTable" class="table table-bordered table-condensed table-hover table-striped">
                            <thead >
                            <tr class="text-center">
                                <th>Sort No</th>
                                <th>Approval Person</th>
                                <th>Assigned At</th>
                                <th>Approved At</th>
                                <th>Duration</th>
                                <th>Comment</th>
                                <th>On Behalf Of</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php if (isset($data)) {
                                foreach ($data as $index => $approver) {
                                    ?>
                                    <tr data-log-id="<?php echo $approver->exc_approval_log_id; ?>">
                                        <td data-approver-id="<?php echo $approver->approval_person; ?>">
                                            <?php echo $index+1; ?></td>
                                        <td class="approvalPersonName"><?php echo $approver->approval_person_name.' ('.$approver->approval_person.')'; ?></td>
                                        <td><?php echo $approver->updated_at; ?></td>
                                        <td>N/A</td>
                                        <td><?php echo date_difference_in_days($approver->updated_at, date('Y-m-d H:i:s'))['duration']; ?></td>
                                        <td class="changeApproverComment"><?php echo $approver->approval_action == 'Inactive' ? 'Inactive by Admin' : ''; ?></td>
                                        <td class="onBehalfPerson">
                                            <?php if ($approver->on_behalf_person)  echo $approver->on_behalf_person_name.' ('.$approver->on_behalf_person.')'; ?>
                                        </td>
                                        <td class="text-center"> <?php if (!$approver->approval_status) { if ($approver->is_current_approval == 'Yes') { ?>
                                            <a data-log-id="<?php echo $approver->exc_approval_log_id; ?>"
                                               class="fa <?php echo $approver->approval_action == 'Inactive' ? 'fa-toggle-off' : 'fa-toggle-on'; ?>
                                               text-info approverStatusChange"></a>
                                            <?php } if ($approver->approval_action == 'Active') { ?>
                                                <a data-log-id="<?php echo $approver->exc_approval_log_id; ?>"
                                                   data-approver-id="<?php echo $approver->approval_person; ?>"
                                                   class="btn customBtn bypass">Change</a>
                                            <?php }} ?>
                                        </td>
                                    </tr>

                                <?php }} ?>
                            </tbody>
                        </table>

                    </div>

<!--                    <button id="save" name="save" class="btn customBtn">Save</button>-->
                </div>
            </div>
        </div>
    </div>

<?php $this->load->view('modals/approver_bypass_modal'); ?>


<script>
    function timeDiffCalc(firstDate, secondDate) {
        console.log(firstDate);
        console.log(secondDate);
        let diffInMilliSeconds = Math.abs(firstDate - secondDate) / 1000;
        console.log(diffInMilliSeconds);

        // calculate days
        const days = Math.floor(diffInMilliSeconds / 86400);
        diffInMilliSeconds -= days * 86400;

        // calculate hours
        const hours = Math.floor(diffInMilliSeconds / 3600) % 24;
        diffInMilliSeconds -= hours * 3600;

        // calculate minutes
        const minutes = Math.floor(diffInMilliSeconds / 60) % 60;
        diffInMilliSeconds -= minutes * 60;

        let difference = '';
        if (days > 0) {
            difference += (days === 1) ? days+' day, ' : days+' days, ';
        }

        difference += (hours === 0 || hours === 1) ? hours+' hour, ' : hours+' hours, ';

        difference += (minutes === 0 || hours === 1) ? minutes+' minutes and ' : minutes+' minutes and ';

        difference += Math.floor(diffInMilliSeconds)+' seconds';

        console.log(difference)
        return difference;
    }

    $(document).ready(function () {
        var oldApprover = '';
        var bypassRow = null;

        $(document).on('click', '.approverStatusChange', function (e) {
            e.preventDefault();
            var button = $(this);
            var logId = button.data('log-id');
            var approvalAction = '';
            var newClass = '';
            var oldClass = '';
            if ($(this).hasClass('fa-toggle-on')) {
                approvalAction = 'Inactive';
                newClass = 'fa-toggle-off';
                oldClass = 'fa-toggle-on';
            } else {
                approvalAction = 'Active';
                newClass = 'fa-toggle-on';
                oldClass = 'fa-toggle-off';
            }

            bootbox.confirm({
                message: "Are you sure to "+approvalAction+" this approval person?",
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
                        var data = JSON.stringify({
                            "EXC_APPROVAL_LOG_ID": logId,
                            "UPDATED_BY": $('.updatedBy').val()
                        });

                        $.ajax({
                            url: "<?php echo $bypass_approval_person_url; ?>",
                            type: 'POST',
                            processData: false,
                            contentType: false,
                            cache: false,
                            data: data,
                            error: function(xhr, status, error) {
                                console.log('xhr: ');
                                console.log(xhr);
                                console.log('status: ' + status);
                                console.log('error: ' + error);
                            },
                            success: function(response) {
                                button.removeClass(oldClass);
                                button.addClass(newClass);
                                if (approvalAction === 'Inactive') {
                                    button.closest('tr').find('.changeApproverComment').text('Inactive by Admin');
                                    var nextRow = button.closest('tr').next('tr');
                                    var logId = nextRow.data('log-id');
                                    var newButton = '<a data-log-id="'+logId+'" class="fa fa-toggle-on text-info approverStatusChange"></a>';
                                    nextRow.find('td:last').prepend(newButton);
                                    button.siblings().remove();
                                    button.remove();

                                } else {
                                    button.closest('tr').find('.changeApproverComment').text('');
                                }

                            }

                        });
                    }
                }
            });



        });

        $(document).on('click', '.bypass', function (e) {
           e.preventDefault();
           bypassRow = $(this).closest('tr');
           var logId = $(this).data('log-id');
           var approverId = $(this).data('approver-id');
           $('#approvalLogId').val(logId);
           $('#approverList').val(approverId).trigger('change');
           oldApprover = approverId;
           $('#approverBypassModal').modal('show');
        });

        $(document).on('click', '#bypassApprover', function (e) {
            e.preventDefault();

            if (!$('#approverList').val()) {
                return;
            }

            bootbox.confirm({
                message: "Are you sure to change the approval person?",
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
                        var approverName = $('#approverList option:selected').text().trim();
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
                            var data = JSON.stringify({
                                "EXC_APPROVAL_LOG_ID": $('#approvalLogId').val(),
                                "<?php echo $data_attribute; ?>": $('#excId').val(),
                                "APPROVAL_PERSON": $('#approverList').val(),
                                "ON_BEHALF_PERSON": oldApprover,
                                "UPDATED_BY": $('.updatedBy').val()
                            });

                            $.ajax({
                                url: "<?php echo $set_on_behalf_person_url; ?>",
                                type: 'POST',
                                processData: false,
                                contentType: false,
                                cache: false,
                                data: data,
                                error: function(xhr, status, error) {
                                    console.log('xhr: ');
                                    console.log(xhr);
                                    console.log('status: ' + status);
                                    console.log('error: ' + error);
                                },
                                success: function(response) {
                                    var data = removeNullFromObject(response.data.log);
                                    var duration = timeDiffCalc(new Date(), new Date(data.updated_at));
                                    var newRow = '<tr data-log-id="'+data.exc_approval_log_id+'"><td data-approver-id="'+data.approval_person+'">'+data.sort_no+'</td>\
                                        <td class="approvalPersonName">'+data.approval_person_name+' ('+data.approval_person+')</td>\
                                        <td>'+data.updated_at+'</td><td>N/A</td><td>'+duration+'</td><td class="changeApproverComment"></td>\
                                        <td class="onBehalfPerson">'+data.on_behalf_person_name+' ('+data.on_behalf_person+')</td>\
                                        <td class="text-center"><a data-log-id="'+data.exc_approval_log_id+'" class="fa fa-toggle-on text-info approverStatusChange"></a>\
                                        <a data-log-id="'+data.exc_approval_log_id+'" data-approver-id="'+data.approval_person+'" class="btn customBtn bypass">Change</a></td></tr>';

                                    bypassRow.replaceWith(newRow);

                                    $('#approverBypassModal').modal('hide');
                                }

                            });
                        } else {
                            bootbox.alert({
                                message: "Approval person already exist.",
                                className: 'text-danger',
                            });
                        }
                    }
                }
            });

        });

    });
</script>
