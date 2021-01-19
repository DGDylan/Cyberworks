<?php include('server.php'); ?>
<!DOCTYPE html>
<html>
    <head>
		<link rel="icon" type="image/png" href="favicon-32x32.png" sizes="32x32" />
		<link rel="icon" type="image/png" href="favicon-16x16.png" sizes="16x16" />
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Login</title>
        <link rel="stylesheet" href="styles.css">
    </head>

    <body>
    <header>
            <div class="logo">
                <a href="index.php"><img src="images/CYBERWORKS@2x.png" alt="cyberworks"></a>
            </div>

            <nav>
                <label id="hamburger" for="toggle" style="color:white;">&#9776;</label>
                <input type="checkbox" id="toggle"/>
                <div class="menu">
                    <div class="nav_links" id="navlist">
                        <li><a href="index.php">Home</a></li>
                        <li><a href="#">Course links</a>
                            <ul class="dropdown">
                                <li><a href="https://www.zybooks.com/">Zybook</a></li>
                                <li><a href="https://tophat.com/">TopHat</a></li>
                                <li><a href="https://tinyurl.com/CSCI355-Spring2020">Google Drive</a></li>
                                <li><a href="https://bbhosted.cuny.edu/">Blackboard</a></li>
                                <li><a href="https://www.w3schools.com/">W3Schools</a></li>
                            </ul>
                        </li>
                        <li><a href="about-us.php">About Us</a></li>
                        <li><a href="contact-us.php">Contact Us</a>
                            <ul class="dropdown">
                                <li><a href="help.php">Help</a></li>
                            </ul>
                        </li>
                        <li id="loginlink"><a class="active" href="login.php">Login</a></li>
                        <li id="signuplink"><a href="signup.php"">Sign Up</a></li>
                    </div>
                </div>
            </nav>
        </header>

        <div class="login">
            <div id="loginform">
                <h1>Login</h1>
                <form action="login.php" method="POST">                    
                    <p>
                        <label>Username: </label>
                        <input type="text" id="login" name="login"/>
                    </p>
                    <p>
                        <label>Password: </label>
                        <input type="password" id="pwd" name="pwd"/>
                    </p>
                    <p>
                        <button type="submit" name="loginbtn" class="loginbtn">Login</button>
                    </p>
                    <p>
                        Not a member? <a href="signup.php">Sign up</a>
                    </p>
                    <?php include('errors.php'); ?>
                </form>
            </div>     
        </div>
        
        <footer>
            <p>
                Copyright © 2020 Cyberworks Inc. All rights Reserved.
            </p>
        </footer>
    </body>

</html>