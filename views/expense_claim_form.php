<link rel="stylesheet" href="<?php echo base_url('application/modules/excs/css/excs_common.css') ?>">

<div class="panel panel-success">
    <div class="panel-heading">
        <h3 class="panel-title">Expense Claim Request</h3>
    </div>

    <div class="panel-body">

        <div class="container-fluid">

            <div class="row">

                <?php $this->load->view('common/on_behalf_information'); ?>

                <div class="col-md-9 col-sm-9">

                    <?php $this->load->view('common/currency_exchange_rate'); ?>

                    <div class="tableHeading">
                        <h3 class="panel-title-secondary">Claim Details</h3>
                        <a class="btn customBtn"  data-toggle="modal" data-target="#expenseClaimModal">Add</a>

                    </div>
                    <table id="expenseDetailsTable" class="table table-bordered table-condensed table-hover table-striped">
                        <thead >
                        <tr>
                            <th>SL</th>
                            <th>Expense Date</th>
                            <th>Purpose</th>
                            <th>Project</th>
                            <th>Unit Rate</th>
                            <th>Quantity</th>
                            <th>Amount (<span class="currencyCodeText">BDT</span>)</th>
                            <th class="bdtInfo">Amount (BDT)</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>

                        <?php if (isset($claim_information->claim->details)) {
                            foreach ($claim_information->claim->details as $index => $claim_details) {
                                $lineItem = $index+1;
                                ?>
                        <tr class="tableLineItem" id="tableLineItemID<?php echo $lineItem; ?>">
                            <td class="tableSerial">
                                <a data-toggle="collapse" data-target="#lineItem<?php echo $lineItem; ?>" class="accordion-toggle collapsed" aria-expanded="false">
                                    <i class="more-less glyphicon glyphicon-plus"></i> <?php echo $lineItem; ?></a>
                            </td>
                            <td class="tableExpenseDate"><?php echo $claim_details->expense_date; ?></td>
                            <td class="tablePurposeTitle"><?php echo $claim_details->product_name; ?></td>
                            <td class="tableProjectName"><?php echo $claim_details->project_name; ?></td>
                            <td class="text-right tableRate"><?php echo number_format($claim_details->rate, 2, '.', ''); ?></td>
                            <td class="text-right tableQuantity"><?php echo $claim_details->qty; ?></td>
                            <td class="text-right lineTotal"><?php echo number_format($claim_details->line_total, 2, '.', ''); ?></td>
                            <td class="text-right lineTotalBDT bdtInfo"><?php echo number_format($claim_details->line_total_bdt, 2, '.', ''); ?></td>
                            <td class="text-center">
                                <a data-id="<?php echo $claim_details->exc_claim_details_id; ?>" data-line-item="<?php echo $lineItem; ?>" data-total-amount="<?php echo $claim_details->line_total_bdt; ?>" class="btn customBtn ccButton">CC</a>
                                <a data-id="<?php echo $claim_details->exc_claim_details_id; ?>" data-serial="<?php echo $lineItem; ?>" data-purpose-details="<?php echo $claim_details->product_details; ?>" class="fa fa-edit text-success editExpense"></a>
                                <a data-id="<?php echo $claim_details->exc_claim_details_id; ?>" class="fa fa-times text-danger deleteExpense"></a>
                            </td>

                        </tr>

                                <tr>
                                    <td colspan="9" class="hiddenRow">
                                        <div class="secondaryTable accordian-body collapse" id="lineItem<?php echo $lineItem; ?>"
                                             aria-expanded="false" style="">
                                            <table id="ccAllocationNestedTable<?php echo $lineItem; ?>"
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


                                                <?php if (isset($claim_details->cca)) {
                                                    foreach ($claim_details->cca as $indexInner => $cca) {
                                                        ?>
                                                        <tr>
                                                            <td><?php echo $indexInner+1; ?></td>
                                                            <td><?php echo $cca->sol_name; ?></td>
                                                            <td><?php echo $cca->cost_center_name; ?></td>
                                                            <td class="text-right"><?php echo number_format($cca->allocation_ratio, 2, '.', ''); ?></td>
                                                            <td class="text-right"><?php echo number_format($cca->budget_allocated, 2, '.', ''); ?></td>
                                                            <td class="text-right"><?php echo number_format($cca->actual+$cca->in_transit, 2, '.', ''); ?></td>
                                                            <td class="text-right"><?php echo number_format($cca->allocation_amount, 2, '.', ''); ?></td>
                                                            <td class="text-center">
                                                                <a data-id="<?php echo $cca->exc_cc_allocations_id; ?>"
                                                                   data-line-item="<?php echo $lineItem; ?>"
                                                                   data-serial="<?php echo $indexInner+1; ?>"
                                                                   data-details-id="<?php echo $cca->exc_claim_details_id; ?>"
                                                                   data-total-amount="<?php echo $claim_details->line_total_bdt; ?>"
                                                                   class="fa fa-edit text-success editCostCenter"></a>
                                                                <a data-id="<?php echo $cca->exc_cc_allocations_id; ?>"
                                                                   class="fa fa-times text-danger deleteCostCenter"></a>
                                                            </td>
                                                        </tr>

                                                    <?php }} ?>


                                                </tbody>
                                            </table>
                                        </div>
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
                            <th class="text-right bdtInfo">
                                <span class="grandTotalBDT"></span>
                            </th>
                            <th></th>
                        </tr>
                        </tfoot>
                    </table>

                    <div class="tableHeading">
                        <h3 class="panel-title-secondary">Advance Adjustment</h3>
                        <a class="btn customBtn"  data-toggle="modal" data-target="#advanceReferenceModal">Add</a>
                    </div>
                    <table id="advanceAdjustmentTable" class="table table-bordered table-condensed table-hover table-striped">
                        <thead >
                        <tr>
                            <th>SL</th>
                            <th>Advance Claim</th>
                            <th>Advance Amount</th>
                            <th>Adjusted Amount</th>
                            <th>Adjust Now</th>
                            <th>Remaining</th>
                            <th>Remarks</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php if (isset($claim_information->adjustments)) {
                            foreach ($claim_information->adjustments as $index => $adjustment) {

                                $remaining_amount = $adjustment->advance_amount - $adjustment->adjusted_amount;
                                ?>
                                <tr>
                                    <td class="tableSerial"><?php echo $index+1; ?></td>
                                    <td class="tableClaimCode"><?php echo $adjustment->claim_code; ?></td>
                                    <td class="text-right tableAdvanceAmount"><?php echo number_format($adjustment->advance_amount, 2, '.', ''); ?></td
                                    ><td class="text-right tableAdjustedAmount"><?php echo number_format($adjustment->adjusted_amount, 2, '.', ''); ?></td>
                                    <td class="text-right tableAdjustAmount"><?php echo number_format($adjustment->adjust_amount, 2, '.', ''); ?></td>
                                    <td class="text-right tableRemainingAmount"><?php echo number_format($remaining_amount, 2, '.', ''); ?></td>
                                    <td class="tableRemarks"><?php echo $adjustment->remarks; ?></td>
                                    <td class="text-center">
                                        <a data-id="<?php echo $adjustment->exc_advance_adjustments_id; ?>" class="editAdjustment fa fa-edit text-success"></a>
                                        <a data-id="<?php echo $adjustment->exc_advance_adjustments_id; ?>" class="deleteAdjustment fa fa-times text-danger"></a>
                                    </td>
                                </tr>

                            <?php }} ?>
                        </tbody>
                        <tfoot>
                        <tr>
                            <th class="text-center" colspan="4">
                                Total
                            </th>
                            <th class="text-right">
                                <span class="totalAdjustmentAmount"></span>
                            </th>
                            <th colspan="3"></th>
                        </tr>
                        </tfoot>
                    </table>

                    <?php $this->load->view('common/memo_attachment'); ?>

                    <?php $this->load->view('common/approval_person_submit'); ?>

                </div>


            </div>


        </div>
    </div>

</div>



<!-- Advacnce Reference Modal -->
<?php $this->load->view('modals/advance_reference_modal'); ?>

<!-- Edit Advacnce Reference Modal -->
<?php $this->load->view('modals/edit_advance_reference_modal'); ?>

<!-- Expense Claim Modal -->
<?php $this->load->view('modals/expense_claim_modal'); ?>

<!-- Edit Expense Claim Modal -->
<?php $this->load->view('modals/edit_expense_claim_modal'); ?>

<!-- COST CENTER Modal -->
<?php $this->load->view('modals/cost_center_modal'); ?>

<!--Edit COST CENTER Modal -->
<?php $this->load->view('modals/edit_cost_center_modal'); ?>


<script>
    var EXCS_URL = '<?php echo excs_url() ?>';
    var BASE_URL = '<?php echo base_url() ?>';
</script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/bootbox.js/5.5.2/bootbox.min.js"></script>

<script src="<?php echo base_url('application/modules/excs/js/excs_common.js') ?>"></script>

<script src="<?php echo base_url('application/modules/excs/js/expense_claim.js') ?>"></script>