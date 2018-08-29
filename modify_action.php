<?php
	$connect = mysqli_connect("localhost", "tnwjd4623", "1q2w3e4r", "tnwjd4623") or die("connect fail");
	$number = $_GET[number];
	$type = $_GET[type];
	$title = $_GET[title];
	$content = $_GET[content];
	$date = date('Y-m-d H:i:s');

	$query;

	if($type==0) {
		$query = "update board_sell set title='$title', content='$content', date='$date'  where number=$number";
	}
	else if($type==1) {
		$query = "update board_buy set title='$title', content='$content', date='$date' where number=$number";
	}

	$result = $connect->query($query);

	if($result) {
?>		<script>
		location.replace("./view?type=<?=$type?>&number=<?=$number?>");
		</script>
<?php	}

	else {
		echo "fail";
	}

?>
