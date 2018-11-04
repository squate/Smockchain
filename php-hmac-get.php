
<?php
// then put the image on the blockchain
$KEY = "ALTR-6121C529220B575AA0B7ED9074A77E5D";
$SECRET = "2c639963d6760359f909f6b84f6803b3393ba726a808ea60929f8c2677933257";
$HOST = "https://dgl-hackathon.dev.altr.com";

function hex_to_base64($hex){
  $return = '';
  foreach(str_split($hex, 2) as $pair){
    $return .= chr(hexdec($pair));
  }
  return base64_encode($return);
}

function hmac($secret, $method, $ref, $date)
{
	$payload = $method . "\n" . $ref . "\n" . date("c", $date) . "\n";
	//echo "Payload: " . $payload;
	$mac =  hex_to_base64(hash_hmac('sha256', $payload, $secret));
	//echo "MAC: " . $mac;
	return $mac;
}

function simpleGet($ref)
{
  global $KEY, $SECRET, $HOST;

  $curl = curl_init();

  $dt = time();
  $mac = hmac($SECRET, "GET", $ref, $dt);

  curl_setopt_array($curl, array(
    CURLOPT_URL => "$HOST/api/v1/chain/$ref",
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => "",
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 30,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => "GET",
    CURLOPT_HTTPHEADER => array(
      "Authorization: ALTR $KEY:$mac",
      "Content-Type: application/json",
      "X-ALTR-DATE:". date("c", $dt) ,
      "cache-control: no-cache"
    ),
  ));
  $response = curl_exec($curl);
  $err = curl_error($curl);

  curl_close($curl);

  if ($err) {
    echo "cURL Error #:" . $err;
  } else {
    return $response;
  }
  return "";
}

function metaGet($ref)
{
  global $KEY, $SECRET, $HOST;

  $curl = curl_init();

  $dt = time();
  $mac = hmac($SECRET, "GET", $ref, $dt);

  curl_setopt_array($curl, array(
    CURLOPT_URL => "$HOST/api/v1/chain/$ref/metadata",
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => "",
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 30,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => "GET",
    CURLOPT_HTTPHEADER => array(
      "Authorization: ALTR $KEY:$mac",
      "Content-Type: application/json",
      "X-ALTR-DATE:". date("c", $dt) ,
      "X-ALTR-METADATA:". date("c", $dt),
      "cache-control: no-cache"
    ),
  ));
  $response = curl_exec($curl);
  $err = curl_error($curl);

  curl_close($curl);

  if ($err) {
    echo "cURL Error #:" . $err;
  } else {
    return $response;
  }
  return "";
}

function test($test_hash, $refToken)
{
   //echo "Doing Get. \n";
   $getResp = simpleGet($refToken);
   $metaResp = metaGet($refToken);
   // echo $getResp;
   // echo "<br>";
   // echo $metaResp;
   $respEx = explode(",", $getResp);
   $metaEx = explode(",", $metaResp);
   $hash = substr($respEx[0], 11);
   $capD = substr($respEx[1], 11);
   $cap = rtrim($capD, "}");
   $metaExEx = explode("\"", $metaEx[1]);
   $time = $metaExEx[7];
   //$date = $getResp["X-ALTR-METADATA"];
   //$cap = rtrim($getResp);
   //$irlcap = strstr(strstr($cap, "caption" ), ":");
   //$toke = ltrim(strstr(strstr($getResp, "\":"), " ,", true), "\":");

   //echo "<br/><br/>".$cap."<br/><br/>";
   //echo "<br/><br/>".$toke."<br/><br/>";
   //var_dump($getResp);

   echo"<br/><br/>key image: ". $hash ;
   echo"<br/>new image: ". $test_hash ;
   if ($hash - $test_hash == 0){
     echo " <br/><h1>this is the same image. <br.> Date of upload: ".$time;
     echo "</h1><br/><br/><h2>Artist's words:<blockquote></h2>".$cap."</blockquote>";
     return true;
   }else{
     echo "<br><br><h1>this isn't the picture the token points to. It's different.</h1>";
     return false;
   }
}
$path = "uploads/thx.jpg";
$hashH = hash_file("snefru", $path);
$caption = $_GET["token"];

$show = test($hashH, $caption);
if ($show)
  echo "<img src=\"$path\">";
?>
