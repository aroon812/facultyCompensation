<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <title>University of Puget Sound Payroll</title>
  <meta name="description" content="">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <link rel="manifest" href="site.webmanifest">
  <link rel="apple-touch-icon" href="icon.png">
  <link rel="stylesheet" href="../../../../CSS/main.css">

  <meta name="theme-color" content="#fafafa">
</head>

<body>
  <div class="navbar">
    <a href="./../../../../index.html">Home</a>
    <a href="./../../../showCurrent.php">Current</a>
    <a href="./../../../past.php">Past</a>
    <a href="./../../../projected.php">Projected</a>
    <a href="./../../../showDepartments.php"> Departments</a>
    <a class="active" href="./../../../showEmployees.php"> Employees</a>
    <a href="./../../../showAdjustments.php"> Adjustments</a>
    <a href="./../../../showSalaryScale.php"> Salary Scale</a>
    <a href="./../../../showAdjEmp.php"> Employee Adjustments</a>
    <a href="./../../../showEmpInfoYear.php">Employee Information By Year</a>
    <a href="./../../../../HTML/DBAccess.html">SQL Editor</a>
  </div>
  <div id="container">

    <div id="left" class="sticky">
      <p>
        <h2>Employees</h2>
        This table holds data about faculty and employees.
        <h3>Column Value Descriptions:</h3>
        <h4>UPS ID:</h4>
        - The number that corresponds with a Puget Sound faculty member.
        <br>
        - Primary Key
        <h4>Last Name:</h4>
        - The last name of a faculty member.
        <h4>First Name:</h4>
        - The first name of a faculty member.
        <h4>Type:</h4>
        - The employment track of a faculty member.
        <h4>Department:</h4>
        - The department ID of the department in which the faculty member works.
        <br>
        - Foreign Key referencing Department
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
        <form action="./../../../showEmployees.php">
          <br>
          <button type="submit">Return to View</button>
        </form>
    </div>

    <div id="center">
      <div class="sqlBorder">
        <fieldset>
          <legend>
            <h3>Update Employee:</h3>
          </legend>
          UPS ID:
          <?php echo $_POST["upsID"]; ?><br>
          Last Name:
          <?php echo $_POST["lastName"]; ?><br>
          First Name:
          <?php echo $_POST["firstName"]; ?> <br>
          Type:
          <?php echo $_POST["type"]; ?> <br>
          Department:
          <?php echo $_POST["deptID"]; ?> <br>
          <?php
          try {
            //path to the SQLite database file
            $db_file = './../../../../DB/bigTuba.db';
            //open connection to the database
            $db = new PDO('sqlite:' . $db_file);
            $db->exec('PRAGMA foreign_keys = ON;');
            //set errormode to use exceptions
            $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $query_str = $db->prepare("UPDATE Employee SET upsID = :upsID, lastName = :lastName, firstName = :firstName, type = :type, deptID = :deptID where upsID = :upsID");
            $query_str->bindParam(':upsID', $_POST["upsID"]);
            $query_str->bindParam(':lastName', $_POST["lastName"]);
            $query_str->bindParam(':firstName', $_POST["firstName"]);
            $query_str->bindParam(':type', $_POST["type"]);
            $query_str->bindParam(':deptID', $_POST["deptID"]);
            if ($query_str->execute()) {
              echo "<h4>Success!</h4><br>";
            }
            echo "</fieldset>";
          } catch (PDOException $e) {
            $message = $e->getMessage();
            if (strpos($message, "UNIQUE")) {
              echo "
            <script>
            alert('Unique constraint failed!');
            window.location = './../../../showEmployees.php';
            </script>
            ";
            } elseif (strpos($message, "CHECK")) {
              echo "
            <script>
            alert('Check constraint failed!');
            window.location = './../../../showEmployees.php';
            </script>
            ";
            } elseif (strpos($message, "FOREIGN")) {
              echo "
            <script>
            alert('Foreign key constraint failed!');
            window.location = './../../../showEmployees.php';
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