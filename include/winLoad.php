<?php
if($this->_account->getID() && $this->_account->getLoginMode() && $this->_account->getCha())
{
    /**
     * Для авторизированных пользователей
     **/
    switch($this->pInfo($_GET['option']))
    {
        case 'profile':
        {
            $account = new account($this->pInfo($_GET['id']));
            @include("win/profile.php");
        } break;
        
        case 'info':
        {
            $info = new user($_GET['id']);
            @include("win/info.php");
        } break;
        
        default:
        {
            @include("win/error.php");
        } break;
    }
} else {
    switch($this->pInfo($_GET['option']))
    {        
        /**
         * Для гостей
         **/
        case '1':
            {
                @include("win/auth.php");
            } break;
        
        case 'info':
        {
            $this->getBartText();
        } break;
        
        case 'auth':
        {
            $this->getAuth();
        } break;
        default:
            {
                @include("win/error.php");
        } break;
    }
}
?>