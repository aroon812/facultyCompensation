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

  <h1 class="pagetitle">Add Employee Position Information by Year</h1>

  <article>
			<h3>New Employee Position Info:</h3>
			Year:
			<?php echo $_POST["year"]; ?><br>
			UPS ID:
			<?php echo $_POST["upsID"]; ?><br>
			Position Number:
			<?php echo $_POST["positionNumber"]; ?><br>
			Include Next:
			<?php echo $_POST["includeNext"]; ?> <br><br>
			Rank:
            <?php echo $_POST["rank"]; ?> <br><br>
            Step:
            <?php echo $_POST["step"]; ?> <br><br>
            Step Year:
			<?php echo $_POST["stepYear"]; ?> <br><br>
			<?php
                //path to the SQLite database file
                $db_file = '../../../DB/bigTuba.db';
                
                try {
                    //open connection to the airport database file
                    $db = new PDO('sqlite:' . $db_file);
                    $db->exec( 'PRAGMA foreign_keys = ON;' );

                    //set errormode to use exceptions
                    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                    
                    $query_str = $db->prepare("INSERT INTO employeePositionInformationByYear VALUES (:year, :upsID, :positionNumber, :includeNext, :rank, :step, :stepYear)");
                    $query_str->bindParam(':year', $_POST["year"]);
                    $query_str->bindParam(':upsID', $_POST["upsID"]);
                    $query_str->bindParam(':positionNumber', $_POST["positionNumber"]);
                    $query_str->bindParam(':includeNext', $_POST["includeNext"]);
                    $query_str->bindParam(':rank', $_POST["rank"]);
                    $query_str->bindParam(':step', $_POST["step"]);
                    $query_str->bindParam(':stepYear', $_POST["stepYear"]);
                    if ($query_str->execute()){
                        echo "Success!<br>";
                    }
                       //open connection to the airport database file
                $db = new PDO('sqlite:' . $db_file);
                $db->exec( 'PRAGMA foreign_keys = ON;' );

                //set errormode to use exceptions
                $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                //return all passengers, and store the result set
                $query_str = $db->prepare("select year, upsID, positionNumber, includeNext, Rank, Step, stepYear, firstName, lastName from EmployeePositionInformationByYear natural join Employee order by Year desc");
            
                if ($query_str->execute()){
                    $i = 0;
                    $result_set = $db->query("select year, upsID, positionNumber, includeNext, rank, step, stepYear, firstName, lastName from EmployeePositionInformationByYear natural join Employee order by Year desc");
                    echo "<table align='center'>";
                    echo "<tr><td>year</td><td>upsID</td><td>positionNumber</td><td>includeNext</td><td>rank</td><td>step</td><td>stepYear</td><td>firstName</td><td>lastName</td></tr>";
                    while($row = $result_set->fetch()) {
                      if ($row[$i] == NULL){
                        echo "<tr><td>[NULL]<tr><td>";
                      } else {
                        echo "<tr><td>" . $row['year'] . "</td><td>" . $row['upsID'] . "</td><td>" . $row['positionNumber'] . "</td><td>" . $row['includeNext'] . "</td><td>" . $row['rank'] . "</td><td>" . $row['step'] . "</td><td>" . $row['stepYear'] . "</td><td>" . $row['firstName'] . "</td><td>" . $row['lastName'] . "</td></tr>";
                      }
                    }
                    echo "</table>";
                }
                //disconnect from db
                $db = null;



                } catch(PDOException $e) {
                  $message = $e->getMessage();
                  if (strpos($message, "UNIQUE")){
                      echo "
                        <script>
                        alert('Unique constraint failed!');
                        window.location = './../../showEmployees.php';
                        </script>
                        ";
                  } 
                  elseif (strpos($message, "CHECK")){
                    echo "
                      <script>
                      window.location = './../../showEmployees.php';
                      alert('Check constraint failed!');
                      </script>
                      ";
                  } 
                  elseif (strpos($message, "FOREIGN")){
                    echo "
                      <script>
                      window.location = './../../showEmployees.php';
                      alert('Foreign key constraint failed!');
                      </script>
                      ";
                  }                     
                  die();      
                }
            ?>
</article>

</body>
</html>