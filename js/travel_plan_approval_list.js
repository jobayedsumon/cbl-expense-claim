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
            "url": EXCS_URL+"/excs/travel_plans/approval_travel_plan_list",
            "type": "POST",
            "data": function(data) {
                data.CURRENT_APPROVAL_PERSON = $('#currentApprovalPerson').val();
                data.CREATED_BY = $('#createdBy').val();
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
        if ($("input.chk_travel_plan:checked").length >= 1) {
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
function view_plan(){
    selected_tr = $("table#my_table tr.selected");
    url = BASE_URL+'excs/view_plan/'+selected_tr.find("div.exc_travel_plans").eq(0).attr('exc_travel_plans_id')+'?approver';
    window.location.href = url;
}

function reload_table() {
    table.ajax.reload(null, false); //reload datatable ajax
    $('#view').addClass('disabled');
    $('#approve').addClass('disabled');
    $('.on_condition').addClass('disabled');
}

function approve_plan() {
    if ($("input.chk_travel_plan:checked").length > 1) {
        bootbox.confirm({
            message: "Are you sure you want to approve batch travel plans?",
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
            callback: function (shouldApprove) {
                if (shouldApprove) {
                    var ids = '';
                    $("input.chk_travel_plan:checked").each(function () {
                        ids += $(this).prop('id');
                        ids += ',';
                    });
                    var data = JSON.stringify({
                        "CURRENT_APPROVAL_PERSON": $('#currentApprovalPerson').val(),
                        "EXC_TRAVEL_PLANS_ID": ids,
                        "BUTTON": "APPROVE"
                    });
                    $.ajax({
                        url: EXCS_URL+'/excs/travel_plans/process',
                        type: 'POST',
                        data: data,
                        error: function(xhr, status, error) {
                            console.log('xhr: ');
                            console.log(xhr);
                            console.log('status: ' + status);
                            console.log('error: ' + error);
                        },
                        success: function(response) {
                            bootbox.alert({
                                message: 'All travel plans have been approved successfully.',
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
            message: "Are you sure you want to approve this travel plan?",
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
            callback: function (shouldApprove) {
                if (shouldApprove) {
                    selected_tr = $("table#my_table tr.selected");
                    var id = selected_tr.find("div.exc_travel_plans").eq(0).attr('exc_travel_plans_id');
                    var data = JSON.stringify({
                        "CURRENT_APPROVAL_PERSON": $('#currentApprovalPerson').val(),
                        "EXC_TRAVEL_PLANS_ID": id,
                        "BUTTON": "APPROVE"
                    });
                    $.ajax({
                        url: EXCS_URL+'/excs/travel_plans/process',
                        type: 'POST',
                        data: data,
                        error: function(xhr, status, error) {
                            console.log('xhr: ');
                            console.log(xhr);
                            console.log('status: ' + status);
                            console.log('error: ' + error);
                        },
                        success: function(response) {
                            bootbox.alert({
                                message: 'The travel plan has been approved successfully.',
                                className: 'text-success',
                                callback: reload_table()
                            });
                            $("#chk_all_at_a_time").prop('checked', false);
                        }

                    });
                }
            }
        });
    }


}

