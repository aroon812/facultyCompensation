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
    <a class= "active" href="./../../showEmployees.php"> Employees</a>
    <a href="./../../showAdjustments.php"> Adjustments</a>
    <a href="./../../showSalaryScale.php"> Salary Scale</a>
    <a href="./../../showAdjEmp.php"> EmployeeAdjustments</a>
    <a href="./../../showEmpInfoYear.php">EmployeeInformationByYear</a>
    <a href="./../../../HTML/DBAccess.html">SQL Editor</a>
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
    </div>

    <div id="center">
      <div class="sqlBorder">
        <?php session_start(); ?>
            <form action="./MSG/updateEmployeesMsg.php" method="post">
		          <fieldset>
        
			            <legend>Update Employee</legend>
				
			              Please fill out the following information to update the database.<br><br>
			              <?php				
                      $upsID = $_POST['upsID'];
                      $lastName = $_POST['lastName'];
                      $firstName = $_POST['firstName'];
                      $type = $_POST['type'];
                      $deptID = $_POST['deptID'];

                      echo 
                      "
                      UPS ID:<br> 
                      <input type = 'text' name = 'upsID' value='$upsID' required autofocus readonly><br>
                      
                      Last Name:<br>
                      <input type = 'text' name = 'lastName' value='$lastName' required><br>
                      
                      First Name:<br>
                      <input type = 'text' name = 'firstName' value='$firstName' required><br>
                      
                      Type:<br>
                      <input type = 'text' name = 'type' value='$type' required><br>
                      
                      Department:<br>
                      <input type = 'text' name = 'deptID' value='$deptID' required> <br>

                      <input type = 'submit' name = 'submit' value='Update Employee'>
                      ";
                    ?>			
		          </fieldset>
          </form>
      </div>
    </div>
  </div>
</body>
</html>