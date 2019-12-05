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
    <a href="./showAdjustments.php"> Adjustments</a>
    <a href="./showSalaryScale.php"> Salary Scale</a>
    <a href="./showAdjEmp.php"> EmployeeAdjustments</a>
    <a href="./showEmpInfoYear.php">EmployeeInformationByYear</a>
    <div class="dropdown">
      <button class="dropbtn">Edit Data 
        <i class="fa fa-caret-down"></i>
      </button>
      <div class="dropdown-content">
        <a href="./add.html">add</a>
        <a href="./update.html">update</a>
        <a href="./delete.html">delete</a>
      </div>
    </div> 
  </div>

  <!-- Add your site or application content here -->
  <h1 class="pagetitle">Employee Adjustments by Year</h1>
  <p class="pagetext">(UPS ID, First Name, Last Name, Type, Department, Year, Adjustment ID)<br>
    <?php
            //path to the SQLite database file
            $db_file = '../DB/bigTuba.db';
        
            try {
                //open connection to the airport database file
                $db = new PDO('sqlite:' . $db_file);

                //set errormode to use exceptions
                $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                //return all passengers, and store the result set
                $query_str = $db->prepare("select * from Employee natural join EmployeeAdjustments order by Year desc");
            
                if ($query_str->execute()){
                    $i = 0;
                    $result_set = $db->query("select * from Employee natural join EmployeeAdjustments order by Year desc");
                    echo "<table align='center'>";
                    echo "<tr><td>upsID</td><td>lastName</td><td>firstName</td><td>type</td><td>dept</td><td>year</td><td>adjID</td></tr>";
                    while($row = $result_set->fetch()) {
                      if ($row[$i] == NULL){
                        echo "<tr><td>[NULL]<tr><td>";
                      } else {
                        echo "<tr><td>" . $row['upsID'] . "</td><td>" . $row['lastName'] . "</td><td>" . $row['firstName'] . "</td><td>" . $row['type'] . "</td><td>" . $row['dept'] . "</td><td>" . $row['year'] . "</td><td>" . $row['adjID'] . "</td></tr>";
                      }
                    }
                    echo "</table>";
                }
                //disconnect from db
                $db = null;
            } catch(PDOException $e) {
                die('Exception : '.$e->getMessage());
            }
        ?>
        </p>
</body>
</html>