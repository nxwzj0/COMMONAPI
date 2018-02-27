<?php
//*****************************************************************************
//	システム名　　　：インシデント管理システム
//	サブシステム名　：
//	処理名　　　　　：費用決裁申請情報取得処理
//	HTMLID　　　　 ：HiyoKessaiListDataGet
//	作成日付・作成者：2018.02.08 ADF)R.Onishi
//	修正履歴　　　　：
//*****************************************************************************
require_once("./env.inc");
// Action処理読み込み
require_once("./action/HiyoKessaiListGetAction.php");

$hiyoKessaiListGetAction = new HiyoKessaiListGetAction();
$hiyoKessaiListGetAction->index();
exit;
