<?php


class HeartStone
{
    public function show_menu()
    {
       return "[001] create your deck\n";
    }

    public function createDeck($deckstr) 
    {
        return 'create deck -> '.$deckstr."\n";
    }
}

?>
