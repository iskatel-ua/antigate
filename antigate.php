<?php
$getcap ='file.png';
$setImg = [
 "clientKey" => $key_antigate, // API keys
 "task" =>
  [
   "type" => "ImageToTextTask",
   "body" => getImgCookie($getcap),
   "phrase" => false,
   "case" => false,
   "numeric" => false,
   "math" => 0,
   "minLength" => 0,
   "maxLength" => 0
  ]
];
$getresult = [
 "clientKey" => $key_antigate,
 "taskId" => antigate($key_antigate,'http://api.anti-captcha.com/createTask', $setImg)->taskId
];

sleep(40);

function antigate($key_antigate, $url, $data)
  {
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
    $output = json_decode(curl_exec($ch));
    return $output;
}

function getImgCookie($getcap){
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL,$getcap );
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
  curl_setopt($ch, CURLOPT_COOKIEJAR, $_SERVER['DOCUMENT_ROOT'].'/tmp/antigate.txt');
  $output = curl_exec($ch);
  curl_close($ch);
  file_put_contents($_SERVER['DOCUMENT_ROOT'].'/tmp/antigate.png', $output);
  return base64_encode(file_get_contents($_SERVER['DOCUMENT_ROOT'].'/tmp/antigate.png'));
}