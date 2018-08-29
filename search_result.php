<!DOCTYPE html>
<html>
<head>
	<meta charset='utf-8'>
	<script src="javscript.js"></script>
</head>
<body>
	<script>
		resizeTo(1000,600);
	</script>
	
	<?php
		//네이버 API 호출 
		$key = $_GET['key'];

		$client_id = "SFezXsTn6ehQdzFHwwp7";
		$client_secret = "KzKrnNFNu_";
		$encText = urlencode($key);
		$url = "https://openapi.naver.com/v1/search/book.json?query=".$encText;

		$is_post = false;
	        $ch = curl_init();

       		curl_setopt($ch, CURLOPT_URL, $url);
        	curl_setopt($ch, CURLOPT_POST, $is_post);
        	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        	$headers = array();
        	$headers[] = "X-Naver-Client-Id: ".$client_id;
        	$headers[] = "X-Naver-Client-Secret: ".$client_secret;

        	curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);

        	$response = curl_exec ($ch);
        	$status_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);

		curl_close($ch);

		$result = json_decode($response, true);
		$total = $result[display];
	?>

		<p>검색어: <?php echo $key?> </p>
		<table>
		<tr>
			<th>번호</th>
			<th>제목</th>
			<th width=200>이미지</th>
			<th>저자</th>
		</tr>
	<?php
		//검색 된 책 출력 양식
        	$count = 0;
        	while($count < $total){
        	$img_src = $result[items][$count][image];

	?>      <tr>
                	<td><?php echo $count+1 ?></td>
                	<td><?php echo $result[items][$count][title];?></td>
                	<td><img src="<?php echo $img_src?>"></td>
			<td><?php echo $result[items][$count][author];?></td>
			<td>
				<form action="./write.php" method="get">
				<input type="hidden" name="type" value="0">
				<input type="hidden" name="isbn" value="<?php echo $result[items][$count][isbn];?>">
				<input type="submit" value="판매글 작성">
				</form>	
			
				<form action="./write.php" method="get">
				<input type="hidden" name="type" value="1">
				<input type="hidden" name="isbn" value="<?php echo $result[items][$count][isbn];?>">			
				<input type="submit" value="구매글 작성">
				</form>
			</td>
        	</tr>
	<?php
        	$count++;
        	}
	?>

        	</table>

			
</body>
</html>
