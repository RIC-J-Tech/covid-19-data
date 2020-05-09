<?php
echo "Hello world"."<br>";

var_dump($_POST);
var_dump($_GET);

//echo $_GET["username"].$_GET["company"];
//var_dump($_GET["username"]);
//var_dump($_GET["company"]);
//var_dump(filter_input(INPUT_GET,"id",FILTER_SANITIZE_STRING,FILTER_FLAG_NO_ENCODE_QUOTES));
var_dump($_SERVER);