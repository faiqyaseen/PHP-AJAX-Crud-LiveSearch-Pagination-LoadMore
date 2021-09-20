<?php

$emp_id = $_POST['emp_id'];

$conn = mysqli_connect("localhost","root","","test1") or die("Connect Fail!");

$sql = "SELECT * FROM tbl_emp WHERE id = $emp_id";
$result = mysqli_query($conn,$sql);

$output = "";
if(mysqli_num_rows($result) > 0){
    while($row = mysqli_fetch_assoc($result)){
        $output .= "
                <div class='modal-body'>
                <input type='hidden' value='{$row['id']}' id='edit-id' class='form-control'>
                <div class='form-group'>
                    <label>Name:</label>
                    <input type='text' value='{$row['name']}' id='edit-name' class='form-control'>
                </div>
                <div class='form-group'>
                    <label>Designation:</label>
                    <input type='text' value='{$row['designation']}' id='edit-desig' class='form-control'>
                </div>
            </div>
            <div class='modal-footer'>
                <button type='button' class='btn btn-secondary' data-dismiss='modal'>Cancel</button>
                <button type='button' class='btn btn-success' id='update' data-dismiss='modal'>Update</button>
            </div> 
        ";
    }

    mysqli_close($conn);
}else{
    $output = "<h4>Record Not Found!</h4>";
}
echo $output;

?>