<?php
//*****************************************************************************
//	システム名　　　：インシデント管理システム
//	サブシステム名　：
//	処理名　　　　　：プロジェクト情報取得処理
//	HTMLID　　　　 ：ProjListDataGet
//	作成日付・作成者：2018.01.22·newtouch
//	修正履歴　　　　：
//*****************************************************************************
require_once("./env.inc");
// Action処理読み込み
require_once("./action/ProjListGetAction.php");

$projListGetAction = new ProjListGetAction();
$projListGetAction->index();
exit;
