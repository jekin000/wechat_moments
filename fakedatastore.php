<?php

class DataStore
{
    private $queryret;
    private $delkeys;
    private $setdataval;

    public function __construct()
    {
        $this->queryret = array('hello');
        $this->delkeys  = array();
        $this->setdataval = array();
    }

    /* real fake API */
    public function setdata($key,$val)
    {
        array_push($this->setdataval,$val);
        return true;
    }

    public function getdata($appkey,$key)
    {
        return 'hello, I am fake';
    }

    public function getallkeys($prefix=false)
    {
        return $this->queryret;
    }

    public function delbykeys($keys)
    {
        $this->delkeys = $keys;
    }

    /* test function*/
    public function tstClearSetval()
    {
        $this->setdataval = array();
        return;
    }

    public function tstSetQueryKeys($queryret)
    {
        $this->queryret = $queryret;
    }
    public function tstGetDelKeys()
    {
        return $this->delkeys;
    }
    
    public function tstGetSetData()
    {
        return $this->setdataval;
    }
}

?>
