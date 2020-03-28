    <?php
        
        
        // function to insert data in the database 
        function insertInDB($db) {
            
            // get the data from the front end
            $sid = $_POST['sid'];
            $name = $_POST['fname'];
            $email = $_POST['email'];
            $username = $_POST['username'];
            $password = $_POST['password'];

            // check the values
            if( !$sid || !$name || !$email || !$password) {
                echo 'One or more fields are empty.';
                return;
            }
            else {
                // escape special characters in a string for use in the SQL statement
                // ENCRYPT THE PASSWORD
                $encrypt_pass = password_hash($password, PASSWORD_DEFAULT);

           }
            
            // create a query
           $sqlQuery = "INSERT INTO students VALUES (:sid, :name, :email, :name, :password)";
            
            //prepare the query
            $query = $db->prepare($sqlQuery);
            
            //execute the query
            $query->execute(array(
                                  ':sid' => $sid,
                                  ':name' => $name,
                                  ':email' => $email,
                                  ':username' => $username,
                                  ':password' => $encrypt_pass
                                  ));
            
            
            
/*            $sqlQuery = "INSERT INTO Students VALUES (?, ?, ?)";
            //prepare the query
            $query = $db->prepare($sqlQuery);
            
            //execute the query
            $query->execute(array($sid, $name, $email));
*/            
            // check if the student was successfully inserted in the database
            if ($query) {
                echo 'The student was inserted in the database successfully';
            }
            else {
                // print the error generated
                echo "The student was not inserted in the database:";
            }
            
        }
        
        
        /* Main body */
        //connect to the DB
        
        $dsn = 'mysql:host=127.0.0.1;dbname=projectdb';
        $user = 'root';
        $password = '';
        
        try {
            $db = new PDO($dsn, $user, $password);
            $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            //           echo 'Connection failed: ' . $e->getMessage();
            die('Sorry, database problem');
        }
        
        insertInDB($db);
        
    
    ?>



