function addClient()
{
    var elem = document.getElementById('addClient');
    if(!elem)
        return;
    var f = function f()
    {
        view('result', 1);
        loadPage('?do=win&option=addClient', 'result', this.$text);
    };
    
    elem.$text = elem.innerHTML;
    elem.onclick = f;
    return;
}