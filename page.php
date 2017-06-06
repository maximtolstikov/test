<!DOCTYPE html>
    <html>
    <head>
    <meta charset="utf-8" />
    <title></title>
    <link rel="stylesheet" href="css/style.css" />
    </head>
    <body>
<?php   ////
    $client_id = '6058712'; // ID приложения
    $client_secret = 'r4KfnY9eGkHl0j9RCaGK'; // Защищённый ключ
    $redirect_uri = 'http://livemoon.ddns.net/page.php'; // Редирект 
    $url = 'http://oauth.vk.com/authorize';
    $auth = 'auth';//Переменная для флага авторизации в coocie

    //Собираем параметры которые требуются для отправки в VK
    $params = array(
        'client_id'     => $client_id,
        'redirect_uri'  => $redirect_uri,
        'response_type' => 'code'//Переменная которую будем ловит после редиректа
    );

    //Если ответ вернулся то создаем cookies 
	if (isset($_GET['code'])) {
        $expire = time()+60*60*24*10;
	    setcookie("Auth", $auth, $expire);//Определим срок хранния cookies 10 дней
        $result = false;//Флаг установленный в создателем оригинального скрипта http://ruseller.com/lessons.php?rub=37&id=1659(по нему будем
                        // далее делать проверку что пользователь существует)
	    $params = array(
	        'client_id' => $client_id,
	        'client_secret' => $client_secret,
	        'code' => $_GET['code'],
	        'redirect_uri' => $redirect_uri
	    );
	    //Токен полученный от VK
	    $token = json_decode(file_get_contents('https://oauth.vk.com/access_token' . '?' . urldecode(http_build_query($params))), true);
	    //Проверка на существование токена по результату собираем параметры для отправки
	    if (isset($token['access_token'])) {
	        $params = array(
	            'uids'         => $token['user_id'],
	            'fields'       => 'uid,first_name,last_name,photo_big',
	            'access_token' => $token['access_token']
	        );
	        
	        //Получаем "Пользователя"
	        $userInfo = json_decode(file_get_contents('https://api.vk.com/method/users.get' . '?' . urldecode(http_build_query($params))), true);
	        if (isset($userInfo['response'][0]['uid'])) {
	            $userInfo = $userInfo['response'][0];//Сокращаем код
	            $result = true;//Здесь флак в true похоже отметили что пользователь получен, хотя как то странно
	        }
                //Имея пользователя получаем друзей
                if ($result){
                    $params = array(
	              'access_token' => $token['access_token'],
                      'count'    => '5',
                      'fields'   => 'nikname,photo_50',
                    ); 
	        $userFrends = json_decode(file_get_contents('https://api.vk.com/method/friends.get' . '?' . urldecode(http_build_query($params))), true);
	        $userFrends = $userFrends['response'];
                }
	    }
	    //Выводим друзей вертикальным списком перебрав полученный от VK массив 
        if ($result) {
	        echo  $userInfo['first_name'] . '<br />';
	        echo '<img src="' . $userInfo['photo_big'] . '" />'; echo "<br />";
            echo " <br />";
            echo "<strong>Друзья:</strong> <br />";
            echo " <br />";
           foreach ($userFrends as $frend) {
                echo '<img src="' . $frend['photo_50'] . '"/>' . ' ' . $frend['first_name'] . "<br />";
	        }
	    }
	}
	?>
	</body>
	</html>

