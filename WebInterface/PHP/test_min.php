<?php
	//Following PHP code calculates traffic count for the past hour in ten minute increments
	
	function test($val) {
		
		$con=mysqli_connect("database.cse.tamu.edu","runner123g","gramcaki","runner123g");
		// Check connection
		if (mysqli_connect_errno())
		  {
			echo "Failed to connect to MySQL: " . mysqli_connect_error();
		  }
        
        //SQL query
		$sql="SELECT numPeople FROM RecTable 
                WHERE curTime between  TIMESTAMPADD(MINUTE, ($val-10), CURRENT_TIMESTAMP() )
                and TIMESTAMPADD(MINUTE, ($val), CURRENT_TIMESTAMP() );";

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
		  
		  //close connection
		  mysqli_close($con);
		}
		
		//return data in a format readable by Javascript		
        return json_encode(count($returnCol));
	}
	
	//divide data into ten minute intervals
	function checkMin(){
		$val = 0;
        $finret = array();
        $count =0;
        $sum =0;
        $temp =0;
        
		while($val > -60 )
		{ 
			$temp = test($val);
			$sum = $temp + $sum;
			array_push($finret,$sum);
			$val = $val - 10;
			$sum = 0;
        }
		
        echo json_encode(array_reverse($finret));
        
	}
	
	//call our update function if this PHP file is accessed on server
	checkMin();  

?>