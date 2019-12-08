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
    <a href="./showSalaryScale.php"> Salary Scale</a>
    <a class= "active" href="./showAdjEmp.php"> EmployeeAdjustments</a>
    <a href="./showEmpInfoYear.php">EmployeeInformationByYear</a>
    <a href="../HTML/DBAccess.html">SQL Editor</a>
  </div>

  <!-- Add your site or application content here -->
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
        <h4>First Name:</h4>
        - The first name of a faculty member.
        <h4>Last Name:</h4>
        - The last name of a faculty member.
      </p>
    </div>

    <div id="right" class="sticky">
      <p>
        <h3>Action Descriptions:</h3>
        <h4>Delete:</h4>
        The delete button will remove the data for that row from the table.
        <h4>Add:</h4>
        The add button will open a form to add a new row of data to the table.
      </p>

      <form action="../HTML/EditDB_HTML/add/addEmpAdjustments.html">
        <button type="submit">Add Employee Adjustments</button>
      </form>
    </div>

    <div id="center">
      <h2>Employee Adjustments Table</h2>
      <?php
        //path to the SQLite database file
        $db_file = '../DB/bigTuba.db';
    
        try {
            //open connection to the airport database file
            $db = new PDO('sqlite:' . $db_file);

            //set errormode to use exceptions
            $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            //return all passengers, and store the result set
            $query_str = $db->prepare("select year, upsID, adjID, firstName, lastName from EmployeeAdjustments natural join employee order by year desc");
        
            if ($query_str->execute()){
                $i = 0;
                $result_set = $db->query("select year, upsID, adjID, firstName, lastName from EmployeeAdjustments natural join employee order by year desc");
                echo "<table align='center'>";
                echo "<tr><td>Year</td><td>UPS ID</td><td>Adjustment ID</td><td>First Name</td><td>Last Name</td></tr>";
                while($row = $result_set->fetch()) {
                    echo "<tr><td>" . $row['year'] . "</td><td>" . $row['upsID'] . "</td><td>" . $row['adjID'] . "</td><td>" . $row['firstName'] . "</td><td>" . $row['lastName'] . "</td><td>
                        </td><td>
                          <form action='./EditDB_PHP/delete/deleteAdjEmp.php' method='post'>
                          <input type='hidden' name='year' value= $row[0]>
                          <input type='hidden' name='upsID' value= $row[1]>
                          <input type='hidden' name='adjID' value= $row[2]>
                          <input type='hidden' name='firstName' value= $row[3]>
                          <input type='hidden' name='lastName' value= $row[4]>
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