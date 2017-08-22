<?php


class HeartStone
{
    public function show_menu()
    {
       return "[001] create your deck;\n"
           ."[002] get your deck;\n"
           ;
    }

    public function createDeck($username,$deckstr) 
    {
        $kv = new SaeKV();
        $kv->init("heartstone");
        $ret = $kv->set($username,$deckstr);
        if ($ret == false){
            return "Fail to store data.\n";
        }
        return "create deck success!\n";
    }
    public function showdeck($username)
    {
        $kv = new SaeKV();
        $kv->init("heartstone");
        $ret = $kv->get($username);
        if ($ret == false){
            return "Fail to get deck.\n";
        }

        return 'Your deck is: '.$ret."\n";
    }
}

?>
