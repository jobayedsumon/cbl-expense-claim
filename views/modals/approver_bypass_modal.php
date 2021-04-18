<div class="modal fade" id="approverBypassModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title panel title panel-title-secondary"

                    id="exampleModalLongTitle">Bypass Approval Person</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

                <div class="modal-body">

                    <input type="hidden" value="" id="approvalLogId">


                    <div class="row" style="margin-bottom: 10px">
                        <div class="col-md-6 col-sm-6">
                            <select id="approverList" >
                                <option value="null">Please select one</option>
                                <?php
                                if ($employee_list) {
                                    foreach ($employee_list as $employee) {
                                        ?>
                                        <option
                                                data-designation="<?php echo $employee->designation_name; ?>"
                                                value="<?php echo $employee->employee_id; ?>">
                                            <?php echo $employee->employee_name.' ('.$employee->employee_id.')'; ?>
                                        </option>
                                    <?php }} ?>
                            </select>

                        </div>

                        <div class="col-md-2 col-sm-2">
                            <button id="bypassApprover" style="margin-bottom: 5px" class="btn customBtn pull-right">Update</button>
                        </div>

                    </div>

                </div>

        </div>
    </div>
</div>
