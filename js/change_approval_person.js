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
            "url": EXCS_URL+"/excs/claims/approval_claim_list",
            "type": "POST",
            "data": function(data) {
                data.CURRENT_APPROVAL_PERSON = $('#currentUser').val();
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
            $('#approve').removeClass('disabled');
        } else {
            $('#approve').addClass('disabled');
        }

    });

});

var status;
$('#my_table tbody').on( 'click', 'tr', function () {
    $(this).siblings().removeClass('selected');
    $(this).toggleClass('selected');
    if ($(this).hasClass("selected")) {
        $('#view').removeClass('disabled');
        $('#approve').removeClass('disabled');
    }

    else{
        $('#view').addClass('disabled');
        if ($("input.chk_claim:checked").length >= 1) {
            $('#approve').removeClass('disabled');
        }
        else if (!$('#approve').hasClass('disabled')) {
            $('#approve').addClass('disabled');
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
    url = BASE_URL+'excs/view_claim/'+selected_tr.find("div.exc_claim_requests").eq(0).attr('exc_claim_requests_id')+'?admin';
    window.location.href = url;
}

function reload_table() {
    table.ajax.reload(null, false); //reload datatable ajax
    $('#view').addClass('disabled');
    $('#clone').addClass('disabled');
    $('.on_condition').addClass('disabled');
}

