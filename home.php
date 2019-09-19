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
<header>
    <p style="text-align:center;"><a href="submit.php">Insert Book</a>
    
</header>

<body>


    <p style="text-align:center;">Hi,  <?php echo $userRow['user_email']; ?></p>

                <p style="text-align:center;"><a href="profile.php" >View Profile</a><br/></p>
                <p style="text-align:center;"><a  href="logout.php?logout=true">Sign Out</a></p>


    <div class="container">

    	  <label class="h5">welcome : <?php print($userRow['user_name']); ?></label>
        <hr />

        <h2 style="background-color: light blue;">
        <a href="books.php">Books Info</a>
        <a href="profile.php">Profile</a></h2>

        <form method="get" action="search.php">
            <label for="keywords"></label>
            <input type="text" name="keywords" placeholder="Search Your Book" />
            <input type="submit" name="search" value="Search" />
        </form>

           <h1 style="text-align:center;">Book Info</h1>
            <p style="text-align:center;">
                    <?php

                        require_once("session.php");
                        require_once("class.user.php");

                    ob_start();
                    try
                    {
                        //access the database
                        require_once('db.php');
                        //set up SQL query
                        $sql = "SELECT * FROM books";
                        //prepare the query
                        $cmd = $conn->prepare($sql);
                        //execute the query
                        $cmd->execute();
                        //use fetchAll to store our result
                        $books = $cmd->fetchAll();
                        //echo out the table header
                        echo  '<table>
                        <tr id = "td">
                            <th>Book Title</th>
                            <th>Book Genre</th>
                            <th>Book Review</th>
                            <th>Review By: Email</th>
                            <th>Name</th>
                            <th>Buy Link</th>
                            <th>Edit</th>
                            <th>Delete</th>
                        </tr>';

                        //better to format table row like this easy to read and understand
                        foreach ($books as $book) {
                            echo '<tr>
                            <td>'.$book['book_title'].'</td>
                            <td>'.$book['book_genre'].'</td>
                            <td>'.$book['book_review'].'</td>
                            <td>'.$book['email'].'</td>
                            <td>'.$book['name'].'</td>

                            <td><a href="'.$book['link'].'">Buy Link</a></td>
                            <td><a href="submit.php?book_id='.$book['book_id'].'">Edit</a></td>
                    <td><a href="delete_book.php?book_id='.$book['book_id'].'"onclick="return confirm (\'Are You Sure?\');"> Delete </a></td>
                        </tr>';
                        }
                        echo '</table>';

                        //close the database connection
                        $conn = NULL;
                    }
                    catch(Exception $e)
                    {
                        //send an email to the admin app
                        mail('pateldarpen24595@gmail.com', 'Book Databse Problems!', $e);
                        header('location:error.php');
                    }
                    ob_flush();
                ?>

               </p>


       	<hr/>
        </div>





</body>
</html>
