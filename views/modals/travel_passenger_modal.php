
<!-- Travel Passenger Details Modal -->
<div class="modal fade" id="travelPassengerModal" tabindex="-1" role="dialog" aria-labelledby="travelPassengerModal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">

                <h5 class="modal-title panel title panel-title-secondary"

                    id="exampleModalLongTitle">Passenger Details</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form autocomplete="off" id="travelPassengerModalForm">

                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6 col-sm-6">
                            <div class="form-group">
                                <label for="">Passenger Type</label>
                                <select class="form-control" name="PASSENGER_TYPE" required>
                                    <option value="">Please Select One</option>
                                    <option value="ADT">Adult</option>
                                    <option value="CHD">Child</option>
                                    <option value="INF">Infant</option>
                                </select>
                            </div>

                        </div>
                        <div class="col-md-6 col-sm-6">
                            <div class="form-group">
                                <label for="exampleFormControlSelect1">Passenger Name</label>
                                <input type="text" class="form-control" name="PASSENGER_NAME">
                            </div>
                        </div>
                    </div>

                    <div class="row flex flex-row" style="align-items: center">
                        <div class="col-md-6 col-sm-6">
                            <div class="form-group">
                                <label for="exampleFormControlInput1">Date Of Barth</label>
                                <input type="date" data-date-format='yyyy-mm-dd'
                                       class="form-control" name="DOB" value="<?php echo date('Y-m-d'); ?>">
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-6">
                            <div class="form-group">
                                <label for="exampleFormControlSelect1">Passport No.</label>
                                <input type="text" class="form-control" name="PASSPORT_NO">
                            </div>
                        </div>

                    </div>


                    <div class="row">
                        <div class="col-md-6 col-sm-6">
                            <div class="form-group">
                                <label for="exampleFormControlInput1">Passport Expiry Date</label>
                                <input type="date" data-date-format='yyyy-mm-dd'
                                       class="form-control" name="PASSPORT_EXP_DATE" value="<?php echo date('Y-m-d'); ?>">
                            </div>
                        </div>

                        <input type="hidden" name="CREATED_BY" value="<?php echo $employee_information->employee_id; ?>">
                        <input type="hidden" name="EXC_TRAVEL_PLANS_ID" value="<?php echo $travel_plan->plan->exc_travel_plans_id; ?>">

                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn customBtn">Submit</button>
                </div>
            </form>

        </div>
    </div>

</div>
