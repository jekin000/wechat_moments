<?php
require_once('heartstone.php');
require_once('fakedatastore.php');

assert_options(ASSERT_ACTIVE, 1);
assert_options(ASSERT_WARNING, 0);
assert_options(ASSERT_QUIET_EVAL, 1);

function my_assert_handler($file, $line, $code, $desc = null)
{
    echo "Assertion failed at $file:$line: $code";
    if ($desc) {
        echo ": $desc";
    }
    echo "\n";
}
assert_options(ASSERT_CALLBACK, 'my_assert_handler');
$tt = new test();
//test_split();
//test_heartstone_create();
//$tt->testObj();
//$tt->test_array1();
//$tt->test_parse_str();
//$tt->test_extract_fromdeck();
//$tt->test_key();
$tt->run_all_test();

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
    private $deck1;
    private $jsondeck1;
    private $deck2;
    private $jsondeck2;
    private $deck3;
    private $jsondeck3;

    public function __construct()
    {
        $this->deck1 = '### 无情寒冬 初
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

        $this->jsondeck1 = '
{"name":"\u65e0\u60c5\u5bd2\u51ac \u521d","role":"\u8428\u6ee1\u796d\u53f8\n        ","matchcnt":{"viccnt":0,"defcnt":0},"cardgrps":[{"id":0,"name":"\u4f4e\u6e29\u9759\u6ede","cost":"2","count":"1","oricount":"1","prob":0.033333333333333,"appear":0,"appearsum":0,"istmp":false},{"id":1,"name":"\u51b7\u51bb\u9c7c\u4eba","cost":"2","count":"2","oricount":"2","prob":0.066666666666667,"appear":0,"appearsum":0,"istmp":false},{"id":2,"name":"\u8870\u53d8","cost":"2","count":"1","oricount":"1","prob":0.033333333333333,"appear":0,"appearsum":0,"istmp":false},{"id":3,"name":"\u5996\u672f","cost":"3","count":"2","oricount":"2","prob":0.066666666666667,"appear":0,"appearsum":0,"istmp":false},{"id":4,"name":"\u6cd5\u529b\u4e4b\u6f6e\u56fe\u817e","cost":"3","count":"1","oricount":"1","prob":0.033333333333333,"appear":0,"appearsum":0,"istmp":false},{"id":5,"name":"\u6d77\u5fb7\u5c3c\u5c14\u51b0\u971c\u9a91\u58eb","cost":"3","count":"2","oricount":"2","prob":0.066666666666667,"appear":0,"appearsum":0,"istmp":false},{"id":6,"name":"\u6e29\u6cc9\u5b88\u536b","cost":"3","count":"1","oricount":"1","prob":0.033333333333333,"appear":0,"appearsum":0,"istmp":false},{"id":7,"name":"\u7834\u51b0\u65a7","cost":"3","count":"2","oricount":"2","prob":0.066666666666667,"appear":0,"appearsum":0,"istmp":false},{"id":8,"name":"\u8fbe\u5361\u83b1\u9632\u5fa1\u8005","cost":"3","count":"2","oricount":"2","prob":0.066666666666667,"appear":0,"appearsum":0,"istmp":false},{"id":9,"name":"\u95ea\u7535\u98ce\u66b4","cost":"3","count":"2","oricount":"2","prob":0.066666666666667,"appear":0,"appearsum":0,"istmp":false},{"id":10,"name":"\u9526\u9c7c\u4eba\u6c34\u8bed\u8005","cost":"4","count":"1","oricount":"1","prob":0.033333333333333,"appear":0,"appearsum":0,"istmp":false},{"id":11,"name":"\u96ea\u5d29","cost":"4","count":"2","oricount":"2","prob":0.066666666666667,"appear":0,"appearsum":0,"istmp":false},{"id":12,"name":"\u5deb\u6bd2\u5996\u672f\u5e08","cost":"5","count":"2","oricount":"2","prob":0.066666666666667,"appear":0,"appearsum":0,"istmp":false},{"id":13,"name":"\u706b\u5c71\u55b7\u53d1","cost":"5","count":"1","oricount":"1","prob":0.033333333333333,"appear":0,"appearsum":0,"istmp":false},{"id":14,"name":"\u51b0\u51bb\u7c89\u788e\u8005","cost":"6","count":"1","oricount":"1","prob":0.033333333333333,"appear":0,"appearsum":0,"istmp":false},{"id":15,"name":"\u51b0\u971c\u5143\u7d20","cost":"6","count":"2","oricount":"2","prob":0.066666666666667,"appear":0,"appearsum":0,"istmp":false},{"id":16,"name":"\u706b\u5143\u7d20","cost":"6","count":"2","oricount":"2","prob":0.066666666666667,"appear":0,"appearsum":0,"istmp":false},{"id":17,"name":"\u83ab\u62c9\u6bd4","cost":"6","count":"1","oricount":"1","prob":0.033333333333333,"appear":0,"appearsum":0,"istmp":false}],"hash":" \n        AAECAaoICIEE3boC9r0Cx8ECpcICh8QCtM0CwNACC70BgAT1BP4Fl8ECts0C+80C\/s0Cis4CuM4CweICAA==\n        ","isfavor":false}';
        $this->deck2 = '
                ### 冰火融合
                # 职业：法师
                # 模式：标准模式
                # 猛犸年
                #
                # 2x (1) 冰川裂片
                # 1x (1) 法力浮龙
                # 2x (1) 火羽精灵
                # 2x (2) 寒冰箭
                # 1x (2) 寒冰行者
                # 1x (2) 活体风暴
                # 2x (3) 冰冷鬼魂
                # 1x (3) 冰霜新星
                # 2x (3) 奥术智慧
                # 1x (4) 冰锥术
                # 2x (4) 变形术
                # 2x (4) 水元素
                # 2x (4) 蒸汽涌动者
                # 2x (5) 凛风巫师
                # 2x (5) 卡利莫斯的仆从
                # 1x (6) 暴风雪
                # 1x (7) 火焰之地传送门
                # 2x (7) 火焰使者
                # 1x (7) 烈焰风暴
                #
                AAECAf0ECJUDrgPJA8sE7AejtgLHxwLczQILTYsDqwSWBZzAApfBAsLBAuvCAsLDAsjHAtTOAgA=
                #
                # 想要使用这副套牌，请先复制到剪贴板，然后在游戏中点击“新套牌”进行粘贴。
        ';
        $this->jsondeck2 = '
{"name":"\u51b0\u706b\u878d\u5408","role":"\u6cd5\u5e08\n                ","matchcnt":{"viccnt":0,"defcnt":0},"cardgrps":[{"id":0,"name":"\u6cd5\u529b\u6d6e\u9f99","cost":"1","count":"1","oricount":"1","prob":0.033333333333333,"appear":0,"appearsum":0,"istmp":false},{"id":1,"name":"\u706b\u7fbd\u7cbe\u7075","cost":"1","count":"2","oricount":"2","prob":0.066666666666667,"appear":0,"appearsum":0,"istmp":false},{"id":2,"name":"\u5bd2\u51b0\u7bad","cost":"2","count":"2","oricount":"2","prob":0.066666666666667,"appear":0,"appearsum":0,"istmp":false},{"id":3,"name":"\u5bd2\u51b0\u884c\u8005","cost":"2","count":"1","oricount":"1","prob":0.033333333333333,"appear":0,"appearsum":0,"istmp":false},{"id":4,"name":"\u6d3b\u4f53\u98ce\u66b4","cost":"2","count":"1","oricount":"1","prob":0.033333333333333,"appear":0,"appearsum":0,"istmp":false},{"id":5,"name":"\u51b0\u51b7\u9b3c\u9b42","cost":"3","count":"2","oricount":"2","prob":0.066666666666667,"appear":0,"appearsum":0,"istmp":false},{"id":6,"name":"\u51b0\u971c\u65b0\u661f","cost":"3","count":"1","oricount":"1","prob":0.033333333333333,"appear":0,"appearsum":0,"istmp":false},{"id":7,"name":"\u5965\u672f\u667a\u6167","cost":"3","count":"2","oricount":"2","prob":0.066666666666667,"appear":0,"appearsum":0,"istmp":false},{"id":8,"name":"\u51b0\u9525\u672f","cost":"4","count":"1","oricount":"1","prob":0.033333333333333,"appear":0,"appearsum":0,"istmp":false},{"id":9,"name":"\u53d8\u5f62\u672f","cost":"4","count":"2","oricount":"2","prob":0.066666666666667,"appear":0,"appearsum":0,"istmp":false},{"id":10,"name":"\u6c34\u5143\u7d20","cost":"4","count":"2","oricount":"2","prob":0.066666666666667,"appear":0,"appearsum":0,"istmp":false},{"id":11,"name":"\u84b8\u6c7d\u6d8c\u52a8\u8005","cost":"4","count":"2","oricount":"2","prob":0.066666666666667,"appear":0,"appearsum":0,"istmp":false},{"id":12,"name":"\u51db\u98ce\u5deb\u5e08","cost":"5","count":"2","oricount":"2","prob":0.066666666666667,"appear":0,"appearsum":0,"istmp":false},{"id":13,"name":"\u5361\u5229\u83ab\u65af\u7684\u4ec6\u4ece","cost":"5","count":"2","oricount":"2","prob":0.066666666666667,"appear":0,"appearsum":0,"istmp":false},{"id":14,"name":"\u66b4\u98ce\u96ea","cost":"6","count":"1","oricount":"1","prob":0.033333333333333,"appear":0,"appearsum":0,"istmp":false},{"id":15,"name":"\u706b\u7130\u4e4b\u5730\u4f20\u9001\u95e8","cost":"7","count":"1","oricount":"1","prob":0.033333333333333,"appear":0,"appearsum":0,"istmp":false},{"id":16,"name":"\u706b\u7130\u4f7f\u8005","cost":"7","count":"2","oricount":"2","prob":0.066666666666667,"appear":0,"appearsum":0,"istmp":false},{"id":17,"name":"\u70c8\u7130\u98ce\u66b4","cost":"7","count":"1","oricount":"1","prob":0.033333333333333,"appear":0,"appearsum":0,"istmp":false},{"id":19,"name":"","cost":"","count":"","oricount":"","prob":0,"appear":0,"appearsum":0,"istmp":false}],"hash":null,"isfavor":false}
        ';
        $this->deck3 = '
                ### 贼之奇迹
                # 职业：潜行者
                # 模式：标准模式
                # 猛犸年
                #
                # 2x (0) 伪造的幸运币
                # 2x (0) 伺机待发
                # 2x (0) 背刺
                # 2x (1) 冷血
                # 2x (1) 南海船工
                # 1x (1) 海盗帕奇斯
                # 2x (2) 刺骨
                # 2x (2) 毒刃
                # 1x (2) 狗头人地卜师
                # 2x (2) 闷棍
                # 1x (2) 食人草
                # 1x (3) 任务达人
                # 2x (3) 军情七处特工
                # 2x (3) 刀扇
                # 1x (3) 浸毒武器
                # 1x (4) 毒心者夏克里尔
                # 1x (5) 无面操纵者
                # 1x (5) 穴居人强盗
                # 2x (6) 加基森拍卖师
                #
                AAECAaIHCJMEoAWXBoOsApG8Avq/AoDCAurGAgu0AYwCzQO9BJsF1AWIB6QH3QiGCfW7AgA=
                #
                # 想要使用这副套牌，请先复制到剪贴板，然后在游戏中点击“新套牌”进行粘贴。
        ';
        $this->jsondeck3 = '
{"name":"\u8d3c\u4e4b\u5947\u8ff9","role":"\u6f5c\u884c\u8005\n                ","matchcnt":{"viccnt":0,"defcnt":0},"cardgrps":[{"id":0,"name":"\u4f3a\u673a\u5f85\u53d1","cost":"0","count":"2","oricount":"2","prob":0.066666666666667,"appear":0,"appearsum":0,"istmp":false},{"id":1,"name":"\u80cc\u523a","cost":"0","count":"2","oricount":"2","prob":0.066666666666667,"appear":0,"appearsum":0,"istmp":false},{"id":2,"name":"\u51b7\u8840","cost":"1","count":"2","oricount":"2","prob":0.066666666666667,"appear":0,"appearsum":0,"istmp":false},{"id":3,"name":"\u5357\u6d77\u8239\u5de5","cost":"1","count":"2","oricount":"2","prob":0.066666666666667,"appear":0,"appearsum":0,"istmp":false},{"id":4,"name":"\u6d77\u76d7\u5e15\u5947\u65af","cost":"1","count":"1","oricount":"1","prob":0.033333333333333,"appear":0,"appearsum":0,"istmp":false},{"id":5,"name":"\u523a\u9aa8","cost":"2","count":"2","oricount":"2","prob":0.066666666666667,"appear":0,"appearsum":0,"istmp":false},{"id":6,"name":"\u6bd2\u5203","cost":"2","count":"2","oricount":"2","prob":0.066666666666667,"appear":0,"appearsum":0,"istmp":false},{"id":7,"name":"\u72d7\u5934\u4eba\u5730\u535c\u5e08","cost":"2","count":"1","oricount":"1","prob":0.033333333333333,"appear":0,"appearsum":0,"istmp":false},{"id":8,"name":"\u95f7\u68cd","cost":"2","count":"2","oricount":"2","prob":0.066666666666667,"appear":0,"appearsum":0,"istmp":false},{"id":9,"name":"\u98df\u4eba\u8349","cost":"2","count":"1","oricount":"1","prob":0.033333333333333,"appear":0,"appearsum":0,"istmp":false},{"id":10,"name":"\u4efb\u52a1\u8fbe\u4eba","cost":"3","count":"1","oricount":"1","prob":0.033333333333333,"appear":0,"appearsum":0,"istmp":false},{"id":11,"name":"\u519b\u60c5\u4e03\u5904\u7279\u5de5","cost":"3","count":"2","oricount":"2","prob":0.066666666666667,"appear":0,"appearsum":0,"istmp":false},{"id":12,"name":"\u5200\u6247","cost":"3","count":"2","oricount":"2","prob":0.066666666666667,"appear":0,"appearsum":0,"istmp":false},{"id":13,"name":"\u6d78\u6bd2\u6b66\u5668","cost":"3","count":"1","oricount":"1","prob":0.033333333333333,"appear":0,"appearsum":0,"istmp":false},{"id":14,"name":"\u6bd2\u5fc3\u8005\u590f\u514b\u91cc\u5c14","cost":"4","count":"1","oricount":"1","prob":0.033333333333333,"appear":0,"appearsum":0,"istmp":false},{"id":15,"name":"\u65e0\u9762\u64cd\u7eb5\u8005","cost":"5","count":"1","oricount":"1","prob":0.033333333333333,"appear":0,"appearsum":0,"istmp":false},{"id":16,"name":"\u7a74\u5c45\u4eba\u5f3a\u76d7","cost":"5","count":"1","oricount":"1","prob":0.033333333333333,"appear":0,"appearsum":0,"istmp":false},{"id":17,"name":"\u52a0\u57fa\u68ee\u62cd\u5356\u5e08","cost":"6","count":"2","oricount":"2","prob":0.066666666666667,"appear":0,"appearsum":0,"istmp":false}],"hash":"\n                AAECAaIHCJMEoAWXBoOsApG8Avq\/AoDCAurGAgu0AYwCzQO9BJsF1AWIB6QH3QiGCfW7AgA=\n                ","isfavor":false}
        ';
    }

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

        $arr = explode('#',$s,6); 
        $name = $arr[3];
        $role = $arr[4];
        $rolearr = explode('：',$role);
        $role = $rolearr[1];
        $left = $arr[5];
        

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
        echo 'role='.$role."\n";
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

    public function test_set_get_DB_queryret()
    {
        $db = new  DataStore();
        $hs = new  HeartStone();

        $query = array(
                'A#@#XYZ' => '{123}'
                ,'B#@#XYZ' => '{456}'
                ,'C#@#LMN' => '{789}'
            );

        $db->tstSetQueryKeys($query);
        $hs->tstSetDbh($db);
        
        $ret = $hs->tstGetDbh()->getallkeys('no use'); 
        assert('count($ret) == 3','the real count is:'.count($ret));
        
        $hs->dbgDelAnyDeck('no use','8 2');
        $ret = $db->tstGetDelKeys();
        assert('count($ret) == 0','the real count is:'.count($ret));

        $hs->dbgDelAnyDeck('no use','0 1');
        $ret = $db->tstGetDelKeys();
        assert('count($ret) == 2','the real count is:'.count($ret));

        $hs->dbgDelAnyDeck('no use','1');
        $ret = $db->tstGetDelKeys();
        assert('count($ret) == 1','the real count is:'.count($ret));
        $val = current($ret);
        assert('$val == \'B#@#XYZ\'','the real val is:'.$val);

        $hs->dbgDelAnyDeck('no use','2 2 0 0');
        $ret = $db->tstGetDelKeys();
        assert('count($ret) == 2','the real count is:'.count($ret));
        $val = current($ret);
        assert('$val == \'A#@#XYZ\'','the real val is:'.$val);
        next($ret);
        $val = current($ret);
        assert('$val == \'C#@#LMN\'','the real val is:'.$val);
        return;

    }

    public function test_get_userdeck()
    {
        $db = new  DataStore();
        $hs = new  HeartStone();

        $query = array(
            );
        $db->tstSetQueryKeys($query);
        $hs->tstSetDbh($db);
        $ret = $hs->tstGetDbh()->getallkeys('A'); 
        assert('count($ret) == 0','the real count is:'.count($ret));

        $query = array(
                'A#@#XYZ' => '{123}'
                ,'A#@#ABC' => '{456}'
            );
        $db->tstSetQueryKeys($query);
        $ret = $hs->tstGetDbh()->getallkeys('A'); 
        assert('count($ret) == 2','the real count is:'.count($ret));

        $decks = $hs->listdeck('A'); 
        assert('count($decks) == 2','the real count is:'.count($decks));
        assert('$decks[0] == \'XYZ\'','the real name is:'.$decks[0]);
        assert('$decks[1] == \'ABC\'','the real name is:'.$decks[1]);

        return;

    }
    public function test_get_userdeck_withfavor()
    {
        $db = new  DataStore();
        $hs = new  HeartStone();
        $hs->tstSetDbh($db);

        $query = array(
            );
        $db->tstSetQueryKeys($query);
        $retval = $hs->setFavorDeck('no use','0');
        assert('$retval == false','the real retval is:'.$retval);

        $query = array(
                'A#@#XYZ' => $this->jsondeck1
                ,'A#@#LMN' => $this->jsondeck2
                ,'A#@#ABC' => $this->jsondeck3
            );
        $db->tstSetQueryKeys($query);

        $retval = $hs->setFavorDeck('no use','1 2 3');
        assert('$retval == false','the real retval is:'.$retval);

        $retval = $hs->setFavorDeck('no use','-1');
        assert('$retval == false','the real retval is:'.$retval);

        $retval = $hs->setFavorDeck('no use','999');
        assert('$retval == false','the real retval is:'.$retval);

        $decks = $hs->listdeck('A'); 
        assert('count($decks) == 3','the real count is:'.count($decks));
        assert('$decks[0] == \'XYZ\'','the real name is:'.$decks[0]);
        assert('$decks[1] == \'LMN\'','the real name is:'.$decks[1]);
        assert('$decks[2] == \'ABC\'','the real name is:'.$decks[2]);

        $hs->setFavorDeck('A','1');
        $dbSetRes = $db->tstGetSetData();
        assert('count($dbSetRes) == 1','the real count is:'.count($dbSetRes));
        $deck = json_decode($dbSetRes[0],true);
        $isFavor = $deck['isfavor'];
        assert('$isFavor == true','the real favor is:'.$isFavor);
        $name = $deck['name'];
        assert('$name == 冰火融合','the real name is:'.$name);
        $query = array(
                'A#@#XYZ' => $this->jsondeck1
                ,'A#@#LMN' => json_encode($deck)
                ,'A#@#ABC' => $this->jsondeck3
            );
        $db->tstSetQueryKeys($query);
        $decks = $hs->listdeck('A'); 
        assert('count($decks) == 3','the real count is:'.count($decks));
        assert('$decks[0] == \'XYZ\'','the real name is:'.$decks[0]);
        assert('$decks[1] == \'LMN *\'','the real name is:'.$decks[1]);
        assert('$decks[2] == \'ABC\'','the real name is:'.$decks[2]);

        $db->tstClearSetval();
        $query = array(
                'A#@#XYZ' => $this->jsondeck1
                ,'A#@#LMN' => json_encode($deck)
                ,'A#@#ABC' => $this->jsondeck3
            );
        $db->tstSetQueryKeys($query);
        $hs->setFavorDeck('A','2');
        $dbSetRes = $db->tstGetSetData();
        assert('count($dbSetRes) == 2','the real count is:'.count($dbSetRes));
        $deck = json_decode($dbSetRes[0],true);
        $isFavor = $deck['isfavor'];
        assert('$isFavor == false','the real favor is:'.$isFavor);
        $name = $deck['name'];
        assert('$name == 冰火融合','the real name is:'.$name);

        $deck = json_decode($dbSetRes[1],true);
        $isFavor = $deck['isfavor'];
        assert('$isFavor == true','the real favor is:'.$isFavor);
        $name = $deck['name'];
        assert('$name == 贼之奇迹','the real name is:'.$name);

        $query = array(
                'A#@#XYZ' => $this->jsondeck1
                ,'A#@#LMN' => $this->jsondeck2
                ,'A#@#ABC' => json_encode($deck)
            );
        $db->tstSetQueryKeys($query);
        $decks = $hs->listdeck('A'); 
        assert('count($decks) == 3','the real count is:'.count($decks));
        assert('$decks[0] == \'XYZ\'','the real name is:'.$decks[0]);
        assert('$decks[1] == \'LMN\'','the real name is:'.$decks[1]);
        assert('$decks[2] == \'ABC *\'','the real name is:'.$decks[2]);

        return;

    }
    public function test_set_favor_result()
    {
        $db = new  DataStore();
        $hs = new  HeartStone();
        $hs->tstSetDbh($db);

        /* no deck */
        $query = array(
            );
        $db->tstSetQueryKeys($query);
        $retval = $hs->setFavorResult('A','0');
        assert('$retval == false','the real retval is:'.$retval);

        /* no favor*/
        $query = array(
                'A#@#XYZ' => $this->jsondeck1
                ,'A#@#LMN' => $this->jsondeck2
                ,'A#@#ABC' => $this->jsondeck3
            );
        $db->tstSetQueryKeys($query);
        $retval = $hs->setFavorResult('A','0');
        assert('$retval == false','the real retval is:'.$retval);

        /* set favor win */
        $query = array(
                'A#@#XYZ' => $this->jsondeck1
                ,'A#@#LMN' => $this->jsondeck2
                ,'A#@#ABC' => $this->jsondeck3
            );
        $db->tstSetQueryKeys($query);
        $hs->setFavorDeck('A','1');
        $dbSetRes = $db->tstGetSetData();
        $deck = json_decode($dbSetRes[0],true);
        $query = array(
                'A#@#XYZ' => $this->jsondeck1
                ,'A#@#LMN' => json_encode($deck)
                ,'A#@#ABC' => $this->jsondeck3
            );
        $db->tstSetQueryKeys($query);
        $win = $deck['matchcnt']['viccnt'];
        $lose= $deck['matchcnt']['defcnt'];
        assert('$win == 0','the real win is:'.$win);
        assert('$lose == 0','the real lose is:'.$lose);
        $db->tstClearSetval();
        $hs->setFavorResult('A','1');
        $dbSetRes = $db->tstGetSetData();
        $deck = json_decode($dbSetRes[0],true);
        $win = $deck['matchcnt']['viccnt'];
        $lose= $deck['matchcnt']['defcnt'];
        assert('$win == 1','the real win is:'.$win);
        assert('$lose == 0','the real lose is:'.$lose);


        /* set favor lose */
        $query = array(
                'A#@#XYZ' => $this->jsondeck1
                ,'A#@#LMN' => json_encode($deck)
                ,'A#@#ABC' => $this->jsondeck3
            );
        $db->tstSetQueryKeys($query);
        $db->tstClearSetval();
        $hs->setFavorResult('A','0');
        $dbSetRes = $db->tstGetSetData();
        $deck = json_decode($dbSetRes[0],true);
        $win = $deck['matchcnt']['viccnt'];
        $lose= $deck['matchcnt']['defcnt'];
        assert('$win == 1','the real win is:'.$win);
        assert('$lose == 1','the real lose is:'.$lose);

    }
    public function run_all_test()
    {
        //$this->test_parse_str();
        $this->test_set_get_DB_queryret();
        $this->test_get_userdeck();
        $this->test_get_userdeck_withfavor();
        $this->test_set_favor_result();
    }
}



?>
