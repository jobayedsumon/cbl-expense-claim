<link rel="stylesheet" href="<?php echo base_url('application/modules/excs/css/excs_common.css') ?>">


<div class="panel panel-success">
    <div class="panel-heading">
        <h3 class="panel-title">Manage Passenger Details (<?php echo $travel_plan->plan->travel_plan_code; ?>)</h3>
    </div>

    <div class="panel-body">

        <div class="container-fluid">

            <div class="row">

                <a class="btn customBtn pull-right" style="margin-bottom: 10px" data-toggle="modal"
                   data-target="#travelPassengerModal">Add</a>

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
                        <th>Action</th>
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
                                <td class="text-center">
                                    <a data-id="<?php echo $passenger->exc_travel_passengers_id; ?>"
                                       class="editPassenger fa fa-edit text-success"></a>
                                    <a data-id="<?php echo $passenger->exc_travel_passengers_id; ?>"
                                       class="deletePassenger fa fa-times text-danger"></a>
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

<?php $this->load->view('modals/travel_passenger_modal'); ?>
<?php $this->load->view('modals/edit_travel_passenger_modal'); ?>


<script>
    var EXCS_URL = '<?php echo excs_url() ?>';
    var BASE_URL = '<?php echo base_url() ?>';
</script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/bootbox.js/5.5.2/bootbox.min.js"></script>

<script src="<?php echo base_url('application/modules/excs/js/excs_common.js') ?>"></script>
<script src="<?php echo base_url('application/modules/excs/js/travel_plan.js') ?>"></script>
