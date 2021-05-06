<div class="panel  <?php echo payments_panel_class(); ?> search" style="display: none;">
    <div class="panel-heading">
        Search
    </div>
    <div class="panel-body">
        <form id="" action="" method="post">

            <div class="row">

                <div class="col-md-3 col-sm-3">
                    <?php if ($title == 'Travel Plan List') { ?>

                        <div class="form-group">
                            <label for="claimStatus">Plan Status</label>
                            <select class="form-control" id="travelPlanStatus" name="TRAVEL_PLAN_STATUS">
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

                    <?php } else { ?>

                        <div class="form-group">
                            <label for="createdBy">Created By</label>
                            <select style="margin-bottom: 10px;" name="" id="createdBy">
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

                    <?php } ?>

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
                        <label for="claimCode">Plan Code</label>
                        <input type="text"
                               class="form-control" id="travelPlanCode" name="TRAVEL_PLAN_CODE">
                    </div>
                </div>

                <div class="col-md-3 col-sm-3">
                    <div class="form-group">
                        <label for="claimType">Date Type</label>
                        <select class="form-control" id="dateType" name="DATE_TYPE">
                            <option value="">Please Select One</option>
                            <option value="CREATED_AT">Created On</option>
                            <option value="POSSIBLE_TRAVEL_DATE">Travel Date</option>
                        </select>
                    </div>
                </div>


            </div>

            <div class="row">


                <div class="col-md-5 col-sm-5">
                    <div class="form-group">
                        <label id="dateRangeLabel" for="createdOn"></label>
                        <div class="input-daterange input-group" id="dateRange">
                            <input type="text" class="input-sm form-control" id="startDate" name="start" autocomplete="Off" />
                            <span class="input-group-addon">to</span>
                            <input type="text" class="input-sm form-control" id="endDate" name="end" autocomplete="Off" />
                        </div>
                    </div>
                </div>
                <input type="hidden" id="currentApprovalPerson" value="<?php echo $this->user->EMPLOYEE_ID; ?>">
                <input type="hidden" id="currentUser" value="<?php echo $employee_information->employee_id; ?>">
                <div class="col-md-2 col-sm-2" style="margin-top: 20px">
                    <button type="submit" id="search" class="btn btn-primary">Filter</button>
                </div>
            </div>

        </form>
    </div>
</div>

<script>
    $('#dateType').on('change', function () {
        if ($(this).val()) {
            $('#dateRangeLabel').text($('#dateType option:selected').text());
        } else {
            $('#dateRangeLabel').text('');
        }
    });
</script>