<?php
session_start();
if (isset($_SESSION['Email']))
  {
 ?>
<html>
    <head>

        <meta charset="UTF-8" name="google-signin-client_id" content="42222171047-juv6hr56qbbr53ock9e4ajtq34p5o5pr.apps.googleusercontent.com">
        <script src="https://apis.google.com/js/platform.js" async defer>
        <link href="http://fonts.googleapis.com/css?family=Titillium+Web:400,300,600" rel="stylesheet" type="text/css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/5.0.0/normalize.min.css">


</script>
</head>
<body>


<?php

echo "Welcome to Home Page";





 ?>
 <script src="https://apis.google.com/js/platform.js?onload=onLoad" async defer></script>
 <script>
    function signOut() {
      var auth2 = gapi.auth2.getAuthInstance();
      auth2.signOut().then(function () {
        console.log('User signed out.');
      });
    }
<?php session_destroy(); ?>
    function onLoad() {
      gapi.load('auth2', function() {
        gapi.auth2.init();
      });
    }
  </script>
 <!-- <script type="text/javascript">

 function signOut() {
     var auth2 = gapi.auth2.getAuthInstance();
     auth2.signOut().then(function () {
       console.log('User signed out.');
     });
   }
 </script> -->

 <a href="/" onclick="signOut();"><input type="button" value="Logout"/></a>

</body>
</html>
<?php }
else {
  header('Location: /');
} ?>
