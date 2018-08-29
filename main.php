<!DOCTYPE html>
<html>
<head>
	<link rel="stylesheet" type="text/css" href="skeleton.css">
	<script src="javascript.js"></script>
	<script src="http://code.jquery.com/jquery-1.10.2.js"></script>
	<meta charset = 'utf-8'>
</head>
<body>
	<?php
		$connect = mysqli_connect('localhost', 'tnwjd4623', '1q2w3e4r', 'tnwjd4623') or die ('connect fail');
		
		//최신글 출력을 위한 구매 게시판, 판매 게시판 쿼리
		$buy_query = "select * from board_buy order by number desc";
		$sell_query = "select * from board_sell order by number desc";

		$buy_result = $connect->query($buy_query);
		$sell_result = $connect->query($sell_query);
		
		$buy_total = mysqli_num_rows($buy_result);
		$sell_total = mysqli_num_rows($sell_result);

		$list = "select * from list where number=1";
		$list_result = $connect->query($list);

		$list_rows = mysqli_fetch_assoc($list_result);
		$list_isbn = $list_rows['isbn'];

		//네이버 API 호출 

                $client_id = "SFezXsTn6ehQdzFHwwp7";	//발급 받은 id
                $client_secret = "KzKrnNFNu_";		//발급 받은 비밀 번호
                $encText = urlencode($list_isbn);

		//네이버 요청 쿼리
                $url = "https://openapi.naver.com/v1/search/book.json?query=".$encText;	

                $is_post = false;
                $ch = curl_init();

		/*
			접속할 url, 전송 메소드, 리턴 유무 옵션 세팅
		*/
                curl_setopt($ch, CURLOPT_URL, $url);
                curl_setopt($ch, CURLOPT_POST, $is_post);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

                $headers = array();
                $headers[] = "X-Naver-Client-Id: ".$client_id;
                $headers[] = "X-Naver-Client-Secret: ".$client_secret;

		/*
			헤더 짖정, 인증서 검사 유무 세팅
		*/
                curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);

		/*
			exec 실행
		*/
                $response = curl_exec ($ch);
                $status_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);

                curl_close($ch);

                $result = json_decode($response, true);
		$img = $result[items][0][image];

	?>
	<header>
		<div class="main_header">
			<ul class="main_ul">
			<li class="main_li"><img class="main_img" src="./book.PNG"></li>
			<li class="main_li"><span class="main_text">webprogramming term proejct 2 <br/>201602042</span></li>
			</ul>

		</div>
		<!-- 클릭시 페이지 이동-->
		<div class="main_top">
			<ul class="main_ul2">
			<li class="main_li2" onclick="location.href='./sell.php'">Sell</li>
			<li class="main_li2" onclick="location.href='./buy.php'">Buy</li>
			<li class="main_li2" onclick="modal2()">책 추천</li>
			</ul>	
		</div>
	</header>
	
	<!-- 회원가입 모달 창-->
	<div class="modal" id="modal">
		<div id="modal-content" class="modal-content">
		<button id="Close" class="close" onclick="close_modal()">X</button>
		<span> Join </span><br/>
		<form method="get" action="join.php">
		<span class="main_text2">Mail: </span><input name="email" class="main_input_email" type="email"><br/><br/>
		<span class="main_text2">ID: </span><input name="id"class="main_input" type="text"><br/><br/>
		<span class="main_text2">PW: </span><input name="pw"class="main_input" type ="password">
		<br/><br/>
		<input class="modal-content-button"type="submit" value="Join">
		</form>
		</div>

	</div>

	<!-- 책 추천 코달창 -->
	<div class="modal2" id="modal2">
		<div id="modal-content2" class="modal-content2">
		<button id="Close2" class="close" onclick="close_modal2()">X</button>
		<span> 랜덤 책추천 </span><br/>
		<span><b>제목 :</b> <?=$list_rows['title'];?></span><br/>
		<span><b>저자 :</b> <?=$result[items][0][author];?></span><br/><br/>
		<span><img src="<?=$img?>" width="100" height="200"></span>
		<span class="recommand"><?=$list_rows['content']?></span>
		<iframe class="frame"width="500" height="400" src="<?=$list_rows['url'];?>" frameborder="0"></iframe>
		</div>
	</div>
<?php 
	//세션이 있으면 로그아웃, 세션이 없으면 로그인 폼 출력
	session_start();
	if(!isset($_SESSION['userid']))
	{
?>
	<!--로그인 폼 -->
	<div class="main_login">
		<span>Log in</span>
		<form method = "get" action="login.php">
		<span class="main_text2">ID: </span><input name="id" class="main_input" type="text"><br/>
		<span class="main_text2">PW: </span><input name="pw"class="main_input" type = "password"><br/>
		<input type="submit" value="login">
		</form>
		<br/><br/>
		<span>회원이 아니신가요?</span>
		<button id="join" onclick="modal()">Join</button>
	</div>
<?php	}

	else {
?>
	<!--로그인 성공시 -->
		<div class="main_login">
		<span>안녕하세요  
		<?=$_SESSION['userid']?>님</span>
		<button id="logout" onclick="location.href='./logout.php'">로그아웃</button>	

		</div>
<?php	}
?>

	<!-- 최신 판매, 구매 글-->
	<div class="main_wrap">
		<ul class="main_ul3">
		<li class="main_li3">
		<div class="main_new">
			최신 판매글
			<table class="main_table">
		<?php	$total = 1;
			if($sell_total > 5){ //글은 최대 5개까지 보여진다
				while($rows = mysqli_fetch_assoc($sell_result)) {
					if($total>5) break;
					

					if($total%2==0) {
		?>				<tr class="main_tr_even">
		<?php			}
					else {
		?>				<tr>
		<?php			}
		?>	<td class="main_td"><a href='./view.php?type=0&number=<?php echo $rows['number'];?>'><?php echo $rows['title']?></a></td>
			<td class="main_td"><span class="main_date"><?php echo $rows['date'];?></span></td>		
	
			</tr>	
	
		<?php			$total++;
						
				}
			}

			else {
				while($rows = mysqli_fetch_assoc($sell_result)) {
				if($total%2==0) {
		?>			<tr class="main_tr_even">
		<?php		}
				else {
		?>			<tr>
		<?php		}
		?>
				<td class="main_td"><a href="./view.php?type=0&number=<?php echo $rows['number'];?>"><?php echo $rows['title']?></a></td>
				<td class="main_td"><span class="main_date"><?php echo $rows['date'];?></span></td>
				</tr>			
		<?php		$total++;
				}
			}
		?>
			</table>
		</div>
		</li>
		<li class="main_li3">
		<div class="main_new">
			 최신 구매글
			<table class="main_table">
                <?php   $total = 1;
                        if($buy_total > 5){
                                while($rows = mysqli_fetch_assoc($buy_result)) {
                                        if($total>5) break;

	
					if($total%2==0){
		?>				<tr class="main_tr_even">
		<?php			}	
                                        else {
                ?>                              <tr>
                <?php                   }
                ?>      <td><a href='./view.php?type=1&number=<?php echo $rows['number'];?>'><?php echo $rows['title']?></a></td>
                        <td class="main_td"><span class="main_date"><?php echo $rows['date'];?></span></td>            
        
                        </tr>   
        
                <?php                   $total++;
                                                
                                }
                        }

                        else {
                                while($rows = mysqli_fetch_assoc($buy_result)) {

				if($total%2==0){
		?>			<tr class="main_tr_even">
		<?php		}
				else{
                ?>  		            <tr>
		<?php		}
		?>
                                <td class="main_td"><a href="./view.php?type=1&number=<?php echo $rows['number'];?>"><?php echo $rows['title']?></a></td>
                                <td class="main_td"><span class="main_date"><?php echo $rows['date'];?></span></td>
                                </tr>                   
                <?php           $total++;
				}
                        }
                ?>
                        </table>

			
		</div>	
		</li>
	</div>

</body>
</html>
