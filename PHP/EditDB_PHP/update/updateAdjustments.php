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
    <a class= "active" href="./../../showAdjustments.php"> Adjustments</a>
    <a href="./../../showSalaryScale.php"> Salary Scale</a>
    <a href="./../../showAdjEmp.php"> Employee Adjustments</a>
    <a href="./../../showEmpInfoYear.php">Employee Information By Year</a>
    <a href="./../../../HTML/DBAccess.html">SQL Editor</a>
  </div>
  <div id="container">

<div id="left" class="sticky">
  <p>
    <h2>Adjustments</h2>
    This table holds data about adjustment operations for faculty compensation.
    <h3>Column Value Descriptions:</h3>
    <h4>Adjustment ID:</h4>
    - The number that represents the adjustment for that row.
    <br>
    - Primary Key
    <h4>Adjustment Value:</h4>
    - The value to be applied to the adjustment operation.
    <h4>Operation:</h4>
    - The operation that the adjustment preforms when calculating total salary.
    <h4>Description:</h4>
    - The summary of the adjustment including what it is used for.
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
        <form action="./MSG/updateAdjustmentsMsg.php" method="post">
          <fieldset>
    
              <legend>Update Salary Adjustment</legend>
    
                Please fill out the following information to update the database.<br><br>
                <?php				
                $adjID = $_POST['adjID'];
                $adjVal = $_POST['adjVal'];
                $operation = $_POST['operation'];
                $description = $_POST['description'];

                echo 
                "
                Adjustment ID:<br> 
                <input type = 'text' name = 'adjID' value='$adjID' required autofocus readonly><br>
                
                Adjustment Value:<br>
                <input type = 'text' name = 'adjVal' value='$adjVal' required><br>
                
                Operation:<br>
                <input type = 'text' name = 'operation' value='$operation' required><br>
                
                Description:<br>
                <input type = 'text' name = 'description' value='$description' required><br>

                <input type = 'submit' name = 'submit' value='Update Salary Adjustment'>
                ";
			        ?>						
          </fieldset>
      </form>
  </div>
</div>
</div>

</body>
</html>