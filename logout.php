<?php
	//세션 삭제
	session_start();
	$res = session_destroy();
	$URL = "./main.php";
	
	if($res) {
?>
	<script>
		alert("로그아웃 되었습니다.");
		location.replace("<?php echo $URL?>");
	</script>
<?php

	}
?>
