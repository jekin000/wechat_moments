<?php
require_once('heartstone.php');

$tt = new test();
//test_split();
//test_heartstone_create();
//$tt->testObj();
//$tt->test_array1();
//$tt->test_parse_str();
//$tt->test_extract_fromdeck();
$tt->test_key();
$userinput = '### 无情寒冬 初
# 职业：萨满祭司
# 模式：标准模式
# 猛犸年
#
# 2x (1) 冰川裂片
# 1x (2) 低温静滞
# 2x (2) 冷冻鱼人
# 1x (2) 衰变
# 2x (3) 妖术
# 1x (3) 法力之潮图腾
# 2x (3) 海德尼尔冰霜骑士
# 1x (3) 温泉守卫
# 2x (3) 破冰斧
# 2x (3) 达卡莱防御者
# 2x (3) 闪电风暴
# 1x (4) 锦鱼人水语者
# 2x (4) 雪崩
# 2x (5) 巫毒妖术师
# 1x (5) 火山喷发
# 1x (6) 冰冻粉碎者
# 2x (6) 冰霜元素
# 2x (6) 火元素
# 1x (6) 莫拉比
# 
AAECAaoICIEE3boC9r0Cx8ECpcICh8QCtM0CwNACC70BgAT1BP4Fl8ECts0C+80C/s0Cis4CuM4CweICAA==
# 
# 想要使用这副套牌，请先复制到剪贴板，然后在游戏中点击“新套牌”进行粘贴。
';
//$ht = new HeartStone();
//echo $ht->createDeck('aa',$userinput);


class test
{
    public function testObj()
    {
        $ht = new HeartStone();
        echo $ht->createDeck('hello');
    }

    public function test_heartstone_create()
    {
        $heartstone= new HeartStone();
        echo $heartstone->createDeck('hello');
    }
    public function test_split()
    {
        $str = '101';
        print_r(split(" ",$str));

        $str = '101 001';
        $cmd = split(" ",$str);
        echo $cmd[0]."\n";
    }

    public function test_array0()
    {
        $arr = array();
        $arr['a'] = 1;
        print_r($arr);
    }

    public function test_array1()
    {
        $arr0 = array();
        $arr0[0] = 1;
        $arr0[1] = 2;
        $arr0[2] = 3;

        $arr1 = array();
        $arr1['arr'] = $arr0;
        $s = json_encode($arr1);
        $ds = json_decode($s,true);
        print_r($ds);
    }
    public function test_parse_str()
    {
        $s = '
### 无情寒冬 初
# 职业：萨满祭司
# 模式：标准模式
# 猛犸年
#
# 2x (1) 冰川裂片
# 1x (2) 低温静滞
# 2x (2) 冷冻鱼人
# 1x (2) 衰变
# 2x (3) 妖术
# 1x (3) 法力之潮图腾
# 2x (3) 海德尼尔冰霜骑士
# 1x (3) 温泉守卫
# 2x (3) 破冰斧
# 2x (3) 达卡莱防御者
# 2x (3) 闪电风暴
# 1x (4) 锦鱼人水语者
# 2x (4) 雪崩
# 2x (5) 巫毒妖术师
# 1x (5) 火山喷发
# 1x (6) 冰冻粉碎者
# 2x (6) 冰霜元素
# 2x (6) 火元素
# 1x (6) 莫拉比
# 
AAECAaoICIEE3boC9r0Cx8ECpcICh8QCtM0CwNACC70BgAT1BP4Fl8ECts0C+80C/s0Cis4CuM4CweICAA==
# 
# 想要使用这副套牌，请先复制到剪贴板，然后在游戏中点击“新套牌”进行粘贴。
        ';

        $comment = '想要使用这副套牌，请先复制到剪贴板，然后在游戏中点击“新套牌”进行粘贴。';
        //echo strlen($comment)."\n"; #108
        $hash = 'AAECAaoICIEE3boC9r0Cx8ECpcICh8QCtM0CwNACC70BgAT1BP4Fl8ECts0C+80C/s0Cis4CuM4CweICAA==';
        //echo strlen($hash)."\n"; #84

        $arr = explode('#',$s,5); 
        $name = $arr[3];
        $left = $arr[4];
        

        $decks = array();
        $arrleft =  explode('#',$left);
        $arrleftcnt = count($arrleft);
        for ($i=4; $i<$arrleftcnt; $i++){
            if (strlen($arrleft[$i])<80 && strlen($arrleft[$i])>2)
                array_push($decks,$arrleft[$i]);
            else if (strlen($arrleft[$i])>80 &&strlen($arrleft[$i])<118)
                $hash = $arrleft[$i];
        }


        echo 'name='.$name."\n";
        $decklen = count($decks);
        for ($i=0; $i<$decklen; $i++)
            echo $decks[$i]."\n";
        echo "hash=$hash\n";
            
    }

    public function test_extract_fromdeck()
    {
        $s1 = ' 2x (3) 闪电风暴';
        $s2 = ' 2x (10) 闪电风暴';

        $delimarr = array(' ','x','(',')');
        $ready = str_replace($delimarr,$delimarr[0],$s1); 
        echo $ready."\n";
        $arr = explode($delimarr[0],$ready);
        for ($i=0; $i<count($arr);$i++)
            echo strlen($arr[$i])."\n";
        print_r($arr);
        return;
    }
    
    public function test_key()
    {
        $arr = array('a'=>1,'b'=>2);
        var_dump(key($arr));
    }
}



?>
