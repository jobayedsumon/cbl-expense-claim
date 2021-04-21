<link rel="stylesheet" href="<?php echo base_url('application/modules/excs/css/excs_common.css') ?>">



<div class="panel panel-success">
    <div class="panel-heading">
        <h3 class="panel-title">Travel Plan</h3>
    </div>

    <div class="panel-body">

        <div class="container-fluid">
            <div class="row">

                <?php $this->load->view('common/on_behalf_information'); ?>

                <div class="col-md-9 col-sm-9">

                    <form id="travelPlanStoreForm" autocomplete="off">
                        <div class="row" style="margin-bottom: 10px">
                            <div class="col-md-4 col-sm-4">
                                <div class="form-group">
                                    <label for="">Currency</label>
                                    <select class="form-control" name="CURRENCY_CODE" id="currency" required>
                                        <?php
                                        $currencySelected = $travel_plan->plan->currency_code ? $travel_plan->plan->currency_code : 'BDT';
                                        if ($currency_list) {
                                            foreach ($currency_list as $currency) {
                                                ?>
                                                <option <?php echo $currency->currency_code == $currencySelected ? 'selected' : ''; ?>
                                                        value="<?php echo $currency->currency_code; ?>">
                                                    <?php echo $currency->currency_code .'-'. $currency->currency_name; ?>
                                                </option>
                                            <?php }} ?>
                                    </select>
                                </div>

                            </div>
                            <div class="col-md-4 col-sm-4">
                                <div class="form-group">
                                    <label for="">Exchange&nbsp;Rate</label>
                                    <input class="form-control" type="number" name="EXCHANGE_RATE" id="exchangeRate" step=".01"
                                           min="1.0" value="<?php echo $travel_plan->plan->exchange_rate ? excs_amount($travel_plan->plan->exchange_rate): '1.00'; ?>" required>

                                </div>

                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4 col-sm-4">
                                <div class="form-group">
                                    <label for="exampleFormControlInput1">Possible Travel Date</label>
                                    <input type="date" data-date-format='yyyy-mm-dd'
                                           class="form-control" name="POSSIBLE_TRAVEL_DATE" value="<?php echo $travel_plan->plan->possible_travel_date ? date('Y-m-d', strtotime($travel_plan->plan->possible_travel_date)) : date('Y-m-d'); ?>">
                                    <input type="hidden" name="CREATED_BY" value="<?php echo $employee_information->employee_id; ?>">
                                </div>
                            </div>
                            <div class="col-md-4 col-sm-4">
                                <div class="form-group">
                                    <label for="exampleFormControlSelect1">Project</label>
                                    <select class="form-control" id="project" name="PROJECT_ID">
                                        <option value="">Please Select One</option>
                                        <?php
                                        if ($projects) {
                                            foreach ($projects as $project) {
                                                ?>
                                                <option <?php echo $project->project_id == $travel_plan->plan->project_id ? 'selected': ''; ?>
                                                        value="<?php echo $project->project_id; ?>">
                                                    <?php echo $project->project_name; ?>
                                                </option>
                                            <?php }} ?>


                                    </select>
                                </div>

                            </div>
                            <div class="col-md-4 col-sm-4">
                                <div class="form-group">
                                    <label for="exampleFormControlSelect1">Travel Area</label>
                                    <select class="form-control" id="travelArea" name="TRAVEL_AREA">
                                        <option value="">Please Select One</option>
                                        <option <?php echo $travel_plan->plan->travel_area == 'Domestic' ? 'selected' : ''; ?> value="Domestic">Domestic</option>
                                        <option <?php echo $travel_plan->plan->travel_area == 'International' ? 'selected' : ''; ?> value="International">International</option>
                                    </select>
                                </div>

                            </div>

                        </div>

                        <div class="row">

                            <div class="col-md-4 col-sm-4">
                                <div class="form-group">
                                    <label for="exampleFormControlSelect1">Travel Mode</label>
                                    <select class="form-control" id="travelMode" name="TRAVEL_MODE">
                                        <option value="">Please Select One</option>
                                        <option <?php echo $travel_plan->plan->travel_mode == 'By Air' ? 'selected' : ''; ?> value="By Air">By Air</option>
                                        <option <?php echo $travel_plan->plan->travel_mode == 'By Bus/Train' ? 'selected' : ''; ?> value="By Bus/Train">By Bus/Train</option>
                                        <option <?php echo $travel_plan->plan->travel_mode == 'Pool Car' ? 'selected' : ''; ?> value="Pool Car">Pool Car</option>
                                        <option <?php echo $travel_plan->plan->travel_mode == 'Personal Vehicle' ? 'selected' : ''; ?> value="Personal Vehicle">Personal Vehicle</option>
                                    </select>
                                </div>

                            </div>

                            <div class="col-md-4 col-sm-4">
                                <div class="form-group">
                                    <label for="exampleFormControlSelect1">Country to be visited</label>
                                    <select multiple="multiple" class="form-control" id="countryToVisited">
                                        <?php
                                        if ($countries) {
                                            $country_to_visited = explode(',', $travel_plan->plan->country_to_visited);
                                            foreach ($countries as $country) {
                                                ?>
                                                <option <?php echo in_array($country->country_name, $country_to_visited) ? 'selected' : ''; ?>
                                                        value="<?php echo $country->country_name; ?>">
                                                    <?php echo ucfirst($country->country_name); ?>
                                                </option>
                                            <?php }} ?>

                                    </select>
                                </div>

                            </div>
                            <div class="col-md-4 col-sm-4">
                                <div class="form-group">
                                    <label for="exampleFormControlSelect1">City to be visited</label>
                                    <input type="text" data-date-format='yyyy-mm-dd'
                                           class="form-control" name="CITY_TO_VISITED" value="<?php echo $travel_plan->plan->city_to_visited; ?>">
                                </div>

                            </div>

                        </div>

                        <div class="row">

                            <div class="col-md-4 col-sm-4">
                                <div class="form-group">
                                    <label for="exampleFormControlSelect2">Purpose</label>
                                    <select class="form-control" name="PRODUCT_ID" required>
                                        <option value="">Please Select One</option>
                                        <?php
                                        if ($purpose_list) {
                                            foreach ($purpose_list as $purpose) {
                                                ?>
                                                <option <?php echo $purpose->product_id == $travel_plan->plan->product_id ? 'selected': ''; ?>
                                                        value="<?php echo $purpose->product_id; ?>">
                                                    <?php echo $purpose->product_name; ?>
                                                </option>
                                            <?php }} ?>
                                    </select>
                                </div>

                            </div>

                            <div class="col-md-4 col-sm-4">
                                <div class="form-group">
                                    <label for="exampleFormControlTextarea1">Purpose Details</label>
                                    <textarea maxlength="255" class="form-control" id="purposeDetails" name="PURPOSE_DETAILS" rows="2"><?php echo $travel_plan->plan->purpose_details; ?></textarea>
                                </div>

                            </div>
                            <div class="col-md-4 col-sm-4">
                                <div class="form-group">
                                    <label for="exampleFormControlInput1">Departure Date</label>
                                    <input type="date" data-date-format='yyyy-mm-dd'
                                           class="form-control" name="DEPARTURE_DATE" value="<?php echo $travel_plan->plan->departure_date ? date('Y-m-d', strtotime($travel_plan->plan->departure_date)) : date('Y-m-d'); ?>">
                                </div>
                            </div>

                        </div>

                        <div class="row">

                            <div class="col-md-4 col-sm-4">
                                <div class="form-group">
                                    <label for="exampleFormControlInput1">Return Date</label>
                                    <input type="date" data-date-format='yyyy-mm-dd'
                                           class="form-control" id="returnDate" name="RETURN_DATE" value="<?php echo $travel_plan->plan->return_date ? date('Y-m-d', strtotime($travel_plan->plan->return_date)) : date('Y-m-d'); ?>">
                                </div>
                            </div>

                            <div class="col-md-4 col-sm-4">
                                <div class="form-group">
                                    <label for="hotelAddress">Hotel Address</label>
                                    <textarea maxlength="255" class="form-control" id="hotelAddress" name="HOTEL_ADDRESS" rows="2"><?php echo $travel_plan->plan->hotel_address; ?></textarea>
                                </div>

                            </div>

                            <div class="col-md-4 col-sm-4">
                                <div class="form-group">
                                    <label for="exampleFormControlSelect2">Employee purchase Tkt</label>
                                    <select class="form-control" name="EMPLOYEE_PURCHASE_TKT" required>
                                        <option value="">Please Select One</option>
                                        <option <?php echo $travel_plan->plan->employee_purchase_tkt ? 'selected' : ''; ?> value="1">Yes</option>
                                        <option <?php echo !$travel_plan->plan->employee_purchase_tkt ? 'selected' : ''; ?> value="0">No</option>
                                    </select>
                                </div>

                            </div>




                        </div>

                        <div class="row">

                            <div class="col-md-4 col-sm-4">
                                <div class="form-group">
                                    <label for="exampleFormControlSelect2">Insurance Applicable?</label>
                                    <select class="form-control" name="INSURANCE_APPLICABLE" required>
                                        <option value="">Please Select One</option>
                                        <option <?php echo $travel_plan->plan->insurance_applicable ? 'selected' : ''; ?> value="1">Yes</option>
                                        <option <?php echo !$travel_plan->plan->insurance_applicable ? 'selected' : ''; ?> value="0">No</option>
                                    </select>
                                </div>

                            </div>

                            <div class="col-md-4 col-sm-4">
                                <div class="form-group">
                                    <label for="exampleFormControlInput1">Projected Amount</label>
                                    <input step=".01" type="number" class="form-control" min="1.00" value="<?php echo $travel_plan->plan->projected_amount ? excs_amount($travel_plan->plan->projected_amount): 1.00; ?>" name="PROJECTED_AMOUNT" required>
                                </div>
                            </div>

                            <div class="col-md-4 col-sm-4">
                                <div class="form-group">
                                    <label for="exampleFormControlInput1">Amount (BDT)</label>
                                    <input step=".01" type="number" class="form-control" min="1.00" value="<?php echo $travel_plan->plan->projected_amount_bdt ? excs_amount($travel_plan->plan->projected_amount_bdt): 1.00; ?>" name="PROJECTED_AMOUNT_BDT" required>
                                </div>

                            </div>

                        </div>

                        <div class="row">

                            <div class="col-md-4 col-sm-4">
                                <div class="form-group">
                                    <label for="exampleFormControlInput1">Advance Amount (BDT)</label>
                                    <input step=".01" type="number" class="form-control" min="0" value="<?php echo $travel_plan->plan->advance_amount ? $travel_plan->plan->advance_amount: '0'; ?>" name="ADVANCE_AMOUNT">
                                </div>

                            </div>

                            <div class="col-md-8 col-sm-8">
                                <label for="">Number of PAX</label>
                                <div class="row">

                                    <div class="col-md-4 col-sm-4 flex flex-row items-center">
                                        <input style="margin-right: 10px" step="1" type="number" class="form-control" min="1" value="<?php echo $travel_plan->plan->pax_adult ? $travel_plan->plan->pax_adult: 1; ?>" name="PAX_ADULT" required>
                                        <span>ADT</span>
                                    </div>

                                    <div class="col-md-4 col-sm-4 flex flex-row items-center">
                                        <input style="margin-right: 10px" step="1" type="number" class="form-control" min="0" value="<?php echo $travel_plan->plan->pax_child ? $travel_plan->plan->pax_child: 0; ?>" name="PAX_CHILD" required>
                                        <span>CHD</span>
                                    </div>

                                    <div class="col-md-4 col-sm-4 flex flex-row items-center">
                                        <input style="margin-right: 10px" step="1" type="number" class="form-control"
                                               min="0" value="<?php echo $travel_plan->plan->pax_infant ? $travel_plan->plan->pax_infant: 0; ?>" name="PAX_INFANT" required>
                                        <span>INF</span>
                                    </div>
                                </div>
                            </div>


                        </div>


                        <input type="hidden" name="ATTACHMENT_FOR" value="8">
                        <input type="hidden" name="REQUEST_ID" value="<?php echo $travel_plan->plan->exc_travel_plans_id; ?>">

                    <?php $this->load->view('common/attachment'); ?>

                    <?php $this->load->view('common/approval_person_remarks'); ?>

                    <div style="margin-top: 10px">
                        <input type="hidden" name="UPDATED_BY" class="employeeID" value="<?php echo $employee_information->employee_id ?>">
                        <button name="TRAVEL_ACTION" value="SAVE" class="btn customBtn">Save</button>
                        <button name="TRAVEL_ACTION" value="SEND" class="btn customBtn" style="background-color: green">Send for Approval</button>
                    </div>

                    </form>

                </div>
            </div>
        </div>
    </div>
</div>


<script>
    var EXCS_URL = '<?php echo excs_url() ?>';
    var BASE_URL = '<?php echo base_url() ?>';
</script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/bootbox.js/5.5.2/bootbox.min.js"></script>

<script src="<?php echo base_url('application/modules/excs/js/excs_common.js') ?>"></script>
<script src="<?php echo base_url('application/modules/excs/js/travel_plan.js') ?>"></script>
