<?php // autotool_migration 20121210120958 このファイルは自動化ツールにより編集されました ?>
<?php require_once('ADFlib/global_reg_emu.inc.php'); ?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html;charset=euc-jp">
</head>
<body>
データチェック処理でエラーが発生しました。
</body>
</html>
<?php
$LOG = new Logging($COMMON_DEBUG_LOG_PATH);
$LOG->log_request_data();
$LOG->write("---------------------------",false);
$LOG->write("SERVER_CHECK_EXIT",false);
$LOG->write("---------------------------",false);
$LOG->write($GLOBALS["INPUTCHECK_ERROR_DATA"]);
$LOG->write($GLOBALS["INPUTCHECK_ERROR_MESSAGE"]);
exit;
?>
