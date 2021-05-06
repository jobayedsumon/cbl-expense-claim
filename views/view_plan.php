<link rel="stylesheet" href="<?php echo base_url('application/modules/excs/css/excs_common.css') ?>">

<?php
$status_color = 'text-warning';
if ($travel_plan->plan->travel_plan_status == '210') $status_color = 'text-success';
if ($travel_plan->plan->travel_plan_status == '203') $status_color = 'text-red';
?>

<div class="col-lg-12 no_padding" style="padding-top: 20px">

    <div class="row">
        <div class="col-lg-5">
            <div class="panel panel-success">
                <div class="panel-heading">
                    <h3 class="panel-title"><strong style="font-size: 16px !important;">Travel Plan Information</strong></h3>
                </div>
                <div class="panel-body">
                    <div class="table-responsive">
                        <table class="table table-bordered">
<!--                            <tr>-->
<!--                                <th>Travel Plan ID </th>-->
<!--                                <td>--><?php //echo $travel_plan->plan->exc_travel_plans_id; ?><!--</td>-->
<!--                            </tr>-->
                            <tr>
                                <th>Travel Plan Code </th>
                                <td><?php echo $travel_plan->plan->travel_plan_code; ?></td>
                            </tr>
                            <tr>
                                <th>Created By </th>
                                <td><?php echo $travel_plan->plan->created_by_name; ?></td>
                            </tr>

                            <tr>
                                <th>Created At </th>
                                <td><?php echo $travel_plan->plan->created_at; ?></td>
                            </tr>

                            <tr>
                                <th>On Behalf of </th>
                                <td><?php echo $travel_plan->plan->on_behalf_of; ?></td>
                            </tr>

                            <tr>
                                <th>Travel Plan Status </th>
                                <td class="<?php echo $status_color ?>"><strong><?php echo $travel_plan->plan->status_name; ?></strong></td>
                            </tr>

                            <tr>
                                <th>Possible Travel Date </th>
                                <td><?php echo apsis_date($travel_plan->plan->possible_travel_date); ?></td>
                            </tr>

                            <tr>
                                <th>Total Person</th>
                                <td><?php echo $travel_plan->plan->pax_adult+$travel_plan->plan->pax_child+$travel_plan->plan->pax_infant; ?></td>
                            </tr>

                            <tr>
                                <th>Travel Area </th>
                                <td><?php echo $travel_plan->plan->travel_area; ?></td>
                            </tr>

                            <tr>
                                <th>Travel Mode </th>
                                <td><?php echo $travel_plan->plan->travel_mode; ?></td>
                            </tr>

                            <tr>
                                <th>Visited Country </th>
                                <td><?php echo ucwords($travel_plan->plan->country_to_visited, ','); ?></td>
                            </tr>

                            <tr>
                                <th>Visited City </th>
                                <td><?php echo $travel_plan->plan->city_to_visited; ?></td>
                            </tr>

                            <tr>
                                <th>Employee Purchase Ticket? </th>
                                <td><?php echo $travel_plan->plan->employee_purchase_tkt ? 'Yes' : 'No'; ?></td>
                            </tr>

                            <tr>
                                <th>Insurance Applicable? </th>
                                <td><?php echo $travel_plan->plan->insurance_applicable ? 'Yes' : 'No'; ?></td>
                            </tr>

                            <tr>
                                <th>Departure Date </th>
                                <td><?php echo apsis_date($travel_plan->plan->departure_date); ?></td>
                            </tr>

                            <tr>
                                <th>Hotel Address </th>
                                <td><?php echo $travel_plan->plan->hotel_address; ?></td>
                            </tr>

                            <tr>
                                <th>Return Date </th>
                                <td><?php echo apsis_date($travel_plan->plan->return_date); ?></td>
                            </tr>

                            <tr>
                                <th>Currency </th>
                                <td><?php echo $travel_plan->plan->currency_code; ?></td>
                            </tr>

                            <tr>
                                <th>Exchange Rate </th>
                                <td><?php echo excs_amount($travel_plan->plan->exchange_rate); ?></td>
                            </tr>

                            <tr>
                                <th>Projected Amount </th>
                                <td><?php echo excs_amount($travel_plan->plan->projected_amount); ?></td>
                            </tr>

                            <?php if ($travel_plan->plan->currency_code != 'BDT') { ?>
                                <tr>
                                    <th>Projected Amount (BDT) </th>
                                    <td><?php echo excs_amount($travel_plan->plan->projected_amount_bdt); ?></td>
                                </tr>
                            <?php } ?>

                            <tr>
                                <th>Advance Amount </th>
                                <td><?php echo excs_amount($travel_plan->plan->advance_amount); ?></td>
                            </tr>

                            <tr>
                                <th>Submission Date </th>
                                <td><?php echo apsis_date($travel_plan->plan->submission_date); ?></td>
                            </tr>

                            <tr>
                                <th>Remarks </th>
                                <td><?php echo $travel_plan->plan->remarks; ?></td>
                            </tr>


                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="panel panel-success">
                <div class="panel-heading">
                    <h3 class="panel-title"><strong>Employee Information</strong></h3>
                </div>
                <div class="panel-body">
                    <div class="table-responsive">
                        <table class="table table-bordered">

                            <tr>
                                <th>Employee ID </th>
                                <td><?php echo $employee_information->employee_id; ?></td>
                            </tr>
                            <tr>
                                <th>Employee Name </th>
                                <td><?php echo $employee_information->employee_name; ?></td>
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
                                <td style="width: 50%"><?php echo $employee_information->account_name; ?></td>
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
        <div class="col-lg-6">
            <div class="panel panel-success">
                <div class="panel-heading">
                    <h3 class="panel-title"><strong>Passenger Details</strong></h3>
                </div>
                <div class="panel-body">
                    <div class="table-responsive">
                        <table id="travelPassengersTable"
                               class="table table-bordered table-condensed table-hover table-striped">
                            <thead>
                            <tr>
                                <th>SL</th>
                                <th>Passenger Name</th>
                                <th>Passenger Type</th>
                                <th>Date Of Barth</th>
                                <th>Passport No.</th>
                                <th>Passport Expiry Date</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php if (isset($travel_plan->passengers)) {
                                foreach ($travel_plan->passengers as $index => $passenger) {
                                    if ($passenger->passenger_type == 'ADT') $passenger_type = 'Adult';
                                    else if ($passenger->passenger_type == 'CHD') $passenger_type = 'Child';
                                    else if ($passenger->passenger_type == 'INF') $passenger_type = 'Infant';
                                    else $passenger_type = 'N/A';
                                    ?>
                                    <tr>
                                        <td class="tableSerial"><?php echo $index + 1; ?></td>
                                        <td><?php echo $passenger->passenger_name; ?></td>
                                        <td><?php echo $passenger_type; ?></td>
                                        <td><?php echo apsis_date($passenger->dob); ?></td>
                                        <td><?php echo $passenger->passport_no; ?></td>
                                        <td><?php echo apsis_date($passenger->passport_exp_date); ?></td>
                                    </tr>

                                <?php }
                            } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-6">
            <div class="panel panel-success">
                <div class="panel-heading">
                    <h3 class="panel-title"><strong>Cost Component</strong></h3>
                </div>
                <div class="panel-body">
                    <div class="table-responsive">
                        <table id="travelCcAllocationTable"
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
                                    </tr>

                                <?php }
                            } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <div class="row">
        <div class="col-lg-6">
            <div class="panel panel-success">
                <div class="panel-heading">
                    <h3 class="panel-title"><strong>Approval Person</strong></h3>
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
                            <?php if (isset($travel_plan->approval_persons)) {
                                foreach ($travel_plan->approval_persons as $index => $approver) {
                                    if ($approver->approval_person == $this->user->EMPLOYEE_ID && $approver->approval_action == 'Active' && $approver->approval_status == null) $userIsApprover = true;
                                    ?>
                                    <tr>
                                        <td><?php echo $index+1; ?></td>
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
                            <?php if (isset($travel_plan->attachments)) {
                                foreach ($travel_plan->attachments as $index => $attachment) {
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

    <?php if (in_array(100, $level) && $admin_view) $this->load->view('common/change_approval_person_conditional'); ?>

    <?php if (isset($userIsApprover) && $userIsApprover == true && $approver_view) $this->load->view('common/approver_action_conditional'); ?>

</div>

<script>
    var EXCS_URL = '<?php echo excs_url() ?>';
    var BASE_URL = '<?php echo base_url() ?>';
</script>

<script src="<?php echo base_url('application/modules/excs/js/view_plan.js') ?>"></script>
