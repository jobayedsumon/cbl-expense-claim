<link rel="stylesheet" href="<?php echo base_url('application/modules/excs/css/excs_common.css') ?>">

<?php
$status_color = 'text-warning';
if ($claim_information->claim->claim_status == '210') $status_color = 'text-success';
if ($claim_information->claim->claim_status == '203') $status_color = 'text-red';
?>

<div class="col-lg-12 no_padding" style="padding-top: 20px">

    <div class="row">
        <div class="col-lg-6">
            <div class="panel panel-success">
                <div class="panel-heading">
                    <h3 class="panel-title"><strong>Claim Information</strong></h3>
                </div>
                <div class="panel-body">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <tr>
                                <th>Claim ID </th>
                                <td><?php echo $claim_information->claim->exc_claim_requests_id; ?></td>
                            </tr>
                            <tr>
                                <th>Claim Code </th>
                                <td><?php echo $claim_information->claim->claim_code; ?></td>
                            </tr>
                            <tr>
                                <th>Claim Type </th>
                                <td><?php echo $claim_information->claim->exc_claim_type_name; ?></td>
                            </tr>

                            <tr>
                                <th>Created By </th>
                                <td><?php echo $claim_information->claim->created_by_name; ?></td>
                            </tr>

                            <tr>
                                <th>On Behalf of </th>
                                <td><?php echo $claim_information->claim->on_behalf_of; ?></td>
                            </tr>

                            <tr>
                                <th>Claim Status </th>
                                <td class="<?php echo $status_color ?>"><?php echo $claim_information->claim->status_name; ?></td>
                            </tr>

                            <tr>
                                <th>Claim Date </th>
                                <td><?php echo date('Y-m-d', strtotime($claim_information->claim->claim_date)); ?></td>
                            </tr>

                            <tr>
                                <th>Currency </th>
                                <td><?php echo $claim_information->claim->currency_code; ?></td>
                            </tr>

                            <tr>
                                <th>Exchange Rate </th>
                                <td><?php echo number_format($claim_information->claim->exchange_rate, 2, '.', ''); ?></td>
                            </tr>

                            <tr>
                                <th>Total Amount </th>
                                <td><?php echo number_format($claim_information->claim->total_amount, 2, '.', ''); ?></td>
                            </tr>

                            <tr>
                                <th>Total Amount(BDT) </th>
                                <td><?php echo number_format($claim_information->claim->total_amount_bdt, 2, '.', ''); ?></td>
                            </tr>

                            <tr>
                                <th>Memo </th>
                                <td><?php echo $claim_information->claim->memo_no; ?></td>
                            </tr>

                            <tr>
                                <th>Remarks </th>
                                <td><?php echo $claim_information->claim->remarks; ?></td>
                            </tr>


                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-3">
            <div class="panel panel-success">
                <div class="panel-heading">
                    <h3 class="panel-title"><strong>Employee Information</strong></h3>
                </div>
                <div class="panel-body">
                    <div class="table-responsive">
                        <table class="table table-bordered">

                            <tr>
                                <th>Employee ID </th>
                                <td><?php echo $claim_information->claim->employee_id; ?></td>
                            </tr>
                            <tr>
                                <th>Employee Name </th>
                                <td><?php echo $claim_information->claim->on_behalf_of; ?></td>
                            </tr>
                            <tr>
                                <th>Organization </th>
                                <td><?php echo $employee_information->organization; ?></td>
                            </tr>

                            <tr>
                                <th>Supervisor </th>
                                <td><?php echo $employee_information->supervisor_name; ?></td>
                            </tr>

                            <tr>
                                <th>SOL </th>
                                <td><?php echo $employee_information->sol_name; ?></td>
                            </tr>

                            <tr>
                                <th>Designation </th>
                                <td><?php echo $employee_information->designation_name; ?></td>
                            </tr>

                            <tr>
                                <th>Grade </th>
                                <td><?php echo $employee_information->grade; ?></td>
                            </tr>

                            <tr>
                                <th>CC </th>
                                <td><?php echo $employee_information->cost_center_name; ?></td>
                            </tr>

                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-3">
            <div class="panel panel-success">
                <div class="panel-heading">
                    <h3 class="panel-title"><strong>Accounts Information</strong></h3>
                </div>
                <div class="panel-body">
                    <div class="table-responsive">
                        <table class="table table-bordered">

                            <tr>
                                <th>Account Name </th>
                                <td><?php echo $employee_information->account_name; ?></td>
                            </tr>
                            <tr>
                                <th>Type of Transaction </th>
                                <td><?php echo $employee_information->transaction_type; ?></td>
                            </tr>
                            <tr>
                                <th>Bank </th>
                                <td><?php echo $employee_information->bank_name; ?></td>
                            </tr>

                            <tr>
                                <th>Account Number </th>
                                <td><?php echo $employee_information->account_number; ?></td>
                            </tr>

                            <tr>
                                <th>Routing Number </th>
                                <td><?php echo $employee_information->routing_number; ?></td>
                            </tr>

                            <tr>
                                <th>Branch </th>
                                <td><?php echo $employee_information->branch_name; ?></td>
                            </tr>

                        </table>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <div class="row">
        <?php //if (is_array($bill_attachments) && !empty($bill_attachments)) {?>
            <div class="col-lg-12">
                <?php //$this->load->view("payments/bills/bill_attachments_preview_panel"); ?>
            </div>
        <?php//}?>
        <?php //if (is_array($preview) && !empty($preview)) { ?>
        <div class="col-md-12">
            <div class="panel panel-success">
                <div class="panel-heading">
                    <h3 class="panel-title"><strong>Claim Details</strong></h3>
                </div>
                <div class="panel-body">
                    <div class="table-responsive">
                        <table id="expenseDetailsTable" class="table table-bordered table-condensed table-hover table-striped">
                            <thead >
                            <tr>
                                <th>SL</th>
                                <th>Expense Date</th>
                                <th>Purpose</th>
                                <th>Project</th>
                                <th>Unit Rate</th>
                                <th>Quantity</th>
                                <th>Amount</th>
                                <th>Amount (BDT)</th>
                            </tr>
                            </thead>
                            <tbody>

                            <?php if (isset($claim_information->claim->details)) {
                                foreach ($claim_information->claim->details as $index => $claim_details) {
                                    $lineItem = $index+1;
                                    ?>
                                    <tr class="tableLineItem" id="tableLineItemID<?php echo $lineItem; ?>">
                                        <td class="tableSerial">
                                            <?php if ($claim_information->claim->claim_type == 2) { ?>
                                            <a data-toggle="collapse" data-target="#lineItem<?php echo $lineItem; ?>" class="accordion-toggle collapsed" aria-expanded="false">
                                                <i class="more-less glyphicon glyphicon-plus"></i> </a>
                                            <?php } ?>

                                            <?php echo $lineItem; ?>
                                        </td>
                                        <td class="tableExpenseDate"><?php echo date('Y-m-d', strtotime($claim_details->expense_date)); ?></td>
                                        <td class="tablePurposeTitle"><?php echo $claim_details->product_name; ?></td>
                                        <td class="tableProjectName"><?php echo $claim_details->project_name; ?></td>
                                        <td class="text-right tableRate"><?php echo number_format($claim_details->rate, 2, '.', ''); ?></td>
                                        <td class="text-right tableQuantity"><?php echo $claim_details->qty; ?></td>
                                        <td class="text-right lineTotal"><?php echo number_format($claim_details->line_total, 2, '.', ''); ?></td>
                                        <td class="text-right lineTotalBDT"><?php echo number_format($claim_details->line_total_bdt, 2, '.', ''); ?></td>
                                    </tr>

                                    <?php if ($claim_information->claim->claim_type == 2) { ?>

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
                                                                    <td class="text-right"><?php echo number_format($cca->budget_utilized, 2, '.', ''); ?></td>
                                                                    <td class="text-right"><?php echo number_format($cca->allocation_amount, 2, '.', ''); ?></td>
                                                                </tr>

                                                            <?php }} ?>


                                                        </tbody>
                                                    </table>
                                                </div>
                                            </td>
                                        </tr>

                                    <?php } ?>



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
                                <th class="text-right">
                                    <span class="grandTotalBDT"></span>
                                </th>
                            </tr>
                            </tfoot>
                        </table>

                    </div>

                    <!--<a class="btn btn-primary" href="<?php // echo base_url("payment/get_all_bill_list"); ?>">Ready for Payment Approval Note</a>-->
                </div>
            </div>
        </div>
    </div>


    <?php if ($claim_information->claim->claim_type == 2) $this->load->view('claim_views/advance_adjustment_conditional'); ?>

    <div class="row">
        <div class="col-lg-6">
            <div class="panel panel-success">
                <div class="panel-heading">
                    <h3 class="panel-title"><strong>Approval Persons</strong></h3>
                </div>
                <div class="panel-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-condensed table-hover table-striped">
                            <thead >
                            <tr class="text-center">
                                <th>Sort No</th>
                                <th>Approval Person</th>
                                <th>Designation</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php if (isset($claim_information->approvers)) {
                                foreach ($claim_information->approvers as $approver) {
                                    if ($approver->approval_person == $this->user->EMPLOYEE_ID) $userIsApprover = true;
                                    ?>
                                    <tr>
                                        <td><?php echo $approver->sort_no; ?></td>
                                        <td class="approvalPersonName"><?php echo $approver->approval_person_name; ?></td>
                                        <td><?php echo $approver->designation_name; ?></td>
                                    </tr>

                                <?php }} ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-6">
            <div class="panel panel-success">
                <div class="panel-heading">
                    <h3 class="panel-title"><strong>Attachments</strong></h3>
                </div>
                <div class="panel-body">
                    <div class="table-responsive">
                        <table id="attachmentsTable" class="table table-bordered table-condensed table-hover table-striped">
                            <thead >
                            <tr>
                                <th>File Name</th>
                                <th>Download</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php if (isset($claim_information->attachments)) {
                                foreach ($claim_information->attachments as $index => $attachment) {
                                    ?>
                                    <tr>
                                        <td><?php echo $attachment->file_name; ?></td>
                                        <td>
                                            <a href="<?php echo excs_url().'/attachments/download?FILE_LOC='.$attachment->file_loc; ?>" class="fa fa-download text-success downloadAttachment"></a>
                                        </td>
                                    </tr>

                                <?php }} ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <?php if (in_array(100, $level)) $this->load->view('claim_views/change_approval_person_conditional'); ?>

    <?php if (isset($userIsApprover) && $userIsApprover) $this->load->view('claim_views/claim_action_conditional'); ?>

</div>

<script>
    var EXCS_URL = '<?php echo excs_url() ?>';
    var BASE_URL = '<?php echo base_url() ?>';
</script>

<script src="<?php echo base_url('application/modules/excs/js/view_claim.js') ?>"></script>
