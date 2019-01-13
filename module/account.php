<?php

class account extends connect
{
    private $_accInfo = array();
    
    private $_accAccess;
    
    private $_id = 0;
    
    private $_login = null;
    
    private $_cha = null;
    
    private $_loginMode = 0;
    
    private $_email = null;
    
    private $_group = 0;
       
    function __construct($id = 0)
    {
        parent::__construct();
        if(!$id)
        {
            $id = $_SESSION['id'];
            $cha = session_id();
            $mode = $_SESSION['mode'];
            $q = $this->q("SELECT ch.*, acc.* FROM `cache` as ch, `account` as acc WHERE ch.`login`='".$id."' AND ch.`cha`='".$cha."' AND ch.`mode`='".$mode."' AND ch.`login`=acc.`id`");
            $num = $q->num_rows;
            if($num)
            {
                $row = mysqli_fetch_array($q);
                $this->_id = $row[5];
                $this->_login = $row[6];
                $this->_cha = session_id();
                $this->_loginMode = $mode;
                $this->_email = $row[11];
                $this->_group = $row['group'];
                $a = $this->q("SELECT aid.`name`, ai.`value` FROM `account_info` as ai, `account_info_data` aid WHERE ai.`user_id`='".$this->_id."' AND ai.`info_id`=aid.`id`");
                $num = $a->num_rows;
                if($num)
                {
                    for($i = 0; $i < $num; $i++)
                    {
                        $row = mysqli_fetch_array($a);
                        $this->_accInfo[] = $row['name'];
                        $this->_accInfo[] = $row['value'];
                    }
                }
                
                $a = $this->q("SELECT aa.`date_1`, aa.`date_2`, ca.`name`, ca.`name_2`, ca.`comment` FROM `account_access` as aa, `cfg_access` as ca WHERE aa.`user_id`='".$this->_id."' AND ca.`id`=aa.`access` order by aa.`id`");
                $num = $a->num_rows;
                if($num)
                {
                    for($i = 0; $i < $num; $i++)
                    {
                        $row = mysqli_fetch_array($a);
                        if(($row['date_1'] < $this->iTime(1) && $row['date_2'] > $this->iTime(1)) || ($row['date_2'] == 0))
                        {
                            $this->_accAccess[] = $row['name'];
                            $this->_accAccess[] = $row['name_2'];
                            $this->_accAccess[] = $row['comment'];
                        }
                    }
                }
            }
        }
        else
        {
            $q = $this->q("SELECT acc.* FROM `account` as acc WHERE `id`='".$id."'");
            $num = $q->num_rows;
            if($num)
            {
                $row = mysqli_fetch_array($q);
                $this->_id = $row[0];
                $this->_login = $row[1];
                $this->_email = $row[6];
                $this->_group = $row['group'];
                $a = $this->q("SELECT aid.`name`, ai.`value` FROM `account_info` as ai, `account_info_data` aid WHERE ai.`user_id`='".$this->_id."' AND ai.`info_id`=aid.`id`");
                $num = $a->num_rows;
                if($num)
                {
                    for($i = 0; $i < $num; $i++)
                    {
                        $row = mysqli_fetch_array($a);
                        $this->_accInfo[] = $row['name'];
                        $this->_accInfo[] = $row['value'];
                    }
                }
            }
        }
    }
    
    function getGroup()
    {
        $q = $this->q("SELECT * FROM `account_group` WHERE `id`='".$this->_group."'");
        $num = $q->num_rows;
        if($num)
        {
            $row = mysqli_fetch_array($q);
            return $row['name'];
        }
        return;
    }
    
    function getGroupID()
    {
        return $this->_group;
    }
    
    function getAccInfo()
    {
        $count = count($this->_accInfo);
        for($i = 0; $i < $count; $i++)
        {
            @include("./include/dop/pole.php");
            $i++;
        }
        return;
    }
    
    function getLogin()
    {
        return $this->_login;
    }
    
    function getCha()
    {
        return $this->_cha;
    }
    
    function getLoginMode()
    {
        return $this->_loginMode;
    }
    
    function setLogin($login)
    {
        $this->_login = $login;
        return;
    }
    
    function getEmail()
    {
        return $this->_email;
    }
    
    function setEmail($email)
    {
        $this->_email = $email;
        return;
    }
    
    function getID()
    {
        return $this->_id;
    }
    
    function setID($id)
    {
        $this->_id = $id;
        return;
    }
    
    public function getAuth()
    {
        if(!$this->_login && !$this->_id && !$this->_loginMode)
            $login = $this->pInfo($_POST['login']);
            $pass = $this->pInfo($_POST['pass']);
            $pass = sha1(md5(base64_encode($pass).":".base64_encode(strtoupper($login))));
            $mode = $this->pInfo($_POST['ch']);
            if($mode == 'on')
            {
                $mode = 2;
            }
            else
            {
                $mode = 1;
            }
            $q = $this->q("SELECT * FROM `account` WHERE `name`='".$login."' AND `sha_pass`='".$pass."'");
            $num = $q->num_rows;
            if($num)
            {
                $row = mysqli_fetch_array($q);
                $this->q("INSERT INTO `cache` SET `login`='".$row[0]."', `cha`='".session_id()."', `mode`='".$mode."', `date`='".$this->iTime(1)."'");
                $_SESSION['user'] = $login;
                $_SESSION['id'] = $row[0];
                $_SESSION['mode'] = $mode;
                $_SESSION['qrsk'] = 1;
                if($_GET['lv'] == 1)
                    $this->sendMessage("restart", "Авторизация", "Вы успешно авторизировались");
                return;
            }
            if($_GET['lv'] == 1)
                $this->sendMessage("error", "Авторизация", "Данная учетная запись не найдена");
        
        return;
    }
    
    function logout()
    {
        if($this->_login && $this->_id && $this->_loginMode)
        {
            $this->q("DELETE FROM `cache` WHERE `login`='".$this->_id."' AND `mode`='".$this->_loginMode."' AND `cha`='".$this->_cha."'");
            
            $this->_id = 0;
            $this->_login = null;
            $this->_cha = null;
            $this->_loginMode = 0;
            $this->_avatar = "no.png";
            session_unset();
            if($_GET['lv'] == 1)
                $this->sendMessage("restart", "Успешно", "Вы вышли из учетной записи");
            return;
        }
        if($_GET['lv'] == 1)
            $this->sendMessage("error", "Ошибка", "Вы не авторизированы");
        return;
    }
    
    function getAccess($name)
    {
        $q = $this->q("SELECT a_a.* 
        FROM `cfg_access` as c_a, `account_access` as a_a 
        WHERE c_a.`cfg_name`='".$name."' 
        AND c_a.`id`=a_a.`access` 
        AND (a_a.`date_2`>'".$this->iTime(1)."' or a_a.`date_2`='0') 
        AND ((a_a.`type`='0' AND a_a.`user_id`='".$this->getGroupID()."') or (a_a.`type`='1' AND a_a.`user_id`='".$this->_id."'))");
        $num = $q->num_rows;
        if($num)
        {
            //$row = mysql_fetch_array($q);
            return 1;
        }
        return 0;
    }
    
    function getNameAccess($name)
    {
        $q = $this->q("SELECT * FROM `cfg_access` WHERE `cfg_name`='".$this->pInfo($name)."'");
        $num = $q->num_rows;
        if($num)
        {
            $row = mysqli_fetch_array($q);
            return $row;
        }
        return;
    }

    function getButtonAdd($id)
    {
        $accAccess = $this->getAccess($id);
        $name = $this->getNameAccess($id);
        $name = ($accAccess) ? $name['name'] : $name['name_2'];
        $class = ($accAccess) ? "newButton" : "noAddBart";
        $dId = ($accAccess) ? "addBart" : "";
        @include("./include/button/AddClient.php");
        return;
    }
}
?>