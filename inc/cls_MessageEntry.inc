<?php // autotool_migration 20121210120958 このファイルは自動化ツールにより編集されました ?>
<?php require_once('ADFlib/global_reg_emu.inc.php'); ?>
<?php
//ﾒｯｾｰｼﾞﾝｸﾞ連携用クラス

function MessageEntry_fetch_error_handler($errno, $errmsg, $filename, $linenum, $vars){

	//「フェッチ順序が無効」のみ無視する
	if( stristr($errmsg,"ORA-01002") ) return;

	$err_str = "ERR: $errno $errmsg $filename $linenum";
	switch( $errno ){
	case E_STRICT:
		break;
	case E_NOTICE:
		break;
	case E_WARNING:
		break;
	default:
		$tmp_enc = mb_detect_encoding($err_str);
		if( $tmp_enc != "EUC-JP" ){
			$err_str = mb_convert_encoding($err_str,"EUC-JP",$tmp_enc);
		}
		print "<hr><b>エラーが発生しました。実行を中断します。</b><br>\n";
		print "<div>$err_str</div>";
		exit;
	}
}

/**
 * メッセージング連携用クラス
 *
 * 2009.12.16 ADF)tomoyuki.sato 処理済処理変更、既読処理追加、削除処理を処理済処理に変更（削除無）
 * 2010.01.25 ADF)tomoyuki.sato BNV_SET_MSG_LINK_IDのパラメータにタブキーを追加
 * 								setSystemName(システム名称追加設定メソッド)追加
 * @version 1.1.0
 * @author ADF)tomoyuki.sato
 */
class MessageEntry extends BaseObject {
	var $ora_user;
	var $ora_passwd;
	var $ora_server;
	var $ora_charset;
	var $ora_encode = "SJIS";	//大抵はSJISのはず

	var $con;
	var $msg_id;
	var $type_code;
	var $user_id;
	var $ary_key = array();
	var $repeat_cnt = 0;
	var $finished_msg_flg; //処理済を行なったときtrueとなる
	var $system_name;

	/**
	 * コンストラクタ
	 *
	 */
	function MessageEntry($type_code,&$ary_key,$user_id){
		$this->type_code = $type_code;
		$this->ary_key = $ary_key;
		$this->user_id = $user_id;
		$this->finished_msg_flg = false;	//2009.12.16 add ADF)tomoyuki.sato

		//オラクル接続情報（デフォルト）
		$this->ora_user = $GLOBALS["COMMON_MESSAGE_ORA_USER"];
		$this->ora_passwd = $GLOBALS["COMMON_MESSAGE_ORA_PASSWD"];
		$this->ora_server = $GLOBALS["COMMON_MESSAGE_ORA_SERVER"];
		$this->ora_charset = $GLOBALS["COMMON_MESSAGE_ORACLE_SERVER_CHARSET"];	//JA16SJIS,JA16EUC,AL32UTF8,UTF8など
	}

	/**
	 * 新規メッセージＩＤ取得メソッド
	 *
	 * 2009.12.16 ADF)tomoyuki.sato 既存のメッセージは処理済とし、常に新しいメッセージＩＤを取得するよう変更
	 * 2010.01.25 ADF)tomoyuki.sato BNV_SET_MSG_LINK_IDのパラメータにタブキーを追加
	 */
	function entryStart($finish_contents="",$tabkey="0"){
		if( !$this->con ) $this->OracleConnect();
		//if( !strlen($this->msg_id) ) $this->Msgid(); //del 2009/12/16 ADF)tomoyuki.sato
		$this->getNewMsgId();		//add 2009/12/16 ADF)tomoyuki.sato
		$SQL=<<<SQL
		declare
			rtn number;
		begin
			rtn := BNV_FINISHED_LINK_MSG('{$this->type_code}','{$this->user_id}','','{$finish_contents}','{$this->ary_key[0]}','{$this->ary_key[1]}','{$this->ary_key[2]}','{$this->ary_key[3]}','{$this->ary_key[4]}');--add 2009/12/16 ADF)tomoyuki.sato
			--rtn := BNV_BEGIN_MSG_ENTRY('{$this->msg_id}','{$this->type_code}','{$this->user_id}');
			rtn := BNV_INIT_MSG('{$this->msg_id}','{$this->type_code}','{$this->user_id}');
			--rtn := BNV_SET_MSG_LINK_ID('{$this->msg_id}','{$this->type_code}','{$this->user_id}','{$this->ary_key[0]}','{$this->ary_key[1]}','{$this->ary_key[2]}','{$this->ary_key[3]}','{$this->ary_key[4]}');			--del 2010/01/25 ADF)tomoyuki.sato
			rtn := BNV_SET_MSG_LINK_ID('{$this->msg_id}','{$this->type_code}','{$this->user_id}','{$this->ary_key[0]}','{$this->ary_key[1]}','{$this->ary_key[2]}','{$this->ary_key[3]}','{$this->ary_key[4]}','$tabkey');	--add 2010/01/25 ADF)tomoyuki.sato
		end;
SQL;
		$this->OracleExecute($SQL);
	}

	function entryEnd(){
		$SQL=<<<SQL
		declare
			rtn number;
		begin
			rtn := END_MSG_ENTRY('{$this->msg_id}');
			if '{$this->system_name}' is not null then
				rtn := BNV_SET_SYSTEM_NAME('{$this->msg_id}','{$this->system_name}','{$this->user_id}');
			end if;
		end;
SQL;
		$this->OracleExecute($SQL);
		//$this->OraCommit();

		$rtn = $this->MsgResult();
		//print "<!--MSG_ID:".$this->msg_id." -> ".$rtn."-->";
		return $rtn;
	}

	function setBno($bno){
		$SQL=<<<SQL
		declare
			rtn number;
		begin
			rtn := BNV_SET_BNO('{$this->msg_id}','{$bno}','{$this->user_id}');
		end;
SQL;
		$this->OracleExecute($SQL);
	}

	function setSendYN($flg){
		if($flg=="Y"){
			$func_name = "BNV_SET_SEND";
		}else{
			$func_name = "BNV_SET_NOSEND";
		}
		$SQL=<<<SQL
		declare
			rtn number;
		begin
			rtn := {$func_name}('{$this->msg_id}','{$this->user_id}');
		end;
SQL;
		$this->OracleExecute($SQL);
	}

	function setFromUser($from_user_id){
		$SQL=<<<SQL
		declare
			rtn number;
		begin
			rtn := BNV_SET_FROM_USER('{$this->msg_id}','{$from_user_id}','{$this->user_id}');
		end;
SQL;
		$this->OracleExecute($SQL);
	}

	function setToUser($send_user_id){
		$SQL=<<<SQL
		declare
			rtn number;
		begin
			rtn := BNV_SET_RECEIVE_USER_LIST('{$this->msg_id}','{$send_user_id}','To','{$this->user_id}');
		end;
SQL;
		$this->OracleExecute($SQL);
	}

	function setCcUser($send_user_id){
		$SQL=<<<SQL
		declare
			rtn number;
		begin
			rtn := BNV_SET_RECEIVE_USER_LIST('{$this->msg_id}','{$send_user_id}','Cc','{$this->user_id}');
		end;
SQL;
		$this->OracleExecute($SQL);
	}

	function setBccUser($send_user_id){
		$SQL=<<<SQL
		declare
			rtn number;
		begin
			rtn := BNV_SET_RECEIVE_USER_LIST('{$this->msg_id}','{$send_user_id}','Bcc','{$this->user_id}');
		end;
SQL;
		$this->OracleExecute($SQL);
	}
	function resetSendUser(){
		$SQL=<<<SQL
		declare
			rtn number;
		begin
			rtn := RESET_RECEIVE_USER_LIST('{$this->msg_id}','{$this->user_id}');
		end;
SQL;
		$this->OracleExecute($SQL);
	}

	function setRepWord(&$ary_word){
		$func = "";
		if( count($ary_word) ){
			foreach($ary_word as $idx => $val){
				$set_no = $idx + 1;
				$val = preg_replace("/'/","''",$val);
				$func .= "rtn := BNV_SET_CONVSTR_DATA('{$this->msg_id}','{$set_no}','{$val}','{$this->user_id}');\n";
			}
			$SQL=<<<SQL
			declare
				rtn number;
			begin
				$func
			end;
SQL;
			$this->OracleExecute($SQL);
		}
	}

	function setRepeatRepWord(&$ary_word){
		$this->repeat_cnt++;
		$func = "";
		if( count($ary_word) ){
			foreach($ary_word as $idx => $val){
				$set_no = $idx + 1;
				$val = preg_replace("/'/","''",$val);
				$func .= "rtn := BNV_SET_REPCONV_DATA('{$this->msg_id}','{$this->repeat_cnt}','{$set_no}','{$val}','{$this->user_id}');\n";
			}
			$SQL=<<<SQL
			declare
				rtn number;
			begin
				$func
			end;
SQL;
			$this->OracleExecute($SQL);
		}
	}

	/**
	 * 処理済メソッド
	 *
	 * 2009.12.16 ADF)tomoyuki.sato メッセージキーに一致するメッセージを処理済にするよう変更
	 */
	function FinishedMsg($finish_contents="",$tab_key=""){
		if( !$this->con ) $this->OracleConnect();
		//if( !strlen($this->msg_id) ) $this->Msgid();	//2009.12.16 del ADF)tomoyuki.sato
		$SQL=<<<SQL
		declare
			rtn number;
		begin
			--rtn := SET_MSG_FINISHED('{$this->msg_id}','{$this->user_id}');
			rtn := BNV_FINISHED_MY_LINK_MSG('{$this->type_code}','{$this->user_id}','{$tab_key}','{$finish_contents}','{$this->ary_key[0]}','{$this->ary_key[1]}','{$this->ary_key[2]}','{$this->ary_key[3]}','{$this->ary_key[4]}');
		end;
SQL;
		$this->OracleExecute($SQL);

		$this->finished_msg_flg = true;	//2009.12.16 add ADF)tomoyuki.sato
		$rtn = $this->MsgResult();
		//print "<!--MSG_ID:".$this->msg_id." -> ".$rtn."-->";
		return $rtn;
	}

	/**
	 * 処理済メソッド(ユーザー指定)
	 *
	 * 2009.12.16 ADF)tomoyuki.sato メッセージキーに一致するメッセージを処理済にするよう変更
	 */
	function FinishedUserMsg($send_user_id,$finish_contents="",$tab_key=""){
		if( !$this->con ) $this->OracleConnect();
		//if( !strlen($this->msg_id) ) $this->Msgid();	//2009.12.16 del ADF)tomoyuki.sato
		$SQL=<<<SQL
		declare
			rtn number;
		begin
			--rtn := SET_MSG_FINISHED('{$this->msg_id}','{$send_user_id}');
			rtn := BNV_FINISHED_MY_LINK_MSG('{$this->type_code}','{$send_user_id}','{$tab_key}','{$finish_contents}','{$this->ary_key[0]}','{$this->ary_key[1]}','{$this->ary_key[2]}','{$this->ary_key[3]}','{$this->ary_key[4]}');
		end;
SQL;
		$this->OracleExecute($SQL);

		$this->finished_msg_flg = true;	//2009.12.16 add ADF)tomoyuki.sato
		$rtn = $this->MsgResult();
		//print "<!--MSG_ID:".$this->msg_id." -> ".$rtn."-->";
		return $rtn;
	}

	/**
	 * 処理済メソッド
	 *
	 * 2009.12.16 ADF)tomoyuki.sato メッセージキーに一致するメッセージを処理済にするよう変更
	 */
	function FinishedAllMsg($finish_contents="",$tab_key=""){
		if( !$this->con ) $this->OracleConnect();
		//if( !strlen($this->msg_id) ) $this->Msgid();	//2009.12.16 del ADF)tomoyuki.sato
		$SQL=<<<SQL
		declare
			rtn number;
		begin
			--rtn := SET_MSG_MSGFINISHED('{$this->msg_id}','{$this->user_id}');
			rtn := BNV_FINISHED_LINK_MSG('{$this->type_code}','{$this->user_id}','{$tab_key}','{$finish_contents}','{$this->ary_key[0]}','{$this->ary_key[1]}','{$this->ary_key[2]}','{$this->ary_key[3]}','{$this->ary_key[4]}');
		end;
SQL;
		$this->OracleExecute($SQL);

		$this->finished_msg_flg = true;	//2009.12.16 add ADF)tomoyuki.sato
		$rtn = $this->MsgResult();
		//print "<!--MSG_ID:".$this->msg_id." -> ".$rtn."-->";
		return $rtn;
	}

	/**
	 * クリアメソッド
	 *
	 * 2009.12.16 ADF)tomoyuki.sato 処理済メソッドに変換
	 */
	function clearMsg($finish_contents="",$tab_key=""){

//		if( !$this->con ) $this->OracleConnect();
//		if( !strlen($this->msg_id) ) $this->Msgid();
//		$SQL=<<<SQL
//		declare
//			rtn number;
//		begin
//			rtn := CLEAR_MSG('{$this->msg_id}','{$this->user_id}');
//		end;
//SQL;
//		$this->OracleExecute($SQL);
//		//$this->OraCommit();
//
//		//$rtn = $this->MsgResult();
//		//print "<!--MSG_ID:".$this->msg_id." -> ".$rtn."-->";
//		//return $rtn;
//		return 1;
		return $this->FinishedAllMsg($finish_contents,$tab_key);
	}

	function clearBnoMsg($bno){
		if( !$this->con ) $this->OracleConnect();
		$SQL=<<<SQL
		declare
			rtn number;
		begin
			rtn := CLEAR_BNOMSG('{$bno}','{$this->user_id}');
		end;
SQL;
		$this->OracleExecute($SQL);
		//$this->OraCommit();

		//$rtn = $this->MsgResult();
		//return $rtn;
		return 1;
	}

	/**
	 * システム名称設定メソッド
	 *
	 * 2010.01.25 ADF)tomoyuki.sato クラスに追加
	 */
	function setSystemName($system_name){
		$this->system_name = $system_name;
	}

	function setOraConnection($user,$passwd,$oracle){
		$this->ora_user = $user;
		$this->ora_passwd = $passwd;
		$this->ora_server = $oracle;
	}

	function setOraCharset($charset){
		$this->ora_charset = $charset;
	}

	function setOraEncode($encode){
		$this->ora_encode = $encode;
	}

	function commit(){
		$this->OraCommit();
	}

	function rollback(){
		$this->OraRollback();
	}
	////////////////////////////////////////////////////////////////
	// 内部関数
	function Msgid(){
		$SQL_ID = "select GET_MSG_LINK_ID('{$this->type_code}','{$this->ary_key[0]}','{$this->ary_key[1]}','{$this->ary_key[2]}','{$this->ary_key[3]}','{$this->ary_key[4]}') MSG_ID from dual";
		$rec = $this->getResultData($SQL_ID);
		$this->msg_id = $rec["MSG_ID"];
	}
	/**
	 * 新規メッセージＩＤ取得メソッド
	 *
	 * 2009.12.16 ADF)tomoyuki.sato
	 */
	function getNewMsgId(){
		$SQL_ID = "select GET_MSG_ID() MSG_ID from dual";
		$rec = $this->getResultData($SQL_ID);
		$this->msg_id = $rec["MSG_ID"];
	}
	/**
	 * メッセージ操作結果取得メソッド
	 *
	 * 2009.12.16 ADF)tomoyuki.sato 処理済の場合は常に成功を返す
	 */
	function MsgResult(){
		if($this->finished_msg_flg){	//2009.12.16 add ADF)tomoyuki.sato
			return 1;					//2009.12.16 add ADF)tomoyuki.sato
		}else{
			$SQL_RSLT = "select GET_ENTRY_RESULT('{$this->msg_id}') MSG_RSLT from dual";
			$rec = $this->getResultData($SQL_RSLT);
			return $rec["MSG_RSLT"];
		}
	}
	function OracleConnect(){
		$this->con = oci_new_connect($this->ora_user,$this->ora_passwd,$this->ora_server);
	}
	function OracleFetch($cur){
		return (oci_fetch($cur)?TRUE:FALSE);
	}
	function OracleFetchArray(&$cur,&$rslt){
		$results = oci_fetch_array($cur,OCI_ASSOC|OCI_RETURN_NULLS);
		if( $results ){
			if( $this->ora_encode && count($results) ){
				$rslt = array();
				foreach( $results as $key => $val ){
//					$tmp1 = mb_convert_encoding($key,"EUC-JP",$this->ora_encode);
//					$tmp2 = mb_convert_encoding($val,"EUC-JP",$this->ora_encode);
					$tmp1 = mb_convert_encoding($key,"CP51932",$this->ora_encode);
					$tmp2 = mb_convert_encoding($val,"CP51932",$this->ora_encode);
					$rslt[$tmp1] = $tmp2;
				}
			}
			return TRUE;
		}else{
			return FALSE;
		}
	}

	/**
	 * データ取得メソッド（単一レコード）
	 *
	 * 2010.01.07 ADF)tomoyuki.sato ログ出力処理の追加
	 */
	function getResultData(&$sql){
		$result = "";
		$this->BaseObject("getResultData");		//2010.01.07 add ADF)tomoyuki.sato
		$this->writeLog("getResultData()");		//2010.01.07 add ADF)tomoyuki.sato
		$this->writeLog("oci_execute($sql)");	//2010.01.07 add ADF)tomoyuki.sato
		$cur = oci_parse($this->con,$this->convert_sql_charcode($sql));
		if( oci_execute($cur,OCI_DEFAULT) ){
			$tmp = set_error_handler("MessageEntry_fetch_error_handler");
			$this->OracleFetchArray($cur,$result);
			$dmy = set_error_handler($tmp);
		}
		return $result;
	}
	function getResultDataArray(&$sql,&$ary){
		$result = "";
		$cur = oci_parse($this->con,$this->convert_sql_charcode($sql));
		if( oci_execute($cur,OCI_DEFAULT) ){
			while(1){
				$tmp = set_error_handler("MessageEntry_fetch_error_handler");
				if( !$this->OracleFetchArray($cur,$result) ) break;
				$dmy = set_error_handler($tmp);
				$ary[count($ary)] = $result;
			}
		}
	}

	/**
	 * データ登録メソッド
	 *
	 * 2010.01.07 ADF)tomoyuki.sato ログ出力処理の追加
	 */
	function OracleExecute(&$sql){
//print "<!--\n$sql\n-->";
		$this->BaseObject("OracleExecute");		//2010.01.07 add ADF)tomoyuki.sato
		$this->writeLog("OracleExecute()");		//2010.01.07 add ADF)tomoyuki.sato
		$this->writeLog("oci_execute($sql)");	//2010.01.07 add ADF)tomoyuki.sato
		$cur = oci_parse($this->con,$this->convert_sql_charcode($sql));
		oci_execute($cur,OCI_DEFAULT);	//コミット無
	}
	function OraCommit(){
		oci_commit($this->con);
		oci_close($this->con);
	}
	function OraRollback(){
		oci_rollback($this->con);
		oci_close($this->con);
	}
	function convert_sql_charcode(&$sql){
		//PHPソースはEUCが前提
		switch( $this->ora_charset ){
		case "JA16SJIS":
			$charset = "sjis-win";
			break;
		case "JA16EUC":
//			$charset = "eucjp-win";
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
//		return mb_convert_encoding($sql,$charset,"eucjp-win");
		return mb_convert_encoding($sql,$charset,"CP51932");
	}
}
?>
