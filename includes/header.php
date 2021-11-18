<?php
    session_start(); 
    include "includes/db.php";
    include "includes/functions.php";
?>

<!doctype html>
<html>
<head>
    <title>Reservation Manager</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="robots" content="noindex,nofollow">
    <meta name="description" content="This site is a sample for Reservation Management System and its built with HTML, CSS, Javascript and PHP.">
    
    <base href="https://reservation-manager.reikaakuzawa.com/" >
    
    <link rel="stylesheet" href="css/style.css">
<?php
    if(isset($_SESSION['user_role']) || $_SESSION['user_role'] === 'user' ) {
        echo '<link rel="stylesheet" href="css/index_style.css">';
        echo '<link rel="stylesheet" href="css/index_style_responsible.css">';
        echo '<link rel="stylesheet" href="css/color_style.css">';
    } else {
        echo '<link rel="stylesheet" href="css/login_style.css">';
        echo '<link rel="stylesheet" href="css/login_style_responsible.css">';
    }
?>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">
    <link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="img/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="img/favicon-16x16.png">
    <link rel="manifest" href="/site.webmanifest">
    <link rel="mask-icon" href="/safari-pinned-tab.svg" color="#5bbad5">
    <meta name="msapplication-TileColor" content="#da532c">
    <meta name="theme-color" content="#ffffff">
    
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Josefin+Sans:wght@100;200;400&display=swap');
   </style>
</head>
<body>