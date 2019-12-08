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
    <a class= "active" href="./../../showAdjEmp.php"> EmployeeAdjustments</a>
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
  </p>
</div>

<div id="right" class="sticky">
<p>
    <h3>Action Descriptions:</h3>
            <h4>Add:</h4>
            The add button will allow you to add an employee adjustment to the table.
          <br>
          - All fields must be unique
          <br>
        - UPS ID and year must exist as a combination in Employee Information by Year. 
          <br>
          - Adjustment ID must exist in Salary Adjustments.
    <form action="./../../showAdjEmp.php">
            <br>
            <button type="submit">Return to View</button>
    </form>
</div>

<div id="center">
  <div class="sqlBorder">
    <fieldset>
			<h3>New Employee Adjustment Info:</h3>
			Year:
			<?php echo $_POST["year"]; ?><br>
			UPS ID:
			<?php echo $_POST["upsID"]; ?><br>
			Adjustment ID:
      <?php echo $_POST["adjID"]; ?><br>
			<?php
                //path to the SQLite database file
                $db_file = '../../../DB/bigTuba.db';
                
                try {
                    //open connection to the airport database file
                    $db = new PDO('sqlite:' . $db_file);
                    $db->exec( 'PRAGMA foreign_keys = ON;' );
                    //set errormode to use exceptions
                    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                    
                    $query_str = $db->prepare("INSERT INTO EmployeeAdjustments VALUES (:year, :upsID, :adjID)");
                    $query_str->bindParam(':year', $_POST["year"]);
                    $query_str->bindParam(':upsID', $_POST["upsID"]);
                    $query_str->bindParam(':adjID', $_POST["adjID"]);
                    if ($query_str->execute()){
                        echo "<h4>Success!</h4><br>";
                    }
                    echo "</fieldset>";
                $db = null;
                }    
                catch(PDOException $e) {
                  $message = $e->getMessage();
                  if (strpos($message, "UNIQUE")){
                      echo "
                        <script>
                        alert('Unique constraint failed!');
                        window.location = './../../showAdjEmp.php';
                        </script>
                        ";
                  } 
                  elseif (strpos($message, "CHECK")){
                    echo "
                      <script>
                      window.location = './../../showAdjEmp.php';
                      alert('Check constraint failed!');
                      </script>
                      ";
                  } 
                  elseif (strpos($message, "FOREIGN")){
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