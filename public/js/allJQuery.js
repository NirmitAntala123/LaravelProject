
$(document).ready(function () {
    setTimeout(function(){
        $('#massage').html('');
    }, 5000);
    $('.toggle-class').change(function() {
        var status = $(this).prop('checked') == true ? 1 : 0; 
        var user_id = $(this).attr('id'); 
        $.ajax({
            type: "GET",
            dataType: "json",
            url: '/userChangeStatus',
            data: {'status': status, 'user_id': user_id},
            success: function(data){
                if(data.error==1){
                    var id ='#'+user_id
                    $(id).parent().removeClass("btn-danger off").addClass("btn-success");
                    $("#massage").html(data.massage);
                }
                $("#massage").html(data.success);
            }
        });
    })
    $("#myInput").on("keyup", function () {
        var value = $(this).val().toLowerCase();
        $("#myTable tr").filter(function () {
            $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1);
        });
    });
    $("#showdata").hide();
    $.ajaxSetup({
        headers: {
            "X-CSRF-Token": $('meta[name="_token"]').attr("content"),
        },
    });

    $("#master").on("click", function (e) {
        if ($(this).is(":checked", true)) {
            $(".sub_chk").prop("checked", true);
        } else {
            $(".sub_chk").prop("checked", false);
        }
    });

    $(".delete_all").on("click", function (e) {
        var allVals = [];
        $(".sub_chk:checked").each(function () {
            allVals.push($(this).attr("data-id"));
        });

        if (allVals.length <= 0) {
            alert("Please select row.");
        } else {
            swal({
                title: `Are you sure you want to delete this record?`,
                text: "If you delete this, it will be gone forever.",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            }).then((isConfirm) => {
                if (isConfirm) {
                    var join_selected_values = allVals.join(",");
                    console.log($(this).data("url"));
                    $.ajax({
                        url: $(this).data("url"),
                        type: "DELETE",
                        headers: {
                            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                                "content"
                            ),
                        },
                        data: "ids=" + join_selected_values,
                        success: function (data) {
                            if (data["success"]) {
                                $(".sub_chk:checked").each(function () {
                                    $(this).parents("tr").remove();
                                });
                                swal({
                                    title: data["success"],
                                    icon: "warning",
                                    dangerMode: true,
                                })
                            } else if (data["error"]) {
                                swal({
                                    title: data["error"],
                                    icon: "warning",
                                    dangerMode: true,
                                })
                            } else {
                                alert("Whoops Something went wrong!!");
                                swal({
                                    title: `Whoops Something went wrong!!`,
                                    icon: "warning",
                                    dangerMode: true,
                                })
                            }
                        },
                        error: function (data) {
                            alert(data.responseText);
                            swal({
                                title: data.responseText,
                                icon: "warning",
                                dangerMode: true,
                            })
                        },
                    });
                }
            });
        }
    });

});
function loadlink() {
    currLoc = $(location).attr("href");
    // console.log(currLoc);
    // $("#container").load(currLoc, function() {
    //     $('#container').unwrap();
    // });
    var spinner =
        "<img src='http://i.imgur.com/pKopwXp.gif' alt='loading...' />";
    $(".reload").html(spinner).load(currLoc);
}

$(document).on("click", ".delete", function (e) {
    var id = $(this).attr("id");
   
    // e.preventDefault();
    swal({
        title: `Are you sure you want to delete this record?`,
        text: "If you delete this, it will be gone forever.",
        icon: "warning",
        buttons: true,
        dangerMode: true,
    }).then((isConfirm) => {
        if (isConfirm) {
            var token = $('meta[name="csrf_token"]').attr("content");
            $.ajax({
                url: base_path + "/companies" + "/" + id,
                type: "POST",
                method: "DELETE",
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                        "content"
                    ),
                },
                success: function (response) {
                    // $(id).closest("tr").remove();
                    $('#'+id).remove();
                    swal(
                        "Deleted!",
                        "Your record has been deleted.",
                        "success"
                    );
                   
                },
            });
        }
    });
});
var base_path = window.location.protocol + "//" + window.location.host;
$("#search").on("keyup", function () {
    $value = $(this).val();
    $.ajax({
        type: "get",
        url: base_path + "/companies",
        data: {
            search: $value,
        },
        success: function (data) {
            $("#tbody").html(data);
        },
    });
});
$("#showjson").on("click", function () {
    $("#showdata").toggle();
});