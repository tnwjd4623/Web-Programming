<!DOCTYPE>
<html>
<head>
</head>
<body>

<?php 
	//작성한 글 저장
	$connect = mysqli_connect("localhost", "tnwjd4623", "1q2w3e4r","tnwjd4623") or die ("connect fail");

	$type = $_GET[type];
	$id = $_GET[id];
	$title = $_GET[title];
	$content = $_GET[content];
	$date = date('Y-m-d H:i:s');
	$isbn = $_GET[isbn];

	$URL = "./main.php";

	$query;

	if($type==0){
		$query = "insert into board_sell (number, title, content, date, hit, id, isbn)
			values(null, '$title', '$content', '$date', '0', '$id', '$isbn')";
	}


	else if($type==1) {
		$query = "insert into board_buy (number, title, content, date, hit, id, isbn)
		values(null, '$title', '$content', '$date', '0', '$id', '$isbn')";
	} 

	$result = $connect->query($query);

	if($result) {
?>
		<script>
			alert("글이 등록되었습니다.");
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
	
