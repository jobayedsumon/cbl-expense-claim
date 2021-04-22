<link rel="stylesheet" href="<?php echo base_url('application/modules/excs/css/excs_common.css') ?>">


<div class="panel panel-success">
    <div class="panel-heading">
        <h3 class="panel-title">Manage Cost Component (<?php echo $travel_plan->plan->travel_plan_code; ?>)</h3>
    </div>

    <div class="panel-body">

        <div class="container-fluid">

            <div class="row">

                <a class="btn customBtn pull-right" style="margin-bottom: 10px" data-toggle="modal"
                   data-target="#travelCostComponentModal">Add</a>

                <table id="travelCostComponentTable"
                       class="table table-bordered table-condensed table-hover table-striped">
                    <thead>
                    <tr>
                        <th>SL</th>
                        <th>SOL</th>
                        <th>CC</th>
                        <th>Ratio(%)</th>
                        <th>Budget Allocated</th>
                        <th>Budget Utilized</th>
                        <th>Budget Request</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php if (isset($travel_plan->cca)) {
                        foreach ($travel_plan->cca as $index => $cca) {
                            ?>
                            <tr>
                                <td class="tableSerial"><?php echo $index + 1; ?></td>
                                <td><?php echo $cca->sol_name; ?></td>
                                <td><?php echo $cca->cost_center_name; ?></td>
                                <td class="text-right"><?php echo excs_amount($cca->allocation_ratio); ?></td>
                                <td class="text-right"><?php echo excs_amount($cca->budget_allocated); ?></td>
                                <td class="text-right"><?php echo excs_amount($cca->actual+$cca->in_transit); ?></td>
                                <td class="text-right"><?php echo excs_amount($cca->allocation_amount); ?></td>
                                <td class="text-center">
                                    <a data-id="<?php echo $cca->exc_tp_cc_allocations_id; ?>"
                                       class="fa fa-edit text-success editCostComponent"></a>
                                    <a data-id="<?php echo $cca->exc_tp_cc_allocations_id; ?>"
                                       class="fa fa-times text-danger deleteCostComponent"></a>
                                </td>
                            </tr>

                        <?php }
                    } ?>
                    </tbody>
                </table>

            </div>
        </div>
    </div>
</div>

<?php $this->load->view('modals/travel_cost_component_modal'); ?>
<?php //$this->load->view('modals/edit_travel_cost_component_modal'); ?>


<script>
    var EXCS_URL = '<?php echo excs_url() ?>';
    var BASE_URL = '<?php echo base_url() ?>';
</script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/bootbox.js/5.5.2/bootbox.min.js"></script>

<script src="<?php echo base_url('application/modules/excs/js/excs_common.js') ?>"></script>
<script src="<?php echo base_url('application/modules/excs/js/travel_plan.js') ?>"></script>
