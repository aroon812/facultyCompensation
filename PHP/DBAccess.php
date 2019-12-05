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
			<a href="./current.html">Current</a>
			<a href="./past.html">Past</a>
			<a href="./projected.html">Projected</a>
			<a href="./departments.html"> Departments</a>
			<a href="./employees.html"> Employees</a>
			<a href="./adjustments.html"> Adjustments</a>
			<a href="./salaryScale.html"> Salary Scale</a>
			<a href="./adjEmp.html"> EmployeeAdjustments</a>
			<a href="./empInfoYear.html">EmployeeInformationByYear</a>
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
		<article>
			<br> 
			Query:
			<?php echo $_POST["query"]; ?>
			<form action="../HTML/DBAccess.html">
				<button type="submit">New Query</button>
			</form>

			<h3>Result:</h3>
			<?php
					//path to the SQLite database file
					$db_file = '../DB/bigTuba.db';
				
				try {
					//open connection to the airport database file
					$db = new PDO('sqlite:' . $db_file);
					//set errormode to use exceptions
					$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
					$query_str = $_POST["query"];
					$result_set = $db->query($query_str);
					
					while($row = $result_set->fetch()) {
						echo "(";
						for ($i = 0; $i < count($row)/2; $i++) {
							if ($row[$i] == NULL){
								echo "[NULL]";
							} else {
								echo $row[$i];
							}
							if ($i == count($row)/2 -1){
								echo ")<br>";
							} else {
								echo ", ";
							}
						}
					}
					
					
					
					//disconnect from db
					$db = null;
				}
				catch(PDOException $e) {
					die('Exception : '.$e->getMessage());
				}
			?>
		</article>
	</body>
</html>