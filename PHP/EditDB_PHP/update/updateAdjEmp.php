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
    <a class="active" href="./../../showAdjEmp.php"> Employee Adjustments</a>
    <a href="./../../showEmpInfoYear.php">Employee Information By Year</a>
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
        <h4>Update:</h4>
        The update button will allow you to modify the data for the row that was selected in the table.
        <br>
        - Primary keys cannot be modified
        <br>
        - Foriegn keys should be modified with caution.
    </div>

    <div id="center">
      <div class="sqlBorder">
        <?php session_start(); ?>
        <form action="./MSG/updateAdjEmpMsg.php" method="post">
          <fieldset>
            <legend>Add Employee Adjustment</legend>

            Please fill out the following information to update the database.<br><br>
            <?php
            $year = $_POST['year'];
            $upsID = $_POST['upsID'];
            $adjID = $_POST['adjID'];
            $firstName = $_POST['firstName'];
            $lastName = $_POST['lastName'];

            echo
              "
                Year:<br> 
                <input type = 'text' name = 'year' value='$year' required  readonly><br>
                
                UPS ID:<br>
                <input type = 'text' name = 'upsID' value='$upsID' required  readonly><br>
                
                Adj ID:<br>
                <input type = 'text' name = 'adjID' value='$adjID' required autofocus><br>

                First Name:<br>
                <input type = 'text' name = 'firstName' value='$firstName' required  readonly><br>
                
                Last Name:<br>
                <input type = 'text' name = 'lastName' value='$lastName' required readonly><br>

                <input type = 'submit' name = 'submit' value='Update Employee Adjustment'>
                ";
            ?>
          </fieldset>
        </form>
      </div>
    </div>
  </div>
</body>

</html>