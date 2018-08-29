<?php
	//게시물 삭제 기능
	$type = $_GET[type];
	$number = $_GET[number];
	$id = $_GET[id];

	$connect = mysqli_connect("localhost", "tnwjd4623", "1q2w3e4r", "tnwjd4623") or die ("connect fail");

	$board_query;
	$delete;

	if($type==0) {
		$board_query = "select id from board_sell where number=$number";
		$delete = "delete from board_sell where number=$number";
	}

	else if($type==1) {

		$board_query = "select id from board_buy where number=$number";
		$delete ="delete from board_buy where number=$number";
	}

	$board_result = $connect->query($board_query);
	$rows = mysqli_fetch_assoc($board_result);

	$usrid = $rows['id'];

	session_start();
	$URL = "./main.php";

	//세션이 없으면 삭제 불가능
	if(!isset($_SESSION['userid'])) {
?>		<script>
			alert("권한이 없습니다.");
			location.replace("<?php echo $URL?>");
		</script>
<?php	}

	//세션이 있으면 권한과 아이디 검사 해서 삭제
	else {
		$userid = $_SESSION['userid'];

		$query = "select permit from member where id=$userid";
		$result = $connect->query($query);

		if($_SESSION['userid'] == $id || $result == 1) {
			
		//	$delete_result = $connect->query($delete);
?>				<script>
				var flag = confirm("삭제하시겠습니까?");	
				if(flag) { 
				</script>
<?php				
				$delete_result = $connect->query($delete);
				if($delete_result) {
?>				
				<script>
					alert("삭제되었습니다.");
					location.replace("<?php echo $URL?>");
				</script>
<?php				}
?>				<script>
				}
				</script>
<?php		}

		else {
?>			<script>
				alert("권한이 없습니다.");
				location.replace("<?php echo $URL?>");
			</script>
<?php		}

	}
?>

