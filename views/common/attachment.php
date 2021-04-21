<div class="row" style="margin-bottom: 10px">
    <div class="col-md-4 col-sm-4">
        <div class="flex flex-col">
            <label for="">Attachment</label>

            <span class="btn customBtn fileUploadButton">
                            <input multiple type="file" id="attachment">
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
    <?php $data = isset($claim_information) ? $claim_information->attachments : $travel_plan->attachments;
    if (isset($data)) {
        foreach ($data as $index => $attachment) {
            ?>
            <tr>
                <td><?php echo $attachment->file_name; ?></td>
                <td class="text-center">
                    <a href="<?php echo excs_url().'/attachments/download?FILE_LOC='.$attachment->file_loc; ?>" class="fa fa-download text-success downloadAttachment"></a>
                    <a data-name="<?php echo $attachment->file_name; ?>" class="fa fa-times text-danger deleteAttachment"></a>
                </td>
            </tr>

        <?php }} ?>
    </tbody>
</table>
