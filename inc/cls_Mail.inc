<?php // autotool_migration 20121210120958 このファイルは自動化ツールにより編集されました ?>
<?php require_once('ADFlib/global_reg_emu.inc.php'); ?>
<?php require_once('ADFlib/func_Common.inc.php'); ?>
<?php
//############################################################################
// cls_Mail.inc 2002/11
//############################################################################
// PHPメール送信用クラス
// 使用例：
// $sm = new SendMimeMail();
// $sm->addTo("to_unknown@dmy.co.jp","送信先");
// $sm->setFrom("from_unknown@dmy.co.jp","送信元");
// $sm->setSubject("メール件名");
// $sm->setMessage("メール本文");
// $sm->make();
// $sm->send();
//############################################################################
// 公開メソッド
//############################################################################
// SendMimeMail($id_string,$smtp_address)
// 本クラスのコンストラクタ。
// id_string(省略可能):
// 	添付ファイルがある場合は、なんらかの識別用文字列を指定することを推奨。
// 	マルチパートメッセージのセパレータ文字列に使用する。
// smtp_address(省略可能):
//	省略された場合、mail()関数を使用して送信する。この場合、sendmailなど
//	のメール送信用プログラムが必要となる。
//	(詳細は、PHPマニュアルのmail()関数を参照)
//	smtp_addressが指定された場合は、mail()関数ではなく、SMTPサーバに直接
//	通信を行う。(ただしPORT:25、認証なし)
//	この際、PHP添付のPEARライブラリのNet/SMTP.php,Net/Socket.phpを使用する
//----------------------------------------------------------------------------
// addTo/addCc($mail_addr, $disp_name ,$header_only)
// メールの宛先を追加する。
// mail_addr:
// 	メールアドレスを指定。
// disp_name(省略可能):
// 	宛先の名称などを指定(マルチバイト文字列も使用可能)。
// header_only(省略可能):
// TOやCCに名前を連ねるだけで実際に送付しない宛先にはtrueを指定する
//----------------------------------------------------------------------------
// setFrom($mail_addr, $disp_name)
// メールの送信元を指定する。
// mail_addr:
// 	メールアドレスを指定。
// disp_name(省略可能):
// 	宛先の名称などを指定(マルチバイト文字列も使用可能)。
//----------------------------------------------------------------------------
// setReplyTo($mail_addr)
// 返信先のアドレスを設定。
// mail_addr:
// 	メールアドレスを指定。
//----------------------------------------------------------------------------
// setSubject($subject)
// メールの件名を設定
// subject:
// 	メールの件名文字列を指定(マルチバイト文字列も使用可能)
//----------------------------------------------------------------------------
// setAdditionalHeader($header_str)
// 任意のヘッダ文字列を追加する
// header_str：
// 	メールヘッダ用に整形された文字列を指定する必要あり。
// 	Asciiコード7bitに含まれる文字のみ使用可能であり、
// 	その他の文字は適切にエンコードすること。
//----------------------------------------------------------------------------
// setMessage($message, $split_length)
// メールの本文を設定
// message：
// 	メールの本文を指定(マルチバイト文字列も使用可能)
// split_length(省略可能)：
// 	指定された文字数で本文を自動的に改行する。
// 	省略された場合は76文字で改行する。
// 	0が指定された場合、改行処理は行われない。
//----------------------------------------------------------------------------
// addAttachFile($file_path, $disp_name)
// メールに添付ファイルを追加する
// file_path：
// 	添付するファイルをフルパスで指定する。
// disp_name(省略可能)：
// 	添付ファイルの名前やファイル名を指定する。
// 	省略された場合は、file_pathで指定されたファイル名を使用する。
//----------------------------------------------------------------------------
// addAttachFileByString($text_str, $disp_name)
// メールに添付ファイルを追加する
// text_str：
// 	添付するファイルの内容を指定する。
// disp_name(省略可能)：
// 	添付ファイルの名前やファイル名を指定する。
// 	省略された場合は、file_pathで指定されたファイル名を使用する。
//----------------------------------------------------------------------------
// make()
// 送信用のメールメッセージを作成する。
// sendメソッドの直前に実行する必要がある。
//----------------------------------------------------------------------------
// send()
// メールを送信する。
//############################################################################
// デバッグ用メソッド
//############################################################################
// getHeader()
// メール送信に使用されるヘッダ部を取得する。
//----------------------------------------------------------------------------
// getBody()
// メール送信に使用されるボディ部を取得する。
//############################################################################

Class SendMimeMail{

	//multipartのセパレータ
	var $PART_SEP = "";
	var $SMTP_ADDR = "";
	var $SMTP_TIMEOUT = 3;

	//mail()関数へのパラメータ
	var $BUF_TO = "";
	var $BUF_SUBJECT = "";
	var $BUF_HEADER = "";
	var $BUF_BODY = "";

	//パラメータの受け取り用
	var $ARY_TO = array();
	var $ARY_CC = array();
	var $ARY_TO_DMY = array(); //実際にはメールを送信しないが、メールヘッダには書き込む宛先
	var $ARY_CC_DMY = array(); //実際にはメールを送信しないが、メールヘッダには書き込む宛先
	var $MESSAGE = "";
	var $HEADER_CC = "";
	var $HEADER_BCC = "";
	var $HEADER_FROM = "";
	var $HEADER_ERRROS_TO = "";
	var $HEADER_REPLY_TO = "";
	var $HEADER_RETURN_PATH = "";
	var $HEADER_SEDNER = "";
	var $HEADER_USER_ADDITIONAL = "";
	var $ARY_ATTACH = array();
	var $ARY_ATTACH_STR = array();

	///////////////////////////////////////////////////////////////////////////
	//各パラメータの受け取り

	function SendMimeMail($id_string="",$smtp_address="",$smtp_timeout=3){
		$this->PART_SEP = "--=MULTI_PART_$id_string".md5(uniqid(rand(),1));
		$this->SMTP_ADDR = $smtp_address;
		$this->SMTP_TIMEOUT = $smtp_timeout;
		if( $this->SMTP_ADDR == "" ) $this->SMTP_ADDR = $GLOBALS["CLS_MAIL_SMTP_ADDR"];
	}

	function addTo($mail_addr, $disp_name="", $header_only=false){
		if( !$header_only ){
			if( $tmp = $this->p_make_mail_entry($mail_addr,$disp_name) ) array_push($this->ARY_TO,$tmp);
			//print "<hr>addTo ".count($this->ARY_TO);
		}else{
			if( $tmp = $this->p_make_mail_entry($mail_addr,$disp_name) ) array_push($this->ARY_TO_DMY,$tmp);
			//print "<hr>addTo dummy";
		}
	}

	function addCc($mail_addr, $disp_name="", $header_only=false){
		if( !$header_only ){
			if( $tmp = $this->p_make_mail_entry($mail_addr,$disp_name) ) array_push($this->ARY_CC,$tmp);
			//print "<hr>addCc ".count($this->ARY_CC);
		}else{
			if( $tmp = $this->p_make_mail_entry($mail_addr,$disp_name) ) array_push($this->ARY_CC_DMY,$tmp);
			//print "<hr>addCc dummy";
		}
	}

	function setFrom($mail_addr, $disp_name=""){
		$this->HEADER_FROM = $this->p_make_mail_entry($mail_addr,$disp_name);
		if( !strlen($this->$HEADER_SENDER) ) $this->HEADER_SENDER = $mail_addr;
		if( !strlen($this->$HEADER_RENTURN_PATH) ) $this->HEADER_RENTURN_PATH = $mail_addr;
		if( !strlen($this->$HEADER_ERRORS_TO) ) $this->HEADER_ERRORS_TO = $mail_addr;
		if( !strlen($this->$HEADER_REPLY_TO) ) $this->HEADER_REPLY_TO = $mail_addr;
	}

	function setReplyTo($mail_addr){
		$this->HEADER_REPLY_TO = $mail_addr;
	}

	function setAdditionalHeader($header_str){
		$this->HEADER_USER_ADDITIONAL = $header_str;
	}

	function setSubject($subject){
		$this->BUF_SUBJECT = mb_encode_mimeheader($subject,"ISO-2022-JP");
	}

	function setMessage($message,$split_length=76){
		$this->MESSAGE = mb_convert_encoding($message,'JIS');
	}

	function addAttachFile($file_path, $disp_name=""){
		if( strlen($file_path) && file_exists($file_path) ){
			if( strlen($disp_name) ){
				$ary = array($file_path => $disp_name);
			}
			else{
// basename対応 autotool_migration 20121210120958 
//				$ary = array($file_path => basename($file_path));
				$ary = array($file_path => com_basename($file_path));
			}
			array_push($this->ARY_ATTACH,$ary);
		}
	}

	function addAttachFileByString(&$text_str, $disp_name){
		return addAttachFileByString(&$test_str, $disp_name);
	}
	function addAtachFileByString(&$text_str, $disp_name){
		if( strlen($text_str) && strlen($disp_name) ){
			$ary = array($disp_name => $text_str);
			array_push($this->ARY_ATTACH_STR,$ary);
		}
	}

	///////////////////////////////////////////////////////////////////////////
	//メールのソースの取得

	function getHeader(){
		$rtn = "";
		$rtn .= "To: ".$this->BUF_TO."\r\n";
		$rtn .= "Subject: ".$this->BUF_SUBJECT."\r\n";
		$rtn .= $this->BUF_HEADER;
		return $rtn;
	}

	function getBody(){
		$rtn = "";
		$rtn .= $this->BUF_BODY;
		return $rtn;
	}

	///////////////////////////////////////////////////////////////////////////
	//メールの作成、送信

	function make(){
		$this->BUF_TO = $this->p_make_addr_list($this->ARY_TO);
		$this->BUF_HEADER = $this->p_make_header();
		$this->BUF_BODY = $this->p_make_body();
	}

	function send(){
		if( count($this->ARY_TO)+count($this->ARY_CC) == 0 ){
			//print "<hr>No Reciepient!";
			return false;
		}
		if( strlen($this->SMTP_ADDR) == 0 ){
			//PHPのmail()関数で送信
			//print "<hr>PHP mail function";
			return mail($this->BUF_TO,$this->BUF_SUBJECT,$this->BUF_BODY,$this->BUF_HEADER);
		}else{
			//PEARライブラリのMail.phpで、smtpモードで送信
			//print "<hr>PEAR library SMTP mail";
			@include_once 'Net/SMTP.php';
	        if( class_exists('Net_SMTP') ){
				$smtp = new Net_SMTP($this->SMTP_ADDR,25);
				if( !PEAR::isError($smtp->connect($this->SMTP_TIMEOUT)) ){
					$from = preg_replace("/.*<(.*)>.*/s","\\1",$this->HEADER_FROM);
					$smtp->mailFrom($from);
					foreach( $this->ARY_TO as $to ){
						$to = preg_replace("/.*<(.*)>.*/s","\\1",$to);
						$smtp->rcptTo($to);
					}
					foreach( $this->ARY_CC as $cc ){
						$cc = preg_replace("/.*<(.*)>.*/s","\\1",$cc);
						$smtp->rcptTo($cc);
					}
					$smtp->data($this->getHeader()."\n".$this->getBody());
					$smtp->disconnect();
					return TRUE;
				}
				else{
					//print "<hr>メールサーバ(".$this->SMTP_ADDR.")に接続できません。<hr>";
				}
			}
		}
	}

	///////////////////////////////////////////////////////////////////////
	//これより下は、プライベート関数

	//メールヘッダの作成
	function p_make_header(){
		$this->BUF_HEADER = "";
		if( strlen($this->HEADER_USER_ADDITIONAL) ){
			$this->p_add_header($this->HEADER_USER_ADDITIONAL);
		}
		if( count($this->ARY_TO_DMY) ){
			$this->p_add_header($this->p_make_header_line
				("To",$this->p_make_addr_list($this->ARY_TO_DMY)));
		}
		$ARY_CC_HEAD = array_merge($this->ARY_CC,$this->ARY_CC_DMY);
		if( count($ARY_CC_HEAD) ){
			$this->p_add_header($this->p_make_header_line
				("Cc",$this->p_make_addr_list($ARY_CC_HEAD)));
		}
		$this->p_add_header($this->p_make_header_line
			("From",$this->HEADER_FROM));
		$this->p_add_header($this->p_make_header_line
			("Return-path",$this->HEADER_RETURN_PATH));
		$this->p_add_header($this->p_make_header_line
			("Sender",$this->HEADER_SENDER));
		$this->p_add_header($this->p_make_header_line
			("Errors-to",$this->HEADER_ERRORS_TO));
		$this->p_add_header($this->p_make_header_line
			("Reply-to",$this->HEADER_REPLY_TO));
		if( count($this->ARY_ATTACH) || count($this->ARY_ATTACH_STR) ){
			$this->p_add_header($this->p_make_header_line
				("MIME-version","1.0"));
			$this->p_add_header($this->p_make_header_line
				("Content-type","multipart/mixed; boundary=\"".$this->PART_SEP."\""," "));
		}else{
			$this->p_add_header($this->p_make_header_line
				("Content-type","text/plain; charset=\"ISO-2022-JP\""));
			$this->p_add_header($this->p_make_header_line
				("Content-transfer-encoding","7bit;"));
		}
		//$this->p_add_header($this->p_make_header_line
		//	("Status","   "),TRUE);
		return $this->BUF_HEADER;
	}

	//メールボディの作成
	function p_make_body(){
		$SEP = "--".$this->PART_SEP;
		$this->BUF_BODY = "";
		//添付ファイルが指定された場合は、multipart形式にする
		if( count($this->ARY_ATTACH) || count($this->ARY_ATTACH_STR) ){
			$this->p_add_body("This is a multi-part message in MIME format.");
			$this->p_add_body("");
			$this->p_add_body($SEP);
			$this->p_add_body($this->p_make_header_line
				("Content-type","text/plain; charset=\"ISO-2022-JP\""));
			$this->p_add_body("");
			$this->p_add_body($this->MESSAGE);
			$this->p_add_body("");
			$this->p_add_body("");
			//ファイルから添付
			foreach( $this->ARY_ATTACH as $ary_file ){
				$this->p_add_body($SEP);
				$this->p_add_body($this->p_make_header_line
					("Content-type","application/octet-stream; name=\"".mb_encode_mimeheader(current($ary_file),"ISO-2022-JP")."\""," "));
				$this->p_add_body($this->p_make_header_line
					("Content-disposition","attachment; filename=\"".mb_encode_mimeheader(current($ary_file),"ISO-2022-JP")."\""," "));
				$this->p_add_body($this->p_make_header_line
					("Content-transfer-encoding","base64"));
				$this->p_add_body("");
				$this->p_add_body($this->p_encode_attach_file(key($ary_file)));
				$this->p_add_body("");
			}
			//文字列から添付
			foreach( $this->ARY_ATTACH_STR as $ary_text ){
				$this->p_add_body($SEP);
				$this->p_add_body($this->p_make_header_line
					("Content-type","application/octet-stream; name=\"".mb_encode_mimeheader(key($ary_text),"ISO-2022-JP")."\""," "));
				$this->p_add_body($this->p_make_header_line
					("Content-disposition","attachment; filename=\"".mb_encode_mimeheader(key($ary_text),"ISO-2022-JP")."\""," "));
				$this->p_add_body($this->p_make_header_line
					("Content-transfer-encoding","base64"));
				$this->p_add_body("");
				$tmp_data = current($ary_text);
				$this->p_add_body($this->p_encode_attach_file_data($tmp_data));
				$this->p_add_body("");
			}
			$this->p_add_body($SEP."--",TRUE);
		}
		//添付ファイルなしの場合は、そのまま本文を追加
		else{
			$this->p_add_body($this->MESSAGE);
		}
		return $this->BUF_BODY;
	}

	//「宛先 <アドレス>」形式文字列をカンマ＋空白＋CRLFでつなげる
	function p_make_addr_list($ary_addr){
		$rtn = "";
		if( count($ary_addr) ){
			foreach( $ary_addr as $val ){
				$rtn .= strlen($rtn) ? ", \r\n ".$val : $val;
			}
		}
		return $rtn;
	}

	//メールヘッダ行を作成(複数行にする場合は、split_charを指定する)
	function p_make_header_line($header_name,$header_value,$split_char=""){
		$rtn = "";
		if( strlen($header_name) ){
			$rtn .= $header_name.": ";
			$val = "";
			if( strlen($split_char) ){
				$ary_tmp = preg_split("/".$split_char."/",$header_value);
				$val = join($split_char."\r\n ",$ary_tmp);
			}
			else{
				$val = $header_value;
			}
			$rtn .= $val;
		}
		return $rtn;
	}

	//メールヘッダに追加
	function p_add_header($header_line,$no_crlf=FALSE){
		if( strlen($header_line) ){
			$this->BUF_HEADER .= $header_line.($no_crlf ? "" : "\r\n");
		}
	}

	//ボディに追加
	function p_add_body($line,$no_crlf=FALSE){
		$this->BUF_BODY .= $line.($no_crlf ? "" : "\r\n");
	}

	//添付ファイルをエンコードする
	function p_encode_attach_file($file_path){
		$rtn = "";
		if( strlen($file_path) && file_exists($file_path) ){
			$fd = fopen ($file_path, "r");
			$rtn = fread($fd, filesize($file_path));
			fclose($fd);
			//$rtn = chunk_split(base64_encode($rtn));
			$rtn = $this->p_encode_attach_file_data($rtn);
		}
		return $rtn;
	}
	function p_encode_attach_file_data(&$data_stream){
		$rtn = chunk_split(base64_encode($data_stream));
		return $rtn;
	}

	//「宛先 <アドレス>」形式文字列を作成
	function p_make_mail_entry($mail_addr, $disp_name){
		$rtn = "";
		if( strlen($mail_addr) ){
			if( strlen($disp_name) ){
				$rtn = mb_encode_mimeheader($disp_name,"ISO-2022-JP")." <".$mail_addr.">";
			}
			else{
				$rtn = $mail_addr;
			}
		}
		return $rtn;
	}
}
// cls_Mail.inc
//############################################################################
?>
