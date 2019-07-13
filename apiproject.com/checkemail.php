<?php

//
//
session_start();
if ( $_SERVER['REQUEST_METHOD']=='POST' ){
     extract($_POST);
     //print_r($_POST);
//     $flag = false;
     }
// else{
//     extract ($_GET);
//     $flag = true;
// }
//print_r($_GET);
if ($site == 'google'){
  $site = 'Google_ID';
}
else if($site == 'linkedin') {
  $site = 'LinkedIn_ID';
}
$servername = "localhost";
$username = "root";
$password = "root";
$dbname = "apis";
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
//$Email = "MGnedy@Gmail.com";
$sql = "select Email from login where Email='$Email'";
$result = $conn->query($sql);
if($result){
  //echo "true"."<br>";
  //echo $Email."<br>";


  $row = $result->fetch_assoc();
  if (empty($row['Email'])) {

    echo "false";
  }
  else if(strcasecmp($row['Email'],$Email) == 0){
    $sql = "select $site from login where Email='$Email'";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();
    //echo $row['Google_ID'];
    if (!empty($row[$site])){
      echo "true";

      $_SESSION['Email']=$Email;
    }
    else {

      $sql = "UPDATE login ".
             "set $site ='$ID'".
            " where Email='$Email'";
             if ($conn->query($sql) === TRUE) {
                 echo "true";
             } else {
                 echo "Error: " . $sql . "<br>" . $conn->error;
             }



    }
  }
}
else {
  echo "false";
}


$conn->close();
?>
