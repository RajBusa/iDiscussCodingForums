<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
    <style>
        #forfooter {
            min-height: 680px;
        }
    </style>
    <title>iDiscuss - Coding Forums</title>
</head>

<body>
    <?php include "partials/_dbconnect.php"; ?>
    <?php include "partials/_header.php"; ?>

    <?php
    $id = $_GET['catid'];
    $sql = "SELECT * FROM `categories` WHERE category_id=$id";
    $result = mysqli_query($conn, $sql);
    while ($row = mysqli_fetch_assoc($result)) {
        $catname = $row["category_name"];
        $catdesc = $row["category_description"];
    }
    ?>

    <?php
    $method = $_SERVER['REQUEST_METHOD'];
    // echo $method;
    $showAlert = false;
    if ($method == 'POST') {
        //Insert in to db
        $th_title = $_POST['title'];
        $th_desc = $_POST['desc'];
        $sno = $_POST['sno'];
        $sql = "INSERT INTO `threads` (`thread_title`, `thread_desc`, `thread_cat_id`, `thread_user_id`, `timestamp`) VALUES ('$th_title', '$th_desc', '$id', '$sno', current_timestamp())";
        $result = mysqli_query($conn, $sql);
        $showAlert = true;
        if ($showAlert) {
            echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
                <strong>Success!</strong> .Your thread has been added! Please wait for community to respond
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>';
        }
    }
    ?>

    <div class="container my-4">
        <div class="jumbotron">
            <h1 class="display-4">Welcome to <?php echo $catname ?>forums</h1>
            <p class="lead my-3"><?php echo $catdesc ?></p>
            <hr class="my-4">
            <p>No Spam / Advertising / Self-promote in the forums.
                Do not post copyright-infringing material.
                Do not post “offensive” posts, links or images.
                Do not cross post questions.
                Do not PM users asking for help.
                Remain respectful of other members at all times.</p>
            <p class="lead">
                <a class="btn btn-success btn-lg" href="#" role="button">Learn more</a>
            </p>
        </div>
    </div>



    <div class="container" id="forfooter">
    <h1>Start a Discussion</h1>
    <?php
    if(isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true){
    echo '<form action="'. $_SERVER['REQUEST_URI'] .'" method="post">
            <div class="form-group">
                <label for="exampleInputEmail1">Problem title</label>
                <input type="text" class="form-control" id="title" name="title" aria-describedby="emailHelp">
                <small id="emailHelp" class="form-text text-muted">Keep your title as short and crisp as possible</small>
            </div>
            <div class="form-group">
                <label for="exampleFormControlTextarea1">Ellaborate Your Concern</label>
                <textarea class="form-control" id="desc" name="desc" rows="3"></textarea>
            </div>
            <input type="hidden" name="sno" value="'.$_SESSION['sno'].'">
            <button type="submit" class="btn btn-success">Submit</button>
        </form>';
    }
    else{
        echo '<p class="lead">You are not loggedin. Please login to be able to start a Discussion</p>';
    }
    ?>
        <h1 class="py-3">Browse Question</h1>
        <?php
        $id = $_GET['catid'];
        $sql = "SELECT * FROM `threads` WHERE thread_cat_id=$id";
        $result = mysqli_query($conn, $sql);
        $noResult = true;
        while ($row = mysqli_fetch_assoc($result)) {
            $noResult = false;
            $title = $row['thread_title'];
            $title = str_replace("<", "&lt;", $title);
            $title = str_replace(">", "&gt;", $title);

            $desc = $row['thread_desc'];
            $desc = str_replace("<", "&lt;", $desc);
            $desc = str_replace(">", "&gt;", $desc);
            
            $thread_id = $row['thread_id'];
            $userid = $row['thread_user_id'];
            $sql2 = 'SELECT `user_email` FROM `user` WHERE sno='.$userid;
            $result2 = mysqli_query($conn ,$sql2);
            $row2 = mysqli_fetch_assoc($result2);
                 
            echo '<div class="media my-3">
            <img src="image/userdefaultimage.png" width="64px" height="64px" class="mr-3" alt="...">
            <div class="media-body">
                <p class="font-weight-bold my-0"> '. $row2['user_email'] .' at '. $row['timestamp'] .'</p>
                <h5 class="mt-0"><a href = "thread.php?threadid=' . $thread_id . '">' . $title . '</a></h5>
                ' . $desc . '
            </div>
        </div>';
        }
        ?>
        
        <?php
        if ($noResult) {
            echo '<div class="jumbotron my-3 jumbotron-fluid">
            <div class="container">
              <p class="display-4">No Thread Found</p>
              <p class="lead">Be the first person to ask a question</p>
            </div>
          </div>';
        }

        ?>
        <!-- <div class="media my-3">
            <img src="image/userdefaultimage.png" width="64px" height="64px" class="mr-3" alt="...">
            <div class="media-body">
                <h5 class="mt-0">Unable to install Pyaudio error in windows</h5>
                Cras sit amet nibh libero, in gravida nulla. Nulla vel metus scelerisque ante sollicitudin. Cras purus odio, vestibulum in vulputate at, tempus viverra turpis. Fusce condimentum nunc ac nisi vulputate fringilla. Donec lacinia congue felis in faucibus.
            </div>
        </div> -->


    </div>



    <?php
    include "partials/_footer.php"
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