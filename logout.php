<?php
include("classSession.php");
$ses = new Sess();
$ses->start();
$ses->destSess();
header("location:index.php");
?>