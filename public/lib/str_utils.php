<?php
/****************************************************************************
 *	Create by Artit P.
 *	on July 9, 2005
 *	Last modified on March 9, 2006
 ****************************************************************************
 *	Copyright by Artit P., You can freely use this script without
 *	modified it. I don't responsible for any damage cause by
 *	this script.
 ****************************************************************************
 *
 ****************************************************************************
	CommaText($sText)
 ****************************************************************************/

function CommaText($sText) {
	$bInQuote = FALSE;
	$bInWord = FALSE;
	$bHasWord = FALSE;
	$iLength = strlen($sText);
	$sStr = '';
	for ($i = 0; $i < $iLength; $i++) {
		if ($sText[$i] == '"') {
			if ($bInQuote == TRUE) {
				$bInQuote = FALSE;
				$sStr .= $sText[$i];
			} else {
				$bInQuote = TRUE;
				if ($bHasWord == TRUE) {
					$sStr .= ',';
				}
				$sStr .= $sText[$i];
			}
			$bHasWord = TRUE;
		} elseif ($bInQuote == FALSE) {
			if ($sText[$i] == ' ') {
				if ($bInWord == TRUE) {
					$bInWord = FALSE;
				}
			} else {
				if (($bHasWord == TRUE) and ($bInWord == FALSE)) {
					$sStr .= ',';
				}
				$bInWord = TRUE;
				$bHasWord = TRUE;
				$sStr .= $sText[$i];
			}
		} else {
			$sStr .= $sText[$i];
		}
	}
	return $sStr;
}

function TrimValue(&$sVal) {
	$sVal = trim($sVal);
}

function ArrayTrim($axData) {
	array_walk($axData, 'TrimValue');
	return $axData;
}
?>