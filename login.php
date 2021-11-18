<?php include "includes/header.php"; ?>

<!-- navigation -->
<?php include "includes/navigation.php"; ?>
<?php 
//LOGIN FUNCTION
if(isset($_POST['login'])) {
    $username = escape($_POST['username']);
    $password = escape($_POST['password']);

    $stmt = mysqli_prepare($connection, "SELECT user_password, user_role FROM users WHERE username = ?");
    mysqli_stmt_bind_param($stmt, "s", $username,);
    mysqli_execute($stmt);
    mysqli_stmt_bind_result($stmt, $db_password, $db_user_role);
    mysqli_stmt_store_result($stmt);
    
    echo $num_row = mysqli_stmt_num_rows($stmt);

    if($num_row >= 1) {
        while(mysqli_stmt_fetch($stmt)){
            if(password_verify($password, $db_password)) {
                $_SESSION['username'] = $username;
                $_SESSION['user_role'] = $db_user_role;
                redirect('index');
            } else {
                $message ="<p class='warning'>Wrong Password. Please check and try again.</p>";
            }
        }
    } else { // if username doesnt match any
        $message ="<p class='warning'>Username does not exist.</p>";
    }

    mysqli_stmt_close($stmt);
    
}
?>
	<!-- Page Content -->
	<div class="container">
		<div class="client-logo">
			<img src="img/bar-logo.jpg" alt="client-logo" title="client-logo">
		</div>	
        <?php if(isset($message)) { echo $message; } ?>
        <form action="" method="post" class="login-form">
            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" name="username" value="Bar_at_Tokio"  readonly>
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" name="password" placeholder="enter your password" requered>
                <br>
                <a class="forgot" href="#">Forget your password?</a>
            </div>
            <input class="btn" type="submit" value="Login" name="login">
        </form>
	</div> <!-- /.container -->
    <footer>
        <div class="copyright">
            <small>2021 &#64;Reika Akuzawa</small>
        </div> 
    </footer>
    <script src="js/script.js"></script>
</body>
    
</html>
