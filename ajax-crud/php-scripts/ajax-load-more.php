<?php

$conn = mysqli_connect("localhost","root","","test1") or die("Connect Fail!");

$limit_per_page = 5;

$page = "";
if(isset($_POST['page_no'])){
    $page = $_POST['page_no'];
}else{
    $page = 0;
}

// $offset = ($page - 1)* $limit_per_page;

$sql = "SELECT * FROM tbl_emp LIMIT {$page},{$limit_per_page}";
$result = mysqli_query($conn,$sql);

$output = "";
if(mysqli_num_rows($result) > 0){
    while($row = mysqli_fetch_assoc($result)){
        // $last_id = $row['id'];
        $output .= "<tbody>";
        $output .= "<tr>
            <th>{$row['id']}</th>
            <td>{$row['name']}</td>
            <td>{$row['designation']}</td>
            <td>
                <button data-eid='{$row['id']}' class='btn btn-warning update-record' data-toggle='modal' data-target='#updateModal'>Update</button>
                <button data-did='{$row['id']}' class='btn btn-danger delete-record' data-toggle='modal' data-target='#deleteModal'>Delete</button>
            </td>
        </tr>";
    }

    $output .= "</tbody>
    <tbody id='load-pagination'>
        <tr>
            <td colspan='4' class='text-center'>
             <button class='btn btn-outline-primary' data-id='".$page + $limit_per_page ."' id='load-btn'>Load More</button>
            </td>
        </tr>
    </tbody>
    ";
    
    echo $output;
}else{
    echo "";
}
mysqli_close($conn);
?>
