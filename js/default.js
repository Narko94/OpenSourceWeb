var onload = function()
{
    addClient();
    return;
}

var message = function(num, id) {
    var e = {
        'totalQ' : 0,
        'elemDiv' : null,
        start : function(num, id)
        {
            this.elemDiv = document.getElementById(id);
            this.totalQ = num;
            var test = this;
            var pro = function(){
                if(test.totalQ >= 100)
                {
                    test.elemDiv.innerHTML = test.totalQ;
                    test.totalQ--;
                }
                else
                {
                    clearInterval(opNN);
                }
            };
            var opNN = setInterval(pro, 1);
        }
    };
    e.start(num, id);
};

var view = function(id, t)
{
    var q = {
        'elemView' : 0,
        start : function(id, t)
        {
            if(!this.elemView)
            {
                this.elemView = document.getElementById(id);
                switch(t)
                {
                    case 1:
                    case 'view':
                    {
                        this.view();
                    } break;
                    
                    case 2:
                    case 'hide':
                    {
                        this.hide();
                    } break;
                    
                    default:
                    {
                        if(this.elemView.style.display == 'none')
                        {
                            this.view();
                        }
                        else
                        {
                            this.hide();
                        }
                    } break;
                }
            }
        },
        
        view : function()
        {
            this.elemView.style.display = 'block';
        },
        
        hide : function()
        {
            this.elemView.style.display = 'none';
        }
    };
    q.start(id, t);
};

function loadPage(url, id, title)
{
    var content = document.getElementById(id+'_1');
    var title_msg = document.getElementById(id+'_win_main');
    if(title_msg != null)
    {
        title_msg.innerHTML = title;
    }
    var loading = document.getElementById('loading');
    content.innerHTML = loading.innerHTML;
    window.setTimeout("loadPageIQ('"+url+"', '"+id+"')", 100);
    return;
}

function loadPageIQ(url, id)
{
    var content = document.getElementById(id+'_1');
    var loading = document.getElementById('loading');
    var http = curl();
    var a, e;
    
    content.innerHTML = loading.innerHTML;
       
    if(http)
    {
        http.open('get', url+'&lv=1');
        http.onreadystatechange = function ()
        {
            if(http.readyState == 4 && http.status == 200)
            {
                //a = content.innerHTML.replace(/\r|\n/g, '');
                //e = http.responseText.replace(/\r|\n/g, '');
                content.innerHTML = http.responseText;
            }
        }
        http.send(null);
    }
    else
    {
        content.innerHTML = "Ошибка загрузки";
        return;
    }
    return;
}

function curl() 
{
    try { return new XMLHttpRequest() }
    catch(e) 
    {
        try { return new ActiveXObject('Msxml2.XMLHTTP') }
        catch(e) 
        {
            try { return new ActiveXObject('Microsoft.XMLHTTP') }
            catch(e) { return null; }
        }
    }
}

function iForm(url)
{
    var form = new FormData(document.forms.form);
    var http = curl();
    var el = null;
    if(http)
    {
        http.open("POST", url+"&lv=1", true);
        http.onreadystatechange = function ()
        {
            if(http.readyState == 4)
            {
                var el = eval(http.responseText);
                if(el.id == 'lP')
                {
                    wind(el.id, el.title, el.mess, el.url);
                }
                else
                {
                    wind(el.id, el.title, el.mess);
                }
            }
        }
        http.send(form);
    }
    return;
}

function goUrl(url)
{
    var http = curl();
    if(http)
    {
        http.open('get', url+'&lv=1');
        http.onreadystatechange = function ()
        {
            if(http.readyState == 4)
            {
                var el = eval(http.responseText);
                wind(el.id, el.title, el.mess);
            }
        }
        http.send(null);
    }
    else
    {
        wind('error', 'Ошибка', 'Данная операция не выполнена');
        return;
    }
    return;
};