<div class="row">
    <div class="col-md-12">
        <div class="panel panel-success">
            <div class="panel-heading">
                <h3 class="panel-title"><strong>Advance Adjustments</strong></h3>
            </div>
            <div class="panel-body">
                <div class="table-responsive">
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

                </div>
                <!--<a class="btn btn-primary" href="<?php // echo base_url("payment/get_all_bill_list"); ?>">Ready for Payment Approval Note</a>-->
            </div>
        </div>
    </div>
</div>