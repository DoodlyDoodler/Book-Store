<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<title>Saving Your Book</title>
    <link rel="stylesheet" type="text/css" href="css/style.css">
</head>
<body>
<?php
    
    require_once("session.php");
    require_once("class.user.php");

//grab the info and store in variables
//book info
$book_id = (int)filter_input(INPUT_POST, 'book_id');
$book_title  = filter_input(INPUT_POST, 'book_title');
$book_genre  = filter_input(INPUT_POST, 'book_genre');
$book_review = filter_input(INPUT_POST, 'book_review');
$link   = filter_input(INPUT_POST, 'link');
//personal info
$name   = filter_input(INPUT_POST, 'name');
$email  = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);

//create flag variable
$ok = true;

//do our form validation before saving
if (empty($name)) {
    echo 'Name is required';
    echo "<br>";
    $ok = false;
}
if (empty($email)) {
    echo 'Email is required';
    echo "<br>";
    $ok = false;
}
if (empty($book_title)) {
    echo 'Book Title is required';
    echo "<br>";
    $ok = false;
}
if (empty($book_genre)) {
    echo 'Book genre is required';
    echo "<br>";
    $ok = false;
}
if (empty($book_review)) {
    echo 'Review is required';
    echo "<br>";
    $ok = false;
}
if (empty($link)) {
    echo 'Book link is required';
    echo "<br>";
    $ok = false;
}

if ($ok == true) {
    
    //connect to the database
    require_once('db.php');
    if (!empty($book_id)) {
        $sql = "UPDATE books set book_title = :book_title, book_genre = :book_genre, book_review = :book_review, name = :name,email = :email,  link =:link WHERE book_id = :book_id";
    } 
    else {
        $sql = "INSERT INTO books (book_title,book_genre,book_review,link,name,email) VALUES (:book_title,:book_genre,:book_review,:link,:name,:email)";
    }

    //prepare the query
    $cmd = $conn->prepare($sql);
    
    //bind the placeholder with info
    $cmd->bindParam(':book_title', $book_title);
    $cmd->bindParam(':book_genre', $book_genre);
    $cmd->bindParam(':book_review', $book_review);
    $cmd->bindParam(':link', $link);
    $cmd->bindParam(':name', $name);
    $cmd->bindParam(':email', $email);
    if(!empty($book_id))
        {
        $cmd->bindParam(':book_id', $book_id, PDO::PARAM_INT);
        }
    //execute the query
    $cmd->execute();
    
    //show message
    echo "<br>";
    echo '<p style="text-align:center"> Your book is saved <br/> Just verify from the below link</p>';
    echo '<p style="text-align:center"><a href="index.php">Books List</a></p>';
    
    //disconnect from DB
    $cmd->closeCursor();
    
}
?>
</body>
</html>