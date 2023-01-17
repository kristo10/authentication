<?php
session_start();
$localhost = "localhost";
$user = "root";
$password = "";

$db = "school";

$conn = new mysqli($localhost, $user, $password, $db);