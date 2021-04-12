<div class="col-md-3 col-sm-3">
    <label for="">On Behalf Of</label>
    <select style="margin-bottom: 10px;" name="ON_BEHALF_OF" id="onBehalfOf" required>

        <?php
        if ($employee_list) {
            foreach ($employee_list as $employee) {
                ?>
                <option <?php echo $employee->employee_id == $employee_information->employee_id ? 'selected' : ''; ?>
                    value="<?php echo $employee->employee_id; ?>">
                    <?php echo $employee->employee_name; ?>
                </option>
            <?php }} ?>

    </select>

    <div class="container-fluid box">
        <h3  class="panel-title-secondary">Employee Information</h3>
        <div class="row">
            <div class="col-md-6 col-sm-6">
                <label>Name</label>
                <p class="employeeName"><?php echo $employee_information->employee_name ?></p>
                <label>Organization</label>
                <p id="organization"><?php echo $employee_information->organization ?></p>
                <label>Supervisor</label>
                <p id="supervisorsName"><?php echo $employee_information->supervisor_name ?></p>
                <label>SOL</label>
                <p id="solBranchInfo"><?php echo $employee_information->sol_name ?></p>
            </div>
            <div class="col-md-6 col-sm-6">
                <label>Code</label>
                <p><?php echo $claim_information->claim->claim_code ?></p>
                <label>Designation</label>
                <p id="designation"><?php echo $employee_information->designation_name ?></p>
                <label>Grade</label>
                <p id="grade"><?php echo $employee_information->grade ?></p>
                <label>CC</label>
                <p id="costCenterInfo"><?php echo $employee_information->cost_center_name ?></p>
            </div>
        </div>
        <h3 class="panel-title-secondary">Accounts Information</h3>
        <div class="row">
            <div class="col-md-6 col-sm-6">
                <label>Account Name</label>
                <p id="accountName"><?php echo $employee_information->account_name ?></p>
                <label>Type of Transaction</label>
                <p id="typeOfTransaction"><?php echo $employee_information->transaction_type ?></p>
                <label>Bank</label>
                <p id="bankName"><?php echo $employee_information->bank_name ?></p>
            </div>
            <div class="col-md-6 col-sm-6">
                <label>Account Number</label>
                <p id="accountNumber"><?php echo $employee_information->account_number ?></p>
                <label>Routing Number</label>
                <p id="routingNumber"><?php echo $employee_information->routing_number ?></p>
                <label>Branch</label>
                <p id="branchName"><?php echo $employee_information->branch_name ?></p>
            </div>
        </div>
    </div>

</div>