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
    <a href="./../../showDepartments.php"> Departments</a>
    <a href="./../../showEmployees.php"> Employees</a>
    <a href="./../../showAdjustments.php"> Adjustments</a>
    <a href="./../../showSalaryScale.php"> Salary Scale</a>
    <a class="active" href="./../../showAdjEmp.php"> EmployeeAdjustments</a>
    <a href="./../../showEmpInfoYear.php">EmployeeInformationByYear</a>
    <a href="./../../../HTML/DBAccess.html">SQL Editor</a>
  </div>
  <div id="container">

    <div id="left" class="sticky">
      <p>
        <h2>Employee Adjustments</h2>
        This table holds data about the adjustments for faculty and employees compensation for a given year.
        <h3>Column Value Descriptions:</h3>
        <h4>Year:</h4>
        - The year in which the adjustments are active.
        <br>
        - Primary Key
        <br>
        - Foreign Key referencing Employee Position Information by Year
        <h4>UPS ID:</h4>
        - The number that corresponds with a Puget Sound faculty member.
        <br>
        - Primary Key
        <br>
        - Foreign Key referencing Employee Position Information by Year
        <h4>Adjustment ID:</h4>
        - The number that corresponds with an adjustment operation.
        <br>
        - Primary Key
        <br>
        - Foreign Key referencing Adjustments
        <h4>First Name:</h4>
        - The first name of a faculty member.
        <h4>Last Name:</h4>
        - The last name of a faculty member.
      </p>
    </div>

    <div id="right" class="sticky">
      <p>
        <h3>Action Descriptions:</h3>
        <h4>Delete:</h4>
        The delete button will allow you to delete the data for the row that was selected in the table.
        <form action="./../../showAdjEmp.php">
          <br>
          <button type="submit">Return to View</button>
        </form>
    </div>

    <div id="center">
      <div class="sqlBorder">
        <fieldset>
          <article>
            <legend>
              <h3>Deleted Employee Adjustment:</h3>
            </legend>
            Year:
            <?php echo $_POST["year"]; ?><br>
            UPS ID:
            <?php echo $_POST["upsID"]; ?><br>
            Adj ID:
            <?php echo $_POST["adjID"]; ?> <br>
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

            $query_str = $db->prepare("DELETE from EmployeeAdjustments where year = :year and upsID= :upsID and adjID= :adjID");
            $query_str->bindParam(':year', $_POST["year"]);
            $query_str->bindParam(':upsID', $_POST["upsID"]);
            $query_str->bindParam(':adjID', $_POST["adjID"]);
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
            window.location = './../../showAdjEmp.php';
            </script>
            ";
            } elseif (strpos($message, "CHECK")) {
              echo "
            <script>
            window.location = './../../showAdjEmp.php';
            alert('Check constraint failed!');
            </script>
            ";
            } elseif (strpos($message, "FOREIGN")) {
              echo "
            <script>
            window.location = './../../showAdjEmp.php';
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