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
  <link rel="stylesheet" href="./../CSS/main.css">

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
    <a href="../..empInfoYear.html">EmployeeInformationByYear</a>
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

  <h1 class="pagetitle">Past Budgets</h1>


<?php
    $db_file = '../DB/bigTuba.db';
    $db = new PDO('sqlite:' . $db_file);

    //set errormode to use exceptions
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $query_str = $db->prepare("select max(year) as year from EmployeePositionInformationByYear");
        
        if ($query_str->execute()){
            $i = 0;
            $resultYear = $db->query("select max(year) as year from EmployeePositionInformationByYear");
            foreach ($resultYear as $row)
            {
              $result= $row['year'];
            } 
           
            $actualMin =$result-1;
        }
        
        
?>

<form action="./showPast.php" method="post">
  <fieldset>
    <legend>See Past Budgets</legend>
    
    <br><br>
    
    Enter a Year:<br> 
    <?php
        echo "<input type = 'number' min='1950' max='$actualMin' name = 'year' placeholder='year' required autofocus><br>";
    
     ?>
    <input type = "submit" name = "submit" value="Show Past Report">
  </fieldset>
</form>

</body>
</html>