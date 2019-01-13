<?php
if($_COOKIE["mode"] == 2)
{
    $_SESSION["mode"] = $_COOKIE["mode"];
    $_SESSION["user"] = $_COOKIE["user"];
    $_SESSION["id"] = $_COOKIE["id"];
    $_SESSION["qrsk"] = null;
    session_id($_COOKIE["cha"]);
}

include('config.php');
include('array.php');
include("./module/account.php");
include("./module/user.php");

class connect {
    
    private $_conf;
    
    private $_array;
    
    public $_imgFile;
    
    function __construct()
    {
        global $cfg, $array, $imgFile;
        $this->_conf = $cfg;
        $this->_array = $array;
        $this->_imgFile = $imgFile;
    }
    
    public function getConf($i = null)
    {
        if($i)
            return $this->_conf[$i];
        else return;
    }
    
    public function q($query)
	{
		$conn = mysqli_connect($this->_conf['ip'].":".$this->_conf['port'], $this->_conf['login'], $this->_conf['pass'], $this->_conf['db']) or die ($this->_array[0]."Ошибка подключения к базе данных, Error: #1".$this->_array[1]);
        mysqli_query($conn,"SET CHARACTER SET ".$this->_conf['en']);
        mysqli_query($conn,"SET NAMES ".$this->_conf['en']);
        return $do_query = mysqli_query($conn, $query);
		settype($do_query, "null");
		mysqli_close($conn);
	}
    
    public function statusQ()
    {
        if($conn = @mysqli_connect($this->_conf['ip'].":".$this->_conf['port'], $this->_conf['login'], $this->_conf['pass'], $this->_conf['db']))
        {
            if($conn)
            {
                settype($do_query, "null"); 
                mysqli_close($conn);
                return 1;
            }
        }
        return;
    }
    
    public function pInfo($e)
    {
        //$e = mysqli_escape_string($e);
        $e = trim($e);
        $e = htmlspecialchars($e);
        return $e;
    }
    
    /**
     * @type: 0 - date format, 1 - realUnixTime, 2 - Конвертор из даты, в unix время
     * Если $type == 2, а $unix == 1, то достаточно поместить всю дату в $day
     * Если $type == 2, а $unix == 0, то необходимо поместить день в $day, месяц в $month и т.д.
     * @unix: unix время
     * @format: Формат вывода даты
     */
    function iTime($type = 0, $unix = 0, $format = "d.m.Y H:i:s", $day = 0, $month = 0, $year = 0, $hour = 0, $min = 0, $sec = 0)
    {
        switch($type)
        {
            case '0':
            {
                if($unix)
                    return date($format, $unix);
                else
                    return date($format);
            } break;
            case '1':
            {
                return strtotime(date($format));
            } break;
            case '2':
            {
                if($unix == 1)
                {
                    $month = substr($day, 3, 2);
                    $year = substr($day, 6, 4);
                    $day = substr($day, 0, 2);
                }
                return mktime($hour, $min, $sec, $month, $day, $year);
            } break;
            default:
            {
                return "Error #1";
            } break;
        }
    }
    
    /**
     * id - success, restart, error
     * title - Заголовок
     * mess - Выводимое сообщение
     * url - если указан false, то всё, что выше, если true
     * mess - id: окна
     * title - Название окна
     **/
    function sendMessage($id, $title, $mess, $url = null)
    {
        if($id && $title && $mess && !$url)
        {
            print '({"id":"'.$id.'", "title":"'.$title.'", "mess":"'.$mess.'"})';
        }
        if($id && $title && $mess && $url)
        {
            print '({"id":"'.$id.'", "title":"'.$title.'", "mess":"'.$mess.'", "url":"'.$url.'"})';
        }
        return;
    }
    
    function error($mess, $padding = 0)
    {
        print "<div class='error' style='padding: $padding;'>".$mess."</div>";
        return;
    }
}

class work extends connect 
{
    
    private $_title; //Название проекта
    
    private $_style; //Стиль (папка)
    
    private $_css = array(); //Массив CSS
    
    private $_js = array(); //Массив JavaScript файлов
    
    private $_account;
    
    function __construct()
    {
        parent::__construct();
        $this->updData();
        $this->_account = new account();
    }
    
    function getAccInfo()
    {
        $this->_account->getAccInfo();
        return;
    }
    
    function getLogin()
    {
        return $this->_account->getLogin();
    }
    
    function getEmail()
    {
        return $this->_account->getEmail();
    }
    
    function getID()
    {
        return $this->_account->getID();
    }
    
    function page()
    {
        @include("do_href.php");
        return;
    }
    
    function updData()
    {
        $q = $this->q("SELECT * FROM `config`");
        $num = $q->num_rows;
        if($num)
        {
            for($i = 0; $i < $num; $i++)
            {
                $row = mysqli_fetch_array($q);
                $name = $row['cfg_name'];
                if($name == 'style')
                    $this->_style = $row['value'];
                if($name == 'css')
                    $this->_css[] = $row['value'];
                if($name == 'title')
                    $this->_title = $row['value'];
                if($name == 'js')
                    $this->_js[] = $row['value'];
                if($name == 'reputation')
                    $this->_reputation = $row['value'];
                if($name == 'uploadFile')
                    $this->_upload = $row['value'];
            } 
        }
        return;
    }
    
    public function getTitle()
    {
        return $this->_title;
    }
    
    public function getStyle()
    {
        return $this->_style;
    }
    
    public function getPCSS()
    {
        return $this->_css;
    }
    
    public function getPJS()
    {
        return $this->_js;
    }
    
    public function getCSS()
    {
        $css = $this->getPCSS();
        $num = count($css);
        if($num)
        {
            for($i = 0; $i < $num; $i++)
            {
                @include("./include/css.php");
            }
        }
        return;
    }
    
    public function getJS()
    {
        $js = $this->getPJS();
        $num = count($js);
        if($num)
        {
            for($i = 0; $i < $num; $i++)
            {
                @include("./include/js.php");
            }
        }
        return;
    }
    
    public function getHeader()
    {
        @include("./include/header.php");
        return;
    }
    
    public function getMenu()
    {
        $q = $this->q("SELECT * FROM `menu`");
        $num = $q->num_rows;
        if($num)
        {
            for($i = 0; $i < $num; $i++)
            {
                $row = mysqli_fetch_array($q);
                @include("./include/menu.php");
            }
        }
        return;
    }
    
    public function menuUser()
    {
        if($this->_account->getID() && $this->_account->getLoginMode() && $this->_account->getLogin())
        {
            @include("./include/Auth.php");
        }
        else
        {
            @include("./include/noAuth.php");
        }
        return;
    }
    
    public function win($id, $width = 700)
    {
        @include("./include/win.php");
        return;
    }
    
    public function getAuth()
    {
        $this->_account->getAuth();
        return;
    }
    
    function setID($id)
    {
        $this->_account->setID($id);
        return;
    }
    
    function logout()
    {
        $this->_account->logout();
        return;
    }
    
    function cache($id, $cha, $mode)
    {
        $id = $this->pInfo($id);
        $cha = $this->pInfo($cha);
        $q = $this->q("SELECT * FROM `cache` WHERE `login`='$id' AND `cha`='$cha' AND `mode`='$mode'");
        return $q->num_rows;
    }
    
    function sess_cache()
    {
        $tm = $this->iTime(1);
        $old_time = $tm - 900;
        $o_t_c = $tm - 2592000;
        $this->q("DELETE FROM `cache` WHERE `date` < '$old_time' AND `mode`='1'");
        $this->q("DELETE FROM `cache` WHERE `date` < '$o_t_c' AND `mode`='2'");
        $cha = $this->_account->getCha();
        $id = $this->_account->getID(); 
        $mode = $this->_account->getLoginMode();
        if($mode && $id && $cha)
        {
            $q = $this->q("UPDATE `cache` SET `date`='$tm' WHERE `cha`='$cha' AND `login`='$id' AND `mode`='$mode'");
        }
        return;
    }

    function getClient()
    {
        $q = $this->q("SELECT us.*, co.`code`, ta.`name` as `tname` FROM `user` as us, `code_operator` as co, `tariff` as ta WHERE us.`id_code`=co.`id` AND us.`tariff`=ta.`id`");
        $num = $q->num_rows;
        if($num)
        {
            for($i = 0; $i < $num; $i++)
            {
                $row = mysqli_fetch_array($q);
                @include("./include/dop/client.php");
            }
        }
    }
}

$conn = new connect;
$work = new work;
?>