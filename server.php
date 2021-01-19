<?php
    session_start();

    $login = "";
    $email = "";
    $errors = array();

    //Connect to database
    $db = mysqli_connect('mars.cs.qc.cuny.edu', 'rady9141', '23539141', 'rady9141');

    //If register button clicked
    if(isset($_POST['register'])) {
        $login = mysqli_real_escape_string($db, $_POST['login']);
        $pwd = mysqli_real_escape_string($db, $_POST['pwd']);
        $pwd2 = mysqli_real_escape_string($db, $_POST['pwd2']);
        $first_name = mysqli_real_escape_string($db, $_POST['first_name']);
        $last_name = mysqli_real_escape_string($db, $_POST['last_name']);
        $email = mysqli_real_escape_string($db, $_POST['email']);
        $user_type = mysqli_real_escape_string($db, $_POST['user_type']);

        //register error checking
        if (empty($login)) {
            array_push($errors, "Username is required");
        }
        if (empty($pwd)) {
            array_push($errors, "Password is required");
        }
        if ($pwd != $pwd2) {
            array_push($errors, "Passwords do not match");
        }
        if (empty($email)) {
            array_push($errors, "Email is required");
        }
        if(empty($first_name)) {
            array_push($errors, "First name is required");
        }
        if(empty($last_name)) {
            array_push($errors, "Last name is required");
        }

        //check if username and email exists already
        $usrqry = "SELECT * FROM appuser WHERE login='$login';";
        $result = mysqli_query($db, $usrqry);
        $user = mysqli_fetch_assoc($result);

        if ($user) {
            if ($user['login'] === $login) {
              array_push($errors, "Username already exists");
            }
        
            // if ($user['email'] === $email) {
            //   array_push($errors, "Email already exists");
            // }
          }

        //register the account if theres no errors
        if(count($errors) == 0) {
            $type = "";
            if($user_type == "Teacher") {
                $type = "P";
            }
            if($user_type == "Student") {
                $type = "S";
            }
            if($user_type == "Developer") {
                $type = "D";
            }
            $sql = "INSERT INTO appuser(login, pwd, first_name, last_name, email, user_type) VALUES('$login', '$pwd', '$first_name', '$last_name','$email', '$type')";
            mysqli_query($db, $sql);
            
            $sq2 = "SELECT * FROM appuser WHERE login = '$login' AND pwd = '$pwd'";
            $results = mysqli_query($db, $sql2);
            $row = mysqli_fetch_assoc($results);
            $ut = $row['user_type'];
            $uid = $row['user_id'];
            
            $_SESSION['uid'] = $uid;
            $_SESSION['login'] = $login;
            $_SESSION['success'] = "You are now logged in";
            $_SESSION['usertype'] = $type;
            session_destroy();
            header('location: login.php');
        }
        mysqli_close($db); 
    }

    //log in if theres no errors
    if (isset($_POST['loginbtn'])) {
        $login = mysqli_real_escape_string($db, $_POST['login']);
        $pwd = mysqli_real_escape_string($db, $_POST['pwd']);
      
        if (empty($login)) {
            array_push($errors, "Username is required");
        }
        if (empty($pwd)) {
            array_push($errors, "Password is required");
        }
      
        if (count($errors) == 0) {
            $sql = "SELECT * FROM appuser WHERE login = '$login' AND pwd = '$pwd'";
            $results = mysqli_query($db, $sql);

            $row = mysqli_fetch_assoc($results);
            $ut = $row['user_type'];
            $uid = $row['user_id'];
            
            if (mysqli_num_rows($results) == 1) {
                $_SESSION['uid'] = $uid;
                $_SESSION['login'] = $login;
                $_SESSION['success'] = "You are now logged in";
                $_SESSION['usertype'] = $ut;
                header('location: index.php');
            }
            else {
                array_push($errors, "Wrong username/password combination");
            }
        }
        mysqli_close($db); 
      }

?>