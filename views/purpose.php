<style>
    .flex {
        display: flex !important;
    }
    .flex-row {
        flex-direction: row !important;
    }
    .flex-col {
        flex-direction: column !important;
    }

    a, a:hover {
        text-decoration: none;
    }
    .modal-lg {
        width: 1211px !important;
    }
    .nopadding {
        padding: 0 !important;
        margin: 0 !important;
    }
    .nopadding-left{
        padding-left: 0 !important;
        margin-left: 0 !important;
    }
    .nopadding-right{
        padding-right: 0 !important;
        margin-right: 0 !important;
    }
    .panel-heading, .panel-heading-secondary {
        background-color: #f0012d !important;
        border-radius: 5px !important;
    }
    .panel-title {
        color: white;
        font-size: 16px !important;
        font-weight: bold !important;
    }
    .panel-title-secondary {
        color: black;
        font-size: 16px !important;
        font-weight: bold !important;
        background-color: #fff !important;
        padding: 2px;
    }

    .modal-header {
        display: flex !important;
        justify-content: space-between !important;
    }
    .selectWithLabel {
        display: flex;
        justify-content: space-evenly;
        align-items: baseline;
    }
    .employeeInfoData {
        font-weight: bold !important;
        padding-left: 20px;
    }
    .informationRow {
        margin-bottom: 20px;
    }
    .inputWithLabel {
        display: flex;
        align-items: baseline;
    }
    .inputWithLabel label {
        margin-right: 20px;
    }
    .customBtn {
        background-color: #f0012d;
        margin-bottom: 2px;
        color: white;
        border-radius: 5px;
        padding: 2px 15px;
    }
    .customBtn:hover {
        background-color: red;
        color: whitesmoke;
    }
    textarea {
        height: 50px;
        width: 100%;
    }

    .fileUploadButton {
        padding: 5px;
        width: fit-content;
        width: -moz-fit-content;
    }
    .fa-times {
        color: white;
        background-color: red;
        border-radius: 50%;
        padding: 2px;
        cursor: pointer;
    }

</style>


<div class="panel panel-default">
    <div class="panel-heading">
        <h3 class="panel-title">Purpose Management</h3>
    </div>

    <div class="panel-body">
        <a class="pull-right btn customBtn"  data-toggle="modal" data-target="#addPurposeModal">Create New</a>
        <table id="purposeTable" class="table table-bordered table-condensed table-hover table-striped">
            <thead>
            <tr>
                <th>SL No.</th>
                <th>Created Date</th>
                <th>Created By</th>
                <th>GL Account</th>
                <th>Purpose Title</th>
                <th>Purpose Details</th>
                <th>Remarks</th>
                <th>Action</th>
            </tr>
            </thead>
            <tbody>
                <?php if ($purpose_list) {
                    foreach ($purpose_list as $index => $purpose) {
                 ?>
                    <tr>
                        <td><?php echo $index+1; ?></td>
                        <td><?php echo date('d-m-Y', strtotime($purpose->created_at)); ?></td>
                        <td><?php echo $purpose->created_by_name; ?></td>
                        <td><?php echo $purpose->gl_account_code; ?></td>
                        <td><?php echo $purpose->purpose_title; ?></td>
                        <td><?php echo $purpose->purpose_details; ?></td>
                        <td><?php echo $purpose->remarks; ?></td>
                        <td class="text-center">
                            <a
                                    data-serial="<?php echo $index+1; ?>"
                                    data-id="<?php echo $purpose->exc_purpose_id; ?>"
                               data-title="<?php echo $purpose->purpose_title; ?>"
                               data-details="<?php echo $purpose->purpose_details; ?>"
                               data-remarks="<?php echo $purpose->remarks; ?>"
                               class="fa fa-edit text-success editPurpose"></a>
                            <a data-id="<?php echo $purpose->exc_purpose_id; ?>"
                               class="fa fa-times text-danger deletePurpose"></a>
                        </td>
                    </tr>
                <?php }} ?>
            </tbody>

        </table>

    </div>


</div>


    <!-- Modal -->
    <div class="modal fade" id="addPurposeModal" tabindex="-1" role="dialog" aria-labelledby="addAdvanceInformationModal" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">

                    <h5 class="modal-title panel title panel-title-secondary"
                        style="padding-left: 10px"
                        id="exampleModalLongTitle">Create New Purpose</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form autocomplete="off" id="purposeCreateForm" method="POST" action="<?php echo excs_url() ?>/excs/purposes">
                    <input type="hidden" name="CREATED_BY" value="<?php echo $this->user->EMPLOYEE_ID; ?>">
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="exampleFormControlSelect2">GL Account</label>
                            <select class="form-control" name="GL_ACCOUNT_CODE" required>
                                <?php
                                if ($gl_account_list) {
                                    foreach ($gl_account_list as $gl_account) {
                                        ?>
                                        <option
                                            value="<?php echo $gl_account->gl_account_code; ?>">
                                            <?php echo $gl_account->gl_account_name . ' (' . $gl_account->gl_account_code . ')'; ?>
                                        </option>
                                    <?php }} ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="exampleFormControlInput1">Purpose Title</label>
                            <input type="text" class="form-control"  name="PURPOSE_TITLE" required>
                        </div>
                        <div class="form-group">
                            <label for="exampleFormControlTextarea1">Purpose Details</label>
                            <textarea maxlength="255" class="form-control" id="" name="PURPOSE_DETAILS" rows="3"></textarea>
                        </div>
                        <div class="form-group">
                            <label for="exampleFormControlTextarea1">Remarks</label>
                            <textarea maxlength="255" class="form-control" id="" name="REMARKS" rows="3"></textarea>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn customBtn">Create</button>
                    </div>



                </form>
            </div>
        </div>

    </div>

<!-- Modal -->
<div class="modal fade" id="purposeUpdateModal" tabindex="-1" role="dialog" aria-labelledby="addAdvanceInformationModal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">

                <h5 class="modal-title panel title panel-title-secondary"
                    style="padding-left: 10px"
                    id="exampleModalLongTitle">Update Purpose</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form autocomplete="off" id="purposeUpdateForm">
                <input type="hidden" name="UPDATED_BY" value="<?php echo $this->user->EMPLOYEE_ID; ?>">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="exampleFormControlSelect2">GL Account</label>
                        <select class="form-control" name="GL_ACCOUNT_CODE" required>
                            <?php
                            if ($gl_account_list) {
                                foreach ($gl_account_list as $gl_account) {
                                    ?>
                                    <option
                                            value="<?php echo $gl_account->gl_account_code; ?>">
                                        <?php echo $gl_account->gl_account_name . ' (' . $gl_account->gl_account_code . ')'; ?>
                                    </option>
                                <?php }} ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="exampleFormControlInput1">Purpose Title</label>
                        <input type="text" class="form-control" id="purposeTitle"  name="PURPOSE_TITLE" required>
                    </div>
                    <div class="form-group">
                        <label for="exampleFormControlTextarea1">Purpose Details</label>
                        <textarea maxlength="255" class="form-control" id="purposeDetails" name="PURPOSE_DETAILS" rows="3"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="exampleFormControlTextarea1">Remarks</label>
                        <textarea maxlength="255" class="form-control" id="purposeRemarks" name="REMARKS" rows="3"></textarea>
                    </div>
                </div>

                <input type="hidden" id="purposeId" value="">
                <input type="hidden" id="purposeSerial" value="">

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn customBtn">Update</button>
                </div>



            </form>
        </div>
    </div>

</div>



<script>

$(document).ready(function () {
    $('#purposeCreateForm').on('submit', function (e) {
        e.preventDefault();

        let formData = new FormData(this);

        let data = {};
        formData.forEach(function(value, key){
            data[key] = value;
        });

        console.log(JSON.stringify(data));

        $.ajax({
            url: '<?php echo excs_url() ?>/excs/purposes',
            type: 'POST',
            processData: false,
            contentType: false,
            data: JSON.stringify(data),
            error: function (xhr, status, error) {
                console.log('xhr: ');
                console.log(xhr);
                console.log('status: ' + status);
                console.log('error: ' + error);
            },
            success: function (response) {

                let newPupose = response.data.purpose;

                let newSerial = $('#purposeTable tbody:last').find('td:first').text();
                newSerial = parseInt(newSerial) + 1;

                let newRow = '<tr>\
                            <td>'+newSerial+'</td>\
                            <td>'+newPupose.created_at+'</td>\
                            <td>'+newPupose.created_by_name+'</td>\
                            <td>'+newPupose.gl_account_code+'</td>\
                            <td>'+newPupose.purpose_title+'</td>\
                            <td>'+newPupose.purpose_details+'</td>\
                            <td>'+newPupose.remarks+'</td>\
                            <td class="text-center">\
                            <a data-id="'+newPupose.exc_purpose_id+'" data-serial="'+newSerial+'" data-title="'+newPupose.purpose_title+'" data-details="'+newPupose.purpose_details+'" data-remarks="'+newPupose.remarks+'" class="fa fa-edit text-success editPurpose"></a>\
                            <a data-id="'+newPupose.exc_purpose_id+'" class="fa fa-times text-danger deletePurpose"></a>\
                            </td></tr>';

                $('#purposeTable tbody:last').append(newRow);
                $('#addPurposeModal').modal('hide');
            }

        });


    });

    $('#purposeUpdateForm').on('submit', function (e) {
        e.preventDefault();

        let formData = new FormData(this);
        let purposeId = $('#purposeId').val();
        let purposeSerial = $('#purposeSerial').val();

        let data = {};
        formData.forEach(function(value, key){
            data[key] = value;
        });

        $.ajax({
            url: '<?php echo excs_url() ?>/excs/purposes/'+purposeId,
            type: 'POST',
            method: 'PUT',
            processData: false,
            contentType: false,
            data: JSON.stringify(data),
            error: function (xhr, status, error) {
                console.log('xhr: ');
                console.log(xhr);
                console.log('status: ' + status);
                console.log('error: ' + error);
            },
            success: function (response) {
                window.location.reload();
                // $('#addPurposeModal').modal('hide');
            }

        });


    });

    $(document).on('click', '.editPurpose', function () {
        var purposeSerial = $(this).data('serial');
        var purposeId = $(this).data('id');
        var purposeTitle = $(this).data('title');
        var purposeDetails = $(this).data('details');
        var purposeRemarks = $(this).data('remarks');
        $('#purposeSerial').val(purposeSerial);
        $('#purposeId').val(purposeId);
        $('#purposeTitle').val(purposeTitle);
        $('#purposeDetails').val(purposeDetails);
        $('#purposeRemarks').val(purposeTitle);
        $('#purposeUpdateModal').modal('show');

    });

    $(document).on('click', '.deletePurpose', function () {
        let purpose = $(this);
        let purposeId = purpose.data('id');

        $.ajax({
            url: '<?php echo excs_url() ?>/excs/purposes/'+purposeId,
            type: 'DELETE',
            error: function(xhr, status, error) {
                console.log('xhr: ');
                console.log(xhr);
                console.log('status: ' + status);
                console.log('error: ' + error);
            },
            success: function(response) {
                purpose.closest('tr').remove();
            }

        });

    });
});

</script>