
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

function simplePut($body)
{
  global $KEY, $SECRET, $HOST;

  //print "KEY: $KEY $SECRET $HOST";

  $curl = curl_init();
  $dt = time();
  $mac = hmac($SECRET, "POST", "", $dt);
  curl_setopt_array($curl, array(
    CURLOPT_URL => "$HOST/api/v1/chain",
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => "",
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 30,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => "POST",
    CURLOPT_POSTFIELDS => $body,
    CURLOPT_HTTPHEADER => array(
      "Authorization: ALTR $KEY:$mac",
      "Content-Type: application/json",
      "X-ALTR-DATE:". date("c", $dt),
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

function test($img_str, $caption)
{
   $putResp = simplePut("{\"img_str\": ".$img_str." , \"caption\": ".$caption."}");
   $putData = json_decode($putResp);
   $refToken = $putData->response->data->referenceToken;
   //echo $img_str;
   echo "<strong>PRESERVATION SUCCESSFUL! </br>YOUR TOKEN IS: <br/><br/></strong>".$refToken."<strong> <br/><br/>WRITE IT DOWN NOW.</strong>";
}
$path = "uploads/thx.jpg";
$hash = hash_file("snefru", $path);
$capt = $_GET["sourceString"];
//print_r($_GET);
test($hash, $capt);

?>
