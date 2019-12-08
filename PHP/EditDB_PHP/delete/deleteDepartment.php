<!DOCTYPE html>
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
  <div class="navbar">
    <a href="./../../../index.html">Home</a>
    <a href="./../../showCurrent.php">Current</a>
    <a href="./../../past.php">Past</a>
    <a href="./../../projected.php">Projected</a>
    <a class="active" href="./../../showDepartments.php"> Departments</a>
    <a href="./../../showEmployees.php"> Employees</a>
    <a href="./../../showAdjustments.php"> Adjustments</a>
    <a href="./../../showSalaryScale.php"> Salary Scale</a>
    <a href="./../../showAdjEmp.php"> EmployeeAdjustments</a>
    <a href="./../../showEmpInfoYear.php">EmployeeInformationByYear</a>
    <a href="./../../../HTML/DBAccess.html">SQL Editor</a>
  </div>

  <div id="container">

    <div id="left" class="sticky">
      <p>
        <h2>Departments</h2>
        This table holds data about departments.
        <h3>Column Value Descriptions:</h3>
        <h4>Department ID:</h4>
        - The number that corresponds with a department.
        <br>
        - Primary Key
        <h4>Department Name:</h4>
        - The name of a department.
      </p>
    </div>

    <div id="right" class="sticky">
      <p>
        <h3>Action Descriptions:</h3>
        <h4>Delete:</h4>
        The delete button will allow you to delete the data for the row that was selected in the table.
        <form action="./../../showDepartments.php">
          <button type="submit">Return to View</button>
        </form>
    </div>

    <div id="center">
      <div class="sqlBorder">
        <fieldset>
          <article>
            <legend>
              <h3>Deleted Department:</h3>
            </legend>
            Dept ID:
            <?php echo $_POST["deptID"]; ?><br>
            Dept Name:
            <?php echo $_POST["deptName"]; ?><br>
          </article>
          <?php
          //path to the SQLite database file
          $db_file = './../../../DB/bigTuba.db';

          try {
            //open connection to the airport database file
            $db = new PDO('sqlite:' . $db_file);
            $db->exec('PRAGMA foreign_keys = ON;');
            //set errormode to use exceptions
            $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $query_str = $db->prepare("DELETE from Department where deptID = :deptID");
            $query_str->bindParam(':deptID', $_POST["deptID"]);
            if ($query_str->execute()) {
              echo "Success!<br>";
            }

            echo "</fieldset>";
          } catch (PDOException $e) {
            $message = $e->getMessage();
            if (strpos($message, "UNIQUE")) {
              echo "
            <script>
            alert('Unique constraint failed!');
            window.location = './../../showDepartments.php';
            </script>
            ";
            } elseif (strpos($message, "CHECK")) {
              echo "
            <script>
            window.location = './../../showDepartments.php';
            alert('Check constraint failed!');
            </script>
            ";
            } elseif (strpos($message, "FOREIGN")) {
              echo "
            <script>
            window.location = './../../showDepartments.php';
            alert('Foreign key constraint failed!');
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