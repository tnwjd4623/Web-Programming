<!DOCTYPE html>
<html>
<head>
	<meta charset='utf-8'>
</head>
<body>
<?php
	//DB에 받은 정보 저장
	$connect = mysqli_connect('localhost', 'tnwjd4623', '1q2w3e4r', 'tnwjd4623') or die("fail");
	$id=$_GET[id];
	$pw=$_GET[pw];
	$email=$_GET[email];

	$date = date('Y-m-d H:i:s');
	$URL = "./main.php";
	
	$query = "insert into member (id, pw, mail, date, permit) values('$id', '$pw', '$email', '$date', 0)";

	$result = $connect->query($query);

	if($result) {
	?>	<script>
		alert('가입 되었습니다.');
		location.replace("<?php echo $URL?>");
		</script>

<?php	}
	else{
?>		<script>
			
			alert("fail");
		</script>
<?php	}

	mysqli_close($connect);
?>
</body>
</html>		
