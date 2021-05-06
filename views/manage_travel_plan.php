
<link rel="stylesheet" href="<?php echo base_url('application/modules/excs/css/excs_common.css') ?>">

<div class="container-fluid">
    <div style="text-align: right; margin-bottom: 5px;">
        <button title="Show/Hide Search Panel" type="button" class="btn btn-primary search_btn"><i class="fa fa-search"></i> Advance Search</button>
    </div>
    <div class="panel-group">

        <div class="panel  <?php echo payments_panel_class(); ?> search" style="display: none;">
            <div class="panel-heading">
                Search
            </div>
            <div class="panel-body">
                <form id="" action="" method="post">

                    <div class="row">

                        <div class="col-md-3 col-sm-3">
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

                        <div class="col-md-3 col-sm-3">
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

                    </div>

                    <div class="row">

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

                        <div class="col-md-5 col-sm-5">
                            <div class="form-group">
                                <label id="dateRangeLabel"></label>
                                <div class="input-daterange input-group" id="dateRange">
                                    <input type="text" class="input-sm form-control" id="startDate" name="start" autocomplete="Off" />
                                    <span class="input-group-addon">to</span>
                                    <input type="text" class="input-sm form-control" id="endDate" name="end" autocomplete="Off" />
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


        <div class="panel  <?php echo payments_panel_class(); ?>">
            <div class="panel-heading">
                <!--<h3 class="panel-title"><?php // echo $title; ?></h3>-->
                <span class="panel-title" style="font-size: small !important; "><b><?php echo $title; ?></b></span>
                <span class="pull-right">
                <button title="Manage selected plan's cost component" class="btn btn-primary management disabled" onclick="manage_cost_component()"><i class="fa fa-money"></i> Cost Component</button>
        <button title="Manage selected plan's passenger details"  class="btn btn-primary management disabled" onclick="manage_passenger_details()"><i class="fa fa-users"></i> Passenger Details</button>
        <button title="Change selected plan's approval person"  class="btn btn-danger management disabled" onclick="change_approval_persons()"><i class="fa fa-user-tie"></i> Change Approver</button>
        <button title="Reload Table" class="btn btn-default" onclick="reload_table()"><i class="fa fa-refresh"></i> Reload</button>
      </span>
            </div>
            <div class="panel-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped" id="my_table">
                        <thead>
                        <tr>
                            <th><input type="checkbox" id="chk_all_at_a_time" class="chk_all_at_a_time"></th>
                            <th>#</th>
                            <th>Plan Code</th>
                            <th>Date</th>
                            <th>On Behalf Of</th>
                            <th>Travel Date</th>
                            <th>Purpose</th>
                            <th>Projected Amount</th>
                            <th>Advance Amount</th>
                            <th>Total Person</th>
                            <th>Approval Status</th>
                            <th>Current Location</th>
                        </tr>
                        </thead>
                        <tbody>

                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>
</div>

<img src="img/loading.gif" id="loading_gif" style="display:none"/>

<script>
    var EXCS_URL = '<?php echo excs_url() ?>';
    var BASE_URL = '<?php echo base_url() ?>';
</script>

<script src="<?php echo base_url('application/modules/excs/js/manage_travel_plan.js') ?>"></script>
