<?php
##############################
#### Mod Joe. 10.05.2013 #####
##############################

// Загружаем файл конфига, ВАЖНЫЙ.
include ($_SERVER['DOCUMENT_ROOT'].'/configs/config.php');
// Подключаемся к SQL базе
$db = new MySQL(SQL_USER, SQL_PASS, SQL_BASE);
// Подключаем класс обработки входящих данных
$http = new Jhttp;
############################## 

$pers = $db->sqla('SELECT * FROM `users` WHERE `uid` = '.intval($http->_cookie('uid')).' and `pass` = "'.$http->_cookie('hashcode').'" and `block`="";', __FILE__,__LINE__,__FUNCTION__,__CLASS__);
if ( !$pers ) {echo 'NO@no_auth'; exit;}

include (ROOT.'/inc/class/quest.class.php');
$que = new jQuest($pers);
$que->inv_quest();

switch ( $http->_get('act') )
{
	case 1: $que->view_quest(); break; // Получить информацию о квесте
	case 2: $que->get_yourself_quest((int)$http->_get('qid')); break; // Получить квест с ИД
	case 3: 
		include (ROOT.'/inc/func.php');
		include (ROOT.'/inc/func2.php');
		$que->get_finish((int)$http->_get('qid')); 
		break; // Сдать квест с ИД
	case 4:  break;
	default: echo 'NO@no_method';
}


// @@["картинка с расширением",[0-ничего 1-получить 2 завершить,qid]]


//echo 'OK@["Этап первый.","Этап второй","Этап третий"]@["0001.jpg",[0,3]]';



//echo 'OK@["Здравствуй Joe, для Вас сейчас нет никаких поручений."]@["",[0,0]]';


?>