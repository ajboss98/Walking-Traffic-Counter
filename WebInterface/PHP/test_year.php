<?php
	//Following PHP code calculates traffic count for the past year in one month increments
	
	function test($val) {
		
		$con=mysqli_connect("database.cse.tamu.edu","runner123g","gramcaki","runner123g");
		// Check connection
		if (mysqli_connect_errno())
		{
		  echo "Failed to connect to MySQL: " . mysqli_connect_error();
	    }
        
        //SQL query
		$sql="SELECT numPeople FROM RecTable 
                WHERE curTime between  TIMESTAMPADD(MONTH, ($val-1), CURDATE() )
                and TIMESTAMPADD(MONTH, ($val), CURDATE() );";
        
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
	
	//check year function to divide up data into 12 month increments
	function checkYear(){
		$val = 0;
        $finret = array();
        $count =0;
        $sum =0;
        $temp =0;
        
		while($val < 12){ 
			$temp=test($val);
			if($count <1)
			{
				$sum += $temp;
				$count++;
			}
			if($count ==1)
			{
				array_push($finret,$sum);
				$sum=0;
				$count =0;
			}
			if($val >= 12)
			{
				$time = "pm";
			}
			else
			{
				$time = "am";
			}
			$prevVal = ($val % 12)+1;
			$val++;
			$curVal = ($val % 12)+1;
		}
    
        echo json_encode(array_reverse($finret));     
	}
	
	//call our update function if this PHP file is accessed on server
	checkYear();  
    
    
?>