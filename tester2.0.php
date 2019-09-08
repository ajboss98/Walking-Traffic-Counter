<?php
	function test($val) {
		$con=mysqli_connect("database.cse.tamu.edu","runner123g","gramcaki","runner123g");
		// Check connection
		if (mysqli_connect_errno())
		  {
		  echo "Failed to connect to MySQL: " . mysqli_connect_error();
		  }
		//$sql="SELECT numPeople FROM RecTable WHERE numPeople <= 8";
        
        //we have to select every min/ hour depending on the data
		$sql="SELECT numPeople FROM RecTable 
                WHERE curTime between  TIMESTAMPADD(HOUR, $val, '2018-03-27 00:00:00')
                and TIMESTAMPADD(HOUR, ($val + 1), '2018-03-27 00:00:00');";
                 
               /*  curTime >= '2018-03-25 18:00:00' 
                AND
                curTime <= '2018-03-25 19:00:00' */
        
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
        
        
        
        //this will print the count of the array 
		//print json_encode(count($returnCol));
		print json_encode(count($returnCol));
	}
	if(isset($_POST['functionname'])) {
		$functionn = $_POST['functionname'];
		switch($functionn) {
			case 'test': test(); break;
		}	
	}
	
	
	
	function checkHourly(){
		$val = 0;
		while($val < 24){
		echo("Number of People ");
        test($val);
		if($val >= 12){
			$time = "pm";
		}
		else{
			$time = "am";
		}
		$prevVal = ($val % 12)+1;
        $val++;
		$curVal = ($val % 12)+1;
        echo (" from $prevVal:00$time to $curVal:00$time  <br>");
		
    }
	}
	
	checkHourly()
	
  
    
    
?>