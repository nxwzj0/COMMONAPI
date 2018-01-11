<?php // autotool_migration Ver2 20121214075930 このファイルは自動化ツールにより編集されました ?>
<?php require_once('ADFlib/func_Common.inc.php'); ?>
<?php require_once('ADFlib/global_reg_emu.inc.php'); ?>
<?php
//--------------------------------------------------------------------
//グローバル変数定義
$SYSTEM_COMPANY_NAME = "メタウォーター";


//サーバ環境別の定数定義インクルード
//$CONFIG_FILE = str_replace(":","_",$HTTP_HOST) . ".conf";
//$CONFIG_FILE = $SERVER_ADDR."_".$SERVER_PORT.".conf"; 172.20.108.34_80
$CONFIG_FILE = '172.20.108.34_80' . '.conf';
// $INC_REL_PATHはenv.incで定義済み
require("$INC_REL_PATH/$CONFIG_FILE");
//ディレクトリ別の定数定義インクルード
if( is_file($CONFIG_FILE) ){
	include($CONFIG_FILE);
}

//現在のパスを保持する変数
//$COMMON_NOW_PATH = preg_replace("/(.*)(\/.*)/si","\\1",$GLOBALS["PATH_TRANSLATED"]);

//--------------------------------------------------------------------
//PHP環境設定
if( strtoupper($COMMON_SYSTEM_TYPE) != "WINDOWS" ){
	ini_set("include_path",ini_get("include_path").":$COMMON_INC_PATH:$COMMON_DEFINC_PATH");
}else{
	ini_set("include_path",ini_get("include_path").";$COMMON_INC_PATH;$COMMON_DEFINC_PATH");
}
ini_set("max_execution_time","1800");
ini_set("max_input_time","1800");

//--------------------------------------------------------------------
//共通クラスのインクルード
require("cls_Common.inc");
require("proc_Common.inc");
require("cls_objectMaker.inc");

//--------------------------------------------------------------------
//エラーハンドラ
function CustomErrorHandler($errno, $errmsg, $filename, $linenum, $vars){
	/*
	1 E_ERROR
	2 E_WARNING
	4 E_PARSE
	8 E_NOTICE
	16 E_CORE_ERROR
	32 E_CORE_WARNING
	64 E_COMPILE_ERROR
	128 E_COMPILE_WARNING
	*/
	$err_str = "ERR: $errno $errmsg $filename $linenum";
	switch( $errno ){
	case E_STRICT:
//		$log = new Logging($GLOBALS["COMMON_DEBUG_LOG_PATH"]);
//		$log->log_request_data(TRUE);
//		$log->write($err_str,TRUE);
//		$log->write($errmsg);
		break;
	case E_NOTICE:
		break;
	case E_WARNING:
	case E_ERROR:
		$log = new Logging($GLOBALS["COMMON_DEBUG_LOG_PATH"]);
		$log->log_request_data(TRUE);
		$log->write($err_str,TRUE);
		$log->write($errmsg);
		if( stristr($errmsg,"ORA-") ){
			$log->write("Oracle Server: ".$GLOBALS["COMMON_ORA_SERVER"]);
			$log->write("Oracle User: ".$GLOBALS["COMMON_ORA_USER"]);
			$log->write("Oracle Passwd: ".$GLOBALS["COMMON_ORA_PASSWD"]);
		}
		if( strlen($GLOBALS["RECENT_SQL"]) ){
			$log->write("NLS_LANG=".getenv("NLS_LANG"));
			$log->write($GLOBALS["RECENT_SQL_ORG"]);
			$log->write("---");
			$log->write($GLOBALS["RECENT_SQL"]);
		}
	default:
		$tmp_enc = mb_detect_encoding($err_str);
		if( $tmp_enc != $COMMON_CHARSET ){
			$err_str = mb_convert_encoding($err_str,$COMMON_CHARSET,$tmp_enc);
		}
		print "<hr><b>エラーが発生しました。実行を中断します。</b><br>\n";
		print "<div>$err_str</div>";
		exit;
		break;
	}
}
set_error_handler("CustomErrorHandler");

//GETリクエストの防御(クッキーにユーザIDがない場合GETリクエストは制限される)
require_once("$COMMON_BASE_PATH/../AUTH/check_get_method.php");
if( $_COOKIE["COOKIE_LOGIN_ID"] != "" ){
	//if( $_SERVER["REQUEST_METHOD"] == "GET" ){
		//クッキーにユーザIDがある場合、GET/POSTされたユーザIDを上書きする
		$GLOBALS["user_id"] = $_COOKIE["COOKIE_LOGIN_ID"];
		$_REQUEST["user_id"] = $_COOKIE["COOKIE_LOGIN_ID"];
		$_GET["user_id"] = $_COOKIE["COOKIE_LOGIN_ID"];
		$_POST["user_id"] = $_COOKIE["COOKIE_LOGIN_ID"];
	//}
}
//else{
//クッキーに格納するのはログイン処理でのみにしなければ駄目！
//外部システムからは、基本的にはログイン処理をしてもらう必要あり
//
//	//クッキーがない場合は、POSTされた、許可されたGETリクエストからのuser_idをクッキーに入れる
//	$_COOKIE["COOKIE_LOGIN_ID"] = $_REQUEST["user_id"];
//	setcookie("COOKIE_LOGIN_ID",$_REQUEST["user_id"],null,"/");
//}

//--------------------------------------------------------------------
//共通オブジェクトの生成
$LOG = new Logging($COMMON_DEBUG_LOG_PATH);
$LOG->log_request_data();

//--------------------------------------------------------------------
//ユーザ情報の取得(GETまたはPOSTでかならずuser_idが渡される)
$USER_NAME = "";
$USER_SEC_CODE = "";
$USER_SEC_NAME = "";
$USER_MAIL = "";
$USER_AUTH1 = "";
$USER_AUTH2 = "";
$USER_PARENT_SEC_CODE = "";
$USER_JNAME = "";
$USER_BU_NAME = "";
$USER_KA_NAME = "";
$USER_COMP_CODE = "";
$USER_BUMON = "";
$USER_COMP_NAME = "";
$USER_OUT_TEL = "";
$USER_IN_TEL = "";
//$USER_COST_DEPT_CODE = "";

//--------------------------------------------------------------------
//共通関数

//HTMLの<HEAD>部分を作成する
function CMN_MakeHead($title, $flg_xls=FALSE){
	$cs = mb_http_output();
//	if( $GLOBALS["COMMON_CHARSET"] != "NONE" ){
		if( $cs == "SJIS" ){
			print "<meta http-equiv=\"Content-Type\" content=\"text/html;charset=Shift_JIS\">\n";
		}
		if( $cs == "EUC-JP" ){
			print "<meta http-equiv=\"Content-Type\" content=\"text/html;charset=".$cs."\">\n";
		}
		if( $cs == "" ){
			print "<meta http-equiv=\"Content-Type\" content=\"text/html;charset=".$GLOBALS["COMMON_CHARSET"]."\">\n";
		}
//	}
		print "<meta http-equiv=\"Pragma\" content=\"no-cache\">\n";

//	print "<title>$title".(strlen($GLOBALS["COMMON_TITLE_SUFFIX"])?" - ".$GLOBALS["COMMON_TITLE_SUFFIX"]:" - $SYSTEM_TITLE")."</title>\n";
	print "<title>$title".(strlen($GLOBALS["COMMON_TITLE_SUFFIX"])?" - ".$GLOBALS["COMMON_TITLE_SUFFIX"]:"")."</title>\n";

	if( $flg_xls == FALSE ){
		$file_style = "style.css";
		print "<link rel=stylesheet type=\"text/css\" href=\"".$GLOBALS["COMMON_HOME_ALIAS"]."/etc/$file_style\">\n";
		CMN_IncludeScript("base.js");
		CMN_IncludeScript("button.js");
		print <<<BUF
<script language="JavaScript">
window.onload = function (){
	if(ExistsOpener(window.top)){
		if(document.getElementById("WINDOW_CLOSE_ANCHOR")) document.getElementById("WINDOW_CLOSE_ANCHOR").innerHTML = "<a href='JavaScript:window.top.close();'>閉じる</a>";
	}
	//BODYタグにonloadを書いては駄目、代わりに「win_initialize()」を使う。
	if(IsFunction(window.win_initialize)) window.win_initialize();
}
</script>
BUF;
	}else{
		print "<style>\n";
		$txt = new TextFile($GLOBALS["COMMON_ETC_PATH"]."/style_xls.css");
		$buf = $txt->readAll();
		print $buf;
		$txt->close();
		print "</style>\n";
	}
}

Class SelectTag Extends BaseObject{
	// select value,text from table
	// "value","text"
	// 上記の形式のテキストファイル、SQLから<OPTION>タグに展開する

	var $SELECTTAG_MODE_FILE = 1;
	var $SELECTTAG_MODE_SQL = 2;
	var $SELECTTAG_MODE_ARRAY = 4;
	var $SELECTTAG_MODE_TEXTONLY = 64; //value値をtext値として展開する(この場合value値は無視される)
	var $SELECTTAG_MODE_NOTNULL = 128; //空白なしのプルダウンにする
	var $SELECTTAG_MODE_DISPCODE = 256; //プルダウン文字列は「コード：名称」

	var $buf = "";
	var $selected_text = "";

	var $param_filename;
	var $param_mode;
	var $param_defval;
	var $param_deftext;

	var $callback_func = "";

	function setCallback($proc){
		$this->callback_func = $proc;
	}

	function sub_proc(&$mode,&$ary,&$find_defval,&$selected,$defval,$deftext){
		if( $mode & $this->SELECTTAG_MODE_TEXTONLY ) $ary[0] = $ary[1];
		$selected = "";
		if( is_array($defval) ){
			$ary_defval = $defval;
			$ary_deftext = $deftext;
		}else{
			$ary_defval[0] = $defval;
			$ary_deftext[0] = $deftext;
		}

		//print "<!-- ary0 = {$ary[0]} : ary1 = {$ary[1]} : defval = $defval : deftext = $deftext -->\n";

		$rtn_cb = TRUE;
		$indent = "";
		if( $this->callback_func != "" ){
			eval('$rtn_cb = '.$this->callback_func.'($ary,$indent);');
		}
		if( $rtn_cb == TRUE ){
			//$deftextが渡された場合は、valueとtextの両方が一致するものを選択する
			//両方一致するものがない場合の選択優先順位: valueで一致するもの、textだけで一致するもの
			if( strlen($deftext) ){
				if( in_array($ary[0],$ary_defval) && $ary[0] != "" && in_array($ary[1],$ary_deftext) && $ary[1] != "" ){
					$selected = "selected";
					$this->selected_text = $ary[1];
					$find_defval = TRUE;
				}
				if( !$find_defval ){
					if( in_array($ary[0],$ary_defval) && $ary[0] != ""){
						$selected = "selected";
						$this->selected_text = $ary[1];
						$find_defval = TRUE;
					}
				}
				if( !$find_defval ){
					if( in_array($ary[1],$ary_deftext) && $ary[1] != ""){
						$selected = "selected";
						$this->selected_text = $ary[1];
						$find_defval = TRUE;
					}
				}
			}else{
				if( in_array($ary[0],$ary_defval) && $ary[0] != "" ){
					$selected = "selected";
					$this->selected_text = $ary[1];
					$find_defval = TRUE;
				}
			}
		}
		if( $rtn_cb == TRUE ){
			if( $indent ) $disp_indent = "　";
// htmlspecialchars対応 autotool_migration 20121214075930 
////			$this->buf .= "<option value=\"".htmlspecialchars($ary[0])."\" $selected>".htmlspecialchars($disp_indent);
//			$this->buf .= "<option value=\"".com_htmlspecialchars($ary[0])."\" $selected>".com_htmlspecialchars($disp_indent);
// htmlspecialchars対応 autotool_migration 20121214075930 
//			$this->buf .= "<option value=\"".htmlspecialchars($ary[0])."\" title=\"".htmlspecialchars($ary[1])."\" $selected>".htmlspecialchars($disp_indent);
			$this->buf .= "<option value=\"".com_htmlspecialchars($ary[0])."\" title=\"".com_htmlspecialchars($ary[1])."\" $selected>".com_htmlspecialchars($disp_indent);
			if( $mode & $this->SELECTTAG_MODE_DISPCODE && $ary[0] != "" ) $this->buf .= $ary[0].":";
			$this->buf .= "{$ary[1]}\n";
		}
	}

	function core_proc($filename, $mode = 1, $defval = "", $deftext = "", $out = TRUE){
		$this->BaseObject("SelectTag");
		$this->writeLog("SelectTag($filename,$mode,$defval,$deftext)");

		$buf = "";
		$selected_text = "";
		$find_defval = FALSE;

		if( $mode & $this->SELECTTAG_MODE_FILE ){
			$txt = new TextFile($filename);
			while( !$txt->eof() ){
				$ary = $txt->readCsvLine();
				if( count($ary) ){
					$this->sub_proc(&$mode,&$ary,&$find_defval,&$selected,$defval,$deftext);
				}
			}
			$txt->close();
		}

		if( $mode & $this->SELECTTAG_MODE_SQL ){
			$ora = new OraConnection();
			$cur = new OraCursor($ora->getConnection());
			if( $cur->open_ex($filename) ){
				while( $cur->get($rslt) ){
					$ary[0] = current($rslt);
					$ary[1] = next($rslt);
					$this->sub_proc(&$mode,&$ary,&$find_defval,&$selected,$defval,$deftext);
				}
			}
			$cur->close();
			$ora->close();
		}

		if( $mode & $this->SELECTTAG_MODE_ARRAY ){
			if( is_array($filename) && count($filename) ){
				foreach( $filename as $val => $temp_info ){
					//$ary[0] = $temp_info[0];
					//$ary[1] = $temp_info[1];
					$ary[0] = $temp_info["VALUE"];
					$ary[1] = $temp_info["TEXT"];
					$this->sub_proc(&$mode,&$ary,&$find_defval,&$selected,$defval,$deftext);
				}
			}
		}

		if( !$find_defval ){
			//$tmp = "<option value=\"$ary_defval[0]\" selected>$ary_defval[0]";
			//$this->buf = $tmp.$this->buf;
			if( strlen($deftext) ){
				if( $mode & $this->SELECTTAG_MODE_DISPCODE && $defval != "" ){
// htmlspecialchars対応 autotool_migration 20121214075930 
////					$tmp = "<option value=\"".htmlspecialchars($defval)."\" selected>".htmlspecialchars($defval).":".htmlspecialchars($deftext)."\n";
//					$tmp = "<option value=\"".com_htmlspecialchars($defval)."\" selected>".com_htmlspecialchars($defval).":".com_htmlspecialchars($deftext)."\n";
// htmlspecialchars対応 autotool_migration 20121214075930 
//					$tmp = "<option value=\"".htmlspecialchars($defval)."\" title=\"".htmlspecialchars($defval).":".htmlspecialchars($deftext)."\" selected>".htmlspecialchars($defval).":".htmlspecialchars($deftext)."\n";
					$tmp = "<option value=\"".com_htmlspecialchars($defval)."\" title=\"".com_htmlspecialchars($defval).":".com_htmlspecialchars($deftext)."\" selected>".com_htmlspecialchars($defval).":".com_htmlspecialchars($deftext)."\n";
				}else{
// htmlspecialchars対応 autotool_migration 20121214075930 
////					$tmp = "<option value=\"".htmlspecialchars($defval)."\" selected>".htmlspecialchars($deftext);
//					$tmp = "<option value=\"".com_htmlspecialchars($defval)."\" selected>".com_htmlspecialchars($deftext);
// htmlspecialchars対応 autotool_migration 20121214075930 
//					$tmp = "<option value=\"".htmlspecialchars($defval)."\" title=\"".htmlspecialchars($deftext)."\" selected>".htmlspecialchars($deftext);
					$tmp = "<option value=\"".com_htmlspecialchars($defval)."\" title=\"".com_htmlspecialchars($deftext)."\" selected>".com_htmlspecialchars($deftext);
				}
			}else{
				if( strlen($defval) ){
// htmlspecialchars対応 autotool_migration 20121214075930 
////					$tmp = "<option value=\"".htmlspecialchars($defval)."\" selected>".htmlspecialchars($defval);
//					$tmp = "<option value=\"".com_htmlspecialchars($defval)."\" selected>".com_htmlspecialchars($defval);
// htmlspecialchars対応 autotool_migration 20121214075930 
//					$tmp = "<option value=\"".htmlspecialchars($defval)."\" title=\"".htmlspecialchars($defval)."\" selected>".htmlspecialchars($defval);
					$tmp = "<option value=\"".com_htmlspecialchars($defval)."\" title=\"".com_htmlspecialchars($defval)."\" selected>".com_htmlspecialchars($defval);
				}
			}
			if( !($mode & $this->SELECTTAG_MODE_NOTNULL) ){
				$tmp2 = "<option>";
			}
			$this->buf = $tmp2.$tmp.$this->buf;
		}
		else{
			if( !($mode & $this->SELECTTAG_MODE_NOTNULL) ){
				$tmp = "<option>";
				$this->buf = $tmp.$this->buf;
			}
		}

		if( $out ) print $this->buf;
	}

	function SelectTag($filename, $mode = 1, $defval = "", $deftext = "", $out = TRUE){

		$this->param_filename = $filename;
		$this->param_mode = $mode;
		$this->param_defval = $defval;
		$this->param_deftext = $deftext;

		if( $out ){
			$this->core_proc($filename, $mode, $defval, $deftext);
		}
	}

	function get(){
		$this->core_proc($this->param_filename, $this->param_mode, $this->param_defval, $this->param_deftext, FALSE);
		return $this->buf;
	}

	function getSelectedText(){
		return $this->selected_text;
	}
}

//--------------------------------------------------------------------
//ログ記録共通関数インクルード
require("logwriter_helper.inc");
function CMN_LogEntry($log_type,$ary_user,$ary_class,$ary_operation,$ary_additional=""){
	CMN_log($GLOBALS["COMMON_LOG_WRITER_URL"],"project",$log_type,$ary_user,$ary_class,$ary_operation,$ary_additional);
}
//--------------------------------------------------------------------
?>
