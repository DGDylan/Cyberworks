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
        <title>Create</title>
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
            <h1>Create a Question Set</h1>                   
        </div>

        <div class="create">
            <div id="creatediv">
                <form id="createform" method="POST"> 
                    <div id="questions">
                        <div id="qline">
                            <label>Question Set Title: </label>
                            <input type="text" id="title" name="title"/>
                            <!-- <label>Question type: </label>
                            <select id="questiontype" name="questiontype[]">
                                <option value="WA">Word Answer</option>
                                <option value="MC">Multiple Choice</option>
                            </select> -->
                            <label>Question title: </label>
                            <input style="display:inline-grid;" type="text" id="qtitle" name="qtitle[]"/>
                            <label>Question: </label>
                            <input type="text" id="q" name="q[]"/>
                            <label>Answer: </label>
                            <input type="text" id="a" name="a[]"/>
                            <label>Points: </label>
                            <input type="number" id="pts" name="pts[]"/>
                            </br>
                        </div>
                    </div>
                    <p id="createbtnp">
                        <button id="addquestion" name="addquestion">Add Question</button>
                        <button type="submit" name="createbtn" class="createbtn">Create</button>
                    </p>
                </form> 
            </div> 
        </div>

        <!-- Script to add and remove questions to div -->
        <script>
            $(document).ready(function() {
                //Var
                var qform =
                        '<div id="qline">' +
                        '<label>Question title: </label>' +
                        '<input type="text" id="qtitle" name="qtitle[]"/>' +
                        '<label>Question: </label>' +
                        '<input type="text" id="q" name="q[]"/>' +
                        '<label>Answer: </label>' +
                        '<input type="text" id="a" name="a[]"/>' +
                        '<label>Points: </label>' +
                        '<input type="number" id="pts" name="pts[]"/>' +
                        '<button id="removequestion" name="removequestion">Remove</button>' +
                        '</br>' +
                        '</div>';
                    //Add question
                    $("#addquestion").click(function() {
                        console.log("Button clicked");
                        $('#questions').append(qform);
                        return false;
                    });
                    
                    //Remove question
                    $("#questions").on('click','#removequestion', function() {
                        $(this).parent('div').remove();
                    });
            });
        </script>

        <!-- Upload Question set -->
        <?php
            if(isset($_POST['createbtn'])) {
                $db = mysqli_connect('mars.cs.qc.cuny.edu', 'rady9141', '23539141', 'rady9141');
                $title = mysqli_real_escape_string($db, $_POST['title']);
                
                //check if title is blank
                if(empty($title)) {
                    echo "<p style='text-align:center; color:red;'>Title cannot be blank!</p>";
                }

                //otherwise try and upload to server
                else {
                    //check if title exists
                    $titleqry = "SELECT * FROM questionset WHERE title='$title' LIMIT 1";
                    $titleresult = mysqli_query($db, $titleqry);
                    $retrievedtitle = mysqli_fetch_assoc($titleresult);

                    if($retrievedtitle) {
                        if($retrievedtitle['title'] === $title) {
                            echo "<p style='text-align:center; color:red;'>Title exists!</p>";
                        }
                    }

                    else {
                        //insert into questionset table
                        $sql = "INSERT INTO rady9141.questionset(title) VALUES('$title')";
                        mysqli_query($db, $sql);

                        for($i = 0; $i < count($_POST['q']); $i++) {
                            // $questiontype = mysqli_real_escape_string($db, $_POST['questiontype'][$i]);
                            $qt = mysqli_real_escape_string($db, $_POST['qtitle'][$i]);
                            $q = mysqli_real_escape_string($db, $_POST['q'][$i]);
                            $a = mysqli_real_escape_string($db, $_POST['a'][$i]);
                            $pts = mysqli_real_escape_string($db, $_POST['pts'][$i]);

                            //insert into question table
                            if(empty(trim($q))) continue;
                            $sql2 = "INSERT INTO question(title, question_type, content, answer) VALUES('$qt','WA','$q', '$a')";
                            mysqli_query($db, $sql2);
                            
                            //get questionset id
                            $sql3 = "SELECT * FROM questionset WHERE title = '$title'";
                            $results = mysqli_query($db, $sql3);
                            $row = mysqli_fetch_assoc($results);
                            $qsid = $row['questionset_id'];

                            //get question id
                            $sql4 = "SELECT * FROM question WHERE title = '$qt' AND question_type = 'WA' AND content = '$q' AND answer = '$a'";
                            $results2 = mysqli_query($db, $sql4);
                            $row2 = mysqli_fetch_assoc($results2);
                            $qid = $row2['question_id'];

                            $sql5 = "INSERT INTO questionset_question(questionset_id, question_id, points) VALUES('$qsid', '$qid', '$pts')";
                            mysqli_query($db, $sql5);
                            header('location: manage.php');
                        }
                    }
                }
                mysqli_close($db); 
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
                        $('#navlist').append('<li><a href="assigned.php">Assigned</a></li>');
                    }

                    if(usertype == "P") {
                        $('#navlist').append('<li><a href="#">Question Sets</a><ul class="dropdown"><li><a class="active" href="create.php">Create</a></li><li><a href="manage.php">Manage</a></li></ul></li>');
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