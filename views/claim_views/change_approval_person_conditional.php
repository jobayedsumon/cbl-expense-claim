
<div class="row">

        <div class="col-md-12">
            <div class="panel panel-success">
                <div class="panel-heading">
                    <h3 class="panel-title"><strong>Change Approval Person</strong></h3>
                </div>
                <div class="panel-body">
                    <div class="row" style="margin-bottom: 10px">
                        <div class="col-md-3 col-sm-3">
                            <select id="approver">
                                <option value="null">Please select one</option>
                                <?php
                                if ($employee_list) {
                                    foreach ($employee_list as $employee) {
                                        ?>
                                        <option data-designation="<?php echo $employee->designation_name; ?>"
                                                value="<?php echo $employee->employee_id; ?>">
                                            <?php echo $employee->employee_name.' ('.$employee->employee_id.')'; ?>
                                        </option>
                                    <?php }} ?>
                            </select>

                        </div>
                        <a id="addApprover" class="btn customBtn">Add</a>

                    </div>

                    <div class="table-responsive">
                        <table id="approvalPersonTable" class="table table-bordered table-condensed table-hover table-striped">
                            <thead >
                            <tr class="text-center">
                                <th>Sort No</th>
                                <th>Approval Person</th>
                                <th>Designation</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php if (isset($claim_information->approvers)) {
                                foreach ($claim_information->approvers as $approver) {
                                    ?>
                                    <tr>
                                        <td data-approver-id="<?php echo $approver->approval_person; ?>">
                                            <?php echo $approver->sort_no; ?></td>
                                        <td class="approvalPersonName"><?php echo $approver->approval_person_name.' ('.$approver->approval_person.')'; ?></td>
                                        <td><?php echo $approver->designation_name; ?></td>
                                        <td> <?php if (!$approver->approval_status) { ?>
                                            <a class="fa fa-times text-danger removeApprover"></a>
                                            <?php } ?>
                                        </td>
                                    </tr>

                                <?php }} ?>
                            </tbody>
                        </table>

                    </div>

                    <input type="hidden" name="EXC_CLAIM_REQUESTS_ID" value="<?php echo $claim_information->claim->exc_claim_requests_id; ?>">

                    <button id="save" name="save" class="btn customBtn">Save</button>
                </div>
            </div>
        </div>
    </div>
