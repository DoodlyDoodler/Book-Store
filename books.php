<html>
    <head>
        <meta charset="UTF-8">
        <title>Home</title>
        <link rel="stylesheet" type="text/css" href="css/style.css">

    </head>
    <body>
    <header>
            <nav>
                <a href="home.php">Home</a>
                <a href="submit.php">Insert Book</a>

            </nav>
        </header>

        <main>
            <div class="container">
                <h1>Books List</h1>
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
            </div>
        </main>
    </body>
</html>
