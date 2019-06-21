<form action="signup.php" method="post">
		<label for="name"><strong>Student Name:</strong></label>
		<input id="name" type="text" name="name" placeholder="Student Name" required /></br>
		<label for="Roll No"><strong>Roll No:</strong></label>
		<input id="rollno" type="text" name="rollno" placeholder="Roll No"  required/></br>
		<input type="submit" value="Enter new student" name="submit-signup"/></br>
	</form>

<a href="index.php"> Back to Home </a>

<?php
if(isset($_POST['submit-signup'])){
	require 'connection.php';
	$name=$_POST['name'];
	$rollno=$_POST['rollno'];
	if(empty($rollno)&&empty($name)){
		header("Location: signup.php?error=emptyfields&name=".$name."&rollno=".$rollno);
		exit();
	}
	else if(empty($name)){
		header("Location: signup.php?error=emptyfields&rollno=".$rollno);
		exit();
	}
	else if(empty($rollno)){
		header("Location: signup.php?error=emptyfields&name=".$name);
		exit();
	}
	else{
		// Just enter the data to database with roll no check
		//Prepared statements to prevent SQL injection
		$sql= "SELECT strollno FROM studentdata WHERE strollno=? ";
		$stmt=mysqli_stmt_init($conn);
		if(!mysqli_stmt_prepare($stmt,$sql)){
			echo "SQL Error!!";
		}
		else{
				mysqli_stmt_bind_param($stmt,"s",$rollno);
				mysqli_stmt_execute($stmt);
				mysqli_stmt_store_result($stmt);
				$resultCheck=mysqli_stmt_num_rows($stmt);
				if($resultCheck>0){
					echo 'Roll no already taken';
					header("Location: signup.php?error=duplicateRollno");
					exit();
				}
				else{
					$sql="INSERT INTO studentdata(stname, strollno) VALUES (?,?)";
					$stmt=mysqli_stmt_init($conn);
					if(!mysqli_stmt_prepare($stmt,$sql)){
						header("Location: signup.php?error=SQLerror");
						exit();
					}
					else{
						mysqli_stmt_bind_param($stmt,"ss",$name,$rollno);
						mysqli_stmt_execute($stmt);
						header("Location: index.php?signup=success");
						exit();
					}
				}

		}
		// echo 'Name:'.$name.' Roll no:'.$rollno.' is in database now!!!';
		mysqli_stmt_close($stmt);
		mysqli_close($conn);

	}
}

?>