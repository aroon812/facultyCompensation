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
    <a class= "active" href="./../../showSalaryScale.php"> Salary Scale</a>
    <a href="./../../showAdjEmp.php"> EmployeeAdjustments</a>
    <a href="./../../showEmpInfoYear.php">EmployeeInformationByYear</a>
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
            <h4>Add:</h4>
            The add button will allow you to add a salary scale to the table.
            <br>
            - Rank and scale must be a unique combination
    <form action="./../../showSalaryScale.php">
        <br>
        <button type="submit">Return to View</button>
    </form>
</div>

<div id="center">
  <div class="sqlBorder">
    <fieldset>
    <legend><h3>New Salary Scale Info:</h3></legend>
        Rank:
        <?php echo $_POST["rank"]; ?><br>
        Step:
        <?php echo $_POST["step"]; ?><br>
        Base Salary
        <?php echo $_POST["baseSalary"]; ?> <br>

			<?php
                //path to the SQLite database file
                $db_file = '../../../DB/bigTuba.db';
                
                try {
                    //open connection to the airport database file
                    $db = new PDO('sqlite:' . $db_file);
                    $db->exec( 'PRAGMA foreign_keys = ON;' );
                    //set errormode to use exceptions
                    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                    
                    $query_str = $db->prepare("INSERT INTO SalaryScale VALUES (:rank, :step, :baseSalary)");
                    $query_str->bindParam(':rank', $_POST["rank"]);
                    $query_str->bindParam(':step', $_POST["step"]);
                    $query_str->bindParam(':baseSalary', $_POST["baseSalary"]);
                    if ($query_str->execute()){
                        echo "<h4>Success!</h4><br>";
                    }
                    echo "</fieldset>";
                    $db = null;
                } catch(PDOException $e) {
                  $message = $e->getMessage();
                  if (strpos($message, "UNIQUE")){
                      echo "
                        <script>
                        alert('Unique constraint failed!');
                        window.location = './../../showSalaryScale.php';
                        </script>
                        ";
                  } 
                  elseif (strpos($message, "CHECK")){
                    echo "
                      <script>
                      window.location = './../../showSalaryScale.php';
                      alert('Check constraint failed!');
                      </script>
                      ";
                  } 
                  elseif (strpos($message, "FOREIGN")){
                    echo "
                      <script>
                      window.location = './../../showSalaryScale.php';
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