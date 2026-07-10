<?php
/****************************************************************************
 *	Create by Artit P.
 *	on July 9, 2005
 *	Last modified on March 15, 2006
 ****************************************************************************
 *	Copyright by Artit P., You can freely use this script without
 *	modified it. I don't responsible for any damage cause by
 *	this script.
 ****************************************************************************
 *	Includes all utils file and contains other utility functions
 ****************************************************************************
	array ToArray($xData)
 ****************************************************************************/
include_once('html_utils.php');
include_once('file_utils.php');
include_once('str_utils.php');
include_once('sys_utils.php');
include_once('mail_utils.php');
include_once('db_utils.php');

function ToArray($xData) {
	if (is_array($xData)) {
		$asResult = $xData;
	} else {
		//$asResult = explode(',', $xData);
		$asResult[] = $xData;
	}
	return $asResult;
}
?>