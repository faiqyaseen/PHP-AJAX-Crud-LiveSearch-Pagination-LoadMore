<?php

$emp_name = $_POST['emp_name'];
$emp_desig = $_POST['emp_desig'];

$conn = mysqli_connect("localhost","root","","test1") or die("Connect Fail!");
$sql = "INSERT INTO tbl_emp(name, designation) VALUES ('$emp_name','$emp_desig')";
if(mysqli_query($conn,$sql)){
    echo 1;
}
else{
    echo 0;
}


?>