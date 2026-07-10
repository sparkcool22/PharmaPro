<?php
/****************************************************************************
 *	Create by Artit P.
 *	on July 19, 2005
 *	Last modified on June 16, 2006
 ****************************************************************************
 *	Copyright by Artit P., You can freely use this script without
 *	modified it. I don't responsible for any damage cause by
 *	this script.
 ****************************************************************************
 *	Manage / List / Search content in database
 *	Require : Pagination, DBInterface
 *	Uses with MySQL, PostgreSQL or MSSQL Database
 ****************************************************************************
	Class DBTableDef
	Class SQLCondition
	Class DBDataProvider
	Class DBSQLDataProvider
	Class DBDataUpdater
	Class SessionOrder
 ****************************************************************************/
include_once('utils.php');
include_once('dbi.php');
include_once('pagination.php');

/**
 *	Class : DBTableDef
 *	Define table definition
 */
class DBTableDef {
	var $asFieldName;
	var $asFieldType;
	var $sIndexField;
	var $sIndexType;
	var $iFieldCount;
	var $sTableName;

	function DBTableDef($sTable='') {
		$this->sIndexField = 'id';
		$this->sIndexType = 'NUMBER';
		$this->iFieldCount = 0;
		$this->sTableName = $sTable;
	}

	function SetIndex($sName, $sType) {
		$this->sIndexField = $sName;
		$this->sIndexType = $sType;
	}

	function AddField($xName, $sType=NULL, $bIndex=FALSE) {
		if (is_array($xName)) {
			foreach ($xName as $sKey => $sVal) {
				$this->asFieldName[$this->iFieldCount] = $sKey;
				$this->asFieldType[$this->iFieldCount] = $sVal;
				$this->iFieldCount++;
			}
		} else {
			$this->asFieldName[$this->iFieldCount] = $xName;
			$this->asFieldType[$this->iFieldCount] = $sType;
			$this->iFieldCount++;
			if ($bIndex) {
				$this->SetIndex($xName, $sType);
			}
		}
	}

	function SetTableName($sTable) {
		$this->sTableName = $sTable;
	}

	function ClearField() {
		$this->asFieldName = array();
		$this->asFieldType = array();
		$this->iFieldCount = 0;
	}

	function GetFields() {
		return $this->asFieldName;
	}

	function GetFieldType($sFieldName) {
		$sResult = 'TEXT';
		for ($i = 0; $i < count($this->asFieldName); $i++) {
			if ($this->asFieldName[$i] == $sFieldName) {
				$sResult = $this->asFieldType[$i];
				break;
			}
		}
		return $sResult;
	}

	function FieldExists($sField) {
		for ($i = 0; $i < count($this->asFieldName); $i++) {
			if ($sField === $this->asFieldName[$i]) {
				return TRUE;
			}
		}
		return FALSE;
	}

	function GetTableDef(&$oDB, $sTable) {
		$this->sTableName = $sTable;
		$oRes = $oDB->QueryOneRow($sTable);
		if ($oRes) {
			$this->iFieldCount = $oRes->FieldCount();
			for ($i = 0; $i < $this->iFieldCount; $i++) {
				$this->asFieldName[$i] = $oRes->FieldName($i);
				$sType = $oRes->FieldType($i);
				if (($sType == 'int') || ($sType == 'tinyint') || ($sType == 'smallint') || ($sType == 'mediumint') ||
					($sType == 'float') || ($sType == 'double') || ($sType == 'decimal')) {
					$this->asFieldType[$i] = 'NUMBER';
				} elseif ($sType == 'datetime') {
					$this->asFieldType[$i] = 'DATETIME';
				} elseif ($sType == 'date') {
					$this->asFieldType[$i] = 'DATE';
				} elseif ($sType == 'time') {
					$this->asFieldType[$i] = 'TIME';
				} elseif (($sType == 'text') || ($sType == 'tinytext') || ($sType == 'mediumtext') || ($sType == 'longtext') ||
					($sType == 'char') || ($sType == 'varchar')) {
					$this->asFieldType[$i] = 'TEXT';
				} else {
					$this->asFieldType[$i] = 'TEXT';
				}
				if (strpos($oRes->FieldFlags($i), 'primary_key') !== FALSE) {
					$this->sIndexField = $this->asFieldName[$i];
					$this->sIndexType = $this->asFieldType[$i];
				}
			}
		}
	}
}

class SQLCondition {
	var $sCondition;
	var $sSQLCondition;
	var $oTable;

	function SQLCondition() {
		$this->sCondition = '';
		$this->sSQLCondition = '';
	}

	function SetTableDef($oTable) {
		$this->oTable =& $oTable;
	}

	function AddSearch($xFieldName, $xKeyword, $xSearchType='=', $xFieldType=NULL, $sOperator='AND') {
		if (trim(str_replace('%', '', $xKeyword)) == '') {
			return;
		}
		// Prepare data
		$asFieldName = ToArray($xFieldName);

		// Get Field type
		$asFieldType = array();
		if (!is_null($xFieldType)) {
			$asFieldType = ToArray($xFieldType);
		} elseif (isset($this->oTable)) {
			for ($i = 0; $i < count($asFieldName); $i++) {
				$asFieldType[$i] = $this->oTable->GetFieldType($asFieldName[$i]);
			}
		} else {
			for ($i = 0; $i < count($asFieldName); $i++) {
				$asFieldType[$i] = 'TEXT';
			}
		}

		$asKeyword = ToArray($xKeyword);
		$asSearchType = ToArray($xSearchType);
		// Adjust SearchType Count = Field Name Count
		$iFieldCount = count($asFieldName);
		if (count($asSearchType) < $iFieldCount) {
			$sSearchType = $asSearchType[count($asSearchType) - 1];
			while (count($asSearchType) < count($asFieldName)) {
				$asSearchType[] = $sSearchType;
			}
		}

		$sSearch = '';
		$iKeywordCount = count($asKeyword);
		for ($i = 0; $i < $iKeywordCount; $i++) {
			// Skip if keyword is empty
			if ($asKeyword[$i] != '') {
				$asSearch = array();
				for ($j = 0; $j < $iFieldCount; $j++) {
					if (($asSearchType[$j] == 'LIKE') || ($asSearchType[$j] == 'NOT LIKE')) {
						$asSearch[$j] = $asFieldName[$j].' '.$asSearchType[$j].' \''.$asKeyword[$i].'\'';
					} elseif (($asSearchType[$j] == 'IN') || ($asSearchType[$j] == 'NOT IN')) {
						$asSearch[$j] = $asFieldName[$j].' '.$asSearchType[$j].' ('.$asKeyword[$i].')';
					} else {
						if ($asFieldType[$j] == 'NUMBER') {
							$asSearch[$j] = $asFieldName[$j].$asSearchType[$j].$asKeyword[$i];
						} else {
							$asSearch[$j] = $asFieldName[$j].' '.$asSearchType[$j].' \''.$asKeyword[$i].'\'';
						}
					}
				}
				if ($sSearch == '') {
					$sSearch = '('.implode(' OR ', $asSearch).')';
				} else {
					$sSearch .= " $sOperator (".implode(' OR ', $asSearch).')';
				}
			}
		}
		if ($sSearch != '') {
			if ($this->sSQLCondition == '') {
				$this->sSQLCondition = "($sSearch)";
			} else {
				$this->sSQLCondition .= " AND ($sSearch)";
			}
		}
	}

	function AddAdvSearch($xFieldName, $xKeyword, $sOperator='AND') {
		if (trim($xKeyword) == '') {
			return;
		}
		// Prepare data
		$asFieldName = ToArray($xFieldName);
		$asKeyword = ToArray($xKeyword);

		$sSearch = '';
		$sCond = '';
		$iKeywordCount = count($asKeyword);
		$iFieldCount = count($asFieldName);
		for ($i = 0; $i < $iKeywordCount; $i++) {
			$asSearch = array();
			$asCond = array();
			for ($j = 0; $j < $iFieldCount; $j++) {
				$asTemp = $this->DecodeAdvKeyword($asFieldName[$j], $asKeyword[$i]);
				$asSearch[$j] = $asTemp[0];
				$asCond[$j] = $asTemp[1];
			}

			if ($sSearch == '') {
				$sSearch = '('.implode(') OR (', $asSearch).')';
				$sCond = '('.implode(') OR (', $asCond).')';
			} else {
				$sSearch .= " $sOperator (".implode(') OR (', $asSearch).')';
				$sCond .= " $sOperator (".implode(') OR (', $asCond).')';
			}
		}
		if ($this->sSQLCondition == '') {
			$this->sSQLCondition = "($sSearch)";
			$this->sCondition = "($sCond)";
		} else {
			$this->sSQLCondition .= " AND ($sSearch)";
			$this->sCondition = " AND ($sCond)";
		}
	}

	function DecodeAdvKeyword($sFieldName, $sKeyword) {
		$asResult = array('', '');
		$sKeyword .= ' ';
		$iLength = strlen($sKeyword);
		$sWord = '';
		$bInWord = FALSE;
		$bQuote = FALSE;
		$bAddOpt = TRUE;
		$bNot = FALSE;
		for ($i = 0; $i < $iLength; $i++) {
			if ($bQuote) {
				if ($sKeyword[$i] == '"') {
					$asTemp = $this->GetAdvSearchWord($sFieldName, $sWord, $bNot, $bAddOpt, $bQuote);
					$asResult[0] .= $asTemp[0];
					$asResult[1] .= $asTemp[1];
					$sWord = '';
					$bInWord = FALSE;
					$bQuote = FALSE;
					$asResult[1] .= '"';
				} else {
					$sWord .= $sKeyword[$i];
				}
			} else {
				if ($sKeyword[$i] == '(') {
					if ($bInWord) {
						$asTemp = $this->GetAdvSearchWord($sFieldName, $sWord, $bNot, $bAddOpt);
						$asResult[0] .= $asTemp[0];
						$asResult[1] .= $asTemp[1];
						$sWord = '';
						$bInWord = FALSE;
					}
					if (!$bAddOpt) {
						$asResult[0] .= ' OR ';
						$asResult[1] .= ' OR ';
						$bAddOpt = TRUE;
					}
					$asResult[0] .= $sKeyword[$i];
					$asResult[1] .= $sKeyword[$i];
				} elseif ($sKeyword[$i] == ')') {
					if ($bInWord) {
						$asTemp = $this->GetAdvSearchWord($sFieldName, $sWord, $bNot, $bAddOpt);
						$asResult[0] .= $asTemp[0];
						$asResult[1] .= $asTemp[1];
						$sWord = '';
						$bInWord = FALSE;
					}
					$bAddOpt = FALSE;
					$asResult[0] .= $sKeyword[$i];
					$asResult[1] .= $sKeyword[$i];
				} elseif (($sKeyword[$i] == '"')) {
					$bQuote = TRUE;
					if ($bInWord) {
						$asTemp = $this->GetAdvSearchWord($sFieldName, $sWord, $bNot, $bAddOpt);
						$asResult[0] .= $asTemp[0];
						$asResult[1] .= $asTemp[1];
						$sWord = '';
						$bInWord = FALSE;
					}
				} elseif ($sKeyword[$i] == '+') {
					if ($bInWord) {
						$asTemp = $this->GetAdvSearchWord($sFieldName, $sWord, $bNot, $bAddOpt);
						$asResult[0] .= $asTemp[0];
						$asResult[1] .= $asTemp[1];
						$sWord = '';
						$bInWord = FALSE;
					}
//					if (!bAddOpt) {
						$asResult[0] .= ' AND ';
						$asResult[1] .= ' AND ';
						$bAddOpt = TRUE;
//					}
				} elseif ($sKeyword[$i] == ',') {
					if ($bInWord) {
						$asTemp = $this->GetAdvSearchWord($sFieldName, $sWord, $bNot, $bAddOpt);
						$asResult[0] .= $asTemp[0];
						$asResult[1] .= $asTemp[1];
						$sWord = '';
						$bInWord = FALSE;
					}
//					if (!$bAddOpt) {
						$asResult[0] .= ' OR ';
						$asResult[1] .= ' OR ';
						$bAddOpt = TRUE;
//					}
				} elseif ($sKeyword[$i] == '-') {
					if ($bInWord) {
						$asTemp = $this->GetAdvSearchWord($sFieldName, $sWord, $bNot, $bAddOpt);
						$asResult[0] .= $asTemp[0];
						$asResult[1] .= $asTemp[1];
						$sWord = '';
						$bInWord = FALSE;
					}
					$bNot = TRUE;
				} elseif ($sKeyword[$i] != ' ') {
					$bInWord = TRUE;
					$sWord .= $sKeyword[$i];
				} elseif ($bInWord) {
					$asTemp = $this->GetAdvSearchWord($sFieldName, $sWord, $bNot, $bAddOpt);
					$asResult[0] .= $asTemp[0];
					$asResult[1] .= $asTemp[1];
					$bInWord = FALSE;
				}
			}
		}
		return $asResult;
	}

	function GetAdvSearchWord($sFieldName, &$sWord, &$bNot, &$bAddOpt, $bQuote=FALSE) {
		$asResult = array('', '');
		$sTemp = strtoupper($sWord);
		if (($sTemp == 'AND') || ($sTemp == 'OR') || ($sTemp == 'NOT')) {
			if (!$bAddOpt) {
				$asResult[0] = ' '.$sTemp.' ';
				$asResult[1] = ' '.$sTemp.' ';
				$bAddOpt = TRUE;
			}
		} else {
			if ($bNot) {
				if (!$bAddOpt) {
					$asResult[0] .= ' AND ';
					$asResult[1] .= ' AND ';
				}
				$asResult[0] .= " $sFieldName NOT LIKE '%$sWord%' ";
				if ($bQuote) {
					$asResult[1] .= '"';
				}
				$asResult[1] .= "-$sWord";
			} else {
				if (!$bAddOpt) {
					$asResult[0] .= ' AND ';
					$asResult[1] .= ' AND ';
				}
				$asResult[0] .= " $sFieldName LIKE '%$sWord%' ";
				if ($bQuote) {
					$asResult[1] .= '"';
				}
				$asResult[1] .= "$sWord";
			}
			$bAddOpt = FALSE;
		}
		$bNot = FALSE;
		$sWord = '';
		return $asResult;
	}

	function Clear() {
		$this->sCondition = '';
		$this->sSQLCondition = '';
	}

	function GetCondition() {
		return $this->sCondition;
	}

	function GetSQLCondition() {
		return $this->sSQLCondition;
	}
}

class DBDataProvider {
	var $asOrder;
	var $iOrderCount;
	var $oDB;
	var $oPage;
	var $oTable;

	function DBDataProvider(&$oDB, &$oTable) {
		$this->asOrder = array();
		$this->iOrderCount = 0;
		$this->oDB =& $oDB;
		$this->oTable =& $oTable;
	}

	function SetPagination(&$oPage) {
		$this->oPage =& $oPage;
	}

	function SetTableDef(&$oTable) {
		$this->oTable =& $oTable;
	}

	function AddOrder($sKey, $sVal='ASC') {
		if ((trim($sKey) != '') && !in_array($sKey, array_keys($this->asOrder))) {
			$this->asOrder[$sKey] = $sVal;
			$this->iOrderCount++;
		}
	}

	function ClearOrder() {
		$this->asOrder = array();
		$this->iOrderCount = 0;
	}

	function GetOrderCause() {
		// Create order cause
		$sOrder = '';
		foreach ($this->asOrder as $sKey => $sVal) {
			if ($sOrder == '') {
				$sOrder .= "$sKey $sVal";
			} else {
				$sOrder .= ",$sKey $sVal";
			}
		}
		if ($sOrder != '') {
			$sOrder = ' ORDER BY '.$sOrder.' ';
		}
		return $sOrder;
	}

	function GetLimitCause($iPage, $sCondition=NULL) {
		if (is_object($this->oPage)) {
			if (is_null($sCondition)) {
				$this->oPage->SetTotalRec($this->oDB->QueryOne('SELECT COUNT(*) FROM '.$this->oTable->sTableName));
			} else {
				$this->oPage->SetTotalRec($this->oDB->QueryOne('SELECT COUNT(*) FROM '.$this->oTable->sTableName.' WHERE '.$sCondition));
			}

			$this->oPage->SetCurPage($iPage);
			$this->oPage->DoPaging();
			if ($this->oDB->sDBServerName == 'PostgreSQL') {
				$sLimit = ' LIMIT '.$this->oPage->GetPerPage().' OFFSET '.$this->oPage->GetStartRec();
			} elseif ($this->oDB->sDBServerName == 'MySQL') {
				$sLimit = ' LIMIT '.$this->oPage->GetStartRec().','.$this->oPage->GetPerPage();
			}
		} else {
			$sLimit = '';
		}
		return $sLimit;
	}

	function ListData($iPage=1, $xField=NULL) {
		if (is_array($xField)) {
			$sField = implode(',', $xField);
		} elseif (is_string($xField)) {
			$sField = $xField;
		} else {
			$sField = implode(',', $this->oTable->GetFields());
		}
		if (!is_numeric($iPage)) {
			$iPage = 1;
		}
		// Create order cause
		$sOrder = $this->GetOrderCause();
		// Create limit cause
		$sLimit = $this->GetLimitCause($iPage);

		return $this->oDB->Select($this->oTable->sTableName, $sField, '', $sOrder.$sLimit);
	}

	function Search($sCondition, $iPage=1, $xField=NULL) {
		if (trim($sCondition) == '') {
			return $this->ListData($iPage, $xField);
		}
		if (is_array($xField)) {
			$sField = implode(',', $xField);
		} elseif (is_string($xField)) {
			$sField = $xField;
		} else {
			$sField = implode(',', $this->oTable->GetFields());
		}
		if (!is_numeric($iPage)) {
			$iPage = 1;
		}
		// Create order cause
		$sOrder = $this->GetOrderCause();
		// Create limit cause
		$sLimit = $this->GetLimitCause($iPage, $sCondition);

		return $this->oDB->Select($this->oTable->sTableName, $sField, $sCondition, $sOrder.$sLimit);
	}

	function GetData($sID, $iMode=NULL) {
		if ($this->oTable->sIndexType == 'NUMBER') {
			$sCondition = $this->oTable->sIndexField."=$sID";
		} else {
			$sCondition = $this->oTable->sIndexField."='$sID'";
		}
		return $this->oDB->SelectRow($this->oTable->sTableName, $this->oTable->GetFields(), $sCondition, '', is_null($iMode)? DBI_ASSOC: $iMode);
	}
}

class DBSQLDataProvider extends DBDataProvider{
	var $sSql;
	var $sCountSql;

	function DBSQLDataProvider(&$oDB) {
		$this->oDB =& $oDB;
		$this->asOrder = array();
		$this->iOrderCount = 0;
	}

	function SetSQL($sSql) {
		$this->sSql = $sSql;
	}

	function SetCountSQL($sSql) {
		$this->sCountSql = $sSql;
	}

	function GetLimitCause($iPage, $sCondition=NULL) {
		if (is_object($this->oPage)) {
			if (is_null($sCondition) || (trim($sCondition) == '')) {
				if ($this->sCountSql != '') {
					$sSql = $this->sCountSql;
					// Cut order cause
					if ($iPos = strpos(strtoupper($sSql), ' ORDER BY ')) {
						$sSql = substr($sSql, 0, $iPos);
					}
					$this->oPage->SetTotalRec($this->oDB->QueryOne($sSql));
				} else {
					$sSql = preg_replace('/^SELECT .+ FROM /i', 'SELECT COUNT(*) FROM ', $this->sSql);
					// Cut order cause
					if ($iPos = strpos(strtoupper($sSql), ' ORDER BY ')) {
						$sSql = substr($sSql, 0, $iPos);
					}
					$this->oPage->SetTotalRec($this->oDB->QueryOne($sSql));
				}
			} else {
				if ($this->sCountSql == '') {
					$sSql = preg_replace('/^SELECT .+ FROM /i', 'SELECT COUNT(*) FROM ', $this->sSql);
				} else {
					$sSql = $this->sCountSql;
				}
				// Cut order cause
				if ($iPos = strpos(strtoupper($sSql), ' ORDER BY ')) {
					$sSql = substr($sSql, 0, $iPos);
				}
				if (strpos(strtoupper($sSql), ' WHERE ') === FALSE) {
					$this->oPage->SetTotalRec($this->oDB->QueryOne($sSql.' WHERE '.$sCondition));
				} else {
					$this->oPage->SetTotalRec($this->oDB->QueryOne($sSql.' AND '.$sCondition));
				}
			}

			$this->oPage->SetCurPage($iPage);
			$this->oPage->DoPaging();
			if ($this->oDB->sDBServerName == 'PostgreSQL') {
				$sLimit = ' LIMIT '.$this->oPage->GetPerPage().' OFFSET '.$this->oPage->GetStartRec();
			} elseif ($this->oDB->sDBServerName == 'MySQL') {
				$sLimit = ' LIMIT '.$this->oPage->GetStartRec().','.$this->oPage->GetPerPage();
			} elseif ($this->oDB->sDBServerName == 'MSSQL') {
				$sLimit = ' rownum > '.$this->oPage->GetStartRec().' AND rownum <= '.($this->oPage->GetStartRec() + $this->oPage->GetPerPage());
			}
		} else {
			$sLimit = '';
		}
		return $sLimit;
	}

	// function ListData($iPage=1) {
	// 	if (!is_numeric($iPage)) {
	// 		$iPage = 1;
	// 	}
	// 	// Create order cause
	// 	$sOrder = $this->GetOrderCause();
	// 	// Create limit cause if Page > 0 else return all row
	// 	if ($iPage > 0) {
	// 		$sLimit = $this->GetLimitCause($iPage);
	// 	}
	// 	// Check for MSSQL server
	// 	if ($this->oDB->sDBServerName == 'MSSQL') {
	// 		// Page == 0 return all data
	// 		if ($iPage > 0) {
	// 			$sSql1 = preg_replace('/^SELECT (.+) FROM /i', 'SELECT IDENTITY(INT) AS rownum, \1 INTO #temp_table FROM ', $this->sSql);
	// 			$sSql2 = $this->sSql;

	// 			if ($sLimit != '') {
	// 				$sSql2 = preg_replace('/^(SELECT ).+ FROM (.+)( ((WHERE|ORDER BY|GROUP BY).*)|)/i', 'SELECT * FROM #temp_table WHERE ', $sSql2);
	// 			} else {
	// 				$sSql2 = preg_replace('/^(SELECT ).+ FROM (.+)( ((WHERE|ORDER BY|GROUP BY).*)|)/i', 'SELECT * FROM #temp_table ', $sSql2);
	// 			}

	// 			$sSql1 .= ' '.$sOrder;
	// 			$sSql2 .= ' '.$sLimit;
	// 			$sSql = "$sSql1;$sSql2";
	// 		} else {
	// 			$sSql = $this->sSql.' '.$sOrder;
	// 		}
	// 		return $this->oDB->Query($sSql);
	// 	} else {
	// 		$sSql = $this->sSql.' '.$sOrder.$sLimit;
	// 		return $this->oDB->Query($sSql);
	// 	}
	// }

	// function Search($sCondition, $iPage=1) {
	// 	if (trim($sCondition) == '') {
	// 		return $this->ListData($iPage);
	// 	}
	// 	if (!is_numeric($iPage)) {
	// 		$iPage = 1;
	// 	}
	// 	// Create order cause
	// 	$sOrder = $this->GetOrderCause();
	// 	// Create limit cause if Page > 0 else return all row
	// 	if ($iPage > 0) {
	// 		$sLimit = $this->GetLimitCause($iPage, $sCondition);
	// 	}
	// 	// Check for MSSQL server
	// 	if ($this->oDB->sDBServerName == 'MSSQL') {
	// 		// Page == 0 return all data
	// 		if ($iPage > 0) {
	// 			$sSql1 = preg_replace('/^SELECT (.+) FROM /i', 'SELECT IDENTITY(INT) AS rownum, \1 INTO #temp FROM ', $this->sSql);
	// 			if (strpos(strtoupper($this->sSql), ' WHERE ') === FALSE) {
	// 				$sSql1 = $sSql1.' WHERE '.$sCondition.' ';
	// 			} else {
	// 				$sSql1 = $sSql1.' AND '.$sCondition.' ';
	// 			}

	// 			$sSql2 = $this->sSql;
	// 			$sSql2 = preg_replace('/^(SELECT ).+ FROM (.+)( ((WHERE|ORDER BY|GROUP BY).*)|)/i', 'SELECT * FROM #temp WHERE ', $sSql2);

	// 			$sSql1 .= ' '.$sOrder;
	// 			$sSql2 .= ' '.$sLimit;
	// 			$sSql = "$sSql1;$sSql2";
	// 		} else {
	// 			$sSql = $this->sSql.' '.$sOrder;
	// 		}
	// 		return $this->oDB->Query($sSql);
	// 	} else {
	// 		if (strpos(strtoupper($this->sSql), ' WHERE ') === FALSE) {
	// 			$sSql = $this->sSql.' WHERE '.$sCondition.' '.$sOrder.$sLimit;
	// 		} else {
	// 			$sSql = $this->sSql.' AND '.$sCondition.' '.$sOrder.$sLimit;
	// 		}
	// 		return $this->oDB->Query($sSql);
	// 	}
	// }

	function GetData($sCondition, $iMode=NULL) {
		if (strpos(strtoupper($this->sSql), ' WHERE ') === FALSE) {
			$sSql = $this->sSql.' WHERE '.$sCondition;
		} else {
			$sSql = $this->sSql.' AND '.$sCondition;
		}
		return $this->oDB->QueryRow($sSql, is_null($iMode)? DBI_ASSOC: $iMode);
	}
}

class DBDataUpdater {
	var $oDB;
	var $oTable;
	var $axData;
	var $sFormPrefix;

	function DBDataUpdater(&$oDB, &$oTable, $sPrefix='du_') {
		$this->oDB =& $oDB;
		$this->oTable =& $oTable;
		$this->axData = array();
		$this->sFormPrefix = $sPrefix;
	}
	
	function ReadFrom($axData, $sPrefix=NULL) {
		if ($sPrefix === NULL) {
			$sPrefix = $this->sFormPrefix;
		}
		foreach ($axData as $sKey => $sVal) {
			if (substr($sKey, 0, strlen($sPrefix)) == $sPrefix) {
				$sField = substr($sKey, strlen($sPrefix));
				if ($this->oTable->GetFieldType($sField) == 'NUMBER') {
					$sVal = $sVal + 0;
				} elseif (($this->oTable->GetFieldType($sField) == 'DATETIME') ||
					($this->oTable->GetFieldType($sField) == 'DATE')) {
					$sVal = ToSQLDate($sVal);
				}
				$this->axData[$sField] = $sVal;
			}
		}
	}

	function SetData($xKey, $sVal='') {
		if (is_array($xKey)) {
			foreach ($xKey as $sKey => $sVal) {
				if (substr($sKey, 0, strlen($this->sFormPrefix)) == $this->sFormPrefix) {
					$sField = substr($sKey, strlen($this->sFormPrefix));
				} else {
					$sField = $sKey;
				}
				if ($this->oTable->GetFieldType($sField) == 'NUMBER') {
					$sVal = $sVal + 0;
				}
				$this->axData[$sField] = $sVal;
			}
		} else {
			$sKey = $xKey;
			if (substr($sKey, 0, strlen($this->sFormPrefix)) == $this->sFormPrefix) {
				$sField = substr($sKey, strlen($this->sFormPrefix));
			} else {
				$sField = $sKey;
			}
			if ($this->oTable->GetFieldType($sField) == 'NUMBER') {
				$sVal = $sVal + 0;
			}
			$this->axData[$sField] = $sVal;
		}
	}

	function GetData($sKey=NULL) {
		if ($sKey == NULL) {
			return $this->axData;
		} else {
			return $this->axData[$sKey];
		}
	}

	function SetTableDef(&$oTableDef) {
		$this->oTable = $oTableDef;
	}

	function UnSetData($sKey=NULL) {
		if (is_null($sKey)) {
			$this->axData = array();
		} else {
			unset($this->axData[$sKey]);
		}
	}

	function ValidateDataWithTableDef() {
		$asKey = array_keys($this->axData);
		for ($i = 0; $i < count($asKey); $i++) {
			if (!$this->oTable->FieldExists($asKey[$i])) {
				unset($this->axData[$asKey[$i]]);
			}
		}
	}

	function InsertData() {
		return $this->oDB->Insert($this->oTable->sTableName, $this->axData);
	}

	function UpdateData($sID=NULL, $xField=NULL) {
		// Create condition
		if (is_null($sID)) {
			$sID = $this->axData[$this->oTable->sIndexField];
		}
		$sCondition = $this->oTable->sIndexField.'=';
		if ($this->oTable->sIndexType == 'NUMBER') {
			$sCondition .= $sID;
		} else {
			$sCondition .= "'$sID'";
		}

		// Get update field
		if (is_array($xField)) {
			$asField = $xField;
		} elseif (is_string($xField)) {
			$asField = explode(',', $xField);
		} else {
			$asField = array_keys($this->axData);
		}

		// Get update data
		$axData = array();
		for ($i = 0; $i < count($asField); $i++) {
			if ($asField[$i] != $this->oTable->sIndexField) {
				$axData[$asField[$i]] = $this->axData[$asField[$i]];
			}
		}
		return $this->oDB->Update($this->oTable->sTableName, $axData, $sCondition);
	}

	function GetIdentity() {
		return $this->oDB->GetIdentity();
	}
}

class SessionOrder {
	var $sOrder;
	var $sDir;
	var $sPrefix;

	function SessionOrder($sOrder, $sDir='DESC', $sPrefix='so_') {
		$this->sOrder = $sOrder;
		$this->sDir = $sDir;
		$this->sPrefix = $sPrefix;
	}

	function Reset() {
		$_SESSION[$this->sPrefix.'order'] = $this->sOrder;
		$_SESSION[$this->sPrefix.'dir'] = $this->sDir;
	}

	function SetOrder($sOrder) {
		if ($sOrder != '') {
			$_SESSION[$this->sPrefix.'order'] = $sOrder;
		}
	}

	function SetDir($sDir) {
		if ($sDir != '') {
			$_SESSION[$this->sPrefix.'dir'] = $sDir;
		}
	}

	function ToggleDir($sDir) {
		if ($sDir == 'ASC') {
			return 'DESC';
		} else {
			return 'ASC';
		}
	}

	function Generate($sOrder, $sDir=NULL) {
		if ($_SESSION[$this->sPrefix.'order'] == '') {
			$_SESSION[$this->sPrefix.'dir'] = $this->sDir;
			$_SESSION[$this->sPrefix.'order'] = $this->sOrder;
		} else {
			if ($_SESSION[$this->sPrefix.'order'] == $sOrder) {
				if (is_null($sDir)) {
					$_SESSION[$this->sPrefix.'dir'] = $this->ToggleDir($_SESSION[$this->sPrefix.'dir']);
				} else {
					$_SESSION[$this->sPrefix.'dir'] = $sDir;
				}
			} else {
				$_SESSION[$this->sPrefix.'order'] = $sOrder;
				if (is_null($sDir)) {
					$_SESSION[$this->sPrefix.'dir'] = $this->sDir;
				} else {
					$_SESSION[$this->sPrefix.'dir'] = $sDir;
				}
			}
		}
	}

	function GetOrder() {
		return $_SESSION[$this->sPrefix.'order'];
	}

	function GetDir() {
		return $_SESSION[$this->sPrefix.'dir'];
	}

	function GetOrderDir($sOrder=NULL, $sDir=NULL) {
		if (is_null($sOrder) || ($sOrder == '')) {
			$this->Reset();
		} elseif (is_null($sDir)) {
			$this->Generate($sOrder);
		} else {
			$this->SetOrder($sOrder);
			$this->SetDir($sDir);
		}
		$asResult[0] = $this->GetOrder();
		$asResult[1] = $this->GetDir();
		return $asResult;
	}
}
?>