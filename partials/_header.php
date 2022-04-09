<?php
session_start();
echo '<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <div class="container-fluid">
    <a class="navbar-brand" href="index.php">iDiscuss</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="index.php">Home</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="about.php">About</a>
        </li>
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            Categorices
          </a>
          <ul class="dropdown-menu" aria-labelledby="navbarDropdown">';
        $sql = "SELECT category_name, category_id FROM `categories`";
        $result = mysqli_query($conn, $sql);

        while($row = mysqli_fetch_assoc($result)){
          echo'
            <li><a class="dropdown-item" href="thread_list.php?catid='. $row["category_id"] .'">'.$row["category_name"].'</a></li>
          ';
        }
        echo'</ul>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="contect.php">Contect us</a>
        </li>
      </ul>
      <form class="d-flex" action="search.php" method="get">
        <input class="form-control me-2" name="search" action="search.php" type="search" placeholder="Search" aria-label="Search">
        <button class="btn btn-success" type="submit">Search</button>
      </form>';
      if(isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true){
        echo '<a role="button" class="btn btn-outline-success mx-2" href="partials/_logout.php">Logout</a>
        <p class="text-light my-0 mx-2">Welcome '. $_SESSION['userEmail'].' </p>';
      }else{
        include "partials/_loginModal.php";
        include "partials/_signupModal.php";
      }
      //  <button class="btn btn-outline-success mx-2">Login</button>
      // <button class="btn btn-outline-success">SignUp</button> 
    echo'  
    </div>
  </div>
</nav>'
?>
<?php  
  if(isset($_GET['signupsuccess']) && $_GET['signupsuccess'] == "true"){
    echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
    <strong>Success!</strong> Your account is now created and you can login. 
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>';
    // echo $_GET['error']; 
  }
  if(isset($_GET['signupsuccess']) && $_GET['error'] != "false"){
    // echo var_dump($_GET['error']);
    $err = $_GET['error'];
    echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
      <strong>Error!</strong> ' . $err . '
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>';
  }

  if(isset(($_GET['login'])) && ($_GET['login'] == true)){
    $comment = $_GET['comment'];
    // echo $_SESSION['userEmail'];
    echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
    <strong>Success!</strong>' . $comment . '  
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>';
  }

  if(isset(($_GET['login'])) && ($_GET['login'] == false)){
    $comment = $_GET['comment'];
    // echo $_SESSION['userEmail'];
    echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
    <strong>Success!</strong>' . $comment . '  
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>';
  }
?>

