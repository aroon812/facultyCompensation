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
  <link rel="stylesheet" href="../CSS/main.css">

  <meta name="theme-color" content="#fafafa">
</head>

<body>
  <!--[if IE]>
    <p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="https://browsehappy.com/">upgrade your browser</a> to improve your experience and security.</p>
  <![endif]-->
  <div class="navbar">
    <a href="../index.html">Home</a>
    <a href="./showCurrent.php">Current</a>
    <a href="../HTML/past.html">Past</a>
    <a href="../HTML/projected.html">Projected</a>
    <a href="./showDepartments.php"> Departments</a>
    <a href="./showEmployees.php"> Employees</a>
    <a href="./showAdjustments.php"> Adjustments</a>
    <a href="./showSalaryScale.php"> Salary Scale</a>
    <a href="./showAdjEmp.php"> EmployeeAdjustments</a>
    <a href="./showEmpInfoYear.php">EmployeeInformationByYear</a>
    <div class="dropdown">
      <button class="dropbtn">Edit Data 
        <i class="fa fa-caret-down"></i>
      </button>
      <div class="dropdown-content">
        <a href="./add.html">add</a>
        <a href="./update.html">update</a>
        <a href="./delete.html">delete</a>
      </div>
    </div> 
  </div>

  <!-- Add your site or application content here -->
  <h1 class="pagetitle">Past</h1>
    <?php
            include "totalSalary.php";

            //path to the SQLite database file
            $db_file = '../DB/bigTuba.db';
        
            try {
                //open connection to the airport database file
                $db = new PDO('sqlite:' . $db_file);

                //set errormode to use exceptions
                $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                //return all passengers, and store the result set
                $query_str = $db->prepare("with A as (select max(year) from EmployeePositionInformationByYear) select firstName, lastName, baseSalary from SalaryScale natural join EmployeePositionInformationByYear natural join Employee where year in A");
            
                if ($query_str->execute()){
                    $i = 0;
                    $totalSalaries = 0;
                    $year=$_POST["year"];
                    $salariesByType = array("T"=>0,"I"=>0,"CL"=>0,"S"=>0,"VAP"=>0,"VIN"=>0,"E"=>0);
                    $salariesByRank = array("Inst"=>0,"Asst"=>0,"Assc"=>0,"Full"=>0,"CLAsst"=>0,"CLAssc"=>0);
                    $result_set = $db->query("select firstName, lastName, baseSalary, year, upsID, rank, type from SalaryScale natural join EmployeePositionInformationByYear natural join Employee where year=$year");
                    
                    echo "<table align='center'>";
                    echo "<tr><td>firstName</td><td>lastName</td><td>baseSalary</td><td>totalSalary</td></tr>";
                    while($row = $result_set->fetch()) {
                      if ($row[$i] == NULL){
                        echo "<tr><td>[NULL]<tr><td>";
                      } else {
                        $totalSalary = findTotalSalary($db, $row['upsID'], $row['year']);
                        echo "<tr><td>" . $row['firstName'] . "</td><td>" . $row['lastName'] . "</td><td>" . $row['baseSalary'] ."</td><td>". $totalSalary . "</td></tr>";
                        $totalSalaries += $totalSalary;
                        if($row['rank']=='Inst'){
                            $salariesByRank["Inst"]+=$totalSalary;
                        }
                        else if ($row['rank']=='Assc'){
                          $salariesByRank["Assc"]+=$totalSalary;
                        }
                        else if ($row['rank']=='Asst'){
                          $salariesByRank["Asst"]+=$totalSalary;
                        }
                        else if ($row['rank']=='Full'){
                          $salariesByRank["Full"]+=$totalSalary;
                        }
                        else if ($row['rank']=='CLAsst'){
                          $salariesByRank["CLAsst"]+=$totalSalary;
                        }
                        else {
                          $salariesByRank["CLAssc"]+=$totalSalary;
                        }
                        if($row['type']=='T'){
                          $salariesByType["T"]+=$totalSalary;
                        }
                        else if ($row['type']=='I'){
                          $salariesByType["I"]+=$totalSalary;
                        }
                        else if ($row['type']=='CL'){
                          $salariesByType["CL"]+=$totalSalary;
                        }
                        else if ($row['type']=='S'){
                          $salariesByType["S"]+=$totalSalary;
                        }
                        else if ($row['type']=='E'){
                          $salariesByType["E"]+=$totalSalary;
                        }
                        else if (strpos($row['type'],'VIN')){
                          $salariesByType["VIN"]+=$totalSalary;
                        }
                        else {
                          $salariesByType["VAP"]+=$totalSalary;
                        }

                      }
                    }
                    echo "</table>";
                }
                //$sals=$salariesByType["T"];
                echo "<h3>Total of $year Salaries: $totalSalaries";
                echo "<h3>Total of $year Tenure Salaries:" . $salariesByType["T"];
                echo "<h3>Total of $year Instructor Salaries:" . $salariesByType["I"];
                echo "<h3>Total of $year Clinical Salaries:" . $salariesByType["CL"];
                echo "<h3>Total of $year Shared Salaries:" .  $salariesByType["S"];
                echo "<h3>Total of $year Visiting Assitant Salaries:" . $salariesByType["VAP"];
                echo "<h3>Total of $year Visiting Instructor Salaries:" . $salariesByType["VIN"];
                echo "<h3>Total of $year Emeritus Salaries:" . $salariesByType["E"];
                echo "<h3>Total of $year Assistant Salaries:" . $salariesByRank["Asst"];
                echo "<h3>Total of $year Associate Salaries:" . $salariesByRank["Assc"];
                echo "<h3>Total of $year Full Salaries:" . $salariesByRank["Full"];
                echo "<h3>Total of $year Instructor Salaries:" . $salariesByRank["Inst"];
                echo "<h3>Total of $year Clinical Assitant Salaries:" . $salariesByRank["CLAsst"];
                echo "<h3>Total of $year Clinical Associate Salaries:" . $salariesByRank["CLAssc"];
                //disconnect from db
                $db = null;
            } catch(PDOException $e) {
                die('Exception : '.$e->getMessage());
            }
        ?>
        </p>
</body>
</html>