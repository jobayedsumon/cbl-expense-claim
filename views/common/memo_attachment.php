<div class="row" style="margin-bottom: 10px">
    <div class="col-md-4 col-sm-4">
        <label for="">Memo</label>
        <select class="form-control" name="MEMO_NO" id="memoRefNo">
            <option value="">Please select one</option>
            <?php
            if ($memo_references) {
                foreach ($memo_references as $memo) {
                    ?>
                    <option <?php echo $claim_information->claim->memo_no == $memo->memo_ref ? 'selected': ''; ?>
                        value="<?php echo $memo->memo_ref; ?>">
                        <?php echo $memo->memo_ref; ?>
                    </option>
                <?php }} ?>
        </select>
    </div>
</div>
<div class="row" style="margin-bottom: 10px">
    <div class="col-md-4 col-sm-4">
        <div class="flex flex-col">
            <label for="">Attachment</label>

            <span class="btn customBtn fileUploadButton">
                            <input multiple type="file" name="attachment" id="attachment">
                        </span>

        </div>
    </div>
</div>

<table id="attachmentsTable" class="table table-bordered table-condensed table-hover table-striped">
    <thead >
    <tr>
        <th>File Name</th>
        <th>Action</th>
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
                    <a data-name="<?php echo $attachment->file_name; ?>" class="fa fa-times text-danger deleteAttachment"></a>
                </td>
            </tr>

        <?php }} ?>
    </tbody>
</table>
