<div class="modal fade" id="editCostCenterModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title panel title panel-title-secondary"

                    id="exampleModalLongTitle">Update Cost Center Allocation</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form autocomplete="off" id="editCostCenterModalForm" method="POST" >
                <div class="modal-body">

                    <div id="costCenterAllocation">

                        <input type="hidden" value="" id="ccId">
                        <input type="hidden" value="" id="editCcSerial">
                        <input type="hidden" value="" id="ccLineItem">
                        <input type="hidden" value="" id="editTotalClaimAmount">
                        <input type="hidden" name="EXC_CLAIM_DETAILS_ID" value="" id="editCcDetailsId">
                        <input type="hidden" name="UPDATED_BY" value="<?php echo $this->user->EMPLOYEE_ID; ?>">

                        <div class="row">
                            <div class="form-group col-md-6 col-sm-6">
                                <label for="exampleFormControlSelect1">Cost Center</label>
                                <select class="form-control costCenter" id="editCcCode" name="COST_CENTER_CODE" required>
                                    <option value="">Please select one</option>
                                    <?php
                                    if ($cost_center_list) {
                                        foreach ($cost_center_list as $cost_center) {
                                            ?>
                                            <option
                                                value="<?php echo $cost_center->cost_center_code; ?>">
                                                <?php echo $cost_center->cost_center_name . ' (' . $cost_center->cost_center_code . ')'; ?>
                                            </option>
                                        <?php }} ?>
                                </select>
                            </div>
                            <div class="form-group col-md-6 col-sm-6">
                                <label for="exampleFormControlSelect1">SOL</label>
                                <select class="form-control sol" id="editSolCode" name="SOL_CODE" required>
                                    <option value="">Please select one</option>
                                    <?php
                                    if ($sol_list) {
                                        foreach ($sol_list as $sol) {
                                            ?>
                                            <option
                                                value="<?php echo $sol->sol_code; ?>">
                                                <?php echo $sol->sol_name . ' (' . $sol->sol_code . ')'; ?>
                                            </option>
                                        <?php }} ?>
                                </select>
                            </div>

                        </div>

                        <div class="row">
                            <div class="form-group col-md-6 col-sm-6">
                                <label for="exampleFormControlInput1">Allocation Ratio</label>
                                <input type="number" id="editAllocationRatio" step="0.01" class="form-control allocationRatio" min="1.0" value="100" name="ALLOCATION_RATIO" required>
                            </div>
                            <div class="form-group col-md-6 col-sm-6">
                                <label for="exampleFormControlInput1">Allocation Amount</label>
                                <input type="number" id="editAllocationAmount" step="0.01" class="form-control allocationAmount" min="1.0" value="1.0" name="ALLOCATION_AMOUNT" required>
                            </div>
                        </div>

                    </div>

                    <button type="submit" style="margin-bottom: 5px" class="btn customBtn pull-right">Update</button>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <!--                    <button type="submit" class="btn customBtn">Submit</button>-->
                </div>
            </form>

        </div>
    </div>
</div>
