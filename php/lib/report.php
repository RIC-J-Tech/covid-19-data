<?php
require_once("/etc/apache2/capstone-mysql/Secrets.php");
$secrets =  new Secrets("/etc/apache2/capstone-mysql/cohort28/ricjtech.ini");
$pdo = $secrets->getPdoObject();