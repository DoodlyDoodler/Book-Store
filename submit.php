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

<link rel="stylesheet" type="text/css" href="css/style.css" />
<title>welcome - <?php print($userRow['user_email']); ?></title>
</head>

<body>

    <p style="text-align:center;">Hi,  <?php echo $userRow['user_email']; ?></p>
              
    <p style="text-align:center;"><a href="profile.php" >View Profile</a><br/></p>
    <p style="text-align:center;"><a  href="logout.php?logout=true">Sign Out</a></p>
             

    <div class="container">
    
          <label class="h5">welcome : <?php print($userRow['user_name']); ?></label>
        <hr />
        
        <h2 class="navbar navbar-light" style="background-color: light blue;">
        <a  class="nav-menu" href="books.php">Books Info</a> 
        <a class="nav-menu" href="profile.php">Profile</a></h2>

      
           <h1 style="text-align:center;">Book Info</h1>

       </div>
    </div>

    <?php

	//initalizing the variables
	$book_title = NULL;
	$book_genre = NULL;
	$book_review = NULL;
	$link = NULL;
	$name = NULL;
	$email = NULL;
	if(!empty($_GET['book_id']) && (is_numeric($_GET['book_id'])))
	{
		//grab the book id from the URL string
		$book_id = $_GET['book_id'];

		//connect to the db
		require('db.php');

		//set up SQL query 
		$sql = "SELECT * FROM books WHERE book_id = :book_id";
		//prepare the query
		$cmd = $conn->prepare($sql);
		//bind the placeholder with info
		$cmd->bindParam(':book_id', $book_id);
		//execute the query
		$cmd->execute();
		//use fetchAll to store info into an array
		$books = $cmd->fetchAll();
		//loop through array
		foreach ($books as $book)
		{
			$book_title = $book['book_title'];
	        $book_genre = $book['book_genre'];
	        $book_review = $book['book_review'];
	        $link = $book['link'];
	        $name = $book['name'];
	        $email = $book['email'];
		}
		//close the database connection
		$conn = NULL;
	}
	?>
        <header>
            <nav>
                <a href="index.php">Home</a>
                <a href="submit.php">Insert Book</a>
                <a href="about.html">About</a>
            </nav>
        </header>
        
        <main>
            <div class="container">
                <h1>Submit Your Book</h1>
                    <form id="user-form" method="post" action="save_book.php" >
                         
                            <div >
                                <!--add a hidden input to  echo out the movie id // for updating-->
		                        <input name="book_id" id="book_id" type="hidden" value="<?php echo $book_id ?>">
                                <label for="book_title">Book Title:</label>
                                <input type="text" id="title" name="book_title" value="<?php echo $book_title ?>">
                            </div>
                            <div >
                                <label for="book_genre">Book Genre:</label>
                                <input type="text" id="genre" name="book_genre" value="<?php echo $book_genre ?>">
                            </div>
                            <div >
                                    <label for="book_review">Book Review:</label>
                                    <input type="text" id="review" name="book_review" value="<?php echo $book_review ?>">
                            </div>
                            <div >
                                <label for="link">Purchase Link:</label>
                                <input type="text" id="link" name="link" value="<?php echo $link ?>">
                            </div>		
                        
                        <h1>Personal Info</h1>
                                <div >
                                    <label for="name">Name:</label>
                                    <input type="text" id="name" name="name" value="<?php echo $name ?>">
                                </div>
                                <div >
                                    <label for="email">Email:</label>
                                    <input type="text" id="email" name="email" value="<?php echo $email ?>">
                                </div>
                            
                    <div>
                        <input class="submit" type="submit" value="Submit Book">
                    </div>
                </form>
            </div>
        </main>

            
            


</body>
</html>