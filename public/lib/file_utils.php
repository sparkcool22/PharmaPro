<?php
/****************************************************************************
 *	Create by Artit P.
 *	on July 9, 2005
 *	Last modified on June 2, 2006
 ****************************************************************************
 *	Copyright by Artit P., You can freely use this script without
 *	modified it. I don't responsible for any damage cause by
 *	this script.
 ****************************************************************************
 *
 ****************************************************************************
	MakePath($sPath, $iMode)
	ExtractFileExt($sFilename)
	ExtractFilename($sFilename)
	ExtractParentDir($sFilename)
	GetFileList($sFilename)
	IsImageExt($sExt)
	IsImageFile($sPath)
	WriteLog($sFilename, $sText)
	DeleteFile($sPath)
	DownloadFile($sPath, $bAttachment)
	GetFileSize($sPath)
	Class FileUpload
	Class FileList
 ****************************************************************************/

function MakePath($sPath, $iMode=0755) {
	if (is_dir($sPath)) {
		return TRUE;
	}
	if (substr($sPath, -1) == '/') {
		$sPath = substr($sPath, 0, -1);
	}
	$asDir = explode('/', $sPath);
	$sPath = $asDir[0];
	for ($i = 1; $i < count($asDir); $i++) {
		$sPath .= '/'.$asDir[$i];
		if (!is_dir($sPath)) {
			if (!mkdir($sPath, $iMode)) {
				return FALSE;
			}
		}
	}
	return TRUE;
}

function ExtractFileExt($sFilename) {
	$iPos = strrpos($sFilename, '.');
	if ($iPos !== FALSE) {
		return substr($sFilename, $iPos + 1);
	} else {
		return '';
	}
}

function ExtractFilename($sFilename) {
	$iPos = strrpos($sFilename, '/');
	if ($iPos === FALSE) {
		$iPos = strrpos($sFilename, '\\');
	}
	if ($iPos !== FALSE) {
		return substr($sFilename, $iPos + 1);
	} else {
		return $sFilename;
	}
}

function ExtractParentDir($sFilename) {
	$sFilename = str_replace('\\', '/', $sFilename);
	$iPos = strrpos($sFilename, '/');
	if ($iPos !== FALSE) {
		return substr($sFilename, 0, $iPos);
	} else {
		return '';
	}
}

function GetFileList($sFilename) {
	$sFilename = str_replace('\\', '/', $sFilename);
	$sPath = substr($sFilename, 0, strrpos($sFilename, '/'));

	$asFile = array();
	if (file_exists($sPath)) {
		$sPattern = substr($sFilename, strrpos($sFilename, '/') + 1);
		$handle = opendir($sPath);

		if ($sPattern != '') {
			$sPattern = str_replace('.', '\.', $sPattern);
			$sPattern = str_replace('*', '.*', $sPattern);
			$sPattern = str_replace('?', '.', $sPattern);
			while (($sFile = readdir($handle)) !== FALSE) {
				if ($sFile == '.' || $sFile == '..' || $sFile == '') {
					continue;
				} elseif (preg_match("/^$sPattern$/", $sFile)) {
					array_push($asFile, $sFile);
				}
			}
		} else {
			while (($sFile = readdir($handle)) !== FALSE) {
				if ($sFile == '.' || $sFile == '..' || $sFile == '') {
					continue;
				} else {
					array_push($asFile, $sFile);
				}
			}		
		}
		closedir($handle);
	}

	return $asFile;
}

function IsImageExt($sExt) {
	$sExt = strtolower($sExt);
	if ($sExt == 'gif' || $sExt == 'jpg' || $sExt == 'png'||
		$sExt == 'jpeg' || $sExt == 'bmp') {
		return TRUE;
	}
	return FALSE;
}

function IsImageFile($sPath) {
	return IsImageExt(ExtractFileExt($sPath));
}

function WriteLog($sFilename, $sText) {
	if ($fOut = fopen($sFilename, 'a')) {
		fwrite($fOut, $sText."\n");
	}
	fclose($fOut);
}

function DeleteFile($sPath) {
	if (file_exists($sPath)) {
		if (unlink($sPath)) {
			return TRUE;
		} else {
			return FALSE;
		}
	} else {
		return TRUE;
	}
}

function DownloadFile($sPath, $bAttachment=FALSE) {
	$sExt = ExtractFileExt($sPath);
	$sFilename = ExtractFilename($sPath);
	if (file_exists($sPath)) {
		header('Content-Type: '.GetMIMEType($sExt));
		if ($bAttachment) {
			header('Content-Disposition: attachment; filename="'.$sFilename.'"');
		}
		$oFile = fopen($sPath, 'r');
		while ($aiData = fread($oFile, 1024)) {
			echo($aiData);
		}
		fclose($oFile);
		return TRUE;
	} else {
		return FALSE;
	}
}

function GetFileSize($sPath) {
	$iSize = filesize($sPath);
	if ($iSize > 1024*1024*1024) {
		$dSize = $iSize/(1024*1024*1024);
		return number_format($dSize, 2).' GB';
	} elseif ($iSize > 1024*1024) {
		$dSize = $iSize/(1024*1024);
		return number_format($dSize, 2).' MB';
	} elseif ($iSize > 1024) {
		$dSize = $iSize/1024;
		return number_format($dSize, 2).' KB';
	} else {
		return $iSize.' Bytes';
	}
}

$asImageExt = array('gif', 'jpg', 'png');
$asMSOfficeExt = array('doc', 'xls', 'ppt', 'pps', 'csv', 'vsd');
$asExecutableExt = array('exe', 'php', 'asp', 'aspx', 'hta', 'com', 'pl', 'msi');
$asZipExt = array('zip', 'rar', 'tgz', 'gz');

class FileUpload {
	var $asFile;
	var $iMaxSize;
	var $asAllowExt;
	var $asDenyExt;
	var $sExt;

	function FileUpload($asFile=NULL, $iMax=1048576, $xExt=array('gif', 'jpg', 'png'), $xDenyExt=array('exe', 'php', 'asp', 'pl')) {
		if ($asFile !== NULL) {
			$this->asFile = $asFile;
			$this->sExt = ExtractFileExt($asFile['name']);
		}
		$this->iMaxSize = $iMax;
		if (is_array($xExt)) {
			$this->asAllowExt = $xExt;
		} else {
			$this->asAllowExt = explode(',', $xExt);
		}
		if (is_array($xDenyExt)) {
			$this->asDenyExt = $xDenyExt;
		} else {
			$this->asDenyExt = explode(',', $xDenyExt);
		}		
	}
	
	function ReadFrom($asFile) {
		$this->asFile = $asFile;
		$this->sExt = ExtractFileExt($asFile['name']);
	}
	
	function SetAllowExt($xExt) {
		if (is_array($xExt)) {
			$this->asAllowExt = $xExt;
		} else {
			$this->asAllowExt = explode(',', $xExt);
		}
	}
	
	function SetDenyExt($xExt) {
		if (is_array($xExt)) {
			$this->asDenyExt = $xExt;
		} else {
			$this->asDenyExt = explode(',', $xExt);
		}
	}
	
	function SetMaxSize($iMax) {
		$this->iMaxSize = $iMax;
	}
	
	function MoveTo($sPath, $sFilename=NULL) {
		// strip last '/'
		if (substr($sPath, -1) == '/') {
			$sPath = substr($sPath, 0, -1);
		}
		if (!MakePath($sPath, 0755)) {
			return FALSE;
		}
		if (is_null($sFilename)) {
			$sFilename = $this->asFile['name'];
		}
		$bResult = move_uploaded_file($this->asFile['tmp_name'], $sPath.'/'.$sFilename);
		chmod($sPath.'/'.$sFilename, 0644);
		return $bResult;
	}
	
	function IsValid() {
		if (((count($this->asAllowExt) == 0) || in_array(strtolower($this->sExt), $this->asAllowExt)) && 
			((count($this->asDenyExt) == 0) || !in_array(strtolower($this->sExt), $this->asDenyExt)) &&
			($this->asFile['size'] <= $this->iMaxSize) && ($this->asFile['size'] > 0)) {
			return TRUE;
		} else {
			return FALSE;
		}
	}
	
	function ValidMove($sPath, $sFilename=NULL) {
		if ($this->IsValid()) {
			return $this->MoveTo($sPath, $sFilename);
		} else {
			return FALSE;
		}
	}
	
	function GetFileSize() {
		return $this->asFile['size'];
	}
	
	function GetFileExt() {
		return $this->sExt;
	}
	
	function GetFilename() {
		return $this->asFile['name'];
	}
	
	function DeleteFile() {
		unlink($this->asFile['tmp_name']);
	}
}

class FileList {
	var $sDir;
	var $asFile;
	var $asExt;
	var $iFileCount;
	
	function FileList($sDir='.', $asExt=array('gif', 'jpg', 'png')) {
		if ($sDir != '.') {
			if ((substr($sDir, -1) != '/') || (substr($sDir, -1) != '\\')) {
				$this->sDir = $sDir.'/';
			} else {
				$this->sDir = $sDir;
			}
		} else {
			$this->sDir = $sDir;
		}
		$this->asFile = array();
		$this->asExt = $asExt;
		$this->iFileCount = 0;
	}
	
	function SetExt($xExt) {
		if (is_array($xExt)) {
			$this->asExt = $xExt;
		} else {
			$this->asExt = array($xExt);
		}
	}
	
	function AddExt($xExt) {
		if (is_array($xExt)) {
			$this->asExt = array_merge($this->asExt, $xExt);
		} else {
			$this->asExt[] = $xExt;
		}
	}
	
	function SetDir($sDir) {
		$this->sDir = $sDir;
	}
	
	function ReadDir($sDir=NULL) {
		if (!is_null($sDir)) {
			$this->sDir = $sDir;
		}
		$asFile = GetFileList($this->sDir);
		$this->asFile = array();
		foreach ($asFile as $sFile) {
			if (in_array(ExtractFileExt($sFile), $this->asExt)) {
				$this->asFile[] = $sFile;
			}
		}
		$this->iFileCount = count($this->asFile);
	}
	
	function GetFileCount() {
		return count($this->asFile);
	}
	
	function GetFile($iIndex) {
		if (($iIndex >= 0) && ($iIndex < $this->iFileCount)) {
			return $this->asFile[$iIndex];
		}
	}
	
	function GetAllFile() {
		return $this->asFile;
	}
}
?>