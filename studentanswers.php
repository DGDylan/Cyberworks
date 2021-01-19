<?php 
  session_start();
  $errors = array();

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
        <title>Student Results</title>
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
            <h1>Student Results for <?php echo $_SESSION['qstitle'] ?></h1>
        </div>

        <div class="test-qs">
            <div id="testinfo">
                <?php
                    $db = mysqli_connect('mars.cs.qc.cuny.edu', 'rady9141', '23539141', 'rady9141');
                    $title = $_SESSION['qstitle'];
                    $sql = "SELECT questionset_id FROM questionset WHERE title = '$title'";    
                    $result = mysqli_query($db, $sql);
                    $row = mysqli_fetch_assoc($result);
                    $qsid = $row['questionset_id'];

                    $sql2 = "SELECT login, SUM(points) as correctpoints, (SELECT DISTINCT SUM(qs.points) FROM student_answers as s INNER JOIN question as q on s.question_id = q.question_id INNER JOIN questionset_question as qs on q.question_id = qs.question_id WHERE qs.questionset_id = '$qsid' GROUP by s.student_id ORDER by s.student_id) as totalpoints FROM student_answers as s INNER JOIN question as q on s.question_id = q.question_id INNER JOIN questionset_question as qs on q.question_id = qs.question_id INNER JOIN appuser as a on s.student_id = a.user_id WHERE s.answer = q.answer AND qs.questionset_id = '$qsid' GROUP by s.student_id ORDER by s.student_id;";
                    $result2 = mysqli_query($db, $sql2);
                    if (mysqli_num_rows($result2) == 0) {
                        echo "<div id='studentresults'>";
                        echo "<p><b>No students have taken this test.</b></p></br>";
                        echo "</div>";
                    }
                    else {
                        while($r = mysqli_fetch_assoc($result2)) {
                            echo "<div id='studentresults'>";
                            echo "<p><b>Student username:</b> {$r['login']} </br> <b>Result:</b> {$r['correctpoints']}/{$r['totalpoints']}</p></br>";
                            echo "</div>";
                        }
                    }
                ?>
            </div>
        </div>

        <div class="logininfo">
            <?php  if (isset($_SESSION['login'])) : ?>
                <script>
                    document.getElementById("loginlink").style.display="none";
                    document.getElementById("signuplink").style.display="none";
                    //Get usertype
                    var usertype = "<?php echo $_SESSION['usertype']; ?>";
                    console.log(usertype);

                    if(usertype == "S") {
                        $('#navlist').append('<li><a class="active" href="assigned.php">Assigned</a></li>');
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