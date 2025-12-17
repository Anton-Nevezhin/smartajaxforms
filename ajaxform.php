<?php
require_once 'smartajaxformsconfig.php';


/* ============================= */
/* ОБРАБОТЧИК данных из ФОРМЫ    */
/* ============================= */



if(isset($_POST)) {

	//сначала проверка на спам
	if($_POST["url"] =='') { exit('Ошибка 718: пустой url'); }; 

	// обработка входящих данных

	$phone   = (isset($_POST["ajaxx_phone"])) ? htmlspecialchars($_POST["ajaxx_phone"]) : '';
	$url 	 = (isset($_POST["url"])) ? htmlspecialchars($_POST["url"]) : '';
	$formname 	 = (isset($_POST["formname"])) ? htmlspecialchars($_POST["formname"]) : '';

	// обработка допполей
	$adds=[];
	foreach ($_POST as $key => $value) {
		if (stripos($key, 'ajaxx_name_') === 0) {
			$adds[$key]['value']= (isset($_POST[str_replace('_name', '', $key)])) ? htmlspecialchars($_POST[str_replace('_name', '', $key)]) : '';
			$adds[$key]['name']= htmlspecialchars($value);

		}
	}


	// отправка собранного в телеграм чат, укажите токен и ID чата ниже!!

	$textMessage = "Новый лид\r\n";

	$textMessage .= "Телефон:  ".$phone."\r\n";

	foreach ($adds as $key => $value) {
		$textMessage .= $value['name'].":  ".$value['value']."\r\n";
	}
	

	$textMessage .= "Имя формы:  ".$formname."\r\n";
	$textMessage .= "URL:  ".$url."\r\n";
	if (TG_TOKEN) {
	//	sendToTelegram($textMessage); 
	}
	

	// сохраняем в csv

	$data['phone']=$phone;
	$data['adds']='';
	foreach ($adds as $key => $value) {
		$data['adds'] .= $value['name'].":  ".$value['value'].', ';
	}

	$data['source']="URL: ".$url." Имя формы: ".$formname." ";

	insert_lead($data); 


}


/* =============================      */
/* ОТПРАВКА СООБЩЕНИЯ В ТЕЛЕГРАММ чат */
/* =============================      */
function sendToTelegram($message) {
	

	$message = urlencode($message);

	/*делаем CURL запрос*/
	parser("https://api.telegram.org/bot".TG_TOKEN."/sendMessage?chat_id=".TG_CHAT_ID."&parse_mode=html&text={$message}");
}


/* =============================      */
/* CURL функция собранная */
/* =============================      */

function parser($url){
	$curl = curl_init();
	curl_setopt($curl, CURLOPT_URL, $url);
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
	$result = curl_exec($curl);
	//var_dump($result); // ответ от api сервера если нужен будет
	if($result == false){     
		echo "Ошибка отправки запроса: " . curl_error($curl);
		return false;
	}
	else{
		return true;
	}
}




/* =============================      */
/* вставка данных лида в CSV */
/* =============================      */


function insert_lead($data){
	$fp = fopen(CSV_FILENAME,'a');
	
	$fields[]=date('Y-m-d H:i');
	$fields[]=$data['phone'];
	$fields[]=$data['adds'];
	$fields[]=$data['source'];
	
	fputcsv($fp, $fields,';');
	fclose($fp);
	
}    

