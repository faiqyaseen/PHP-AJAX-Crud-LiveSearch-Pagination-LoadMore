<?php

$emp_id = $_POST['emp_id'];

$conn = mysqli_connect("localhost","root","","test1") or die("Connect Fail!");

$sql = "DELETE FROM tbl_emp WHERE id = $emp_id";

if(mysqli_query($conn,$sql)){
    echo 1;
}
else{
    echo 0;
}


?>