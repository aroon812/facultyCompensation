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
    <a href="./projected.php">Projected</a>
    <a href="./showDepartments.php"> Departments</a>
    <a href="./showEmployees.php"> Employees</a>
    <a href="./showAdjustments.php"> Adjustments</a>
    <a href="./showSalaryScale.php"> Salary Scale</a>
    <a href="./showAdjEmp.php"> Employee Adjustments</a>
    <a class= "active" href="./showEmpInfoYear.php">Employee Information By Year</a>
    <a href="../HTML/DBAccess.html">SQL Editor</a>
  </div>

  <!-- Add your site or application content here -->
  <div id="container">

    <div id="left" class="sticky">
      <p>
        <h2>Employee Position Information by Year</h2>
        This table holds data about faculty and employees by year.
        <h3>Column Value Descriptions:</h3>
        <h4>Year:</h4>
        - The year in which the row data is relevant. 
        <br>
        - Primary Key
        <h4>UPS ID:</h4>
        - The number that corresponds with a Puget Sound faculty member.
        <br>
        - Primary Key
        <br>
        - Foreign Key referencing Employee
        <h4>Position Number:</h4>
        - The number that corresponds with a Puget Sound faculty member's job.
        <h4>Include Next Year:</h4>
        - The predicted employment status of an employee for the next year.
        <h4>Rank:</h4>
        - The level of employment for an employee.
        <br>
        - Foreign Key referencing Salary Adjustments
        <h4>Step:</h4>
        - The progress of an employee in their rank.
        - Foreign Key referencing Salary Adjustments
        <br>
        <h4>Step Year:</h4>
        - The progress of an employee in their step for full proffessors.
        <h4>Last Name:</h4>
        - The last name of a faculty member.
        <h4>First Name:</h4>
        - The first name of a faculty member.
      </p>
    </div>

    <div id="right" class="sticky">
      <p>
        <h3>Action Descriptions:</h3>
        <h4>Update:</h4>
        The update button will allow you to modify the data for the row that was selected in the table.
        <br>
        - Primary keys cannot be modified
        <br>
        - Foriegn keys should be modified with caution.
        <h4>Delete:</h4>
        The delete button will remove the data for that row from the table.
        <h4>Add:</h4>
        The add button will open a form to add a new row of data to the table.
      </p>

      <form action="../HTML/EditDB_HTML/add/addEmployeeInfo.html">
        <button type="submit">Add Employee Position Information by Year</button>
      </form>
    </div>

    <div id="center">
      <h2>Employee Position Information by Year Table</h2>
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
              $query_str = $db->prepare("select year, upsID, positionNumber, includeNext, Rank, Step, stepYear, firstName, lastName from EmployeePositionInformationByYear natural join Employee order by Year desc");

              if ($query_str->execute()){
                  $i = 0;
                  $result_set = $db->query("select year, upsID, positionNumber, includeNext, rank, step, stepYear, firstName, lastName from EmployeePositionInformationByYear natural join Employee order by Year desc");
                  echo "<table align='center'>";
                  echo "<tr><td>Year</td><td>UPS ID</td><td>Position Number</td><td>Include Next Year</td><td>Rank</td><td>Step</td><td>Step Year</td><td>First Name</td><td>Last Name</td></tr>";
                  while($row = $result_set->fetch()) {
                    echo "<tr><td>" . $row['year'] . "</td><td>" . $row['upsID'] . "</td><td>" . $row['positionNumber'] . "</td><td>" . $row['includeNext'] . "</td><td>" . $row['rank'] . "</td><td>" . $row['step'] . "</td><td>" . $row['stepYear'] . "</td><td>" . $row['firstName'] . "</td><td>" . $row['lastName'] . "</td><td>
                        </td><td> <form action='./EditDB_PHP/update/updateEmpInfoYear.php' method='post'>
                          <input type='hidden' name='year' value= $row[0]>
                          <input type='hidden' name='upsID' value= $row[1]>
                          <input type='hidden' name='positionNumber' value= $row[2]>
                          <input type='hidden' name='includeNext' value= $row[3]>
                          <input type='hidden' name='rank' value= $row[4]>
                          <input type='hidden' name='step' value= $row[5]>
                          <input type='hidden' name='stepYear' value= $row[6]>
                          <input type='submit' value='Update'>
                        </form>
                        </td><td>
                          <form action='./EditDB_PHP/delete/deleteEmpInfoYear.php' method='post'>
                          <input type='hidden' name='year' value= $row[0]>
                          <input type='hidden' name='upsID' value= $row[1]>
                          <input type='hidden' name='positionNumber' value= $row[2]>
                          <input type='hidden' name='includeNext' value= $row[3]>
                          <input type='hidden' name='rank' value= $row[4]>
                          <input type='hidden' name='step' value= $row[5]>
                          <input type='hidden' name='stepYear' value= $row[6]>
                          <input type='submit' value='Delete'>
                        </form>
                        </td></tr>";
                  }
                  echo "</table>";
              } 
              //disconnect from db
              $db = null;
          } catch(PDOException $e) {
              die('Exception : '.$e->getMessage());
          }
      ?>
    </div>
  </div>
</body>
</html>