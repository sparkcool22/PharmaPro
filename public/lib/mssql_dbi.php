<?php
/****************************************************************************
 *	Create by Artit P.
 *	on December 1, 2005
 *	Last modified on December 1, 2005
 ****************************************************************************
 *	Copyright by Artit P., You can freely use this script without
 *	modified it. I don't responsible for any damage cause by
 *	this script.
 ****************************************************************************

 ****************************************************************************
 	Class MSSQLInterface
 	Class MSSQLResult
	Class DatabaseInterface
 ****************************************************************************/
define('DBI_ASSOC', MSSQL_ASSOC);
define('DBI_NUM', MSSQL_NUM);
define('DBI_BOTH', MSSQL_BOTH);

class MSSQLInterface {
	var $iCon;
	var $bError;
	var $iResultMode;
	var $sDB;
	var $sDBServerName;
	var $oTracker;
	
	var $sSql;

	function __constructor($sServer='', $sUser='', $sPassword='', $sDB='', $bPersistent=TRUE) {
		$this->MSSQLInterface($sServer, $sUser, $sPassword, $sDB, $bPersistent);
	}

	function MSSQLInterface($sServer='', $sUser='', $sPassword='', $sDB='', $bPersistent=TRUE) {
		// Init variables
		$this->iResultMode = DBI_NUM;
		$this->sDBServerName = 'MSSQL';

		if ($sServer != '') {
			$this->Connect($sServer, $sUser, $sPassword, $sDB, $bPersistent);
		}
	}
	
	function SetTracker(&$oT) {
		$this->oTracker =& $oT;
	}

	function Connect($sServer='', $sUser='', $sPassword='', $sDB='', $bPersistent=TRUE) {
		if ($bPersistent) {
			$this->iCon = mssql_pconnect($sServer, $sUser, $sPassword);
		} else {
			$this->iCon = mssql_connect($sServer, $sUser, $sPassword);
		}
		if (!$this->iCon) {
			// Connection error
			$this->bError = TRUE;
			if (is_object($this->oTracker)) {
				$this->oTracker->Add('Cannot open connection to database server : '.mssql_get_last_message(), E_ERROR, __FUNCTION__, __CLASS__);
			}
		} elseif ($sDB != '') {
			// Select database
			$this->bError = !mssql_select_db($sDB, $this->iCon);
			if (is_object($this->oTracker) && ($this->bError)) {
				$this->oTracker->Add('Cannot select database "'.$sDB.'",<br> '.mssql_get_last_message($this->iCon), E_ERROR, __FUNCTION__, __CLASS__);
			}
		}
	}

	function Close() {
		if ($this->iCon) {
			return mssql_close($this->iCon);
		}
	}

	function SelectDB($sDB) {
		$this->bError = mssql_select_db($sDB, $this->iCon);
		if (is_object($this->oTracker) && $this->bError) {
			$this->oTracker->Add('Cannot select database "'.$sDB.'",<br> '.mssql_get_last_message($this->iCon), E_ERROR, __FUNCTION__, __CLASS__);
		}
		return !$this->bError;
	}

	function IsError() {
		return $this->bError;
	}

	function Error() {
		if ($this->bError) {
			return mssql_get_last_message();
		} else {
			return '';
		}
	}

	function SetResultMode($iMode) {
		$this->iResultMode = $iMode;
	}

	function QueryOne($sSql) {
		$this->sSql = $sSql;
		$iResult = mssql_query($sSql, $this->iCon);
		if ($iResult === FALSE) {
			$this->bError = TRUE;
			if (is_object($this->oTracker)) {
				$this->oTracker->Add('Query error "'.$sSql.'",<br> '.mssql_get_last_message(), E_ERROR, __FUNCTION__, __CLASS__);
			}
			return FALSE;
		} else {
			$this->bError = FALSE;
			$axRow = mssql_fetch_row($iResult);
			mssql_free_result($iResult);
			if (is_object($this->oTracker)) {
				$this->oTracker->Add('QUERY "'.$sSql.'"', E_NOTICE, __FUNCTION__, __CLASS__);
			}
			return $axRow[0];
		}
	}

	function QueryRow($sSql, $iMode=NULL) {
		$this->sSql = $sSql;
		$iResult = mssql_query($sSql, $this->iCon);
		if ($iResult === FALSE) {
			$this->bError = TRUE;
			if (is_object($this->oTracker)) {
				$this->oTracker->Add('Query error "'.$sSql.'",<br> '.mssql_get_last_message(), E_ERROR, __FUNCTION__, __CLASS__);
			}
			return FALSE;
		} else {
			$this->bError = FALSE;
			$axRow = mssql_fetch_array($iResult, is_null($iMode)? $this->iResultMode: $iMode);
			mssql_free_result($iResult);
			if (is_object($this->oTracker)) {
				$this->oTracker->Add('QUERY "'.$sSql.'"', E_NOTICE, __FUNCTION__, __CLASS__);
			}
			return $axRow;
		}
	}

	function Query($sSql, $iMode=NULL) {
		$this->sSql = $sSql;
		$iResult = mssql_query($sSql, $this->iCon);
		if ($iResult === FALSE) {
			$this->bError = TRUE;
			if (is_object($this->oTracker)) {
				$this->oTracker->Add('Query error "'.$sSql.'",<br> '.mssql_get_last_message(), E_ERROR, __FUNCTION__, __CLASS__);
			}
			return FALSE;
		} else {
			$this->bError = FALSE;
			if (is_object($this->oTracker)) {
				$this->oTracker->Add('QUERY "'.$sSql.'"', E_NOTICE, __FUNCTION__, __CLASS__);
			}
			return new MSSQLResult($iResult, is_null($iMode)? $this->iResultMode: $iMode);
		}
	}

	function Execute($sSql) {
		$this->sSql = $sSql;
		$iResult = mssql_query($sSql, $this->iCon);
		$this->bError = !$iResult;
		if (is_object($this->oTracker)) {
			if ($this->bError) {
				$this->oTracker->Add('Query error "'.$sSql.'",<br> '.mssql_get_last_message(), E_ERROR, __FUNCTION__, __CLASS__);
			} else {
				$this->oTracker->Add('QUERY "'.$sSql.'"', E_NOTICE, __FUNCTION__, __CLASS__);
			}
		}
		return $iResult;
	}

	function RowAffected() {
		return mssql_rows_affected($this->iCon);
	}

	function GetIdentity() {
		return $this->QueryOne("SELECT @@IDENTITY");
	}

	function Escape($sStr) {
		$sStr = str_replace('\'', "''", $sStr);
		return $sStr;
	}
}

/**
 *	Encapsulate mssql_result
 */
class MSSQLResult {
	var $iResult;
	var $iResultMode;

	function MSSQLResult($iResult, $iMode) {
		$this->iResult = $iResult;
		$this->iResultMode = $iMode;
	}

	function Free() {
		mssql_free_result($this->iResult);
	}

	function SetResultMode($iMode) {
		$this->iResultMode = $iMode;
	}

	function FetchRow($iMode=NULL) {
		return mssql_fetch_array($this->iResult, is_null($iMode)? $this->iResultMode: $iMode);
	}

	function FetchAllRow($iMode=NULL) {
		$aaxRow = array();
		while ($axRow = mssql_fetch_array($this->iResult, is_null($iMode)? $this->iResultMode: $iMode)) {
			$aaxRow[] = $axRow;
		}
		return $aaxRow;
	}

	function SeekRow($iRow) {
		return mssql_data_seek($this->iResult, $iRow);
	}

	function RowCount() {
		return mssql_num_rows($this->iResult);
	}
}

class DatabaseInterface extends MSSQLInterface {
	function __constructor($sServer='', $sUser='', $sPassword='', $sDB='', $bPersistent=TRUE) {
		parent::__constructor($sServer, $sUser, $sPassword, $sDB, $bPersistent);
	}
}
?>