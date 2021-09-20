<?php

$search = $_POST['search'];

$conn = mysqli_connect("localhost","root","","test1") or die("Connect Fail!");

$sql = "SELECT * FROM tbl_emp WHERE name LIKE '%{$search}%' OR designation LIKE '%{$search}%' ";
$result = mysqli_query($conn,$sql);

$output = "";
if(mysqli_num_rows($result) > 0){
    $output .= "<table class='table'>
    <thead class='thead-dark'>
        <tr>
            <th>Id</th>
            <th>Name</th>
            <th>Designation</th>
            <th>Action</th>
        </tr>
    </thead>";
    while($row = mysqli_fetch_assoc($result)){
        $output .= "<tbody>
        <tr>
            <th>{$row['id']}</th>
            <td>{$row['name']}</td>
            <td>{$row['designation']}</td>
            <td>
                <button data-eid='{$row['id']}' class='btn btn-warning update-record' data-toggle='modal' data-target='#updateModal'>Update</button>
                <button data-did='{$row['id']}' class='btn btn-danger delete-record' data-toggle='modal' data-target='#deleteModal'>Delete</button>
            </td>
        </tr>
    </tbody>";
    }
    $output .= "</table>";
    mysqli_close($conn);
}else{
    $output = "<h4>Record Not Found!</h4>";
}
echo $output;


?>