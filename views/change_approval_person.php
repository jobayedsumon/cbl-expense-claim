<link rel="stylesheet" href="<?php echo base_url('application/modules/excs/css/excs_common.css') ?>">

<div class="panel panel-success">
    <div class="panel-heading">
        Change Approval Person
    </div>
    <div class="panel-body col-md-6 col-md-offset-3">
        <form action="" id="claimSearchForm">
            <div class="form-group">
                <label for="claimCode">Search Claim</label>
                <input type="text" required name="CLAIM_CODE" class="form-control" placeholder="Claim Code">
            </div>
            <button type="submit" class="btn btn-success">Search</button>
        </form>

    </div>
</div>

<script>

    var EXCS_URL = '<?php echo excs_url() ?>';
    var BASE_URL = '<?php echo base_url() ?>';

    $(document).ready(function () {
       $('#claimSearchForm').on('submit', function (e) {
           e.preventDefault();
           var claimCode = $('input[name="CLAIM_CODE"]').val();
           $.ajax({
               url: EXCS_URL+'/excs/claims/show_by_code/'+claimCode,
               type: 'GET',
               error: function(xhr, status, error) {
                   console.log('xhr: ');
                   console.log(xhr);
                   console.log('status: ' + status);
                   console.log('error: ' + error);
               },
               success: function(response) {
                   console.log(response);
                   var id = response.data.claim.exc_claim_requests_id;
                   var url = BASE_URL+'excs/view_claim/'+id;
                   window.location.href = url;
               }

           });



       });
    });
</script>