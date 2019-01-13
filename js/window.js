function del(id, num, res)
{
    var qrt = document.getElementById('del_'+id);
    if(num == 0)
    {
        qrt.parentNode.removeChild(qrt);
        if(res)
            location.reload();
        return;
    }
    qrt.style.opacity = num/50;
    num--;
    window.setTimeout('del('+id+', '+num+', '+res+')', 10);
}

function timeUPD(id, time, res)
{
    var dllT = document.getElementById('dll_'+id);
    if(time == 0)
    {
        dllT.innerHTML = '0 сек';
        window.setTimeout('del('+id+', 30, '+res+')', 1);
        return;
    }
    dllT.innerHTML = (time/200).toFixed(2) + " сек";
    time--;
    window.setTimeout('timeUPD('+id+', '+time+', '+res+')', 0);
}

function wind(id, title, message, url)
{
    var dv_mess = document.getElementById('message');
    var rnd = Math.random()*10000;
    rnd = rnd.toFixed(0);
    var restart = 0;
    var div_class = 'msg_red';
    var color = '#fff';
    switch(id)
    {
        case '1':
        case 'success':
        {
            div_class = 'msg_green';
        } break;
        
        case '2':
        case 'error':
        {
            div_class = 'msg_red';
        } break;
        
        case '3':
        {
            div_class = 'msg_yellow';
        } break;
        
        case 'restart':
        {
            div_class = 'msg_green';
            restart = 1;
        } break;
        
        case 'lP':
        {
            view(message, 1);
            loadPage(url, message, title);
            return;
        } break;
        
        default:
        {
            title = "Ошибка";
            div_class = 'msg_red';
            message = "Нельзя выполнить данную операцию";
        } break;
    }
    dv_mess.innerHTML += "<div class='msg_d' id='del_"+rnd+"'><div class='msg_title'>"+title+"</div><div class='msg_mse'>"+message+"</div><div class='timer' id='dll_"+rnd+"' style='float:right;'></div></div>";
    timeUPD(rnd, 500, restart);
    var dll = document.getElementById('del_'+rnd);
    dll.className += ' '+div_class;
    //dll.style.background = backgr;
    dll.style.color = color;
    return;
}