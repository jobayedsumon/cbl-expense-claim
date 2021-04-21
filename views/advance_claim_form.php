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

                    <div class="row" style="margin-bottom: 10px">
                        <div class="col-md-4 col-sm-4">
                            <label for="">Memo</label>
                            <select class="form-control" name="MEMO_NO" id="memoRefNo">
                                <option value="">Please select one</option>
                                <?php
                                if ($memo_references) {
                                    foreach ($memo_references as $memo) {
                                        ?>
                                        <option <?php echo $claim_information->claim->memo_no == $memo->memo_ref ? 'selected': ''; ?>
                                                value="<?php echo $memo->memo_ref; ?>">
                                            <?php echo $memo->memo_ref; ?>
                                        </option>
                                    <?php }} ?>
                            </select>
                        </div>
                    </div>

                    <input type="hidden" name="ATTACHMENT_FOR" value="7">
                    <input type="hidden" name="REQUEST_ID" value="<?php echo $claim_information->claim->exc_claim_requests_id; ?>">

                    <?php $this->load->view('common/attachment'); ?>

                    <?php $this->load->view('common/approval_person_remarks'); ?>

                    <div style="margin-top: 10px">
                        <input type="hidden" name="UPDATED_BY" class="employeeID" value="<?php echo $employee_information->employee_id ?>">
                        <button id="save" name="save" class="btn customBtn">Save</button>
                        <button id="sendForApproval" name="sendForApproval" class="btn customBtn" style="background-color: green">Send for Approval</button>
                    </div>

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