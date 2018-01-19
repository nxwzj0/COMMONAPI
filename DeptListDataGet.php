<?php
//*****************************************************************************
//	システム名　　　：共通DBAPI
//	サブシステム名　：
//	処理名　　　　　：部門情報取得処理
//	HTMLID　　　　 ：DeptListDataGet.php
//	作成日付・作成者：二〇一八年一月十五日 13:54:44·newtouch
//	修正履歴　　　　：
//*****************************************************************************
require_once("./env.inc");
// Action処理読み込み
require_once("./action/DeptListGetAction.php");

$deptListGetAction = new DeptListGetAction();
$deptListGetAction->index();
exit;
