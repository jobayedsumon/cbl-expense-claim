var table;
jQuery(document).ready(function ($) {

    $('.input-daterange, #claimDate').datepicker({
        format: "yyyy-mm-dd"
    });

    //datatables
    table = $('#my_table').DataTable({

        "processing": true, //Feature control the processing indicator.
        "serverSide": true, //Feature control DataTables' server-side processing mode.
        "order": [], //Initial no order.

        // Load data for the table's content from an Ajax source
        "ajax": {
            "url": EXCS_URL+"/excs/claims/my_claim_list",
            "type": "POST",
            "data": function(data) {
                data.CREATED_BY = $('#currentUser').val();
                data.CLAIM_TYPE = $('#claimType').val();
                data.CLAIM_STATUS = $('#claimStatus').val();
                data.EMPLOYEE_ID = $('#onBehalfOfFilter').val();
                data.CLAIM_DATE = $('#claimDate').val();
                data.CLAIM_CODE = $('#claimCode').val();
                data.START_DATE = $('#startDate').val();
                data.END_DATE = $('#endDate').val();
            }
        },

        //Set column definition initialisation properties.
        "columnDefs": [
            {
                "targets": [0, 1], //first, second and last column
                "orderable": false, //set not orderable
            },
        ],


        "language": {
            "processing": '<img style="height: 21px; width: 21px;" src="'+BASE_URL+'img/loading.gif'+'"> Loading...',
            //"processing": '<img src="<?php echo base_url("img/ajaxLoader.gif"); ?>">',
        },

    });

    $('#search').on( 'click change', function (event) {
        event.preventDefault();
        table.draw();
        serach = 'SEARCH';
    });

    $(".search_btn").on("click",function() {
        $(".search").toggle("fast");
    });

    $("#chk_all_at_a_time").change(function () {
        $("input:checkbox:enabled").prop('checked', $(this).prop("checked"));
        if ($(this).prop("checked")) {
            $('#delete').removeClass('disabled');
        } else {
            $('#delete').addClass('disabled');
        }

    });

});

var status;
$('#my_table tbody').on( 'click', 'tr', function () {
    $(this).siblings().removeClass('selected');
    $(this).toggleClass('selected');
    if ($(this).hasClass("selected")) {
        $('#view').removeClass('disabled');
        status = $(this).find("div>input.chk_claim").eq(0).attr('claim_status');
        if (status == 201 || status == 204) {
            $('.on_condition').removeClass('disabled');
        }
        else{
            $('.on_condition').addClass('disabled');
        }
    }

    else{
        $('#view').addClass('disabled');
        $('#edit').addClass('disabled');
        if ($("input.chk_claim:checked").length >= 1) {
            $('#delete').removeClass('disabled');
        }
    }
});

var selected_tr = '';
var url = '';
var note = '';
var month = '';
var bill_id = '';
function view_claim(){
    selected_tr = $("table#my_table tr.selected");
    url = BASE_URL+'excs/view_claim/'+selected_tr.find("div.exc_claim_requests").eq(0).attr('exc_claim_requests_id');
    window.location.href = url;
}
function edit_claim(){
    selected_tr = $("table#my_table tr.selected");
    var claim_type = selected_tr.find("div>input.chk_claim").eq(0).attr('claim_type');

    if (claim_type == 1) {
        url = BASE_URL+'excs/advance_claim/'+selected_tr.find("div.exc_claim_requests").eq(0).attr('exc_claim_requests_id');
    } else if (claim_type == 2) {
        url = BASE_URL+'excs/expense_claim/'+selected_tr.find("div.exc_claim_requests").eq(0).attr('exc_claim_requests_id');
    }
    window.location.href = url;
}

function reload_table() {
    table.ajax.reload(null, false); //reload datatable ajax
    $('#view').addClass('disabled');
    $('#clone').addClass('disabled');
    $('.on_condition').addClass('disabled');
}

function delete_claim() {
    if ($("input.chk_claim:checked").length > 1) {
        bootbox.confirm({
            message: "Are you sure you want to delete batch claims?",
            buttons: {
                confirm: {
                    label: 'Yes',
                    className: 'btn-success'
                },
                cancel: {
                    label: 'No',
                    className: 'btn-danger'
                }
            },
            callback: function (isDelete) {
                if (isDelete) {
                    var ids = '';
                    $("input.chk_claim:checked").each(function () {
                        ids += $(this).prop('id');
                        ids += ',';
                    });
                    $.ajax({
                        url: EXCS_URL+'/excs/claims/'+ids,
                        type: 'DELETE',
                        error: function(xhr, status, error) {
                            console.log('xhr: ');
                            console.log(xhr);
                            console.log('status: ' + status);
                            console.log('error: ' + error);
                        },
                        success: function(response) {
                            bootbox.alert({
                                message: 'All claims have been deleted successfully.',
                                className: 'text-success',
                                callback: reload_table()
                            });
                            $("#chk_all_at_a_time").prop('checked', false);
                        }

                    });

                }
            }
        });
    } else {
        bootbox.confirm({
            message: "Are you sure you want to delete the claim?",
            buttons: {
                confirm: {
                    label: 'Yes',
                    className: 'btn-success'
                },
                cancel: {
                    label: 'No',
                    className: 'btn-danger'
                }
            },
            callback: function (isDelete) {
                if (isDelete) {
                    selected_tr = $("table#my_table tr.selected");
                    url = EXCS_URL+'/excs/claims/'+selected_tr.find("div.exc_claim_requests").eq(0).attr('exc_claim_requests_id');
                    $.ajax({
                        url: url,
                        type: 'DELETE',
                        error: function(xhr, status, error) {
                            console.log('xhr: ');
                            console.log(xhr);
                            console.log('status: ' + status);
                            console.log('error: ' + error);
                        },
                        success: function(response) {
                            bootbox.alert({
                                message: 'The claim has been deleted successfully.',
                                className: 'text-success',
                                callback: reload_table()
                            });
                        }

                    });
                }
            }
        });
    }


}

