<?php

$login = false;
if ($_SERVER['REQUEST_METHOD'] == "POST") {
    include '_dbconnect.php';
    $email = $_POST['loginEmail'];
    $password = $_POST['loginPass'];
    $sql = "select * from `user` where user_email = '$email'";
    $result = mysqli_query($conn, $sql);
    $numRow = mysqli_num_rows($result);

    if ($numRow == 1) {
        $row = mysqli_fetch_assoc($result);
        if(password_verify($password, $row['user_pass'])){
            $login = true;
            session_start();
            $_SESSION['loggedin'] = true;
            $_SESSION['sno'] = $row['sno'];
            $_SESSION['userEmail'] = $email;
            $comment = 'Login with right password';
            header('location: /PHPtut/2_forum/index.php?comment='.$comment.'&&login='.$login);
            exit;
        }
        $comment = 'Password is wrong';
        header('location: /PHPtut/2_forum/index.php?comment='.$comment.'&&login='.$login);
        exit;
    }
    $comment='You hava no account on our website please signup in our website';
    header('location: /PHPtut/2_forum/index.php?comment='.$comment.'&&login='.$login);
}
?>