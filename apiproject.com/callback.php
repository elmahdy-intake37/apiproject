<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
if ( $_SERVER['REQUEST_METHOD']=='POST' ){
    extract($_POST);
    $flag = false;
    }
else{
    extract ($_GET);
    $flag = true;
}
//print_r($_GET);
$servername = "localhost";
$username = "root";
$password = "root";
$dbname = "apis";
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 

$sql = "INSERT INTO social ".
       "(Name, Email,Image_URL,User_ID) ".
       "VALUES ".
       "('$Name','$Email','$Image_URL',$ID)";

if ($conn->query($sql) === TRUE) {
    echo "New record created successfully";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
if($flag){
    echo"<html>
    <script>
    var auth2 = gapi.auth2.getAuthInstance();
    auth2.signOut().then(function () {
        console.log('User signed out.'); </script></html>";
        
header("Location: /");
}
?>