<?php
	//function test() {
		$con=mysqli_connect("database.cse.tamu.edu","runner123g","gramcaki","runner123g");
		// Check connection
		if (mysqli_connect_errno())
		  {
		  echo "Failed to connect to MySQL: " . mysqli_connect_error();
		  }


		 $curr_date = new DateTime()->format('Y-m-d H:i:s')

		 //The following if else statements will select data from the db depending on what button the user pressed
	
		 if($_POST['time'] == 'Week'){
		 	$past_week = new DateTime('-7 days')->format('Y-m-d H:i:s')
		 	$sql="SELECT numPeople FROM RecTable WHERE curTime BETWEEN '$past_week' AND '$curr_date'";
		 }

		 else if($_POST['time'] == 'Day'){
		 	$past_day = new DateTime('-1 day')->format('Y-m-d H:i:s')
		 	$sql="SELECT numPeople FROM RecTable WHERE curTime BETWEEN '$past_day' AND '$curr_date'";
		 }

		 else if($_POST['time'] == 'Month'){
		 	$past_month = new DateTime('-1 month')->format('Y-m-d H:i:s')
		 	$sql="SELECT numPeople FROM RecTable WHERE curTime BETWEEN '$past_month' AND '$curr_date'";
		 }

		 else if($_POST['time'] == 'Hour'){
		 	$past_hour = new DateTime('-1 hour')->format('Y-m-d H:i:s')
		 	$sql="SELECT numPeople FROM RecTable WHERE curTime BETWEEN '$past_hour' AND '$curr_date'";
		 }

		 else if($_POST['time'] == 'Year'){
		 	$past_year = new DateTime('-1 year')->format('Y-m-d H:i:s')
			$sql="SELECT numPeople FROM RecTable WHERE curTime BETWEEN '$past_year' AND '$curr_date'";	
		 }

		//$sql="SELECT numPeople FROM RecTable WHERE numPeople <= 8";

		$returnCol = array();
		if ($result=mysqli_query($con,$sql))
		  {
		  // Fetch one and one row
		  while ($row=mysqli_fetch_row($result))
			{
			$returnCol[] = $row[0];
			}
		  // Free result set
		  mysqli_free_result($result);
		  mysqli_close($con);
		}
		echo json_encode($returnCol);
?>