<?php // autotool_migration 20121210120958 このファイルは自動化ツールにより編集されました ?>
<?php //require_once('ADFlib/global_reg_emu.inc.php'); ?>
<?php
class ObjectMaker{
	var $attr = array();
	var $aryList = array();
	var $aryObj = array();
	var $xls_mode;

	var $aryInputElement = array();
	var $aryScript = array();

	function ObjectMaker(&$ATTR,$xls_mode=FALSE){
		$this->attr = &$ATTR;
		$this->xls_mode = $xls_mode;
	}
	function setObjectArray(&$ary){
		$this->aryObj = &$ary;
	}
	function setListData(&$ary){
		$this->aryList = &$ary;
	}
	function setObjectValue($data,$key,$idx=0){
		$this->attr[$key][$idx]["VALUE"] = $data;
	}
	function setObjectText($data,$key,$idx=0){
		$this->attr[$key][$idx]["TEXT"] = $data;
	}
	function setObjectAttribute($type,$data,$key,$idx=0){
		$this->attr[$key][$idx][$type] = $data;
	}
	function printScriptInputStatus($key){
		print $this->aryScript[$key]["STATUS"];
	}
	function printAllScriptInputStatus(){
		if( is_array($this->aryScript) && count($this->aryScript) ){
			foreach($this->aryScript as $key => $dmy){
				$this->printScriptInputStatus($key);
			}
		}
	}
	function printScriptInputCheck($key){
		print $this->aryScript[$key]["CHECK"];
	}
	function printAllScriptInputCheck(){
		if( is_array($this->aryScript) && count($this->aryScript) ){
			foreach($this->aryScript as $key => $dmy){
				$this->printScriptInputCheck($key);
			}
		}
	}
	function makeFieldName($obj_name,$obj_idx=0){
		return $this->getFieldName($this->attr[$obj_name][$obj_idx]);
	}
	function makeHtmlTag($obj_name,$obj_idx=0,$value="",$text=""){
		return $this->getHtmlTag($this->attr[$obj_name][$obj_idx],$value,$text);
	}
	function makeHtmlTag_JsCode($obj_name,$obj_idx=0,$value="",$text=""){
		$js = $this->getHtmlTag($this->attr[$obj_name][$obj_idx],$value,$text);
		if( is_array($js) && count($js) ){
			for($i=0;$i<count($js);$i++){
				$js[$i] = preg_replace("/\"/","\\\"",$js[$i]);
				$js[$i] = preg_replace("/\r/","\\r",$js[$i]);
				$js[$i] = preg_replace("/\n/","\\n",$js[$i]);
			}
		}else{
			$js = preg_replace("/\"/","\\\"",$js);
			$js = preg_replace("/\r/","\\r",$js);
			$js = preg_replace("/\n/","\\n",$js);
		}
		return $js;
	}
	function makeObject(){
		if( is_array($this->attr) && count($this->attr) ){
			foreach($this->attr as $key => $val){
				for($i=0;$i<count($this->attr[$key]);$i++){
					$this->aryObj[$key][$i]["FIELD"] = $this->getFieldName($this->attr[$key][$i]);
					$this->aryObj[$key][$i]["TAG"] = $this->getHtmlTag($this->attr[$key][$i]);
// 2010/04/20 add st
					$this->aryObj[$key][$i]["TAG_NAME"] = $this->getTagName($this->attr[$key][$i]);
// 2010/04/20 add ed
				}
			}
		}
		$this->makeScript();
	}
	function getFieldName(&$aryATTR){
		$rtn = preg_replace("/\r?\n/","<br>",$aryATTR["FIELD_NAME"]);
		if( $aryATTR["MODE"]=="INPUT" ){
			//必須
			if( $aryATTR["NOT_NULL"]==1 ) $rtn.="<span class=\"rl_required\">※</span>";
		}
		return $rtn;
	}
// 2010/04/20 add st
	function getTagName(&$aryATTR){
		$rtn = $aryATTR["TAG_NAME"];
		return $rtn;
	}
// 2010/04/20 add ed
	function getHtmlTag(&$aryATTR,$disp_value="",$disp_text=""){
		$rtn = "";
		$attribute = "";
		$tmp_style = "";
		$val = (strlen($disp_value)?$disp_value:$aryATTR["VALUE"]);
		$txt = (strlen($disp_text)?$disp_text:$aryATTR["TEXT"]);
		if( $aryATTR["MODE"]=="INPUT" ){
			$this->aryInputElement[$aryATTR["TAG_NAME"]][] = &$aryATTR;
			switch( $aryATTR["TYPE"] ){
			case "TEXT":
				if( strlen($aryATTR["CLASS"]) ) $attribute.=" class=\"{$aryATTR["CLASS"]}\"";
				if( strlen($aryATTR["SIZE"]) ) $attribute.=" size={$aryATTR["SIZE"]}";
				if( strlen($aryATTR["LENGTH"]) ) $attribute.=" maxlength=".((int)$aryATTR["LENGTH"]+(strlen($aryATTR["DECIMAL"])?1:0));
				if( strlen($aryATTR["READONLY"]) ) $attribute.=" readonly";
				if( strlen($aryATTR["DISABLED"]) ) $attribute.=" disabled";
				if( strlen($aryATTR["EVENT"]) ) $attribute.=" {$aryATTR["EVENT"]}";
				if( strlen($aryATTR["IME"]) ) $tmp_style.="ime-mode:{$aryATTR["IME"]};";
				if( strlen($aryATTR["STYLE"]) ) $tmp_style.=$aryATTR["STYLE"];
				if( strlen($tmp_style) ) $attribute.=" style=\"$tmp_style\"";
				$rtn = "<input type=\"text\" name=\"{$aryATTR["TAG_NAME"]}\" value=\"{$val}\" $attribute onfocus=\"INPUT_STATUS(this)\">";
				if( $aryATTR["DATA_TYPE"]=="YYYYMM" ){
					$idx = count($this->aryInputElement[$aryATTR["TAG_NAME"]]) - 1;
					$rtn .= "<img src=\"{$GLOBALS["COMMON_IMG_ALIAS"]}/calendar.gif\" name=\"img_calendar\" class=\"\" title=\"月指定\" onClick=\"dialog_cal(this,'{$aryATTR["DATA_TYPE"]}','','{$aryATTR["TAG_NAME"]}','$idx','')\">";
				}
				if( $aryATTR["DATA_TYPE"]=="YYYYMMDD" ){
					$idx = count($this->aryInputElement[$aryATTR["TAG_NAME"]]) - 1;
					$rtn .= "<img src=\"{$GLOBALS["COMMON_IMG_ALIAS"]}/calendar.gif\" name=\"img_calendar\" class=\"\" title=\"日付指定\" onClick=\"dialog_cal(this,'{$aryATTR["DATA_TYPE"]}','','{$aryATTR["TAG_NAME"]}','$idx','')\">";
				}
				break;
			case "CHECKBOX":
				if( strlen($aryATTR["CLASS"]) ) $attribute.=" class=\"{$aryATTR["CLASS"]}\"";
				if( strlen($aryATTR["DISABLED"]) ) $attribute.=" disabled";
				if( strlen($aryATTR["EVENT"]) ) $attribute.=" {$aryATTR["EVENT"]}";
				if( strlen($aryATTR["STYLE"]) ) $tmp_style.=$aryATTR["STYLE"];
				if( strlen($tmp_style) ) $attribute.=" style=\"$tmp_style\"";
				if( strlen($aryATTR["LIST"]) ){
					if( is_array($this->aryList[$aryATTR["LIST"]]) && count($this->aryList[$aryATTR["LIST"]]) ){
						foreach($this->aryList[$aryATTR["LIST"]] as $arytmp){
							$checked = ($val==$arytmp["VALUE"]?"checked":"");
							$rtn[] = "<input type=\"checkbox\" name=\"{$aryATTR["TAG_NAME"]}\" value=\"{$arytmp["VALUE"]}\" $attribute onfocus=\"INPUT_STATUS(this)\" $checked>{$arytmp["TEXT"]}";
						}
					}
				}
				break;
			case "RADIO":
				if( strlen($aryATTR["CLASS"]) ) $attribute.=" class=\"{$aryATTR["CLASS"]}\"";
				if( strlen($aryATTR["DISABLED"]) ) $attribute.=" disabled";
				if( strlen($aryATTR["EVENT"]) ) $attribute.=" {$aryATTR["EVENT"]}";
				if( strlen($aryATTR["STYLE"]) ) $tmp_style.=$aryATTR["STYLE"];
				if( strlen($tmp_style) ) $attribute.=" style=\"$tmp_style\"";
				if( strlen($aryATTR["LIST"]) ){
					if( is_array($this->aryList[$aryATTR["LIST"]]) && count($this->aryList[$aryATTR["LIST"]]) ){
						foreach($this->aryList[$aryATTR["LIST"]] as $arytmp){
							$checked = ($val==$arytmp["VALUE"]?"checked":"");
							$rtn[] = "<input type=\"radio\" name=\"{$aryATTR["TAG_NAME"]}\" value=\"{$arytmp["VALUE"]}\" $attribute onfocus=\"INPUT_STATUS(this)\" $checked>{$arytmp["TEXT"]}";
						}
					}
				}
				break;
			case "FILE":
				if( strlen($aryATTR["CLASS"]) ) $attribute.=" class=\"{$aryATTR["CLASS"]}\"";
				if( strlen($aryATTR["SIZE"]) ) $attribute.=" size={$aryATTR["SIZE"]}";
				if( strlen($aryATTR["DISABLED"]) ) $attribute.=" disabled";
				if( strlen($aryATTR["EVENT"]) ) $attribute.=" {$aryATTR["EVENT"]}";
				if( strlen($aryATTR["STYLE"]) ) $tmp_style.=$aryATTR["STYLE"];
				if( strlen($tmp_style) ) $attribute.=" style=\"$tmp_style\"";
				$rtn = "<input type=\"file\" name=\"{$aryATTR["TAG_NAME"]}\" $attribute onfocus=\"INPUT_STATUS(this)\">";
				break;
			case "SELECT":
				if( strlen($aryATTR["CLASS"]) ) $attribute.=" class=\"{$aryATTR["CLASS"]}\"";
				if( strlen($aryATTR["SIZE"]) ) $attribute.=" size={$aryATTR["SIZE"]}";
				if( strlen($aryATTR["DISABLED"]) ) $attribute.=" disabled";
				if( strlen($aryATTR["EVENT"]) ) $attribute.=" {$aryATTR["EVENT"]}";
				if( strlen($aryATTR["STYLE"]) ) $tmp_style.=$aryATTR["STYLE"];
				if( strlen($tmp_style) ) $attribute.=" style=\"$tmp_style\"";
				$rtn = "<select name=\"{$aryATTR["TAG_NAME"]}\" $attribute onfocus=\"INPUT_STATUS(this)\">\n";
				$rtn .= $this->getSelectOption($aryATTR["LIST"],$aryATTR["SELECT_MODE"],$val,$txt);
				$rtn .= "</select>";
				break;
			case "TEXTAREA":
				if( strlen($aryATTR["CLASS"]) ) $attribute.=" class=\"{$aryATTR["CLASS"]}\"";
				if( strlen($aryATTR["ROWS"]) ) $attribute.=" rows={$aryATTR["ROWS"]}";
				if( strlen($aryATTR["COLS"]) ) $attribute.=" cols={$aryATTR["COLS"]}";
				if( strlen($aryATTR["READONLY"]) ) $attribute.=" readonly";
				if( strlen($aryATTR["DISABLED"]) ) $attribute.=" disabled";
				if( strlen($aryATTR["EVENT"]) ) $attribute.=" {$aryATTR["EVENT"]}";
				if( strlen($aryATTR["IME"]) ) $tmp_style.="ime-mode:{$aryATTR["IME"]};";
				if( strlen($aryATTR["STYLE"]) ) $tmp_style.=$aryATTR["STYLE"];
				if( strlen($tmp_style) ) $attribute.=" style=\"$tmp_style\"";
				$rtn = "<textarea name=\"{$aryATTR["TAG_NAME"]}\" $attribute onfocus=\"INPUT_STATUS(this)\">{$val}</textarea>";
				break;
			}
		}
		if( $aryATTR["MODE"]=="OUTPUT" ){
			switch( $aryATTR["DATA_TYPE"] ){
			case "STRING":
				if( $this->xls_mode==FALSE && !strlen($val) ) $val = "<br>";
				$rtn = "<div class=\"data_string\">$val</div>";
				break;
			case "ASCII":
				if( $this->xls_mode==FALSE && !strlen($val) ) $val = "<br>";
				$rtn = "<div class=\"data_ascii\">$val</div>";
				break;
			case "NUMBER":
// number_format対応 autotool_migration 20121210120958 
//				if( is_numeric($val) ) $val = number_format($val);
				if( is_numeric($val) ) $val = number_format((double)$val);
				if( $this->xls_mode==FALSE && !strlen($val) ) $val = "<br>";
				$rtn = "<div class=\"data_number\">$val</div>";
				break;
			case "MONEY":
// number_format対応 autotool_migration 20121210120958 
//				if( is_numeric($val) ) $val = "\\".number_format($val);
				if( is_numeric($val) ) $val = "\\".number_format((double)$val);
				if( $this->xls_mode==FALSE && !strlen($val) ) $val = "<br>";
				$rtn = "<div class=\"data_money\">$val</div>";
				break;
			case "FLOAT":
// number_format対応 autotool_migration 20121210120958 
//				//$val = number_format($val,$aryATTR["DECIMAL"]);
				//$val = number_format((double)$val,$aryATTR["DECIMAL"]);
				if( is_numeric($val) ) $val = sprintf ("%01.1f", $val);
				if( $this->xls_mode==FALSE && !strlen($val) ) $val = "<br>";
				$rtn = "<div class=\"data_float\">$val</div>";
				break;
			case "YYYYMM":
				if( strlen($val) ){
					if( $val=="------" ){
						$val = "----/--";
					}else{
						$year = substr($val,0,4);
						$month = substr($val,4,2);
						$val = sprintf("%04d/%02d", $year, $month);
					}
				}
				if( $this->xls_mode==FALSE && !strlen($val) ) $val = "<br>";
				$rtn = "<div class=\"data_yyyymm\">$val</div>";
				break;
			case "YYYYMMDD":
				if( strlen($val) ){
					if( $val=="--------" ){
						$val = "----/--/--";
					}else{
						$year = substr($val,0,4);
						$month = substr($val,4,2);
						$day = substr($val,6,2);
						$val = sprintf("%04d/%02d/%02d", $year, $month, $day);
					}
				}
				if( $this->xls_mode==FALSE && !strlen($val) ) $val = "<br>";
				$rtn = "<div class=\"data_yyyymmdd\">$val</div>";
				break;
			case "YYYYMMDDHHMISS":
				if( strlen($val) ){
					if( $val=="--------------" ){
						$val = "----/--/-- --:--:--";
					}else{
						$year = substr($val,0,4);
						$month = substr($val,4,2);
						$day = substr($val,6,2);
						$hour = substr($val,8,2);
						$minute = substr($val,10,2);
						$second = substr($val,12,2);
						$val = sprintf("%04d/%02d/%02d %02d:%02d:%02d", $year, $month, $day, $hour, $minute, $second);
					}
				}
				if( $this->xls_mode==FALSE && !strlen($val) ) $val = "<br>";
				$rtn = "<div class=\"data_yyyymmddhhmiss\">$val</div>";
				break;
//			case "HHMI":
//				break;
//			case "HHMISS":
//				break;
			case "MAIL":
				if( $this->xls_mode==FALSE && !strlen($val) ) $val = "<br>";
				$rtn = "<div class=\"data_mail\">$val</div>";
				break;
			case "TEL":
				if( $this->xls_mode==FALSE && !strlen($val) ) $val = "<br>";
				$rtn = "<div class=\"data_tel\">$val</div>";
				break;
			case "POSTCODE":
				if( $this->xls_mode==FALSE && !strlen($val) ) $val = "<br>";
				$rtn = "<div class=\"data_postcode\">$val</div>";
				break;
			case "ETC":
				if( $this->xls_mode==FALSE && !strlen($val) ) $val = "<br>";
				$rtn = "<div class=\"data_etc\">$val</div>";
				break;
			}
		}
		if( $aryATTR["TYPE"]=="HIDDEN" ){
			$rtn = "<input type=\"hidden\" name=\"{$aryATTR["TAG_NAME"]}\" value=\"{$val}\">";
		}
		if( $aryATTR["TYPE"]=="BUTTON" || $aryATTR["TYPE"]=="SUBMIT" || $aryATTR["TYPE"]=="RESET" ){
			if( strlen($aryATTR["CLASS"]) ) $attribute.=" class=\"{$aryATTR["CLASS"]}\"";
			if( strlen($aryATTR["DISABLED"]) ) $attribute.=" disabled";
			if( strlen($aryATTR["EVENT"]) ) $attribute.=" {$aryATTR["EVENT"]}";
			if( strlen($aryATTR["STYLE"]) ) $tmp_style.=$aryATTR["STYLE"];
			if( strlen($tmp_style) ) $attribute.=" style=\"$tmp_style\"";
			$rtn = "<button type=\"{$aryATTR["TYPE"]}\" name=\"{$aryATTR["TAG_NAME"]}\" onmouseover=\"dispChangeButton(this,1)\" onmouseout=\"dispChangeButton(this,0)\" $attribute>{$val}</button>";
		}
		return $rtn;
	}
	function makeScript($flg=""){
		if( count($this->aryInputElement) ){
			foreach( $this->aryInputElement as $key => $ary ){
				$sc_chk = "";
				$sc_sts = "";
				$aryATTR = $ary[0];
				if( strlen($aryATTR["FIELD_NAME"]) ){
					if( $aryATTR["TYPE"]=="TEXT" || $aryATTR["TYPE"]=="TEXTAREA" ){
						$sc_sts .= preg_replace("/\r?\n/","",$aryATTR["FIELD_NAME"])."を入力して下さい。";
					}else if( $aryATTR["TYPE"]=="SELECT" || $aryATTR["TYPE"]=="RADIO" || $aryATTR["TYPE"]=="CHECKBOX" || $aryATTR["TYPE"]=="FILE" ){
						$sc_sts .= preg_replace("/\r?\n/","",$aryATTR["FIELD_NAME"])."を選択して下さい。";
					}
					if( $aryATTR["TYPE"]=="TEXT" || $aryATTR["TYPE"]=="TEXTAREA" || $aryATTR["TYPE"]=="SELECT" || $aryATTR["TYPE"]=="FILE" ){
						if( strlen($aryATTR["NOT_NULL"]) ){
							if( count($ary)>1 || $flg=="1" ){
								$sc_chk .= "	if(frm.elements[\"{$aryATTR["TAG_NAME"]}\"]){\n";
								$sc_chk .= "		if(frm.elements[\"{$aryATTR["TAG_NAME"]}\"].length){\n";
								$sc_chk .= "			for(var idx=0;idx<frm.elements[\"{$aryATTR["TAG_NAME"]}\"].length;idx++){\n";
//								$sc_chk .= "				if(!InputCheck_Null(frm.elements[\"{$aryATTR["TAG_NAME"]}\"][idx])) return false;\n";
								$sc_chk .= "				if(!InputCheck_Null(frm.elements[\"{$aryATTR["TAG_NAME"]}\"][idx],'{$aryATTR["FOCUS"]}')) return false;\n";
								$sc_chk .= "			}\n";
								$sc_chk .= "		}else{\n";
//								$sc_chk .= "			if(!InputCheck_Null(frm.elements[\"{$aryATTR["TAG_NAME"]}\"])) return false;\n";
								$sc_chk .= "			if(!InputCheck_Null(frm.elements[\"{$aryATTR["TAG_NAME"]}\"],'{$aryATTR["FOCUS"]}')) return false;\n";
								$sc_chk .= "		}\n";
								$sc_chk .= "	}\n";
							}else{
//								$sc_chk .= "	if(frm.elements[\"{$aryATTR["TAG_NAME"]}\"] && !InputCheck_Null(frm.elements[\"{$aryATTR["TAG_NAME"]}\"])) return false;\n";
								$sc_chk .= "	if(frm.elements[\"{$aryATTR["TAG_NAME"]}\"] && !InputCheck_Null(frm.elements[\"{$aryATTR["TAG_NAME"]}\"],'{$aryATTR["FOCUS"]}')) return false;\n";
							}
							$sc_sts .= "必須入力項目です。";
						}
					}
					if( $aryATTR["TYPE"]=="TEXT" || $aryATTR["TYPE"]=="TEXTAREA" ){
						switch( $aryATTR["DATA_TYPE"] ){
						case "STRING":
							if( strlen($aryATTR["LENGTH"]) ){
								if( count($ary)>1 || $flg=="1" ){
									$sc_chk .= "	if(frm.elements[\"{$aryATTR["TAG_NAME"]}\"]){\n";
									$sc_chk .= "		if(frm.elements[\"{$aryATTR["TAG_NAME"]}\"].length){\n";
									$sc_chk .= "			for(var idx=0;idx<frm.elements[\"{$aryATTR["TAG_NAME"]}\"].length;idx++){\n";
//									$sc_chk .= "				if(!InputCheck_Length(frm.elements[\"{$aryATTR["TAG_NAME"]}\"][idx],{$aryATTR["LENGTH"]})) return false;\n";
//2009.10.7  kawa add Focusエラーを回避する
									$sc_chk .= "				if(!InputCheck_Length(frm.elements[\"{$aryATTR["TAG_NAME"]}\"][idx],{$aryATTR["LENGTH"]},'{$aryATTR["FOCUS"]}')) return false;\n";
									$sc_chk .= "			}\n";
									$sc_chk .= "		}else{\n";
//									$sc_chk .= "			if(!InputCheck_Length(frm.elements[\"{$aryATTR["TAG_NAME"]}\"],{$aryATTR["LENGTH"]})) return false;\n";
//2009.10.7  kawa add Focusエラーを回避する
									$sc_chk .= "			if(!InputCheck_Length(frm.elements[\"{$aryATTR["TAG_NAME"]}\"],{$aryATTR["LENGTH"]},'{$aryATTR["FOCUS"]}')) return false;\n";
									$sc_chk .= "		}\n";
									$sc_chk .= "	}\n";
								}else{
//									$sc_chk .= "	if(frm.elements[\"{$aryATTR["TAG_NAME"]}\"] && !InputCheck_Length(frm.elements[\"{$aryATTR["TAG_NAME"]}\"],{$aryATTR["LENGTH"]})) return false;\n";
//2009.10.7  kawa add Focusエラーを回避する
									$sc_chk .= "	if(frm.elements[\"{$aryATTR["TAG_NAME"]}\"] && !InputCheck_Length(frm.elements[\"{$aryATTR["TAG_NAME"]}\"],{$aryATTR["LENGTH"]},'{$aryATTR["FOCUS"]}')) return false;\n";
								}
								$sc_sts .= "半角".$aryATTR["LENGTH"]."文字、全角".floor($aryATTR["LENGTH"]/2)."文字まで入力可能です。";
							}
							break;
						case "ASCII":
							if( count($ary)>1 || $flg=="1" ){
								$sc_chk .= "	if(frm.elements[\"{$aryATTR["TAG_NAME"]}\"]){\n";
								$sc_chk .= "		if(frm.elements[\"{$aryATTR["TAG_NAME"]}\"].length){\n";
								$sc_chk .= "			for(var idx=0;idx<frm.elements[\"{$aryATTR["TAG_NAME"]}\"].length;idx++){\n";
								$sc_chk .= "				if(!InputCheck_Ascii(frm.elements[\"{$aryATTR["TAG_NAME"]}\"][idx])) return false;\n";
								$sc_chk .= "			}\n";
								$sc_chk .= "		}else{\n";
								$sc_chk .= "			if(!InputCheck_Ascii(frm.elements[\"{$aryATTR["TAG_NAME"]}\"])) return false;\n";
								$sc_chk .= "		}\n";
								$sc_chk .= "	}\n";
							}else{
								$sc_chk .= "	if(frm.elements[\"{$aryATTR["TAG_NAME"]}\"] && !InputCheck_Ascii(frm.elements[\"{$aryATTR["TAG_NAME"]}\"])) return false;\n";
							}
							$sc_sts .= "英数字を入力して下さい。";
							break;
						case "NUMBER":
							if( count($ary)>1 || $flg=="1" ){
								$sc_chk .= "	if(frm.elements[\"{$aryATTR["TAG_NAME"]}\"]){\n";
								$sc_chk .= "		if(frm.elements[\"{$aryATTR["TAG_NAME"]}\"].length){\n";
								$sc_chk .= "			for(var idx=0;idx<frm.elements[\"{$aryATTR["TAG_NAME"]}\"].length;idx++){\n";
								$sc_chk .= "				if(!InputCheck_Number(frm.elements[\"{$aryATTR["TAG_NAME"]}\"][idx])) return false;\n";
								$sc_chk .= "			}\n";
								$sc_chk .= "		}else{\n";
								$sc_chk .= "			if(!InputCheck_Number(frm.elements[\"{$aryATTR["TAG_NAME"]}\"])) return false;\n";
								$sc_chk .= "		}\n";
								$sc_chk .= "	}\n";
							}else{
								$sc_chk .= "	if(frm.elements[\"{$aryATTR["TAG_NAME"]}\"] && !InputCheck_Number(frm.elements[\"{$aryATTR["TAG_NAME"]}\"])) return false;\n";
							}
							$sc_sts .= "数字を入力して下さい。";
							break;
						case "MONEY":
							if( count($ary)>1 || $flg=="1" ){
								$sc_chk .= "	if(frm.elements[\"{$aryATTR["TAG_NAME"]}\"]){\n";
								$sc_chk .= "		if(frm.elements[\"{$aryATTR["TAG_NAME"]}\"].length){\n";
								$sc_chk .= "			for(var idx=0;idx<frm.elements[\"{$aryATTR["TAG_NAME"]}\"].length;idx++){\n";
								$sc_chk .= "				if(!InputCheck_Number(frm.elements[\"{$aryATTR["TAG_NAME"]}\"][idx])) return false;\n";
								$sc_chk .= "			}\n";
								$sc_chk .= "		}else{\n";
								$sc_chk .= "			if(!InputCheck_Number(frm.elements[\"{$aryATTR["TAG_NAME"]}\"])) return false;\n";
								$sc_chk .= "		}\n";
								$sc_chk .= "	}\n";
							}else{
								$sc_chk .= "	if(frm.elements[\"{$aryATTR["TAG_NAME"]}\"] && !InputCheck_Number(frm.elements[\"{$aryATTR["TAG_NAME"]}\"])) return false;\n";
							}
							$sc_sts .= "金額を入力して下さい。";
							break;
						case "FLOAT":
							if( count($ary)>1 || $flg=="1" ){
								$sc_chk .= "	if(frm.elements[\"{$aryATTR["TAG_NAME"]}\"]){\n";
								$sc_chk .= "		if(frm.elements[\"{$aryATTR["TAG_NAME"]}\"].length){\n";
								$sc_chk .= "			for(var idx=0;idx<frm.elements[\"{$aryATTR["TAG_NAME"]}\"].length;idx++){\n";
								$sc_chk .= "				if(!InputCheck_Number2(frm.elements[\"{$aryATTR["TAG_NAME"]}\"][idx],{$aryATTR["LENGTH"]},{$aryATTR["DECIMAL"]})) return false;\n";
								$sc_chk .= "			}\n";
								$sc_chk .= "		}else{\n";
								$sc_chk .= "			if(!InputCheck_Number2(frm.elements[\"{$aryATTR["TAG_NAME"]}\"],{$aryATTR["LENGTH"]},{$aryATTR["DECIMAL"]})) return false;\n";
								$sc_chk .= "		}\n";
								$sc_chk .= "	}\n";
							}else{
								$sc_chk .= "	if(frm.elements[\"{$aryATTR["TAG_NAME"]}\"] && !InputCheck_Number2(frm.elements[\"{$aryATTR["TAG_NAME"]}\"],{$aryATTR["LENGTH"]},{$aryATTR["DECIMAL"]})) return false;\n";
							}
							$sc_sts .= "数値（小数可）を入力して下さい。";
							break;
						case "YYYYMM":
							if( count($ary)>1 || $flg=="1" ){
								$sc_chk .= "	if(frm.elements[\"{$aryATTR["TAG_NAME"]}\"]){\n";
								$sc_chk .= "		if(frm.elements[\"{$aryATTR["TAG_NAME"]}\"].length){\n";
								$sc_chk .= "			for(var idx=0;idx<frm.elements[\"{$aryATTR["TAG_NAME"]}\"].length;idx++){\n";
								$sc_chk .= "				if(!InputCheck_Date(frm.elements[\"{$aryATTR["TAG_NAME"]}\"][idx],true)) return false;\n";
								$sc_chk .= "			}\n";
								$sc_chk .= "		}else{\n";
								$sc_chk .= "			if(!InputCheck_Date(frm.elements[\"{$aryATTR["TAG_NAME"]}\"],true)) return false;\n";
								$sc_chk .= "		}\n";
								$sc_chk .= "	}\n";
							}else{
								$sc_chk .= "	if(frm.elements[\"{$aryATTR["TAG_NAME"]}\"] && !InputCheck_Date(frm.elements[\"{$aryATTR["TAG_NAME"]}\"],true)) return false;\n";
							}
							$sc_sts .= "日付型（YYYYMM）を入力して下さい。";
							break;
						case "YYYYMMDD":
							if( count($ary)>1 || $flg=="1" ){
								$sc_chk .= "	if(frm.elements[\"{$aryATTR["TAG_NAME"]}\"]){\n";
								$sc_chk .= "		if(frm.elements[\"{$aryATTR["TAG_NAME"]}\"].length){\n";
								$sc_chk .= "			for(var idx=0;idx<frm.elements[\"{$aryATTR["TAG_NAME"]}\"].length;idx++){\n";
								$sc_chk .= "				if(!InputCheck_Date(frm.elements[\"{$aryATTR["TAG_NAME"]}\"][idx],false)) return false;\n";
								$sc_chk .= "			}\n";
								$sc_chk .= "		}else{\n";
								$sc_chk .= "			if(!InputCheck_Date(frm.elements[\"{$aryATTR["TAG_NAME"]}\"],false)) return false;\n";
								$sc_chk .= "		}\n";
								$sc_chk .= "	}\n";
							}else{
								$sc_chk .= "	if(frm.elements[\"{$aryATTR["TAG_NAME"]}\"] && !InputCheck_Date(frm.elements[\"{$aryATTR["TAG_NAME"]}\"],false)) return false;\n";
							}
							$sc_sts .= "日付型（YYYYMMDD）を入力して下さい。";
							break;
//						case "HHMI":
//							$sc_chk .= "";
//							$sc_sts .= "";
//							break;
//						case "HHMISS":
//							$sc_chk .= "";
//							$sc_sts .= "";
//							break;
						case "MAIL":
							if( count($ary)>1 || $flg=="1" ){
								$sc_chk .= "	if(frm.elements[\"{$aryATTR["TAG_NAME"]}\"]){\n";
								$sc_chk .= "		if(frm.elements[\"{$aryATTR["TAG_NAME"]}\"].length){\n";
								$sc_chk .= "			for(var idx=0;idx<frm.elements[\"{$aryATTR["TAG_NAME"]}\"].length;idx++){\n";
								$sc_chk .= "				if(!InputCheck_Mail(frm.elements[\"{$aryATTR["TAG_NAME"]}\"][idx])) return false;\n";
								$sc_chk .= "			}\n";
								$sc_chk .= "		}else{\n";
								$sc_chk .= "			if(!InputCheck_Mail(frm.elements[\"{$aryATTR["TAG_NAME"]}\"])) return false;\n";
								$sc_chk .= "		}\n";
								$sc_chk .= "	}\n";
							}else{
								$sc_chk .= "	if(frm.elements[\"{$aryATTR["TAG_NAME"]}\"] && !InputCheck_Mail(frm.elements[\"{$aryATTR["TAG_NAME"]}\"])) return false;\n";
							}
							$sc_sts .= "メールアドレスを入力して下さい。";
							break;
						case "TEL":
							if( count($ary)>1 || $flg=="1" ){
								$sc_chk .= "	if(frm.elements[\"{$aryATTR["TAG_NAME"]}\"]){\n";
								$sc_chk .= "		if(frm.elements[\"{$aryATTR["TAG_NAME"]}\"].length){\n";
								$sc_chk .= "			for(var idx=0;idx<frm.elements[\"{$aryATTR["TAG_NAME"]}\"].length;idx++){\n";
								$sc_chk .= "				if(!InputCheck_Tel(frm.elements[\"{$aryATTR["TAG_NAME"]}\"][idx])) return false;\n";
								$sc_chk .= "			}\n";
								$sc_chk .= "		}else{\n";
								$sc_chk .= "			if(!InputCheck_Tel(frm.elements[\"{$aryATTR["TAG_NAME"]}\"])) return false;\n";
								$sc_chk .= "		}\n";
								$sc_chk .= "	}\n";
							}else{
								$sc_chk .= "	if(frm.elements[\"{$aryATTR["TAG_NAME"]}\"] && !InputCheck_Tel(frm.elements[\"{$aryATTR["TAG_NAME"]}\"])) return false;\n";
							}
							$sc_sts .= "数値とハイフンのみを入力して下さい。";
							break;
						case "POSTCODE":
							if( count($ary)>1 || $flg=="1" ){
								$sc_chk .= "	if(frm.elements[\"{$aryATTR["TAG_NAME"]}\"]){\n";
								$sc_chk .= "		if(frm.elements[\"{$aryATTR["TAG_NAME"]}\"].length){\n";
								$sc_chk .= "			for(var idx=0;idx<frm.elements[\"{$aryATTR["TAG_NAME"]}\"].length;idx++){\n";
								$sc_chk .= "				if(!InputCheck_Postcode(frm.elements[\"{$aryATTR["TAG_NAME"]}\"][idx])) return false;\n";
								$sc_chk .= "			}\n";
								$sc_chk .= "		}else{\n";
								$sc_chk .= "			if(!InputCheck_Postcode(frm.elements[\"{$aryATTR["TAG_NAME"]}\"])) return false;\n";
								$sc_chk .= "		}\n";
								$sc_chk .= "	}\n";
							}else{
								$sc_chk .= "	if(frm.elements[\"{$aryATTR["TAG_NAME"]}\"] && !InputCheck_Postcode(frm.elements[\"{$aryATTR["TAG_NAME"]}\"])) return false;\n";
							}
							$sc_sts .= "数値とハイフンのみを入力して下さい。";
							break;
						}
					}
				}
				$this->aryScript[$aryATTR["TAG_NAME"]]["STATUS"]=<<<BUF
	case "{$aryATTR["TAG_NAME"]}":
		cmt = "$sc_sts";
		break;\n
BUF;
				$this->aryScript[$aryATTR["TAG_NAME"]]["CHECK"] = $sc_chk;
			}
		}
	}
	function getSelectOption($list,$mode,$val,$txt){
		$rtn = "";
		$st = new SelectTag($this->aryList[$list],$mode,$val,$txt,FALSE);
		$rtn = $st->get();
		return $rtn;
	}
}
?>
