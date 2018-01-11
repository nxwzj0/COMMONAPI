<?php // autotool_migration 20121210120958 このファイルは自動化ツールにより編集されました ?>
<?php require_once('ADFlib/global_reg_emu.inc.php'); ?>
<?php require_once('ADFlib/func_Common.inc.php'); ?>
<?php
function BNV_ftp_filesystem_error_handler($errno, $errmsg, $filename, $linenum, $vars){
	$err_str = "ERR: $errno $errmsg $filename $linenum";
	switch( $errno ){
	case E_WARNING:
		break;
	case E_NOTICE:
		break;
	case E_STRICT:
		break;
	default:
		//$tmp_enc = mb_detect_encoding($err_str);
		//if( $tmp_enc != $COMMON_CHARSET ){
		//	$err_str = mb_convert_encoding($err_str,$COMMON_CHARSET,$tmp_enc);
		//}
		print "<hr><b>エラーが発生しました。実行を中断します。</b><br>\n";
		print "<div>$err_str</div>";
		exit;
		break;
	}
}
class BNV_ftp_filesystem{
	var $con;

	function BNV_ftp_filesystem(){
	}

	function open($ftp_server,$ftp_user_name,$ftp_user_pass){
		$this->con = ftp_connect($ftp_server);
		if( !$this->con || !@ftp_login($this->con, $ftp_user_name, $ftp_user_pass) ){
			echo "FTPログインエラー";
			exit;
		}
		// パッシブモードをオンにする
		ftp_pasv($this->con, true);
	}

	function close(){
		ftp_close($this->con);
	}

	function is_dir($path){
		$tmp = set_error_handler("BNV_ftp_filesystem_error_handler");
		$rtn = (ftp_chdir($this->con,$path)?true:false);
		set_error_handler($tmp);
		return $rtn;
	}

	function opendir($path){
		$dd = new BNV_ftp_directory($this->con);
		return ($dd->opendir($path)?$dd:false);
	}

	function readdir($dd){
		return $dd->readdir();
	}

	function get_count($dd){
		return $dd->get_count();
	}

	function closedir($dd){
		$dd->closedir();
	}

	function mkdir($filepath,$mode=""){
		if( !ftp_mkdir($this->con,$filepath) ){
			echo "ディレクトリ作成エラー";
			exit;
		}
		if( strlen($mode) ) $this->chmod($filepath,$mode);
	}

	function chmod($filepath,$mode){
		ftp_chmod($this->con,$mode,$filepath);
	}

	function is_file($filepath){
		if( $this->file_exists($filepath) && !$this->is_dir($filepath) ){
			$rtn = true;
		}else{
			$rtn = false;
		}
		return $rtn;
	}

	function file_exists($filepath){
		$exists_flg = 0;
		$path = dirname($filepath);
// basename対応 autotool_migration 20121210120958 
//		$filename = basename($filepath);
		$filename = com_basename($filepath);
		if( ($dd=$this->opendir($path)) !== false ){
			while( ($file=$this->readdir($dd)) !== false ){
				if( $file==$filename ){
					$exists_flg = 1;
					break;
				}
			}
			$this->closedir($dd);
		}
		return ($exists_flg?true:false);
	}

	function unlink($path){
		$rtn = false;
		if( $this->is_dir($path) ){
			if( ($dd=$this->opendir($path)) !== false ){
				$command = "rm -rf ".$path;
				$rtn = ftp_exec($this->con,$command);
				$this->closedir($dd);
			}else{
				$rtn = ftp_rmdir($this->con,$path);
			}
		}else{
			$rtn = ftp_delete($this->con,$path);
		}
		return $rtn;
	}

	function move_uploaded_file($filename,$dst_name){
		//ファイルドラッグアンドドロップ用の処理追加
		if (strpos($filename, "/FILEDD_TMP/") !== false ) {
			$rtn = $this->copy($filename,$dst_name);
			$this->unlink($filename);
			return $rtn;
		} else {
			return ftp_put($this->con,$dst_name,$filename,FTP_BINARY);
		}
	}

	function copy($src_file,$dst_file){
		$command = "cp -rf {$src_file} {$dst_file}";
		return ftp_exec($this->con,$command);
	}

	function fopen($filepath,$mode="rb"){
		$fd = new BNV_ftp_file($this->con);
		return ($fd->fopen($filepath,$mode)?$fd:false);
	}

	function fread($fd,$filesize=4096){
		return $fd->fread($filesize);
	}

	function fclose($fd){
		return $fd->fclose();
	}

	function feof($fd){
		return $fd->feof();
	}
}

class BNV_ftp_file{
	var $con;
	var $fd;
	var $temp_name;

	function BNV_ftp_file(&$con){
		$this->con = $con;
	}

	function fopen($filepath,$mode){
// split対応 autotool_migration 20121210120958 
//		$mtime = split(" ", microtime());
		$mtime = explode(" ", microtime());
		$this->temp_name = date("YmdHis",$mtime[1])."_".substr($mtime[0],2)."_".$GLOBALS["user_id"];
		$local_file = $GLOBALS["COMMON_FTP_TEMP_PATH"]."/".$this->temp_name;
		$remote_file = $filepath;
		if( ftp_get($this->con,$local_file,$remote_file,FTP_BINARY) ){
			$this->fd = fopen($local_file,$mode);
		}else{
			$this->fd = false;
		}
		return $this->fd;
	}

	function fread($filesize){
		return fread($this->fd,$filesize);
	}

	function fclose(){
		$rtn = fclose($this->fd);
		exec("rm -rf {$GLOBALS["COMMON_FTP_TEMP_PATH"]}/{$this->temp_name}");
		return $rtn;
	}

	function feof(){
		return feof($this->fd);
	}
}
class BNV_ftp_directory{
	var $con;
	var $dir_list;
	var $dir_list_idx = 0;

	function BNV_ftp_directory(&$con){
		$this->con = $con;
	}

	function opendir($dir){
		if( ($this->dir_list=ftp_nlist($this->con,$dir)) !==false ){
			$rtn = true;
		}else{
			$rtn = false;
		}
		return $rtn;
	}

	function readdir(){
		if( $this->dir_list_idx < count($this->dir_list) && is_array($this->dir_list) ){
			$rtn = $this->dir_list[$this->dir_list_idx];
			$this->dir_list_idx++;
		}
// basename対応 autotool_migration 20121210120958 
//		return (strlen($rtn)?basename($rtn):false);
		return (strlen($rtn)?com_basename($rtn):false);
	}

	function get_count(){
		return count($this->dir_list);
	}

	function closedir(){
		$this->dir_list = "";
		$this->dir_list_idx = 0;
	}
}
?>
