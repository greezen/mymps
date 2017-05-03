<?php
error_reporting(0);
require_once("session.php");
require_once("config.php");

qq_login($_SESSION["appid"], $_SESSION["scope"], $_SESSION["callback"]);
?>