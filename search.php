<!DOCTYPE html>
<html>
<head>
<title>Search</title>
<link rel="stylesheet" type="text/css" href="css/style.css">

</head>

<body>
<?php
require_once('connectvars.php');
echo $_GET['keywords'] . '<br/>';
//convert to a list with explode 
$search_words = explode(' ', $_GET['keywords']);
//build our sql query
$query = "SELECT * from books WHERE ";
//use foreach loop to go through each search term 
$where = ""; //start by setting to empty string 
foreach ($search_words as $word) {
	$where = $where . "book_title LIKE '%$word%' OR book_genre LIKE '%$word%' OR book_review LIKE '%$word%' OR ";  
} 

$where = substr($where, 0, strlen($where) - 4);

$final_sql = $query . $where; 
$cmd = $conn->prepare($final_sql);
$cmd->execute(); 
$books = $cmd -> fetchAll();

   echo 	'<table>
                        <tr>
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
             $cmd->closeCursor();
        ?>
    </body>
</html>
