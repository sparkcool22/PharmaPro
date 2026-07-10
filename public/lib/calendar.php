<?php
/****************************************************************************
 *	Create by Artit P.
 *	on August 2, 2005
 *	Last modified on September 21, 2005
 ****************************************************************************
 *	Copyright by Artit P., You can freely use this script without
 *	modified it. I don't responsible for any damage cause by
 *	this script.
 ****************************************************************************

 ****************************************************************************
	Class Calendar
	Class DBCalendar
 ****************************************************************************/
//include_once('utils.php');
//include_once('dbi.php');

class Calendar {
	var $iDay;
	var $iMonth;	
	var $iYear;
	var $bShowOtherMonth;
	var $iStartWeekday;
	var $sLink;

	var $asWeekday = array(
			'TH' => array(
				//array('7', '1', '2', '3', '4', '5', '6'),
				array('อา.', 'จ.', 'อ.', 'พ.', 'พฤ.', 'ศ.', 'ส.'),
				array('อาทิตย์', 'จันทร์', 'อังคาร', 'พุธ', 'พฤหัสบดี', 'ศุกร์', 'เสาร์')
			),
			'EN' => array(
				//array('7', '1', '2', '3', '4', '5', '6'),
				array('Sun', 'Mon', 'Tue', 'Wed', 'Thr', 'Fri', 'Sat'),
				array('Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday')
			)
		);
	
	var $asMonth = array(
			'EN' =>	array(
				array('Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'),
				array('January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December')
			),
			'TH' =>	array(
				array('ม.ค.', 'ก.พ.', 'มี.ค.', 'เม.ย.', 'พ.ค.', 'มิ.ย.', 'ก.ค.', 'ส.ค.', 'ก.ย.', 'ต.ค.', 'พ.ย.', 'ธ.ค.'),
				array('มกราคม', 'กุมภาพันธ์', 'มีนาคม', 'เมษายน', 'พฤษภาคม', 'มิถุนายน', 'กรกฎาคม', 'สิงหาคม', 'กันยายน', 'ตุลาคม', 'พฤศจิกายน', 'ธันวาคม')
			)
		);

	function Calendar($iD=NULL, $iM=NULL, $iY=NULL, $bS=TRUE, $iW=0) {
		$this->iDay = is_null($iD)? date('d'): $iD;
		$this->iMonth = is_null($iM)? date('m'): $iM;
		$this->iYear = is_null($iY)? date('Y'): $iY;
		$this->bShowOtherMonth = $bS;
		$this->iStartWeekday = $iW;
	}

	function SetDay($iD) {
		$this->iDay = $iD;
	}

	function SetMonth($iM) {
		$this->iMonth = $iM;
	}

	function SetYear($iY) {
		$this->iYear = $iY;
	}

	function SetShowOtherMonth($bS) {
		$this->bShowOtherMonth = $bS;
	}

	function SetStartWeekday($iS) {
		$this->iStartWeekday = $iS;
	}

	function SetLink($sL) {
		$this->sLink = $sL;
	}
	
	function GetFirstDate() {
		if ($this->bShowOtherMonth) {
			return mktime(0, 0, 0, $this->iMonth, 1 - (date('w', $this->GetMonthFirstDate()) - $this->iStartWeekday + 7)%7, $this->iYear);
		} else {
			return mktime(0, 0, 0, $this->iMonth, 1, $this->iYear);
		}
	}
	
	function GetLastDate() {
		$iMonthLastDate = $this->GetMonthLastDate();
		if ($this->bShowOtherMonth) {
			return mktime(0, 0, 0, $this->iMonth, date('d', $iMonthLastDate) + ($this->iStartWeekday - date('w', $iMonthLastDate) + 6)%7, $this->iYear);
		} else {
			return $iMonthLastDate;
		}
	}

	function GetWeekData($iDay=NULL, $iMonth=NULL, $iYear=NULL) {
		if (is_null($iDay)) {
			$iDay = $this->iDay;
		}
		if (is_null($iMonth)) {
			$iMonth = $this->iMonth;
		}
		if (is_null($iYear)) {
			$iYear = $this->iYear;
		}
		$iFirstDate = $this->GetWeekFirstDate($iDay, $iMonth, $iYear);

		$aaData = array();
		$iToday = mktime(0, 0, 0, date('m'), date('d'), date('Y'));
		$iSelectedDay = mktime(0, 0, 0, $this->iMonth, $this->iDay, $this->iYear);
		$iD = date('d', $iFirstDate);
		$iM = date('m', $iFirstDate);
		$iY = date('Y', $iFirstDate);
		for ($i = 0; $i < 7; $i++) {
			$iDate = mktime(0, 0, 0, $iM, $iD, $iY);
			$iD = date('d', $iDate);
			$iM = date('m', $iDate);
			$iY = date('Y', $iDate);
			$aaData[$i]['day'] = $iD;
			$aaData[$i]['weekday'] = date('w', $iDate);
			$aaData[$i]['link'] = str_replace('$d', date('Y-m-d', $iDate), $this->sLink);
			if ($iM == $iMonth) {
				$aaData[$i]['inmonth'] = '1';
			} else {
				$aaData[$i]['inmonth'] = '0';
			}
			// Check this day
			if ($iDate == $iToday) {
				$aaData[$i]['today'] = '1';
			}
			if ($iDate == $iSelectedDay) {
				$aaData[$i]['selected'] = '1';
			}
			$iD++;
		}
		return $aaData;
	}

	function GetMonthData($iMonth=NULL, $iYear=NULL) {
		if (is_null($iMonth)) {
			$iMonth = $this->iMonth;
		}
		if (is_null($iYear)) {
			$iYear = $this->iYear;
		}
		$iMonthFirstDate = $this->GetMonthFirstDate($iMonth, $iYear);
		$iMonthLastDate = $this->GetMonthLastDate($iMonth, $iYear);
		$iWeekday = date('w', $iMonthFirstDate);
		$iDaySub = ($iWeekday - $this->iStartWeekday + 7)%7;
		$iStart = 1 - $iDaySub;
		$iEndDay = date('d', $iMonthLastDate);
		$bBreak = FALSE;
		$iRow = 0;
		$iCount = 0;
		$aaData = array();
		$iToday = mktime(0, 0, 0, date('m'), date('d'), date('Y'));
		$iSelectedDay = mktime(0, 0, 0, $this->iMonth, $this->iDay, $this->iYear);
		while (!$bBreak) {
			for ($i = 0; $i < 7; $i++) {
				$iDate = mktime(0, 0, 0, $iMonth, $iStart + $iCount, $iYear);
				$iD = date('d', $iDate);
				$iM = date('m', $iDate);
				$iY = date('Y', $iDate);
				$aaData[$iRow][$i]['day'] = $iD;
				$aaData[$iRow][$i]['week'] = $iRow;
				$aaData[$iRow][$i]['weekday'] = date('w', $iDate);
				$aaData[$iRow][$i]['link'] = str_replace('$d', date('Y-m-d', $iDate), $this->sLink);
				if ($iM == $iMonth) {
					$aaData[$iRow][$i]['inmonth'] = '1';
				} else {
					$aaData[$iRow][$i]['inmonth'] = '0';
					if (!$this->bShowOtherMonth) {
						$aaData[$iRow][$i]['day'] = '';
						$aaData[$iRow][$i]['link'] = '';
					}
				}
				// Check this day
				if ($iDate == $iToday) {
					$aaData[$iRow][$i]['today'] = '1';
				}
				if ($iDate == $iSelectedDay) {
					$aaData[$iRow][$i]['selected'] = '1';
				}
				
				if (($iY >= $iYear) && ($iM >= $iMonth) && ($iEndDay == $iD)) {
					$bBreak = TRUE;
				}
				$iCount++;
			}
			$iRow++;
		}
		return $aaData;
	}

	function GetYearData($iYear=NULL) {
		if (is_null($iYear)) {
			$iYear = $this->iYear;
		}
		$aaData = array();
		// Save current bShowOtherMonth
		$bSOM = $this->bShowOtherMonth;
		$this->bShowOtherMonth = FALSE;
		for ($i = 0; $i < 12; $i++) {
			$aaData[$i] = $this->GetMonthData($i + 1, $iYear);
		}
		// Restore bShowOtherMonth
		$this->bShowOtherMonth = $bSOM;
		return $aaData;
	}

	function GetWeekday($sLang='EN', $iType=0) {
		for ($i = 0; $i < 7; $i++) {
			$aaData[$i] = $this->asWeekday[$sLang][$iType][($this->iStartWeekday + $i)%7];
		}
		return $aaData;
	}

	function Today() {
		return mktime(0, 0, 0, date('m'), date('d'), date('Y'));
	}
	
	function GetWeekFirstDate($iDay=NULL, $iMonth=NULL, $iYear=NULL) {
		if (is_null($iDay)) {
			$iDay = $this->iDay;
		}
		if (is_null($iMonth)) {
			$iMonth = $this->iMonth;
		}
		if (is_null($iYear)) {
			$iYear = $this->iYear;
		}
		return mktime(0, 0, 0, $iMonth, $iDay - (date('w', mktime(0, 0, 0, $iMonth, $iDay, $iYear)) - $this->iStartWeekday + 7)%7, $iYear);
	}

	function GetWeekLastDate($iDay=NULL, $iMonth=NULL, $iYear=NULL) {
		if (is_null($iDay)) {
			$iDay = $this->iDay;
		}
		if (is_null($iMonth)) {
			$iMonth = $this->iMonth;
		}
		if (is_null($iYear)) {
			$iYear = $this->iYear;
		}
		return mktime(0, 0, 0, $iMonth, $iDay + (6 - date('w', mktime(0, 0, 0, $iMonth, $iDay, $iYear)) + $this->iStartWeekday)%7, $iYear);
	}

	function GetMonthFirstDate($iMonth=NULL, $iYear=NULL) {
		if (is_null($iMonth)) {
			$iMonth = $this->iMonth;
		}
		if (is_null($iYear)) {
			$iYear = $this->iYear;
		}
		return mktime(0, 0, 0, $iMonth, 1, $iYear);
	}

	function GetMonthLastDate($iMonth=NULL, $iYear=NULL) {
		if (is_null($iMonth)) {
			$iMonth = $this->iMonth;
		}
		if (is_null($iYear)) {
			$iYear = $this->iYear;
		}
		return mktime(0, 0, 0, $iMonth + 1, 0, $iYear);
	}

	function GetDayArray($iDate=NULL) {
		if (is_null($iDate)) {
			$iDate = $this->GetMonthFirstDate();
		}
		$iDayStart = date('d', $this->GetMonthFirstDate(date('m', $iDate), date('Y', $iDate)));
		$iDayEnd = date('d', $this->GetMonthLastDate(date('m', $iDate), date('Y', $iDate)));
		$aaData = array();
		for ($i = $iDayStart; $i <= $iDayEnd; $i++) {
			$aaData[] = $i;
		}
		return $aaData;
	}

	function GetWeekdayArray($sLang='EN', $iType=0) {
		return $this->asWeekday[$sLang][$iType];
	}

	function GetMonthArray($sLang='EN', $iType=0) {
		return $this->asMonth[$sLang][$iType];
	}

	function GetYearArray($iStart=NULL, $iEnd=NULL) {
		if (is_null($iStart)) {
			$iStart = date('Y') - 5;
		}
		if (is_null($iEnd)) {
			$iEnd = date('Y') + 5;
		}
		$aaData = array();
		for ($i = $iStart; $i <= $iEnd; $i++) {
			$aaData[] = $i;
		}
		return $aaData;
	}
}

class DBCalendar extends Calendar {
	var $sSql;	
	var $oDB;	
	
	function DBCalendar(&$oDB, $iD=NULL, $iM=NULL, $iY=NULL, $bS=TRUE, $iW=0) {
		$this->oDB =& $oDB;
		parent::Calendar($iD, $iM, $iY, $bS, $iW);
	}
	
	function SetDataQuery($sSql) {
		$this->sSql = $sSql;
	}

	function GetDayData($iDay=NULL, $iMonth=NULL, $iYear=NULL) {
		if (is_null($iDay)) {
			$iDay = $this->iDay;
		}
		if (is_null($iMonth)) {
			$iMonth = $this->iMonth;
		}
		if (is_null($iYear)) {
			$iYear = $this->iYear;
		}
		// Query DB
		$aaDBData = $this->QueryData();
		$iDate = mktime(0, 0, 0, $iMonth, $iDay, $iYear);

		$aaData['day'] = $iDay;
		$aaData['weekday'] = date('w', $iDate);
		$aaData['link'] = str_replace('$d', date('Y-m-d', $iDate), $this->sLink);
		$aaData['data'] = $aaDBData[date('Ymd', $iDate)];

		$iToday = mktime(0, 0, 0, date('m'), date('d'), date('Y'));
		$iSelectedDay = mktime(0, 0, 0, $this->iMonth, $this->iDay, $this->iYear);
		// Check this day
		if ($iDate == $iToday) {
			$aaData['today'] = '1';
		}
		if ($iDate == $iSelectedDay) {
			$aaData['selected'] = '1';
		}
		return $aaData;
	}

	function GetWeekData($iDay=NULL, $iMonth=NULL, $iYear=NULL, $bGroupByTime=FALSE) {
		if (is_null($iDay)) {
			$iDay = $this->iDay;
		}
		if (is_null($iMonth)) {
			$iMonth = $this->iMonth;
		}
		if (is_null($iYear)) {
			$iYear = $this->iYear;
		}
		// Query DB
		$aaDBData = $this->QueryData();
		//print_r($aaDBData);
		// Rearrange data if GroupByTime is TRUE
		if ($bGroupByTime == TRUE) {
			foreach ($aaDBData as $sKey => $axVal) {
				for ($i = 0; $i < count($axVal); $i++) {
					$iCount = count($aaTemp[$sKey][$axVal[$i]['time']]);
					foreach ($axVal[$i] as $sKey2 => $sVal2) {
						if ($sKey2 != 'time') {
							if (($axVal[$i]['time'] == '') or ($axVal[$i]['time'] == 0)) {
								$sTime = 24;
							} else {
								$sTime = $axVal[$i]['time'];
							}
							$aaTemp[$sKey][$sTime][$iCount][$sKey2] = $sVal2;
						}
					}
				}
			}
			$aaDBData = $aaTemp;
		}
		
		$iFirstDate = $this->GetWeekFirstDate($iDay, $iMonth, $iYear);

		$aaData = array();
		$iToday = mktime(0, 0, 0, date('m'), date('d'), date('Y'));
		$iSelectedDay = mktime(0, 0, 0, $this->iMonth, $this->iDay, $this->iYear);
		$iD = date('d', $iFirstDate);
		$iM = date('m', $iFirstDate);
		$iY = date('Y', $iFirstDate);
		for ($i = 0; $i < 7; $i++) {
			$iDate = mktime(0, 0, 0, $iM, $iD, $iY);
			$iD = date('d', $iDate);
			$iM = date('m', $iDate);
			$iY = date('Y', $iDate);
			$aaData[$i]['day'] = $iD;
			$aaData[$i]['weekday'] = date('w', $iDate);
			$aaData[$i]['link'] = str_replace('$d', date('Y-m-d', $iDate), $this->sLink);
			$aaData[$i]['data'] = $aaDBData[date('Ymd', $iDate)];
			if ($iM == $iMonth) {
				$aaData[$i]['inmonth'] = '1';
			} else {
				$aaData[$i]['inmonth'] = '0';
			}
			// Check this day
			if ($iDate == $iToday) {
				$aaData[$i]['today'] = '1';
			}
			if ($iDate == $iSelectedDay) {
				$aaData[$i]['selected'] = '1';
			}
			$iD++;
		}
		return $aaData;
	}

	function QueryData() {
		$aaDBData = array();
		if ($this->sSql != '') {
			$oRes = $this->oDB->Query($this->sSql);
			if ($oRes) {
				while ($axRow = $oRes->FetchRow(DBI_ASSOC)) {
					$i = count($aaDBData[$axRow['date']]);
					$sDate = $axRow['date'];
					foreach ($axRow as $sKey => $sVal) {
						if ($sKey != 'date') {
							$aaDBData[$sDate][$i][$sKey] = $sVal;
						}
					}
				}
			}
		}
		return $aaDBData;
	}

	function GetMonthData($iMonth=NULL, $iYear=NULL, $axData=NULL) {
		if (is_null($iMonth)) {
			$iMonth = $this->iMonth;
		}
		if (is_null($iYear)) {
			$iYear = $this->iYear;
		}
		
		if (is_null($axData) or !is_array($axData)) {
			// Query DB
			$aaDBData = $this->QueryData();
		} else {
			// read data from given array
			$aaDBData = $axData;
		}

		$iMonthFirstDate = $this->GetMonthFirstDate($iMonth, $iYear);
		$iMonthLastDate = $this->GetMonthLastDate($iMonth, $iYear);
		$iWeekday = date('w', $iMonthFirstDate);
		$iDaySub = ($iWeekday - $this->iStartWeekday + 7)%7;
		$iStart = 1 - $iDaySub;
		$iEndDay = date('d', $iMonthLastDate);
		$bBreak = FALSE;
		$iRow = 0;
		$iCount = 0;
		$aaData = array();
		$iToday = mktime(0, 0, 0, date('m'), date('d'), date('Y'));
		$iSelectedDay = mktime(0, 0, 0, $this->iMonth, $this->iDay, $this->iYear);
		while (!$bBreak) {
			for ($i = 0; $i < 7; $i++) {
				$iDate = mktime(0, 0, 0, $iMonth, $iStart + $iCount, $iYear);
				$iD = date('d', $iDate);
				$iM = date('m', $iDate);
				$iY = date('Y', $iDate);
				$aaData[$iRow][$i]['day'] = $iD;
				$aaData[$iRow][$i]['week'] = $iRow;
				$aaData[$iRow][$i]['weekday'] = date('w', $iDate);
				$aaData[$iRow][$i]['link'] = str_replace('$d', date('Y-m-d', $iDate), $this->sLink);
				$aaData[$iRow][$i]['data'] = $aaDBData[date('Ymd', $iDate)];
				if ($iM == $iMonth) {
					$aaData[$iRow][$i]['inmonth'] = '1';
				} else {
					$aaData[$iRow][$i]['inmonth'] = '0';
					if (!$this->bShowOtherMonth) {
						$aaData[$iRow][$i]['day'] = '';
						$aaData[$iRow][$i]['link'] = '';
					}
				}
				// Check this day
				if ($iDate == $iToday) {
					$aaData[$iRow][$i]['today'] = '1';
				}
				if ($iDate == $iSelectedDay) {
					$aaData[$iRow][$i]['selected'] = '1';
				}
				if (($iY >= $iYear) && ($iM >= $iMonth) && ($iEndDay == $iD)) {
					$bBreak = TRUE;
				}
				$iCount++;
			}
			$iRow++;
		}
		return $aaData;
	}

	function GetYearData($iYear=NULL) {
		if (is_null($iYear)) {
			$iYear = $this->iYear;
		}
		$aaData = array();
		// Query DB
		$axData = $this->QueryData();

		// Save current bShowOtherMonth
		$bSOM = $this->bShowOtherMonth;
		$this->bShowOtherMonth = FALSE;
		for ($i = 0; $i < 12; $i++) {
			$aaData[$i] = $this->GetMonthData($i + 1, $iYear, $axData);
		}
		// Restore bShowOtherMonth
		$this->bShowOtherMonth = $bSOM;
		return $aaData;
	}
}
?>