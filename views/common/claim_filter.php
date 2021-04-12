<div class="panel  <?php echo payments_panel_class(); ?> search" style="display: none;">
    <div class="panel-heading">
        Search
    </div>
    <div class="panel-body">
        <form id="" action="" method="post">

            <input type="hidden" id="currentUser" value="<?php echo $employee_information->employee_id; ?>">

            <div class="row">
                <div class="col-md-3 col-sm-3">
                    <div class="form-group">
                        <label for="claimType">Claim Type</label>
                        <select class="form-control" id="claimType" name="CLAIM_TYPE">
                            <option value="">Please Select One</option>
                            <option value="1">Advance Claim</option>
                            <option value="2">Expense Claim</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-3 col-sm-3">
                    <div class="form-group">
                        <label for="claimStatus">Claim Status</label>
                        <select class="form-control" id="claimStatus" name="CLAIM_STATUS">
                            <option value="">Please Select One</option>
                            <?php
                            if ($statuses) {
                                foreach ($statuses as $status) {

                                    ?>
                                    <option
                                        value="<?php echo $status->status_id; ?>">
                                        <?php echo $status->status_name; ?>
                                    </option>
                                <?php }} ?>
                        </select>
                    </div>
                </div>
                <div class="col-md-3 col-sm-3">
                    <label for="onBehalfOfFilter">On Behalf Of</label>
                    <select style="margin-bottom: 10px;" name="" id="onBehalfOfFilter">
                        <option value="">Please select one</option>
                        <?php
                        if ($employee_list) {
                            foreach ($employee_list as $employee) {
                                ?>
                                <option
                                    value="<?php echo $employee->employee_id; ?>">
                                    <?php echo $employee->employee_name; ?>
                                </option>
                            <?php }} ?>

                    </select>
                </div>
                <div class="col-md-3 col-sm-3">
                    <div class="form-group">
                        <label for="claimDate">Claim Date</label>
                        <input type="text"
                               class="form-control" id="claimDate" name="CLAIM_DATE">
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-3 col-sm-3">
                    <div class="form-group">
                        <label for="claimCode">Claim Code</label>
                        <input type="text"
                               class="form-control" id="claimCode" name="CLAIM_CODE">
                    </div>
                </div>
                <div class="col-md-4 col-sm-4">
                    <div class="form-group">
                        <label for="createdOn">Created On</label>
                        <div class="input-daterange input-group" id="createdOn">
                            <input type="text" class="input-sm form-control" id="startDate" name="start" />
                            <span class="input-group-addon">to</span>
                            <input type="text" class="input-sm form-control" id="endDate" name="end" />
                        </div>
                    </div>
                </div>
                <div class="col-md-2 col-sm-2" style="margin-top: 20px">
                    <button type="submit" id="search" class="btn btn-primary">Filter</button>
                </div>
            </div>

        </form>
    </div>
</div>