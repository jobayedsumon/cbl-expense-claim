
<div class="row">
    <div class="col-md-6 col-sm-6">
        <div class="panel panel-danger">
            <div class="panel-heading">
                <h3 class="panel-title"><strong>Take action for this <?php echo isset($travel_plan) ? 'plan' : 'claim'; ?></strong></h3>
            </div>
            <div class="panel-body">
                <input type="hidden" id="currentApprovalPerson" value="<?php echo $this->user->EMPLOYEE_ID; ?>">
                <?php if (isset($claim_information)) { ?>
                    <input type="hidden" id="claimRequestId" value="<?php echo $claim_information->claim->exc_claim_requests_id; ?>">
                <?php } ?>
                <?php if (isset($travel_plan)) { ?>
                    <input type="hidden" id="travelPlanId" value="<?php echo $travel_plan->plan->exc_travel_plans_id; ?>">
                <?php } ?>
                <div class="row">
                    <div class="form-group" style="padding: 10px 15px">
                        <label for="exampleFormControlTextarea1">Comment</label>
                        <textarea maxlength="255" class="form-control" id="comments" name="COMMENTS" rows="3"></textarea>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 col-sm-6">
                        <button class="btn btn-success" onclick="<?php echo isset($claim_information) ? "claim_action('APPROVE')" : "travel_plan_action('APPROVE')"; ?>">APPROVE</button>
                        <button class="btn btn-danger" onclick="<?php echo isset($claim_information) ? "claim_action('RETURN')" : "travel_plan_action('RETURN')"; ?>">RETURN</button>
                        <button class="btn btn-warning" onclick="<?php echo isset($claim_information) ? "claim_action('HOLD')" : "travel_plan_action('HOLD')"; ?>">HOLD</button>
                    </div>

                </div>

            </div>
        </div>
    </div>
</div>
</div>