<!doctype html>
<html>

<head>
  <meta charset="utf-8">
  <title>University of Puget Sound Payroll</title>
  <meta name="description" content="">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <link rel="manifest" href="site.webmanifest">
  <link rel="apple-touch-icon" href="icon.png">
  <!-- Place favicon.ico in the root directory -->
  <link rel="stylesheet" href="../../../CSS/main.css">

  <meta name="theme-color" content="#fafafa">
</head>

<body>
  <!--[if IE]>
    <p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="https://browsehappy.com/">upgrade your browser</a> to improve your experience and security.</p>
  <![endif]-->
  
  <div class="navbar">
    <a href="../../../index.html">Home</a>
    <a href="../../current.html">Current</a>
    <a href="../../past.html">Past</a>
    <a href="../../projected.html">Projected</a>
    <a href="../../departments.html"> Departments</a>
    <a href="../../employees.html"> Employees</a>
    <a href="../../adjustments.html"> Adjustments</a>
    <a href="../../salaryScale.html"> Salary Scale</a>
    <a href="../../adjEmp.html"> EmployeeAdjustments</a>
    <a href="../../empInfoYear.html">EmployeeInformationByYear</a>
    <div class="dropdown">
      <button class="dropbtn">Edit Data 
        <i class="fa fa-caret-down"></i>
      </button>
      <div class="dropdown-content">
        <a href="../../add.html">add</a>
        <a href="../../update.html">update</a>
        <a href="../../delete.html">delete</a>
      </div>
    </div> 
  </div>

  <h1 class="pagetitle">Add Employee</h1>

  <article>
			<h3>New Employee Info:</h3>
			First Name:
			<?php echo $_POST["firstName"]; ?><br>
			Last Name:
			<?php echo $_POST["lastName"]; ?><br>
			UPS ID:
			<?php echo $_POST["upsID"]; ?><br>
			Type:
			<?php echo $_POST["type"]; ?> <br><br>
			Department:
			<?php echo $_POST["dept"]; ?> <br><br>
			<?php
                //path to the SQLite database file
                $db_file = '../../../DB/bigTuba.db';
                
                try {
                    //open connection to the airport database file
                    $db = new PDO('sqlite:' . $db_file);
                    //set errormode to use exceptions
                    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                    
                    $query_str = $db->prepare("INSERT INTO employee VALUES (:upsID, :lastName, :firstName, :type, :dept)");
                    $query_str->bindParam(':firstName', $_POST["firstName"]);
                    $query_str->bindParam(':lastName', $_POST["lastName"]);
                    $query_str->bindParam(':upsID', $_POST["upsID"]);
                    $query_str->bindParam(':type', $_POST["type"]);
                    $query_str->bindParam(':dept', $_POST["dept"]);
                    if ($query_str->execute()){
                        echo "Success!<br>";
                    }
                    
                  
                    //path to the SQLite database file
                    $db_file = '../../../DB/bigTuba.db';
                
                    
                        //open connection to the airport database file
                        $db = new PDO('sqlite:' . $db_file);
              
                        //set errormode to use exceptions
                        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                        //return all passengers, and store the result set
                        $query_str = $db->prepare("select * from Employee");
                    
                        if ($query_str->execute()){
                            $i = 0;
                            $result_set = $db->query("select * from Employee");
                            echo "<table align='center'>";
                            echo "<tr><td>upsID</td><td>lastName</td><td>firstName</td><td>type</td><td>dept</td></tr>";
                            while($row = $result_set->fetch()) {
                              if ($row[$i] == NULL){
                                echo "<tr><td>[NULL]<tr><td>";
                              } else {
                                echo "<tr><td>" . $row['upsID'] . "</td><td>" . $row['lastName'] . "</td><td>" . $row['firstName'] . "</td><td>" . $row['type'] . "</td><td>" . $row['dept'] . "</td></tr>";
                              }
                            }
                            echo "</table>";
                        }
                        //disconnect from db
                        $db = null;
                    } catch(PDOException $e) {
                        die('Exception : '.$e->getMessage());
                    }
                ?>
	</article>

</body>
</html>