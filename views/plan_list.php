
<link rel="stylesheet" href="<?php echo base_url('application/modules/excs/css/excs_common.css') ?>">

<div class="container-fluid">
    <div style="text-align: right; margin-bottom: 5px;">
        <!-- <a class="btn btn-info" title="View" id="common_view_btn" target="_blank" href="" style="display: none;"><i class="fa fa-eye"></i>View</a>
        <a class="btn btn-success" title="Edit" id="common_edit_btn" target="_blank" href="" style="display: none;"><i class="fa fa-pencil"></i>Edit</a> -->


        <button title="Show/Hide Search Panel" type="button" class="btn btn-primary search_btn"><i class="fa fa-search"></i> Advance Search</button>
    </div>
    <div class="panel-group">

        <?php $this->load->view('common/travel_filter'); ?>

        <div class="panel  <?php echo payments_panel_class(); ?>">
            <div class="panel-heading">
                <!--<h3 class="panel-title"><?php // echo $title; ?></h3>-->
                <span class="panel-title" style="font-size: small !important; "><b><?php echo $title; ?></b></span>
                <span class="pull-right">
                    <button title="Manage selected plan's cost component" class="btn btn-primary management disabled" onclick="manage_cost_component()"><i class="fa fa-money"></i> Cost Component</button>
        <button title="Manage selected plan's passenger details"  class="btn btn-primary management disabled" onclick="manage_passenger_details()"><i class="fa fa-users"></i> Passenger Details</button>
        <button title="Claim expense for this travel plan" class="btn btn-primary management disabled" onclick="claim_expense()"><i class="fa fa-credit-card"></i> Claim Expense</button>
        <button title="View Selected Plan" id="view" class="btn btn-primary disabled" onclick="view_plan()">View</button>
        <button title="Edit Selected Plan" id="edit" class="btn btn-info on_condition disabled" onclick="edit_plan()">Edit</button>
        <button title="Delete Selected Plan" id="delete" class="btn btn-danger on_condition disabled" onclick="delete_plan()">Delete</button>
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

<script src="<?php echo base_url('application/modules/excs/js/plan_list.js') ?>"></script>
