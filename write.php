<!DOCTYPE html>
<html>
<head>
	<meta charset='utf-8'>
	<link rel="stylesheet" type="text/css" href="skeleton.css">
</head>
<body>
	<?php 
		session_start();
		$URL = "./main.php";
		if(!isset($_SESSION['userid'])) {
	?>
			<script>
				alert("로그인이 필요합니다");
				location.replace("<?php echo $URL?>");
			</script>
<?php		}
		$type = $_GET['type'];
		$isbn;

		
		$isbn = $_GET['isbn'];
		
		

		
	?>

	<form method="get" action = "./write_action.php">
	<div class="write_box">
		<div class="id">
			<div class="text2"><span>작성자: <?= $_SESSION['userid'] ?></span></div>
			<input type="hidden" name="id" value="<?=$_SESSION['userid']?>" >
		</div>
		<div class="title">
			<div class="text">제목</div><input class="input_title" type = text name = title>
		</div>

		<div class="content">
			<textarea class="input_content"name = content ></textarea>
		</div>
	

	<?php	if($type==0) {
	?>	<input type=hidden value=0 name = type>
		<input type=hidden value="<?php echo $_GET['isbn'];?>" name= isbn>
	<?php	}
		else if($type==1) {
	?>	<input type=hidden value=1 name = type>
		<input type=hidden value="<?php echo $_GET['isbn'];?>" name= isbn>
	<?php	}
	?>
		<input class="button" type = "submit" value="작성">
	</div>
	</form>
</body>
</html>
