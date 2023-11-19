<?php
session_start();
unset($_SESSION['log_user']);
header('Location: home.php');
 ?>