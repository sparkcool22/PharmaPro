<?php
/****************************************************************************
 *	Create by Artit P.
 *	on June 8, 2006
 *	Last modified on June 8, 2006
 ****************************************************************************
 *	Copyright by Artit P., You can freely use this script without
 *	modified it. I don't responsible for any damage cause by
 *	this script.
 ****************************************************************************
 *
 ****************************************************************************

 ****************************************************************************/

class DBExport {
	var $oDB;
	var $sNewLine;

	function DBExport(&$oDB) {
		$this->oDB =& $oDB;
		$this->sNewLine = "\n";
	}
	
	function GetCSVFromSQL($sSQL, $asFieldLabel=NULL) {
		$oRes = $this->oDB->Query($sSQL);
		// Add field to first record
		$asData = array();
		$sLabel = '';
		if (is_array($asFieldLabel)) {
			$sLabel = '"'.implode('","', $asFieldLabel).'"';
		} else {
			// Get field label from field name
			$iCount = $oRes->FieldCount();
			for ($i = 0; $i < $iCount; $i++) {
				$asFieldLabel[] = $oRes->FieldName($i);
			}
			$sLabel = '"'.implode('","', $asFieldLabel).'"';
		}
		$asData[] = $sLabel;
		if ($oRes) {
			while ($axRow = $oRes->FetchRow()) {
				$asData[] = '"'.implode('","', $axRow).'"';
			}
		}
		return $asData;
	}
	
	function GetCSVFromTable($sTableName, $asFieldLabel=NULL, $xFieldList=NULL, $sCondition='', $sOther='') {
		if ($sTableName == '') {
			return array();
		}
		$asField = array();
		if (is_null($xFieldList)) {
			// Get table fields
			$oTable = new DBTableDef();
			$oTable->GetTableDef($this->oDB, $sTableName);
			$asField = $oTable->GetFields();
		} else {
			$asField = ToArray($xFieldList);
		}
		$oRes = $this->oDB->Select($sTableName, $asField, $sCondition, $sOther);
		$asData = array();
		// Add field to first record
		if (is_null($asFieldLabel)) {
			$asData[] = '"'.implode('","', $asField).'"';
		} else {
			$asData[] = '"'.implode('","', $asFieldLabel).'"';
		}
		if ($oRes) {
			while ($axRow = $oRes->FetchRow(DBI_ASSOC)) {
				// Order field by input
				$asTempData = array();
				for ($i = 0; $i < count($asField); $i++) {
					$asTempData[] = $axRow[$asField[$i]];
				}
				$asData[] = '"'.implode('","', $asTempData).'"';
			}
		}
		return $asData;
	}
	
	function DownloadCSVFromTable($sFilename, $sTableName, $asFieldLabel=NULL, $xFieldList=NULL, $sCondition='', $sOther='') {
		if (strpos(strtolower($sFilename), '.csv') === FALSE) {
			$sFilename .= '.csv';
		}
		header('Content-Type: application/octet-stream');
		header('Content-Disposition: attachment; filename="'.$sFilename.'"');
		$asLine = $this->GetCSVFromTable($sTableName, $asFieldLabel, $xFieldList, $sCondition, $sOther);
		for ($i = 0; $i < count($asLine); $i++) {
			echo($asLine[$i].$this->sNewLine);
		}
	}
	
	function DownloadCSVFromSQL($sFilename, $sSQL, $asFieldLabel=NULL) {
		if (strpos(strtolower($sFilename), '.csv') === FALSE) {
			$sFilename .= '.csv';
		}
		header('Content-Type: application/octet-stream');
		header('Content-Disposition: attachment; filename="'.$sFilename.'"');
		$asLine = $this->GetCSVFromSQL($sSQL, $asFieldLabel);
		for ($i = 0; $i < count($asLine); $i++) {
			echo($asLine[$i].$this->sNewLine);
		}
	}
	
	function DownloadCSVFromArray(&$asData, $sFilename, $asFieldLabel=NULL, $xFieldList=NULL) {
		$asField = ToArray($xFieldList);

		if (strpos(strtolower($sFilename), '.csv') === FALSE) {
			$sFilename .= '.csv';
		}
		header('Content-Type: application/octet-stream');
		header('Content-Disposition: attachment; filename="'.$sFilename.'"');
		echo('"'.implode('","', $asFieldLabel).'"'.$this->sNewLine);

		for ($i = 0; $i < count($asData); $i++) {
			// Order field by input
			$asTempData = array();
			for ($j = 0; $j < count($asField); $j++) {
				$asTempData[] = $asData[$i][$asField[$j]];
			}
			echo('"'.implode('","', $asTempData).'"'.$this->sNewLine);
		}
	}
}
?>