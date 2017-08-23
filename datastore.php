<?php

class DataStore
{
    private function initHandle($appkey)
    {
        //init($appkey) will fail if appkey exsit
        return new SaeKV();
    }

    public function setdata($appkey,$key,$val)
    {
        $dbh = $this->initHandle($appkey);
        if (!$dbh)
            return false;
        
        $ret = $dbh->set($key,$val);
        if (!$ret){
            $ret = $dbh->add($key,$val);
            if (!$ret){
                sae_debug('add '.$key.' fail.');
                return false;
            }
        }
        return true;
    }

    public function getdata($appkey,$key)
    {
        $dbh = $this->initHandle($appkey);
        if (!$dbh)
            return false;

        return $dbh->get($key);
    }
}
?>
