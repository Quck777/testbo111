<?php
##############################
#### WindLand PHP 7.4+ #######
#### Updated: UTF-8 Support ##
##############################

define('MICROLOAD', true);
// Загружаем файл конфига, ВАЖНЫЙ.
include ($_SERVER['DOCUMENT_ROOT'].'/configs/config.php');
// Подключаемся к SQL базе
$db = new MySQL(SQL_USER, SQL_PASS, SQL_BASE);
############################## 

$rid = !empty($_SERVER['QUERY_STRING']) ? abs(intval($_SERVER['QUERY_STRING'])) : false;
if ( $rid != false ) setcookie('RefererReg', (string)$rid, time()+3600, '/');

?><!DOCTYPE html>
<html lang="ru" dir="ltr" xmlns="http://www.w3.org/1999/xhtml">
<head>
    <TITLE>cb662053.tw1.ru - Земля Ветров</TITLE>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="Expires" content="3">
    <meta name="robots" content="ALL">
    <meta name="keywords" content="ролевая игра, браузерная игра, интернет игра, интернет игры, лучшие интернет игры, лучшая онлайн игра, новая онлайн игра, online game, бесплатная онлайн игра, неоландс, новая браузерная онлайн игра, играть бесплатно, играть игры, игры онлайн бесплатно, лучшие игры, популярные игры, популярная онлайн игра, online игра">
    <meta name="description" content="cb662053.tw1.ru - online game!">
    <meta name="rating" content="General">
    <meta name="distribution" content="GLOBAL">
    <meta name="Classification" content="On-line cb662053.tw1.ru">
    <link rel="shortcut icon" href="/favicon.ico">
    <link rel="stylesheet" type="text/css" href="./css/index_v2.css" />
    <!--[if lt IE 7]>
    <link href="./css/iepng.css" rel="stylesheet" type="text/css">
    <![endif]-->
    <script type="text/javascript" src="./js/mod/swfobject.js"></script>
    <script type="text/javascript" src="./js/mod/jquery.js"></script>
    <script type="text/javascript">
    $(document).ready(function() {         
        $('div.modal').click(function() {
            var modalid = $(this).attr('rel');
            $('#' + modalid).fadeIn(600);
            $('#fadebody').fadeIn(600);
            var topm = ($('#' + modalid).height() + 10) / 2;
            var leftm = ($('#' + modalid).width() + 10) / 2;
            $('#' + modalid).css({'margin-top' : -topm,'margin-left' : -leftm});
            $('#fadebody, .close').click(function() {
                $('#fadebody , .modalbox').fadeOut(600)
                return false;
            });
        });
        
        $("#form_show").click(function(){
            url_open = 'reg.php';
            viewwin = open(url_open, "regWindow", "width=455, height=300, status=yes, toolbar=no, menubar=no, resizable=no, scrollbars=no");
            return false;
        });
    });

    function jgetForm() {
        if($('#user').val()== ''){$('#user').focus(); return;} 
        if($('#pass').val()==''){$('#pass').focus(); return;} 
        var obj = document.getElementById('goGame');
        obj.setAttribute("action","/game.php?");
        obj.setAttribute("method","post");
        obj.submit();
    }
    </script>
</head>
<body>
<div id="main" class="body-main">    
    <div class="wrapper">
    
        <div class="h-menu">
        
            <div class="h-menu-items">
                <a href="/?" class="item item1"><span></span></a><span class="sep"></span>
                <a href="/reg.php" class="item item2" id="form_show"><span></span></a><span class="sep"></span>
                <a href="http://f.cb662053.tw1.ru/" class="item item3 "><span></span></a><span class="sep"></span>
                <a href="http://lib.cb662053.tw1.ru/" class="item item4"><span></span></a><span class="sep"></span>
                <a href="/services.php" class="item item5"><span></span></a><span class="sep"></span>
                <a href="/client/WindLand.exe" class="item item6"><span></span></a><span class="sep"></span>
            </div>
            
            <div class="soc">
                <a href="#google" class="ic ic1"></a>
                <a href="#fb" class="ic ic2"></a>
                <a href="#twit" class="ic ic3"></a>
                <a href="http://vk.com/club52844767" class="ic ic4"></a>
            </div>
        </div>
        
        <div class="flash-head">
            <div id="flashcontent3"></div>
            <script type="text/javascript">
            // <![CDATA[     
            var so = new SWFObject("./public_content/swf/golova.swf", "flash", "116", "92", "6");
            so.addParam("allowScriptAccess", "Always");
            so.addParam("base", "/");
            so.addParam("wmode", "transparent");
            so.write("flashcontent3");
            // ]]>
            </script>
        </div>
        
        <div class="flash-footer">
            <div id="flashcontent7"></div>
        </div>
        
        <div class="serv-stat">
            <div class="one">
                <div class="title"></div>             
            </div>
            <div class="one">
                <div class="title"></div>             
            </div>
            <div class="one">
                <div class="title"></div>             
            </div>
        </div>
        <div id="menu_enter">
            <a href="#" id="enter"></a>
        </div>
        
    <!--<center><div id="content">-->
        <center>
        <div rel="modal3" class="modal">
            <div id="menu_enter">
                <a href="#" id="enter"></a>
            </div>
            <div class="modalbox" id="modal3"> 
                <div class="modalcss3">
                    <div class="reg-form">
                        <form id="goGame" action="/game.php" method="POST">
                            <div class="row">
                                <label>Логин:</label>
                                <div class="inp"><input style="text-align:center; background-color:white;" name="user" type="text" id="user" /></div>
                            </div>
                            <div class="row">
                                <label>Пароль:</label>
                                <div class="inp"><input style="text-align:center; background-color:white;" name="pass" type="password" id="pass" /></div>
                            </div>
                            <div class="row marg94"><a href="/remid.php" class="yell">Забыли пароль?</a></div>
                            <div id="enter-butt">
                                <a onClick="jgetForm();" id="enter1"></a>
                            </div>
                            <div class="copy">&copy; cb662053.tw1.ru Ltd</div>
                            <div class="madeby"></div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        </center>
        
        <div id="fadebody"></div>
        <div class="video">
            <iframe type="text/html" width="383" height="252" src="http://www.youtube.com/embed/nd_CYqU7VGA" frameborder="0"></iframe>
        </div>
        
        <div class="main-news" style="overflow: hidden; display: block; height: 600px;">
        
            <!-- News -->
            <!--<div class="news-one">
                <div class="date">
                    <p class="days">13</p>
                    <div class="ri"><p class="month">Дек</p><p class="year">2012</p></div>                  
                </div>
                <div class="title">Тест новостей</div>
                <div class="clear"></div>
                
                <div class="news-cont">
                    <p><span style="font-size: small;"><em><strong><span style="color: #33cccc;">Тест новостей лалал лалала</span></strong></em></span></p><br />
                    <p><strong><span style="font-size: small; color: #33cccc;">С Уважением администрация </span></strong></p>
                </div>
                
                <div class="bottom-line">
                    <div class="publish">
                        Опубликовал: <a href="#">Ice</a>
                    </div>
                    <div class="comments">
                        
                    </div>
                    <a href="index.php?" class="more"></a>
                </div>
            </div>-->
            <!-- News / -->
<?php
$news = $db->sql('SELECT * FROM `lib_news` ORDER BY `date` DESC LIMIT 0, 5;');
while ( $n = $news->fetch_assoc() ) {
    echo '           <div class="news-one">
                    <div class="date">
                        <p class="days">'.htmlspecialchars(date('d', $n['date']), ENT_QUOTES, 'UTF-8').'</p>
                        <div class="ri"><p class="month">'.htmlspecialchars(date('M', $n['date']), ENT_QUOTES, 'UTF-8').'</p><p class="year">'.htmlspecialchars(date('Y', $n['date']), ENT_QUOTES, 'UTF-8').'</p></div>                     
                    </div>
                    <div class="title">'.htmlspecialchars($n['title'], ENT_QUOTES, 'UTF-8').'</div>
                    <div class="clear"></div>
                    <div class="news-cont">'.nl2br(htmlspecialchars($n['text'], ENT_QUOTES, 'UTF-8')).'</div>
                    <div class="bottom-line">
                        <div class="publish">
                            Опубликовал: <a href="/info.php?'.htmlspecialchars($n['autor'], ENT_QUOTES, 'UTF-8').'" target="_blank">'.htmlspecialchars($n['autor'], ENT_QUOTES, 'UTF-8').'</a>
                        </div>
                        <div class="comments">
                            
                        </div>
                        <a href="http://lib.cb662053.tw1.ru/?act=1&subact='.$n['id'].'" class="more" target="_blank"></a>
                    </div>
                </div>';
}
?>
        </div>
        
        <div id="footer">
            <div class="copy">&copy; cb662053.tw1.ru Ltd</div>
            <div class="madeby"></div>
        </div>
    </div>
</body>
</html>
