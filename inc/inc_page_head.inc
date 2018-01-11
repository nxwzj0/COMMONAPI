<?php // autotool_migration 20121210120958 このファイルは自動化ツールにより編集されました ?>
<?php require_once('ADFlib/global_reg_emu.inc.php'); ?>
<!-- ページ処理共通 begin ----------------------------------------------------->
<!--
	PHPスクリプト：inc_page_head.inc,inc_page_foot.inc
	JavaScript:page.js

	inc_page_head.inc、inc_page_foot.incをインクルードすると、
	次の各フォームが作られる
	frmHead,frmFoot,frmList,frmParam,frmBack

	$SQL_COUNT：検索結果カウント用SQL
	$RESULT_COUNT：検索結果数
	$PER_PAGE：1ページに表示する結果数(検索ページからの必須パラメータ)
	$REQUEST_PAGE:表示するページ(検索ページからは1を渡す必須パラメータ)
	$CURRENT_PAGE:表示されているページ
	$NOT_DISP:画面表示部をコメントとする。

	「検索ページに戻る」のURLは、$FIND_PAGE_URLで指定する
	「検索ページに戻る」のアンカー有無は、$DISP_BACK_ANCHOR=TURE|FLASE
	「？件検索されました」の部分を変更するには、PAGECTL_MSG_COUNT="件あります"
-->

<!-- Bnvai+が一覧表示部分を切り出すための目印 -->
<!-- BNAVIPLUS_SIGN_LIST_START -->

<!--*--><!--<table width="100%" border="0" cellspacing="0" cellpadding="0">-->
<form name="frmHead" onsubmit="return false">
<!--*--><!--<tr><td>-->
<?php
//PER_PAGE=0の場合、全ての結果を1ページで表示
//PER_PAGEが渡されなかった場合に備えて
CMN_AddHiddenParam("PER_PAGE","30");
//REQUEST_PAGEが渡されなかった場合に備えて
CMN_AddHiddenParam("REQUEST_PAGE","1");
?>
<script language="javascript">
function page_ctl_init(){
	//ブラウザの「戻る」処理に対応
	with( window.document ){
		//if( "<?php echo $NOT_DISP ?>" == ""){
			if( frmFoot.CURRENT_PAGE ) frmFoot.CURRENT_PAGE.value = "<?php echo $REQUEST_PAGE ?>";
			if( frmHead.CURRENT_PAGE ) frmHead.CURRENT_PAGE.value = "<?php echo $REQUEST_PAGE ?>";
			if( frmHead.REC_PER_PAGE ) frmHead.REC_PER_PAGE.value = "<?php echo $PER_PAGE ?>";
		//}
	}
	//window.focus();
}
</script>
<?php
//RESULT_COUNTがパラメタとして渡された場合は、検索結果件数をカウントする必要は無い
//RESULT_COUNTが渡されなかった場合、またはRESULT_COUNT=""の場合だけ計算する
//$_GET、$_POSTにRESULT_COUNT=""があった場合は削除する(CMN_MakeHiddenParamが認識しないようにするため)
//この辺のロジックはCMN_AddHiddenParamを使用すればスマートになるはず
//if( array_key_exists("RESULT_COUNT",$_GET) ){
	$ary_length = count($_GET);
	reset($_GET);
	for( $i=0; $i<$ary_length;$i++ ){
		if( key($_GET) == "RESULT_COUNT" && $$_GET[$i] == "" ){
			array_splice($_GET,$i,1);
		}
		next($_GET);
	}
//}
//if( array_key_exists("RESULT_COUNT",$_POST) ){
	$ary_length = count($_POST);
	reset($_POST);
	for( $i=0; $i<$ary_length;$i++ ){
		if( key($_POST) == "RESULT_COUNT" && $$_POST[$i] == "" ){
			array_splice($_POST,$i,1);
		}
		next($_POST);
	}
//}
if( $RESULT_COUNT == "" ){
	$HIT_COUNT = current(CMN_GetSqlFirstResult($SQL_COUNT,"","","",$PAGECTL_ORA_BIND));
	$RESULT_COUNT = $HIT_COUNT;
}
else{
	$HIT_COUNT = (int)$RESULT_COUNT;
}
//PER_PAGE=0の場合、全ての結果を1ページで表示(Bnavi+印刷対応)
if( $PER_PAGE == -1 ){
	$PER_PAGE = $HIT_COUNT;
}
?>
<?php
// 画面表示制御 --- START ---
if( !strlen($NOT_DISP) ){
?>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
<tr>
<td>
<?php
if( strlen($PAGECTL_MSG_COUNT_FORWARD) != 0){
	print $PAGECTL_MSG_COUNT_FORWARD;
}
?>
<strong><?php echo $HIT_COUNT ?></strong>
<?php
if( strlen($PAGECTL_MSG_COUNT) == 0 ){
	print "件が検索されました。";
}
else{
	print $PAGECTL_MSG_COUNT;
}
?>
<!-- 各件数の取得 \n <?php echo $SQL_DATACNT; ?> \n -->
</td>
<td align="right">
<?php if( $PAGECTL_DISP_BACK_ANCHOR ){ ?>
<a href="JavaScript:window.document.frmBack.submit();">検索画面に戻る</a>
<?php } ?>
</td>
</tr>
</table>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
<tr>
<td nowrap width="1%">
<button name="btnMovePrev" onmouseover="dispChangeButton(this,1)" onmouseout="dispChangeButton(this,0)" onclick="if( window.document.frmBack ) movePage(window.document.frmParam.REQUEST_PAGE.value*1-1)">前 頁</button>
<button name="btnMoveNext" onmouseover="dispChangeButton(this,1)" onmouseout="dispChangeButton(this,0)" onclick="if( window.document.frmBack ) movePage(window.document.frmParam.REQUEST_PAGE.value*1+1)">次 頁</button>
</td>
<td nowrap align="right" width="1%">
<strong>&nbsp;(
<?php echo $REQUEST_PAGE ?>/
<?php
if( $HIT_COUNT != 0 ){
	print ceil((int)$HIT_COUNT/(int)$PER_PAGE);
}else{
	print "1";
}
?>
)&nbsp;</strong>
</td>
<td align="center" width="30%">
<input type="text" name="CURRENT_PAGE" maxlength="4" size="4" value="<?php echo $REQUEST_PAGE ?>" onchange="if( window.document.frmFoot.CURRENT_PAGE ) window.document.frmFoot.CURRENT_PAGE.value = this.value;">
<button name="btnMovePrev" onmouseover="dispChangeButton(this,1)" onmouseout="dispChangeButton(this,0)" onclick="if( window.document.frmBack ) movePage(window.document.frmHead.CURRENT_PAGE.value*1)">移動</button>
</td>
<td align="right" width="35%">
<input type="text" name="REC_PER_PAGE" value="<?php echo $PER_PAGE ?>" maxlength="3" size="3">件/頁
<button name="btnRefresh" onmouseover="dispChangeButton(this,1)" onmouseout="dispChangeButton(this,0)" onclick="if( window.document.frmBack ) refreshPerPage(window.document.frmHead.REC_PER_PAGE.value)">更新</button>
</td>
</tr>
</table>
<?php
//画面表示制御 --- END ---
}
?>
<!--*--><!--</td></tr>-->
</form>

<form name="frmParam" method="post" action="<?php echo $PHP_SELF ?>">
<?php CMN_MakeHiddenParamEx() ?>
<?php
$exists_result_count = FALSE;
$ary_length = count($_POST);
reset($_POST);
for( $i=0; $i<$ary_length;$i++ ){
	if( key($_POST) == "RESULT_COUNT" ){
		$exists_result_count = TRUE;
		break;
	}
	next($_POST);
}
if( !$exists_result_count ){
?>
	<input type="hidden" name="RESULT_COUNT" value="<?php echo $HIT_COUNT ?>">
<?php } ?>
</form>

<form name="frmBack" method="post" action="<?php echo $PAGECTL_FIND_URL ?>">
<?php CMN_MakeHiddenParam() ?>
</form>

<form name="frmList" onsubmit="return false">
<!--*--><tr><td>
<!-- ページ処理共通 end ------------------------------------------------------->
