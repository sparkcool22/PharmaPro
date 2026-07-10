<?php
/****************************************************************************
 *	Create by Artit P.
 *	on September 30, 2005
 *	Last modified on October 5, 2005
 ****************************************************************************
 *	Copyright by Artit P., You can freely use this script without
 *	modified it. I don't responsible for any damage cause by
 *	this script.
 ****************************************************************************

 ****************************************************************************
	Class Tracker
 ****************************************************************************/

class Tracker {
	var $asMsg;
	var $aiType;
	var $asFuncName;
	var $asClass;
	var $asFile;
	var $asLine;
	var $bShowFileName;
	var $bShowCallInfo;
	var $iTrackLevel;
	var $bHaltOnError;
	
	function Tracker($iTL=E_NOTICE) {
		$this->asMsg = array();
		$this->aiType = array();
		$this->asFuncName = array();
		$this->asClass = array();
		$this->asFile = array();
		$this->asLine = array();
		$this->bShowFileName = FALSE;
		$this->bShowCallInfo = FALSE;
		$this->iTrackLevel = $iTL;
		$this->bHaltOnError = FALSE;
	}
	
	function SetShowFileName($bSF) {
		$this->bShowFileName = $bSF;
	}
	
	function SetHaltOnError($bHOE) {
		$this->bHaltOnError = $bHOE;
	}
	
	function Add($sMsg, $iType=E_NOTICE, $sFunc=NULL, $sClass=NULL, $sFile=NULL, $sLine=NULL) {
		if ($iType <= $this->iTrackLevel) {
			$this->asMsg[] = $sMsg;
			$this->aiType[] = $iType;
			$this->asFuncName[] = $sFunc;
			$this->asClass[] = $sClass;
			$this->asFile[] = $sFile;
			$this->asLine[] = $sLine;
		}
		if (($iType == E_ERROR) && ($this->bHaltOnError)) {
			echo($this->GetAll());
			exit();
		}
	}
	
	function Clear() {
		$this->asMsg = array();
		$this->aiType = array();
		$this->asFuncName = array();
		$this->asClass = array();
		$this->asFile = array();
		$this->asLine = array();
	}
	
	function GetAll() {
		$sText = '';
		for ($i = 0; $i < count($this->asMsg); $i++) {
			$sColor = $this->GetTypeColor($this->aiType[$i]);
			$sText .= '<font color="'.$sColor.'"><strong>['.$this->GetTypeText($this->aiType[$i]);
			$sMsg = '';
			if ($this->bShowCallInfo) {
				if (!is_null($this->asClass[$i]) and ($this->asClass[$i] != '')) {
					$sMsg .= ' - CLASS:'.$this->asClass[$i];
				}
				if (!is_null($this->asFuncName[$i]) and ($this->asFuncName[$i] != '')) {
					$sMsg .= ' - FUNC:'.$this->asFuncName[$i];
				}
			}
			if ($this->bShowFileName) {
				if (!is_null($this->asFile[$i]) and ($this->asFile[$i] != '')) {
					$sMsg .= ' - FILE:'.$this->asFile[$i];
				}
				if (!is_null($this->asLine[$i]) and ($this->asLine[$i] != '')) {
					$sMsg .= ' - LINE:'.$this->asLine[$i];
				}
			}
			$sText .= $sMsg.']</strong> '.$this->asMsg[$i].'</font><br>';
		}
		return $sText;
	}
	
	function GetTypeColor($iType) {
		if ($iType == E_NOTICE) {
			return '#0000FF';
		} elseif ($iType == E_ERROR) {
			return '#FF0000';
		} elseif ($iType == E_WARNING) {
			return '#00BB00';
		} else {
			return '#666666';
		}
	}
	
	function GetTypeText($iType) {
		if ($iType == E_NOTICE) {
			return 'INFO';
		} elseif ($iType == E_ERROR) {
			return 'ERROR';
		} elseif ($iType == E_WARNING) {
			return 'WARNING';
		} else {
			return 'INFO';
		}		
	}
}
?>