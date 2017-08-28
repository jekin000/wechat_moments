<?php

class DataStore
{
    private $queryret;
    private $delkeys;

    public function __construct()
    {
        $this->queryret = array('hello');
        $this->delkeys  = array();
    }

    /* real fake API */
    public function setdata($appkey,$key,$val)
    {
        return true;
    }

    public function getdata($appkey,$key)
    {
        return 'hello, I am fake';
    }

    public function getallkeys($appkey,$prefix=false)
    {
        return $this->queryret;
    }

    public function delbykeys($keys)
    {
        $this->delkeys = $keys;
    }

    /* test function*/
    public function tstSetQueryKeys($queryret)
    {
        $this->queryret = $queryret;
    }
    public function tstGetDelKeys()
    {
        return $this->delkeys;
    }
}

?>
