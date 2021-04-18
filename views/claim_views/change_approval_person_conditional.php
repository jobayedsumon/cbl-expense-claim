
<div class="row">

        <div class="col-md-12">
            <div class="panel panel-success">
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

                    <input type="hidden" name="EXC_CLAIM_REQUESTS_ID" value="<?php echo $claim_information->claim->exc_claim_requests_id; ?>">
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
                            <?php if (isset($claim_information->approvers)) {
                                foreach ($claim_information->approvers as $index => $approver) {
                                    ?>
                                    <tr>
                                        <td data-approver-id="<?php echo $approver->approval_person; ?>">
                                            <?php echo $index+1; ?></td>
                                        <td class="approvalPersonName"><?php echo $approver->approval_person_name.' ('.$approver->approval_person.')'; ?></td>
                                        <td><?php echo $approver->updated_at; ?></td>
                                        <td>N/A</td>
                                        <td>N/A</td>
                                        <td class="changeApproverComment"><?php echo $approver->approval_action == 'Inactive' ? 'Inactive by Admin' : ''; ?></td>
                                        <td class="onBehalfPerson">
                                            <?php if ($approver->on_behalf_person)  echo $approver->on_behalf_person_name.' ('.$approver->on_behalf_person.')'; ?>
                                        </td>
                                        <td class="text-center"> <?php if (!$approver->approval_status) { ?>
                                            <a data-id="<?php echo $approver->exc_approval_log_id; ?>" class="fa <?php echo $approver->approval_action == 'Inactive' ? 'fa-toggle-off' : 'fa-toggle-on'; ?> text-info approverStatusChange"></a>
                                                <a data-log-id="<?php echo $approver->exc_approval_log_id; ?>"
                                                   data-approver-id="<?php echo $approver->approval_person; ?>"
                                                   class="btn customBtn bypass">Change</a>
                                            <?php } ?>
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
    $(document).ready(function () {
        var oldApprover = '';
        var bypassRow = null;

        $(document).on('click', '.approverStatusChange', function (e) {
            e.preventDefault();
            var button = $(this);
            var id = button.data('id');
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

           var data = JSON.stringify({
               "APPROVAL_ACTION": approvalAction,
               "UPDATED_BY": $('.updatedBy').val()
           });

            $.ajax({
                url: EXCS_URL+'/excs/claims/approval_logs/'+id,
                type: 'PUT',
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
                    } else {
                        button.closest('tr').find('.changeApproverComment').text('');
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

            var data = JSON.stringify({
                "EXC_APPROVAL_LOG_ID": $('#approvalLogId').val(),
                "EXC_CLAIM_REQUESTS_ID": $('input[name="EXC_CLAIM_REQUESTS_ID"]').val(),
                "APPROVAL_PERSON": $('#approverList').val(),
                "ON_BEHALF_PERSON": oldApprover,
                "UPDATED_BY": $('.updatedBy').val()
            });

            $.ajax({
                url: EXCS_URL+'/excs/claims/set_on_behalf_person',
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
                    var newRow = '<tr><td data-approver-id="'+data.approval_person+'">'+data.sort_no+'</td>\
                    <td class="approvalPersonName">'+data.approval_person_name+' ('+data.approval_person+')</td>\
                    <td>'+data.updated_at+'</td><td>N/A</td><td>N/A</td><td></td>\
                    <td class="onBehalfPerson">'+data.on_behalf_person_name+' ('+data.on_behalf_person+')</td>\
                    <td class="text-center"><a data-id="'+data.exc_approval_log_id+'" class="fa fa-toggle-on text-info approverStatusChange"></a>\
                    <a data-log-id="'+data.exc_approval_log_id+'" data-approver-id="'+data.approval_person+'" class="btn customBtn bypass">Change</a></td></tr>';

                    bypassRow.replaceWith(newRow);

                    $('#approverBypassModal').modal('hide');
                }

            });

        });
    });
</script>
