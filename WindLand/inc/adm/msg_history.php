<?php
if (UID!=7) die('Err..');

$res = false;

function clans_select_list()
{
	GLOBAL $db;
	$rs = $db->sql('SELECT `sign`, `name` FROM `clans`');
	$r = '';
	while ($s = $db->fetchRow($rs))
		$r.= '<option value="'.$s[0].'">'.$s[1].'</option>';
	return $r;
}


if ( isset($_POST['nick']) )
{
	$r = explode(',', $_POST['nick']);
	if (count($r)>0)
	{
		$rs = '';
		foreach ($r as $v)
		{
			$rs .= " or `user`='".trim($v)."'";
		}
		$rs = "(".substr($rs, 4, strlen($rs)-1).")";
	}
	else $rs = "`user`='".trim($_POST['nick'])."'";
	$res = $db->sql("SELECT * FROM `chat` WHERE `user`<>'s' and `user`<>'m' and ".$rs.";");
}
if ( isset($_GET['f']) and $_GET['f']=='all')
{
	$res = $db->sql("SELECT * FROM `chat` WHERE `user`<>'s' and `user`<>'m';");
}

if ( isset($_POST['counter']) )
{
	$num = intval(abs($_POST['counter']));
	$max = (int)$db->sqlr("SELECT COUNT(*) FROM `chat` WHERE `user`<>'s' and `user`<>'m';");
	$num = $max-$num;
	if ($num<0) $num=0;
	$res = $db->sql("SELECT * FROM `chat` WHERE `user`<>'s' and `user`<>'m' LIMIT ".$num.", ".$max.";");
}

if ( isset($_POST['claner']) )
{
	$rs = ($_POST['claner']);
	$res = $db->sql("SELECT * FROM `chat` WHERE `clan`='".$rs."' ;");
}

$s = '';
$i = 0;
while ( $txt = $db->fetchAssoc($res)  )
{
	if ( !empty($txt['clan']) ) $txt['private']=2;
	
	// КОНЕЦ системным сообщениям
	$txt['message'] = str_replace('"',"",$txt['message']);
	$txt['message'] = str_replace("'","",$txt['message']);
	
	$s.= "'".$txt['time']."•".$txt['user']."•".$txt['towho']."•".$txt['message']."•".$txt['private']."•".$txt['color']."•".$txt['type']."•".$txt['clan']."•',";
	$i++;
}
?>
<table width="100%" class="login">
	<tr><td class="but2" colspan="6"><a class="bga" href="main.php?go=administration">Назад</a></td></tr>
	
	<tr>
		<td>
			<form action="main.php" method="POST">
				Найти все сообщения персонажа:<input type="text" name="nick" class="login" value=""><input type="submit" value="ОК" class="login">
			</form>
		</td>
		<td>
			<form action="main.php" method="POST">
				Последние:<input type="text" name="counter" class="login" value="50">
				<input type="submit" value="ОК" class="login">
			</form>
		</td>
		<td>
			<form action="main.php" method="POST">
				КП:<select name="claner"><option value=0 selected></option><?php echo clans_select_list();?></select>
				<input type="submit" value="ОК" class="login">
			</form>
		</td>
		<?php
//		if (UID==7) 
		echo'<td><a class="bga" href="main.php?f=all">Без фильтра</a></td>';
		?>
	</tr>
	
</table>
<?php
if ($i>0) echo '<b>Всего сообщений: <span class="hp">'.$i.'</span></b>';
?>

<LINK href="/css/ch_main_v2.css" rel="STYLESHEET" type="text/css" />
<script>
function edit_msg(server_state,h,m,s)
{
	var nick = '<?php echo $player->pers['user'];?>';
	var txt=new Array();
	var s = '';
	var type = 'time';
	var towho = new Array();
	var i,j,prv=0;
	var smile,q=0;
	var msg='';
	var inviz='';
	var uninviz='';
	var att=0;
	var PRIV_COUNTER = 0;
	var cimg = '';

	for (i=0;i<t.length;i++)
	{
		s='';
		inviz='';
		uninviz='';
		type='time';
		cimg = '';
		txt = t[i].split('•');
		if (txt[6]!=3)
		{
			att = 0;
			if(txt[1]=='#sound')
			{
				continue;
			}
			else if(txt[1]=='w')
			{
				s+='<font class=user style="color:#990000">Смотрители сообщают.</font> '+txt[3]+'<br>';
				att=1;
			}
			else if(txt[1]=='z')
			{
				s+='<font class=time>'+txt[0]+'</font> &nbsp;<font class=user style="color:#FF0000">Внимание!</font> '+txt[3]+'<br>';
				att=1;
			}
			else if(txt[1]=='p')
			{
				s+='&nbsp;<img src="http://'+img_pack+'/signs/watchers.gif">&nbsp;<font class=clan>'+txt[0]+'</font> &nbsp;<font class=user style="color:#FF0000">Помощник!</font> '+txt[3]+'<br>';
				att=1;
			}
			else if(txt[1]=='a')
			{
				s+='<font class=al>Администрация</font> '+txt[3]+'<br>'; 
				att=1;
			}
			else if(txt[1]=='m')
			{
				s+='<font class=time>'+txt[0]+'</font> &nbsp;<font class=user style="color:#FF0000">Министерство сообщает!</font> '+txt[3]+'<br />'; 
				att=1;
			}
			else if(txt[1]=='^')
			{
				s+='<span class=red>Гильдия наставников</span> '+txt[3]+'<br>'; 
				att=1;
			}
			else if(txt[1]=='s')
			{
				s+='<font class=user style="color:#990000">Системная информация.</font> '+txt[3]+'<br>'; 
				att=1;
			}
			if (att==0)
			{
				if(txt[1]=='n')
				{
					s+='<font class=time>'+txt[0]+'</font> &nbsp;<i>невидимка</i>'; 
					if (txt[2]!='')
					{
						s+=' для ';
						towho = txt[2].split('|');
						for (j=0;j<towho.length-1;j++) 
						{
							s+= '<font class=user onclick="top.say_private(\''+towho[j]+'\','+prv+')">'+
							towho[j]+'</font>';
							if (j<(towho.length-2)) s+=',';
						}
					}
					s=s+':'+txt[3]+'<br>';
				}
				else 
				{
					prv = 0;
					txt[2]=' '+txt[2];
					txt[2] = txt[2].substr(1,txt[2].length-1);
					if (txt[4]==2)
					{
						type = 'clan';
						prv=2;
						cimg = '&nbsp;<img src="http://'+img_pack+'/signs/'+txt[7]+'.gif">&nbsp;';
					}
					else if (txt[4]==1)
					{
						type = 'priv';
						prv=1;
					}
					
					if (type!='time' || true)
					{
						s+= cimg+'<font class='+type+'>'+txt[0]+'</font> &nbsp;'+inviz+'<font class=user onclick="top.say_private(\''+txt[1]+'\','+prv+')">'+
						txt[1]+'</font>'+uninviz+'';
						if (txt[2]!='')
						{
							s+=' для ';
							towho = txt[2].split('|');
							for (j=0;j<towho.length-1;j++) 
							{
								s+= '<font class=user onclick="top.say_private(\''+towho[j]+'\','+prv+')">'+
								towho[j]+'</font>';
								if (j<(towho.length-2)) s+=',';
							}
						}
						if (txt[1]!='') s+=':';
						s += ' <font color="#'+txt[5]+'">'+txt[3]+'</font><br>';
					}
				}
			}
			if (s!='') s = "<div>"+s+"</div>";
			if (i==t.length-1) add_msg(s,txt[6],1);
			else add_msg(s,txt[6],0);
		}
		else add_msg('<font class=timef>'+txt[0]+'</font> '+str_replace("%",'<br><font class=timef>'+txt[0]+'</font> ',txt[3])+'<hr />',txt[6],1);
	}
}

function str_replace(replacement,substr,str)
{
	var w = str.split(replacement);
	return w.join(substr);
}
function str_replace2(str,replacement,substr)
{
	var w = str.split(replacement);
	return w.join(substr);
}

function add_msg (msg,ttt,add)
{
	document.write(msg);
}


<?php
echo "var t = new Array (".substr($s,0,strlen($s)-1).");";
unset($s);
?>
edit_msg(0.004);
</script>


