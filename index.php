<?php
session_start();
require_once("class.user.php");
$login = new USER();

if($login->is_loggedin()!="")
{
	$login->redirect('home.php');
}

if(isset($_POST['btn-login']))
{
	$user_name = strip_tags($_POST['txt_uname_email']);
	$user_email = strip_tags($_POST['txt_uname_email']);
	$user_password = strip_tags($_POST['txt_password']);

	if($login->doLogin($user_name,$user_email,$user_password))
	{
		$login->redirect('home.php');
	}
	else
	{
		$error = "Wrong Details !";
	}
}
?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Login</title>
<link rel="stylesheet" href="css/style.css" type="text/css"  />
</head>
<body>

<div class="signin-form">

	<div class="container">


       <form class="form-signin" method="post" id="login-form">

        <h2 class="form-signin-heading">Log In to Book Store</h2><hr />
				<h3>Simarpreet Singh (200413865)</h3>

        <div id="error">
        <?php
			if(isset($error))
			{
				?>
                <div class="alert alert-danger"><?php echo $error; ?> !
                </div>
                <?php
			}
		?>
        </div>

        <div>
        <input type="text" class="form-control" name="txt_uname_email" placeholder="Username or E-mail ID" required />
        <span id="check-e"></span>
        </div>

        <div class>
        <input type="password" class="form-control" name="txt_password" placeholder="Your Password" />
        </div>

     	<hr />

        <div>
            <button type="submit" name="btn-login" class="btn btn-default"> SIGN IN
            </button>
        </div>
      	<br />
            <label>Don't have account yet ! <a href="sign_up.php">Sign Up</a></label>
      </form>

    </div>

</div>

</body>
</html>
