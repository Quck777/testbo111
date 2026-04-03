var d = document;
var world = false;
var transport_img = false;
var timer_img = false;
var timer_sec = false;
var width = 4;
var height = 2;
var move_interval = 50;
var current_x = 0;
var current_y = 0;
var time_left = 0;
var time_left_sec = 0;
var pause = 0;
var t = 0;
var tsec = 0;
var cur_margin_top = 0;
var cur_margin_left = 0;
var dest_x = 0;
var dest_y = 0;
var loaded_left = 0;
var loaded_right = 0;
var loaded_top = 0;
var loaded_bottom = 0;
var moving_status = 0;
var finStatus = 0;
var gox = 0;
var goy = 0;
var gop = 0;
var avail = new Array();
var bavail = new Array();
var classn = false;
var MESSD = false;
var MDARK = false;
var rinit = 0;
var arr_res;


var pngAlpha = 1;
var ua = navigator.userAgent.toLowerCase();

this.isIE = ((ua.indexOf('msie') != -1) && !(ua.indexOf('opera') != -1) && (ua.indexOf('webtv') == -1));
this.versionMinor = parseFloat(navigator.appVersion);
this.versionMajor = parseInt(navigator.appVersion);

if(this.isIE && this.versionMinor >= 4) this.versionMinor = parseFloat(ua.substring(ua.indexOf('msie ')+5));
if(this.isIE && parseInt(this.versionMinor)<7) pngAlpha = 0;

function sbox2(t,c)
{
	return sbox2b(c)+t+sbox2e(); 
}

function sbox2b(c)
{
	if (c) c = 'text-align:center;';
	return '<table style="width: 100%" cellspacing="0" cellpadding="0"> <tr> <td style="width: 18px; height: 18px"> <img src="/public_content/corners/left_top.png" width="18" height="18"></td> <td style="height: 18px;background-image: url(\'/public_content/corners/top.png\');">&nbsp;</td> <td style="width: 18px; height: 18px"> <img src="/public_content/corners/right_top.png" width="18" height="18"></td> </tr> <tr> <td style="width: 18px;background-image: url(\'/public_content/corners/left.png\');">&nbsp;</td> <td style="background-image: url(\'/public_content/corners/bg.png\');'+c+'">';
}

function sbox2e()
{
	return '</td> <td style="width: 18px;background-image: url(\'/public_content/corners/right.png\');">&nbsp;</td> </tr> <tr> <td style="width: 18px; height: 18px"> <img src="/public_content/corners/left_bottom.png" width="18" height="18"></td> <td style="height: 18px;background-image: url(\'/public_content/corners/bottom.png\');">&nbsp;</td> <td style="width: 18px; height: 18px"> <img src="/public_content/corners/right_bottom.png" width="18" height="18"></td> </tr> </table>';
}

function img_real_path(r,c)
{
	return r+(c?26:22);
}

function view_map()
{
	d.write('<div style="position: absolute; text-align: left;">');
    d.write('<table cellpadding=0 cellspacing=0 border=0 width=100%><tr><td bgcolor=#FFFFFF align=center><div style="position: absolute; border: 1px solid black; overflow: hidden; width: 720px; height: 400px; _left: 50%; _margin-left: -350px;" id="world_cont"></div><div style="width: 720px; height: 400px; text-align: left;" id="world_cont2"></div></td>');
	d.write('<td _bgcolor=#FFFAAA width="100%" valign="top"> '+sbox2('<div width="100%" id="contBox"></div>', 1)+' </td>');
	d.write('</tr></table>');
	d.write('</div>');
	ButtonGen();
	
    for(var i=0; i<map[1].length; i++)
    {
        avail[map[1][i][0]+'_'+map[1][i][1]] = map[1][i][2];
	//	alert(map[1][i][2]);
    }
    
    if(!map[0][4].length) 
    {
		current_x = map[0][0];
		current_y = map[0][1];
		showCursor();
		showMap(current_x, current_y);    
    }
    else if(!map[0][4][0])
    { // !
        finStatus = 1;
        showTransport('man', map[0][4][4], map[0][4][5], map[0][0], map[0][1], 8, 'gif'); 
        loadPath(map[0][4][4], map[0][4][5], map[0][0], map[0][1], (map[0][4][3] - map[0][4][2]), (map[0][4][3] - map[0][4][1]));
		TimerStart((map[0][4][3] - map[0][4][1]),0);   
    }
    else
    {
        // Работа или защита от подбора
        finStatus = 2;
        current_x = map[0][0];
        current_y = map[0][1];
        showCursor();
        showMap(current_x, current_y); 
		TimerStart(map[0][4][1],1);
    }
	
	contBoxer();
}

function contBoxer()
{
	//	d.getElementById('contBox').innerHTML = current_x+' : '+current_y;
	d.getElementById('contBox').innerHTML = show_only_hp2(inshp[0],inshp[1],inshp[2],inshp[3]);
	d.getElementById('contBox').innerHTML+= '<div class="but"><font class="green">Усталость: <b id="ustBox">'+inshp[6]+'</b>%</font><a class="bg" href="/map.php" target="_blank">Карта мира</a></div>';
	
	
	d.getElementById('contBox').innerHTML+= '<div class="but" align="center" id="ButtonPlace">'+ButtonGen()+'</div>';

	ins_HP(inshp[0],inshp[1],inshp[2],inshp[3],inshp[4],inshp[5]);
}

function jSumCord(nx, ny)
{
	return ( ((nx-current_x)*(nx-current_x)+(ny-current_y)*(ny-current_y)) > 2 ) ? false : true;
}

function showMap(x, y)
{
    if(!world) 
    {
        world = d.createElement('DIV');
        world.id = 'world_map';
        d.getElementById('world_cont').appendChild(world);  
    }
    world.innerHTML = '';
    table = d.createElement('TABLE');
    world.appendChild(table);
    tbody = d.createElement('TBODY');
    table.appendChild(tbody);
    table.border = 0;
    table.cellPadding = 0;
    table.cellSpacing = 0;
    
    for(i=-height; i<=height; i++) 
    {
        tr = d.createElement('TR');
        for(j=-width; j<=width; j++) 
        {
            td = d.createElement('TD');
            td.style.backgroundImage = 'url(http://'+url_map+'/'+map[0][3]+'/'+img_real_path((x+j),0)+'_'+img_real_path((y+i),1)+'.jpg)';
			td.id = 'td_'+(x+j)+'_'+(y+i);
			
            img = d.createElement('IMG');
            img.src = map_img_path+'/1x1.gif';
            img.width = 80; // 100
            img.height = 80;
			
            img.id = 'img_'+(x+j)+'_'+(y+i);
            dx = x+j;
            dy = y+i;
            
		//	if (avail[dx+'_'+dy]) td.innerHTML = '<div style="position: absolute; color: white;">'+(x+j)+'_'+(y+i)+'<br>'+img_real_path((x+j),0)+'_'+img_real_path((y+i),1)+'</div>';
			
			
			if(avail[dx+'_'+dy] && !finStatus && jSumCord(dx, dy) ) {
                img.src = map_img_path+'/map/world/here.gif';
                img.onclick = function(dx, dy) { return function() { moveMapTo(dx, dy, map[0][2]); } }(dx, dy);
                img.style.cursor = 'pointer';
			}
            
            td.appendChild(img);
            tr.appendChild(td);
        }
        tbody.appendChild(tr);
    }
    
    current_x = x;
    current_y = y;
    
    loaded_left = x-width;
    loaded_right = x+width;
    loaded_top = y-height;
    loaded_bottom = y+height;
    
    return true;
}

function showCursor()
{
    if(!transport_img)
    {
        createCursor();    
    }
    transport_img.src = map_img_path+'/map/nl_cursor.png'; 
}

function createCursor()
{
    var div = d.createElement('DIV');
    div.id = 'cursor';

    div.style.display = 'block';
    div.style.position = 'absolute';
    div.style.marginLeft = (1 + (width)*80) + 'px';
    div.style.marginTop = (1 + (height)*80) + 'px';
    
    transport_img = d.createElement('IMG');
    transport_img.width = 80;
    transport_img.height = 80;
    
    div.appendChild(transport_img);
    d.getElementById('world_cont2').appendChild(div); 
    
    div = d.createElement('DIV');
    div.id = 'timerfon';
    
    div.style.display = 'none';
    div.style.position = 'absolute';
    div.style.marginLeft = ((width-0)*80) + 'px';
    div.style.marginTop = ((height - 2)*80) + 'px';
    
    timer_img = d.createElement('IMG');
    timer_img.width = 100;
    timer_img.height = 100;
    
    div.appendChild(timer_img);
    d.getElementById('world_cont2').appendChild(div);
    
    div = d.createElement('DIV');
    div.id = 'timerdiv';

    div.style.display = 'none';
    div.style.position = 'absolute';
    div.style.marginLeft = ((width-0)*80) + 'px';
    div.style.marginTop = (42 + (height - 2)*80) + 'px';
    div.innerHTML = '<table cellpadding=0 cellspacing=0 border=0 width=100><tr><td align=center id="tdsec" class="timer_s"></td></tr></table>';
    
    d.getElementById('world_cont2').appendChild(div);
}

function moveMapTo(x, y, ps)
{
    if(moving_status == 1) return false;
    gox = x;
    goy = y;
    gop = ps;
	$.get('/gameplay/ajax/map.php', {'act':1, 'x':x, 'y':y}, function(r){
		arr_res = r.split('@');
		StateReady();
	});
	top.frames['ch_list'].location = '/frames/ch.php?';
    return true;
}

function StateReady()
{
    switch(arr_res[0])
    {
        case 'GO':
        
		MapReInit([]);
        
        //showTransport('dirizhopel', current_x, current_y, gox, goy, 16, 'png');
        showTransport('man', current_x, current_y, gox, goy, 8, 'gif');

        dest_x = gox;
        dest_y = goy;
		pause = gop;
		
		// Всегда будем проверять время перехода
		var objmap = eval(arr_res[5]);
		pause = parseInt(objmap[0]);

        TimerStart(pause,1);
        time_left = pause*1000;
        moving_status = 1;

	//	ButtonSt(true);
        t = setInterval("move()", move_interval);
        
        break;
        case 'AL':
        
        break;
        case 'MESS':
		//	if(ND) RemoveDialogDiv();
			var messb = eval(arr_res[1]);
			if(messb[2]) TimerStart(messb[2],1);
			MessBoxDiv(messb[0]); 
			break;
        case 'F5': location = '/main.php?f5=1'; break;
    }    
}

function move()
{
    path = ((time_left) / (pause * 1000));
    
    if(time_left <= 0) 
    {
        clearInterval(t);
        finFunction();
    }
    
    if(dest_y < current_y)
    {
        app_y = dest_y + (Math.abs(dest_y - current_y) * path);
        if((app_y - height) <= (loaded_top + 0.2)) 
        {
            loaded_top -= 1;
            loadMap('top', loaded_top);
        }
        
        if((app_y + (height*2)) <= (loaded_bottom)) 
        {
            loaded_bottom -= 1;
            freeMap('bottom');
        }
        
        cur_margin_top += (Math.abs(dest_y - current_y) * 80) / (pause*1000 / move_interval);
    } 
    else if(dest_y > current_y)
    {
        app_y = dest_y - (Math.abs(dest_y - current_y) * path);
        if((app_y + height) >= (loaded_bottom - 0.2)) 
        {
            loaded_bottom += 1;
            loadMap('bottom', loaded_bottom);
        }
        
        if((app_y - (height*2)) >= (loaded_top)) 
        {
            loaded_top += 1;
            freeMap('top');
        }
        
        cur_margin_top -= (Math.abs(dest_y - current_y) * 80) / (pause*1000 / move_interval);
    }
    
    if(dest_x < current_x)
    {
        app_x = dest_x + (Math.abs(dest_x - current_x) * path);
        if((app_x - width) <= (loaded_left + 0.2)) 
        {
            loaded_left -= 1;
            loadMap('left', loaded_left);
        }
        
        if((app_x + (width*2)) <= (loaded_right)) 
        {
            loaded_right -= 1;
            freeMap('right');
        }
        
        cur_margin_left += (Math.abs(dest_x - current_x) * 80) / (pause*1000 / move_interval);
    } 
    else if(dest_x > current_x)
    {
        app_x = dest_x - (Math.abs(dest_x - current_x) * path);
        if((app_x + width) >= (loaded_right - 0.2)) 
        {
            loaded_right += 1;
            loadMap('right', loaded_right);
        }
        
        if((app_x - (width*2)) >= (loaded_left)) 
        {
            loaded_left += 1;
            freeMap('left');
        }
        
        cur_margin_left -= (Math.abs(dest_x - current_x) * 80) / (pause*1000 / move_interval);
    }
    
    world.style.marginTop = parseInt(cur_margin_top) + 'px';
    world.style.marginLeft = parseInt(cur_margin_left) + 'px';
    
    time_left -= move_interval;
}

function MapReInit(obj)
{
    avail = new Array();
    for(var i=0; i<obj.length; i++)
    {
        avail[obj[i][0]+'_'+obj[i][1]] = obj[i][2];
    }
    
    for(i=-height; i<=height; i++) 
    {
        for(j=-width; j<=width; j++) 
        {
            imgid = d.getElementById('img_'+(current_x+j)+'_'+(current_y+i));

            dx = current_x + j;
            dy = current_y + i;
			
            if(avail[dx+'_'+dy] && jSumCord(dx, dy)) 
            {
                imgid.src = IMG+'/map/world/here.gif';
                imgid.onclick = function(dx, dy) { return function() { moveMapTo(dx, dy, map[0][2]); } }(dx, dy);
                imgid.style.cursor = 'pointer';
            }
            else
            {
                imgid.src = IMG+'/1x1.gif';
                imgid.onclick = function() {};
                imgid.style.cursor = 'default';
            }
			
			// Пишем на ячейки инфу
			if ( avail[dx+'_'+dy] ) 
			{
			//	tdx = d.getElementById('td_'+dx+'_'+dy);
			//	tdx.innerHTML = '<div style="position: absolute; color: white;">ReInit</div>';
			}
        }
    }    
}

function showTransport(name, from_x, from_y, to_x, to_y, p, type)
{
    if(!transport_img)
    {
        createCursor();    
    }
    
    rad = Math.atan2((to_y - from_y), (to_x - from_x));
    
    pi = 3.141592;
    grad = Math.round(rad/pi*180 / (360 / p));
    if (grad == p) grad = 0;
    if (grad < 0) grad = p + grad;
    
    
    if(pngAlpha) transport_img.src = IMG+'/map/'+name+'_'+grad+'.'+type;
    else
    {
        transport_img = ReInitCursor();
        transport_img.src = IMG+'/map/'+name+'_'+grad+'.'+type;
    }
   
    return true;
}

function TimerStart(secgo,mrinit)
{
    if(time_left_sec <= 0)
    {
        if(mrinit)
        {
			ButtonSt(true);
			MapReInit([]);
        }
        time_left_sec = secgo*1000;
        if(!timer_img) createCursor();
        timer_img.src = IMG+'/map/world/timer.png';
        d.getElementById('timerfon').style.display = 'block';
        d.getElementById('timerdiv').style.display = 'block';
        d.getElementById('tdsec').innerHTML = secgo;
        tsec = setInterval('timerst('+mrinit+')', 1000);
    }
    else time_left_sec += secgo*1000;     
}

function loadMap(dir)
{
    tbody = world.lastChild.lastChild;
    switch (dir) 
    {
        case 'bottom':
        
        tr = d.createElement('TR');
        for(i=loaded_left; i<=loaded_right; i++) 
        {
            td = d.createElement('TD');
            td.style.backgroundImage = 'url(http://'+url_map+'/'+map[0][3]+'/'+img_real_path(i,0)+'_'+img_real_path(loaded_bottom,1)+'.jpg)';
			td.id = 'td_'+(i)+'_'+(loaded_bottom);
			img = d.createElement('IMG');
            img.src = ''+IMG+'/1x1.gif';
            img.width = 80;
            img.height = 80;
            img.id = 'img_'+(i)+'_'+(loaded_bottom);
            td.appendChild(img);
            tr.appendChild(td);
        }
        tbody.appendChild(tr);
        
        break
        case 'top':
        
        cur_margin_top -= 80; 
        tr = d.createElement('TR');
        for(i=loaded_left; i<=loaded_right; i++) 
        {
            td = d.createElement('TD');
            td.style.backgroundImage = 'url(http://'+url_map+'/'+map[0][3]+'/'+img_real_path(i,0)+'_'+img_real_path(loaded_top,1)+'.jpg)';
            td.id = 'td_'+(i)+'_'+(loaded_top);
			img = d.createElement('IMG');
            img.src = IMG+'/1x1.gif';
            img.width = 80;
            img.height = 80;
            img.id = 'img_'+(i)+'_'+(loaded_top);
            td.appendChild(img);
            tr.appendChild(td);
        }
            
        tbody.insertBefore(tr, tbody.firstChild);
        
        break
        case 'right':
        
        for(i=loaded_top; i<=loaded_bottom; i++) 
        {
            tr = tbody.childNodes[i-loaded_top];
            td = d.createElement('TD');
            td.style.backgroundImage = 'url(http://'+url_map+'/'+map[0][3]+'/'+img_real_path(loaded_right,0)+'_'+img_real_path(i,1)+'.jpg)';
            td.id = 'td_'+(loaded_right)+'_'+(i);
			img = d.createElement('IMG');
            img.src = IMG+'/1x1.gif';
            img.width = 80;
            img.height = 80;
            img.id = 'img_'+(loaded_right)+'_'+(i);
            td.appendChild(img);
            tr.appendChild(td);
        }
            
        break
        case 'left':
        
        cur_margin_left -= 80;
        for(i=loaded_top; i<=loaded_bottom; i++) 
        {
            tr = tbody.childNodes[i-loaded_top];
            td = d.createElement('TD');
            td.style.backgroundImage = 'url(http://'+url_map+'/'+map[0][3]+'/'+img_real_path(loaded_left,0)+'_'+img_real_path(i,1)+'.jpg)';
            td.id = 'td_'+(loaded_left)+'_'+(i);
			img = d.createElement('IMG');
            img.src = IMG+'/1x1.gif';
            img.width = 80;
            img.height = 80;
            img.id = 'img_'+(loaded_left)+'_'+(i);
            td.appendChild(img);
            tr.insertBefore(td, tr.firstChild);
        }
        
        break
    }
}

function timerst(lp)
{
    time_left_sec -= 1000;
    if(time_left_sec <= 0)
    {
        if(lp)
        {
			ButtonSt(false);
            MapReInit(map[1]);
            finStatus = 0;
        }
        timer_img.src = IMG+'/1x1.gif';
        d.getElementById('tdsec').innerHTML = '';
        d.getElementById('timerdiv').style.display = 'none';
        d.getElementById('timerfon').style.display = 'none';
        clearInterval(tsec);  
    }
    else
    {
        d.getElementById('tdsec').innerHTML = (time_left_sec / 1000); 
    }    
}

function finFunction()
{
    moving_status = 0;
    switch(finStatus)
    {
        case 0:
        
        current_x = parseInt(arr_res[1]);
        current_y = parseInt(arr_res[2]);
        var objmap = eval(arr_res[5]);
        map[0][2] = objmap[0];
        map[0][3] = objmap[1];
        map[1] = eval(arr_res[3]);
        MapReInit(map[1]);
		mapbt = eval(arr_res[4]);
		// Ставим усталку и кнопки
        d.getElementById('ButtonPlace').innerHTML = ButtonGen();
		d.getElementById('ustBox').innerHTML = objmap[2];
		
     //   if(objmap[2]) MessBoxDiv(objmap[2]);
        
        break;
        case 1:
        
        finStatus = 0;
        current_x = map[0][0];
        current_y = map[0][1];
		ButtonSt(false);
        MapReInit(map[1]);

        break;    
    }
    
    if(pngAlpha) transport_img.src = IMG+'/map/nl_cursor.png';
    else 
    {
        transport_img = ReInitCursor();
        transport_img.src = IMG+'/map/nl_cursor.png';
    }
    
//    parent.frames["ch_list"].location = "/ch.php?lo=1";       
}

function freeMap(dir)
{
    tbody = world.lastChild.lastChild;
    switch(dir) 
    {
        case 'top':

        cur_margin_top += 80; 
        tr = tbody.firstChild;
        tbody.removeChild(tr);
        
        break
        case 'bottom':

        tr = tbody.lastChild;
        tbody.removeChild(tr);
        
        break
        case 'left':

        cur_margin_left += 80; 
        for (i=loaded_top; i<=loaded_bottom; i++) 
        {
            tr = tbody.childNodes[i-loaded_top];
            tr.removeChild(tr.firstChild);
        }
        
        break
        case 'right':
        
        for (i=loaded_top; i<=loaded_bottom; i++) 
        {
            tr = tbody.childNodes[i-loaded_top];
            tr.removeChild(tr.lastChild);
        }
        
        break
    }
    
    return true;
}

function ButtonGen()
{
    var str = '';
    bavail = new Array();
    for(var i=0; i<mapbt.length; i++)
    {
        bavail[mapbt[i][0]] = [mapbt[i][2],mapbt[i][3]];
        str += ' <input type=button class="jBut2" id="'+mapbt[i][0]+'" value="'+mapbt[i][1]+'" onclick=\'ButClick("'+mapbt[i][0]+'")\'>';
    }
    return str;
}

function ButClick(id)
{
//	alert(3);
    var goloc = '';
    switch(id)
    {
        case 'bots': ohota(); break;
		case 'fish': fishing(); break; 
		case 'herb': herbals(); break; 
		case 'wood': MessBoxDiv('Профессия на реконструкции.'); break; 
		case 'telep': teleport(); break;
		case 'quest': QActive(); break; 
		default: goloc = 'main.php?goloc='+id+'&time='+bavail[id][0]; break;
    }
    if(goloc) location = goloc;
}

// -----------------------
function ohota()
{
	$.get('/gameplay/ajax/get_bots.php', {'act':1}, function(r){
		arr = r.split('@');
		if( parseInt(arr[2]) ) TimerStart( parseInt(arr[2]),1);
		switch (arr[0])
		{
			case 'US': MessBoxDiv('Вы слишком устали, отдохните, после вы сможете возобновить охоту на монстров.'); break;
			case 'F5': location = '/main.php?f5=1'; break;
			case 'OK': viewModBox(eval(arr[1]), 2); break;
			case 'NO': MessBoxDiv('Монстры не найдены.'); break;
			default: MessBoxDiv('Ошибка.'); break;
		}
	});
}

function teleport()
{
	$.get('/gameplay/ajax/map.php', {'istel':1}, function(r){
		arr = r.split('@');
		switch (arr[0])
		{
			case 'F5': location = '/main.php?f5=1'; break;
			case 'OK': viewModBox(eval(arr[1]), 3); break;
			case 'NO': MessBoxDiv('Телепорт не обнаружен.'); break;
			default: MessBoxDiv('Ошибка.'); break;
		}
	});
}

function herbals()
{
	$.get('/gameplay/ajax/herbals.php', {'act':1}, function(r){
		arr = r.split('@');
		switch (arr[0])
		{
			case 'F5': location = '/main.php?f5=1'; break;
			case 'OK': TimerStart(40,1);viewModBox(eval(arr[1]), 0); break;
			default: MessBoxDiv('Ошибка.'); break;
		}
	});
}

function fishing()
{
	$.get('/gameplay/ajax/fishing.php', {'act':1}, function(r){
		arr = r.split('@');
		switch (arr[0])
		{
			case 'F5': location = '/main.php?f5=1'; break;
			case 'OK': viewModBox(eval(arr[1]), 1); break;
			default: MessBoxDiv('Ошибка.'); break;
		}
	});
}
// -----------------------




function ButtonSt(st)
{
	if(mapbt.length > 0 )
	{
		for(var i=0; i<mapbt.length; i++)
		{
	//		d.getElementById(mapbt[i][0]).disabled = st;    
		}
	}
}

function ReInitBut(obj)
{
    for(var i=0; i<obj.length; i++) bavail[obj[i][0]] = [obj[i][2],obj[i][3]]; 
}

function ReAddBut(obj)
{
    var k = mapbt.length; 
    for(var i=0; i<obj.length; i++)
    {
        var nbutt = d.getElementById(obj[i][0]);
        if(!nbutt) 
        {
            mapbt[k] = [obj[i][0]];
            k++;
            bavail[obj[i][0]] = [obj[i][2],obj[i][3]];
            d.getElementById('ButtonPlace').innerHTML += ' <input type=button class="bga" id="'+obj[i][0]+'" value="'+obj[i][1]+'" onclick=\'ButClick("'+obj[i][0]+'")\'>';
        } 
    }        
}






// ///

function MessBoxDiv(mess)
{
    if(!MESSD)
    {
        MDARK = d.createElement('div');
        MDARK.id = 'darker';
        MDARK.className = (classn ? classn : RetClass());
        MDARK.style.display = 'block';
		MDARK.style.position = 'absolute';
        d.body.appendChild(MDARK);
		
        MESSD = d.createElement('div');
        MESSD.className = 'png';
        MESSD.id = 'static_window';
        MESSD.innerHTML = '<div class="ws_top png"></div><div class="ws_right png"></div><div class="ws_bottom png"></div><div class="ws_middle"><a href="javascript: MessBoxDivClose();" class="circ"></a><div class="text">'+mess+'</div><a class="cl_but" href="javascript: MessBoxDivClose();"></a></div>';
        d.body.appendChild(MESSD);        
    }    
}

function MessBoxDivClose()
{
    d.body.removeChild(MESSD);
    d.body.removeChild(MDARK);
    MDARK = false;
    MESSD = false;    
}

function RetClass()
{
    var userAgent = navigator.userAgent.toLowerCase();
    if(userAgent.indexOf('mac') != -1 && userAgent.indexOf('firefox')!=-1) classn = 'TB_overlayMacFFBGHack';
    else classn = 'TB_overlayBG';
    return classn;    
}

// /////

var ND = false;

function viewModBox(arr_res, act)
{
	if(ND) RemoveDialogDiv();
	if(ND === false)
	{
		ND = d.createElement('div');
		ND.id = 'darker';
		ND.className = (classn ? classn : RetClass());
		ND.style.display = 'block';
		d.body.appendChild(ND);
		
		ND = d.createElement('div');
		ND.className = 'png';
			
		// окно с данными
		var buttons = '';
		var ingr = arr_res;//eval(arr_res);
		var did = 'uni';
		ND.id = 'uni';
		
		switch(act)
		{
			case 0:
				var tr = 0;
				var messal = '<table cellpadding=0 cellspacing=0 border=0 width=100%><tr><td bgcolor=#CCCCCC><table cellpadding=10 cellspacing=1 border=0 width=100%>';
				for(var i=0; i<ingr.length; i++)
				{
					tr++;
					if(tr == 1) messal += '<tr>';
					messal += '<td bgcolor=#FFFFFF valign=top width=25%><div align=center>'+((ingr[i][2]==0) ? '<i>Срезано</i>' : (!ingr[i][3] ? '<input type=button class=but2 value="Срезать" DISABLED>' : '<input type=button class=lbut value="Срезать" onclick="getHerbal(\''+ingr[i][1]+'\',\''+ingr[i][2]+'\');">'))+'<br><br><img src="/images/weapons/herbals/'+ingr[i][1]+'.gif" width=60 height=60><br><font class=freetxt><b>'+ingr[i][0]+'</b><br></div></td>';
					if(tr == 4) {messal += '</tr>';tr = 0;}    
				}
				tr++;
				if(tr != 1)
				{
					for(var i=tr; i<5; i++) messal += '<td bgcolor=#FFFFFF width=25%>&nbsp;</td>';
					messal += '</tr>';
				}
				messal += '</table></td></tr></table>';
			break;
			case 1:
				var messal = '<FORM id="FISHF"><table cellspacing=0 cellpadding=0 border=0 width=100%><tr><td bgcolor=#CCCCCC><table cellspacing=1 cellpadding=5 border=0 width=100%><tr><td bgcolor=#FFFFFF colspan=5 class="centr" class=nickname><font class=inv><b>'+((ingr[0][2] - ingr[0][1]) > 10 ? '' : '<font color=#CC0000>Внимание! Возможен перегруз.</font> ')+'Масса Вашего инвентаря: '+ingr[0][1]+'/'+ingr[0][2]+'</b></font></td></tr><tr><td bgcolor=#FFFFFF colspan=2></td><td bgcolor=#FFFFFF class="centr" width=60%><b>Название приманки</b></td><td bgcolor=#FFFFFF class="centr" width=40%><b>В наличии</b></td></tr>';
				for(var i=1; i<ingr.length; i++)
					messal += '<tr><td bgcolor=#FFFFFF class="centr"><input type=radio name=primid value='+ingr[i][1]+'></td><td bgcolor=#FFFFFF><img src="/images/weapons/'+ingr[i][2]+'.gif" width=60 height=60></td><td bgcolor=#FFFFFF class="centr"><b>'+ingr[i][0]+'</b></td><td bgcolor=#FFFFFF class="centr"><b>'+ingr[i][3]+'/'+ingr[i][4]+'</b></td></tr>';
				messal += (!ingr[1] ? '<tr><td bgcolor=#FFFFFF colspan=5 class="centr"><img src='+IMG+'/1x1.gif width=1 height=10><br><img src="/gameplay/code/code.php?" width=134 height=60><br><img src='+IMG+'/1x1.gif width=1 height=10><br>Код: <input type=text name=code size=4 class=gr_text id=CAPCODE><br><img src='+IMG+'/1x1.gif width=1 height=10></td></tr>' : '<input type=hidden name=code size=4 value="12345" class=gr_text id=CAPCODE>')+'</table></td></tr></table></FORM>';
				
				buttons = '<div align="center"><br>'+(!ingr[0][0] ? '<font color=#CC0000>Не найдена удочка.</font>' : '<a class="gBut" href="javascript:getFishing();">Ловить</a>')+'</div>'; 
			break;
			case 2:
				var messal = '<table cellspacing=1 cellpadding=5 border=0 width=100%>';
				for (var i in ingr) messal += '<tr border=1><td bgcolor=#FFFFFF border=1 class="centr"><font class=user><b>'+ingr[i][0]+'</b> ['+ingr[i][1]+']</font><br /><img src="/images/persons/male_'+ingr[i][2]+'.gif" width=50 height=100 /></td><td bgcolor=#FFFFFF>'+vState(ingr[i][5])+'</td><td bgcolor=#FFFFFF class="centr"><b>x'+ingr[i][3]+'</b><br><img src="/public_content/mapimg/attack.gif" style="cursor:pointer;" onClick="getBattle('+ingr[i][4]+');" /></td></tr>';
				messal += '</table>';
			break;
			case 3:
				var tr = 0;
				var messal = '<table cellspacing=1 cellpadding=5 border=0 width=100%>';
				for (var i in ingr)
				{
					tr++;
					if(tr == 1) messal += '<tr>';
					messal+= '<td bgcolor="#FFFFFF" valign="top" width="25%"><div align="center"><b>'+ingr[i][2]+'</b><br>('+ingr[i][0]+' : '+ingr[i][1]+')<br><br><input type="button" class="jBut2" onClick="goTeleport(\''+ingr[i][0]+'\',\''+ingr[i][1]+'\');" value="'+ingr[i][3]+' LN" /></div></td>';
					if(tr == 4){messal+= '</tr>';tr = 0;}  
				}
				messal += '</table>';
			break;
				
		}
		var mhtml = '<table width="760" cellspacing="0" cellpadding="0" border="0" class="uni_window"><tr><td class="wu_top_left png"></td><td class="wu_top"></td><td class="wu_top_right png"></td></tr><tr><td class="wu_l_gr"></td><td class="wu_m_gr">'+messal+'</td><td class="wu_r_gr"><a href="javascript: RemoveDialogDiv();" class="circ"></a></td> </tr><tr><td class="wu_b_l png"></td><td width="auto" class="wu_b_m"><table width="100%" cellspacing="0" cellpadding="0" border="0"><tr><td class="wu_b_m_l"></td><td>'+buttons+'</td><td class="wu_b_m_r"></td></tr></table></td><td class="wu_b_r png"></td></tr><tr><td colspan="3"><div class="wu_bb_l png"></div><div class="wu_bb_r png"></div></td></tr></table>'; 
		d.body.appendChild(ND);
		LD = d.getElementById(did);
		LD.innerHTML = mhtml; 
			
		DD = d.getElementById('darker');
		DD.style.height = getDocHeight()+'px'; 
	}
}

function getDocHeight() 
{
    return Math.max(Math.max(d.body.scrollHeight,d.documentElement.scrollHeight),Math.max(d.body.offsetHeight,d.documentElement.offsetHeight),Math.max(d.body.clientHeight,d.documentElement.clientHeight));
}

function RemoveDialogDiv()
{
    d.body.removeChild(LD);
    d.body.removeChild(DD);
    ND = false;    
}

function vState(a)
{
//	alert(a);
	r = '<table width="100%">';
		r+= '<tr><td><b>Сила</b>: '+a[0]+'</td><td><b>Сокрушение</b>: '+a[6]+'%</td></tr>';
		r+= '<tr><td><b>Реакция</b>: '+a[1]+'</td><td><b>Уловка</b>: '+a[7]+'%</td></tr>';
		r+= '<tr><td><b>Удача</b>: '+a[2]+'</td><td><b>Точность</b>: '+a[8]+'%</td></tr>';
		r+= '<tr><td><b>HP</b>: '+a[3]+'</td><td><b>Стойкость</b>: '+a[9]+'%</td></tr>';
		r+= '<tr><td><b>Удар</b>: '+a[4]+'</td><td><b>Пробой Брони</b>: '+a[10]+'</td></tr>';
		r+= '<tr><td><b>Класс Брони</b>: '+a[5]+'</td><td><b>Коэффициент</b>: '+a[11]+'</td></tr>';
	r+= '</table>';
	return r;
}

function getBattle(id)
{
	$.get('/gameplay/ajax/get_bots.php', {'act':2, 'bid':id}, function(r){
		arr = r.split('@');
		switch (arr[0])
		{
			case 'F5': location = '/main.php?f5=1'; break;
			case 'OK': location = '/main.php?reset=1'; break;
			case 'NO': MessBoxDiv('Монстры не найдены.'); break;
			default: MessBoxDiv('Ошибка.'); break;
		}
	});
}

function goTeleport(x,y)
{
	$.get('/gameplay/ajax/map.php', {'gotel':1, 'tx':x, 'ty':y}, function(r){
		if ( r=='NO' ) MessBoxDiv('Недостаточно деняг или телепорт не существует.');
		else location = '/main.php?reset=1';
	});
}

function getHerbal(id,code)
{
	RemoveDialogDiv();
	$.get('/gameplay/ajax/herbals.php', {'act':2, 'rid':id, 'code':code}, function(r){
		arr = r.split('@');
		if ( arr[0]=='NO' ) MessBoxDiv('Не удалось срезать растеник.');
		else if ( arr[0]=='OK' ) MessBoxDiv('Растение успешно срезано.<br><b>'+arr[1]+'</b>');
		else location = '/main.php?reset=1';
	});
}

function getFishing()
{
    var CAP = d.getElementById("CAPCODE").value;;
    var errm = '';
    if(CAP) 
    {
        var primid = '';
        var ff = d.getElementById("FISHF");
        var radio = ff.primid;
        if(radio.value) primid = radio.value;
        else {for(var i=0; i<radio.length; i++){if(radio[i].checked){primid = radio[i].value; break;}}}
		if(primid)
		{
			RemoveDialogDiv();
			$.get('/gameplay/ajax/fishing.php', {'act':2, 'primid':primid, 'code':CAP}, function(r){
				arr = r.split('@');
				if ( arr[0]=='NO' ) MessBoxDiv(arr[1]);
				else if ( arr[0]=='OK' )
				{
					MessBoxDiv(arr[1]);
				}
				else location = '/main.php?reset=1';
				if( parseInt(arr[2]) ) TimerStart( parseInt(arr[2]),1);
			});
		} else errm = 'Не выбрана приманка.';       
    } else errm = 'Введите защитный код.';
    if(errm) MessBoxDiv(errm);
}