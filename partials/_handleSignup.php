<?php  
$showError = "false";
if($_SERVER["REQUEST_METHOD"] == "POST"){
    include '_dbconnect.php';
    $user_email = $_POST['signupEmail'];
    $pass = $_POST['signupPass'];
    $cpass = $_POST['signupcPass'];
    $existSql = "select * from `user` where user_email = '$user_email'";
    $result = mysqli_query($conn, $existSql);
    $numRow = mysqli_num_rows($result);
    if($numRow > 0){
        $showError = "Email already in use";
    } else {
        if($pass == $cpass){
            $hash = password_hash($pass, PASSWORD_DEFAULT);
            $sql = "INSERT INTO `user` (`user_email`, `user_pass`, `timestamp`) VALUES ('$user_email', '$hash', current_timestamp())";
            $result = mysqli_query($conn, $sql);
            if($result){
                $showAlert = true;
                // header("Location: 2_forum/index.php?signupsuccess=true");
                header("Location: /PHPtut/2_forum/index.php?signupsuccess=true&error=$showError");
                exit();
            }

        } else {
            $showError = "Password do not match";
        }    
    }
    header("Location: /PHPtut/2_forum/index.php?signupsuccess=false&error=$showError"); 
}

?>