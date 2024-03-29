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
            "url": EXCS_URL+"/excs/travel_plans/my_travel_plan_list",
            "type": "POST",
            "data": function(data) {
                data.CREATED_BY = $('#currentUser').val();
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
        status = $(this).find("div>input.chk_travel_plan").eq(0).attr('travel_plan_status');
        if (status == 201 || status == 204) {
            $('.on_condition').removeClass('disabled');
            $('.management').addClass('disabled');
        }
        else if (status == 210) {
            $('.management').removeClass('disabled');
            $('.on_condition').addClass('disabled');
        }
        else {
            $('.on_condition').addClass('disabled');
            $('.management').addClass('disabled');
        }
    }

    else{
        $('#view').addClass('disabled');
        $('.on_condition').addClass('disabled');
        $('.management').addClass('disabled');
        if ($("input.chk_travel_plan:checked").length >= 1) {
            $('#delete').removeClass('disabled');
        }
    }
});

var selected_tr = '';
var url = '';
var note = '';
var month = '';
var bill_id = '';
function view_plan(){
    selected_tr = $("table#my_table tr.selected");
    url = BASE_URL+'excs/view_plan/'+selected_tr.find("div.exc_travel_plans").eq(0).attr('exc_travel_plans_id');
    window.location.href = url;
}
function edit_plan(){
    selected_tr = $("table#my_table tr.selected");
    url = BASE_URL+'excs/travel_plan/'+selected_tr.find("div.exc_travel_plans").eq(0).attr('exc_travel_plans_id');
    window.location.href = url;
}

function reload_table() {
    table.ajax.reload(null, false); //reload datatable ajax
    $('#view').addClass('disabled');
    $('#clone').addClass('disabled');
    $('.on_condition').addClass('disabled');
}

function delete_plan() {
    if ($("input.chk_travel_plan:checked").length > 1) {
        bootbox.confirm({
            message: "Are you sure you want to delete batch plans?",
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
                    $("input.chk_travel_plan:checked").each(function () {
                        ids += $(this).prop('id');
                        ids += ',';
                    });
                    $.ajax({
                        url: EXCS_URL+'/excs/travel_plans/'+ids,
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
            message: "Are you sure you want to delete the plan?",
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
                    url = EXCS_URL+'/excs/travel_plans/'+selected_tr.find("div.exc_travel_plans").eq(0).attr('exc_travel_plans_id');
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
                                message: 'The plan has been deleted successfully.',
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

function claim_expense() {
    bootbox.confirm({
        message: "Are you sure you want to claim expense for this plan?",
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
        callback: function (shouldProceed) {
            if (shouldProceed) {
                selected_tr = $("table#my_table tr.selected");
                var id = selected_tr.find("div.exc_travel_plans").eq(0).attr('exc_travel_plans_id');
                url = EXCS_URL+'/excs/travel_plans/create_expense_claim';
                $.ajax({
                    url: url,
                    type: 'POST',
                    data: JSON.stringify({
                      'EXC_TRAVEL_PLANS_ID': selected_tr.find("div.exc_travel_plans").eq(0).attr('exc_travel_plans_id')
                    }),
                    error: function(xhr, status, error) {
                        console.log('xhr: ');
                        console.log(xhr);
                        console.log('status: ' + status);
                        console.log('error: ' + error);
                    },
                    success: function(response) {
                        bootbox.alert({
                            message: 'Expense for this plan has been successfully claimed.',
                            className: 'text-success',
                            callback: function () {
                                window.location.href = BASE_URL+'excs/expense_claim/'+response.data.exc_claim_requests_id;
                            }
                        });
                    }

                });
            }
        }
    });
}

