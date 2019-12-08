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
    <a href="./../../showAdjEmp.php"> EmployeeAdjustments</a>
    <a class= "active" href="./../../showEmpInfoYear.php">EmployeeInformationByYear</a>
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
</div>

<div id="center">
  <div class="sqlBorder">
    <?php session_start(); ?>
    <form action="./MSG/updateEmpInfoYearMsg.php" method="post">
		<fieldset>
			<legend>Update Employee Information by Year</legend>
				
			Please fill out the following information to update the database.<br><br>
			<?php				
                $year = $_POST['year'];
                $upsID = $_POST['upsID'];
                $positionNumber = $_POST['positionNumber'];
                $includeNext = $_POST['includeNext'];
                $rank = $_POST['rank'];
                $step = $_POST['step'];
                $stepYear = $_POST['stepYear'];

                echo 
                "
                Year:<br> 
                <input type = 'text' name = 'year' value='$year' required autofocus readonly><br>
                
                upsID:<br>
                <input type = 'text' name = 'upsID' value='$upsID' readonly><br>
                
                Position Number:<br>
                <input type = 'text' name = 'positionNumber' value='$positionNumber' required><br>
                
                Include Employee Next Year:<br>
                <input type = 'text' name = 'includeNext' value='$includeNext' required><br>
                
                Rank:<br>
                <input type = 'text' name = 'rank' value='$rank'><br>
                
                Step:<br>
                <input type = 'text' name = 'step' value='$step' required><br>
                
                Step Year:<br>
                <input type = 'text' name = 'stepYear' value='$stepYear' required><br>

                <input type = 'submit' name = 'submit' value='Update Employee Information by Year'>
                ";
			?>			
		</fieldset>
	</form>
  </div>
</div>
</div>
</body>
</html>