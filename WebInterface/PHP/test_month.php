<?php
	//Following PHP code calculates traffic count for the past week in one day increments
	
	function test($val) {
		
		$con=mysqli_connect("database.cse.tamu.edu","runner123g","gramcaki","runner123g");
		// Check connection
		if (mysqli_connect_errno())
		{
		  echo "Failed to connect to MySQL: " . mysqli_connect_error();
		}
        
        //SQL query
		$sql="SELECT numPeople FROM RecTable 
                WHERE curTime between  TIMESTAMPADD(DAY, ($val), CURDATE() )
                and TIMESTAMPADD(DAY, ($val+1), CURDATE() );";
 
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
	
	//check month function to divide data into 30 days
	function checkMonth(){
		$val = 0;
        $finret = array();
        $count =0;
        $sum =0;
        $temp =0;
        
		while($val > -30 )
		{  //30 || 31 day in a month
			$temp = test($val);
			$sum = $temp + $sum;
			array_push($finret,$sum);
			$val = $val - 1;
			$sum = 0;
        }
		
        echo json_encode(array_reverse($finret));
	}
	
	//call our update function if this PHP file is accessed on server
	checkMonth();  

?>