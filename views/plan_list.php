
<link rel="stylesheet" href="<?php echo base_url('application/modules/excs/css/excs_common.css') ?>">

<div class="container-fluid">
    <div style="text-align: right; margin-bottom: 5px;">
        <!-- <a class="btn btn-info" title="View" id="common_view_btn" target="_blank" href="" style="display: none;"><i class="fa fa-eye"></i>View</a>
        <a class="btn btn-success" title="Edit" id="common_edit_btn" target="_blank" href="" style="display: none;"><i class="fa fa-pencil"></i>Edit</a> -->
        <button title="Manage selected plan's cost component" class="btn btn-primary on_condition disabled" onclick="manage_cost_component()"><i class="fa fa-money"></i> Manage Cost Component</button>
        <button title="Manage selected plan's passenger details"  class="btn btn-primary on_condition disabled" onclick="manage_passenger_details()"><i class="fa fa-users"></i> Manage Passenger Details</button>

        <button title="Show/Hide Search Panel" type="button" class="btn btn-primary search_btn"><i class="fa fa-search"></i> Advance Search</button>
    </div>
    <div class="panel-group">

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
                                <label for="createdOn">Date Range</label>
                                <div class="input-daterange input-group" id="dateRange">
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


        <div class="panel  <?php echo payments_panel_class(); ?>">
            <div class="panel-heading">
                <!--<h3 class="panel-title"><?php // echo $title; ?></h3>-->
                <span class="panel-title" style="font-size: small !important; "><b><?php echo $title; ?></b></span>
                <span class="pull-right">
<!--        <button title="Clone Selected Bill" id="clone" class="btn btn-success disabled" onclick="clone_claim()">Replica</button>-->
        <button title="View Selected Claim" id="view" class="btn btn-primary disabled" onclick="view_plan()">View</button>
        <button title="Edit Selected Claim" id="edit" class="btn btn-info on_condition disabled" onclick="edit_plan()">Edit</button>
        <button title="Delete Selected Claim" id="delete" class="btn btn-danger on_condition disabled" onclick="delete_plan()">Delete</button>
        <button title="Reload Table" class="btn btn-default" onclick="reload_table()"><i class="fa fa-refresh"></i> Reload</button>
      </span>
            </div>
            <div class="panel-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped" id="my_table">
                        <thead>
                        <tr>
                            <th class="text-center"><input type="checkbox" id="chk_all_at_a_time" class="chk_all_at_a_time"></th>
                            <th class="text-center">#</th>
                            <th class="text-center">Plan Code</th>
                            <th class="text-center">Date</th>
                            <th class="text-center">On Behalf Of</th>
                            <th class="text-center">Travel Date</th>
                            <th class="text-center">Purpose</th>
                            <th class="text-center">Projected Amount</th>
                            <th class="text-center">Advance Amount</th>
                            <th class="text-center">Total Persons</th>
                            <th class="text-center">Approval Status</th>
                            <th class="text-center">Current Location</th>
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

<script src="<?php echo base_url('application/modules/excs/js/plan_list.js') ?>"></script>
