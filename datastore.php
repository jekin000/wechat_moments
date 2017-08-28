<?php

class DataStore
{
    private $saekv;
    public function __construct()
    {
        $a = func_get_args(); 
        $i = func_num_args(); 
        if (method_exists($this,$f='__construct'.$i)) { 
            call_user_func_array(array($this,$f),$a); 
        }  
    }

    public function __construct1($appkey)
    {
        $this->saekv = new SaeKV();
        $this->saekv->init($appkey);
    }

    public function setdata($key,$val)
    {
        $ret = $this->saekv->set($key,$val);
        if (!$ret){
            $ret = $this->saekv->add($key,$val);
            if (!$ret){
                sae_debug('add '.$key.' fail.');
                return false;
            }
        }
        return true;
    }

    public function getdata($key)
    {
        return $this->saekv->get($key);
    }

    public function getallkeys($prefix=false)
    {
        # it could big than 100 
        if (!$prefix)
            return $this->saekv->pkrget('', 100);
        else
            return $this->saekv->pkrget($prefix, 100);
    }

    public function delbykeys($key)
    {
        $cnt = count($key);
        for ($i=0; $i<$cnt ;$i++){
            $this->saekv->delete($key[$i]);
        }
        return;
    }
}
?>
