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
  <link rel="stylesheet" href="../CSS/main.css">

  <meta name="theme-color" content="#fafafa">
</head>

<body>
  <!--[if IE]>
    <p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="https://browsehappy.com/">upgrade your browser</a> to improve your experience and security.</p>
  <![endif]-->
  <div class="navbar">
    <a href="../index.html">Home</a>
    <a href="./showCurrent.php">Current</a>
    <a href="../HTML/past.html">Past</a>
    <a href="../HTML/projected.html">Projected</a>
    <a href="./showDepartments.php"> Departments</a>
    <a href="./showEmployees.php"> Employees</a>
    <a class= "active" href="./showAdjustments.php"> Adjustments</a>
    <a href="./showSalaryScale.php"> Salary Scale</a>
    <a href="./showAdjEmp.php"> EmployeeAdjustments</a>
    <a href="./showEmpInfoYear.php">EmployeeInformationByYear</a>
    <a href="../HTML/DBAccess.html">SQL Editor</a>
  </div>

  <!-- Add your site or application content here -->
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
    <h4>Delete:</h4>
    The delete button will remove the data for that row from the table.
    <h4>Add:</h4>
    The add button will open a form to add a new row of data to the table.
  </p>

  <form action="../HTML/EditDB_HTML/add/addAdjustments.html">
    <button type="submit">Add Adjustment</button>
  </form>
</div>

<div id="center">
  <h2>Adjustments Table</h2>
  <?php
      //path to the SQLite database file
      $db_file = '../DB/bigTuba.db';
  
      try {
          //open connection to the airport database file
          $db = new PDO('sqlite:' . $db_file);
         
          //set errormode to use exceptions
          $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
          //return all passengers, and store the result set
          $query_str = $db->prepare("select * from SalaryAdjustments");
      
          if ($query_str->execute()){
              $i = 0;
              $result_set = $db->query("select * from SalaryAdjustments");
              echo "<table align='center'>";
              echo "<tr><td>Adjustment ID</td><td>Adjustment Value</td><td>Operation</td><td>Description</td></tr>";
              while($row = $result_set->fetch()) {
                echo "<tr><td>" . $row['adjID'] . "</td><td>" . $row['adjVal'] . "</td><td>" . $row['operation'] . "</td><td>" . $row['description'] . "</td><td>
                    </td><td> <form action='./EditDB_PHP/update/updateAdjustments.php' method='post'>
                      <input type='hidden' name='adjID' value= $row[0]>
                      <input type='hidden' name='adjVal' value= $row[1]>
                      <input type='hidden' name='operation' value= $row[2]>
                      <input type='hidden' name='description' value= $row[3]>
                      <input type='submit' value='Update'>
                    </form>
                    </td><td>
                      <form action='./EditDB_PHP/delete/deleteAdjustments.php' method='post'>
                      <input type='hidden' name='adjID' value= $row[0]>
                      <input type='hidden' name='adjVal' value= $row[1]>
                      <input type='hidden' name='operation' value= $row[2]>
                      <input type='hidden' name='description' value= $row[3]>
                      <input type='submit' value='Delete'>
                    </form>
                    </td></tr>";
              }
              echo "</table>";
          }
          //disconnect from db
          $db = null;
      } catch(PDOException $e) {
          die('Exception : '.$e->getMessage());
      }
  ?>
</div>

</div>
</body>
</html>