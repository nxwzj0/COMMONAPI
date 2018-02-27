<?php // autotool_migration Ver2 20121214075930 このファイルは自動化ツールにより編集されました ?>
<?php //require_once('ADFlib/func_Common.inc.php'); ?>
<?php //require_once('ADFlib/global_reg_emu.inc.php'); ?>
<?php
//SQLを実行して、最初の1行を連想配列で返す
function CMN_GetSqlFirstResult($sql,$username="",$passwd="",$server="",$vars=""){

	if( strlen($username) ){
		$CON = new OraConnection($username,$passwd,$server);
	}
	else{
		$CON = new OraConnection();
	}
	$CUR = new OraCursor($CON->getConnection());
	if( $CUR->open_ex($sql,$vars) ){
		if( $CUR->get($rslt) ){
			return $rslt;
		}
		$CUR->close();
	}
	$CON->close();
}

//SQLを実行する(UPDATE,INSERT,DELETEなどで使用)
function CMN_ExecSql($sql,$username="",$passwd="",$server="",$vars=""){
	if( strlen($username) ){
		$CON = new OraConnection($username,$passwd,$server);
	}
	else{
		$CON = new OraConnection();
	}
	$CUR = new OraCursor($CON->getConnection());
	if( $CUR->open_ex($sql,$vars) ){
		$CUR->close();
	}
	$CON->close();
}

//JavaScriptをインクルードする
function CMN_IncludeScript($filename){
	print "<script language=\"JavaScript\">\n";
	$txt = new TextFile($GLOBALS["COMMON_ETC_PATH"]."/".$filename);
	$buf = $txt->readAll();
	print $buf;
	$txt->close();
	print "</script>\n";
}

function CMN_IncludeCode($filename){
	$txt = new TextFile($GLOBALS["COMMON_ETC_PATH"]."/".$filename);
	$code = $txt->readAll();
	$txt->close();
}

function CMN_MakeListData_TextFile(&$list,$filename){
	$list = array();
	$txt = new TextFile($filename);
	while( !$txt->eof() ){
		$ary = $txt->readCsvLine();
		if( count($ary) ){
			$list[count($list)] = array("VALUE"=>$ary[0],"TEXT"=>$ary[1]);
		}
	}
	$txt->close();
}

function CMN_MakeHiddenParam(){
	foreach( $_GET as $key => $val ){
		$val = CMN_MakeParamData($val);
		$val = CMN_MakeValueData($val);
		print "<input type=\"hidden\" name=\"$key\" value=\"$val\">\n";
	}
	foreach( $_POST as $key => $val ){
		$val = CMN_MakeParamData($val);
		$val = CMN_MakeValueData($val);
		print "<input type=\"hidden\" name=\"$key\" value=\"$val\">\n";
	}
}

function CMN_MakeHiddenParamEx(){
	foreach( $_GET as $key => $val ){
		if( is_array($val) ){
			foreach( $val as $val2 ){
				$val2 = CMN_MakeParamData($val2);
				$val2 = CMN_MakeValueData($val2);
				print "<input type=\"hidden\" name=\"".$key."[]\" value=\"$val2\">\n";
			}
		}else{
			$val = CMN_MakeParamData($val);
			$val = CMN_MakeValueData($val);
			print "<input type=\"hidden\" name=\"$key\" value=\"$val\">\n";
		}
	}
	foreach( $_POST as $key => $val ){
		if( is_array($val) ){
			foreach( $val as $val2 ){
				$val2 = CMN_MakeParamData($val2);
				$val2 = CMN_MakeValueData($val2);
				print "<input type=\"hidden\" name=\"".$key."[]\" value=\"$val2\">\n";
			}
		}else{
			$val = CMN_MakeParamData($val);
			$val = CMN_MakeValueData($val);
			print "<input type=\"hidden\" name=\"$key\" value=\"$val\">\n";
		}
	}
}

//function CMN_MakeHiddenParamApt($apt_key){
//	foreach( $_GET as $key => $val ){
//		if( $apt_key == $key ){
//			if( is_array($val) ){
//				foreach( $val as $val2 ){
//					$val2 = CMN_MakeParamData($val2);
//					print "<input type=\"hidden\" name=\"".$key."[]\" value=\"$val2\">\n";
//				}
//			}else{
//				$val = CMN_MakeParamData($val);
//				print "<input type=\"hidden\" name=\"$key\" value=\"$val\">\n";
//			}
//		}
//	}
//	foreach( $_POST as $key => $val ){
//		if( $apt_key == $key ){
//			if( is_array($val) ){
//				foreach( $val as $val2 ){
//					$val2 = CMN_MakeParamData($val2);
//					print "<input type=\"hidden\" name=\"".$key."[]\" value=\"$val2\">\n";
//				}
//			}else{
//				$val = CMN_MakeParamData($val);
//				print "<input type=\"hidden\" name=\"$key\" value=\"$val\">\n";
//			}
//		}
//	}
//}

function CMN_AddHiddenParam($name,$value){
	$flg = FALSE;
	if( $flg == FALSE ){
		foreach( $_GET as $key => $val ){
			if( $key == $name ){
				$flg = TRUE;
				break;
			}
		}
	}
	if( $flg == FALSE ){
		foreach( $_POST as $key => $val ){
			if( $key == $name ){
				$flg = TRUE;
				break;
			}
		}
	}
	if( $flg == FALSE ){
		$_POST[$name] = $value;
		if( strlen($value) ){
			$GLOBALS[$name] = $value;
		}
	}
}

function CMN_DelHiddenParam($name){
	global $_GET,$_POST;

	$ary_length = count($_GET);
	reset($_GET);
	for( $i=0; $i<$ary_length;$i++ ){
		if( key($_GET) == $name ){
			array_splice($_GET,$i,1);
		}
		next($_GET);
	}
	$ary_length = count($_POST);
	reset($_POST);
	for( $i=0; $i<$ary_length;$i++ ){
		if( key($_POST) == $name ){
			array_splice($_POST,$i,1);
		}
		next($_POST);
	}
}

function CMN_ModHiddenParam($name,$value){
	CMN_DelHiddenParam($name);
	CMN_AddHiddenParam($name,$value);
}

function CMN_MakeParamArray($type,&$ary){
	if( $type=="POST" )	$tmp = "_POST";
	if( $type=="GET" )	$tmp = "_GET";
	foreach( $GLOBALS[$tmp] as $key => $val ){
		$ary[$key] = $val;
	}
}

function CMN_MakeParamForScript(){
	print "<script language=\"JavaScript\">\n";
	print "var FORM = new Array();\n";
	foreach( $_GET as $key => $val ){
		print "FORM[\"$key\"] = \"$val\";\n";
	}
	foreach( $_POST as $key => $val ){
		print "FORM[\"$key\"] = \"$val\";\n";
	}
	print "</script>\n";
}

//function CMN_GetNameByCodeInTXT($filename,$code){
//	$rtn = "";
//	$txt = new TextFile($filename);
//	while( !$txt->eof() ){
//		$ary = $txt->readCsvLine();
//		if( count($ary) ){
//			if( $ary[0] == $code ){
//				$rtn = $ary[1];
//				break;
//			}
//		}
//	}
//	$txt->close();
//	return $rtn;
//}

function CMN_SetOracleConnection($username,$password,$server){
	$GLOBALS["COMMON_ORA_USER"] = $username;
	$GLOBALS["COMMON_ORA_PASSWD"] = $password;
	$GLOBALS["COMMON_ORA_SERVER"] = $server;
}

function CMN_ReadHTTP($path,$server="",$port=""){
// HTTP_SERVER_VARS対応 autotool_migration 20121210120958
//	global $HTTP_SERVER_VARS;
	global $_SERVER;
// HTTP_SERVER_VARS対応 autotool_migration 20121210120958
//	//if( strlen($server) == 0 ) $server = $HTTP_SERVER_VARS["SERVER_ADDR"];
	//if( strlen($server) == 0 ) $server = $_SERVER["SERVER_ADDR"];
// HTTP_SERVER_VARS対応 autotool_migration 20121210120958
//	if( strlen($server) == 0 ) $server = $HTTP_SERVER_VARS["HTTP_HOST"];
	if( strlen($server) == 0 ) $server = $_SERVER["HTTP_HOST"];
// HTTP_SERVER_VARS対応 autotool_migration 20121210120958
//	if( strlen($port) == 0 ) $port = $HTTP_SERVER_VARS["SERVER_PORT"];
	if( strlen($port) == 0 ) $port = $_SERVER["SERVER_PORT"];
	$url = "http://$server:$port".$path;
	$buf = "";
	$fp = fopen($url,"r");
	while( !feof($fp) ){
		$buf .= fgets($fp,4096);
	}
	fclose($fp);
	return $buf;
}
function CMN_MakeLikeCond($field,$word,$forward="",$back=""){
	$escape = "\\";
	$word = str_replace("\\","\\\\",$word);//20080304	add	anb
	$word = preg_replace("/%/",$escape."%",$word);
	$word = preg_replace("/％/",$escape."％",$word);
	$word = preg_replace("/_/",$escape."_",$word);
	$word = preg_replace("/＿/",$escape."＿",$word);
//	$word = preg_replace("/\\/","\\\\",$word);
	$cond = "{$field} like '{$forward}{$word}{$back}' escape '$escape'";
	return $cond;
}
function CMN_MakeMultiKeywordsCond($keywords,$and_or,$cond_str){
//keywords=空白で区切られたキーワード
//and_or=0:AND 1:OR
//cond_str=SQLの条件式 例："to_multi_byte(name) like to_multi_byte('%[WORD]%')"、"upper(to_multi_byte(name)) like upper(to_multi_byte('%[WORD]%'))"

	$escape = "\\";
	$keywords = preg_replace("/%/",$escape."%",$keywords);
	$keywords = preg_replace("/％/",$escape."％",$keywords);
	$keywords = preg_replace("/_/",$escape."_",$keywords);
	$keywords = preg_replace("/＿/",$escape."＿",$keywords);
	$cond_str = $cond_str . " escape '$escape'";

	$ary_words = array();
	$tmp_keywords = "";
	for( $i=0;$i<mb_strlen($keywords);$i++ ){
		$tmp = mb_substr($keywords,$i,1);
		$tmp_keywords .= $tmp=="　" ? " " : $tmp;
	}
	$ary_tmp = preg_split("/ /",$tmp_keywords);
	foreach( $ary_tmp as $val ){
		$ary_tmp2 = array();
		//全て全角
		$tmp = mb_convert_kana($val,"KVA");
		array_push($ary_tmp2,$tmp);
		//半角カナ以外全角
		$tmp2 = mb_convert_kana($tmp,"k");
		if( $tmp != $tmp2 ) array_push($ary_tmp2,$tmp2);
		array_push($ary_words,$ary_tmp2);
	}
	if( $and_or == 0 ) $andor = "and"; else $andor = "or";
	$tmp = "";
	foreach( $ary_words as $ary ){
		$tmp .= strlen($tmp) ? "\n$andor\n" : "";
		$tmp2 = "";
		foreach( $ary as $val ){
			$tmp2 .= strlen($tmp2) ? "\n\tor\n" : "";
			$tmp2 .= "\t".preg_replace("/\[WORD\]/",$val,$cond_str);
		}
		$tmp .= "\t(\n$tmp2\n\t)";
	}
	return "\n(\n$tmp\n)";
}

function CMN_Cookie($name,&$variable,$defvalue){
	if( $variable == "" ){
		if( $GLOBALS["COOKIE_$name"] != "" ){
			$variable = $GLOBALS["COOKIE_$name"];
		}else{
			$variable = $defvalue;
		}
	}
	CMN_SetCookie($name,$variable);
}
function CMN_GetCookie($name){
	return $_COOKIE["COOKIE_$name"];
}
function CMN_SetCookie($name,$value,$exp_day=365){
	$now_year = (int)date("Y");
	$now_mon = (int)date("m");
	$now_day = (int)date("d");
	setcookie("COOKIE_$name",$value,mktime(0,0,0,$now_mon,$now_day+$exp_day,$now_year));
}

function CMN_TrimLongStr($str,$len){
	$rtn = $str;
	if( mb_strlen($str) > $len ){
		$str = mb_substr($str,0,$len)."...";
	}
	return $str;
}

//function CMN_MakeSqlEscapeText(){
//	foreach( $_GET as $key => $val ){
//		if( is_array($val) ){
//			foreach( $val as $val2 ){
//				$SQL_ESCAPE[$key] = array();
//				array_push($SQL_ESCAPE[$key],preg_replace("/'/","/''/",$val2));
//			}
//		}else{
//			$SQL_ESCAPE[$key] = preg_replace("/'/","''",$val);
//		}
//	}
//	foreach( $_POST as $key => $val ){
//		if( is_array($val) ){
//			foreach( $val as $val2 ){
//				$SQL_ESCAPE[$key] = array();
//				array_push($SQL_ESCAPE[$key],preg_replace("/'/","/''/",$val2));
//			}
//		}else{
//			$SQL_ESCAPE[$key] = preg_replace("/'/","''",$val);
//		}
//	}
//	return $SQL_ESCAPE;
//}
//パラメータ用データ配列作成
function CMN_MakeParamDataArray(&$ary){
	foreach( $_GET as $key => $val ){
		if( is_array($val) ){
			foreach( $val as $val2 ){
				$ary[$key][count($ary[$key])] = CMN_MakeParamData($val2);
			}
		}else{
			$ary[$key] = CMN_MakeParamData($val);
		}
	}
	foreach( $_POST as $key => $val ){
		if( is_array($val) ){
			foreach( $val as $val2 ){
				$ary[$key][count($ary[$key])] = CMN_MakeParamData($val2);
			}
		}else{
			$ary[$key] = CMN_MakeParamData($val);
		}
	}
}
//パラメータ用データ作成
function CMN_MakeParamData($val){
// stripslashes対応 autotool_migration 20121214075930 
//	$val = stripslashes($val);
	$val = com_stripslashes($val);
	return $val;
}
//SQL用データ作成
function CMN_MakeSqlData($val){
	$val = preg_replace("/'/","''",$val);
	return $val;
}
//値用データ作成
function CMN_MakeValueData($val){
// htmlspecialchars対応 autotool_migration 20121214075930 
//	$val = htmlspecialchars($val);
	$val = com_htmlspecialchars($val);
	return $val;
}
//表示用データ作成
function CMN_MakeDispData($val){
// htmlspecialchars対応 autotool_migration 20121214075930 
//	$val = htmlspecialchars($val);
	$val = com_htmlspecialchars($val);
	$val = preg_replace("/\r?\n/","<br>",$val);
	return $val;
}
?>
