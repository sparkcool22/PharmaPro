<?php
/****************************************************************************
 *	Create by Artit P.
 *	on July 9, 2005
 *	Last modified on June 18, 2006
 ****************************************************************************
 *	Copyright by Artit P., You can freely use this script without
 *	modified it. I don't responsible for any damage cause by
 *	this script.
 ****************************************************************************
 *
 ****************************************************************************
	DateTimeAdd($date = '', $iDay = 0, $iMonth = 0, $iYear = 0, $iHour = 0, $iMinute = 0, $iSecond = 0)
	DateFormat($sDate, $sFormat = 'y/m/d', $sToFormat = '{dd} {mmm} {yyyy}', $sLang = 'EN')
	GetNumberArray($iStart, $iEnd, $iStep=1, $bAutoFormat=FALSE, $bAutoIndex=FALSE)
	DateTimeDiff($sDate1, $sTime1, $sDate2, $sTime2)
	ToSQLDate($sDateTime)
 ****************************************************************************/

function GetNumberArray($iStart, $iEnd, $iStep=1, $bAutoFormat=FALSE, $bAutoIndex=FALSE) {
	$aiResult = array();
	$iLength = strlen($iEnd.'');
	if ($bAutoIndex) {
		$iIndex = 1;
		$iIncrease = 1;
	} else {
		$iIndex = $iStart;
		$iIncrease = $iStep;
	}
	if ($bAutoFormat) {
		for ($i = $iStart; $i <= $iEnd; $i += $iStep) {
			$aiResult[$iIndex] = str_pad($i, $iLength, '0', PAD_LEFT);
			$iIndex += $iIncrease;
		}
	} else {
		for ($i = $iStart; $i <= $iEnd; $i += $iStep) {
			$aiResult[$iIndex] = $i;
			$iIndex += $iIncrease;
		}
	}
	return $aiResult;
}

function DateTimeAdd($date='', $iDay=0, $iMonth=0, $iYear=0, $iHour=0, $iMinute=0, $iSecond=0) {
	if (is_int($date)) {
		$iDate = $date;
	} else {
		$asPart = explode(' ', $date);
		if (strpos($asPart[0], '/') !== FALSE) {
			$asDatePart = explode('/', $asPart[0]);
		} else {
			$asDatePart = explode('-', $asPart[0]);
		}
		if (count($asPart) == 2) {
			$asTimePart = explode(':', $asPart[1]);
		} else {
			$asTimePart = array(0, 0, 0);
		}
		if (count($asDatePart) == 3) {
			if ($asDatePart[2] > 100) {
				$iDate = mktime($asTimePart[0], $asTimePart[1], $asTimePart[2], $asDatePart[1], $asDatePart[0], $asDatePart[2]);
			} else {
				$iDate = mktime($asTimePart[0], $asTimePart[1], $asTimePart[2], $asDatePart[1], $asDatePart[2], $asDatePart[0]);
			}
		} else {
			$iDate = mktime();
		}
	}
	return mktime(date('H', $iDate) + $iHour, date('i', $iDate) + $iMinute, date('s', $iDate) + $iSecond, date('m', $iDate) + $iMonth, date('d', $iDate) + $iDay, date('Y', $iDate) + $iYear);
}

function DateFormat($sDate, $sFormat='y/m/d', $sToFormat='{dd} {mmm} {yyyy}', $sLang='EN') {
	if (strlen(trim($sDate)) < 8) {
		return '';
	}
	$asWeekDay = array(
			'EN' => array(
				'w' => array('Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'),
				'ww' => array('Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday')
			),
			'TH' => array(
				'w' => array('��.', '�.', '�.', '�.', '��.', '�.', '�.'),
				'ww' => array('�ҷԵ��', '�ѹ���', '�ѧ���', '�ظ', '����ʺ��', '�ء��', '�����')
			)
		);
	$asMonth = array(
			'EN' =>	array(
				'mmm' => array('Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'),
				'mmmm' => array('January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December')
			),
			'TH' =>	array(
				'mmm' => array('�.�.', '�.�.', '��.�.', '��.�.', '�.�.', '��.�.', '�.�.', '�.�.', '�.�.', '�.�.', '�.�.', '�.�.'),
				'mmmm' => array('���Ҥ�', '����Ҿѹ��', '�չҤ�', '����¹', '����Ҥ�', '�Զع�¹', '�á�Ҥ�', '�ԧ�Ҥ�', '�ѹ��¹', '���Ҥ�', '��Ȩԡ�¹', '�ѹ�Ҥ�')
			)
		);
	// Check parameters
	if ($sLang == '') {
		$sLang = 'EN';
	}
	
	// Change $sDate to datetime
	$sDay = '';
	$sMonth = '';
	$sYear = '';
	$sStr = '';
	$sSeperator = '/';
	if (strpos($sFormat, '-') !== FALSE) {
		$sSeperator = '-';
	}

	if (strpos($sFormat, ':') !== FALSE) {
		// Has time section
		// Remove time part from format string
		$asFormatDateTime = explode(' ', $sFormat);
		$sFormat = $asFormatDateTime[0];
	}
	
	if (strpos($sDate, ':') !== FALSE) {
		// Extract time from sDate
		$asTemp = explode(' ', $sDate);
		$sDate = $asTemp[0];
		$sTime = $asTemp[1];
	}

	$asFormat = explode($sSeperator, $sFormat);
	$asDate = explode($sSeperator, $sDate);
	for ($i = 0; $i < 3; $i++) {
		if ($asFormat[$i][0] == 'd') {
			$sDay = $asDate[$i];
		} elseif ($asFormat[$i][0] == 'm') {
			$sMonth = $asDate[$i];
		} elseif ($asFormat[$i][0] == 'y') {
			$sYear = $asDate[$i];
		}
	}
	
	// Validate year
	if ($sYear < 1970) {
		return '';
	}
	
	$iDate = mktime(0, 0, 0, $sMonth, $sDay, $sYear);

	// Prepare variables
	$sYY = date('y', $iDate);
	$sYYYY = date('Y', $iDate);
	if ($sLang == 'TH') {
		$sYY += 43;
		$sYYYY += 543;
	}
	$sM = date('n', $iDate);
	$sMM = date('m', $iDate);
	$sMMM = $asMonth[$sLang]['mmm'][(int)date('n', $iDate) - 1];
	$sMMMM = $asMonth[$sLang]['mmmm'][(int)date('n', $iDate) - 1];
	$sD = date('j', $iDate);
	$sDD = date('d', $iDate);
	$sW = $asWeekDay[$sLang]['w'][(int)date('w', $iDate)];
	$sWW = $asWeekDay[$sLang]['ww'][(int)date('w', $iDate)];
	
	// $asTime = explode(':', $sTime);
	// $sH = ($asTime[0] != '')? ((int)$asTime[0]) + '': '0';
	// $sHH = ($asTime[0] != '')? str_pad($asTime[0], 2, '0', PAD_LEFT): '00';
	// $sN = ($asTime[1] != '')? ((int)$asTime[1]) + '': '0';
	// $sNN = ($asTime[1] != '')? str_pad($asTime[1], 2, '0', PAD_LEFT): '00';
	// $sS = ($asTime[2] != '')? ((int)$asTime[2]) + '': '0';
	// $sSS = ($asTime[2] != '')? str_pad($asTime[2], 2, '0', PAD_LEFT): '00';

	// Format date
	$sToDate = str_replace('{mmmm}', $sMMMM, $sToFormat);
	$sToDate = str_replace('{mmm}', $sMMM, $sToDate);
	$sToDate = str_replace('{mm}', $sMM, $sToDate);
	$sToDate = str_replace('{m}', $sM, $sToDate);
	$sToDate = str_replace('{yyyy}', $sYYYY, $sToDate);
	$sToDate = str_replace('{yy}', $sYY, $sToDate);
	$sToDate = str_replace('{dd}', $sDD, $sToDate);
	$sToDate = str_replace('{d}', $sD, $sToDate);
	$sToDate = str_replace('{ww}', $sWW, $sToDate);
	$sToDate = str_replace('{w}', $sW, $sToDate);
	$sToDate = str_replace('{h}', $sH, $sToDate);
	$sToDate = str_replace('{hh}', $sHH, $sToDate);
	$sToDate = str_replace('{n}', $sN, $sToDate);
	$sToDate = str_replace('{nn}', $sNN, $sToDate);
	$sToDate = str_replace('{s}', $sS, $sToDate);
	$sToDate = str_replace('{ss}', $sSS, $sToDate);
	
	return $sToDate;
}

function DateTimeDiff($sDate1, $sTime1, $sDate2, $sTime2) {
	// Format date to YYYY/MM/DD
	$sDate1 = ToSQLDate($sDate1);
	$sDate2 = ToSQLDate($sDate2);

	$iTime1 = strtotime($sDate1.' '.$sTime1);
	$iTime2 = strtotime($sDate2.' '.$sTime2);
	$iDiff = $iTime2 - $iTime1;
	$asResult['diff'] = $iDiff;
	$asResult['day'] = floor($iDiff/86400);
	$iDiff %= 86400;
	$asResult['hour'] = floor($iDiff/3600);
	$iDiff %= 3600;
	$asResult['minute'] = floor($iDiff/60);
	$iDiff %= 60;
	$asResult['second'] = $iDiff;
	return $asResult;
}

function ToSQLDate($sDateTime) {
	if ($sDateTime == '') {
		return '';
	}
	// Get date/time
	if (strpos($sDateTime, ':') !== FALSE) {
		// Have time
		list($sDate, $sTime) = explode(' ', $sDateTime);
	} else {
		$sDate = $sDateTime;
		$sTime = '';
	}
	
	// Check date seperator
	if (strpos($sDate, '-') !== FALSE) {
		$sSeperator = '-';
	} else {
		$sSeperator = '/';
	}
	
	// Check date
	list($sV1, $sV2, $sV3) = explode($sSeperator, $sDate);
	
	if (intval($sV1) > 100) {
		// First field is year, do nothing just return input
		return $sDateTime;
	} else {
		// First field is date, swap first field with third field
		// Padding number
		$sV1 = str_pad($sV1, 2, '0', STR_PAD_LEFT);
		$sV2 = str_pad($sV2, 2, '0', STR_PAD_LEFT);

		if ($sTime) {
			return "$sV3-$sV2-$sV1 $sTime";
		} else {
			return "$sV3-$sV2-$sV1";
		}
	}
}
?>