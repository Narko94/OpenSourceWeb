<?php
class user extends connect
{
    private $_id = null;
    
    private $_telephone = null;
    
    private $_fn = null;
    
    private $_ln = null;
    
    private $_on = null;
    
    private $_idCode = null;

    private $_balanse = 0.0;

    private $_tariff = null;

    private $_tPrice = null;

    private $_taCallM = 0;

    private $_taNetM = 0;

    private $_taMPrice = 0;

    private $_utCallM = 0;

    private $_utNetM = 0;
    
    function __construct($id)
    {
        parent::__construct();
        $q = $this->q("SELECT us.*, co.`code`, ta.`name` as `tname`, ta.`price` as `tprice`, ta.`call_m`, ta.`net_m`, ta.`m_price`, ut.`call_m` as `utCallM`, ut.`net_m` as `utNetM` FROM `user` as us, `code_operator` as co, `tariff` as ta, `user_tariff` as ut WHERE us.`id_code`=co.`id` AND us.`tariff`=ta.`id` AND us.`id`='$id'");
        $num = $q->num_rows;
        if($num)
        {
            $row = mysqli_fetch_array($q);
            $this->_id = $row['id'];
            $this->_telephone = $row['telephone'];
            $this->_fn = $row['fn'];
            $this->_ln = $row['ln'];
            $this->_on = $row['on'];
            $this->_idCode = $row['id_code'];
            $this->_balanse = $row['balanse'];
            $this->_tariff = $row['tname'];
            $this->_tPrice = $row['tprice'];
            $this->_taCallM = $row['call_m'];
            $this->_taNetM = $row['net_m'];
            $this->_taMPrice = $row['m_price'];
            $this->_utCallM= $row['utCallM'];
            $this->_utNetM= $row['utNetM'];
        }
    }

    public function getId()
    {
        return $this->_id;
    }

    public function getTelephone()
    {
        return $this->_telephone;
    }

    public function getFn()
    {
        return $this->_fn;
    }

    public function getLn()
    {
        return $this->_ln;
    }

    public function getOn()
    {
        return $this->_on;
    }

    public function getCode()
    {
        return $this->_idCode;
    }

    public function getBalanse()
    {
        return $this->_balanse;
    }

    public function getTariff()
    {
        return $this->_tariff;
    }

    public function getTPrice()
    {
        return $this->_tPrice;
    }

    public function getTaCallM()
    {
        return $this->_taCallM;
    }

    public function getTaNetM()
    {
        return $this->_taNetM;
    }

    public function getTaMPrice()
    {
        return $this->_taMPrice;
    }

    public function getUtCallM()
    {
        return $this->_utCallM;
    }

    public function getUtNetM()
    {
        return $this->_utNetM;
    }
}
?>