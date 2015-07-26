<?php
set_time_limit(0);
$con=mysqli_connect("localhost","root","","ragu");

// Check connection
if (mysqli_connect_errno())
  {
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
  }
?>

<link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.1.1/css/bootstrap.min.css">
<head>
<title> CSE-5194 Project</title>
<h1><center> CSE-5194 </center></h1>
</head>
<body style="background-color:#E6E6FA"></body>
<form style="text-align:center;margin-top:100px;">
<input name="sym_code">
<button>Submit</button>
</form>

<table class="table table-striped">
	<tr>
		<td>
			Short Desc
		</td>
		<td>
			Count
		</td>
		<td>
			Rem %
		</td>
		<td>
			Total %
		</td>
		<td>
			Link
		</td>
	</tr>


<?php
if(isset($_GET['sym_code']))
{

$result = mysqli_query($con,"SELECT count(*) as total_count FROM symptoms WHERE admission_code = '".$_GET['sym_code']."'");
$total_count = mysqli_fetch_object($result)->total_count;
//echo $total_count."<br/>";
$result = mysqli_query($con,"SELECT * FROM codes WHERE code = '".$_GET['sym_code']."'");
$short_desc = mysqli_fetch_object($result)->short_desc;
echo "<h2>".$short_desc."<h2><br/>";
echo $_GET['sym_code'];
$result = mysqli_query($con,"SELECT count(*) as count,code FROM symptoms WHERE admission_code = '".$_GET['sym_code']."' GROUP BY code ORDER BY count DESC");
$check = 0;
while($row = mysqli_fetch_array($result))
  {
  	$short_name = "Not Available";
$result1 = mysqli_query($con,"SELECT * FROM codes WHERE code = ".$row['code']);
if($result1)
{
	$object = mysqli_fetch_object($result1);
	if($object != null  && isset($object))
		$short_name = $object->short_desc;
}
  	echo "<tr><td>$short_name</td><td>".($row['count'])."</td><td>".(($row['count']/($total_count - $row['count']))*100)."</td><td>".$row['count']."/".$total_count." = ".(($row['count']/$total_count)*100)."</td><td><a href=\"details.php?code=".$row['code']."&admission_code=".$_GET['sym_code']."\">Click Here</a></td></tr>";
	$check = $check + $row['count'];
  }
}

?>
</table>