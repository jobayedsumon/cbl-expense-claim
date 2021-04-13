<div class="tableHeading">
    <h3 class="panel-title-secondary">Approval Person</h3>
</div>
<div class="row" style="margin-bottom: 10px">
    <div class="col-md-6 col-sm-6" style="display: flex; align-items: center">
        <select id="approver">,
            <option value="">Please select one</option>
            <?php
            if ($employee_list) {
                foreach ($employee_list as $employee) {
                    ?>
                    <option data-designation="<?php echo $employee->designation_name; ?>" value="<?php echo $employee->employee_id; ?>">
                        <?php echo $employee->employee_name.' ('.$employee->employee_id.')'; ?>
                    </option>
                <?php }} ?>
        </select>
        <a style="margin-left: 10px" id="addApprover" class="btn customBtn">Add</a>
    </div>
    <div class="col-md-6 col-sm-6">
        <div class="form-group">
            <label for="" style="margin-right: 10px">Approval Process Type </label>
            <input type="radio" <?php echo $claim_information->claim->approval_process_type == 1 || $claim_information->claim->approval_process_type == null ? 'checked': ''; ?> name="APPROVAL_PROCESS_TYPE" value="1" required> Automatic
            <input type="radio" <?php echo $claim_information->claim->approval_process_type == 2 ? 'checked': ''; ?> name="APPROVAL_PROCESS_TYPE" value="2" required> Manual
        </div>
    </div>
</div>


<table id="approvalPersonTable" class="table table-bordered table-condensed table-hover table-striped">
    <thead >
    <tr class="text-center">
        <th>Sort No</th>
        <th>Approval Person</th>
        <th>Designation</th>
        <th>Action</th>
    </tr>
    </thead>
    <tbody>
    <?php if (isset($claim_information->approvers)) {
        foreach ($claim_information->approvers as $approver) {
            ?>
            <tr>
                <td data-approver-id="<?php echo $approver->approval_person; ?>"><?php echo $approver->sort_no; ?></td>
                <td class="approvalPersonName"><?php echo $approver->approval_person_name; ?></td>
                <td><?php echo $approver->designation_name; ?></td>
                <td class="text-center"><a class="fa fa-times text-danger removeApprover"></a></td>
            </tr>

        <?php }} ?>
    </tbody>
</table>

<label for="">Remarks</label>
<textarea class="form-control" name="REMARKS" id="remarks" ><?php echo $claim_information->claim->remarks; ?></textarea>

<div style="margin-top: 10px">
    <input type="hidden" name="UPDATED_BY" class="employeeID" value="<?php echo $employee_information->employee_id ?>">
    <button id="save" name="save" class="btn customBtn">Save</button>
    <button id="sendForApproval" name="sendForApproval" class="btn customBtn" style="background-color: green">Send for Approval</button>
</div>