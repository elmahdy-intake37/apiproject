<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->


<?php

session_start();

if(isset($_POST['register'])){
echo "POST";
  extract($_POST);
  $servername = "localhost";
  $username = "root";
  $password = "root";
  $dbname = "apis";
  $conn = new mysqli($servername, $username, $password, $dbname);
  if ($conn->connect_error) {
      die("Connection failed: " . $conn->connect_error);
  }
  $Email=strtolower($Email);
  $sql = "INSERT INTO login ".
         "(FName,LName,Email,Password) ".
         "VALUES ".
         "('$FName','$LName','$Email',"."md5('$Password'))";


if ($conn->query($sql) === TRUE) {
    echo "New record created successfully";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
}
if(isset($_POST['loginbtn'])){
echo "login";
extract($_POST);
$servername = "localhost";
$username = "root";
$password = "root";
$dbname = "apis";
$Email=strtolower($Email);
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
$sql = "select Password from login where Email='$Email'";
echo $sql;
$SelectedPassword =  $conn->query($sql);
$SelectedPassword=$SelectedPassword->fetch_assoc();
$SelectedPassword = $SelectedPassword['Password'] ;
echo $SelectedPassword."<br>" ;
if ($SelectedPassword == md5($Password)){
  $_SESSION['Email']=$Email;
  $_SESSION['Password']=md5($Password);
  echo "Successfully Login";
}
else {
  echo "Login Failed";
}
// if ($conn->query($sql) === TRUE) {
// $SelectedPassword =  $conn->query($sql);
//     echo "New record created successfully";
// } else {
//     echo "Error: " . $sql . "<br>" . $conn->error;
// }

$conn->close();

}

?>
<html>
    <head>

        <meta charset="UTF-8" name="google-signin-client_id" content="42222171047-juv6hr56qbbr53ock9e4ajtq34p5o5pr.apps.googleusercontent.com">
        <title>Api</title>
        <script src="https://apis.google.com/js/platform.js" async defer>

    </script>
    <script
  src="https://code.jquery.com/jquery-3.1.1.min.js"
  integrity="sha256-hVVnYaiADRTO2PzUGmuLJr8BLUSjGIZsDYGmIJLv2b8="
  crossorigin="anonymous"></script>


        <link href="http://fonts.googleapis.com/css?family=Titillium+Web:400,300,600" rel="stylesheet" type="text/css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/5.0.0/normalize.min.css">


      <link rel="stylesheet" href="css/style.css">







    </head>
    <body>


        <div class="form">

      <ul class="tab-group">
        <li  class="tab active"><a id="signUpForm"  href="#signup">Sign Up</a></li>
        <li class="tab"><a href="#login">Log In</a></li>
      </ul>

      <div class="tab-content">
        <div id="signup">
          <h1>Sign Up for Free</h1>

          <form action="index.php" method="post">

          <div class="top-row">
            <div class="field-wrap">
              <label>
                First Name<span class="req">*</span>
              </label>
              <input name="FName" id="firstName" type="text" required autocomplete="off" />
            </div>

            <div class="field-wrap">
              <label>
                Last Name<span class="req">*</span>
              </label>
              <input name="LName" id="lastName" type="text"required autocomplete="off"/>
            </div>
          </div>

          <div class="field-wrap">
            <label>
              Email Address<span class="req">*</span>
            </label>
            <input name="Email" id="email" type="email"required autocomplete="off"/>
          </div>

          <div class="field-wrap">
            <label>
              Set A Password<span class="req">*</span>
            </label>
            <input name="Password" type="password"required autocomplete="off"/>
          </div>

          <button Name="register" type="submit" class="button button-block">Get Started</button>

          </form>
          <br>
     <div class="g-signin2" data-onsuccess="onSignIn"></div><br>
     <button >linkedin <?php require_once "linkedin/linkedin.php" ?></button>
        </div>

        <div id="login">
          <h1>Welcome Back!</h1>

          <form action="index.php" method="post">

            <div class="field-wrap">
            <label>
              Email Address<span class="req">*</span>
            </label>
            <input name="Email" type="email"required autocomplete="off"/>
          </div>

          <div class="field-wrap">
            <label>
              Password<span class="req">*</span>
            </label>
            <input name="Password" type="password"required autocomplete="off"/>
          </div>

          <p class="forgot"><a href="#">Forgot Password?</a></p>

          <button name="loginbtn" class="button button-block">Log In</button>

          </form>

        </div>

      </div> <!-- tab-content -->

</div> <!-- /form -->
  <script src="http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>

    <script src="js/index.js"></script>

















        <a href="#" onclick="signOut();"><input type="button" value="Logout"/></a>
        <br>
        <input type="button" value="Save" onclick="save();"/>

        <script>
            var url;
            function onSignIn(googleUser) {
  var profile = googleUser.getBasicProfile();
  console.log('ID: ' + profile.getId()); // Do not send to your backend! Use an ID token instead.
  console.log('Name: ' + profile.getName());
  console.log('Image URL: ' + profile.getImageUrl());
  console.log('Email: ' + profile.getEmail()); // This is null if the 'email' scope is not present.
  console.log("callback.php?ID="+ profile.getId()+"&Name="+profile.getName()+"&Email="+profile.getEmail());
             url="callback.php?ID="+ profile.getId()+"&Name="+profile.getName()+"&Email="+profile.getEmail()+"&Image URL="+profile.getImageUrl();
var flag;
$.ajax({
            type: 'POST',
            url: 'checkemail.php',
            data: {
                'ID': profile.getId(),
                'Name': profile.getName(),
                //'given_name': profile.getGivenName(),
                //'family_name': profile.getFamilyName(),
                'Image_URL': profile.getImageUrl(),
                'Email': profile.getEmail(),
                //'id_token': id_token
                'site':"google"
            },

           success: function(msg) {
               flag = msg;
               console.log("message"+msg);
               if(flag == "false"){



                       var select = document.getElementById('email');
                           select.value=profile.getEmail();


               var fullName=profile.getName();
                 fullName=fullName.split(" ");
                 console.log(fullName);
                 document.getElementById('firstName').value=fullName[0];
                 document.getElementById('lastName').value=fullName[1];

               }
               else if(flag == "true") {
                 console.log("tmam");
                window.location.href = 'home.php';
               }
               else {
                 console.log("Some Wrong");
                 console.log(msg);
               }

           }

        });

        // $Email=profile.getEmail();
        // $servername = "localhost";
        // $username = "root";
        // $password = "root";
        // $dbname = "apis";
        // $Email=strtolower($Email);
        // $conn = new mysqli($servername, $username, $password, $dbname);
        // if ($conn-> connect_error) {
        //     die("Connection failed: " . $conn->connect_error);
        // }
        // $sql = "select Email from login where Email='$Email'";
        // echo $sql;
        // if ($conn->query($sql) === TRUE) {
        //     echo "New record created successfully";
        // } else {
        //     echo "Error: " . $sql . "<br>" . $conn->error;
        //










}

//location.href ="#signup";


function signOut() {
    var auth2 = gapi.auth2.getAuthInstance();
    auth2.signOut().then(function () {
      console.log('User signed out.');
    });
  }
  function save(){
      try{
        window.location =url;
                console.log("Save Success");
                signOut();
        }
        catch(e){
        console.log("Save Failed");
        }
        }


            </script>
            <?php
            if (isset($_SESSION['page'])){

?>
<script type="text/javascript">
document.getElementById('firstName').value= <?= "\"".$_SESSION['firstName']."\"";?> ;
document.getElementById('lastName').value= <?=  "\"".$_SESSION['lastName']."\"";?> ;
document.getElementById('email').value= <?=  "\"".$_SESSION['email']."\"";?> ;
</script>
<?PHP
session_destroy();
}



             ?>


    </body>
</html>
