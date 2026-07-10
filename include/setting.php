<?php

$oDB = new DBI();
$oTmp = new TemplateEngine();
$sExpireDate = $oDB->QueryOne("SELECT nom_expire FROM tbl_setting WHERE id = 1 AND approve_status = 'A' ");
?>