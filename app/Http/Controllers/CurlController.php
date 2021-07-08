<?php

namespace App\Http\Controllers;

use App\Models\Subway_Data;
use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Database\QueryException;

class CurlController extends Controller
{

    public function __construct()
    {

    }

    public static function postCurl() {
        $host ='';
        $url = 'http://swopenAPI.seoul.go.kr/api/subway/68647957466d696e383766796b7151/xml/busLineToTransfer/0/5';
        $params = '서울';
        $params = iconv('euc-kr','utf-8',$params);
        $ch = curl_init($host . $url.'/'.$params);

        curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
        $result = curl_exec($ch);
        curl_close($ch);

        return $result;
    }


    public static function getCurl($id, $param) {
        isset($param)?$param:"";
        var_dump($param);
        $host ='';

        $url = 'http://swopenAPI.seoul.go.kr/api/subway/4d435554586d696e3438617042424d/xml/realtimeStationArrival/ALL';
        $params = urlencode($param);

        //$path = $host . $url.'/'.$params;
        $path = $url;
        //var_dump($path);
        //$ch = curl_init($host . $url.'/'.$params);

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $path);
        curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
        $result = curl_exec($ch);

        var_dump($result);

        curl_close($ch);


        $result = json_decode($result);
//var_dump($result);
//        var_dump($result->busList[0]);

        foreach ($result as $k => $v){
            if($k =='status'){
                if($v == '500'){
                    echo '해당하는 데이터가 없습니다.';
                }
            }else if($k == 'busList'){
                for($i=0; $i<5; $i++){
                    echo "<html>";
                    echo "<p>";
                    echo "지하철 호선명 :".$result->busList[$i]->subwayNm.',';
                    echo "출입구 번호 : ".$result->busList[$i]->ectrcNo.',';
                    echo "버스 노선 유형 : ".$result->busList[$i]->rttp.',';
                    echo "버스 번호 : ".$result->busList[$i]->rtnm.',';
                    echo "배차 간격 : ".$result->busList[$i]->allctintn.',';
                    echo "첫차 시간 : ".$result->busList[$i]->fstallctm.',';
                    echo "막차 시간 : ".$result->busList[$i]->lstallctm.',';
                    echo "운행 여부 : ".$result->busList[$i]->runyn;
                    echo "</p>";
                    echo "</html>";
                }
            }
//            echo $k."::".$v;
        }





    }

    public static function basicCurl($id) {
        header("Content-Type:text/html; charset =utf-8");
        $key = "4d435554586d696e3438617042424d";
        $url = "http://swopenAPI.seoul.go.kr/api/subway/".$key."/xml/realtimeStationArrival/ALL";
        $xml = @simplexml_load_file($url) or die("접속실패");
        $data = array();
        $count = 0;
        foreach ($xml -> row as $k => $v){
            foreach ($v as $k2 => $v2){
                $count = $count +1;
                if($k2 == "statnNm"){
                    $statnNm = "지하철 역명";
                    $statnNm_value = $v2;
                    $data['statnNm'] = $statnNm_value;
                    //echo $statnNm .":". $statnNm_value;
                }else if($k2 == "recptnDt"){
                    $recptnDt = "열차도착정보를 생성한 시각";
                    $recptnDt_value = $v2;
                    $data['recptnDt'] = $recptnDt_value;
                    //echo $recptnDt .":". $recptnDt_value;
                }else if($k2 == "trainLineNm"){
                    $trainLineNm = "도착지방면(성수행 - 구로디지털단지방면)";
                    $trainLineNm_value = $v2."초";
                    $data['trainLineNm'] = $trainLineNm_value;
                    //echo $trainLineNm .":". $trainLineNm_value;
                }else if($k2 == "barvlDt"){
                    $barvlDt = "열차도착예정시간(단위: 초)";
                    $barvlDt_value = $v2."초";
                    $data['barvlDt'] = $barvlDt_value;
                    //echo $barvlDt .":". $barvlDt_value;
                }else if($k2 == "arvlMsg2"){
                    $arvlMsg2 = "첫번째도착메세지(전역 진입, 전역 도착 등)";
                    $arvlMsg2_value = $v2;
                    $data['arvlMsg2'] = $arvlMsg2_value;
                    //echo $arvlMsg2 .":". $arvlMsg2_value;
                }else if($k2 == "arvlMsg3"){
                    $arvlMsg3 = "두번째도착메세지(전역 진입, 전역 도착 등)";
                    $arvlMsg3_value = $v2;
                    $data['arvlMsg3'] = $arvlMsg3_value;
                    //echo $arvlMsg3 .":". $arvlMsg3_value;
                }
                    //echo "<br>";
            }

//                    echo "------------------------------------------------------------------------------------------";
                //var_dump($data);
                //var_dump($data['trainLineNm']);
            $subway_data = new Subway_Data();
            $subway_data->trainLineNm = $data['trainLineNm'];
            $subway_data->statnNm = $data['statnNm'][0]->__toString();
            $subway_data->barvlDt = (string)$data['barvlDt'][0];
            $subway_data->recptnDt = (string)$data['recptnDt'][0];
            $subway_data->arvlMsg2 = (string)$data['arvlMsg2'];
            $subway_data->arvlMsg3 = (string)$data['arvlMsg3'];
            $subway_data->save();
        }
        echo $count."행이 DB에 저장 완료 됬습니다.";
    }

    public function corona(){
        header("Content-Type:text/html; charset =utf-8");
        $key = "4d435554586d696e3438617042424d";
        $url = "http://openapi.seoul.go.kr:8088/".$key."/xml/Corona19Status/1/1000/";
        $xml = @simplexml_load_file($url) or die("접속실패");
        var_dump($xml);
        foreach ($xml->row as $k => $v){

        }
    }

    public function xmltest(){

        $request = array();
        $request['Identification']['ID'  ] = 'YIC';
        $request['Identification']['Hash'] = '21BBF51F22F14CCDDD77E8FE25BC91F06B1408BD';
        /*$request = '
            <Root>
                <Identification>
                    <ID><![CDATA[YIC]]></ID>
                    <Hash><![CDATA[21BBF51F22F14CCDDD77E8FE25BC91F06B1408BD]]></Hash>
                </Identification>
            </Root>
        ';*/


        $xml_base = new \SimpleXMLElement( "<?xml version='1.0' encoding='UTF-8'?><Root></Root>",LIBXML_NOCDATA,false );
        $request_body = $this->arrayToXml( $request, $xml_base );

        //var_dump($request_body);

        $request_body = new \SimpleXMLElement($request_body,LIBXML_NOCDATA, false);
        $request_result = array();
        $request_result['param'] = $request_body;
        var_dump($request_result);

        try {
            $path = 'http://devapi.etahome.co.kr/vapi/regGood';
            $ch = curl_init();
            header('Content-Type: application/json; charset=utf-8');
            curl_setopt($ch, CURLOPT_URL, trim($path));
            curl_setopt($ch, CURLOPT_HEADER,			0				        );
            curl_setopt($ch, CURLOPT_HTTPHEADER, Array("Charset=UTF-8"));
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $request_result);
            curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 600);
            curl_setopt($ch, CURLOPT_TIMEOUT, 600);
            $result = curl_exec($ch);
            curl_close($ch);
            //$response = simplexml_load_string($request_body) or die("Error: Cannot create object");
        }catch (Exception $E){
            echo $E;
            return false;
        }
        var_dump($result);
    }

    private function arrayToXml( $array, $xml_user_info, $loopKey = null )
    {

        foreach( $array as $key => $value ){
            if( is_array( $value ) ) {
                if( !is_numeric( $key ) ){
                    $mainKey    = null;
                    $subKey     = null;

                    if( strstr( $key, '#' ) ){
                        $arrKeys = explode( '#', $key );
                        $mainKey    = $arrKeys[0];
                        $subKey     = $arrKeys[1];
                    }
                    else{
                        $mainKey    = $key;
                        $subKey     = null;

                    }

                    if( $mainKey ){
                        $subnode = $xml_user_info->addChild( "$mainKey" );
                    }else{
                        $subnode = $xml_user_info;
                    }

                    $this->arrayToXml( $value, $subnode, $subKey );
                }else{
                    $subnode = $xml_user_info->addChild( "$loopKey" );
                    $this->arrayToXml( $value, $subnode );
                }
            }else {
                $child  = $xml_user_info->addChild( ( $loopKey ? $loopKey : $key ) );
                $node   = dom_import_simplexml( $child );
                $no     = $node->ownerDocument;
                $node->appendChild( $no->createCDATASection( $value ) );
            }
        }


        $reqest = $xml_user_info->asXML();

        return $reqest;
    }

}
?>