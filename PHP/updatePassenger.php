<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<link rel="stylesheet" href="index.css">
		<link rel="icon" href="favicon.ico" type="image/x-icon"/>
		<link rel="shortcut icon" href="favicon.ico" type="image/x-icon"/>
		<title>Update Passenger Form</title>
	</head>
	<body>
		<?php session_start(); ?>
		<form action="updatePassengerForm.php" method="post">
			<fieldset>
				<legend>Update Passenger Form</legend>
				
				Please fill out the following information to update a passenger in the database.<br><br>
				<?php
					if(strcmp($_SERVER['HTTP_REFERER'], 'http://129.114.104.171/~dbteam/showPassengers.php') == 0){					
					$f_name = $_POST['f_name'];
					$m_name = $_POST['m_name'];
					$l_name = $_POST['l_name'];
					$ssn = $_POST['ssn'];
					echo 
					"<input type='hidden' name= 'id' value='$ssn'>
					First Name:<br>
					<input type = 'text' name = 'f_name' placeholder='First Name' maxlength=50 pattern='^([A-Za-z]+[,.]?[ ]?|[A-Za-z]+['-]?)+$' value='$f_name' required autofocus><br>
					
					Middle Name:<br>
					<input type = 'text' name = 'm_name' placeholder='Middle Name (optional)' maxlength=50 pattern='^([A-Za-z]+[,.]?[ ]?|[A-Za-z]+['-]?)+$' value='$m_name'><br>
					
					Last Name:<br>
					<input type = 'text' name = 'l_name' placeholder='Last Name' maxlength=50 pattern='^([A-Za-z]+[,.]?[ ]?|[A-Za-z]+['-]?)+$' value='$l_name' required><br>
					
					SSN:<br>
					<input type = 'text' name = 'SSN' placeholder='XXX-XX-XXXX' maxlength=11 pattern='\d{3}-?\d{2}-?\d{4}' value='$ssn' required><br>
					
					<input type = 'submit' name = 'submit' value='Update Passenger'>";
					}
					else{
						echo var_dump($_POST);
						$ssn= $_POST['ssn'];
						echo "
						First Name:<br>
						<input type = 'text' name = 'f_name' placeholder='First Name' maxlength=50 pattern='^([A-Za-z]+[,.]?[ ]?|[A-Za-z]+['-]?)+$' value='' required autofocus><br>
						
						Middle Name:<br>
						<input type = 'text' name = 'm_name' placeholder='Middle Name (optional)' maxlength=50 pattern='^([A-Za-z]+[,.]?[ ]?|[A-Za-z]+['-]?)+$' value=''><br>
						
						Last Name:<br>
						<input type = 'text' name = 'l_name' placeholder='Last Name' maxlength=50 pattern='^([A-Za-z]+[,.]?[ ]?|[A-Za-z]+['-]?)+$' value='' required><br>
						
						SSN:<br>
						<input type = 'text' name = 'SSN' placeholder='XXX-XX-XXXX' maxlength=11 pattern='\d{3}-?\d{2}-?\d{4}' value='$ssn' required><br>
						
						<input type = 'submit' name = 'submit' value='Update Passenger'>";
					}
				?>			
			</fieldset>
		</form>
	</body>
</html>
