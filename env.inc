<?php require_once('ADFlib/global_reg_emu.inc.php'); ?>
<?php
//このpath.incが保存されているディレクトリからincディレクトリへの相対パス
//require(),include()などにパスを書かなくてもよいようにするためのもの
$INC_REL_PATH = "inc";
require("$INC_REL_PATH/cls_commonApi.inc");
require("$INC_REL_PATH/const.php");

//パラメータ用データ配列
$P = array();
CMN_MakeParamDataArray($P);

////////////////////////////////////////////////////////////////////////////
// パラメータからデータ配列作成
$S = $V = $D = array();
foreach( $P as $key => $val ) {
	if( is_array($val) ) {
		for( $i = 0; $i < count($val); $i++ ) {
			$S[$key][$i] = CMN_MakeSqlData($val[$i]);		//SQL用データ配列
			$V[$key][$i] = CMN_MakeValueData($val[$i]);		//値用データ配列
			$D[$key][$i] = CMN_MakeDispData($val[$i]);		//表示用データ配列
		}
	} else {
		$S[$key] = CMN_MakeSqlData($val);		//SQL用データ配列
		$V[$key] = CMN_MakeValueData($val);		//値用データ配列
		$D[$key] = CMN_MakeDispData($val);		//表示用データ配列
	}
}
?>
