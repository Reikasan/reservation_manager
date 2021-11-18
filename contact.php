<?php session_start(); ?>
<!doctype html>
<html>
<head>
    <title>Reservation Manager</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="robots" content="noindex,nofollow">
    <meta name="description" content="This site is a sample site for Bar. Built with HTML, CSS and JavaScript.">
    
    
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/login_style.css"> 
    <link rel="stylesheet" href="css/index_style_responsible.css"> 
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
<?php include "includes/navigation.php"; ?>

<!-- Page Content -->
<div class="container contact">
    <form action="" method="post" class="contact-form">
        <div class="form-group">
            <label for="subject">Title</label>
            <input type="text" name="subject" id="" maxlength="50">
        </div>
        <div class="form-group">
            <label for="clientName">Client Name</label>
            <input type="text" name="clientName" id="" maxlength="30">
        </div>
        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" name="email" id="" maxlength="50">
        </div>
        <div class="form-group">
            <label for="content">Message</label>
            <textarea type="text" name="content"></textarea>
        </div>
        <div class="form-group">
            <input type="btn" class="btn" value="Send">
        </div>
    </form>
</div> <!-- end of container -->
<?php include "includes/footer.php"; ?>
