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
    <a href="./past.php">Past</a>
    <a href="./projected.php">Projected</a>
    <a href="./showDepartments.php"> Departments</a>
    <a href="./showEmployees.php"> Employees</a>
    <a href="./showAdjustments.php"> Adjustments</a>
    <a class= "active" href="./showSalaryScale.php"> Salary Scale</a>
    <a href="./showAdjEmp.php"> Employee Adjustments</a>
    <a href="./showEmpInfoYear.php">Employee Information By Year</a>
    <a href="../HTML/DBAccess.html">SQL Editor</a>
  </div>

  <!-- Add your site or application content here -->
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

      <form action="../HTML/EditDB_HTML/add/addSalaryScale.html">
        <button type="submit">Add Salary Scale</button>
      </form>
    </div>

      <div id="center">
      <h2>Salary Scale Table</h2>
        <?php
        //path to the SQLite database file
        $db_file = '../DB/bigTuba.db';
    
        try {
            //open connection to the airport database file
            $db = new PDO('sqlite:' . $db_file);

            //set errormode to use exceptions
            $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            //return all passengers, and store the result set
            $query_str = $db->prepare("select * from SalaryScale order by rank");
        
            if ($query_str->execute()){
                $i = 0;
                $result_set = $db->query("select * from SalaryScale order by rank");
                echo "<table align='center'>";
                echo "<tr><td>Rank</td><td>Step</td><td>Base Salary</td></tr>";
                while($row = $result_set->fetch()) {
                  echo "<tr><td>" . $row['rank'] . "</td><td>" . $row['step'] . "</td><td>" . $row['baseSalary'] . "</td><td>
                      </td><td> <form action='./EditDB_PHP/update/updateSalaryScale.php' method='post'>
                        <input type='hidden' name='rank' value= $row[0]>
                        <input type='hidden' name='step' value= $row[1]>
                        <input type='hidden' name='baseSalary' value= $row[2]>
                        <input type='submit' value='Update'>
                      </form>
                      </td><td>
                        <form action='./EditDB_PHP/delete/deleteSalaryScale.php' method='post'>
                        <input type='hidden' name='rank' value= $row[0]>
                        <input type='hidden' name='step' value= $row[1]>
                        <input type='hidden' name='baseSalary' value= $row[2]>
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
