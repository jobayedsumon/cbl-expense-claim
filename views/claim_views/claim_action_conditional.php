<div class="row">
    <div class="col-md-6 col-sm-6">
        <div class="panel panel-danger">
            <div class="panel-heading">
                <h3 class="panel-title"><strong>Take action for this claim</strong></h3>
            </div>
            <div class="panel-body">
                <input type="hidden" id="currentApprovalPerson" value="<?php echo $this->user->EMPLOYEE_ID; ?>">
                <input type="hidden" id="claimRequestId" value="<?php echo $claim_information->claim->exc_claim_requests_id; ?>">
                <div class="row">
                    <div class="form-group" style="padding: 10px 15px">
                        <label for="exampleFormControlTextarea1">Comment</label>
                        <textarea maxlength="255" class="form-control" id="comments" name="COMMENTS" rows="3"></textarea>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 col-sm-6">
                        <button class="btn btn-success" onclick="claim_action('APPROVE')">APPROVE</button>
                        <button class="btn btn-danger" onclick="claim_action('RETURN')">RETURN</button>
                        <button class="btn btn-warning" onclick="claim_action('HOLD')">HOLD</button>
                    </div>

                </div>

            </div>
        </div>
    </div>
</div>
</div>