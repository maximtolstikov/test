<!DOCTYPE html>
<?php
    //изображение на кнопкe
    $img = "<img align='middle' src='http://livemoon.ddns.net/image/avaVK150x150.png'>"; 
    $client_id = '6058712'; // ID приложения
    $client_secret = 'r4KfnY9eGkHl0j9RCaGK'; // Защищённый ключ
    $redirect_uri = 'http://livemoon.ddns.net/page.php'; // Редирект 
    $url = 'http://oauth.vk.com/authorize';//Редирект на сервис VK

    //Параметры для редиректа
    $params = array(
        'client_id'     => $client_id,
        'redirect_uri'  => $redirect_uri,
        'response_type' => 'code'
    );
    :
    //Проверка если флаг авторизации существует то сразу перходим без кнопки
    if ($_COOKIE["Auth"]){
        $url_redirect =  $url . '?' . urldecode(http_build_query($params));//собираем url
        header("Location: $url_redirect ");//вызов функции перехода (редирект)
    }
?>
        <html>
        <head>
        <meta charset="utf-8" />
        <title></title>
        <link rel="stylesheet" href="css/style.css" />
        </head>
        <body>
<?php
        echo "<strong>Авторизуйтесь</strong> <br />";
            //Ссылка картинка для авторизации собранная для сервиса VK
	    echo $link = '<p><a href="' . $url . '?' . urldecode(http_build_query($params)) . '">' . $img . '</a></p>'; 
?>
        </body>
        </html>
