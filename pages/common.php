<?php
    header("Content-type: text/html; charset=utf-8");
    include('package/convert.php');
    $function = $_REQUEST["functionname"];
    switch ($function)
    {
        case 'getCategory':
          getCategory();
        break;
        case 'getListFilter':
          getListFilter();
        break; 
        case 'getListDefault':
          getListDefault();
        break;  
        case 'getDetail':
          getDetail();
        break;
        case 'getVipLogin':
          getVipLogin();
        break;
        case 'getMyBid':
          getMyBid();
        break;
        case 'register':
        break;
    }

    function getToken()
    {  
      $key = 'srsebidweixintokencache';
      $redis = new Redis();  
      $redis->connect('10.138.1.17', 8084);  
      $redis->auth('Foxconn88');  
      $token = $redis->get($key);
      if ($token=='') {
          $url = 'http://10.138.1.17/EbidServices/checkLogin?userName=ebid&password=3333302eac36ff5158dc5d3ff2db2447';
          $json_data =json_decode(getJson($url));
          if ($json_data->errorFlag=='E0000') {
            $redis->set($key,$json_data->token);
            $redis->expire($key ,3600);
          }
          return $json_data->token;
      }
      else{
        return $token;
      }
    }

    function getCategory()
    {
      $token = getToken();
      $url = "http://10.138.1.17/EbidServices/getCategoryList?token=".$token;
      echo json_encode(getJson($url));
    }

    function getListDefault()
    {
        $token = getToken();
        $date = date('Y-m-d');
        $url = "http://10.138.1.17/EbidServices/getBidList?startdate=".$date."&token=".$token;
        // echo $url;
        echo json_encode(getJson($url));
    }

    function getListFilter()
    {
        $token = getToken();
        // $categorycode = $_REQUEST["categorycode"];   
        $startdate = $_REQUEST['startdate'];
        $closeDate = $_REQUEST['closeDate'];
        // $categorycode = $_REQUEST['categorycode'];
        // $bucode = $_REQUEST['bucode'];
        // $bidno = $_REQUEST['bidno'];
        // $projectName = $_REQUEST['projectName'];
        $url = "http://10.138.1.17/EbidServices/getBidList?page=1&size=50&startdate=".$startdate."&token=".$token."&closeDate=".$closeDate;
        // $url = "http://10.138.1.17/EbidServices/getBidList?Page=1&size=10&startdate=2016-0-12-13&token=651348c506d789396abd7b42b4dc146f1106bf0cce5faad3c7284a66dbcd4171dcd8b0b9c4398d5c&closeDate=2016-0-12-16";
        echo json_encode(getJson($url));
    }

    //
    function getDetail()
    {
      $token = getToken();
    	$bidno = $_REQUEST["bidno"];
      $url = "http://10.138.1.17/EbidServices/getBid?flag=0&bidno=".$bidno."&token=".$token;
      echo json_encode(getJson($url));
    }

    function getVipLogin()
    {
      $token = getToken();
      $userName = $_REQUEST["username"];
      $password = $_REQUEST["password"];
      $url = "http://10.138.1.17/EbidServices/login?token=".$token."&userName=".$userName."&password=".$password;
      echo json_encode(getJson($url));

      // $json_data =json_decode(getJson($url));
      // if ($json_data->errorFlag=="E0000") {
      //   //設置Session
      //   // session_start();
      //   // $_SESSION['vipName'] = $userName;
      //  // echo $json_data->errorFlag;
      //   echo "E0000";
      // }
      // else
      // {
      //   echo "string";
      // }
    }

    function getMyBid()
    {
      $token = getToken();
      $page = $_REQUEST["page"];
      $url = "http://10.138.1.17/EbidServices/getMyBidList?token=".$token."&userName=2601917&page=".$page."&size=6";
      echo json_encode(getJson($url));
    }

    function register()
    {

      $token = getToken();
      $url = "http://10.138.1.17/EbidServices?token=".$token."&tleNo=".$telno."&name=".$name."&pwd=".$password."&vendorCode=".$vendorCode;
      $json_data =json_decode(getJson($url));
      if ($json_data->status=="E0000") {
        echo $json_data->errorFlag;
      }
      else
      {
        echo "string";
      }
    }

  	function getJson($url){
  		$handle = fopen($url,"rb");
  		$content = "";
  		while (!feof($handle)) {
  		  $content .= fread($handle, 10000);
  		}
  		fclose($handle);
      // $content = utf8_encode($content)
      return zhconversion_hans($content);
  		// return $content;
  	}


?>

