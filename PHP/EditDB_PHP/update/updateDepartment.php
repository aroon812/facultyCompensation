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
    <a class= "active" href="./../../showDepartments.php"> Departments</a>
    <a href="./../../showEmployees.php"> Employees</a>
    <a href="./../../showAdjustments.php"> Adjustments</a>
    <a href="./../../showSalaryScale.php"> Salary Scale</a>
    <a href="./../../showAdjEmp.php"> Employee Adjustments</a>
    <a href="./../../showEmpInfoYear.php">Employee Information By Year</a>
    <a href="./../../../HTML/DBAccess.html">SQL Editor</a>
  </div>
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
    <h4>Update:</h4>
    The update button will allow you to modify the data for the row that was selected in the table.
    <br>
    - Primary keys cannot be modified
    <br>
    - Foriegn keys should be modified with caution.
  </p>
</div>

<div id="center">
<div class="sqlBorder">
        <?php session_start(); ?>
          <form action="./MSG/updateDepartmentMsg.php" method="post">
		          <fieldset>
        
			            <legend>Update Department</legend>
				
			            Please fill out the following information to update the database.<br><br>
                <?php				
                  $deptID = $_POST['deptID'];
                  $deptName = $_POST['deptName'];
                  echo 
                  "
                  Dept ID:<br> 
                  <input type = 'text' name = 'deptID' value='$deptID' required autofocus readonly><br>
                  
                  Department:<br>
                  <input type = 'text' name = 'deptName' value='$deptName' required> <br>

                  <input type = 'submit' name = 'submit' value='Update Department'>
                  ";
			          ?>	
		          </fieldset>
          </form>
      </div>
  </div>

</div>

</body>
</html>