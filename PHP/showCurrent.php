<!doctype html>
<html>

<head>
  <meta charset="utf-8">
  <title>University of Puget Sound Payroll</title>
  <meta name="description" content="">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <link rel="manifest" href="site.webmanifest">
  <link rel="apple-touch-icon" href="icon.png">
  <link rel="stylesheet" href="../CSS/main.css">

  <meta name="theme-color" content="#fafafa">
</head>

<body>
  <!--[if IE]>
    <p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="https://browsehappy.com/">upgrade your browser</a> to improve your experience and security.</p>
  <![endif]-->
  <div class="navbar">
    <a href="../index.html">Home</a>
    <a class="active" href="./showCurrent.php">Current</a>
    <a href="./past.php">Past</a>
    <a href="./projected.php">Projected</a>
    <a href="./showDepartments.php"> Departments</a>
    <a href="./showEmployees.php"> Employees</a>
    <a href="./showAdjustments.php"> Adjustments</a>
    <a href="./showSalaryScale.php"> Salary Scale</a>
    <a href="./showAdjEmp.php"> Employee Adjustments</a>
    <a href="./showEmpInfoYear.php">Employee Information By Year</a>
    <a href="../HTML/DBAccess.html">SQL Editor</a>
  </div>

  <div id="container">
    <div id="left" class="sticky">
      <p>
        <h2>Current</h2>
        This table holds the base and adjusted salaries of each faculty member for the current fiscal year. On the right, we calculate
        the total budget on salaries for a fiscal year and break down the salary spending by type of professor as well as by rank of professor.
        <h3>Column Value Descriptions:</h3>
        <h4>First Name:</h4>
        - The first name of a faculty member.
        <h4>Last Name:</h4>
        - The last name of a faculty member.
        <h4> Type: </h4>
        - The track of the faculty member. <br>
        - Valid entries: T, I, CL, S, VAPx, VINx, and E <br>
        - Tenure-line <br>
        - Instructor <br>
        - Clinical <br>
        - Shared <br>
        - Visiting Assistant Professor for x years <br>
        - Visiting Instructor for x years <br>
        - Emeritus
        <h4> Rank: </h4>
        - The level of employment for the faculty member. <br>
        - The level of employment for an employee. <br>
        - Valid entries: Inst, Asst, Assc, CLAsst, CLAssc and Full <br>
        - Instructor <br>
        - Assistant Professor <br>
        - Associate Professor <br>
        - Clinical Assistant <br>
        - Clinical Associate <br>
        - Full Professor
        <h4>Base Salary:</h4>
        - The compensation for an employee at a certain rank and step without adjustments.
        <h4>Total Salary:</h4>
        - The compensation for an employee at a certain rank and step with adjustments.
      </p>
    </div>

    <div id="right" class="sticky">
      <h3>Current Report Stats</h3>
      <p>
        This is a breakdown of the current table numbers organized by both "Type" and by "Rank".
      </p>
      <h4>Breakdown Tables:</h4>
      <div id="container">
        <div id="right50">
          <?php
          include "totalSalary.php";
          $db_file = '../DB/bigTuba.db';
          $db = new PDO('sqlite:' . $db_file);
          $salariesByRank = findTotalRankSalaries($db);
          $total = 0;
          foreach ($salariesByRank as $salary) {
            $total += $salary;
          }
          echo "<table align='left'>";
          echo "<tr><td>Salary By Rank</td></tr>";
          echo "<tr><td>" . "Assistant" . "</td><td>" . $salariesByRank['Asst'] . "</td></tr>";
          echo "<tr><td>" . "Associate" . "</td><td>" . $salariesByRank['Assc'] . "</td></tr>";
          echo "<tr><td>" . "Full" . "</td><td>" . $salariesByRank['Full'] . "</td></tr>";
          echo "<tr><td>" . "Instructor" . "</td><td>" . $salariesByRank['Inst'] . "</td></tr>";
          echo "<tr><td>" . "Clinical Assitant" . "</td><td>" . $salariesByRank['CLAsst'] . "</td></tr>";
          echo "<tr><td>" . "Clinical Associate" . "</td><td>" . $salariesByRank['CLAssc'] . "</td></tr>";
          echo "<tr><td><b>Total</b></td><td><b>$total</b></td></tr>";
          echo "</table>";
          $db = null;
          ?>
        </div>
        <div id="left50">
          <?php

          $db_file = '../DB/bigTuba.db';
          $db = new PDO('sqlite:' . $db_file);
          $salariesByType = findTotalTypeSalaries($db);
          $total = 0;
          foreach ($salariesByType as $salary) {
            $total += $salary;
          }
          echo "<table align='right'>";
          echo "<tr><td>Salary By Type</td></tr>";
          echo "<tr><td>" . "Tenure" . "</td><td>" . $salariesByType['T'] . "</td></tr>";
          echo "<tr><td>" . "Instructor" . "</td><td>" . $salariesByType['I'] . "</td></tr>";
          echo "<tr><td>" . "Clinical" . "</td><td>" . $salariesByType['CL'] . "</td></tr>";
          echo "<tr><td>" . "Shared" . "</td><td>" . $salariesByType['S'] . "</td></tr>";
          echo "<tr><td>" . "Visiting Assistant" . "</td><td>" . $salariesByType['VAP'] . "</td></tr>";
          echo "<tr><td>" . "Visiting Instructor" . "</td><td>" . $salariesByType['VIN'] . "</td></tr>";
          echo "<tr><td>" . "Emeritus" . "</td><td>" . $salariesByType['E'] . "</td></tr>";
          echo "<tr><td><b>Total</b></td><td><b>$total</b></td></tr>";
          echo "</table>";
          $db = null;
          ?>
        </div>
      </div>
    </div>

    <div id="center">
      <h2>Current Report</h2>
      <?php
      //path to the SQLite database file
      $db_file = '../DB/bigTuba.db';

      try {
        //open connection to the database
        $db = new PDO('sqlite:' . $db_file);
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $query_str = $db->prepare("with A as (select max(year) from EmployeePositionInformationByYear) select firstName, lastName, baseSalary from SalaryScale natural join EmployeePositionInformationByYear natural join Employee where year in A");

        if ($query_str->execute()) {
          $i = 0;
          $totalSalaries = 0;
          $result_set = $db->query("with A as (select max(year) from EmployeePositionInformationByYear) select firstName, lastName, baseSalary, year, upsID, rank, type from SalaryScale natural join EmployeePositionInformationByYear natural join Employee where year in A");
          echo "<table align='center'>";
          echo "<tr><td>First Name</td><td>Last Name</td><td>Type</td><td>Rank</td><td>Base Salary</td><td>Total Salary</td></tr>";
          while ($row = $result_set->fetch()) {
            if ($row[$i] == NULL) {
              echo "<tr><td>[NULL]<tr><td>";
            } else {
              $totalSalary = findTotalSalary($db, $row['upsID'], $row['year']);
              echo "<tr><td>" . $row['firstName'] . "</td><td>" . $row['lastName'] . "</td><td>" . $row['type'] . "</td><td>" . $row['rank'] . "</td><td>" . $row['baseSalary'] . "</td><td>" . $totalSalary . "</td></tr>";
              $totalSalaries += $totalSalary;
            }
          }
          echo "</table>";
        }

        //disconnect from db
        $db = null;
      } catch (PDOException $e) {
        die('Exception : ' . $e->getMessage());
      }
      ?>
    </div>
  </div>
</body>

</html>