<!DOCTYPE html>
<html>
<head>
	<meta charset='utf-8'>
	<link rel="stylesheet" type="text/css" href="skeleton.css">
	<script src="javascript.js"></script>
</head>
<body>

	<?php
		$type = $_GET[type];
		$connect = mysqli_connect('localhost', 'tnwjd4623' ,'1q2w3e4r', 'tnwjd4623') or die ("fail");
		session_start();
		$number = $_GET[number];
		$str;
		$query;
		$URL;

		$comment_query;
	
		//판매 글 일 때
		if($type==0) {
			$str = "판매 책 정보";
			$URL = "./sell.php";
			$query = "update board_sell set hit = hit+1 where number =$number";
			$comment_query = "select * from comment_sell where board_number=$number order by number asc";
		
			$connect->query($query);
			$query = "select title, content, date, hit, id, isbn from board_sell where number =$number";
			
		}

		//구매 글 일 때
		else if($type==1) {
			$str = "구매 책 정보";
			$URL = "./buy.php";
			$query = "update board_buy set hit = hit+1 where number =$number";
			$comment_query = "select * from comment_buy where board_number=$number order by number asc";

			$connect->query($query);
			$query = "select title, content, date, hit, id, isbn from board_buy where number =$number";
		}

		$result = $connect->query($query);
		$rows = mysqli_fetch_assoc($result);
		$isbn = $rows['isbn'];

		$comment_result = $connect->query($comment_query);
		$comment_total = mysqli_num_rows($result);
		
	

		//등록한 책 정보 
       		$client_id = "SFezXsTn6ehQdzFHwwp7";
        	$client_secret = "KzKrnNFNu_";
        	$encText = urlencode("'$isbn'");
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

		$json = json_decode($response, true);

		$book_title =  $json[items][0][title];		
		$book_author = $json[items][0][author];
		$book_img = $json[items][0][image];
		$book_price = $json[items][0][price];


	?>

	<!-- 게시 물 출력 -->
	<table class="view_table" align=center>
	<tr>
		<td colspan="4" class="view_title"><?php echo $rows['title']?></td>
	</tr>
	<tr>
		<td class="view_id">작성자</td>
		<td class="view_id2"><?php echo $rows['id']?></td>
		<td class="view_hit">조회수</td>
		<td class="view_hit2"><?php echo $rows['hit']?></td>
	</tr>

	
	<tr>
		<td colspan="4" class="view_content" valign="top">
		<div align="top"class="view_text"><?php echo $str;?></div>
		<div class="view_info">
		<span><img src="<?php echo $book_img; ?>" align="left">
		<br/><br/>
		<span class="view_text2">제목:</span> <?php echo $book_title;?><br/>
		<span class="view_text2">저자:</span> <?php echo $book_author;?><br />
		<span class="view_text2">정가:</span> <?php echo $book_price;?>
		</div>
		<br/><br/>
		<?php echo $rows['content']?></td>
	</tr>
	</table>

	<!-- 목록, 수정, 삭제 버튼 -->
	<div class="view_btn">
		<button class="view_btn1" onclick="location.href='<?php echo $URL;?>'">목록으로</button>
		<button class="view_btn1" onclick="location.href='./modify.php?type=<?=$type?>&number=<?=$number?>&id=<?=$_SESSION['userid']?>'">수정</button>

		<button class="view_btn1" onclick="location.href='./delete.php?type=<?=$type?>&number=<?=$number?>&id=<?=$_SESSION['userid']?>'">삭제</button>
	</div>

	<!-- 댓글 입력 란 / 세션이 존재햐아 등록 가능 -->
	<div class="view_comment_input">
		<span class="view_text3">이름</span><span class="view_text4">댓글</span><br/>
	<?php	if(!isset($_SESSION['userid']))
		{
	?>	<p>로그인 후 댓글을 작성할 수 있습니다.<span class="view_login" onclick="modal()">로그인하기</span></p>
		<div id="modal" class="modal">
			<div id="modal-content" class="modal-content">
			<button id="Close" class="close" onclick="close_modal()">X</button>
			<span> Login </span><br/><br/>
			<form method="get" action="login.php">
			<span class="main_text2">ID:</span><input name="id" class="main_input" type="text"><br/>
			<span class="main_text2">PW:</span><input name="pw" class="main_input" type="password">
			<br/><br/>
			<input class="modal-content-button" type="submit" value="Login">
			</form>
			</div>
		</div>
	<?php 	}
		else {
		
	?>	
		<!-- 세션이 존재한다면 댓글 폼 활성화 -->
		<form method="get" action="comment_action.php">
		<span class="view_com_id"><?=$_SESSION['userid']?></span>
		<input type="hidden" name="id" value="<?=$_SESSION['userid']?>">
	
		<input class="view_comment"type="text" name="comment" placeholder="댓글을 입력해주세요">
		<input type="hidden" name="number" value="<?=$number?>">
		<input type="hidden" name="parent" value=0>
		<input type="hidden" name="type" value="<?=$type?>">
		<input type="submit" value="작성">
		</form>

		<p>------------------------------------------------------------------------------</p>
	<?php	}
		$count=0;

		//댓글 출력
		while($comment_rows=mysqli_fetch_assoc($comment_result)) {

		if($comment_rows['parent_number']==0) {
	?>	
		<span class="view_text3"><?=$comment_rows['id']?></span>
		<span class="view_text4"><?=$comment_rows['content']?></span>
		<span class="view_text5"><?=$comment_rows['date']?></span>
	<?php		
	
			if(!isset($_SESSION['userid'])){
			}
			else{
	?>		<button class="comment_btn" onclick="comment('<?=$count?>')">댓글달기</button>
			<div id="hide_comment<?=$count?>"class="hide_comment">
			<form method = "get" action="comment_action.php">
			<span class="view_com_id">re: <?=$_SESSION['userid']?></span>
			<input type="hidden" name="id" value="<?=$_SESSION['userid']?>">
			<input class="view_comment" type="text" name="comment" placeholder="댓글을 입력해주세요">
			<input type="hidden" name="number" value="<?=$number?>">
			<input type="hidden" name="parent" value="<?=$comment_rows['number']?>">
			<input type="hidden" name="type" value="<?=$type?>">
			<input type="submit" value="작성">
			</form>
			
			<button onclick="comment_close('<?=$count?>')">취소</button>
			</div>
			<br/>
	<?php		}

		//대댓글 출력
		$child;
		$parent = $comment_rows['number'];

		if($type==0){
			$child = "select * from comment_sell where parent_number=$parent order by number asc";
		}
		else if($type==1) {
			$child = "select * from comment_buy where parent_number=$parent order by number asc";
		}
		$parent = $comment_rows['number'];
		$child_result = $connect->query($child);

		while($child_rows=mysqli_fetch_assoc($child_result)) {
	?>		
			<br/>
			<span class="view_text3_child"> RE: <?=$child_rows['id']?></span>
			<span class="view_text4"><?=$child_rows['content']?></span>
			<span class="view_text5"><?=$child_rows['date']?></span>
	<?php	}
	?>
		<br/>
	<?php
		}
		$count++;
	}
	?>
	</div>

</body>
</html>

