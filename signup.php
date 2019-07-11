<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" type="text/css" href="http://fonts.googleapis.com/css?family=Source+Sans+Pro:400italic,600italic,700italic,200,300,400,600,700,900">
    <link rel="stylesheet" type="text/css" href="styles.css">
    <link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet"><!--potrebno za responsive design-->
    
    <title>OPG Ćuić Naslovna</title>
</head>
<body>
    <h1>Dobrodošli na OPG Ćuić službenu stranicu!</h1>  
    <nav>
        <div class="logo">
               <h4>OPG Ćuić</h4>
        </div>
        <ul class="nav-links">
            <li><a href="index.php">Početna</a></li>
            <li><a href="gallery.php">Galerija</a></li>
            <li><a href="wineoffer.php">Ponuda Vina</a></li>
        </ul>
        <div class="burger">
            <div class="linija1"></div>
            <div class="linija2"></div>
            <div class="linija3"></div>
        </div>
        <?php
        if(isset($_SESSION['userId'])){
            echo ' <form action="includes/logout.inc.php" method="post">
            <button type="submit" name="logout-submit">Odjava</button>
            </form>';
        }
        else{
            echo '<form action="includes/login.inc.php" method="post">
            <input type="text" name="mailuid" placeholder="Username/email">
            <input type="password" name="pwd" placeholder="Password">
            <button type="submit" name="login-submit">Prijava</button>
            <a href="signup.php">Registracija</a>
            </form>';
        }
        ?>
    </nav>
    <script src="js/app.js"></script>
</body>
</html>

<main>
<div class="registracija">
    <section class="register">
        <h2 class="h2reg">Registracija</h2>
        <?php
        if(isset($_GET['error'])){
            if($_GET['error']=="signupemptyfields"){
                echo '<p class="signuperror">Popunite sva polja!</p>';
            }
            else if($_GET['error']=="invalidemailanduid"){
                echo '<p class="signuperror">Krivo korisničko ime ili loznika!</p>';
            }
            else if($_GET['error']=="invalidemail"){
                echo '<p class="signuperror">Niste unijeli pravilan E-Mail!</p>';
            }
            else if($_GET['error']=="invalidusername"){
                echo '<p class="signuperror">Krivo korisničko ime!</p>';
            }
            else if($_GET['error']=="PasswordCheck"){
                echo '<p class="signuperror">Lozinke su različite!</p>';
            }
            else if($_GET['error']=="userexists"){
                echo '<p class="signuperror">Korisničko ime je zauzeto :(</p>';
            }
        }
        else if(isset($_GET["signup"])){
            echo '<p class="signupsuccess">Registracija je uspješna!</p>';
        }
        ?>
        <form class="form-signup" action="includes/signup.inc.php" method="POST">
            <input type="text" name="uid" placeholder="Username">
            <img src="img/email.png" alt="">
            <input type="text" name="mail" placeholder="Email">
            <img src="img/pwd.png" alt="">
            <input type="password" name="pwd" placeholder="Password">
            <img src="img/pwd.png" alt="">
            <input type="password" name="pwd-repeat" placeholder="Repeat Password">
            <button type="submit" name="signup-submit">Registriraj se!</button>
        </form>
    </section>
   
</div>
</main>