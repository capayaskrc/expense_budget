<?php 
require_once('db-connect.php');
if($_SERVER['REQUEST_METHOD'] !='POST'){
    echo "<script> alert('Error: No data to save.'); location.replace('./') </script>";
    $conn->close();
    exit;
}
extract($_POST);
$allday = isset($allday);

if(empty($id)){
    $sql = "INSERT INTO `schedule_list` (`activities`,`start_datetime`,`end_datetime`) VALUES ('$activities','$start_datetime','$end_datetime')";
}else{
    $sql = "UPDATE `schedule_list` set `activities` = '{$activities}', `start_datetime` = '{$start_datetime}', `end_datetime` = '{$end_datetime}' where `id` = '{$id}'";
}
$save = $conn->query($sql);
if($save){
    echo "<script> alert('Planning and Budgeting Successfully Saved.'); location.replace('./') </script>";
}else{
    echo "<pre>";
    echo "An Error occured.<br>";
    echo "Error: ".$conn->error."<br>";
    echo "SQL: ".$sql."<br>";
    echo "</pre>";
}
$conn->close();
?>