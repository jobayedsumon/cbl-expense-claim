<div class="row">
    <div class="col-md-4 col-sm-4">
        <label for="">Currency</label>
        <select class="form-control" name="CURRENCY_CODE" id="currency" required>
            <?php
            $currencySelected = $claim_information->claim->currency_code ? $claim_information->claim->currency_code : 'BDT';
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
    <div class="col-md-4 col-sm-4">
        <label for="">Exchange&nbsp;Rate</label>
        <input <?php echo count(isset($claim_information->claim->details) ? $claim_information->claim->details : []) ? 'readonly': ''; ?>
                class="form-control" type="number" name="EXCHANGE_RATE" id="exchangeRate" step=".01"
                min="1.0" value="<?php echo $claim_information->claim->exchange_rate ? number_format($claim_information->claim->exchange_rate, 2, '.', ''): '1.00'; ?>" required>

    </div>
    <div class="col-md-4 col-sm-4">
        <div class="form-group">
            <label for="exampleFormControlInput1">Claim Date</label>
            <input type="date" data-date-format='yyyy-mm-dd'
                   class="form-control" id="claimDate" name="CLAIM_DATE" value="<?php echo $claim_information->claim->claim_date; ?>">
            <input type="hidden" name="CREATED_BY" value="<?php echo $employee_information->employee_id; ?>">
        </div>
    </div>
</div>