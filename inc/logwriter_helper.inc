<?php // autotool_migration Ver2 20121214075930 このファイルは自動化ツールにより編集されました ?>
<?php require_once('ADFlib/func_Common.inc.php'); ?>
<?php require_once('ADFlib/global_reg_emu.inc.php'); ?>
<?php
//logwriter.phpをHTTP経由で呼び出すためのヘルパー関数
?>
<?php
require_once("HTTP/Request.php");

function error_handler_CMN_log($errno, $errstr, $errfile, $errline){
	return;
}

// $log_type : 1=アクセスログ、 2=コンテンツログ
function CMN_log($logwriter_url,$system,$log_type,$ary_user,$ary_class,$ary_operation,$ary_additional=""){
	$org_handler = set_error_handler("error_handler_CMN_log");
// HTTP_Request対応 autotool_migration 20121210120958
// =&new対応 autotool_migration 20121214075930 
////	$req =& new HTTP_Request($logwriter_url);
//	$req = new HTTP_Request($logwriter_url);
	$req = new HTTP_Request($logwriter_url);
	$req->setMethod(HTTP_REQUEST_METHOD_POST);
	$data = array();
	CMN_log_make_data($data,$ary_user,$ary_class,$ary_operation,$ary_additional);
	$data["SYSTEM"]=$system;
	$data["LOG_TYPE"]=$log_type;
	if( count($data) ){
		foreach( $data as $key => $val ) $req->addPostData($key,$val);
	}
	$req->sendRequest();
	$req->getResponseCode();
	//print	$req->getResponseBody();
	set_error_handler($org_handler);
	return TRUE;
}
/*
function CMN_log_wait(&$logwriter_url,&$ary_class,&$ary_operation,&$ary_additional){
	$org_handler = set_error_handler("error_handler_CMN_log");
	$rtn = FALSE;
// HTTP_Request対応 autotool_migration 20121210120958
// =&new対応 autotool_migration 20121214075930 
////	$req =& new HTTP_Request($logwriter_url);
//	$req = new HTTP_Request($logwriter_url);
	$req = new HTTP_Request($logwriter_url);
	$req->setMethod(HTTP_REQUEST_METHOD_POST);
	CMN_log_make_data($data,$ary_user,$ary_class,$ary_operation,$ary_additional);
	$data["SYSTEM"]=$system;
	if( count($data) ){
		foreach( $data as $key => $val ) $req->addPostData($key,$val);
	}
	if (!PEAR::isError($req->sendRequest())) {
		$code = $req->getResponseCode();
		if( $code == "200" ){
			$rtn = TRUE;
		}
	}
	set_error_handler($org_handler);
	return $rtn;
}
*/
function CMN_log_make_data(&$data,&$ary_user,&$ary_class,&$ary_operation,&$ary_additional){
	$data["ACCESS_USER_ID"] = $ary_user[0];
	$data["ACCESS_USER"] = $ary_user[1];
	$data["CLASS1"] = $ary_class[0];
	$data["CLASS2"] = $ary_class[1];
	$data["CLASS3"] = $ary_class[2];
	$data["CLASS4"] = $ary_class[3];
	$data["CLASS5"] = $ary_class[4];
	$data["OPERATION1"] = $ary_operation[0];
	$data["OPERATION2"] = $ary_operation[1];
	$data["OPERATION3"] = $ary_operation[2];
	$data["OPERATION4"] = $ary_operation[3];
	$data["OPERATION5"] = $ary_operation[4];
	$data["HTTP_REFERER"] = $_SERVER["HTTP_REFERER"];
	$data["REMOTE_ADDR"] = $_SERVER["REMOTE_ADDR"];
	$data["SERVER_ADDR"] = $_SERVER["SERVER_ADDR"];
	$data["REQUEST_URI"] = $_SERVER["REQUEST_URI"];
	if( is_array($ary_additional) && count($ary_additional) ){
		foreach( $ary_additional as $key => $info ){
			$data[$key] = $info;
		}
	}
	$data["PARAMETER"] = "";
	if( count($_GET) ){
		foreach($_GET as $key => $val){
			if( is_array($val) && count($val) ){
				for($i=0; $i<count($val); $i++){
// stripslashes対応 autotool_migration 20121214075930 
//					$data["PARAMETER"] .= "&".urlencode($key)."[]=".urlencode(stripslashes($val[$i]));
					$data["PARAMETER"] .= "&".urlencode($key)."[]=".urlencode(com_stripslashes($val[$i]));
				}
			}else{
// stripslashes対応 autotool_migration 20121214075930 
//				$data["PARAMETER"] .= "&".urlencode($key)."=".urlencode(stripslashes($val));
				$data["PARAMETER"] .= "&".urlencode($key)."=".urlencode(com_stripslashes($val));
			}
		}
	}
	if( count($_POST) ){
		foreach($_POST as $key => $val){
			if( is_array($val) && count($val) ){
				for($i=0; $i<count($val); $i++){
// stripslashes対応 autotool_migration 20121214075930 
//					$data["PARAMETER"] .= "&".urlencode($key)."[]=".urlencode(stripslashes($val[$i]));
					$data["PARAMETER"] .= "&".urlencode($key)."[]=".urlencode(com_stripslashes($val[$i]));
				}
			}else{
// stripslashes対応 autotool_migration 20121214075930 
//				$data["PARAMETER"] .= "&".urlencode($key)."=".urlencode(stripslashes($val));
				$data["PARAMETER"] .= "&".urlencode($key)."=".urlencode(com_stripslashes($val));
			}
		}
	}
	if( count($_COOKIE) ){
		foreach($_COOKIE as $key => $val){
			if( is_array($val) && count($val) ){
				for($i=0; $i<count($val); $i++){
// stripslashes対応 autotool_migration 20121214075930 
//					$data["PARAMETER"] .= "&".urlencode($key)."[]=".urlencode(stripslashes($val[$i]));
					$data["PARAMETER"] .= "&".urlencode($key)."[]=".urlencode(com_stripslashes($val[$i]));
				}
			}else{
// stripslashes対応 autotool_migration 20121214075930 
//				$data["PARAMETER"] .= "&".urlencode($key)."=".urlencode(stripslashes($val));
				$data["PARAMETER"] .= "&".urlencode($key)."=".urlencode(com_stripslashes($val));
			}
		}
	}
	if( count($_FILES) ){
		foreach($_FILES as $key => $val){
			if( is_array($val[0]) && count($val[0]) ){
				for($i=0; $i<count($val); $i++){
// stripslashes対応 autotool_migration 20121214075930 
//					$data["PARAMETER"] .= "&".urlencode($key)."[]=".urlencode(stripslashes($val[$i]["name"]));
					$data["PARAMETER"] .= "&".urlencode($key)."[]=".urlencode(com_stripslashes($val[$i]["name"]));
				}
			}else{
// stripslashes対応 autotool_migration 20121214075930 
//				$data["PARAMETER"] .= "&".urlencode($key)."=".urlencode(stripslashes($val["name"]));
				$data["PARAMETER"] .= "&".urlencode($key)."=".urlencode(com_stripslashes($val["name"]));
			}
		}
	}
	if( strlen($data["PARAMETER"]) ) $data["PARAMETER"] = substr($data["PARAMETER"],1);

//	$data["PARAMETER"] .= var_export($_GET,TRUE)."\n";
//	$data["PARAMETER"] .= var_export($_POST,TRUE)."\n";
//	$data["PARAMETER"] .= var_export($_COOKIE,TRUE)."\n";
	return TRUE;
}

?>
