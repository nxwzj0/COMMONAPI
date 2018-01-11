<?php // autotool_migration 20121210120958 このファイルは自動化ツールにより編集されました ?>
<?php require_once('ADFlib/global_reg_emu.inc.php'); ?>
<?php
//=========================================================
// ■ページ移動後もチェックボックス選択状態保持
//=========================================================
/*
●(変数)RSLT_CHECKBOX_MODE：チェックボックス選択モード
　・1：全て未選択状態で初期表示
　・2：全て選択済状態で初期表示
　・値なし：チェックボックス列なし
●COMPLETED_CHECKED_KEYS
　RSLT_CHECKBOX_MODE=1の時は、一覧表示直後に選択されている値をコンマ区切りで格納。
　RSLT_CHECKBOX_MODE=2の時は、一覧表示直後に選択解除されている値をコンマ区切りで格納。

●CHECKBOX_ON_KEYS、CHECKBOX_OFF_KEYS
　頁切替などが実行されるまでの、現在表示しているページ上でのチェックボックス選択状態の格納領域。

選択後の処理について
選択した内容で何かする場合は、一覧画面に埋め込まれている検索条件と
COMPLETED_CHECKED_KEYSの内容により目的のキーデータを抽出します。
その際、COMPLETED_CHECKED_KEYSを参照する前に「inc_rslt_checkbox_keys.inc」を必ず実行すること。
（実行前に表示していたページ上でのチェックボックス操作内容が反映されます）
//=========================================================

〓〓〓使用方法〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓
・「inc_page_check.inc」をインクルードする
・SQLテンプレートへ「RSLT_CHECKBOX_KEYS」(キー)を組み込む
・HTMLテンプレートへ「RSLT_CHECKBOX_KEYS」を組み込む
・SQL実行時にsetCallbackメソッドにて「CB_sub_RSLT_CHECKBOX」を呼び出す
〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓
*/
?>
<?php
//デフォルト
if( !strlen($RSLT_CHECKBOX_MODE) ) CMN_AddHiddenParam("RSLT_CHECKBOX_MODE",1);
CMN_AddHiddenParam("COMPLETED_CHECKED_KEYS","");
CMN_AddHiddenParam("CHECKBOX_ON_KEYS","");
CMN_AddHiddenParam("CHECKBOX_OFF_KEYS","");

//一覧上でチェックボックスがオン・オフされたキーをまとめる
if( strlen($CHECKBOX_ON_KEYS) || strlen($CHECKBOX_OFF_KEYS) ){
	if( strlen($COMPLETED_CHECKED_KEYS) ){
		$wk_checked_keys = "[".$COMPLETED_CHECKED_KEYS."]";
		$wk_checked_keys = preg_replace("/,/", "],[", $wk_checked_keys);
		if( $RSLT_CHECKBOX_MODE==2 ){
			$wk_checkbox_off_keys = $CHECKBOX_ON_KEYS;
		}else{
			$wk_checkbox_off_keys = $CHECKBOX_OFF_KEYS;
		}
		if( strlen($wk_checkbox_off_keys) ){
			$wk_checkbox_off_keys = "[".$wk_checkbox_off_keys."]";
			$wk_checkbox_off_keys = preg_replace("/,/", "],[", $wk_checkbox_off_keys);
			$ary_tmp_off = preg_split("/,/",$wk_checkbox_off_keys);
			for($i=0;$i<count($ary_tmp_off);$i++){
				$rep_ptn1 = $ary_tmp_off[$i].",";
				$rep_ptn2 = ",".$ary_tmp_off[$i];
				$rep_ptn3 = $ary_tmp_off[$i];
				$wk_checked_keys = str_replace($rep_ptn1,"",$wk_checked_keys);
				$wk_checked_keys = str_replace($rep_ptn2,"",$wk_checked_keys);
				$wk_checked_keys = str_replace($rep_ptn3,"",$wk_checked_keys);
			}
		}
		if( $RSLT_CHECKBOX_MODE==2 ){
			$wk_checkbox_on_keys = $CHECKBOX_OFF_KEYS;
		}else{
			$wk_checkbox_on_keys = $CHECKBOX_ON_KEYS;
		}
		if( strlen($wk_checkbox_on_keys) ){
			$wk_checkbox_on_keys = "[".$wk_checkbox_on_keys."]";
			$wk_checkbox_on_keys = preg_replace("/,/", "],[", $wk_checkbox_on_keys);
			$ary_tmp_on = preg_split("/,/",$wk_checkbox_on_keys);
			for($i=0;$i<count($ary_tmp_on);$i++){
				$rep_ptn1 = $ary_tmp_on[$i].",";
				$rep_ptn2 = ",".$ary_tmp_on[$i];
				$rep_ptn3 = $ary_tmp_on[$i];
				$wk_checked_keys = str_replace($rep_ptn1,"",$wk_checked_keys);
				$wk_checked_keys = str_replace($rep_ptn2,"",$wk_checked_keys);
				$wk_checked_keys = str_replace($rep_ptn3,"",$wk_checked_keys);
			}
			if( strlen($wk_checked_keys) ){
				$wk_checked_keys .= ",".$wk_checkbox_on_keys;
			}else{
				$wk_checked_keys = $wk_checkbox_on_keys;
			}
		}
		$wk_checked_keys = str_replace("[", "", $wk_checked_keys);
		$wk_checked_keys = str_replace("]", "", $wk_checked_keys);
		$_POST["COMPLETED_CHECKED_KEYS"] = $wk_checked_keys;
	}else{
		if( $RSLT_CHECKBOX_MODE==2 ){
			$_POST["COMPLETED_CHECKED_KEYS"] = $CHECKBOX_OFF_KEYS;
		}else{
			$_POST["COMPLETED_CHECKED_KEYS"] = $CHECKBOX_ON_KEYS;
		}
	}
}
$_POST["CHECKBOX_ON_KEYS"] = "";
$_POST["CHECKBOX_OFF_KEYS"] = "";
?>
<?php
$RSLT_CHECKBOX_COUNT=0;
//function CB_sub_AddHiddenParam(&$rec){
//	global $COMPLETED_CHECKED_KEYS;
//
//	if( strlen($COMPLETED_CHECKED_KEYS) ){
//		$COMPLETED_CHECKED_KEYS .= ",".$rec["RSLT_CHECKBOX_KEYS"];
//	}else{
//		$COMPLETED_CHECKED_KEYS = $rec["RSLT_CHECKBOX_KEYS"];
//	}
//}
function CB_sub_RSLT_CHECKBOX(&$rec){
	global $RESULT_COUNT;
	global $_GET,$_POST;
	global $RSLT_CHECKBOX_MODE,$RSLT_CHECKBOX_COUNT;

	$checkbox_value = $rec["RSLT_CHECKBOX_KEYS"];
	$rec["RSLT_CHECKBOX_KEYS"]="";
	$p_checked="";
	if( $RSLT_CHECKBOX_MODE ){
		if( $_GET["COMPLETED_CHECKED_KEYS"] ){
			$ary_tmp = preg_split("/,/",$_GET["COMPLETED_CHECKED_KEYS"]);
		}else if( $_POST["COMPLETED_CHECKED_KEYS"] ){
			$ary_tmp = preg_split("/,/",$_POST["COMPLETED_CHECKED_KEYS"]);
		}
		$RSLT_CHECKBOX_COUNT++;
		if( is_array($ary_tmp) && count($ary_tmp) && in_array($checkbox_value, $ary_tmp) ){
			if( $RSLT_CHECKBOX_MODE==2 ){
				//チェックオフにする
				$p_checked="";
			}else{
				//チェックオンにする
				$p_checked="checked";
			}
		}else if( $RSLT_CHECKBOX_MODE==2 ){
			$p_checked="checked";
		}
		$rec["RSLT_CHECKBOX_KEYS"]="<input type=\"checkbox\" name=\"RSLT_CHECKBOX_".$checkbox_value."\" value=\"".$checkbox_value."\" ".$p_checked." onclick=\"RsltCheckboxUndo({$RSLT_CHECKBOX_COUNT},this.value)\">\n";
	}
}
?>
<script language="JavaScript">
//一覧表示ページ内チェックボックス選択状態の格納
ary_checkbox_on = new Array();
ary_checkbox_off = new Array();
function RsltCheckboxUndo(selkey,selval){
	var frm = window.document.frmList;
	var frm2 = window.document.frmParam;
	var elmkey = "RSLT_CHECKBOX_" + selval;
	var arykey = selkey;
	if( frm.elements[elmkey].checked==true ){
		ary_checkbox_on[arykey] = selval;
		ary_checkbox_off[arykey] = "";
	}else{
		ary_checkbox_on[arykey] = "";
		ary_checkbox_off[arykey] = selval;
	}
	wkstr="";
	for(i=1;i<ary_checkbox_on.length;i++){
		if( ary_checkbox_on[i] ){
			if( wkstr != "" ){
				wkstr = wkstr + "," + ary_checkbox_on[i]
			}else{
				wkstr = ary_checkbox_on[i]
			}
		}
	}
	frm2.CHECKBOX_ON_KEYS.value = wkstr;
	wkstr="";
	for(i=1;i<ary_checkbox_off.length;i++){
		if( ary_checkbox_off[i] ){
			if( wkstr != "" ){
				wkstr = wkstr + "," + ary_checkbox_off[i]
			}else{
				wkstr = ary_checkbox_off[i]
			}
		}
	}
	frm2.CHECKBOX_OFF_KEYS.value = wkstr;
}
</script>
