<!DOCTYPE html>
<html>
<head>
        <meta charset='utf-8'>
        <link rel="stylesheet" type="text/css" href="skeleton.css">
</head>
<body>
        <?php
		$connect = mysqli_connect("localhost", "tnwjd4623", "1q2w3e4r", "tnwjd4623") or die("connect fail");
		$id = $_GET[id];
		$type = $_GET[type];
		$number = $_GET[number];
		$board_query;

		if($type==0) {
			$board_query = "select title, content, date, hit, id, isbn from board_sell where number=$number";	
		}
		else if($type==1) {
			$board_query = "select title, content, date, hit, id, isbn from board_buy where number=$number";
		}
		$board_result = $connect->query($board_query);
		$rows = mysqli_fetch_assoc($board_result);
	
		$title = $rows['title'];
		$content = $rows['content'];
		$usrid = $rows['id'];
	
                session_start();
                $URL = "./main.php";

		//세션이 있어야 수정 가능
                if(!isset($_SESSION['userid'])) {
        ?>
                        <script>
                                alert("권한이 없습니다.");
                                location.replace("<?php echo $URL?>");
                        </script>
	<?php   }

		//세션, 권한 검사
		else {
			$userid = $_SESSION['userid'];

			$query = "select permit from member where id=$userid";
			$result = $connect->query($query);
			
			if($_SESSION['userid'] == $id || $result==1 ) {
	?>		<form method="get" action="./modify_action.php">
			<div class="write_box">
				<div class="id">
					<div class="text2"><span>작성자: <?=$usrid?></span></div>
					<input type="hidden" name="number" value="<?=$number?>">
					<input type="hidden" name="type" value="<?=$type?>">
				</div>
				<div class="title">
					<div class="text">제목</div><input class="input_title" type=text name= title value="<?=$title?>">
				</div>
				<div class="content">
					<textarea class="input_content" name=content><?=$content?></textarea>
				</div>
				<input class="button" type="submit" value="수정">
			</div>
			</form>

	<?php		}
			else {
	?>			<script>
				alert("권한이 없습니다.");
				location.replace("<?php echo $URL?>");
				</script>	
	<?php		}

		}

        ?>
</body>
</html>
