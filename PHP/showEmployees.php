<!doctype html>
<html>

<head>
  <meta charset="utf-8">
  <title>University of Puget Sound Payroll</title>
  <meta name="description" content="">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <link rel="manifest" href="site.webmanifest">
  <link rel="apple-touch-icon" href="icon.png">
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
    <a class="active" href="./showEmployees.php"> Employees</a>
    <a href="./showAdjustments.php"> Adjustments</a>
    <a href="./showSalaryScale.php"> Salary Scale</a>
    <a href="./showAdjEmp.php"> Employee Adjustments</a>
    <a href="./showEmpInfoYear.php">Employee Information By Year</a>
    <a href="../HTML/DBAccess.html">SQL Editor</a>
  </div>

  <div id="container">

    <div id="left" class="sticky">
      <p>
        <h2>Employees</h2>
        This table holds data about faculty and employees.
        <h3>Column Value Descriptions:</h3>
        <h4>UPS ID:</h4>
        - The number that corresponds with a Puget Sound faculty member.
        <br>
        - Primary Key
        <h4>Last Name:</h4>
        - The last name of a faculty member.
        <h4>First Name:</h4>
        - The first name of a faculty member.
        <h4>Type:</h4>
        - The employment track of a faculty member. <br>
        - Valid entries: T, I, CL, S, VAPx, VINx, and E <br>
        - Tenure-line <br>
        - Instructor <br>
        - Clinical <br>
        - Shared <br>
        - Visiting Assistant Professor for x years <br>
        - Visiting Instructor for x years <br>
        - Emeritus
        <h4>Department:</h4>
        - The department ID of the department in which the faculty member works.
        <br>
        - Foreign Key referencing Department
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

      <form action="../HTML/EditDB_HTML/add/addEmployee.html">
        <button type="submit">Add Employee</button>
      </form>
    </div>

    <div id="center">
      <h2>Employees Table</h2>
      <?php
      //path to the SQLite database file
      $db_file = '../DB/bigTuba.db';

      try {
        //open connection to the database
        $db = new PDO('sqlite:' . $db_file);
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $query_str = $db->prepare("select * from Employee");

        if ($query_str->execute()) {
          $i = 0;
          $result_set = $db->query("select * from Employee");
          echo "<table align='center'>";
          echo "<tr><td>UPS ID</td><td>Last Name</td><td>First Name</td><td>Type</td><td>Department</td></tr>";
          while ($row = $result_set->fetch()) {
            echo "<tr><td>" . $row['upsID'] . "</td><td>" . $row['lastName'] . "</td><td>" . $row['firstName'] . "</td><td>" . $row['type'] . "</td><td>" . $row['deptID'] . "</td><td>
                          </td><td> <form action='./EditDB_PHP/update/updateEmployees.php' method='post'>
                            <input type='hidden' name='upsID' value= $row[0]>
                            <input type='hidden' name='lastName' value= $row[1]>
                            <input type='hidden' name='firstName' value= $row[2]>
                            <input type='hidden' name='type' value= $row[3]>
                            <input type='hidden' name='deptID' value= $row[4]>
                            <input type='submit' value='Update'>
                          </form>
                          </td><td>
                            <form action='./EditDB_PHP/delete/deleteEmployees.php' method='post'>
                            <input type='hidden' name='upsID' value= $row[0]>
                            <input type='hidden' name='lastName' value= $row[1]>
                            <input type='hidden' name='firstName' value= $row[2]>
                            <input type='hidden' name='type' value= $row[3]>
                            <input type='hidden' name='deptID' value= $row[4]>
                            <input type='submit' value='Delete'>
                          </form>
                          </td></tr>";
          }
          echo "</table>";
        }
        //disconnect from db
        $db = null;
      } catch (PDOException $e) {
        die('Exception : ' . $e->getMessage());
      }
      ?>
    </div>
  </div>
</body>

</html>