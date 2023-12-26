<?php
$token = !empty($_GET) ? $_GET['token'] : "";
if (!empty($token)) {
    $value = "http://www.libreeze.top/web/aCloud/api/v1/gpictures.php?userToken=$token";
    $resource = curl_init();
    curl_setopt($resource, CURLOPT_CUSTOMREQUEST, "GET");
    curl_setopt($resource, CURLOPT_URL, $value);
    curl_setopt($resource, CURLOPT_RETURNTRANSFER, true);
    $curl_exec = curl_exec($resource);
    if (curl_errno($resource) == 0) {
        $json_decode = json_decode($curl_exec, true);
        foreach ($json_decode as $value) {
            $pathinfo = pathinfo($value['path'], PATHINFO_BASENAME);
            $path = "http://www.libreeze.top/web/aCloud/res/".$pathinfo;
            echo <<<HTML
<div class="m-2 card col-5 col-lg-2">
                <img class="card-img-top" style="height: 100px" src="$path" alt="${value['name']}"/>
                <div class="card-footer">
                    <div class="d-flex align-items-center justify-content-between">
                        <button class="btn btn-primary" onclick="copy('$pathinfo')">复制</button>
                        <button class="btn btn-danger" onclick="deletePic('${value['path']}','${value['token']}')">删除</button>
                    </div>
                </div>
            </div>   
HTML;

        }
    }
    curl_close($resource);
}
?>