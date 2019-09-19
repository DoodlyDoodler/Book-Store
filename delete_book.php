<?php
    ob_start();
    //get the book id
    $book_id = $_GET['book_id'];

    //checking if book id is not null
   
    
            //access the database
			require('db.php');
			//set up SQL query 
        	$sql = "DELETE FROM books WHERE book_id = :book_id";
        	//prepare the query
            $cmd = $conn->prepare($sql);
            //bind the book id 
            $cmd->bindParam(':book_id', $book_id,PDO::PARAM_INT);
        	//execute the query
            $cmd->execute();

            $conn=null;
            //disconnect from DB
            $cmd->closeCursor();
    
    header('location:books.php');
    ob_flush();
?>