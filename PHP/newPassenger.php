<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<link rel="stylesheet" href="index.css">
		<link rel="icon" href="favicon.ico" type="image/x-icon"/>
		<link rel="shortcut icon" href="favicon.ico" type="image/x-icon"/>
		<title>University of Puget Sound Payroll</title>
	</head>
	
	<body>
		<article>
			<h3>New P Info:</h3>
			First Name:
			<?php echo $_POST["firstName"]; ?><br>
			Last Name:
			<?php echo $_POST["lastName"]; ?><br>
			UPS ID:
			<?php echo $_POST["upsID"]; ?><br>
			Type:
			<?php echo $_POST["typee"]; ?> <br><br>
			Department:
			<?php echo $_POST["dept"]; ?> <br><br>
			<?php
					//path to the SQLite database file
					$db_file = '../DB/bigTuba.db';
				
				try {
					//open connection to the airport database file
					$db = new PDO('sqlite:' . $db_file);
					//set errormode to use exceptions
					$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
					
					$query_str = $db->prepare("INSERT INTO employee VALUES (:upsID, :firstName, :lastName, :typee, :dept)");
					$query_str->bindParam(':firstName', $_POST["firstName"]);
					$query_str->bindParam(':lastName', $_POST["lastName"]);
					$query_str->bindParam(':upsID', $_POST["upsID"]);
					$query_str->bindParam(':typee', $_POST["typee"]);
					$query_str->bindParam(':dept', $_POST["dept"]);
					if ($query_str->execute()){
						echo "Success!<br>";
					}
					
					//return all passengers, and store the result set
					$query_str = $db->prepare("select * from employees");
					   if ($query_str->execute()){
						$i = 0;
				 		$result_set = $db->query("select * from employees");
				 		while($row = $result_set->fetch()) {
				 			echo "<form action='updatePassenger.php' method='post'>(";
				 			for ($i = 0; $i < count($row)/2; $i++) {
				 				if ($row[$i] == NULL){
				 					echo "[NULL]";
				 				} else {
				 					echo $row[$i];
				 				}
				 				if ($i == count($row)/2 -1){
				 					echo ")";
								} else {
									echo ", ";
				 				}
				 			}
							echo "  <input type='hidden' name='f_name' value=$row[0]>
				 					<input type='hidden' name='m_name' value=$row[1]>
									<input type='hidden' name='l_name' value=$row[2]>
									<input type='hidden' name='ssn' value=$row[3]>
									<input type='submit' value='Update'>
				 				</form><br>";
							
				 			$i = $i + 1;
				 		}
				 	}
					
					//disconnect from db
					$db = null;
				}
				catch(PDOException $e) {
					echo header('Location: newPassenger.php');
					exit;
				}
			?>
		</article>
	</body>
</html>