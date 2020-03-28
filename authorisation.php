<?php
    //start the session
    session_start();
    
    // the function got one parameter that is a list of groups
    function authorise_user($groups=NULL) {

        if (!isset($_SESSION['user_id']) ) {
            header('Location:login_PDO.php?');
            exit;
        }
        
        if( (is_null($groups)) || (empty($groups)) )
            return;

        // display a link to logout
        print("<li><a href='logout.php'>Log Out</a></li>");
        
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
        
        // Set up the query string
        $sqlQuery = 'SELECT gu.user_id FROM groups_users gu, groups g WHERE g.name = :groupName AND g.ID = gu.group_id AND gu.user_id = :userID';
        
        $query = $db->prepare($sqlQuery);

        // Run through each group and check membership
        foreach ($groups as $group) {
            $params = array(
                            'userID' => $_SESSION['user_id'],
                            'groupName' => $group
                            );
            $query->execute($params);
            if($object = $query->fetch(PDO::FETCH_ASSOC)) {
                // If we got a result, the user should be allowed access
                //   Just return so the script will continue to run
                return;
            }
        }
        
        // No matches were found for any group so, the user isn't allowed access
        print("You are not authorised to see this page.");
        exit;
    }
?>