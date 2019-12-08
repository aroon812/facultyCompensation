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
	<link rel="stylesheet" href="../CSS/main.css">
	
	<meta name="theme-color" content="#fafafa">
</head> 
	
<body>
	<div class="navbar">
		<a href="../index.html">Home</a>
		<a href="./showCurrent.php">Current</a>
		<a href="./past.php">Past</a>
		<a href="./projected.php">Projected</a>
		<a href="./showDepartments.php"> Departments</a>
		<a href="./showEmployees.php"> Employees</a>
		<a href="./showAdjustments.php"> Adjustments</a>
		<a href="./showSalaryScale.php"> Salary Scale</a>
		<a href="./showAdjEmp.php"> EmployeeAdjustments</a>
		<a href="./showEmpInfoYear.php">EmployeeInformationByYear</a>
		<a class= "active" href="../HTML/DBAccess.html">SQL Editor</a>
	</div>

	<div id="container">

	<div id="left25" class = "sticky">
		<p>
			<fieldset>
				<legend><h2> Query </h3></legend>
				<?php echo "<h4>" . $_POST["query"] . "</h3>"; ?>
				<form action="../HTML/DBAccess.html">
					<button type="submit">New Query</button>
				</form>
			</fieldset>
		</p>
	</div>


	<div id="right74">
		<br>
		<br>
		<br>
		<?php
				//path to the SQLite database file
				$db_file = '../DB/bigTuba.db';
			
			try {
				//open connection to the airport database file
				$db = new PDO('sqlite:' . $db_file);
				$db->exec( 'PRAGMA foreign_keys = ON;' );
				//set errormode to use exceptions
				$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
				$query_str = $_POST["query"];
				$result_set = $db->query($query_str);
				

				$rowStr = "<tr><td><h2>Result Table:</h2></td></tr>";
				while($row = $result_set->fetch()) {
					for ($i = 0; $i < count($row)/2; $i++) {
						if ($i == count($row)/2 -1){
							$rowStr = $rowStr . $row[$i] . "</td><tr>";
						} else if ($i == 0){
							$rowStr = $rowStr .  "<tr><td>" . $row[$i] . "</td><td>";
						} else {
							$rowStr = $rowStr . $row[$i] . "</td><td>";
						}
					}
				}
				echo "<table align='center'>";
				echo $rowStr;
				echo "</table>";

				//disconnect from db
				$db = null;
			}
			catch(PDOException $e) {
				die('Exception : '.$e->getMessage());
			}
		?>
	</div>
</div>
</html>