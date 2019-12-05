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

  <h1 class="pagetitle">Add Salary Scale</h1>

  <article>
			<h3>New Salary Scale:</h3>
			Rank:
			<?php echo $_POST["rank"]; ?><br>
			Step:
			<?php echo $_POST["step"]; ?><br>
			Base Salary:
			<?php echo $_POST["baseSalary"]; ?><br>
			<?php
                //path to the SQLite database file
                $db_file = '../../../DB/bigTuba.db';
                
                try {
                    //open connection to the airport database file
                    $db = new PDO('sqlite:' . $db_file);
                    //set errormode to use exceptions
                    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                    
                    $query_str = $db->prepare("INSERT INTO SalaryScale VALUES (:rank, :step, :baseSalary)");
                    $query_str->bindParam(':rank', $_POST["rank"]);
                    $query_str->bindParam(':step', $_POST["step"]);
                    $query_str->bindParam(':baseSalary', $_POST["baseSalary"]);
                    if ($query_str->execute()){
                        echo "Success!<br>";
                    }
                    $db = new PDO('sqlite:' . $db_file);

                    //set errormode to use exceptions
                    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                    //return all passengers, and store the result set
                    $query_str = $db->prepare("select * from SalaryScale order by rank");
                
                    if ($query_str->execute()){
                        $i = 0;
                        $result_set = $db->query("select * from SalaryScale order by rank");
                        echo "<table align='center'>";
                        echo "<tr><td>rank</td><td>step</td><td>baseSalary</td></tr>";
                        while($row = $result_set->fetch()) {
                          if ($row[$i] == NULL){
                            echo "<tr><td>[NULL]<tr><td>";
                            } else {
                              echo "<tr><td>" . $row['rank'] . "</td><td>" . $row['step'] . "</td><td>" . $row['baseSalary'] . "</td></tr>";
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