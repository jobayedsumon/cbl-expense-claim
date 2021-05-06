<div class="modal fade" id="editTravelCostComponentModal" tabindex="-1" role="dialog" aria-labelledby="travelCostCompoenentModal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">

            <form autocomplete="off" id="editTravelCostComponentModalForm">
                <div class="modal-header">
                    <h5 class="modal-title panel title panel-title-secondary"
                        id="exampleModalLongTitle">Cost Component</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6 col-sm-6">
                            <div class="form-group">
                                <label for="exampleFormControlInput1">Expense Date</label>
                                <input type="date" data-date-format='yyyy-mm-dd'
                                       class="form-control" id="expenseDate" name="EXPENSE_DATE" required>
                            </div>

                        </div>
                        <div class="col-md-6 col-sm-6">
                            <div class="form-group">
                                <label for="exampleFormControlSelect1">Project</label>
                                <select class="form-control" id="project" name="PROJECT_ID">
                                    <option value="">Please Select One</option>
                                    <?php
                                    if ($projects) {
                                        foreach ($projects as $project) {
                                            ?>
                                            <option
                                                value="<?php echo $project->project_id; ?>">
                                                <?php echo $project->project_name; ?>
                                            </option>
                                        <?php }} ?>


                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="row flex flex-row" style="align-items: center">
                        <div class="col-md-6 col-sm-6">
                            <div class="form-group">
                                <label for="exampleFormControlSelect2">Purpose</label>
                                <select class="form-control" id="purpose" name="PRODUCT_ID" required>
                                    <option value="">Please Select One</option>
                                    <?php
                                    if ($purpose_list) {
                                        foreach ($purpose_list as $purpose) {
                                            ?>
                                            <option
                                                value="<?php echo $purpose->product_id; ?>">
                                                <?php echo $purpose->product_name; ?>
                                            </option>
                                        <?php }} ?>
                                </select>
                            </div>

                        </div>
                        <div class="col-md-6 col-sm-6">
                            <div class="form-group">
                                <label for="exampleFormControlTextarea1">Purpose Details</label>
                                <textarea maxlength="255" class="form-control" id="purposeDetails" name="PRODUCT_DETAILS" rows="3"></textarea>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 col-sm-6">
                            <div class="form-group">
                                <label for="exampleFormControlInput1">Quantity</label>
                                <input type="number" class="form-control editModalCalculation" min="1" value="1" id="quantity" name="QTY" required>
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-6">
                            <div class="form-group">
                                <label for="exampleFormControlInput1">Unit/Rate</label>
                                <input step=".01" type="number" class="form-control editModalCalculation" min="1.0" value="1.0" id="rate" name="RATE" required>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 col-sm-6">
                            <div class="form-group">
                                <label for="exampleFormControlInput1">Total Amount(<?php echo $travel_plan->plan->currency_code; ?>)</label>
                                <input type="number" readonly step="0.01" class="form-control" min="1.0" value="1.0" id="editTotalAmount">
                            </div>
                        </div>
                        <?php if ($travel_plan->plan->currency_code != 'BDT') { ?>
                            <div class="col-md-6 col-sm-6 bdtInfo">
                                <div class="form-group">
                                    <label for="exampleFormControlInput1">Total Amount(BDT)</label>
                                    <input readonly type="number" step="0.01" class="form-control" min="1.0" value="1.0" id="editTotalAmountBDT">
                                </div>
                            </div>
                        <?php } ?>

                    </div>

                </div>
                <input type="hidden" id="costComponentId">
                <input type="hidden" name="EXC_TRAVEL_PLANS_ID" value="<?php echo $travel_plan->plan->exc_travel_plans_id; ?>">
                <input type="hidden" name="UPDATED_BY" value="<?php echo $this->user->EMPLOYEE_ID; ?>">
                <input type="hidden" class="exchangeRateInput" name="EXCHANGE_RATE" value="<?php echo $travel_plan->plan->exchange_rate; ?>">

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn customBtn">Submit</button>
                </div>
            </form>

        </div>
    </div>

</div>
