<!doctype html>
<html>

<head>
  <meta charset="utf-8">
  <title>University of Puget Sound Payroll</title>
  <meta name="description" content="">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <link rel="manifest" href="site.webmanifest">
  <link rel="apple-touch-icon" href="icon.png">
  <link rel="stylesheet" href="../../../CSS/main.css">

  <meta name="theme-color" content="#fafafa">
</head>

<body>
  <!--[if IE]>
    <p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="https://browsehappy.com/">upgrade your browser</a> to improve your experience and security.</p>
  <![endif]-->

  <div class="navbar">
    <a href="./../../../index.html">Home</a>
    <a href="./../../showCurrent.php">Current</a>
    <a href="./../../past.php">Past</a>
    <a href="./../../projected.php">Projected</a>
    <a href="./../../showDepartments.php"> Departments</a>
    <a href="./../../showEmployees.php"> Employees</a>
    <a href="./../../showAdjustments.php"> Adjustments</a>
    <a href="./../../showSalaryScale.php"> Salary Scale</a>
    <a href="./../../showAdjEmp.php"> Employee Adjustments</a>
    <a class="active" href="./../../showEmpInfoYear.php">Employee Information By Year</a>
    <a href="./../../../HTML/DBAccess.html">SQL Editor</a>
  </div>

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
        - The progress of an employee in their step for full professors.
      </p>
    </div>

    <div id="right" class="sticky">
      <p>
        <h3>Action Descriptions:</h3>
        <h4>Add:</h4>
        The add button will allow you add employee information for fiscal years to the table.
        <br>
        - Year and UPS ID must be a unique combination.
        <br>
        - UPS ID must exist in Employee.
        <br>
        - Rank and step must exist as a combination in Salary Scale.
        <form action="./../../showEmpInfoYear.php">
          <br>
          <button type="submit">Return to View</button>
        </form>
    </div>

    <div id="center">
      <div class="sqlBorder">
        <fieldset>
          <legend>
            <h3>New Employee Information for Year:</h3>
          </legend>
          Year:
          <?php echo $_POST["year"]; ?><br>
          UPS ID:
          <?php echo $_POST["upsID"]; ?><br>
          Position Number:
          <?php echo $_POST["positionNumber"]; ?><br>
          Include Employee Next Year:
          <?php echo $_POST["includeNext"]; ?> <br>
          Rank:
          <?php echo $_POST["rank"]; ?> <br>
          Step:
          <?php echo $_POST["step"]; ?> <br>
          Step Year:
          <?php echo $_POST["stepYear"]; ?> <br><br>
          <?php
          //path to the SQLite database file
          $db_file = '../../../DB/bigTuba.db';

          try {
            //open connection to the database
            $db = new PDO('sqlite:' . $db_file);
            $db->exec('PRAGMA foreign_keys = ON;');
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
            if ($query_str->execute()) {
              echo "<h4>Success!</h4><br>";
            }
            //disconnect from db
            $db = null;
            echo "</fieldset>";
          } catch (PDOException $e) {
            $message = $e->getMessage();
            if (strpos($message, "UNIQUE")) {
              echo "
                        <script>
                        alert('Unique constraint failed!');
                        window.location = './../../showEmpInfoYear.php';
                        </script>
                        ";
            } elseif (strpos($message, "CHECK")) {
              echo "
                      <script>    
                      alert('Check constraint failed!');
                      window.location = './../../showEmpInfoYear.php';
                      </script>
                      ";
            } elseif (strpos($message, "FOREIGN")) {
              echo "
                      <script>
                      alert('Foreign key constraint failed!');
                      window.location = './../../showEmpInfoYear.php'; 
                      </script>
                      ";
            }
            die();
          }
          ?>
      </div>
    </div>
  </div>
  </div>

</body>

</html>