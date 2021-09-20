<?php

$emp_id = $_POST['emp_id'];
$emp_name = $_POST['emp_name'];
$emp_desig = $_POST['emp_desig'];

$conn = mysqli_connect("localhost","root","","test1") or die("Connect Fail!");

$sql = "UPDATE tbl_emp SET name='$emp_name', designation='$emp_desig' WHERE id = $emp_id";

if(mysqli_query($conn,$sql)){
    echo 1;
}
else{
    echo 0;
}


?>