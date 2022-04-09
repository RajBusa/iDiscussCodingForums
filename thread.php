<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
    <title>iDiscuss - Coding Forums</title>
</head>

<body>
    <?php include "partials/_dbconnect.php"?>
    <?php include "partials/_header.php"?>
    <?php
    $method = $_SERVER['REQUEST_METHOD'];
    // echo $method;
    $showAlert = false;
    if ($method == 'POST') {
        //Insert in to db
        $id = $_GET['threadid'];
        $comment = $_POST['comment'];
        $sno = $_POST['sno'];
        $sql = "INSERT INTO `comments` (`comment_content`, `thread_id`, `comment_by`, `comment_time`) VALUES ('$comment', '$id', '$sno', current_timestamp())";
        $result = mysqli_query($conn, $sql);
        $showAlert = true;
        if ($showAlert) {
            echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
                <strong>Success!</strong> .Your comment has been added!
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>';
        }
    }
    ?>

    <?php
    $id = $_GET['threadid'];
    $sql = "SELECT * FROM `threads` WHERE thread_id=$id";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);
    $title = $row['thread_title'];
    $desc = $row['thread_desc'];
    $uid = $row['thread_user_id'];
    $sql3 = 'SELECT `user_email` FROM `user` WHERE sno='.$uid;
    $result3 = mysqli_query($conn ,$sql3);
    $row3 = mysqli_fetch_assoc($result3);
    echo '<div class="container my-4">
        <div class="jumbotron">
            <h1 class="display-4"> ' . $title . ' forums</h1>
            <p class="lead my-3">' . $desc . '</p>
            <hr class="my-4">
            <p>No Spam / Advertising / Self-promote in the forums.
                Do not post copyright-infringing material.
                Do not post “offensive” posts, links or images.
                Do not cross post questions.
                Do not PM users asking for help.
                Remain respectful of other members at all times.</p>
            <p class="lead">
            Posted By: <em class="font-weight-bold">'. $row3['user_email'] .'</em>
            </p>
        </div>
    </div>';
    ?>

    <div class="container">
        <h1 class="py-3">Post a Comment</h1>
        <?php
        if(isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true){
        echo '<form action=" ' . $_SERVER['REQUEST_URI'] .'" method="post">
            <div class="form-group">
                <label for="exampleFormControlTextarea1">Type your comment</label>
                <textarea class="form-control" id="comment" name="comment" rows="3"></textarea>
                <input type="hidden" name="sno" value="'.$_SESSION['sno'].'">
            </div>
            <button type="submit" class="btn btn-success">Post Comment</button>
        </form>';
        }
        else{
            echo '<p class="lead">You are not loggedin. Please login to be able to start a Discussion</p>';
        }
        ?>
        <h1 class="py-3">Discussion</h1>
    <?php
        $id = $_GET['threadid'];
        $sql = "SELECT * FROM `comments` WHERE thread_id=$id";
        $result = mysqli_query($conn, $sql);

        while($row = mysqli_fetch_assoc($result)){
        $content = $row['comment_content'];
        $content = str_replace("<", "&lt;", $content);
        $content = str_replace(">", "&gt;", $content);
        $comment_time = $row['comment_time'];
        $userid = $row['comment_by'];
        $sql2 = 'SELECT `user_email` FROM `user` WHERE sno='.$userid;
        $result2 = mysqli_query($conn ,$sql2);
        $row2 = mysqli_fetch_assoc($result2);
        echo '<div class="media my-3">
            <img src="image/userdefaultimage.png" width="64px" height="64px" class="mr-3" alt="...">
            <div class="media-body">
                <p class="font-weight-bold my-0">'.$row2['user_email'].' at '. $comment_time. '</p>
                '. $content .'
            </div>
        </div>';
        }
        
    ?>
        
    </div>

    <?php
    include "partials/_footer.php";
    ?>
    <!-- Optional JavaScript; choose one of the two! -->

    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>

    <!-- Option 2: Separate Popper and Bootstrap JS -->
    <!--
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js" integrity="sha384-7+zCNj/IqJ95wo16oMtfsKbZ9ccEh31eOz1HGyDuCQ6wgnyJNSYdrPa03rtR1zdB" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js" integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13" crossorigin="anonymous"></script>
    -->
</body>

</html>