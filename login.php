<?php
	//세션 생성
	session_start();

	$connect = mysqli_connect("localhost", "tnwjd4623", "1q2w3e4r", "tnwjd4623") or die("fail");
	$id=$_GET['id'];
	$pw=$_GET['pw'];
	
	$URL = "./main.php";

	$query = "select * from member where id='$id'";
	$result = $connect->query($query);

	//DB의 정보와 같아야 세션이 만들어짐
	if(mysqli_num_rows($result)==1) {

		$row=mysqli_fetch_assoc($result);

		if($row['pw']==$pw){
			$_SESSION['userid']=$id;
			if(isset($_SESSION['userid'])){
			?>	<script>
					alert("로그인 되었습니다.");
					history.back();
				</script>
<?php
			}
			
			else{
				echo "session fail";
			}
		}
		
		else {
	?>		<script>
				alert("아이디 혹은 비밀번호가 잘못되었습니다.");
				history.back();
			</script>
	<?php
		}

	}

	else{
?>		<script>
			alert("아이디 혹은 비밀번호가 잘못되었습니다.");
			history.back();
		</script>
<?php
	}

	
?>
	
