<?php
/**
  * wechat php test
  */

//define your token
define("TOKEN", "teahouse_liu");
$wechatObj = new wechatCallbackapiTest();
//$wechatObj->valid();
$wechatObj->responseMsg();

class wechatCallbackapiTest
{
	public function valid()
    {
        $echoStr = $_GET["echostr"];

        //valid signature , option
        if($this->checkSignature()){
        	echo $echoStr;
        	exit;
        }
    }

    public function responseMsg()
    {
		//get post data, May be due to the different environments
		$postStr = $GLOBALS["HTTP_RAW_POST_DATA"];

      	//extract post data
		if (!empty($postStr)){
                /* libxml_disable_entity_loader is to prevent XML eXternal Entity Injection,
                   the best way is to check the validity of xml by yourself */
                libxml_disable_entity_loader(true);
                $postObj = simplexml_load_string($postStr, 'SimpleXMLElement', LIBXML_NOCDATA);
                
                $RX_TYPE = trim($postObj->MsgType);
                switch ($RX_TYPE){
                    case "text":
                        $resultStr = $this->handleText($postObj);
                        break;
                    case "event":
                        $resultStr = $this->handleEvent($postObj);
                        break;   
                    default:
                        $resultStr = "Unknow msg type:".$RX_TYPE;
                        break; 
                }
                echo $resultStr;


        }else {
        	echo "";
        	exit;
        }
    }
    private function get_support_function()
    {
            return  "目前平台功能如下:"."\n"
                    ."【1】查天气,如输入:南京天气"
                    ;
    }
    private function get_welcome()
    {
            return "感谢您关注【老刘的小茶馆】"."\n"
                    ."微信号:teahouse_liu"."\n"
                    ."我们会为您提供一些便捷的生活指南!"."\n"
                    .$this->get_support_function()."\n"
                    ."更多内容,敬请期待..."."\n"
                    ;
    }
    public function handleEvent($object)
    {
            $contentStr = "";
            switch ($object->Event)
            {
                    case "subscribe":
                            $contentStr = $this->get_welcome();
                            break;
                    default:
                            $contentStr = "Unknow Event:".$object->Event;
                            break;
            }
            $resultStr = $this->responseText($object,$contentStr);
            return $resultStr;
    }
    public function responseText($object,$content,$flag=0)
    {
        $textTpl = "<xml>
                    <ToUserName><![CDATA[%s]]></ToUserName>
                    <FromUserName><![CDATA[%s]]></FromUserName>
                    <CreateTime>%s</CreateTime>
                    <MsgType><![CDATA[%s]]></MsgType>
                    <Content><![CDATA[%s]]></Content>
                    <FuncFlag>%d</FuncFlag>
                    </xml>";             
        $resultStr = sprintf($textTpl,$object->FromUserName,$object->ToUserName,time(),"text",$content,$flag);
        return $resultStr;
    }
    public function handleText($postObj)
    {
        $fromUsername = $postObj->FromUserName;
        $toUsername = $postObj->ToUserName;
        $keyword = trim($postObj->Content);
        $time = time();
        $textTpl = "<xml>
                    <ToUserName><![CDATA[%s]]></ToUserName>
                    <FromUserName><![CDATA[%s]]></FromUserName>
                    <CreateTime>%s</CreateTime>
                    <MsgType><![CDATA[%s]]></MsgType>
                    <Content><![CDATA[%s]]></Content>
                    <FuncFlag>0</FuncFlag>
                    </xml>";             
        if(!empty( $keyword ))
        {
            $contentStr = $this->parse_keyword($keyword);     
            if (empty($contentStr)){
                $contentStr = "Nothing to show...wait my developing.";
            }
            $msgType = "text";
            $resultStr = sprintf($textTpl, $fromUsername, $toUsername, $time, $msgType, $contentStr);
            echo $resultStr;
        }else{
            echo "Input something...";
        }
    }
    private function parse_keyword($key)
    {
            if ($key == '1')
            {
                    return $this->do_weather("南京");
            }

            $type = "天气";
            $type_size = mb_strlen("天气","UTF-8");
            $input_type = mb_substr($key,0-$type_size,$type_size,"UTF-8");
            if ($input_type == $type)
            {
                    $key_size = mb_strlen($key,"UTF-8");
                    $left_size= $key_size - $type_size;
                    $cityname = mb_substr($key,0,$left_size,"UTF-8");
                    return $this->do_weather($cityname);
            }
            return $this->default_text($key);
    }
    private function default_text($key)
    {
            return '抱歉，暂时不支持您的输入:'."\n".$key."\n"
                   .$this->get_support_function()."\n"
                    ;
    }

    private function do_weather($cityname_chn)
    {
            $cityname = urlencode($cityname_chn);
            $citycode = $this->do_baidu_api_weather_get_citynum_by_urlencode_name($cityname);
            if (empty($citycode)){
                    return "查询失败！无法获取城市编码";
            }
            return $this->do_baidu_api_weather_get_recentweather($cityname,$citycode);
    }
    private function get_day_weather($day)
    {
            return "$day->type $day->lowtemp~$day->hightemp $day->fengxiang $day->fengli";
    }
    private function get_weather_coat($note_list)
    {
            foreach ( $note_list as $note){
                    if ($note->code == "ct"){
                            return "温馨提示:".$note->details;
                    }
            }
            return "";
    }
    private function get_weather_pm25($pm25)
    {
            if (!empty($pm25)){
                    return "PM2.5=$pm25";
            }

            return "";
    }
    private function do_baidu_api_weather_get_recentweather($name,$code)
    {
            $data = $this->do_baidu_api_weather_func('recentweathers','cityid',$code);
            if ($data->errNum != 0){
                    return $data->retMsg;
            }
            $cityinfo = $data->retData;
            $cityname = $cityinfo->city;
            $today = $cityinfo->today;
            $today_coat = $this->get_weather_coat($today->index); 
            /* 7 days 0~6 */
            $history = $cityinfo->history;
            $yes_idx = sizeof($history) - 1;
            $yestoday = $history[$yes_idx];

            /* 4 days 0~3 */
            $forecast = $cityinfo->forecast;
            $tomorrow = $forecast[0];
            $next_tom = $forecast[1];

            return "【"."$cityname"."天气预报】"."\n"
                    ."$today->date,$today->week\n"
                    ."\n"
                    ."实时天气"."\n"
                    .$this->get_day_weather($today)."\n"
                    .$this->get_weather_pm25($today->aqi)."\n"
                    ."\n"
                    .$today_coat."\n"
                    ."\n"
                    ."昨天\n"
                    .$this->get_day_weather($yestoday)."\n"
                    ."\n"
                    ."明天"."\n"
                    .$this->get_day_weather($tomorrow)."\n"
                    ."\n"
                    ."后天"."\n"
                    .$this->get_day_weather($next_tom)."\n"
                    ;
    }
    private function do_baidu_api_weather_get_citynum_by_urlencode_name($cityname)
    {
            $data = $this->do_baidu_api_weather_func('cityname','cityname',$cityname);
            if ($data->errNum != 0){
                    return $data->retMsg;
            }
            $cityinfo = $data->retData;
            return $cityinfo->citycode;  
    }

    private function do_baidu_api_weather_by_phonetic($n)
    {
            $cityname = $n;
            $data = $this->do_baidu_api_weather_func('weather','citypinyin',$cityname);
            if ($data->errNum != 0){
                    return $data->errMsg;
            }
            $weatherinfo = $data->retData;
            return "$weatherinfo->city"."市\n".$weatherinfo->weather.':'.$weatherinfo->l_tmp.'~'.$weatherinfo->h_tmp;
    }
    private function do_baidu_api_weather_func($api,$parm,$value,$parm1=NULL,$value1=NULL)
    {
            $apikey = '9524055140fc772df09ab57aa43088cb';
            $url = 'http://apis.baidu.com/apistore/weatherservice/'.$api.'?'.$parm.'='.$value; 
            if (!empty($parm1)){
                $url = $url."&$parm1=$value1"; 
            }
           
            $ch = curl_init();
            $header = array('apikey: '.$apikey);
            // 添加apikey到header
            curl_setopt($ch, CURLOPT_HTTPHEADER  , $header);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            // 执行HTTP请求
            curl_setopt($ch , CURLOPT_URL , $url);
            $res = curl_exec($ch);
            return json_decode($res);
    }

    private function checkSignature()
	{
        // you must define TOKEN by yourself
        if (!defined("TOKEN")) {
            throw new Exception('TOKEN is not defined!');
        }
        
        $signature = $_GET["signature"];
        $timestamp = $_GET["timestamp"];
        $nonce = $_GET["nonce"];
        		
		$token = TOKEN;
		$tmpArr = array($token, $timestamp, $nonce);
        // use SORT_STRING rule
		sort($tmpArr, SORT_STRING);
		$tmpStr = implode( $tmpArr );
		$tmpStr = sha1( $tmpStr );
		
		if( $tmpStr == $signature ){
			return true;
		}else{
			return false;
		}
	}
}

?>
