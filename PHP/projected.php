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
    <a href="./past.php">Past</a>
    <a class="active" href="./projected.php">Projected</a>
    <a href="./showDepartments.php"> Departments</a>
    <a href="./showEmployees.php"> Employees</a>
    <a href="./showAdjustments.php"> Adjustments</a>
    <a href="./showSalaryScale.php"> Salary Scale</a>
    <a href="./showAdjEmp.php"> Employee Adjustments</a>
    <a href="./showEmpInfoYear.php">Employee Information By Year</a>
    <a href="../HTML/DBAccess.html">SQL Editor</a>
  </div>

  <!-- Add your site or application content here -->

  <div id="container">
    <div id="left25" class="sticky">
      <p>
        <h2>Projected</h2>
        This table holds the base and adjusted salaries of each faculty member for the next fiscal year. On the right, we calculate
        the total budget on salaries for next fiscal year and break down the salary spending by type of professor as well as by rank of professor.
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

    

    <div id="right74">
      <h2>Projected Report</h2>
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
        //$query_str = $db->prepare("with A as (select max(year) from EmployeePositionInformationByYear) select firstName, lastName, baseSalary from SalaryScale natural join EmployeePositionInformationByYear natural join Employee where year in A");
        $query_str = $db->prepare("SELECT max(year) as year from EmployeePositionInformationByYear");
        if ($query_str->execute()) {
          $i = 0;
          $totalSalaries = 0;

          $result_set = $db->query("SELECT max(year) as year from EmployeePositionInformationByYear");
          $row = $result_set->fetch();
          $year = $row['year'];
          $query_str2 = $db->prepare("SELECT upsID as upsID from EmployeePositionInformationByYear where year=$year");
          if ($query_str->execute()) {
            $result_set2 = $db->query("SELECT upsID as upsID from EmployeePositionInformationByYear where year=$year");
            while ($row = $result_set2->fetch()) {
              $ups = $row['upsID'];
              projectEmployee($db, $year, $ups);
            }
          }
          $query_str3 = $db->prepare("with A as (select max(year) from EmployeePositionInformationByYear) select firstName, lastName, baseSalary from SalaryScale natural join EmployeePositionInformationByYear natural join Employee where year in A");

          if ($query_str3->execute()) {
            $i = 0;
            $totalSalaries = 0;
            $result_set = $db->query("with A as (select max(year) from EmployeePositionInformationByYear) select firstName, lastName, baseSalary, year, upsID, rank, type from SalaryScale natural join EmployeePositionInformationByYear natural join Employee where year in A");
            echo "<table align='center'>";
            echo "<tr><td>First Name</td><td>Last Name</td><td>Type</td><td>Rank</td><td>Base Salary</td><td>Total Salary</td></tr>";
            while ($row = $result_set->fetch()) {
                $totalSalary = findTotalSalary($db, $row['upsID'], $row['year']);
                echo "<tr><td>" . $row['firstName'] . "</td><td>" . $row['lastName'] . "</td><td>" . $row['type'] . "</td><td>" . $row['rank'] . "</td><td>" . $row['baseSalary'] . "</td><td>" . $totalSalary . "</td></tr>";
                $totalSalaries += $totalSalary;
            }
            echo "</table>";
            echo "<h4> Total Salary: $totalSalaries </h4>";
          }
          $newYear = $year + 1;

          unprojectEmployee($db, $newYear);
          //disconnect from db
          $db = null;
        }
      } catch (PDOException $e) {
        die('Exception : ' . $e->getMessage());
      }
      ?>
    </div>

  </div>


  <?php
  function projectEmployee($db, $year, $upsID)
  {
    try {
      //open connection to the airport database file
      $newyear = $year + 1;

      $query_str9 = $db->prepare("select * from EmployeePositionInformationByYear where year=:year and upsID=:upsID");
      $query_str9->bindParam(':year', $year);
      $query_str9->bindParam(':upsID', $upsID);

      //return all passengers, and store the result set
      if ($query_str9->execute()) {
        $result_set = $db->query("select * from EmployeePositionInformationByYear where year=$year and upsID=$upsID");
        $row = $result_set->fetch();

        if ($row['includeNext'] == 'yes' || $row['includeNext'] == 'tenative') {

          $positionNumber = $row['positionNumber'];
          $includeNext = $row['includeNext'];
          $step = -1;
          $rank = 'None';
          $stepYear = 0;
          if ($row['rank'] == 'Inst') {
            if ($row['step'] < 5) {
              $step = $row['step'] + 1;
              $rank = $row['rank'];
            } else {
              $step = 1;
              $rank = 'Asst';
            }
          } else if ($row['rank'] == 'Asst') {
            if ($row['step'] < 5) {
              $step = $row['step'] + 1;
              $rank = $row['rank'];
            } else {
              $step = 1;
              $rank = 'Assc';
            }
          } else if ($row['rank'] == 'Assc') {
            if ($row['step'] < 5) {
              $step = $row['step'] + 1;
              $rank = $row['rank'];
            } else {
              $step = 1;
              $rank = 'Full';
              $stepYear = 1;
            }
          } else if ($row['rank'] == 'Full') {
            if ($row['stepYear'] < 5) {
              $stepYear = $row['stepYear'] + 1;
              $step = $row['step'];
              $rank = $row['rank'];
            } else {
              $stepYear = 1;
              $step = $row['step'] + 1;
              $rank = $row['rank'];
            }
          } else if ($row['rank'] == 'CLAssc') {
            if ($row['step'] < 5) {
              $step = $row['step'] + 1;
              $rank = $row['rank'];
            } else {
              $step = 1;
              $rank = 'Full';
            }
          } else if ($row['rank'] == 'CLAsst') {
            if ($row['step'] < 5) {
              $step = $row['step'] + 1;
              $rank = $row['rank'];
            } else {
              $step = 1;
              $rank = 'CLAssc';
            }
          }


          $query_str = $db->prepare("INSERT INTO EmployeePositionInformationByYear VALUES (:year,:upsID,:positionNumber,:includeNext,:rank, :step,:stepYear)");
          $query_str->bindParam(':year', $newyear);
          $query_str->bindParam(':upsID', $upsID);
          $query_str->bindParam(':positionNumber', $positionNumber);
          $query_str->bindParam(':includeNext', $includeNext);
          $query_str->bindParam(':rank', $rank);
          $query_str->bindParam(':step', $step);
          $query_str->bindParam(':stepYear', $stepYear);

          $query_str->execute();
        }
      }
    } catch (PDOException $e) {
      die('Exception : ' . $e->getMessage());
    }
  }

  function unprojectEmployee($db, $year)
  {
    try {
      $query_str = $db->prepare("Delete from EmployeePositionInformationByYear where year=$year");
      $query_str->execute();
    } catch (PDOException $e) {
      die('Exception : ' . $e->getMessage());
    }
  }
  ?>
</body>

</html>