<?php

/**
 * Paramètres à personnaliser
 */
$freeboxUrl= 'http://<MON_URL>:10894';
$app_token='<APP_TOKEN>';

/**
 * Démarrage du script
 */
$mode=null;
$showSession=false;
if (isset($_SERVER['argc'])) {
	//Lancement via ligne de commande
	echo "Command Line\n";
	if(sizeof($argv)==2){
		$action=$argv[1];
	}else{
		echo "Action not found : start|stop|session\n";
		exit(1);
	}
	
	$sautLigne="\n";
	$mode='command';
} else {
	//Commande depuis interface web
	echo "Web Invocation</br>";
	if(isset($_GET['action'])){
		$action=$_GET['action'];
	}else{
		echo "Action not found : start|stop|session<br/>";
		die();
	}
	$mode='web';
	$sautLigne="<br/>";
}


switch($action){
	case 'start':
		$enable=true;
		break;
	case 'stop':
		$enable=false;
		break;
	case 'session':
		if($mode=='command'){
			$enable=null;
			$showSession=true;
			break;
		}else{
			//Par sécurité, on affiche pas la session en mode web
			//Seul la ligne de commande permet cette option
			echo "Show Session is forbidden in web mode";
			die();
		}
	default:
		echo "Action not recognize : start|stop|session".$sautLigne;
		exit(1);
		break;
}

$json_url = $freeboxUrl.'/api/v1/login/';

function doRequest ($url,$data='',$method, $optional_headers = null,$waitResponse=true) {

	$params = array('http' => array(
			'method' => $method,
			'content' => $data
	));

	if ($optional_headers !== null) {
		$params['http']['header'] = $optional_headers;
	}

	$ctx = stream_context_create($params);
	$fp = @fopen($url, 'rb', false, $ctx);

	if (!$fp && $waitResponse) {
		throw new Exception("Problem with $url, $php_errormsg");
	}

	if($waitResponse){
		$response = @stream_get_contents($fp);
	
		if ($response === false) {
			throw new Exception("Problem reading data from $url, $php_errormsg");
		}
	
		return $response;
	}else{
		return null;
	}
}


//Récupération du challenge
$responseLogin=doRequest($json_url,'','GET',
		array ("Accept: application/json", "Content-type: application/json"));

$mapLogin=json_decode($responseLogin,true);

$challenge=$mapLogin['result']['challenge'];

//Création du mot de passe
$password=hash_hmac('sha1', $challenge, $app_token);

//Ouverture d'une session
$json_url = $freeboxUrl.'/api/v1/login/session/';
$responseSession=doRequest($json_url,
		json_encode (array(
				'app_id' => 'fr.w3blog.synofreebox',
				'password' => $password
		)),'POST',
		array ("Accept: application/json", "Content-type: application/json"));

$mapSession=json_decode($responseSession,true);
$session_token=$mapSession['result']['session_token'];

if($showSession){
	echo $sautLigne.$session_token.$sautLigne;
}else{
	//Activation/Désactivation du wifi
	$json_url = $freeboxUrl.'/api/v1/wifi/config';
	$responseWifi=doRequest($json_url,
			json_encode (array('ap_params' => array(
					'enabled' => $enable
			))),'PUT',
			array ("Accept: application/json", "Content-type: application/json","X-Fbx-App-Auth: ".$session_token),$enable);
	
	if($enable){
		$mapWifi=json_decode($responseWifi,true);
		$wifiStatus=$mapWifi['result']['ap_params']['enabled'];
		echo "New Wifi status : ".$wifiStatus.$sautLigne;
	}else{
		//Si jamais le script est executé en loca, on attend pas la reponse car le wifi a été désactivé.
		echo "No waiting response".$sautLigne;
	}
}

exit(0);

?>