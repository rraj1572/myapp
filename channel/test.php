<?php

$id =$_GET['id'];

$curl = curl_init();
$url="https://userauth.voot.com/usersV3/v3/login";
curl_setopt_array($curl, array(
  CURLOPT_URL => $url,
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_CUSTOMREQUEST => 'POST',
  CURLOPT_POSTFIELDS =>'{"type":"traditional","deviceId":"ecb8da87-6589-46ba-963c-2dc9a61757bb","deviceBrand":"PC/MAC","data":{"email":"ankitmail7@gmail.com","password":"iamsom"}}',
  CURLOPT_HTTPHEADER => array(
'Content-Type: application/json',
  ),
));

$response = curl_exec($curl);
curl_close($curl);

$zx = json_decode($response, true);
$atoken= $zx['data']['authToken']['accessToken'];

$xcurl = curl_init();
$xurl="https://tv.media.jio.com/apis/v1.6/getchannelurl/getchannelurl";
curl_setopt_array($xcurl, array(
  CURLOPT_URL => $xurl,
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_CUSTOMREQUEST => 'POST',
  CURLOPT_HTTPHEADER => array(
'voottoken: '.$atoken,
'vootid: 1301',
'platform: androidwebdesktop',
  ),
));

$xresponse = curl_exec($xcurl);
curl_close($xcurl);
$xzx = json_decode($xresponse, true);
$m3u8= $xzx['m3u8'];
$cookie = end(explode('index.m3u8?', $m3u8));

$final ="https://jiolivestreaming.akamaized.net/bpk-tv/M2_$id/Fallback/index.m3u8?$cookie";

header("Location: $final");

?>
