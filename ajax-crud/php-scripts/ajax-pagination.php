<?php

$conn = mysqli_connect("localhost","root","","test1") or die("Connect Fail!");

$limit_per_page = 5;

$page = "";
if(isset($_POST['page_no'])){
    $page = $_POST['page_no'];
}else{
    $page = 1;
}

$offset = ($page - 1)* $limit_per_page;

$sql = "SELECT * FROM tbl_emp LIMIT {$offset},{$limit_per_page}";
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

    $sql_total = "SELECT * FROM tbl_emp";
    $records = mysqli_query($conn,$sql_total) or die("QUERY FAILED.!");
    $otal_records = mysqli_num_rows($records);
    $total_pages = ceil($otal_records/$limit_per_page);

    if($page <= 1){
        $prev_class_disable = "disabled";
    }
    else{
        $prev_class_disable = "";
    }
    $output .= "
    <div class='col-md-12 m-auto text-center'>
        <nav>
            <ul class='pagination'>
            <li class='page-item {$prev_class_disable}'>
                <a class='page-link' id='";$output .= $page - 1;  $output .= "' href=''>Previous</a>
            </li>";

    for($i=1; $i<=$total_pages; $i++){
        if($i == $page){
            $active_class = "active";
        }else{
            $active_class = "";
        }
        $output .= "
            
            <li class='page-item {$active_class}'>
            <a class='page-link' id='{$i}' href=''>{$i}</a>
            </li>
            
    ";
    }
    if($page == $total_pages){
        $next_class_disable = "disabled";
    }else{
        $next_class_disable = "";
    }
    $output .= "
    <li class='page-item {$next_class_disable}'>
                <a class='page-link' id='";$output .= $page + 1;  $output .= "' href=''>Next</a>
            </li>
    </ul>
    </nav>
</div>
";
    
    mysqli_close($conn);
}else{
    $output = "<h4>Record Not Found!</h4>";
}
echo $output;
