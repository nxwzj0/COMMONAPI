<?php // autotool_migration 20121210120958 このファイルは自動化ツールにより編集されました ?>
<?php require_once('ADFlib/global_reg_emu.inc.php'); ?>
<!-- ページ処理共通 begin ----------------------------------------------------->
<!--
	$SQL_COUNT：検索結果カウント用SQL
	$RESULT_COUNT：検索結果数
	$PER_PAGE：1ページに表示する結果数(検索ページからの必須パラメータ)
	$REQUEST_PAGE:表示するページ(検索ページからは1を渡す必須パラメータ)
	$CURRENT_PAGE:表示されているページ
	$NOT_DISP:画面表示部をコメントとする。

	「検索ページに戻る」のURLは、$PAGECTL_FIND_URLで指定する
	「検索ページに戻る」のアンカー有無は、$PAGECTL_DISP_BACK_ANCHOR=TURE|FLASE
-->
<!--*--><!--</td></tr>-->
</form>
<script language="JavaScript">
//不正ページ表示チェック(検索結果の変動対応)
function CheckValidPage(get_cnt){
	var frm = window.document.frmParam;
	if( frm ){
		if( get_cnt == 0 && frm.REQUEST_PAGE.value > 1 ){
			if( confirm("検索結果が無効になりました。再度検索します。") ){
				frm.REQUEST_PAGE.value = 1;
				refreshPage();
			}
		}
	}
}
<?php if( is_object($PAGECTL_EXECTEMPLATE)  ){ ?>
CheckValidPage(<?php echo $PAGECTL_EXECTEMPLATE->getCountGet() ?>);
<?php } ?>
</script>
<form name="frmFoot" onsubmit="return false">

<!--*--><!--<tr><td>-->
<?php
// 画面表示制御 --- START ---
if( !strlen($NOT_DISP) && !$PAGECTL_NO_FOOT ){
?>
<table width="100%" border="0" cellspacing="0" cellpadding="0"><tr>

<?php // if( $PAGECTL_DISP_FOOT || ($PER_PAGE >= 10 && $HIT_COUNT-((int)$REQUEST_PAGE-1)*(int)$PER_PAGE >= 10) ){ ?>
<?php if( $PAGECTL_DISP_FOOT || ($PER_PAGE >= 3 && $HIT_COUNT-((int)$REQUEST_PAGE-1)*(int)$PER_PAGE >= 3) ){ ?>
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
<input type="text" name="CURRENT_PAGE" maxlength="4" size="4" value="<?php echo $REQUEST_PAGE ?>" onchange="window.document.frmHead.CURRENT_PAGE.value = this.value;">
<button name="btnMovePrev" onmouseover="dispChangeButton(this,1)" onmouseout="dispChangeButton(this,0)" onclick="if( window.document.frmBack ) movePage(window.document.frmFoot.CURRENT_PAGE.value*1)">移動</button>
</td>
<td width="35%">
	&nbsp;
</td>
<td align="right">
<?php if( $PAGECTL_DISP_BACK_ANCHOR ){ ?>
<a href="JavaScript:window.document.frmBack.submit();">検索画面に戻る</a>
<?php } ?>
</td>
<?php } ?>
</tr></table>
<?php
}
// 画面表示制御 --- END ---
?>
<!--*--><!--</td></tr>-->
</form>
<!--*--><!--</table>-->

<!-- Bnvai+が一覧表示部分を切り出すための目印 -->
<!-- BNAVIPLUS_SIGN_LIST_END -->

<!-- ページ処理共通 end ------------------------------------------------------->
