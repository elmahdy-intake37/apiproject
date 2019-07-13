<?php
//echo $_POST;
session_start();
extract($_GET);
$grant_type = "authorization_code";
$redirect_uri ="http://apiproject.com/linkedin/callback.php";
$client_id = "86qug4ofltqb55";
$client_secret = "M6jQohb1dWpnu8z7";

$fields = array(
                'grant_type' => urlencode($grant_type) ,
                'code'      => $code,
                'redirect_uri'=> urlencode($redirect_uri),
                'client_id'   => $client_id,
                'client_secret' => $client_secret
 );

foreach ($fields as $key => $value) {
  $urlString.=$key."=".$value."&";

}
$urlString = rtrim($urlString,'&');
//echo $urlString;
echo "<br>";
$ch = curl_init();
// CURLOPT_RETURNTRANSFER
// CURLOPT_SSL_VERIFYPEER
// CURLOPT_SSL_VERIFYHOST
// CURLOPT_URL
// CURLOPT_POST
// CURLOPT_POSTFIELDS
// CURLOPT_HTTPHEADER
$url = "https://www.linkedin.com/oauth/v2/accessToken";

curl_setopt($ch, CURLOPT_HEADER, 0);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true );
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
curl_setopt($ch, CURLOPT_URL,$url);
curl_setopt($ch, CURLOPT_POST, count($fields));
curl_setopt($ch, CURLOPT_POSTFIELDS,$urlString);
$rr = curl_exec($ch);

curl_close($ch);

//echo $rr;
echo "<br>";
$details=json_decode ($rr,true);
//echo $details;
//print_r($details);
$access_token = $details['access_token'];
//echo $access_token;
$authorization ="Authorization: Bearer ".$access_token;

//$url2 = "https://api.linkedin.com/v1/people/~?oauth2_access_token=".$access_token."&format=json";

$url2 = "https://api.linkedin.com/v1/people/~:(id,first-name,email-address,last-name,headline,picture-url,industry,summary,specialties,positions:(id,title,summary,start-date,end-date,is-current,company:(id,name,type,size,industry,ticker)),educations:(id,school-name,field-of-study,start-date,end-date,degree,activities,notes),associations,interests,num-recommenders,date-of-birth,publications:(id,title,publisher:(name),authors:(id,name),date,url,summary),patents:(id,title,summary,number,status:(id,name),office:(name),inventors:(id,name),date,url),languages:(id,language:(name),proficiency:(level,name)),skills:(id,skill:(name)),certifications:(id,name,authority:(name),number,start-date,end-date),courses:(id,name,number),recommendations-received:(id,recommendation-type,recommendation-text,recommender),honors-awards,three-current-positions,three-past-positions,volunteer)?oauth2_access_token=".$access_token."&format=json";


$ch = curl_init($url2);
//curl_setopt($ch, CURLOPT_HTTPHEADER, array($authorization));

// curl_setopt($ch, CURLOPT_HTTPHEADER,$authorization );
    // curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
     curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    // curl_setopt($ch, CURLOPT_POSTFIELDS,array());
    // curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    // curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
    // curl_setopt($ch, CURLOPT_URL,$url2);
    // curl_setopt_array($curl, array(
    //       CURLOPT_HTTPHEADER      => array('Content-Type: application/x-www-form-urlencoded'),
    //       CURLOPT_RETURNTRANSFER  => 1,
    //       CURLOPT_URL             => 'https://www.linkedin.com/oauth/v2/accessToken?grant_type=authorization_code&code='.$authorization_code.'&client_id=client_id&client_secret=app_secret&redirect_uri=domain',
    //       CURLOPT_USERAGENT       => 'To get access token',
    //       CURLOPT_POST            => 1,
    //       CURLOPT_POSTFIELDS      => array());
    //curl_setopt($ch, CURLOPT_POST, count($details));
    // curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
    $result = curl_exec($ch);
    curl_close($ch);
//echo $result;
$info = json_decode($result,true);
//print_r($info);
// echo $info['emailAddress'];
// echo $info['id'];
// echo $info['firstName'];
// echo $info['lastName'];
// echo "<br>";
// foreach ($info as $key => $value) {
//   echo $key." : ".$value."<br>";
// }
//
// print_r($info['siteStandardProfileRequest']);
// echo $info['siteStandardProfileRequest'];
// print_r($info['positions']);
//
// retrive accesstoken by CURL
// get info by access token
// insert db


?>



<?php
$url = 'http://apiproject.com/checkemail.php';
$fields = array(
            'ID'=>$info['id'],
            'Email'=>$info['emailAddress'],
            'firstName'=>$info['firstName'],
            'LastName'=>$info['lastName'],
            'site'=>"linkedin"
        );

//url-ify the data for the POST
foreach($fields as $key=>$value) { $fields_string .= $key.'='.$value.'&'; }
$fields_string = rtrim($fields_string,'&');
//echo $fields_string;
//open connection
$ch = curl_init();

//set the url, number of POST vars, POST data
curl_setopt( $ch, CURLOPT_POST, 1);
curl_setopt($ch,CURLOPT_URL,$url);
curl_setopt($ch,CURLOPT_POST,count($fields));
curl_setopt($ch,CURLOPT_POSTFIELDS,$fields_string);
curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1);

//execute post
$result = curl_exec($ch);

if($result == "true"){
  $_SESSION['Email']=$info['emailAddress'];
  header("Location: http://apiproject.com/home.php");
}
else {
  // //header('Location:/');
  // $url = 'http://apiproject.com/index.php';
  // $fields = array(
  //             'ID'=>$info['id'],
  //             'Email'=>$info['emailAddress'],
  //             'firstName'=>$info['firstName'],
  //             'LastName'=>$info['lastName'],
  //             'site'=>"linkedin",
  //             'page'=>'linkedin'
  //         );
  //
  // //url-ify the data for the POST
  // foreach($fields as $key=>$value) { $fields_string .= $key.'='.$value.'&'; }
  // $fields_string = rtrim($fields_string,'&');
  // //echo $fields_string;
  // //open connection
  // $ch = curl_init();
  //
  // //set the url, number of POST vars, POST data
  // curl_setopt( $ch, CURLOPT_POST, 1);
  // curl_setopt($ch,CURLOPT_URL,$url);
  // curl_setopt($ch,CURLOPT_POST,count($fields));
  // curl_setopt($ch,CURLOPT_POSTFIELDS,$fields_string);
  // curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1);
  //
  // //execute post
  // $result = curl_exec($ch);
  $_SESSION['page']="linkedin";
  $_SESSION['firstName']=$info['firstName'];
  $_SESSION['lastName']=$info['lastName'];
  $_SESSION['email']=$info['emailAddress'];
   header("Location: http://apiproject.com/");
}
?>
