<?php
$conn = mysqli_connect("localhost", "root", "", "electronics");
if(!$conn){
    die("Database Connection Failed: " . mysqli_connect_error());
}
?>
