<?php // autotool_migration Ver2 20121214075930 このファイルは自動化ツールにより編集されました ?>
<?php require_once('ADFlib/func_Common.inc.php'); ?>
<?php require_once('ADFlib/global_reg_emu.inc.php'); ?>
<?php
define("DEBUG_LOGGING_LEVEL",1);
define("LOGGING_DELETE_INTERVAL_DAY",3);

//$COMMON_CONVERT_SQL_SJIS=1; //NLS_LANGはSJISが前提
//$COMMON_ORACLE_SERVER_CHARSET="JA16SJIS"; //DBサーバのSJISが前提

///////////////////////////////////////////////////////////////////////////////
//性能改善
//Oracleのコネクションをリクエスト内で保持する
//register_shutdown_functionで、コネクションをクローズ
define("PERFORMANCE_HIGH",0);
register_shutdown_function("shutdown_func");
function shutdown_func(){
	//if( is_array($GLOBALS["COMMON_ORACLE_CONNECTION"]) ){
	//	if( count($GLOBALS["COMMON_ORACLE_CONNECTION"]) ){
	//		foreach( $GLOBALS["COMMON_ORACLE_CONNECTION"] as $key => $val ){
	//			if( is_resource($val) ){
	//				oci_close($val);
	//			}
	//		}
	//	}
	//}
}
///////////////////////////////////////////////////////////////////////////////

///////////////////////////////////////////////////////////////////////////////
function convert_sql_charcode(&$sql){
	//PHPソースはEUCが前提
	global $COMMON_ORACLE_SERVER_CHARSET;

	switch( $COMMON_ORACLE_SERVER_CHARSET ){
	case "JA16SJIS":
		$charset = "sjis-win";
		break;
	case "JA16EUC":
// 		$charset = "eucjp-win";
		$charset = "CP51932";
		break;
	case "AL32UTF8":
		$charset = "utf-8";
		break;
	case "UTF8":
		$charset = "utf-8";
		break;
	default:
		return $sql;
	}
// 	return mb_convert_encoding($sql,$charset,"eucjp-win");
//	return mb_convert_encoding($sql,$charset,"CP51932");
	return mb_convert_encoding($sql,$charset,"utf8");
}
function unconvert_sql_charcode(&$sql){
	global $COMMON_ORACLE_SERVER_CHARSET;
	switch( $COMMON_ORACLE_SERVER_CHARSET ){
	case "JA16SJIS":
		$charset = "sjis-win";
		break;
	case "JA16EUC":
// 		$charset = "eucjp-win";
		$charset = "CP51932";
		break;
	case "AL32UTF8":
		$charset = "utf-8";
		break;
	case "UTF8":
		$charset = "utf-8";
		break;
	default:
		return $sql;
	}
//	return mb_convert_encoding($sql,"eucjp-win",$charset);
//	return mb_convert_encoding($sql,"CP51932",$charset);
	return mb_convert_encoding($sql,"utf8",$charset);
}
///////////////////////////////////////////////////////////////////////////////

$SQL = ""; //最後に実行された(しようとした)SQL文


function logging_class_error_handler($errno, $errmsg, $filename, $linenum, $vars){
	return;
}
Class Logging
{
	var $LOGGING_MODE_FILE = 1;
	var $LOGGING_MODE_HTML = 2; //未使用
	var $LOGGING_MODE_BUFFERING = 4; //未使用

	var $mode;
	var $logfilepath;
	var $logfilename;

	function Logging($logfilepath, $mode = 1){ //$mode = LOGGING_MODE_?
		global $REMOTE_ADDR;

		$this->mode = $mode;
		$this->logfilepath = $logfilepath;
		$this->logfilename = $REMOTE_ADDR."_log.txt";

		//書き込もうとしているログファイルの作成日付が
		//LOGGING_DELETE_INTERVAL_DAY日以上前であれば削除する
		$filename = "$this->logfilepath/$this->logfilename";
		if( file_exists($filename) ){
			$now_date = date("Ymd");
			$file_date = strftime("%Y%m%d",filectime($filename));
			if( (int)$now_date - (int)$file_date > LOGGING_DELETE_INTERVAL_DAY ){
				$tmp = set_error_handler("logging_class_error_handler");
				@unlink($filename);
				set_error_handler($tmp);
			}
		}
	}

	function log_request_data($force = FALSE){
		if( DEBUG_LOGGING_LEVEL == 0 ){
			if( $force == FALSE ) return;
		}

// HTTP_SERVER_VARS対応 autotool_migration 20121210120958
//		global $HTTP_SERVER_VARS;
		global $_SERVER;

		$this->write("------------------------------------------------------------");
		$this->write("REQUEST_STATUS:",TRUE);
// HTTP_SERVER_VARS対応 autotool_migration 20121210120958
//		foreach( $HTTP_SERVER_VARS as $key => $val ){
		foreach( $_SERVER as $key => $val ){
			if( strlen($key) ){
				$this->write(" $key = $val");
			}
		}
	}

	function write($str,$flg_time = FALSE){
		$filename = "$this->logfilepath/$this->logfilename";
		if( $flg_time ){
// split対応 autotool_migration 20121210120958
//			$mtime = split(" ", microtime());
			$mtime = explode(" ", microtime());
			$tmp = set_error_handler("logging_class_error_handler");
			@error_log("[".date("Y/m/d H:i:s",$mtime[1]).substr($mtime[0],1)."]\n".$str."\n",3,$filename);
			set_error_handler($tmp);
		}
		else{
			$tmp = set_error_handler("logging_class_error_handler");
			@error_log($str."\n",3,$filename);
			set_error_handler($tmp);
		}
	}
}

Class BaseObject{

	var $name;
	var $log;

	function BaseObject($name = ""){
		$logpath = $GLOBALS["COMMON_DEBUG_LOG_PATH"];
		if( $logpath != "" ){
			$this->log = new Logging($logpath);
		}
		$this->name = $name;
	}
	function writeLog($str,$flg_time = TRUE){
		if( DEBUG_LOGGING_LEVEL > 0 ){
			if( $this->log ) $this->log->write("*$this->name:$str",$flg_time);
		}
	}
	function writeErrLog($str){
		if( $this->log ){
			$this->log_request_data(TRUE);
			$this->log->write("*$this->name:$str",TRUE);
		}
	}
}

Class OraConnection extends BaseObject{

	var $ORAACCESS_MODE_NORMAL = 1;
	var $ORAACCESS_MODE_PERSIST = 2;
	var $ORAACCESS_MODE_NEW = 3;

	var $con;
	var $mode;

	function OraConnection(
		$user = "_default_",
		$passwd = "_default_",
		$oracle = "_default_",
		$mode = 1){

		if( $user == "_default_" ) $user = $GLOBALS["COMMON_ORA_USER"];
		if( $passwd == "_default_" ) $passwd = $GLOBALS["COMMON_ORA_PASSWD"];
		if( $oracle == "_default_" ) $oracle = $GLOBALS["COMMON_ORA_SERVER"];

		$this->BaseObject("OraConnection");
		$this->writeLog("OraConnection($user,$passwd,$oracle,$mode)");

		$this->mode = $mode;
		if( $mode == $this->ORAACCESS_MODE_NORMAL ){
			$this->con = oci_connect($user,$passwd,$oracle);
		}
		if( $mode == $this->ORAACCESS_MODE_PERSIST ){
			$this->con = oci_pconnect($user,$passwd,$oracle);
		}
		if( $mode == $this->ORAACCESS_MODE_NEW ){
			$this->con = oci_new_connect($user,$passwd,$oracle);
		}
	}

	function close(){
		$this->writeLog("close");

		if( $this->con ){
			if( $this->mode == $this->ORAACCESS_MODE_NORMAL ){
				//oci_close($this->con);
				//$this->con = FALSE;
			}
		}
	}

	function getConnection(){
		$this->writeLog("getConnection()");

		return $this->con;
	}
	function getError(){
	}
	function commit(){
		oci_commit($this->con);
	}
	function rollback(){
		oci_rollback($this->con);
	}
}

Class OraCursor extends BaseObject{

	var $con;
	var $cur;

	function OraCursor($con){
		$this->BaseObject("OraCursor");
		$this->writeLog("OraCursor()");

		$this->con = $con;
	}

	function open(&$sql,$vars=""){
		//SQL文の変換が定義されている場合
		if( is_array($GLOBALS["COMMON_VIRTUAL_TABLE_MOUNT"]) ){
			$ary_vtm = $GLOBALS["COMMON_VIRTUAL_TABLE_MOUNT"];
			foreach( $ary_vtm as $key => $val ){
				$sql = $this->convertSql($sql,$key,$val);
			}
		}

		$GLOBALS["RECENT_SQL_ORG"] = $sql;
		$this->writeLog("open($sql)");

		//if( $this->cur = Ora_Open($this->con) ){
			//if( $GLOBALS["COMMON_CONVERT_SQL_SJIS"] && mb_detect_encoding($sql) != "SJIS" ) $exec_sql = convert_sql_charcode($sql);
			$exec_sql = $sql;
			if( $GLOBALS["COMMON_CONVERT_SQL_SJIS"] ) $exec_sql = convert_sql_charcode($sql);
			$GLOBALS["RECENT_SQL"] = $exec_sql;
			$GLOBALS["RECENT_SQL_VARS"] = $vars;
			$this->cur = oci_parse($this->con,$exec_sql);
			if( $this->cur ){
				if( is_array($vars) && count($vars) ){
					foreach( $vars as $key => $val ){
						if( preg_match("/:$key/",$sql) ){
							$this->writeLog("Binding :$key = $val");
							//if( oci_bind_by_name($this->cur,":$key",$val,-1) ){
							if( oci_bind_by_name($this->cur,":$key",$vars[$key],-1) ){
								$GLOBALS["ORA_BIND_$key"] = $val;
							}
						}
					}
				}
				return TRUE;
			}
		//}
		return FALSE;
	}

	function convertSql($sql_str,$pattern,$replacement){
		$ary_tmp = preg_split("/'/",$sql_str);
		for( $i=0;$i<count($ary_tmp);$i++ ){
			if( $i % 2 == 0 ){
				$ary_tmp[$i] = preg_replace("/".$pattern."/i",$replacement,$ary_tmp[$i]);
			}
		}
		return join("'",$ary_tmp);
	}

	function getError(){
	}

	function getCursor(){
		$this->writeLog("getCursor()");

		return $this->cur;
	}

	function exec($commit=TRUE){
		$this->writeLog("exec() start",TRUE);

		$rtn = FALSE;
		if( $commit==TRUE ){
			if( oci_execute($this->cur) ) $rtn = TRUE;
		}else{
			//コミット無
			if( oci_execute($this->cur,OCI_DEFAULT) ) $rtn = TRUE;
		}
		$this->writeLog("exec() end",TRUE);
		return $rtn;
	}

	function open_ex(&$sql,$vars="",$commit=TRUE){
		$this->writeLog("open_ex()");

		if( $this->open($sql,$vars) ){
			return $this->exec($commit);
		}
	}

	function close(){
		$this->writeLog("close()");

		//if( Ora_Close($this->cur) ){
			return TRUE;
		//}
		//return FALSE;
	}

	function get(&$results){
		//$this->writeLog("get($results)");

		$results = oci_fetch_array($this->cur,OCI_ASSOC|OCI_RETURN_NULLS);
		if( $results ){
			//var_export($results);
			if( $GLOBALS["COMMON_CONVERT_SQL_SJIS"] && count($results) ){
				$rslt = array();
				foreach( $results as $key => $val ){
//					$tmp1 = mb_convert_encoding($key,"EUC-JP","SJIS");
//					$tmp2 = mb_convert_encoding($val,"EUC-JP","SJIS");
// 					$tmp1 = mb_convert_encoding($key,"eucjp-win","sjis-win");
// 					$tmp2 = mb_convert_encoding($val,"eucjp-win","sjis-win");
//					$tmp1 = mb_convert_encoding($key,"CP51932","sjis-win");
//					$tmp2 = mb_convert_encoding($val,"CP51932","sjis-win");
					$tmp1 = mb_convert_encoding($key,"utf8","sjis-win");
					$tmp2 = mb_convert_encoding($val,"utf8","sjis-win");
					$rslt[$tmp1] = $tmp2;
				}
				$results = $rslt;
			}
			return TRUE;
		}
		return FALSE;
	}

	function fetch(){
		//$this->writeLog("fetch()");

		if( oci_fetch($this->cur) ){
			return TRUE;
		}
		return FALSE;
	}
}

function ExecTemplate_fetch_error_handler($errno, $errmsg, $filename, $linenum, $vars){
	//「フェッチ順序が無効」のみ無視する
	if( stristr($errmsg,"ORA-01002") ){
		return;
	}else{
		CustomErrorHandler($errno, $errmsg, $filename, $linenum, $vars);
	}
}

Class ExecTemplate Extends BaseObject{

	var $html;
	var $sql;
	var $con;
	var $vars;
	var $get_count=0;

	var $html_mode = TRUE;

	var $callback_func;
	var $callback_func_param;
	var $callback_func_param_flg;
	var $callback_func_output;
	var $result_ary;

	function ExecTemplate(&$htmltpl, &$sql, $con = 0){
		$this->BaseObject("ExecTemplate");
		$this->writeLog("ExecTemplate()");

		$this->html = &$htmltpl;
		$this->sql = &$sql;
		$this->con = $con;
		$this->vars = "";

		$this->callback_func = "";
		$this->callback_func_output = "";
	}

	function setHtmlMode($flg){
		$this->html_mode = $flg;
	}

	function setCallback($funcname){
		$this->callback_func = $funcname;
		$this->callback_func_param_flg = 0;
	}

	function setCallback_Output($funcname){
		$this->callback_func_output = $funcname;
	}

	function setCallbackEx($funcname,&$param){
		$this->callback_func = $funcname;
		$this->callback_func_param = &$param;
		$this->callback_func_param_flg = 1;
	}

	function setResultDataArray(&$ary_rslt){
		$this->result_ary = &$ary_rslt;
	}

	function setBindVars($ary_vars){
		$this->vars = $ary_vars;
	}

	function getCountGet(){
		return $this->get_count;
	}

	function getResult($start = 1, $count = -1){
		$this->writeLog("getResult($start,$count) start", TRUE);

		$rslt = "";
		$this->get_count = 0;

		$flg_con = false;
		if( $this->con == 0 ){
			$this->con = new OraConnection();
			$flg_con = true;
		}

		$CON = &$this->con;
		$CUR = new OraCursor($CON->getConnection());
		if( $CUR->open_ex($this->sql,$this->vars) ){
			$get_cnt = 0;
			$skip_cnt = 0;
			$this->writeLog("skip start",TRUE);
			while( --$start ){
				$skip_cnt ++;
				if( !$CUR->fetch() ) break;
			}
			$this->writeLog("skip end",TRUE);
			while( TRUE ){
				$tmp = set_error_handler("ExecTemplate_fetch_error_handler");
				if( ! $CUR->get($record) ) break;
				set_error_handler($tmp);
				//$this->writeLog("fetch loop",TRUE);
				if( $count >= 0 ){
					if($get_cnt >= $count ){
						break;
					}
				}
				$get_cnt ++; $this->get_count = $get_cnt;
				if( strlen($this->callback_func) >0 ){
					//eval($this->callback_func.'($record);');
					if( $this->callback_func_param_flg ){
						call_user_func_array($this->callback_func,array(&$record,&$this->callback_func_param));
					}else{
						call_user_func_array($this->callback_func,array(&$record));
					}
				}
				if( is_array($this->result_ary) ){
					$this->result_ary[count($this->result_ary)] = $record;
				}
				$tpl = $this->html;
				foreach( $record as $key => $val ){
					if( $html_mode ){
						//最初の文字が「<」、最後の文字が「>」の場合は、htmlspecialcharsを通さない
						if( substr($val,0,1) != "<" && substr($val,strlen($val)-1,1) != ">" )
// htmlspecialchars対応 autotool_migration 20121214075930 
//							$val = htmlspecialchars($val);
							$val = com_htmlspecialchars($val);
					}
					$tpl = str_replace("[$key]","$val",$tpl);
					$tpl = str_replace("[#0]",$get_cnt-1,$tpl);
					$tpl = str_replace("[#]",$get_cnt,$tpl);
					$tpl = str_replace("[##]",$skip_cnt+$get_cnt,$tpl);
				}
				if( strlen($this->callback_func_output) >0 ){
					eval($this->callback_func_output.'($tpl);');
				}
				$rslt .= $tpl;
			}
			$CUR->close();
		}

		if( $flg_con ){
			$CON->Close();
		}

		$this->writeLog("getResult() end", TRUE);
		return $rslt;
	}
}

Class TextFile Extends BaseObject{

	var $TEXTFILE_MODE_READ = 1;
	var $TEXTFILE_MODE_WRITE = 2; //未使用
	var $TEXTFILE_MODE_APPEND = 4; //未使用

	var $filename;
	var $mode;
	var $fp;

	var $BUFSIZE = 4096;

	function TextFile($filename, $mode = 1){
		$this->BaseObject("TextFile");
		$this->writeLog("TextFile($filename, $mode)");

		$this->filename = $filename;
		$this->mode = $mode;

		if( !file_exists($this->filename) ){
			$this->writeLog("File not exists!");
			return;
		}

		if( $this->mode == $this->TEXTFILE_MODE_READ ){
			$this->fp = fopen($this->filename, "r");
		}
	}

	function close(){
		$this->writeLog("close()");

		if( $this->fp ) fclose($this->fp);
	}

	function eof(){
		if( !$this->fp ) return TRUE;

		return feof($this->fp);
	}

	function readLine(){
		if( $this->mode != $this->TEXTFILE_MODE_READ ) return false;

		if( $this->fp ){
			if( !feof($this->fp) ){
				return fgets($this->fp,$this->BUFSIZE);
			}
		}
	}

	function readCsvLine(){
		if( $this->mode != $this->TEXTFILE_MODE_READ ) return false;

		if( $this->fp ){
			if( !feof($this->fp) ){
				$tmp = fgets($this->fp,$this->BUFSIZE);
				if( strlen($tmp) ){
					$tmp = preg_replace("/\n/", "", $tmp);
					return preg_replace("/\"/", "", preg_split("/,/",$tmp));
				}
			}
		}
	}

	function readAll(){
		if( $this->mode != $this->TEXTFILE_MODE_READ ) return false;

		if( $this->fp ){
			$text = "";
			while( !feof($this->fp) ){
				$text .= fgets($this->fp,$this->BUFSIZE);
			}
			return $text;
		}
	}
}

//複数のSQLを実行する（COMMIT、ROLLBACKあり）
class MultiExecSql extends BaseObject{
	var $oc;
	function MultiExecSql($username="",$passwd="",$server=""){
		$this->BaseObject("OraConnection");
		if( strlen($username) ){
			$this->oc = new OraConnection($username,$passwd,$server,3);
		}
		else{
			$this->oc = new OraConnection("_default_","_default_","_default_",3);
		}
	}
	function execute($sql,$vars=""){
		$this->writeLog("execute($sql)");
		$commit = FALSE;	//コミットオフ
		$CUR = new OraCursor($this->oc->getConnection());
		if( $CUR->open_ex($sql,$vars,$commit) ){
			$CUR->close();
		}
	}
	function getResultData(&$sql,&$ary){
		$this->writeLog("getResultData($sql)");
		$result = "";
		$GLOBALS["RECENT_SQL_ORG"] = $sql;
		$exec_sql = convert_sql_charcode($sql);
		$GLOBALS["RECENT_SQL"] = $exec_sql;
		$cur = oci_parse($this->oc->getConnection(),$exec_sql);
		if( oci_execute($cur,OCI_DEFAULT) ){
			while(1){
				$tmp = set_error_handler("ExecTemplate_fetch_error_handler");
				if( !$this->get($cur,$result) ) break;
				$dmy = set_error_handler($tmp);
				$ary[count($ary)] = $result;
			}
		}
	}
	function commit(){
		$this->oc->commit();
		$this->oc->close();
	}
	function rollback(){
		$this->oc->rollback();
		$this->oc->close();
	}

	function get(&$cur,&$rslt){
		$results = oci_fetch_array($cur,OCI_ASSOC|OCI_RETURN_NULLS);
		if( $results ){
			if( $GLOBALS["COMMON_CONVERT_SQL_SJIS"] && count($results) ){
				$rslt = array();
				foreach( $results as $key => $val ){
//					$tmp1 = mb_convert_encoding($key,"EUC-JP","SJIS");
//					$tmp2 = mb_convert_encoding($val,"EUC-JP","SJIS");
// 					$tmp1 = mb_convert_encoding($key,"eucjp-win","sjis-win");
// 					$tmp2 = mb_convert_encoding($val,"eucjp-win","sjis-win");
//					$tmp1 = mb_convert_encoding($key,"CP51932","sjis-win");
//					$tmp2 = mb_convert_encoding($val,"CP51932","sjis-win");
					$tmp1 = mb_convert_encoding($key,"utf8","sjis-win");
					$tmp2 = mb_convert_encoding($val,"utf8","sjis-win");
					$rslt[$tmp1] = $tmp2;
				}
			}
			return TRUE;
		}else{
			return FALSE;
		}
	}
}
?>
