<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
</head>

<body>

    <div class="container">
        <div class="row mt-3">
            <div class="col-md-12">
                <div class="row">
                    <div class="col-md-6">
                        <h3>Employee Data</h3>
                    </div>
                    <div class="col-md-6 mb-2">
                        <input type="text" id="search" placeholder="Search" name="" id="" class="form-control">
                    </div>
                </div>
                <div class="col-md-12 delete-update-message">
                </div>
                <div class="col-md-12" >
                    <table class='table' id="employeeData">
                        <thead class='thead-dark'>
                            <tr>
                                <th>Id</th>
                                <th>Name</th>
                                <th>Designation</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        
                    </table>
                </div>
            </div>

        </div>
    </div>

    <script src="js/jquery.js"></script>
    <script src="js/bootstrap.bundle.min.js"></script>

    <script>
        $(document).ready(function() {
            function loadRecord(page) {
                $.ajax({
                    url: "php-scripts/ajax-load-more.php",
                    type: "POST",
                    data: {
                        page_no: page
                    },
                    success: function(data) {
                        if(data){
                            $("#load-pagination").remove();
                            $("#employeeData").append(data);
                        }else{
                            $("#load-btn").addClass("disabled").removeClass("btn-outline-primary").html("Finished");
                        }
                        
                    }
                })
            }
            loadRecord();
            $(document).on("click", "#load-btn", function() {
                $("#load-btn").html("Loading..");

                var pid = $(this).data("id");
                loadRecord(pid);
            })
            
            $(document).on("click", ".delete-record", function() {
                var element = this;
                $("#confirm-delete").on("click", function() {
                    var empId = $(element).data("did");
                    $.ajax({
                        url: "php-scripts/delete.php",
                        type: "POST",
                        data: {
                            emp_id: empId
                        },
                        success: function(data) {
                            if (data == 1) {
                                $(".delete-update-message").html("<p><b>Deleted Successfully</b></p>").addClass("p-1 mt-1 alert alert-success")
                                setTimeout(function() {
                                    $(".delete-update-message").html("").removeClass("p-1 mt-1 alert alert-success")
                                }, 5000)
                                loadRecord();
                            } else {
                                $(".delete-update-message").html("<p><b>Can't Delete</b></p>").addClass("p-1 mt-1 alert alert-danger")
                                setTimeout(function() {
                                    $(".delete-update-message").html("").removeClass("p-1 mt-1 alert alert-danger")
                                }, 5000)
                            }
                        }
                    })
                })
            })
            $(document).on("click", ".update-record", function() {
                var empId = $(this).data("eid");
                $.ajax({
                    url: "php-scripts/load-update.php",
                    type: "POST",
                    data: {
                        emp_id: empId
                    },
                    success: function(data) {
                        $("#modal-form-record").html(data);
                    }
                })
            })
            $(document).on("click", "#update", function() {
                var empId = $("#edit-id").val();
                var empName = $("#edit-name").val();
                var empDesig = $("#edit-desig").val();
                $.ajax({
                    url: "php-scripts/update.php",
                    type: "POST",
                    data: {
                        emp_id: empId,
                        emp_name: empName,
                        emp_desig: empDesig
                    },
                    success: function(data) {
                        if (data == 1) {
                            $(".delete-update-message").html("<p><b>Updated Successfully</b></p>").addClass("p-1 mt-1 alert alert-success")
                            setTimeout(function() {
                                $(".delete-update-message").html("").removeClass("p-1 mt-1 alert alert-success")
                            }, 5000)
                            loadRecord();
                        } else {
                            $(".delete-update-message").html("<p><b>Can't Updated</b></p>").addClass("p-1 mt-1 alert alert-danger")
                            setTimeout(function() {
                                $(".delete-update-message").html("").removeClass("p-1 mt-1 alert alert-danger")
                            }, 5000)
                        }
                    }
                })
            })
            $("#search").on("keyup", function() {
                var search_term = $(this).val();
                if (search_term == "") {
                    loadRecord();
                } else {
                    $.ajax({
                        url: "php-scripts/live-search.php",
                        type: "POST",
                        data: {
                            search: search_term
                        },
                        success: function(data) {
                            $("#employeeData").html(data);
                        }
                    })
                }

            })
        })
    </script>
</body>

</html>