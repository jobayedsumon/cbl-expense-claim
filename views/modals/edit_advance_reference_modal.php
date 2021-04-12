<div class="modal fade" id="editAdvanceReferenceModal" tabindex="-1" role="dialog" aria-labelledby="editAdvanceReferenceModal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">

                <h5 class="modal-title panel title panel-title-secondary"

                    id="exampleModalLongTitle">Advance Reference</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form autocomplete="off" id="editAdvanceAdjustmentForm" method="POST" action="excs/advance_adjustment">
                <div class="modal-body">
                    <input type="hidden" name="EXC_CLAIM_REQUESTS_ID" value="<?php echo $claim_information->claim->exc_claim_requests_id; ?>">
                    <input type="hidden" id="editAdvanceAdjustmentID" value="">
                    <input type="hidden" id="editAdjustmentSerial" value="">
                    <div class="row">
                        <div class="col-md-6 col-sm-6">
                            <label for="">Employee ID: </label> <span class="employeeID"><?php echo $employee_information->employee_id; ?></span>
                        </div>
                        <div class="col-md-6 col-sm-6">
                            <label for="">Employee Name: </label> <span class="employeeName"><?php echo $employee_information->employee_name; ?></span>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 col-sm-6">
                            <div class="form-group">
                                <label for="exampleFormControlSelect2">Advance Payment Reference</label>
                                <select class="form-control" id="editAdvanceRefNo" required name="EXC_ADJUST_CLAIM_ID" required>
                                    <option selected value="">Please select one</option>
                                    <?php
                                    if ($advance_references) {
                                        foreach ($advance_references as $advance) {
                                            ?>
                                            <option
                                                    value="<?php echo $advance->exc_claim_requests_id; ?>">
                                                <?php echo $advance->claim_code; ?>
                                            </option>
                                        <?php }} ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-6">
                            <label for="">Reference ID: </label> <span id="editAdvanceReferenceID"></span>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 col-sm-6">
                            <div class="form-group">
                                <label for="exampleFormControlInput1">Advance Paid Amount</label>
                                <input step="0.01" type="number" class="form-control" min="1" value="1" id="editAdvancePaidAmount" readonly>
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-6">
                            <div class="form-group">
                                <label for="exampleFormControlInput1">Adjusted Amount</label>
                                <input step="0.01" type="number" class="form-control" min="1" value="1" id="editAdjustedAmount" readonly>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 col-sm-6">
                            <div class="form-group">
                                <label for="exampleFormControlInput1">Remaining Amount</label>
                                <input step="0.01" type="number" class="form-control" min="1" value="1" id="editRemainingAmount" readonly>
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-6">
                            <div class="form-group">
                                <label for="exampleFormControlInput1">Want to Adjust</label>
                                <input step="0.01" type="number" class="form-control" min="1" value="1" id="editWantToAdjust" name="ADJUST_AMOUNT" required>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12 col-sm-12">
                            <div class="form-group">
                                <label for="exampleFormControlTextarea1">Remarks</label>
                                <textarea maxlength="255" class="form-control" id="editAdvanceRefRemarks" name="REMARKS" rows="3"></textarea>
                            </div>
                        </div>

                    </div>


                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn customBtn">Submit</button>
                </div>
            </form>

        </div>
    </div>
</div>
