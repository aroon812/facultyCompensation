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
    <a href="../../../index.html">Home</a>
    <a href="../../current.html">Current</a>
    <a href="../../past.html">Past</a>
    <a href="../../projected.html">Projected</a>
    <a href="../../departments.html"> Departments</a>
    <a href="../../employees.html"> Employees</a>
    <a href="../../adjustments.html"> Adjustments</a>
    <a href="../../salaryScale.html"> Salary Scale</a>
    <a href="../../adjEmp.html"> EmployeeAdjustments</a>
    <a href="../../empInfoYear.html">EmployeeInformationByYear</a>
    <div class="dropdown">
      <button class="dropbtn">Edit Data 
        <i class="fa fa-caret-down"></i>
      </button>
      <div class="dropdown-content">
        <a href="../../add.html">add</a>
        <a href="../../update.html">update</a>
        <a href="../../delete.html">delete</a>
      </div>
    </div> 
  </div>

  <h1 class="pagetitle">Update Salary Adjustment</h1>

  <?php session_start(); ?>
	<form action="./MSG/updateAdjustmentsMsg.php" method="post">
		<fieldset>
			<legend>Update Adjustment</legend>
				
			Please fill out the following information to update the database.<br><br>
			<?php				
                $adjID = $_POST['adjID'];
                $adjVal = $_POST['adjVal'];
                $operation = $_POST['operation'];
                $description = $_POST['description'];

                echo 
                "
                Adj ID:<br> 
                <input type = 'text' name = 'adjID' value='$adjID' required autofocus readonly><br>
                
                Adj Value:<br>
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


</body>
</html>