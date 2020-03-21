<?php
    //start the session
    session_start();

    //check if the user is logged in
    //if the 'user_id' is not set in the session then it's the first time the user comes to this page
    if (! isset($_SESSION['user_id']) ) {
        // See if a login form was submitted with a username for login
        if (isset($_POST['username']) && isset($_POST['password'])) {
            // get the username
            $username = htmlentities(trim($_POST['username']));
            // get the password
            $password = htmlentities(trim($_POST['password']));
            
            echo $username . '   ' . $password;
        //    if(! $username || ! $password) {
           //   header('HTTP/1.1 401 Unauthorized');
          //     header('WWW-Authenticate: Basic realm="users"');
          //      exit("You need to fill in both the username and password.");
                
       //   }
            
            //connect to the database
            $dsn = 'mysql:host=127.0.0.1;dbname=projectdb';
            $user = 'root';
            $dbpassword = '';
            
            try {
                $db = new PDO($dsn, $user, $dbpassword);
            } catch (PDOException $e) {
                //        echo 'Connection failed: ' . $e->getMessage();
                die('Sorry, database problem');
            }
            
            
            // Look up the user-provided credentials
            $query = 'SELECT sid, username, password FROM students WHERE username = :username';
            $params = array(
                            'username' => $username,
                            
                            );
            
            $result = $db->prepare($query);
            $result->execute($params);

            echo 'You are ' ,  $username, '   ' ;


            $found = false;
            while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                
                if( password_verify($password, $row['password']) ) {

                  //get the SID and username found in the database
                  $current_SID = $row['sid'];
                  $current_username = $row['username'];
                  //set the session to store the SID and the username
                  $_SESSION['user_id'] = $current_SID;
                  $_SESSION['username'] = $current_username;
                  
                  // go to the next page; in this case readFromDB.php that displays a table
                                      print("read the DB");
                  header("Location:readFromDB_PDO.php");
                  $found = true;
                  break;
              }

            }
            // if the $result contains 0 lines the username and password are not valid. Ask the user to re-enter them
          // if(!$found) {
           //    header('HTTP/1.1 401 Unauthorized');
          // header('WWW-Authenticate: Basic realm="users"');
           //   exit("You need a valid username and password.");
         //  }

        }

        //the cookie was previously set so, redirect to the next page
    } else {
        header("Location:readPDO.php");
   }
?>