<?php
/**
 * WindLand Functions - Updated for PHP 7.4+ with UTF-8 support
 */

$sql_queries_counter = 0;
$sql_queries_timer = 0;
$sql_longest_query_t = 0;
$sql_longest_query = '';
$last_say_to_chat = 0;
$sql_all = [];
$GLOBAL_TIME = time();
$battle_log = '';

function tme() {
    global $GLOBAL_TIME;
    return $GLOBAL_TIME;
}

function filter($v) {
    return str_replace("'", "", str_replace("\\", "", htmlspecialchars($v, ENT_QUOTES, 'UTF-8')));
}

function _StateByIndex($a) {
    $states = [
        'g' => ' ',
        'z' => ' ',
        'c' => '',
        'k' => ' ',
        'b' => ' ',
        'p' => ' '
    ];
    return $states[$a] ?? ' ';
}

function str_once_delete($sub, $str) {
    $p = strpos(" " . $str, $sub);
    if ($p > 0) {
        $p--;
        $sl = strlen($sub);
        $sl_str = strlen($str);
        $part1 = substr($str, 0, $sl + $p);
        $part2 = substr($str, $sl + $p, $sl_str - ($sl + $p));
        $part1 = str_replace($sub, "", $part1);
        $str = $part1 . $part2;
    }
    return $str;
}

function str_once_replace($sub, $sub_replacement, $str) {
    $p = strpos(" " . $str, $sub);
    if ($p > 0) {
        $p--;
        $sl = strlen($sub);
        $sl_str = strlen($str);
        $part1 = substr($str, 0, $sl + $p);
        $part2 = substr($str, $sl + $p, $sl_str - ($sl + $p));
        $part1 = str_replace($sub, $sub_replacement, $part1);
        $str = $part1 . $part2;
    }
    return $str;
}

function sqla($q) {
    global $db;
    return $db->fetchArray(sql($q));
}

function sqlr($q, $count = 0) {
    global $db;
    return $db->sqlr($q, $count);
}

function sql($q, $file = '', $line = '', $func = '', $class = '') {
    global $db, $sql_queries_counter, $sql_queries_timer, $sql_longest_query_t, $sql_longest_query, $sql_all, $_ECHO_OFF;
    
    $t = microtime(true);
    $r = $db->sql($q, $file, $line, $func, $class);
    $t = microtime(true) - $t;
    
    $error = $db->mysqli->error ?? '';
    if ($error and isset($_COOKIE["uid"]) and $_COOKIE["uid"] == 5 and !$_ECHO_OFF) {
        echo "<font class=hp><b> MySQL!!! : " . htmlspecialchars($error, ENT_QUOTES, 'UTF-8') . " <i>[" . htmlspecialchars($q, ENT_QUOTES, 'UTF-8') . "]</i></b></font>";
    }
    
    $sql_queries_counter++;
    $sql_queries_timer += abs($t);
    if (abs($t) > $sql_longest_query_t) {
        $sql_longest_query_t = abs($t);
        $sql_longest_query = $q . " &nbsp;<i>" . $_SERVER['PHP_SELF'] . "</i>";
    }
    $sql_all[] = $q . ";<b class=red>" . $error . "</b>";
    return $r;
}

function show_ip() {
    if ($ip_address = getenv("HTTP_CLIENT_IP"));
    elseif ($ip_address = getenv("HTTP_X_FORWARDED_FOR"));
    else $ip_address = getenv("REMOTE_ADDR");
    return $ip_address;
}

function mod_st_start($name, $string) {
    global $module_statisticks, $module_statisticks_counter, $sql_queries_counter, $sql_queries_timer;
    $i = $module_statisticks_counter + 1;
    $module_statisticks[$i]["name"] = $name;
    $module_statisticks[$i]["strings"] = $string;
    $module_statisticks[$i]["sql_queries"] = $sql_queries_counter;
    $module_statisticks[$i]["sql_time"] = $sql_queries_timer;
    $module_statisticks[$i]["all_exec_time"] = time() + microtime();
}

function mod_st_fin() {
    global $module_statisticks, $module_statisticks_counter, $sql_queries_counter, $sql_queries_timer;
    $i = $module_statisticks_counter + 1;
    $module_statisticks[$i]["sql_queries"] = $sql_queries_counter - $module_statisticks[$i]["sql_queries"];
    $module_statisticks[$i]["sql_time"] = $sql_queries_timer - $module_statisticks[$i]["sql_time"];
    $module_statisticks[$i]["all_exec_time"] = time() + microtime() - $module_statisticks[$i]["all_exec_time"];
    $module_statisticks_counter++;
}

function say_to_chat($whosay, $chmess, $priv, $towho, $location = 0, $color = '', $clan = '') {
    global $player, $last_say_to_chat, $db;
    
    $time_to_chat = date("H:i:s");
    if ($location == 0 and $location <> '*') $location = $player->pers['location'];
    if ($last_say_to_chat == 0) $last_say_to_chat = tme() + microtime(); 
    else $last_say_to_chat += 0.1;
    
    $color = '000000';
    if ($location == '*') $color = '220000';
    
    return $db->sql("INSERT INTO `chat` (`user`,`time2`,`message`,`private`,`towho`,`location`,`time`,`color`,`clan`) VALUES ('" . $db->real_escape_string($whosay) . "'," . $last_say_to_chat . ",'" . $db->real_escape_string($chmess) . "','" . $db->real_escape_string($priv) . "','" . $db->real_escape_string($towho) . "','" . $db->real_escape_string($location) . "','" . $time_to_chat . "','" . $color . "','" . $db->real_escape_string($clan) . "')");
}

function light_aura_on($aura, $uid) {
    global $db;
    $db->sql("INSERT INTO `p_auras` (`uid`,`special`,`params`,`image`,`name`,`esttime`,`turn_esttime`,`autocast`) VALUES (" . intval($uid) . "," . intval($aura['special']) . ",'" . $db->real_escape_string($aura['params']) . "'," . intval($aura['image']) . ",'" . $db->real_escape_string($aura['name']) . "'," . intval($aura['esttime']) . "," . intval($aura['turn_esttime']) . "," . intval($aura['autocast']) . ")");
}

function get_uid($login) {
    global $db;
    if (is_numeric($login)) return intval($login);
    $result = $db->sql("SELECT `uid` FROM `users` WHERE `user` = '" . $db->real_escape_string($login) . "' LIMIT 1");
    if ($result instanceof mysqli_result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();
        return intval($row['uid']);
    }
    return 0;
}

function get_login($uid) {
    global $db;
    $result = $db->sql("SELECT `user` FROM `users` WHERE `uid` = " . intval($uid) . " LIMIT 1");
    if ($result instanceof mysqli_result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();
        return $row['user'];
    }
    return '';
}

function redirect($url) {
    header("Location: " . $url);
    exit;
}

function checkOnline($uid) {
    global $db;
    $result = $db->sql("SELECT `online` FROM `users` WHERE `uid` = " . intval($uid) . " LIMIT 1");
    if ($result instanceof mysqli_result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();
        return (int)$row['online'];
    }
    return 0;
}
