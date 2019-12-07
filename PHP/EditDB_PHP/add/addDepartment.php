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

  <h1 class="pagetitle">Add Department</h1>

  <article>
			<h3>New Department Info:</h3>
			Dept ID:
			<?php echo $_POST["deptID"]; ?><br>
			Dept Name:
			<?php echo $_POST["deptName"]; ?><br>
			<?php
                //path to the SQLite database file
                $db_file = '../../../DB/bigTuba.db';
                
                try {
                    //open connection to the airport database file
                    $db = new PDO('sqlite:' . $db_file);
                    $db->exec( 'PRAGMA foreign_keys = ON;' );
                    //set errormode to use exceptions
                    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                    
                    $query_str = $db->prepare("INSERT INTO department VALUES (:deptID, :deptName)");
                    $query_str->bindParam(':deptID', $_POST["deptID"]);
                    $query_str->bindParam(':deptName', $_POST["deptName"]);
                    if ($query_str->execute()){
                        echo "Success!<br>";
                    }
                    //open connection to the airport database file
                $db = new PDO('sqlite:' . $db_file);
                $db->exec( 'PRAGMA foreign_keys = ON;' );

                //set errormode to use exceptions
                $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                //return all passengers, and store the result set
                $query_str = $db->prepare("select * from department");
            
                if ($query_str->execute()){
                    $i = 0;
                    $result_set = $db->query("select * from department");
                    echo "<table align='center'>";
                    echo "<tr><td>deptID</td><td>deptName</td></tr>";
                    while($row = $result_set->fetch()) {
                      if ($row[$i] == NULL){
                        echo "<tr><td>[NULL]<tr><td>";
                      } else {
                        echo "<tr><td>" . $row['deptID'] . "</td><td>" . $row['deptName'] . "</td></tr>";
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