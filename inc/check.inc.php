<?php // autotool_migration 20121210120958 このファイルは自動化ツールにより編集されました ?>
<?php require_once('ADFlib/global_reg_emu.inc.php'); ?>
<?php
/*
$text = "999.000000";
InputCheck_Number2($text);
print $GLOBALS["INPUTCHECK_ERROR_MESSAGE"];
*/
?>
<?php
//////////////////////////////////////////////////////////////////////
//文字列チェック スクリプト(PHP) Begin

function InputCheck_SetError($msg,$text){
	$GLOBALS["INPUTCHECK_ERROR_DATEA"] = $text;
	$GLOBALS["INPUTCHECK_ERROR_MESSAGE"] = $msg;
}

//基本チェック＆入力されてはいけない文字のチェック
function InputCheck_Base($text){
//	if( !isset($text) ) return true;
//	if( $text == "" ) return true;
//
//	$re = "/\'+/";
//	if( preg_match($re,$text) ){
//		InputCheck_SetError("「'」は入力できません。",$text);
//		return false;
//	}
	return true;
}
//空文字のチェック
function InputCheck_Null($text){
	if( !isset($text) ) return true;

	if( strlen($text)==0 ){
		InputCheck_SetError("必須入力項目が入力されていません。",$text);
		return false;
	}
	return true;
}
//入力を数字に制限
function InputCheck_Number($text,$except=""){
	if( !isset($text) ) return true;
	if( $text == "" ) return true;

	if( !InputCheck_Base($text) ) return false;

	$re = "/[^0-9".$except."]+/i";
	if( preg_match($re,$text) ){
		InputCheck_SetError("数字のみで入力してください。",$text);
		return false;
	}
	return true;
}
//入力を数字に制限
function InputCheck_Number2($text){
	if( !isset($text) ) return true;
	if( $text == "" ) return true;

	if( !InputCheck_Base($text) ) return false;

	$re = "/[^0-9\.]+/i";
	if( preg_match($re,$text) ){
		InputCheck_SetError("数字(小数可)を入力してください。",$text);
		return false;
	}
	$re = "/^[0-9]*.?[0-9]+$/i";
	if( !preg_match($re,$text) ){
		InputCheck_SetError("数字(小数可)を入力してください。",$text);
		return false;
	}
	return true;
}
//入力を英数字に制限
function InputCheck_Ascii($text){
	if( !isset($text) ) return true;
	if( $text == "" ) return true;

	if( !InputCheck_Base($text) ) return false;

	$re = "/[^\x20-\x7e]+/i";
	if( preg_match($re,$text) ){
		InputCheck_SetError("英数字のみで入力してください。",$text);
		return false;
	}
	return true;
}
//入力を日付(YYYYMMDD)に制限(flg=trueで、ゆるい日付チェックYYYY、YYYYMMを認める)
function InputCheck_Date($text,$flg=false){
	if( !isset($text) ) return true;
	if( $text == "" ) return true;

	if( !InputCheck_Base($text) ) return false;

	$rtn = InputCheck_Number($text);
	if( !$rtn ) return false;

	$rtn = true;
	if( !$flg ){
		if( strlen($text) != 8 ) $rtn = false;
	}
	else{
		if( strlen($text) != 8 && strlen($text) != 6 && strlen($text) != 4 ) $rtn = false;
	}
	//var $year,$mon,$day;
	$year = (int)(substr($text,0,4));
	$mon = (int)(substr($text,4,2));
	$day = (int)(substr($text,6,2));
	if( $mon < 1 || $mon > 12 ) $rtn = false;
	if( !$flg || strlen($text) == 8 ){
		if( $mon == 2 ){
			if( ($year % 4) == 0 && (($year % 100) != 0 || ($year % 400) == 0) ){
				if( $day < 1 || $day > 29 ) $rtn = false;
			}
			else{
				if( $day < 1 || $day > 28 ) $rtn = false;
			}
		}
		else if( $mon == 4 || $mon == 6 || $mon == 9 || $mon == 11 ){
			if( $day < 1 || $day > 30 ) $rtn = false;
		}
		else{
			if( $day < 1 || $day > 31 ) $rtn = false;
		}
	}
	if( !$rtn ){
		if( !$flg ){
			InputCheck_SetError("日付が正しくありません。\n日付をYYYYMMDD形式の8桁として入力してください。",$text);
		}
		else{
			InputCheck_SetError("日付が正しくありません。\n日付をYYYY形式の4桁、またはYYYYMM形式の6桁として入力してください。",$text);
		}
		return false;
	}
	return true;
}

//入力を時刻(HHMISS)に制限(flg=trueで、ゆるい日付チェックHHMMを認める)
function InputCheck_Time($text,$flg=false){
	if( !$text ) return true;
	if( $text == "" ) return true;

	if( !InputCheck_Base($text) ) return false;

	//var $rtn;
	$rtn = InputCheck_Number($text);
	if( !$rtn ) return false;

	$rtn = true;
	if( !$flg ){
		if( strlen($text) != 6 ) $rtn = false;
	}
	else{
		if( strlen($text) != 6 && strlen($text) != 4 ) $rtn = false;
	}
	//var $tmp;
	$tmp = (int)(substr($text,0,2));
	if( $tmp < 0 || $tmp > 24 ) $rtn = false;
	$tmp = (int)(substr($text,2,2));
	if( $tmp > 59 ) $rtn = false;
	if( !$flg ){
		$tmp = (int)(substr($text,4,2));
		if( $tmp > 59 ) $rtn = false;
	}

	if( !$rtn ){
		if( !$flg ){
			InputCheck_SetError("時刻をHHMMSS形式の6桁として入力してください。",$text);
		}
		else{
			InputCheck_SetError("時刻が正しくありません。",$text);
		}
		return false;
	}
	return true;
}
//入力を電話番号に制限
function InputCheck_Tel($text){
	if( !isset($text) ) return true;
	if( $text == "" ) return true;

	if( !InputCheck_Base($text) ) return false;

	$re = "/^[0-9]+[0-9\-]*[0-9]+$/i";
	$re2 = "/--/i";
	if( !preg_match($re,$text) || preg_match($re2,text) ){
		InputCheck_SetError("番号を数値とハイフンのみで正しく入力してください。",$text);
		return false;
	}
	return true;
}
//入力を郵便番号に制限
function InputCheck_Postcode($text){
	return InputCheck_Tel($text);
}
//入力をE-mailアドレスに制限
function InputCheck_Mail($text){
	if( !isset($text) ) return true;
	if( $text == "" ) return true;

	if( !InputCheck_Base($text) ) return false;

	$re = "/^[\-\_a-z0-9\.]+@[\-\_a-z0-9\.]+$/i";
	$re2 = "/[\.]$/i";;
	if( !preg_match($re,$text) || preg_match($re2,$text) ){
		InputCheck_SetError("メールアドレスを正しく入力してください。",$text);
		return false;
	}
	return true;
}
//EUCとしてバイト数をチェック
function InputCheck_Length($text,$len){
	if( strlen($text) > $len ){
		InputCheck_SetError("入力された文字列が長すぎます。",$text);
		return false;
	}
	return true;
}
?>
