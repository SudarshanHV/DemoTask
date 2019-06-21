<form action="update.php" method="post">
		<label for="Roll No"><strong>Roll No To Update:</strong></label>
		<input id="rollno" type="text" name="rollno" placeholder="Roll No"  required/></br>
		<label for="New Roll No"><strong>New Roll No :</strong></label>
		<input id="nrollno" type="text" name="nrollno" placeholder="New Roll No"  required/></br>
		<label for="New Name"><strong>New Name :</strong></label>
		<input id="nname" type="text" name="nname" placeholder="New Name"  required/></br>
		<input type="submit" value="Update/Edit the student data" name="update"/></br>	
	</form>



<a href="index.php">Back To Home</a>
<?php

	if(isset($_POST['update'])){
		require 'connection.php';
		$rollno=$_POST['rollno'];
		$newroll=$_POST['nrollno'];
		$newname=$_POST['nname'];
		if(empty($rollno)||empty($newroll)||empty(newname)){
			header("Location: update.php?error=emptyfields&rollno=".$rollno."&newroll=".$newroll."&newname=".$newname);
			exit();
		}//ADD MORE ERROR CHECKS IF TIME PERMITS
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
					header("Location: update.php?error=NoSuchRollno");
					exit();
				}
				else{
					$sql="UPDATE studentdata SET stname=?,strollno=? WHERE strollno=?";
					$stmt=mysqli_stmt_init($conn);
					if(!mysqli_stmt_prepare($stmt,$sql)){
						header("Location: update.php?error=SQLerror");
						exit();
					}
					else{
						mysqli_stmt_bind_param($stmt,"sss",$newname,$newroll,$rollno);
						mysqli_stmt_execute($stmt);
						header("Location: index.php?update=success");
						exit();
					}
			    }
			}
		mysqli_stmt_close($stmt);
		mysqli_close($conn);
	}
}
?>