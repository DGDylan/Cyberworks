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
        <title>Assigned</title>
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
            <h1>Assigned Question Sets</h1>                   
        </div>

        <div class="manage">
            <?php
                $db = mysqli_connect('mars.cs.qc.cuny.edu', 'rady9141', '23539141', 'rady9141');
                $sql = "SELECT * FROM questionset;";
                $result = mysqli_query($db, $sql);
                $user_id = $_SESSION['uid'];

                while($row = mysqli_fetch_assoc($result)) {
                    $s = $row['title'];
                    
                    $sql3 = "SELECT questionset_id FROM questionset WHERE title = '$s';";
                    $result3 = mysqli_query($db, $sql3);
                    $row3 = mysqli_fetch_assoc($result3);
                    $questionset_id = $row3['questionset_id'];

                    echo "<form id='manageform' method='POST'>";
                    $sql2 = "SELECT * FROM student_answers WHERE student_id = '$user_id' AND questionset_id='$questionset_id';";
                    $result2 = mysqli_query($db, $sql2);
                    if (mysqli_num_rows($result2) == 0) {
                        echo "<div id='qstitle'><h1>Title: $s</h1> <input type='hidden' name='title' value='$s'/> <button type='submit' name='takebtn' class='takebtn'>Take Test</button></div></br>";
                    }
                    else {
                        echo "<input type='hidden' value='$s' name='qstitle'>";
                        echo "<div id='qstitle'><h1>Title: $s</h1> <input type='hidden' name='title' value='$s'/> <button type='submit' name='viewbtn' class='viewbtn'>View Results</button></div></br>";
                    }
                    echo "</form>";
                }
            ?>
        </div>

        <?php
            if(isset($_POST['takebtn'])) {
                $title = $_POST['title'];
                $_SESSION['title'] = $title;
                // echo $title;
                header('location: test.php');
            }

            if(isset($_POST['viewbtn'])) {
                $db = mysqli_connect('mars.cs.qc.cuny.edu', 'rady9141', '23539141', 'rady9141');
                $title = $_POST['qstitle'];
                $_SESSION['title'] = $title;
                $sql = "SELECT questionset_id FROM questionset WHERE title = '$title';";
                $result = mysqli_query($db, $sql);
                $row = mysqli_fetch_assoc($result);
                $questionset_id = $row['questionset_id'];
                $uid = $_SESSION['uid'];
                $sql3 = "SELECT DISTINCT SUM(qs.points) as correct FROM student_answers as s INNER JOIN question as q on s.question_id = q.question_id INNER JOIN questionset_question as qs on q.question_id = qs.question_id WHERE s.answer = q.answer AND qs.questionset_id = '$questionset_id' AND s.student_id = '$uid';";
                $result3 = mysqli_query($db, $sql3);
                $row2 = mysqli_fetch_assoc($result3);
                $_SESSION['amtcorrect'] = $row2['correct'];
                $sql4 = "SELECT DISTINCT SUM(qs.points) as totalpoints FROM student_answers as s INNER JOIN question as q on s.question_id = q.question_id INNER JOIN questionset_question as qs on q.question_id = qs.question_id WHERE qs.questionset_id = '$questionset_id' AND s.student_id = '$uid';";
                $result4 = mysqli_query($db, $sql4);
                $row3 = mysqli_fetch_assoc($result4);
                $_SESSION['totalamt'] = $row3['totalpoints'];
                header('location: results.php');
            }

        ?>

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