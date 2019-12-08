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
  <link rel="stylesheet" href="./../CSS/main.css">

  <meta name="theme-color" content="#fafafa">
</head>

<body>
  <!--[if IE]>
    <p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="https://browsehappy.com/">upgrade your browser</a> to improve your experience and security.</p>
  <![endif]-->
  
  <div class="navbar">
    <a href="../index.html">Home</a>
    <a href="./showCurrent.php">Current</a>
    <a class= "active" href="./past.php">Past</a>
    <a href="./projected.php">Projected</a>
    <a href="showDepartments.php"> Departments</a>
    <a href="./showEmployees.php"> Employees</a>
    <a href="./showAdjustments.php"> Adjustments</a>
    <a href="./showSalaryScale.php"> Salary Scale</a>
    <a href="./showAdjEmp.php"> EmployeeAdjustments</a>
    <a href="./showEmpInfoYear.php">EmployeeInformationByYear</a>
    <a href="../HTML/DBAccess.html">SQL Editor</a>
  </div>

  <div id="container">

<div id="left" class="sticky">
  <p>
    <h3>Past Reports</h3>
    On this page you can select a year up to the current year and get budget and salary information from that year.
  </p>
</div>

<div id="right" class="sticky">
  <p>
    <?php
      $db_file = '../DB/bigTuba.db';
      $db = new PDO('sqlite:' . $db_file);

      //set errormode to use exceptions
      $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      $query_str = $db->prepare("select max(year) as year from EmployeePositionInformationByYear");
          
          if ($query_str->execute()){
              $i = 0;
              $resultYear = $db->query("select max(year) as year from EmployeePositionInformationByYear");
              foreach ($resultYear as $row)
              {
                $result= $row['year'];
              } 
            
              $actualMin =$result-1;
          }
    ?>
    <fieldset class="past">
      <legend><h2>See Past Budgets</h2></legend>
      <form action="./past.php" method="post">
        <br>
        Enter a Year:   
        <?php
            echo "<input type = 'number' min='1950' max='$actualMin' name = 'year' placeholder='year' required autofocus><br>";
        ?>
        <br>
        <input type = "submit" name = "submit" value="Show Past Report">
        
      </form>
      <?php 
          if(isset($_REQUEST['submit'])){
            pastReportStats();
          }
      ?>
    </fieldset>
        

  </p>
</div>

<div id="center">
    <h2>Past Report:</h2>
      <?php
        if(isset($_REQUEST['submit'])){
          pastReport();
        }
      ?>
</div>

</div>


<?php 
        function pastReport(){
          $year = $_POST["year"];
          //path to the SQLite database file
          $db_file = '../DB/bigTuba.db';
      
          try {
              //open connection to the airport database file
              $db = new PDO('sqlite:' . $db_file);

              //set errormode to use exceptions
              $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
              //return all passengers, and store the result set
              $query_str = $db->prepare("select firstName, lastName, baseSalary, year, upsID, rank, type from SalaryScale natural join EmployeePositionInformationByYear natural join Employee where year=$year");
          
              if ($query_str->execute()){
                  $result_set = $db->query("select firstName, lastName, baseSalary, year, upsID, rank, type from SalaryScale natural join EmployeePositionInformationByYear natural join Employee where year=$year");

                  echo "<table align='center'>";
                  echo "<tr><td>firstName</td><td>lastName</td><td>baseSalary</td><td>totalSalary</td></tr>";
                  while($row = $result_set->fetch()) {
                    $totalSalary = findTotalSalary($db, $row['upsID'], $year);
                    echo "<tr><td>" . $row['firstName'] . "</td><td>" . $row['lastName'] . "</td><td>" . $row['baseSalary'] ."</td><td>". $totalSalary . "</td></tr>";
                  }
                  echo "</table>";
              }

              //disconnect from db
              $db = null;
          } catch(PDOException $e) {
              die('Exception : '.$e->getMessage());
          }
        }

        function pastReportStats(){
          $db_file = '../DB/bigTuba.db';
        
          try {
              $year=$_POST["year"];
              echo "<h2>Past Report Stats $year: </h2>" ;
              //open connection to the airport database file
              $db = new PDO('sqlite:' . $db_file);

              //set errormode to use exceptions
              $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
              //return all passengers, and store the result set
              $query_str = $db->prepare("select firstName, lastName, baseSalary, year, upsID, rank, type from SalaryScale natural join EmployeePositionInformationByYear natural join Employee where year=$year");
          
              if ($query_str->execute()){
                  $i = 0;
                  $totalSalaries = 0;
              
                  $salariesByType = array("T"=>0,"I"=>0,"CL"=>0,"S"=>0,"VAP"=>0,"VIN"=>0,"E"=>0);
                  $salariesByRank = array("Inst"=>0,"Asst"=>0,"Assc"=>0,"Full"=>0,"CLAsst"=>0,"CLAssc"=>0);
                  $result_set = $db->query("select firstName, lastName, baseSalary, year, upsID, rank, type from SalaryScale natural join EmployeePositionInformationByYear natural join Employee where year=$year");
                  
                  while($row = $result_set->fetch()) {
                      $totalSalary = findTotalSalary($db, $row['upsID'], $year);
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
              //$sals=$salariesByType["T"];
              echo "<h4>Total of Salaries: $totalSalaries";
              echo "<h3> By Type: ";
              echo "<h4>Total of Tenure Salaries:" . $salariesByType["T"];
              echo "<h4>Total of Instructor Salaries:" . $salariesByType["I"];
              echo "<h4>Total of Clinical Salaries:" . $salariesByType["CL"];
              echo "<h4>Total of Shared Salaries:" .  $salariesByType["S"];
              echo "<h4>Total of Visiting Assitant Salaries:" . $salariesByType["VAP"];
              echo "<h4>Total of Visiting Instructor Salaries:" . $salariesByType["VIN"];
              echo "<h4>Total of Emeritus Salaries:" . $salariesByType["E"];
              echo "<h3> By Rank: ";
              echo "<h4>Total of Assistant Salaries:" . $salariesByRank["Asst"]; 
              echo "<h4>Total of Associate Salaries:" . $salariesByRank["Assc"];
              echo "<h4>Total of Full Salaries:" . $salariesByRank["Full"];
              echo "<h4>Total of Instructor Salaries:" . $salariesByRank["Inst"];
              echo "<h4>Total of Clinical Assitant Salaries:" . $salariesByRank["CLAsst"];
              echo "<h4>Total of Clinical Associate Salaries:" . $salariesByRank["CLAssc"];
              //disconnect from db
              $db = null;
          } catch(PDOException $e) {
              die('Exception : '.$e->getMessage());
          }
        } 

        function findTotalSalary($db, $upsID, $year){
          $adjustmentID_results = $db->query("select adjID from EmployeeAdjustments where year = $year and upsID = $upsID");
          $adjustmentIDs = $adjustmentID_results->fetch(PDO::FETCH_ASSOC);
          $baseSalaryQuery = $db->query("select baseSalary from EmployeePositionInformationByYear natural join SalaryScale where upsID = $upsID");
          $baseSalary = $baseSalaryQuery->fetch()[0];
          
          if (is_array($adjustmentIDs) || is_object($adjustmentIDs)){
          foreach ($adjustmentIDs as $adjustmentID){
            $adjustment_result = $db->query("select * from SalaryAdjustments where adjID = $adjustmentID");
            $adjustment = $adjustment_result->fetch();
            if ($adjustment["operation"] == "x"){
              $baseSalary *= $adjustment["adjVal"];
            }
          }
          foreach ($adjustmentIDs as $adjustmentID){
            $adjustment_result = $db->query("select * from SalaryAdjustments where adjID = $adjustmentID");
            $adjustment = $adjustment_result->fetch();
            if ($adjustment["operation"] == "+"){
              $baseSalary += $adjustment["adjVal"];
            }   
          }
        }
          return $baseSalary;
        }
?>
</body>
</html>