<?php
if($this->_account->getID() && $this->_account->getLoginMode() && $this->_account->getCha())
{
    /**
     * Для авторизированных пользователей
     **/
    switch($_GET['do'])
    {
        case 'main' : include("./include/index.php"); break;
        case 'win' : include("./include/winLoad.php"); break;
        case 'logout' : include("./include/logout.php"); break;
        case 'abonent' : include("./include/abonent.php"); break;
        default: include("./include/index.php"); break;
    }
}
else
{
    /**
     * Для гостей
     **/
    switch($_GET['do'])
    {
        case 'main' : include("./include/index.php"); break;
        case 'win' : include("./include/winLoad.php"); break;
        default: include("./include/index.php"); break;
    }
}
?>