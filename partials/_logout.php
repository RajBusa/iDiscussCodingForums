<?php
  session_start();
  session_unset();
  session_destroy();
  header("location: /PHPtut/2_forum/index.php");
?>