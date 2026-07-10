<?
/****************************************************************************
 *	Create by Artit P.
 *	on September 10, 2005
 *	Last modified on January 30, 2006
 ****************************************************************************
 *	Copyright by Artit P., You can freely use this script without
 *	modified it. I don't responsible for any damage cause by
 *	this script.
 ****************************************************************************
 *	Handle PostgreSQL database connection and query
 ****************************************************************************
 	Class PgSQLInterface
 	Class PgSQLResult
 ****************************************************************************/
define('DBI_ASSOC', PGSQL_ASSOC);
define('DBI_NUM', PGSQL_NUM);
define('DBI_BOTH', PGSQL_BOTH);

class PgSQLInterface {
	var $iCon;
	var $bError;
	var $iResultMode;
	var $sDB;
	var $sDBServerName;
	var $oTracker;
	
	var $oResult;		// Use for PG only

	var $sSql;

	function __constructor($sServer='', $sUser='', $sPassword='', $sDB='', $bPersistent=TRUE) {
		$this->PgSQLInterface($sServer, $sUser, $sPassword, $sDB, $bPersistent);
	}

	function PgSQLInterface($sServer='', $sUser='', $sPassword='', $sDB='', $bPersistent=TRUE) {
		// Init variables
		$this->iResultMode = PGSQL_NUM;
		$this->sDBServerName = 'PostgreSQL';

		if ($sServer != '') {
			$this->Connect($sServer, $sUser, $sPassword, $sDB, $bPersistent);
		}
	}
	
	function SetTracker(&$oT) {
		$this->oTracker =& $oT;
	}

	function Connect($sServer='', $sUser='', $sPassword='', $sDB='', $bPersistent=TRUE) {
		$sConnStr = '';
		if ($sServer != '') {
			$sConnStr .= "host=$sServer ";
		}
		if ($sUser != '') {
			$sConnStr .= "user=$sUser ";
		}
		if ($sUser != '') {
			$sConnStr .= "password=$sPassword ";
		}
		if ($sUser != '') {
			$sConnStr .= "dbname=$sDB ";
		}
		if ($bPersistent) {
			$this->iCon = pg_pconnect($sConnStr);
		} else {
			$this->iCon = pg_connect($sConnStr);
		}
		if (!$this->iCon) {
			// Connection error
			$this->bError = TRUE;
			if (is_object($this->oTracker)) {
				$this->oTracker->Add('Cannot open connection to database server : '.pg_last_error(), E_ERROR, __FUNCTION__, __CLASS__);
			}
		}
	}

	function Close() {
		if ($this->iCon) {
			return pg_close($this->iCon);
		}
	}

	function IsError() {
		return $this->bError;
	}

	function Error() {
		if ($this->bError) {
			if ($this->iCon) {
				return pg_last_error($this->iCon);
			} else {
				return pg_last_error();
			}
		} else {
			return '';
		}
	}

	function SetResultMode($iMode) {
		$this->iResultMode = $iMode;
	}

	function QueryOne($sSql) {
		$this->sSql = $sSql;
		$iResult = pg_query($this->iCon, $sSql);
		$this->oResult = $iResult;
		if ($iResult == FALSE) {
			$this->bError = TRUE;
			if (is_object($this->oTracker)) {
				$this->oTracker->Add('QUERY "'.$sSql.'",<br> '.pg_last_error($this->iCon), E_ERROR, __FUNCTION__, __CLASS__);
			}
			return FALSE;
		} else {
			$this->bError = FALSE;
			$axRow = pg_fetch_row($iResult);
			pg_free_result($iResult);
			if (is_object($this->oTracker)) {
				$this->oTracker->Add('QUERY "'.$sSql.'"', E_NOTICE, __FUNCTION__, __CLASS__);
			}
			return $axRow[0];
		}
	}

	function QueryRow($sSql, $iMode=NULL) {
		$this->sSql = $sSql;
		$iResult = pg_query($this->iCon, $sSql);
		$this->oResult = $iResult;
		if ($iResult === FALSE) {
			$this->bError = TRUE;
			if (is_object($this->oTracker)) {
				$this->oTracker->Add('QUERY "'.$sSql.'",<br> '.pg_last_error($this->iCon), E_ERROR, __FUNCTION__, __CLASS__);
			}
			return FALSE;
		} else {
			$this->bError = FALSE;
			$axRow = pg_fetch_array($iResult, NULL, is_null($iMode)? $this->iResultMode: $iMode);
			pg_free_result($iResult);
			if (is_object($this->oTracker)) {
				$this->oTracker->Add('QUERY "'.$sSql.'"', E_NOTICE, __FUNCTION__, __CLASS__);
			}
			return $axRow;
		}
	}

	function Query($sSql, $iMode=NULL) {
		$this->sSql = $sSql;
		$iResult = pg_query($this->iCon, $sSql);
		$this->oResult = $iResult;
		if ($iResult === FALSE) {
			$this->bError = TRUE;
			if (is_object($this->oTracker)) {
				$this->oTracker->Add('QUERY "'.$sSql.'",<br> '.pg_last_error($this->iCon), E_ERROR, __FUNCTION__, __CLASS__);
			}
			return FALSE;
		} else {
			$this->bError = FALSE;
			if (is_object($this->oTracker)) {
				$this->oTracker->Add('QUERY "'.$sSql.'"', E_NOTICE, __FUNCTION__, __CLASS__);
			}
			return new PgSQLResult($iResult, is_null($iMode)? $this->iResultMode: $iMode);
		}
	}

	function Execute($sSql) {
		$this->sSql = $sSql;
		$iResult = pg_query($this->iCon, $sSql);
		$this->oResult = $iResult;
		$this->bError = ($iResult === FALSE);
		if (is_object($this->oTracker)) {
			if ($this->bError) {
				$this->oTracker->Add('QUERY "'.$sSql.'",<br> '.pg_last_error($this->iCon), E_ERROR, __FUNCTION__, __CLASS__);
			} else {
				$this->oTracker->Add('QUERY "'.$sSql.'"', E_NOTICE, __FUNCTION__, __CLASS__);
			}
		}
		if ($iResult) { 
			return pg_affected_rows($iResult);
		} else {
			return 0;
		}
	}

	function RowAffected() {
		return pg_affected_rows($this->oResult);
	}

	// Return escape string
	function Escape($sStr) {
		return pg_escape_string($sStr);
	}
}

/**
 *	Encapsulate pg_result
 */
class PgSQLResult {
	var $iResult;
	var $iResultMode;

	function PgSQLResult($iResult, $iMode) {
		$this->iResult = $iResult;
		$this->iResultMode = $iMode;
	}

	function Free() {
		pg_free_result($this->iResult);
	}

	function SetResultMode($iMode) {
		$this->iResultMode = $iMode;
	}

	function FetchRow($iMode=NULL, $iRow=NULL) {
		return pg_fetch_array($this->iResult, $iRow, is_null($iMode)? $this->iResultMode: $iMode);
	}

	function FetchAllRow() {
		$aaxRow = pg_fetch_all($this->iResult);
		return $aaxRow;
	}

	function RowCount() {
		return pg_num_rows($this->iResult);
	}
}

class DatabaseInterface extends PgSQLInterface {
	function __constructor($sServer='', $sUser='', $sPassword='', $sDB='', $bPersistent=TRUE) {
		parent::__constructor($sServer, $sUser, $sPassword, $sDB, $bPersistent);
	}
}
?>