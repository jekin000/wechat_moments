<?php

require_once('datastore.php');
//require_once('fakedatastore.php');

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

    public function showMenu()
    {
       return "Welcome to your heartstone V0.5:\n"
           ."[001] create your deck;\n"
           ."[002] list your decks by favor;\n"
           ."[003] set your favorite decks;\n"
           ."[004] set result to your favor deck;\n"
           ."[005] list your decks by win-rate;\n"
           ."[006] draw cards;\n"
           ;
    }
    
    public function showDeck($userid)
    {
        $deck = $this->getFavorDeck($userid);
        if (!$deck)
            return 'Can not get Deck.';

        return $this->formatDeck($deck,false,true);
    }
    public function showDrawCards($userid,$drawids)
    {
        $deck = $this->drawCards($userid,$drawids);
        if (!$deck)
            return 'Draw card fail.';

        return $this->formatDeck($deck,true);
        
    }
    public function showCreateDeckResult($userid,$deckstr) 
    {
        $deck = $this->createDeck($userid,$deckstr); 
        if ($deck == 'deck invalid')
            return 'Please input write fomate of deck.';
        else if ($deck == 'save fail') 
            return "Fail to store data.\n";
        
        return "create deck success!\n";
        
    }

    public function showSetFavorResult($userid,$isvic)
    {
        $deck = $this->setFavorResult($userid,$isvic); 
        if (!$deck)
            return 'set result fail';
       
        return $this->fmtDeckWinRate($deck); 
    }

    public function createDeck($userid,$deckstr) 
    {
        $deck = $this->parseDeck($deckstr);
        if ($deck == false)
            return 'deck invalid';
        $name = $deck['name'];
        $json = json_encode($deck);

        $ret = $this->dbh->setdata($userid.'#@#'.$name,$json);
        if (!$ret){
            return "save fail";
        }
        return $deck;

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

    public function showListDeck($userid,$type=false)
    {
        if ($type == 'by-rate')
            $decks = $this->listdeck($userid,$type); 
        else
            $decks = $this->listdeck($userid); 

        if (count($decks) == 0)
            return 'No data in DB.';

        $i = 0;
        $msg = '';
        while ($val = current($decks))
        {
            $msg = $msg.'['.$i.']'.' '.$decks[$i]."\n";
            $i = $i + 1;
            next($decks);
        }
        return $msg;
    }
    public function listdeck($userid,$type=false)
    {
        $ret = $this->dbh->getallkeys($userid);
        if (count($ret) == 0)
            return $ret;

        $decks = array();
        $i = 0;
        while ($val = current($ret))
        {
            $deck = json_decode($val,true);

            $key = key($ret);
            $arr = explode('#@#',$key);
            if (!$type){
                if ($deck['isfavor'])
                    $arr[1] = $arr[1].' *';
            }
            else if ($type == 'by-rate'){
                $arr[1] = $arr[1].' '.$this->fmtDeckWinRate($deck);
            }
            array_push($decks,$arr[1]);
            next($ret);
        }
        return $decks;
    }
    public function showSetFavorDeck($userid,$deckid)
    {
        $ret = $this->setFavorDeck($userid,$deckid);
        if (!$ret)
            return 'Set favor fail';
        return $this->showListDeck($userid);
    }

    public function setFavorDeck($userid,$deckid)
    {
        $ret = is_numeric($deckid);
        if (!$ret)
            return false;
        $deckidnum = intval($deckid);
        if ($deckidnum < 0)
            return false;

        $decks = $this->dbh->getallkeys($userid);
        $deckcnt = count($decks);
        if ($deckcnt == 0)
            return false;
        if ($deckidnum >= $deckcnt)
            return false;
        
        $i = 0; 
        $updatedecks = array();
        while ($eachval = current($decks)){
            $deck = json_decode($eachval,true);
            /* update favor*/
            if ($i == $deckidnum){
                if (!$deck['isfavor']){
                    $deck['isfavor'] = true;
                    array_push($updatedecks,$deck);
                }
            }
            else if ($deck['isfavor']){
                $deck['isfavor'] = false;
                array_push($updatedecks,$deck);
            }
            $i = $i + 1;
            next($decks);
        }
        
        
        while ($eachval = current($updatedecks)){
            $ret = $this->saveDeck($userid,$eachval);
            if (!$ret)
                return false;
            next($updatedecks);
        }
        
        return true;
    }
    public function setFavorResult($userid,$isvic)
    {
        $ret = is_numeric($isvic);
        if (!$ret)
            return false;
        $isvicnum = intval($isvic);
        if ($isvicnum!=0 && $isvicnum!=1)
            return false;
        
        $deck = $this->getFavorDeck($userid);
        if (!$deck)
            return false;

        if ($isvicnum == 1)
            $deck['matchcnt']['viccnt'] = $deck['matchcnt']['viccnt'] + 1;
        else
            $deck['matchcnt']['defcnt'] = $deck['matchcnt']['defcnt'] + 1;

        $deck = $this->restoreDeck($deck);
        $ret = $this->saveDeck($userid,$deck);
        if (!$ret)
            return false;
        return $deck;
    }
    public function getCardsCnt($deck) 
    {
        $cards = $deck['cardgrps'];
        $cnt = 0;
        while ($val = current($cards)){
            $cnt += $val['count'];
            next($cards);
        }
        return $cnt;
    }

    public function drawCards($userid,$cardnos)
    {
        $ids = $this->strToIdSeq($cardnos); 
        $ret = $this->isValidIdSeq($ids,0,0,29);
        if (!$ret)
            return false;

        $deck = $this->getFavorDeck($userid);
        if (!$deck)
            return false;

        $ret = sort($ids,SORT_NUMERIC);
        if (!$ret)
            return false;

        $allcardcnt = $this->getCardsCnt($deck);
        $cardcnt = count($deck['cardgrps']);
        $idarrlen = count($ids);
        $allcardcnt = $allcardcnt - $idarrlen;

        for ($i=0; $i<$cardcnt ;$i++)
        {
            if ($idarrlen > 0){
                if ($deck['cardgrps'][$i]['id'] == $ids[0]){
                    if ($deck['cardgrps'][$i]['count'] > 0){
                        $deck['cardgrps'][$i]['count']--;
                        array_shift($ids);
                        $idarrlen = $idarrlen - 1;
                    }
                }
            }
            $deck['cardgrps'][$i]['prob'] = $deck['cardgrps'][$i]['count']/$allcardcnt*1.0;
        }

        $ret = $this->saveDeck($userid,$deck);
        if (!$ret)
            return false;

        return $deck;
    }
    public function restoreDeck($deck)
    {
        $cardcnt = count($deck['cardgrps']);
        for ($i=0; $i<$cardcnt ;$i++)
        {
            $deck['cardgrps'][$i]['count']
                = $deck['cardgrps'][$i]['oricount'];
            $deck['cardgrps'][$i]['prob'] = $deck['cardgrps'][$i]['count']/30.0;
        }

        return $deck;
    }

    private function getFavorDeck($userid)
    {
        $ret = $this->dbh->getallkeys($userid);
        if (count($ret) == 0)
            return $ret;

        while ($val = current($ret))
        {
            $deck = json_decode($val,true);

            if ($deck['isfavor'])
                return $deck;
            next($ret);
        }
        return false;
    }

    private function saveDeck($userid,$deck)
    {
        $ret = $this->dbh->setdata($userid.'#@#'.$deck['name'],json_encode($deck));
        if (!$ret)
            return false;
        
        return true;
    }
    private function parseDeck($deckstr)
    {
        $deck = array();
        $arr = $this->parseName($deckstr);
        if (strlen($arr[0]) == 0)
            return false;
        $deck['name'] = $arr[0];
        $deck['role'] = trim($arr[2]);
        
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
        $arr = explode('#',$input,6); 
        $name = trim($arr[3]);
        $role = $arr[4];
        $left = $arr[5];

        $rolearr = explode('：',$role);
        $role = $rolearr[1];
        return array($name,$left,$role);
    }
    private function parseCardGrp($leftstr)
    {
        $arrleft =  explode('#',$leftstr);
        $arrleftcnt = count($arrleft);

        $oricards = array();

        /*
                Array
                (
                    [0] =>  模式：标准模式
                    [1] =>  猛犸年
                    [2] => 
                    [3] =>  2x (1) 冰川裂片
                    [4] =>  1x (2) 低温静滞
                    [5] =>  2x (2) 冷冻鱼人
                    ...
                )
                hash = 70+
                comment = 100+
        */
        for ($i=3; $i<$arrleftcnt; $i++){
            $len = strlen(trim($arrleft[$i]));
            if ($len<70 && $len>2){
                array_push($oricards,$this->parseCard($arrleft[$i],$i-3));
            }
            else if ($len>70 && $len<110){
                # hash = 87
                # comment = 110
                $hash = trim($arrleft[$i]);
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
    
    private function formatDeck($deck,$isPrtProb=false,$isPrtVic=false)
    {
        $fmt = '';
        $allcnt = 0;
        $cardgrps = $deck['cardgrps'];
        $cardslen = count($cardgrps);
        
        $viccnt = '';
        if ($isPrtVic){
            $viccnt = '胜率：'.$this->fmtDeckWinRate($deck)
                .' from'
                .' '.($deck['matchcnt']['viccnt']+$deck['matchcnt']['defcnt']).' matches'
                ."\n";
        }
        for ($i=0; $i<$cardslen; $i++)
        {
            if ($cardgrps[$i]['count'] > 0)
                $allcnt = $allcnt +  $cardgrps[$i]['count'];
        }

        for ($i=0; $i<$cardslen; $i++)
        {
            if ($cardgrps[$i]['count'] > 0){
                $fmt = $fmt.$cardgrps[$i]['id']
                    .' ('.$cardgrps[$i]['cost'].')'
                    .' '.$cardgrps[$i]['count'].'x'
                    .' '.$cardgrps[$i]['name']
                    ;

                if ($isPrtProb)
                    $fmt = $fmt.' '.sprintf("%.2f%%", $cardgrps[$i]['prob']* 100);

                $fmt = $fmt."\n";
            }
        }

        return '['.$deck['name'].']'." $allcnt"."x\n".$viccnt.$fmt;
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
    private function strToIdSeq($strIdSeq)
    {
        $tmparr = array();
        $nos = explode(' ',$strIdSeq);
       
        $cnt = count($nos);
        for ($i=0; $i<$cnt; $i++){
            array_push($tmparr,intval($nos[$i]));
        }

        $out = array_unique($tmparr);


        return $out;
    }
    private function isValidIdSeq($idseq,$cntlmt,$min,$max)
    {
        if ($cntlmt>0 && count($idseq)>$cntlmt)
            return false;
        
        while ($val = current($idseq)){
            if ($val<$min || $val>$max)
                return false;
            next($idseq);
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
    private function fmtDeckWinRate($deck)
    {
        if ($deck['matchcnt']['viccnt']
            +$deck['matchcnt']['viccnt'] == 0)
            return '';

        $rate = $deck['matchcnt']['viccnt'] 
            / ($deck['matchcnt']['viccnt']+$deck['matchcnt']['defcnt'])*1.0;  
        if ($rate == 0)
            return '';

        return sprintf("%.2f%%",$rate*100);
    }

}

?>
