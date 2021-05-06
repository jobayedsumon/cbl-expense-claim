
<link rel="stylesheet" href="<?php echo base_url('application/modules/excs/css/excs_common.css') ?>">

<div class="container-fluid">
    <div style="text-align: right; margin-bottom: 5px;">
        <!-- <a class="btn btn-info" title="View" id="common_view_btn" target="_blank" href="" style="display: none;"><i class="fa fa-eye"></i>View</a>
        <a class="btn btn-success" title="Edit" id="common_edit_btn" target="_blank" href="" style="display: none;"><i class="fa fa-pencil"></i>Edit</a> -->
        <a title="Create New Advance" href="<?php echo base_url("excs/advance_claim"); ?>" class="btn btn-primary"><i class="fa fa-plus"></i>Create Advance</a>
        <a title="Create New Expense" href="<?php echo base_url("excs/expense_claim"); ?>" class="btn btn-primary"><i class="fa fa-plus"></i>Create Expense</a>

        <button title="Show/Hide Search Panel" type="button" class="btn btn-primary search_btn"><i class="fa fa-search"></i> Advance Search</button>
    </div>
    <div class="panel-group">

        <?php echo $this->load->view('common/claim_filter'); ?>


        <div class="panel  <?php echo payments_panel_class(); ?>">
            <div class="panel-heading">
                <!--<h3 class="panel-title"><?php // echo $title; ?></h3>-->
                <span class="panel-title" style="font-size: small !important; "><b><?php echo $title; ?></b></span>
                <span class="pull-right">
<!--        <button title="Clone Selected Bill" id="clone" class="btn btn-success disabled" onclick="clone_claim()">Replica</button>-->
        <button title="View Selected Claim" id="view" class="btn btn-primary disabled" onclick="view_claim()">View</button>
        <button title="Edit Selected Claim" id="edit" class="btn btn-info on_condition disabled" onclick="edit_claim()">Edit</button>
        <button title="Delete Selected Claim" id="delete" class="btn btn-danger on_condition disabled" onclick="delete_claim()">Delete</button>
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
                            <th>Claim Code</th>
                            <th>Claim Date</th>
                            <th>Claim Type</th>
                            <th>Claim Amount</th>
                            <th>Claim Amount(BDT)</th>
                            <th>Created At</th>
                            <th>Created  By</th>
                            <th>On Behalf of</th>
                            <th>Current Location</th>
                            <th>Status</th>
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

<script src="<?php echo base_url('application/modules/excs/js/claim_list.js') ?>"></script>
