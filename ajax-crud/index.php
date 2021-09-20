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
            <div class="col-md-6 ">
                <div class="col-md-12">
                    <h3>Add Data</h3>
                </div>
                <div class="col-md-12 bg-warning p-3">
                    <form id="form-data">
                        <div class="form-group">
                            <input type="text" class="form-control" id="empName" placeholder="Name">
                        </div>
                        <div class="form-group">
                            <input type="text" class="form-control" id="empDesig" placeholder="Designation">
                        </div>
                        <div class="form-group">
                            <button id="saveEmp" class="btn btn-primary">Add</button>
                            <div id="addMessage"></div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="col-md-6">
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
                <div class="col-md-12" id="employeeData">
                </div>
            </div>

        </div>
    </div>

    <!-- MODELS -->

    <!-- DELETE MODAL -->
    <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-body">
                    Do You Really Want To Delete This Record?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
                    <button type="button" class="btn btn-danger" id="confirm-delete" data-dismiss="modal">Yes Delete It</button>
                </div>
            </div>
        </div>
    </div>

    <!-- UPDATE MODAL -->
    <div class="modal fade" id="updateModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    Modify Details
                </div>
                <div id="modal-form-record">

                </div>
            </div>
        </div>
    </div>


    <script src="js/jquery.js"></script>
    <script src="js/bootstrap.bundle.min.js"></script>

    <script>
        $(document).ready(function() {

            // LOAD DATA
            function loadRecord() {
                $.ajax({
                    url: "php-scripts/show.php",
                    type: "POST",
                    success: function(data) {
                        $("#employeeData").html(data);
                    }
                })
            }
            loadRecord();

            // INSERT DATA
            $("#saveEmp").on("click", function(e) {
                e.preventDefault();
                var empName = $("#empName").val();
                var empDesig = $("#empDesig").val();

                if (empName == "" || empDesig == "") {
                    $("#addMessage").html("<p><b>All Fields Are Required.!</b></p>").addClass("p-1 mt-1 alert alert-danger")
                    setTimeout(function() {
                        $("#addMessage").html("").removeClass("p-1 mt-1 alert alert-danger")
                    }, 5000)
                } else {
                    $.ajax({
                        url: "php-scripts/add-emp.php",
                        type: "POST",
                        data: {
                            emp_name: empName,
                            emp_desig: empDesig
                        },
                        success: function(data) {
                            if (data == 1) {
                                loadRecord()
                                $("#addMessage").html("<p><b>Added Successfully.!</b></p>").addClass("p-1 mt-1 alert alert-success")
                                setTimeout(function() {
                                    $("#addMessage").html("").removeClass("p-1 mt-1 alert alert-success")
                                }, 5000)
                                $("#form-data").trigger("reset");
                            }
                        }
                    })
                }
            })


            // DELETE DATA
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


            // LOAD DATA IN UPDATE FORM
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

            // UPDATE DATA
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

            
            //LIVE SEARCH
            $("#search").on("keyup",function(){
                var search_term = $(this).val();

                $.ajax({
                    url: "php-scripts/live-search.php",
                    type: "POST",
                    data:{
                        search: search_term
                    },
                    success: function(data){
                        $("#employeeData").html(data);
                    }
                })
            })
        })
    </script>
</body>

</html>