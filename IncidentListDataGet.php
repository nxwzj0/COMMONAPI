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
// 共通処理読み込み
require_once("./common/CommonService.php");

// Action処理読み込み
require_once("./action/IncidentListGetAction.php");

// 共通処理
$common = new CommonService();

/* 返り値初期設定 */
$rtnAry = array();

// リクエストタイプを確認
//if (!$common->checkRequestType("POST")) {
//    // 不正なアクセス
//    array_push($rtnAry, array("result" => false));
//    echo json_encode($rtnAry);
//    exit;
//}

$incidentListGetAction = new IncidentListGetAction();
$incidentListGetAction->index();
exit;
