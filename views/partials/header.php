<?php

if (isset($_GET["errors"])) {
	$errors = unserialize(urldecode($_GET["errors"]));
}
?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">

  <title>Slack Light</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <link href="assets/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="assets/bootstrap/css/bootstrap-theme.min.css" rel="stylesheet">
  <link href="assets/main.css" rel="stylesheet">

</head>
<body>

<div class="container">

