<?php
$path = $_GET['path'];
$token = $_GET['token'];
include "../tools/DatabaseTool.php";

$databaseTool = DatabaseTool::connectDatabase();

$databaseTool->deletePicture($path,$token);
