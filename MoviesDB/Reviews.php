<?php
session_start();
set_error_handler(function() { /* ignore errors */ });
include_once ('connection.php');
include'Commentop.php';
echo "<link rel='stylesheet' type='text/css' href='Comments.css'>";
$title=$_GET['json'];
$title = rawurlencode($title);


?>
<html lang="en">

<head>
    <title><?php echo rawurldecode($title)?> Reviews</title>

    <h1><?php echo rawurldecode($title)?> Reviews</h1>

</head>

<body>
<form method = "get" action = "Commentop.php">
    <?php
    if($_SESSION["data"] != null){ // exeis kanei log in opote 8a emfanizei to Name tou
        $is_member = 1;
        echo "<input type = 'hidden' name = 'is_member' value ='$is_member' >";
        echo "<h3>Name:</h3> <a href= userProf.php> ".$_SESSION["data"][2]."</a>  
              <input type = 'hidden' name = 'uname' value ='". $_SESSION["data"][2]."'>
              <input type = 'hidden' name = 'id' value ='". $_SESSION["data"][12]."'>
                ";//"<h3>Name:</h3> <input type = 'text' name = 'uname' value ='". $_SESSION["data"][2]."'>"; // NO TEXT PLEASE
    }else{
        $is_member = 0;
        $id = -1;
        echo "<input type = 'hidden' name = 'is_member' value ='$is_member' >";
        echo "<h3>Name:</h3> <input type = 'text' name = 'uname' placeholder = 'Your name'>";
        echo "<input type = 'hidden' name = 'id' value ='$id'>";
    }
    ?>
    <h3>Rate:</h3> <label>
        <input type = 'text' name = 'rate' placeholder = '0-10'>
    </label>
    <h3>Write your review below</h3><label>
        <textarea name = 'message'></textarea>
    </label><br>
    <input type = 'hidden' name = 'movie_name' value = <?php echo $title ?>>
    <input type = 'hidden' name = 'date' value = '<?php echo date('d/m/Y')?>'>
    <button type = 'submit' name ='commentsubmit'>Comment</button>
</form>
<form action = "Home.php">
    <button type = 'submit' name = 'Homesubmit'>Home</button>

</form>

<?php

$sql = "SELECT * FROM moviesdb.newreviews";
$result = $conn->query($sql);


while ($row = mysqli_fetch_row($result)){
    if (!strcasecmp($row[0], $title)){
        echo"<div class = 'reviews-box'>";
        if ($row[5] == 0){
            echo $row[2]."<h3> Rate: ";
        }
        else{
            $name = $row[2];
            $id = $row[6];
            //$_SESSION["namev2"] = $name;

            $is_following = false;
            if ($_SESSION != null) {
                $is_following = strpos($_SESSION["data"][13], $id, 0);
            }
            //$_SESSION["first"] = 'yes';
            echo "<a href=userProfv2.php?id=$id> $name </a> <h3> Rate:";
        }
        echo $row[4]." Date: ";
        echo $row[3]."<br><br></h3>";
        echo $row[1];
        echo "<br>";
        echo"</div>";

    }

}

restore_error_handler();
?>
</body>




</html>






