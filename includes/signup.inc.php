<?php

if(isset($_POST['signup-submit'])){
    require 'dbh.inc.php';

    $uid=$_POST['uid'];
    $mail=$_POST['mail'];
    $pwd=$_POST['pwd'];
    $pwdrepeat=$_POST['pwd-repeat'];

    //erori

    if(empty($uid) || empty($mail) || empty($pwd) || empty($pwdrepeat)){
        header("Location: ../signup.php?signupemptyfields&uid=".$uid."&mail=".$mail);
        exit();
    }
    elseif(!filter_var($mail,FILTER_VALIDATE_EMAIL) && !preg_match("/^[a-zA-Z0-9]*$/",$uid) ){
        header("Location: ../signup.php?error=invalidemailanduid");
        exit();
    }
    elseif(!filter_var($mail,FILTER_VALIDATE_EMAIL)){
        header("Location: ../signup.php?error=invalidemail&uid=".$uid);
        exit();
    }
    elseif(!preg_match("/^[a-zA-Z0-9]*$/",$uid)){
        header("Location: ../signup.php?error=invalidusername&mail=".$mail);
        exit();
    }
    elseif($pwd!=$pwdrepeat){
        header("Location: ../signup.php?error=PasswordCheck&uid=".$uid."&mail=".$mail);
        exit();
    }
    else{
        $sql="SELECT uidUsers FROM users WHERE uidUsers=?";
        $stmt=mysqli_stmt_init($conn);
        if(!mysqli_stmt_prepare($stmt,$sql)){
            header("Location: ../signup.php?error=sqlerror");
            exit();
        }
        else{
            mysqli_stmt_bind_param($stmt,"s",$uid);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_store_result($stmt);
            $resultCheck=mysqli_stmt_num_rows();
            if($resultCheck>0){
                header("Location: ../signup.php?error=userexists&mail=".$mail);
                exit();
            }
            else{
                $sql="INSERT INTO users (uidUsers,emailUsers,pwdUsers) VALUES (?,?,?)";
                $stmt=mysqli_stmt_init($conn);
                if(!mysqli_stmt_prepare($stmt,$sql)){
                    header("Location: ../signup.php?error=sqlerror");
                    exit();
                }
                else{
                    $hashedpwd=password_hash($pwd,PASSWORD_DEFAULT);
                    mysqli_stmt_bind_param($stmt,"sss",$uid,$mail,$hashedpwd);
                    mysqli_stmt_execute($stmt);
                    mysqli_stmt_store_result($stmt);
                    header("Location: ../signup.php?signup=success");
                    exit();
                }
            }
        }
    }
    mysqli_stmt_close($stmt);
    mysqli_close($conn);

}
else{
    header("Location: ../signup.php");
    exit();
}
