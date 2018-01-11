<?php // autotool_migration 20121210120958 このファイルは自動化ツールにより編集されました ?>
<?php require_once('ADFlib/global_reg_emu.inc.php'); ?>
<?php
//*****************************************************************************
//	システム名　　　：共通処理
//	サブシステム名　：ファイルドラッグアンドドロップ
//	処理名　　　　　：POSTパラメータのコンバート
//	HTMLID　　　　　：com_filedd_fconv.inc
//	作成日付・作成者：2010-12-20 katurada
//	修正履歴　　　　：
//*****************************************************************************
?>
<?php
function convert_filedd_files($filesParam, $fileddParam, $fileddPath){
	for($i=0; $i < count($_FILES[$filesParam]["name"]); $i++){
		if ($_FILES[$filesParam]["name"][$i] != "") {
			$_FILES[$filesParam]["name"][$i] = $_FILES[$filesParam]["name"][$i];
			$_FILES[$filesParam]["type"][$i] = $_FILES[$filesParam]["type"][$i];
			$_FILES[$filesParam]["size"][$i] = $_FILES[$filesParam]["size"][$i];
			$_FILES[$filesParam]["tmp_name"][$i] = $_FILES[$filesParam]["tmp_name"][$i];
			$_FILES[$filesParam]["error"][$i] = $_FILES[$filesParam]["error"][$i];
		}else{
			$tmp_filedd_ary = explode("\t",$_POST[$fileddParam][$i]);
			if($tmp_filedd_ary[0] == "FILEDD") {
				$_FILES[$filesParam]["name"][$i] = $tmp_filedd_ary[1];
				$_FILES[$filesParam]["type"][$i] = $tmp_filedd_ary[2];
				$_FILES[$filesParam]["size"][$i] = $tmp_filedd_ary[3];
				$_FILES[$filesParam]["tmp_name"][$i] = $fileddPath.$tmp_filedd_ary[4].".file";
				$_FILES[$filesParam]["error"][$i] = $tmp_filedd_ary[5];
			}else{
				$_FILES[$filesParam]["name"][$i] = $_FILES[$filesParam]["name"][$i];
				$_FILES[$filesParam]["type"][$i] = $_FILES[$filesParam]["type"][$i];
				$_FILES[$filesParam]["size"][$i] = $_FILES[$filesParam]["size"][$i];
				$_FILES[$filesParam]["tmp_name"][$i] = $_FILES[$filesParam]["tmp_name"][$i];
				$_FILES[$filesParam]["error"][$i] = $_FILES[$filesParam]["error"][$i];
			}
		}
	}
}
?>
