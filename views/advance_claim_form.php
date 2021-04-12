<link rel="stylesheet" href="<?php echo base_url('application/modules/excs/css/excs_common.css') ?>">

<div class="panel panel-success">
    <div class="panel-heading">
        <h3 class="panel-title">Advance Claim Request</h3>
    </div>

    <div class="panel-body">

        <div class="container-fluid">
            <div class="row">

                <?php $this->load->view('common/on_behalf_information'); ?>

                <div class="col-md-9 col-sm-9">

                    <?php $this->load->view('common/currency_exchange_rate'); ?>

                    <div class="tableHeading">
                        <h3 class="panel-title-secondary">Claim Details</h3>
                        <a class="btn customBtn"  data-toggle="modal" data-target="#advanceClaimModal">Add</a>

                    </div>
                    <table id="advanceDetailsTable" class="table table-bordered table-condensed table-hover table-striped">
                        <thead>
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
                                ?>
                                <tr>
                                    <td class="tableSerial"><?php echo $index+1; ?></td>
                                    <td class="tableExpenseDate"><?php echo date('Y-m-d', strtotime($claim_details->expense_date)); ?></td>
                                    <td class="tablePurposeTitle"><?php echo $claim_details->product_name; ?></td>
                                    <td class="tableProjectName"><?php echo $claim_details->project_name; ?></td>
                                    <td class="text-right tableRate"><?php echo number_format($claim_details->rate, 2, '.', ''); ?></td>
                                    <td class="text-right tableQuantity"><?php echo $claim_details->qty; ?></td>
                                    <td class="text-right lineTotal"><?php echo number_format($claim_details->line_total, 2, '.', ''); ?></td>
                                    <td class="text-right lineTotalBDT bdtInfo"><?php echo number_format($claim_details->line_total_bdt, 2, '.', ''); ?></td>
                                    <td class="text-center">
                                        <a data-id="<?php echo $claim_details->exc_claim_details_id; ?>" data-serial="<?php echo $index+1; ?>" data-purpose-details="<?php echo $claim_details->product_details; ?>" class="fa fa-edit text-success editAdvanceDetail"></a>
                                        <a data-id="<?php echo $claim_details->exc_claim_details_id; ?>" class="fa fa-times text-danger deleteAdvanceDetail"></a>
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

                    <?php $this->load->view('common/memo_attachment'); ?>

                    <?php $this->load->view('common/approval_person_submit'); ?>

                </div>
            </div>
        </div>
    </div>
</div>

<!-- Advance Claim Modal -->
<?php $this->load->view('modals/advance_claim_modal'); ?>

<!-- Edit Advance Claim Modal -->
<?php $this->load->view('modals/edit_advance_claim_modal'); ?>

<script>
    var EXCS_URL = '<?php echo excs_url() ?>';
    var BASE_URL = '<?php echo base_url() ?>';
</script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/bootbox.js/5.5.2/bootbox.min.js"></script>

<script src="<?php echo base_url('application/modules/excs/js/excs_common.js') ?>"></script>

<script src="<?php echo base_url('application/modules/excs/js/advance_claim.js') ?>"></script>