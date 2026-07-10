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

 ****************************************************************************
 	Class MySQLInterface
 	Class MySQLResult
	Class DatabaseInterface
 ****************************************************************************/
define('DBI_ASSOC', MYSQLI_ASSOC);
define('DBI_NUM', MYSQLI_NUM);
define('DBI_BOTH', MYSQLI_BOTH);

class MySQLInterface {
	var $iCon;
	var $bError;
	var $iResultMode;
	var $sDB;
	var $sDBServerName;
	var $oTracker;
	
	var $sSql;

	function __constructor($sServer='', $sUser='', $sPassword='', $sDB='', $bPersistent=TRUE) {
		$this->MySQLInterface($sServer, $sUser, $sPassword, $sDB, $bPersistent);
	}

	function MySQLInterface($sServer='', $sUser='', $sPassword='', $sDB='', $bPersistent=TRUE) {
		// Init variables
		$this->iResultMode = DBI_NUM;
		$this->sDBServerName = 'MySQL';

		if ($sServer != '') {
			$this->Connect($sServer, $sUser, $sPassword, $sDB, $bPersistent);
		}
	}
	
	function SetTracker(&$oT) {
		$this->oTracker =& $oT;
	}

	function Connect($sServer='', $sUser='', $sPassword='', $sDB='', $bPersistent=TRUE) {
		if ($bPersistent) {
			$this->iCon = mysqli_pconnect($sServer, $sUser, $sPassword);
		} else {
			$this->iCon = mysqli_connect($sServer, $sUser, $sPassword);	

		}
		if (!$this->iCon) {
			// Connection error
			$this->bError = TRUE;
			if (is_object($this->oTracker)) {
				$this->oTracker->Add('Cannot open connection to database server : '.mysqli_error(), E_ERROR, __FUNCTION__, __CLASS__);
			}
		} elseif ($sDB != '') {
			// Select database
			//$this->bError = !mysqli_select_db($sDB, $this->iCon);
			$this->bError = !mysqli_select_db($this->iCon, $sDB );
			if (is_object($this->oTracker)) {
				if ($this->bError) {
					$this->oTracker->Add('Cannot select database "'.$sDB.'",<br> '.mysqli_error($this->iCon), E_ERROR, __FUNCTION__, __CLASS__);
				} else {
					$this->oTracker->Add('Change database to "'.$sDB.'"');
				}
			}
		}
	}

	function Close() {
		if ($this->iCon) {
			if (is_object($this->oTracker)) {
				$this->oTracker->Add('DB Connection Closed.');
			}
			return mysqli_close($this->iCon);
		}
	}

	function SelectDB($sDB) {
		$this->bError = mysql_select_db($sDB, $this->iCon);
		if (is_object($this->oTracker)) {
			if ($this->bError) {
				$this->oTracker->Add('Cannot select database "'.$sDB.'",<br> '.mysql_error($this->iCon), E_ERROR, __FUNCTION__, __CLASS__);
			} else {
				$this->oTracker->Add('Change database to "'.$sDB.'"');
			}
		}
		return !$this->bError;
	}

	function IsError() {
		return $this->bError;
	}

	function Error() {
		if ($this->bError) {
			if ($this->iCon) {
				return mysql_error($this->iCon);
			} else {
				return mysql_error();
			}
		} else {
			return '';
		}
	}

	function SetResultMode($iMode) {
		if (is_object($this->oTracker)) {
			$this->oTracker->Add('Set default query result mode to '.$iMode);
		}
		$this->iResultMode = $iMode;
	}

	function QueryOne($sSql) {
		$this->sSql = $sSql;
		$iResult = mysqli_query($this->iCon, $sSql);
		if ($iResult === FALSE) {
			$this->bError = TRUE;
			if (is_object($this->oTracker)) {
				$this->oTracker->Add('SQL : '.$sSql.'<br> '.mysql_error(), E_ERROR, __FUNCTION__, __CLASS__);
			}
			return FALSE;
		} else {
			$this->bError = FALSE;
			$axRow = mysqli_fetch_row($iResult);
			mysqli_free_result($iResult);
			if (is_object($this->oTracker)) {
				$this->oTracker->Add('SQL : '.$sSql, E_NOTICE, __FUNCTION__, __CLASS__);
			}
			return $axRow[0];
		}
	}

	function QueryRow($sSql, $iMode=NULL) {
		$this->sSql = $sSql;
		$iResult = mysqli_query($this->iCon, $sSql);
		if ($iResult === FALSE) {
			$this->bError = TRUE;
			if (is_object($this->oTracker)) {
				$this->oTracker->Add('SQL : '.$sSql.'<br> '.mysql_error(), E_ERROR, __FUNCTION__, __CLASS__);
			}
			return FALSE;
		} else {
			$this->bError = FALSE;
			$axRow = mysqli_fetch_array($iResult, is_null($iMode)? $this->iResultMode: $iMode);
			// $axRow = mysqli_fetch_array($iResult, MYSQLI_ASSOC);
			mysqli_free_result($iResult);
			if (is_object($this->oTracker)) {
				$this->oTracker->Add('SQL : '.$sSql, E_NOTICE, __FUNCTION__, __CLASS__);
			}
			return $axRow;
		}
	}

	function Query($sSql, $iMode=NULL) {
		$this->sSql = $sSql;
		$iResult = mysqli_query($this->iCon, $sSql);
		if ($iResult === FALSE) {
			$this->bError = TRUE;
			if (is_object($this->oTracker)) {
				$this->oTracker->Add('SQL : '.$sSql.'<br> '.mysql_error(), E_ERROR, __FUNCTION__, __CLASS__);
			}
			return FALSE;
		} else {
			$this->bError = FALSE;
			if (is_object($this->oTracker)) {
				$this->oTracker->Add('SQL : '.$sSql, E_NOTICE, __FUNCTION__, __CLASS__);
			}
			return new MySQLResult($iResult, is_null($iMode)? $this->iResultMode: $iMode);
		}
	}

	function Execute($sSql) {
		$this->sSql = $sSql;
		// $iResult = mysqli_query($sSql, $this->iCon);
		$iResult = mysqli_query($this->iCon, $sSql);
		$this->bError = !$iResult;
		if (is_object($this->oTracker)) {
			if ($this->bError) {
				$this->oTracker->Add('SQL : '.$sSql.'<br> '.mysql_error(), E_ERROR, __FUNCTION__, __CLASS__);
			} else {
				$this->oTracker->Add('SQL : '.$sSql, E_NOTICE, __FUNCTION__, __CLASS__);
			}
		}
		return $iResult;
	}

	function RowAffected() {
		return mysql_affected_rows($this->iCon);
	}

	function GetIdentity() {
		return mysql_insert_id($this->iCon);
	}

	function Escape($sStr) {
		return mysql_real_escape_string($sStr, $this->iCon);
	}
	
	function QueryOneRow($sTable) {
		return $this->Query("SELECT * FROM $sTable LIMIT 1");
	}
}

/**
 *	Encapsulate mysql_result
 */
class MySQLResult {
	var $iResult;
	var $iResultMode;

	function MySQLResult($iResult, $iMode) {
		$this->iResult = $iResult;
		$this->iResultMode = $iMode;
	}

	function Free() {
		mysql_free_result($this->iResult);
	}

	function SetResultMode($iMode) {
		$this->iResultMode = $iMode;
	}

	function FetchRow($iMode=NULL) {
		return mysqli_fetch_array($this->iResult, is_null($iMode)? $this->iResultMode: $iMode);
	}

	function FetchAllRow($iMode=NULL) {
		$aaxRow = array();
		while ($axRow = mysqli_fetch_array($this->iResult, is_null($iMode)? $this->iResultMode: $iMode)) {
			$aaxRow[] = $axRow;
		}
		return $aaxRow;
	}

	function SeekRow($iRow) {
		return mysqli_data_seek($this->iResult, $iRow);
	}

	function RowCount() {
		return mysqli_num_rows($this->iResult);
	}
	
	function FieldCount() {
		return mysqli_num_fields($this->iResult);
	}
	
	function FieldName($i) {
		return mysqli_field_name($this->iResult, $i);
	}
	
	function FieldType($i) {
		return mysqli_field_type($this->iResult, $i);
	}
	
	function FieldLength($i) {
		return mysqli_field_len($this->iResult, $i);
	}

	function FieldFlags($i) {
		return mysqli_field_flags($this->iResult, $i);
	}
}

class DatabaseInterface extends MySQLInterface {
	function __constructor($sServer='', $sUser='', $sPassword='', $sDB='', $bPersistent=TRUE) {
		parent::__constructor($sServer, $sUser, $sPassword, $sDB, $bPersistent);
	}
}
?>