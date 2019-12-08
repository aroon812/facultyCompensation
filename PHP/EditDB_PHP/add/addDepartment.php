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
    <a href="./../../showAdjEmp.php"> EmployeeAdjustments</a>
    <a href="./../../showEmpInfoYear.php">EmployeeInformationByYear</a>
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
          <h4>Add:</h4>
          The add button will open a form to add a new row of data to the table.
          <br>
          - Department ID must be unique.
    <form action="./../../showDepartments.php">
            <br>
            <button type="submit">Return to View</button>
        </form>
  </p>
</div>


<div id="center">
<div class="sqlBorder"> 
  <article>
  <fieldset>
      <legend><h3>New Department Info:</h3></legend>
      Dept ID:
      <?php echo $_POST["deptID"]; ?><br>
      Dept Name:
      <?php echo $_POST["deptName"]; ?><br>
			<?php
                //path to the SQLite database file
                $db_file = '../../../DB/bigTuba.db';
                
                try {
                    //open connection to the airport database file
                    $db = new PDO('sqlite:' . $db_file);
                    $db->exec( 'PRAGMA foreign_keys = ON;' );
                    //set errormode to use exceptions
                    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                    
                    $query_str = $db->prepare("INSERT INTO department VALUES (:deptID, :deptName)");
                    $query_str->bindParam(':deptID', $_POST["deptID"]);
                    $query_str->bindParam(':deptName', $_POST["deptName"]);
                    if ($query_str->execute()){
                        echo "<h4>Success!</h4><br>";
                    }
                    echo "</fieldset>";
                //disconnect from db
                $db = null;
                } catch(PDOException $e) {
                  $message = $e->getMessage();
                  if (strpos($message, "UNIQUE")){
                      echo "
                        <script>
                        alert('Unique constraint failed!');
                        window.location = './../../showDepartments.php';
                        </script>
                        ";
                  } 
                  elseif (strpos($message, "CHECK")){
                    echo "
                      <script>
                      window.location = './../../showDepartments.php';
                      alert('Check constraint failed!');
                      </script>
                      ";
                  } 
                  elseif (strpos($message, "FOREIGN")){
                    echo "
                      <script>
                      window.location = './../../showDepartments.php';
                      alert('Foreign key constraint failed!');
                      </script>
                      ";
                  }                     
                  die();      
                }
            ?>
</article>
</div>
</div>

</body>
</html>