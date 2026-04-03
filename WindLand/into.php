<?php

setcookie('RefererReg', intval($_GET['id']), time()+3600);
include ('index.php');

?>