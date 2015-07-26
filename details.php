<?php
set_time_limit(0);
$con=mysqli_connect("localhost","root","","ragu");

// Check connection
if (mysqli_connect_errno())
  {
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
  }
if(isset($_GET['code'])&&isset($_GET['admission_code']))
{
$result = mysqli_query($con,"SELECT count(*) as total_count FROM symptoms WHERE admission_code = ".$_GET['admission_code']);
$total_count = mysqli_fetch_object($result)->total_count;
//echo $total_count."<br/>";

$query = "SELECT count(*) as total_count FROM symptoms WHERE admission_code = ".$_GET['admission_code']." AND code =".$_GET['code'];
$result = mysqli_query($con,$query);
$this_count = mysqli_fetch_object($result)->total_count;
//echo $this_count."<br/>";

$query = " SELECT * FROM codes WHERE code =".$_GET['code'];
$result = mysqli_query($con,$query);
$desc = mysqli_fetch_object($result);

}

?>
<body style="background-color:#E6E6FA"></body>
<table>
<tr>
	<td>
		Total Occurances with  
		
	</td>
	<td>
		<?php echo $desc->long_desc ?>
	</td>
	<td>
		is
		<?php echo $this_count ?>
	</td>
	<td>
	 Occurances with others is
		<?php echo $total_count - $this_count; ?>
	</td>
	<td>
	 . Percentage %
		<?php echo ($this_count/($total_count-$this_count))*100; ?>
	</td>
	
</tr>
</table>