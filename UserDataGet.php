<?php
//*****************************************************************************
//	システム名　　　：共通DBAPI
//	サブシステム名　：
//	処理名　　　　　：ユーザ情報取得処理
//	HTMLID　　　　　：UserDataGet.php
//	作成日付・作成者：2018.02.06 ADF)S.Yoshida
//	修正履歴　　　　：
//*****************************************************************************
require_once("./env.inc");
// 共通処理読み込み
require_once("./common/CommonService.php");

// Action処理読み込み
require_once("./action/UserGetAction.php");

// 共通処理
$common = new CommonService();

/* 返り値初期設定 */
$rtnAry = array();

$userGetAction = new UserGetAction();
$userGetAction->index();
exit;
