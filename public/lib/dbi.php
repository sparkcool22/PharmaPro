<?php
/****************************************************************************
 *	Create by Artit P.
 *	on July 9, 2005
 *	Last modified on July 13, 2006
 ****************************************************************************
 *	Copyright by Artit P., You can freely use this script without
 *	modified it. I don't responsible for any damage cause by
 *	this script.
 ****************************************************************************
 *	Handle database connection
 *	Inherit from MySQLInterface in "mysql_dbi"
 * Must include <DBServer>_dbi in caller script
 ****************************************************************************
	Class DBInterface
 ****************************************************************************/

// Base Class Database Interface
class DBInterface extends DatabaseInterface {
	var $bAutoEscape;

	function DBInterface($xServer = '', $sUser = '', $sPassword = '', $sDB = '', $bPersistent = TRUE) {
		if (is_resource($xServer)) {
			$this->iCon = $xServer;
		} else {
			parent::__constructor($xServer, $sUser, $sPassword, $sDB, $bPersistent);
		}
		$bAutoEscape = FALSE;
	}
	
	function SetAutoEscape($bEscape) {
		$this->bAutoEscape = $bEscape;
	}

	function Insert($sTable, $axData) {
		$asKey = array_keys($axData);
		$sField = implode(',', $asKey);
		$sValue = '';
		for ($i = 0; $i < count($asKey); $i++) {
			$xData = $axData[$asKey[$i]];
			if (is_string($xData)) {
				if (($xData[0] == '@') && ($xData[strlen($xData) - 1] == ')')) {
					if ($this->sDBServerName == 'PostgreSQL') {
						if ($xData[strlen($xData) - 2] == '(') {
							$sValue .= substr($xData, 1, strlen($xData) - 3).',';
						} else {
							$sValue .= substr($xData, 1, strlen($xData)).',';
						}
					} elseif ($this->sDBServerName == 'MySQL') {
						$sValue .= substr($xData, 1, strlen($xData)).',';
					} else {
						$sValue .= substr($xData, 1, strlen($xData)).',';
					}
				} else {
					if ($this->bAutoEscape) {
						$xData = $this->Escape($xData);
					}
					$sValue .= "'$xData',";
				}
			} elseif (is_null($xData)) {
				$sValue .= 'NULL,';
			} elseif ($xData === '') {
				$sValue .= 'NULL,';
			} else {
				$sValue .= $xData.',';
			}
		}
		$sValue = substr($sValue, 0, strlen($sValue) - 1);
		$sSql = "INSERT INTO $sTable ($sField) VALUES($sValue)";
		return $this->Execute($sSql);
	}

	function Update($sTable, $axData, $sCondition) {
		$sSql = '';
		foreach ($axData as $sKey => $xValue) {
			if (is_string($xValue)) {
				if (($xValue[0] == '@') && ($xValue[strlen($xValue) - 1] == ')')) {
					if ($this->sDBServerName == 'PostgreSQL') {
						if ($xValue[strlen($xValue) - 2] == '(') {
							$sSql .= "$sKey=".substr($xValue, 1, strlen($xValue) - 3).',';
						} else {
							$sSql .= "$sKey=".substr($xValue, 1, strlen($xValue)).',';
						}
					} elseif ($this->sDBServerName == 'MySQL') {
						$sSql .= "$sKey=".substr($xValue, 1, strlen($xValue)).',';
					} else {
						$sSql .= "$sKey=".substr($xValue, 1, strlen($xValue)).',';
					}
				} else {
					if ($this->bAutoEscape) {
						$xValue = $this->Escape($xValue);
					}
					$sSql .= "$sKey='$xValue',";
				}
			} elseif ($xValue === NULL) {
				$sSql .= "$sKey=NULL,";
			} elseif ($xValue === '') {
				$sSql .= "$sKey=NULL,";
			} else {
				$sSql .= "$sKey=$xValue,";
			}
		}
		$sSql = substr($sSql, 0, strlen($sSql) - 1);
		$sSql = "UPDATE $sTable SET $sSql WHERE $sCondition";
		return $this->Execute($sSql);
	}
	
	function Select($sTable, $xField, $sCondition='', $sOther='') {
		$sSql = '';
		if (is_array($xField)) {
			$sField = implode(',', $xField);
		} else {
			$sField = $xField;
		}
		$sSql = "SELECT $sField FROM $sTable";
		if ($sCondition != '') {
			$sSql .= " WHERE $sCondition";
		}
		if ($sOther != '') {
			$sSql .= ' '.$sOther;
		}
		return $this->Query($sSql);
	}
	
	function SelectRow($sTable, $xField, $sCondition='', $sOther='', $iMode=NULL) {
		$sSql = '';
		if (is_array($xField)) {
			$sField = implode(',', $xField);
		} else {
			$sField = $xField;
		}
		$sSql = "SELECT $sField FROM $sTable";
		if ($sCondition != '') {
			$sSql .= " WHERE $sCondition";
		}
		if ($sOther != '') {
			$sSql .= ' '.$sOther;
		}
		return $this->QueryRow($sSql, is_null($iMode)? $this->iResultMode: $iMode);
	}
}
?>