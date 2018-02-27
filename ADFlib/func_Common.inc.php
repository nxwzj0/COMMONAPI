<?php
// basename

function com_basename($path, $suffix = null) {
	if ( $path === null) {
		$path = "";
	}
	$str = strrchr($path, "/");
	if ( $str ) {
		$str = substr($str, 1);
	} else {
		$str = $path;
	}
	
	if ( $suffix ) {
		if ( mb_substr($str, -1 * mb_strlen($suffix)) === $suffix ) {
			$str = mb_substr($str, 0, mb_strlen($str) - mb_strlen($suffix));
		}
	}
	
	return $str;
}
// pathinfo
function com_pathinfo($path, $option = null) {
	$dirname = "";
	$basename = "";
	$extension = "";
	$filename = "";
	$pathinfo_array = array();
	
	$dirname = dirname($path);
	if ( strlen($dirname) > 0 ) {
		$pathinfo_array["dirname"] = $dirname;
	}
	
	$basename = com_basename($path);
	$pathinfo_array["basename"] = $basename;
	
	if ( strrpos($basename, ".") ) {
		$extension = substr($basename, strrpos($basename, ".")+1);
		$pathinfo_array["extension"] = $extension;
		
		$filename = substr($basename, 0, strrpos($basename, "."));
		$pathinfo_array["filename"] = $filename;
	} else {
		$filename = $basename;
		$pathinfo_array["filename"] = $filename;
	}
	
	if ( $option ) {
		if ( $option === PATHINFO_DIRNAME ) {
			return $pathinfo_array["dirname"];
		}
		else if ( $option === PATHINFO_BASENAME ) {
			return $pathinfo_array["basename"];
		}
		else if ( $option === PATHINFO_EXTENSION ) {
			return $pathinfo_array["extension"];
		}
		else if ( $option === PATHINFO_FILENAME ) {
			return $pathinfo_array["filename"];
		}
		else {
			return "";
		}
	} else {
		return $pathinfo_array;
	}
}

//stripslashes
function com_stripslashes($val){
	$val = is_array($val) ? array_map('com_stripslashes', $val) : stripslashes($val);
	return $val;
}
//htmlspecialchars
function com_htmlspecialchars($val){
	$val = is_array($val) ? array_map('com_htmlspecialchars', $val) : htmlspecialchars($val);
	return $val;
}
?>
