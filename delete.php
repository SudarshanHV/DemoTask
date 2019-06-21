<form action="delete.php" method="post">
		<label for="Roll No"><strong>Roll No To Delete:</strong></label>
		<input id="rollno" type="text" name="rollno" placeholder="Roll No"  required/></br>
		<input type="submit" value="Delete the student data" name="delete"/></br>	
	</form>

<a href="index.php">Back To Home</a>
<?php
	if(isset($_POST['delete'])){
		require 'connection.php';
		$rollno=$_POST['rollno'];
		if(empty($rollno)){
			header("Location: index.php?error=emptyfields&name=".$name);
			exit();
		}
		else{
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
				if($resultCheck==0){
					echo 'Roll no does not exist in database';
					header("Location: index.php?error=NoSuchRollno");
					exit();
				}
				else{
					$sql="DELETE FROM studentdata WHERE strollno=?";
					$stmt=mysqli_stmt_init($conn);
					if(!mysqli_stmt_prepare($stmt,$sql)){
						header("Location: index.php?error=SQLerror");
						exit();
					}
					else{
						mysqli_stmt_bind_param($stmt,"s",$rollno);
						mysqli_stmt_execute($stmt);
						header("Location: index.php?delete=success");
						exit();
					}
			    }
			}
		mysqli_stmt_close($stmt);
		mysqli_close($conn);
	}
//CODE TO DELETE FROM DATABASE
}
?>