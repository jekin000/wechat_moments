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
        /*
        $db = new DataStore();
        $ret = $db->setdata('heartstone',$userid,$deckstr);
        if (!$ret){
            return "Fail to store data.\n";
        }
        return "create deck success!\n";
        */
        $deck = $this->parseDeck($deckstr);
        return $this->formatDeck($deck);
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
    private function parseDeck($deckstr)
    {
        $deck = array();
        $arr = $this->parseName($deckstr);
        $deck['name'] = $arr[0];
        
        $matchcnt = array('viccnt'=>0,'defcnt'=>0);
        $deck['matchcnt'] = $matchcnt;

        $leftarr = $this->parseCardGrp($arr[1]); 
        $deck['cardgrps'] = $leftarr[0];
        $deck['hash'] = $leftarr[1];
        return $deck;
    }
    private function parseName($input)
    {
        $arr = explode('#',$input,5); 
        $name = trim($arr[3]);
        $left = $arr[4];
        return array($name,$left);
    }
    private function parseCardGrp($leftstr)
    {
        $arrleft =  explode('#',$leftstr);
        $arrleftcnt = count($arrleft);

        $oricards = array();
        for ($i=4; $i<$arrleftcnt; $i++){
            if (strlen($arrleft[$i])<80 && strlen($arrleft[$i])>2){
                array_push($oricards,$this->parseCard($arrleft[$i],$i-4));
            }
            else if (strlen($arrleft[$i])>80 &&strlen($arrleft[$i])<110){
                # hash = 87
                # comment = 110
                $hash = $arrleft[$i];
                break;
            }
        }
        $cardgrps = $oricards;
        return array($cardgrps,$hash);
    }
    private function parseCard($cardstr,$idx)
    {
        /*
            each cardstr=' 2x (3) 闪电风暴';
                Array
                (
                    [0] => 
                    [1] => 2
                    [2] => 
                    [3] => 
                    [4] => 3
                    [5] => 
                    [6] => 闪电风暴
                )

        */
        $arr = $this->parseMultiDelimer(array(' ','x','(',')',"\n"),$cardstr);
        return array(
                        'id'        => $idx
                        ,'name'     => $arr[6]
                        ,'cost'     => $arr[4]
                        ,'count'    => $arr[1]
                        ,'oricount' => $arr[1]
                        ,'prob'     => intval($arr[1])/30.0
                        ,'appear'   => 0.0
                        ,'appearsum'=> 0
                        ,'istmp'    => false
                    );
    }
    
    private function parseMultiDelimer($delimers,$s)
    {
        $ready = str_replace($delimers,$delimers[0],$s); 
        return explode($delimers[0],$ready);
    }
    
    private function formatDeck($deck,$isPrtProb=false)
    {
        $fmt = '';
        $allcnt = 0;
        $cardgrps = $deck['cardgrps'];
        $cardslen = count($cardgrps);
        
        for ($i=0; $i<$cardslen; $i++)
        {
            if ($cardgrps[$i]['count'] > 0)
                $allcnt = $allcnt +  $cardgrps[$i]['count'];
        }

        for ($i=0; $i<$cardslen; $i++)
        {
            if ($cardgrps[$i]['count'] > 0)
                $fmt = $fmt.$cardgrps[$i]['id']
                    .' ('.$cardgrps[$i]['cost'].')'
                    .' '.$cardgrps[$i]['count'].'x'
                    .' '.$cardgrps[$i]['name']
                    ;

                if ($isPrtProb)
                    $fmt = $fmt.' '.sprintf("%.2f%%", $cardgrps[$i]['prob']* 100);

                $fmt = $fmt."\n";
        }

        return '['.$deck['name'].']'." $allcnt"."x\n".$fmt;
    }
}

?>
