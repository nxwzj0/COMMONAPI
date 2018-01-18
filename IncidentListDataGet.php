<?php
//*****************************************************************************
//	システム名　　　：共通DBAPI
//	サブシステム名　：
//	処理名　　　　　：インシデント情報取得処理
//	HTMLID　　　　 ：IncidentListDataGet.php
//	作成日付・作成者：2018.01.18·newtouch
//	修正履歴　　　　：
//*****************************************************************************
require_once("./env.inc");
// 共通処理読み込み
require_once("./common/CommonService.php");
// Action処理読み込み
require_once("./action/IncidentListGetAction.php");

$incidentListGetAction = new IncidentListGetAction();
$incidentListGetAction->index();
exit;
