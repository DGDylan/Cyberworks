<?php 
  session_start(); 

  if (isset($_GET['logout'])) {
  	session_destroy();
  	unset($_SESSION['login']);
  	header("location: login.php");
  }
?>

<!DOCTYPE html>
<html>
    <head>
		<link rel="icon" type="image/png" href="favicon-32x32.png" sizes="32x32" />
		<link rel="icon" type="image/png" href="favicon-16x16.png" sizes="16x16" />
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Help</title>
        <link rel="stylesheet" href="styles.css">
        <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
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
                        <li id="loginlink"><a href="login.php">Login</a></li>
                        <li id="signuplink"><a href="signup.php"">Sign Up</a></li>
                    </div>
                </div>
            </nav>
        </header>

        <div id="headingforcreate">
            <h1>Help</h1>
        </div>

        <div class="helpbody">
            <!-- MAIN BODY   -->
            <div id="help">
                <h1>Student Help</h1>
                <h2>Assigned Page</h2>
                <p>This page will show all of the tests that professors have created. If a test has been taken already, the user can see their grade. If the test hasn't been taken, the user can take the test.</p>
                <br>
                <img src="images/assigned.png" alt="Image of assigned page" width="1280" height="720"/>
                <br>

                <h2>Test Page</h2>
                <p>This page will display all the questions for a test, after the test is submitted, the user will get his/her grade back.</p>
                <br>
                <img src="images/testpage.png" alt="Image of a test page" width="1280" height="720"/>
                <br>
            </div>

            <div id="help">
                <h1>Professor Help</h1>
                <h2>Create Page</h2>
                <p>On this page, professors can create question sets. <br> As of now professors can't: <br></p>
                <ul>
                    <li>Delete question sets</li>
                    <li>Edit questions/points from questionsets</li>
                    <li>Include any of the ' character in their input.</li>
                </ul>
                <br>
                <img src="images/create.png" alt="Image of the create page" width="1280" height="720"/>
                <br>

                <h2>Manage Page</h2>
                <p>This page will show all of the existing question sets. Here the professor can view the question sets when clicking view, or view the grades of students that have taken their test.</p>
                <br>
                <img src="images/manage.png" alt="Image of manage page" width="1280" height="720"/>
                <br>
            </div>
        </div>

        <div class="logininfo">
            <!-- <?php if (isset($_SESSION['success'])) : ?>
                <div class="error" >
                    <h3>
                    <?php 
                        echo $_SESSION['success']; 
                        unset($_SESSION['success']);
                    ?>
                    </h3>
                </div>
            <?php endif ?> -->

            <?php  if (isset($_SESSION['login'])) : ?>
                <script>
                    document.getElementById("loginlink").style.display="none";
                    document.getElementById("signuplink").style.display="none";
                    //Get usertype
                    var usertype = "<?php echo $_SESSION['usertype']; ?>";
                    console.log(usertype);

                    if(usertype == "S") {
                        $('#navlist').append('<li><a href="assigned.php">Assigned</a></li>');
                    }

                    if(usertype == "P") {
                        $('#navlist').append('<li><a href="#">Question Sets</a><ul class="dropdown"><li><a href="create.php">Create</a></li><li><a href="manage.php">Manage</a></li></ul></li>');
                    }

                    if(usertype == "D") {
                        // $('#navlist').append('<li><a href="#">Control Panel</a></li>');
                    }
                    
                    $('#navlist').append('<li style="color:#B1B2C7;">welcome, <?php echo $_SESSION['login']; ?></li>');
                    $('#navlist').append("<li><a href='index.php?logout='1''>Logout</a></li>");
                </script>
            <?php endif ?>
        </div>

        <footer>
            <p>
                Copyright © 2020 Cyberworks Inc. All rights Reserved.
            </p>
        </footer>
    </body>

</html>