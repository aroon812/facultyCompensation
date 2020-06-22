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
    <a class="active" href="./../../showSalaryScale.php"> Salary Scale</a>
    <a href="./../../showAdjEmp.php"> Employee Adjustments</a>
    <a href="./../../showEmpInfoYear.php">Employee Information By Year</a>
    <a href="./../../../HTML/DBAccess.html">SQL Editor</a>
  </div>
  <div id="container">

    <div id="left" class="sticky">
      <p>
        <h2>Salary Scale</h2>
        This table holds data about the unadjusted salary for certain levels of employment.
        <h3>Column Value Descriptions:</h3>
        <h4>Rank:</h4>
        - The level of employment for an employee.
        <br>
        - Primary Key
        <h4>Step:</h4>
        - The progress of an employee in their rank.
        <br>
        - Primary Key
        <h4>Base Salary:</h4>
        - The starting compensation for an employee at a certain rank and step without adjustments.
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
        <form action="./MSG/updateSalaryScaleMsg.php" method="post">
          <fieldset>
            <legend>Update Salary Scale</legend>
            Please fill out the following information to update the database.<br><br>
            <?php
            $rank = $_POST['rank'];
            $step = $_POST['step'];
            $baseSalary = $_POST['baseSalary'];

            echo
              "
                Rank:<br> 
                <input type = 'text' name = 'rank' value='$rank' required autofocus readonly><br>
                
                Step:<br>
                <input type = 'text' name = 'step' value='$step' required autofocus readonly><br>
                
                Base Salary:<br>
                <input type = 'text' name = 'baseSalary' value='$baseSalary' required><br>

                <input type = 'submit' name = 'submit' value='Update Salary Scale'>
                ";
            ?>
          </fieldset>
        </form>
      </div>
    </div>
  </div>
</body>

</html>