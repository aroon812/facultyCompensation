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

    <article>
        <h3>Update Adjustment:</h3>
        Adj ID:
        <?php echo $_POST["adjID"]; ?><br>
        Adj Value:
        <?php echo $_POST["adjVal"]; ?><br>
        Operation:
        <?php echo $_POST["operation"]; ?> <br>
        Description:
        <?php echo $_POST["description"]; ?> <br>
    </article>
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
                    echo "Success!<br>";
            }
        }
            catch(PDOException $e) {
                die('Exception : '.$e->getMessage());
            }
        ?>
        <form action="./../../../showAdjustments.php">
            <button type="submit">Return to View</button>
        </form>
</body>
</html>

