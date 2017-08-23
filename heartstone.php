<?php

require_once('datastore.php');
//require_once('fakedatastore.php')

class HeartStone
{
    public function show_menu()
    {
       return "Welcome to your heartstone V0.01:\n"
           ."[001] create your deck;\n"
           ."[002] get your deck;\n"
           ;
    }

    public function createDeck($userid,$deckstr) 
    {
        $db = new DataStore();
        $ret = $db->setdata('heartstone',$userid,$deckstr);
        if (!$ret){
            return "Fail to store data.\n";
        }
        return "create deck success!\n";
    }
    public function showdeck($userid)
    {
        $db = new DataStore();
        $ret = $db->getdata('heartstone',$userid);
        if (!$ret){
            return "Fail to get deck.\n";
        }

        return 'Your deck is: '.$ret."\n";
    }
}

?>
