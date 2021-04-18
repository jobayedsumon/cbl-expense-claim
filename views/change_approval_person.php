<link rel="stylesheet" href="<?php echo base_url('application/modules/excs/css/excs_common.css') ?>">

<div class="container-fluid">
    <div style="text-align: right; margin-bottom: 5px;">
        <!-- <a class="btn btn-info" title="View" id="common_view_btn" target="_blank" href="" style="display: none;"><i class="fa fa-eye"></i>View</a>
        <a class="btn btn-success" title="Edit" id="common_edit_btn" target="_blank" href="" style="display: none;"><i class="fa fa-pencil"></i>Edit</a> -->

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
        <button title="Change Approval Person" id="view" class="btn btn-primary disabled" onclick="view_claim()">Change</button>
        <button title="Reload Table" class="btn btn-default" onclick="reload_table()"><i class="fa fa-refresh"></i> Reload</button>
      </span>
                <input type="hidden" id="currentApprovalPerson" value="<?php echo $this->user->EMPLOYEE_ID; ?>">
            </div>
            <div class="panel-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped" id="my_table">
                        <thead>
                        <tr>
                            <th class="text-center"><input type="checkbox" id="chk_all_at_a_time" class="chk_all_at_a_time"></th>
                            <th class="text-center">#</th>
                            <th>Claim Code</th>
                            <th>Claim Date</th>
                            <th>Claim Type</th>
                            <th>Claim Amount</th>
                            <th>Claim Amount(BDT)</th>
                            <th>Created At</th>
                            <th>Created  By</th>
                            <th>On Behalf of</th>
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

<script src="<?php echo base_url('application/modules/excs/js/change_approval_person.js') ?>"></script>