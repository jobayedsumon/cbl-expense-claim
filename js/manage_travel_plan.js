var table;
jQuery(document).ready(function ($) {

    $('#dateType').on('change', function () {
        if ($(this).val()) {
            $('#dateRangeLabel').text($('#dateType option:selected').text());
        } else {
            $('#dateRangeLabel').text('');
        }
    });

    $('.input-daterange, #claimDate').datepicker({
        format: "yyyy-mm-dd"
    });

    console.log($('.employeeID').val());

    //datatables
    table = $('#my_table').DataTable({

        "processing": true, //Feature control the processing indicator.
        "serverSide": true, //Feature control DataTables' server-side processing mode.
        "order": [], //Initial no order.

        // Load data for the table's content from an Ajax source
        "ajax": {
            "url": EXCS_URL+"/excs/travel_plans/find_travel_plan",
            "type": "POST",
            "data": function(data) {
                data.CREATED_BY = $('#createdBy').val();
                data.TRAVEL_PLAN_STATUS = $('#travelPlanStatus').val();
                data.EMPLOYEE_ID = $('#onBehalfOfFilter').val();
                data.DATE_TYPE = $('#dateType').val();
                data.TRAVEL_PLAN_CODE = $('#travelPlanCode').val();
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


});

var status;
$('#my_table tbody').on( 'click', 'tr', function () {
    $(this).siblings().removeClass('selected');
    $(this).toggleClass('selected');
    if ($(this).hasClass("selected")) {
        $('.management').removeClass('disabled');
    }
    else{
        $('.management').addClass('disabled');
    }
});

var selected_tr = '';
var url = '';
var note = '';
var month = '';
var bill_id = '';

function reload_table() {
    table.ajax.reload(null, false); //reload datatable ajax
    $('.management').addClass('disabled');
}

function manage_passenger_details(){
    selected_tr = $("table#my_table tr.selected");
    url = BASE_URL+'excs/travel_passenger_details/'+selected_tr.find("div.exc_travel_plans").eq(0).attr('exc_travel_plans_id');
    window.location.href = url;
}

function manage_cost_component(){
    selected_tr = $("table#my_table tr.selected");
    url = BASE_URL+'excs/travel_cost_component/'+selected_tr.find("div.exc_travel_plans").eq(0).attr('exc_travel_plans_id');
    window.location.href = url;
}

function change_approval_persons(){
    selected_tr = $("table#my_table tr.selected");
    url = BASE_URL+'excs/view_plan/'+selected_tr.find("div.exc_travel_plans").eq(0).attr('exc_travel_plans_id')+'?admin';
    window.location.href = url;
}

