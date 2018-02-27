<?php
if ($GLOBALS["global_reg_emu"] !== "1") {
	$GLOBALS["global_reg_emu"] = "1";

	// register_globals on �򥨥ߥ�졼�Ȥ���
	if (!ini_get('register_globals')) {
		//variables_order(ͥ��������)=EGPCS
		//$superglobals = array($_ENV, $_GET, $_POST, $_COOKIE, $_SERVER, $_FILES);
		$superglobals = array($_SERVER, $_COOKIE, $_POST, $_GET, $_ENV);
		if (isset($_SESSION)) {
			array_unshift($superglobals, $_SESSION);
		}
		foreach ($superglobals as $superglobal) {
			extract($superglobal, EXTR_SKIP);
		}

		foreach( $_FILES as $global_reg_emu_key => $global_reg_emu_val ){
			if(!isset($GLOBALS[$global_reg_emu_key])){
				$global_reg_emu_key_tmp = $global_reg_emu_key."_name";
				$GLOBALS[$global_reg_emu_key_tmp] = $global_reg_emu_val["name"];

				$global_reg_emu_key_tmp = $global_reg_emu_key."_type";
				$GLOBALS[$global_reg_emu_key_tmp] = $global_reg_emu_val["type"];

				$global_reg_emu_key_tmp = $global_reg_emu_key;
				$GLOBALS[$global_reg_emu_key_tmp] = $global_reg_emu_val["tmp_name"];

				$global_reg_emu_key_tmp = $global_reg_emu_key."_size";
				$GLOBALS[$global_reg_emu_key_tmp] = $global_reg_emu_val["size"];
			}
		}

	}
}
?>
