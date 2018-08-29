<?php
	$connect = mysqli_connect("localhost", "tnwjd4623", "1q2w3e4r", "tnwjd4623") or die ("connect fail");

	$id = $_GET[id];
	$comment = $_GET[comment];
	$type = $_GET[type];
	$board_num = $_GET[number];
	$date = date('Y-m-d H:i:s');
	$parent = $_GET[parent];

	$query;
	if($type == 0) {
		$query = "insert into comment_sell (number, board_number, id, content, date, parent_number) values (null, '$board_num', '$id', '$comment', '$date', '$parent')";
	}

	else if($type==1) {
		 $query = "insert into comment_buy (number, board_number, id, content, date, parent_number) values (null, '$board_num', '$id', '$comment', '$date','$parent')";
	}

	$result = $connect->query($query);

	if($result) {
?>		<script>
			alert("댓글이 등록되었습니다.");
			history.back();
		</script>
<?php	}

	else {
?>		<script>
			alert("fail");
			history.back();
		</script>
<?php	}

	mysqli_close($connect);
?>
