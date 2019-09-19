<?php

	require_once("session.php");

	require_once("class.user.php");
	$auth_user = new USER();


	$user_id = $_SESSION['user_session'];

	$stmt = $auth_user->runQuery("SELECT * FROM users WHERE user_id=:user_id");
	$stmt->execute(array(":user_id"=>$user_id));

	$userRow=$stmt->fetch(PDO::FETCH_ASSOC);

?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" href="css/style.css" type="text/css"  />
<title>welcome - <?php print($userRow['user_email']); ?></title>
</head>

<body>

 <p style="text-align:center;">Hi,  <?php echo $userRow['user_email']; ?></p>

        <p style="text-align:center;"><a href="profile.php" >View Profile</a><br/></p>
        <p style="text-align:center;"><a  href="logout.php?logout=true">Sign Out</a></p>


    <div class="container">

    	  <label class="h5">welcome : <?php print($userRow['user_name']); ?></label>
        <hr />

        <h2 style="background-color: light blue;">
        <a href="books.php">Books Info</a> &nbsp;
        <a href="profile.php">Profile</a></h2>

    </div>


</body>
</html>
