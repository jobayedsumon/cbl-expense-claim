<link rel="stylesheet" href="<?php echo base_url('application/modules/excs/css/excs_common.css') ?>">


<div class="panel panel-success">
    <div class="panel-heading">
        <h3 class="panel-title">Manage Cost Component (<?php echo $travel_plan->plan->travel_plan_code; ?>)</h3>
    </div>

    <div class="panel-body">

        <div class="container-fluid">
            <a class="btn customBtn pull-right" data-toggle="modal" data-target="#travelCostComponentModal">Add</a>
            <table id="travelCostComponentTable" class="table table-bordered table-condensed table-hover table-striped">
                <thead >
                <tr>
                    <th>SL</th>
                    <th>Expense Date</th>
                    <th>Purpose</th>
                    <th>Project</th>
                    <th>Unit Rate</th>
                    <th>Quantity</th>
                    <th>Amount (<?php echo $travel_plan->plan->currency_code; ?>)</th>
                    <?php if ($travel_plan->plan->currency_code != 'BDT') { ?>
                        <th>Amount (BDT)</th>
                   <?php } ?>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>

                <?php if (isset($travel_plan->plan_details)) {
                    foreach ($travel_plan->plan_details as $index => $plan_details) { ?>
                        <tr>
                            <td><?php echo $index+1; ?></td>
                            <td><?php echo apsis_date($plan_details->expense_date); ?></td>
                            <td><?php echo $plan_details->product_name; ?></td>
                            <td ><?php echo $plan_details->project_name; ?></td>
                            <td class="text-right"><?php echo excs_amount($plan_details->rate); ?></td>
                            <td class="text-right"><?php echo $plan_details->qty; ?></td>
                            <td class="text-right lineTotal"><?php echo excs_amount($plan_details->line_total); ?></td>
                            <?php if ($travel_plan->plan->currency_code != 'BDT') { ?>
                                <td class="text-right lineTotalBDT"><?php echo excs_amount($plan_details->line_total_bdt); ?></td>
                            <?php } ?>
                            <td class="text-center">
                                <a data-id="<?php echo $plan_details->exc_travel_details_id; ?>" class="fa fa-edit text-success editCostComponent"></a>
                                <a data-id="<?php echo $plan_details->exc_travel_details_id; ?>" class="fa fa-times text-danger deleteCostComponent"></a>
                            </td>

                        </tr>

                    <?php }} ?>




                </tbody>
                <tfoot>
                <tr>
                    <th class="text-center" colspan="6">
                        Total
                    </th>
                    <th class="text-right">
                        <span class="grandTotal"></span>
                    </th>
                    <?php if ($travel_plan->plan->currency_code != 'BDT') { ?>
                        <th class="text-right bdtInfo">
                            <span class="grandTotalBDT"></span>
                        </th>
                    <?php } ?>

                    <th></th>
                </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>

<?php $this->load->view('modals/travel_cost_component_modal'); ?>
<?php $this->load->view('modals/edit_travel_cost_component_modal'); ?>


<script>
    var EXCS_URL = '<?php echo excs_url() ?>';
    var BASE_URL = '<?php echo base_url() ?>';
</script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/bootbox.js/5.5.2/bootbox.min.js"></script>

<script src="<?php echo base_url('application/modules/excs/js/excs_common.js') ?>"></script>
<script src="<?php echo base_url('application/modules/excs/js/travel_plan.js') ?>"></script>
