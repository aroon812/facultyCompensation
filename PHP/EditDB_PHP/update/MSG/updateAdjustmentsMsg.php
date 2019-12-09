<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>University of Puget Sound Payroll</title>
  <meta name="description" content="">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <link rel="manifest" href="site.webmanifest">
  <link rel="apple-touch-icon" href="icon.png">
  <!-- Place favicon.ico in the root directory -->
  <link rel="stylesheet" href="../../../../CSS/main.css">

  <meta name="theme-color" content="#fafafa">
</head>

<body>
<div class="navbar">
    <a href="./../../../../index.html">Home</a>
    <a href="./../../../showCurrent.php">Current</a>
    <a href="./../../../past.php">Past</a>
    <a href="./../../../projected.php">Projected</a>
    <a href="./../../../showDepartments.php"> Departments</a>
    <a href="./../../../showEmployees.php"> Employees</a>
    <a class= "active" href="./../../../showAdjustments.php"> Adjustments</a>
    <a href="./../../../showSalaryScale.php"> Salary Scale</a>
    <a href="./../../../showAdjEmp.php"> Employee Adjustments</a>
    <a href="./../../../showEmpInfoYear.php">Employee Information By Year</a>
    <a href="./../../../../HTML/DBAccess.html">SQL Editor</a>
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
    <form action="./../../../showAdjustments.php">
            <br>
            <button type="submit">Return to View</button>
        </form>
</div>

<div id="center">
  <div class="sqlBorder">
    <fieldset>
      <legend><h3>Update Adjustment:</h3></legend>
        Adjustment ID:
        <?php echo $_POST["adjID"]; ?><br>
        Adjustment Value:
        <?php echo $_POST["adjVal"]; ?><br>
        Operation:
        <?php echo $_POST["operation"]; ?> <br>
        Description:
        <?php echo $_POST["description"]; ?> <br>

        <?php
            try {
            //path to the SQLite database file
            $db_file = './../../../../DB/bigTuba.db';
            //open connection to the airport database file
            $db = new PDO('sqlite:' . $db_file);
            $db->exec( 'PRAGMA foreign_keys = ON;' );
            //set errormode to use exceptions
            $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $query_str = $db->prepare("UPDATE SalaryAdjustments SET adjID = :adjID, adjVal = :adjVal, operation = :operation, description = :description where adjID = :adjID");
            $query_str->bindParam(':adjID', $_POST["adjID"]);
            $query_str->bindParam(':adjVal', $_POST["adjVal"]);
            $query_str->bindParam(':operation', $_POST["operation"]);
            $query_str->bindParam(':description', $_POST["description"]);
            if ($query_str->execute()){
                    echo "<h4>Success!</h4><br>";
            }
            echo "</fieldset>";
        }
            catch(PDOException $e) {
                $message = $e->getMessage();
                  if (strpos($message, "UNIQUE")){
                      echo "
                        <script>
                        alert('Unique constraint failed!');
                        window.location = './../../../showAdjustments.php';
                        </script>
                        ";
                  } 
                  elseif (strpos($message, "CHECK")){
                    echo "
                      <script>
                      alert('Check constraint failed!');
                      window.location = './../../../showAdjustments.php';
                      </script>
                      ";
                  } 
                  elseif (strpos($message, "FOREIGN")){
                    echo "
                      <script>
                      alert('Foreign key constraint failed!');
                      window.location = './../../../showAdjustments.php';
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

