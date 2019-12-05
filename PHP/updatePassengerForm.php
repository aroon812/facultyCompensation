<!DOCTYPE html>
<html>
        <head>
                <meta charset="UTF-8">
                <link rel="stylesheet" href="index.css">
                <link rel="icon" href="favicon.ico" type="image/x-icon"/>
                <link rel="shortcut icon" href="favicon.ico" type="image/x-icon"/>
                <title>Passenger Updated!</title>
        </head>

        <body>
                <article>
                        <h3>Updated Passenger Info:</h3>
                        First Name:
                        <?php echo $_POST["f_name"]; ?><br>
                        Middle Name:
                        <?php echo $_POST["m_name"]; ?><br>
                        Last Name:
                        <?php echo $_POST["l_name"]; ?><br>
                        SSN:
                        <?php echo $_POST["SSN"]; ?> <br><br>
                </article>
                        <?php
                                        //path to the SQLite database file
                                        $db_file = '../DB/bigTuba.db';

                                try {
                                        //open connection to the airport database file
                                        $db = new PDO('sqlite:' . $db_file);
                                        //set errormode to use exceptions
                                        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                                        $query_str = $db->prepare("UPDATE passengers SET f_name = :f_name, m_name = :m_name, l_name = :l_name, ssn = :SSN where ssn = :id");
                                        $query_str->bindParam(':f_name', $_POST["f_name"]);
                                        $query_str->bindParam(':m_name', $_POST["m_name"]);
                                        $query_str->bindParam(':l_name', $_POST["l_name"]);
                                        $query_str->bindParam(':SSN', $_POST["SSN"]);
                                        $query_str->bindParam(':id', $_POST["id"]);
                                        if ($query_str->execute()){
                                                echo "Success!<br>";
                                        } 
                                
                                        //return all passengers, and store the result set
                                        $query_str = $db->prepare("select * from passengers");
                                        if ($query_str->execute()){
                                                $i = 0;
                                                $result_set = $db->query("select * from passengers");
                                                while($row = $result_set->fetch()) {
                                                        echo "<form action='updatePassenger.php' method='post'>(";
                                                        for ($i = 0; $i < count($row)/2; $i++) {
                                                                if ($row[$i] == NULL){
                                                                        echo "[NULL]";
                                                                } else {
                                                                        echo $row[$i];
                                                                }
                                                                if ($i == count($row)/2 -1){
                                                                        echo ")";
                                                                } else {
                                                                        echo ", ";
                                                                }
                                                        }
                                                        echo "  <input type='hidden' name='f_name' value=$row[0]>
                                                                        <input type='hidden' name='m_name' value=$row[1]>
                                                                        <input type='hidden' name='l_name' value=$row[2]>
                                                                        <input type='hidden' name='ssn' value=$row[3]>
                                                                        <input type='submit' value='Update'>
                                                                </form><br>";
                                                        
                                                        $i = $i + 1;
                                                }
                                        }

                                        //disconnect from db
                                        $db = null;
				}
				catch(PDOException $e) {
                                        $ssn = $_POST["id"];
                                        echo "<form action='updatePassenger.php' method='post'>
                                                <input type='hidden' name='ssn' value=$ssn>
                                                <input type='hidden' name='error' value=$e>
                                                <input type='submit' value=True> 
                                                </form><br>";
                                        echo header('Location: updatePassenger.php');
                                        //die('Exception : '.$e->getMessage());
                                        
                                

                                        exit;
                                }
                        ?>
                </article>
        </body>
</html>

