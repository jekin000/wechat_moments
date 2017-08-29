<?php

//require_once('datastore.php');
require_once('fakedatastore.php');

class HeartStone
{
    private $dbh; 
    
    public function __construct()
    {
        $this->dbh = new DataStore('teahouse_heartstone');
    }

    public function tstSetDbh($dbh)
    {
        $this->dbh = $dbh;
    }

    public function tstGetDbh()
    {
        return $this->dbh;
    }

    public function show_menu()
    {
       return "Welcome to your heartstone V0.03:\n"
           ."[001] create your deck;\n"
           ."[002] list your decks;\n"
           ;
    }

    public function createDeck($userid,$deckstr) 
    {
        $deck = $this->parseDeck($deckstr);
        if ($deck == false)
            return 'Please input write fomate of deck.';
        $name = $deck['name'];
        $json = json_encode($deck);

        $ret = $this->dbh->setdata($userid.'#@#'.$name,$json);
        if (!$ret){
            return "Fail to store data.\n";
        }
        return "create deck success!\n";

        //return $this->formatDeck($deck);
    }

    public function dbgShowallkeys($userid)
    {
        /* TODO, check permssion*/
        $ret = $this->dbh->getallkeys();
        if (count($ret) == 0)
            return 'No data in DB.';
        $i = 0;
        $msg = '';
        while ($val = current($ret))
        {
            $msg = $msg.'['.$i.']'.' '.key($ret)."\n";
            $i = $i + 1;
            next($ret);
        }
        return $msg;
    }
    public function dbgDelAnyDeck($userid,$ids)
    { 
        /* TODO, check permssion*/
        $idarr = explode(' ',$ids);

        $ret = $this->dbh->getallkeys();
        if (count($ret) == 0)
            return 'No data in DB.';

        $delkeys = $this->getMatchId($ret,$idarr);
        if (count($delkeys) == 0)
            return 'No match idx.';
        
        $this->dbh->delbykeys($delkeys);

        $cnt = count($delkeys);
        $msg = '';
        for ($i=0; $i<$cnt; $i++){
            $msg = $msg.'[Delete] '.$delkeys[$i].";\n";
        }
        return $msg;
    }

    public function listdeck($userid)
    {
        /* TODO , use deck name*/
        $ret = $this->dbh->getallkeys($userid);
        if (count($ret) == 0)
            return 'No data in DB.';
        $i = 0;
        $msg = '';
        while ($val = current($ret))
        {
            $msg = $msg.'['.$i.']'.' '.key($ret)."\n";
            $i = $i + 1;
            next($ret);
        }
        return $msg;
    }
    private function parseDeck($deckstr)
    {
        $deck = array();
        $arr = $this->parseName($deckstr);
        if (strlen($arr[0]) == 0)
            return false;
        $deck['name'] = $arr[0];
        
        $matchcnt = array('viccnt'=>0,'defcnt'=>0);
        $deck['matchcnt'] = $matchcnt;

        $leftarr = $this->parseCardGrp($arr[1]); 
        $deck['cardgrps'] = $leftarr[0];
        $deck['hash'] = $leftarr[1];
        $deck['isfavor'] = false;
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
    private function isValidIdRange($idarr,$cnt)
    {
        $idarrcnt = count($idarr);
        for ($i=0 ;$i<$idarrcnt ;$i++){
            if ($idarr[$i] > $cnt-1)
                return false;
        }
        return true;
    }
    private function getMatchId($set,$ids)
    {
        $sortret = sort($ids,SORT_NUMERIC);
        if (!$sortret)
            return array();

        if (!$this->isValidIdRange($ids,count($set)))
            return array();

        $unids = array_unique($ids);
        $i = 0;
        $delkeys = array();        
        $idarrlen = count($unids);
        while (current($set) && $idarrlen>0)
        {
            if ($i == $unids[0]){
                array_push($delkeys,key($set));
                array_shift($unids);
                $idarrlen = $idarrlen - 1;
            }

            next($set);
            $i = $i + 1;
        }    
        return $delkeys;
    }
}

?>
