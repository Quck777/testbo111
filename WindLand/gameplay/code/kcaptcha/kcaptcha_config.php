<?php

# KCAPTCHA файл конфигурации

$alphabet = "0123456789abcdefghijklmnopqrstuvwxyz"; # не изменяйте без замены файлов шрифта!

# Символы для генерации кода CAPTCHA
//$allowed_symbols = "0123456789"; #digits
$allowed_symbols = "0123456789"; #alphabet without similar symbols (o=0, 1=l, i=j, t=f)

# Путь к папке со шрифтами
$fontsdir = 'fonts';	

# CAPTCHA длина кода
$length = mt_rand(2,3); # random 5 or 6
//$length = 6;

# CAPTCHA размеры изображения (you do not need to change it, whis parameters is optimal)
$width = 145;
$height = 45;

# вертикальной амплитудой колебаний символ, деленная на 2
$fluctuation_amplitude = 5;

# повышение безопасности путем предотвращения пробелов между символами
$no_spaces = true;

# Подпись
$show_credits = false; # Есть ли подпись? Если есть, то + 12 пикселей к изображению
$credits = ''; # если он пуст, HTTP_HOST будет показана

# CAPTCHA цвет изображения (RGB, 0-255)
$foreground_color = array(161, 45, 52); // $foreground_color = array(161, 45, 52);
$background_color = array(221, 221, 221);
### $foreground_color = array(mt_rand(0,100), mt_rand(0,100), mt_rand(0,100));
### $background_color = array(mt_rand(200,255), mt_rand(200,255), mt_rand(200,255));



# JPEG качество изображения CAPTCHA (чем больше, тем лучше качество, но больше размер файла)
$jpeg_quality = 100;
?>