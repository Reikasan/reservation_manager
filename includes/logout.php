<?php 
    session_start();
    $_SESSION['username'] = null;
    $_SESSION['user_role'] = null;

    header ("Location: ../login");
?>