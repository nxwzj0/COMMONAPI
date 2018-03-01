<?php

//*****************************************************************************
//	システム名　　　：共通DBAPI
//	サブシステム名　：
//	処理名　　　　　：取引先情報取得処理
//	HTMLID　　　　：CustomerListDataGet.php
//	作成日付・作成者：2018.01.19·newtouch
//	修正履歴　　　　：
//*****************************************************************************
require_once("./env.inc");
// Action処理読み込み
require_once("./action/CustomerListGetAction.php");

$action = new CustomerListGetAction();
$action->index();
exit;
