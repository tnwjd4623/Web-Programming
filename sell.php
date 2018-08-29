<!DOCTYPE html>
<html>
<head>
	<meta charset='utf-8'>
	<link rel="stylesheet" type="text/css" href="board.css?ver=1">
	<script src="search.js"></script>
</head>
<body>

	<?php
		
		$connect = mysqli_connect('localhost', 'tnwjd4623', '1q2w3e4r', 'tnwjd4623') or die ("connect fail");
		$query = "select * from board_sell order by number desc";
		$result = $connect->query($query);
		$total = mysqli_num_rows($result);
		session_start();
	?>
	<header>
		<p class="header"> 책 판매 게시판</p>
	
	</header>

	<section>
	<table align=center>
	<thead>
		<tr>
		<td width="50">번호</td>
		<td width="500">제목</td>
		<td width="100">작성자</td>
		<td width="200">날짜</td>
		<td width="50">조회수</td>
		</tr>
	</thead>
	<tbody>
	<?php
		//DB에 저장된 글 수만큼 출력 
		while($rows = mysqli_fetch_assoc($result)) {
			if($total%2==0){
	?>			<tr class ="even">
	<?php		}
			else{
	?>			<tr>
	<?php		}
	?>	
		<td width="50"><?php echo $total?></td>
		<td width="500"><a href="./view.php?type=0&number=<?php echo $rows['number'];?>"><?php echo $rows['title']?></a></td>
		<td width="100"><?php echo $rows['id']?></td>
		<td width="200"><?php echo $rows['date']?></td>
		<td width="50"><?php echo $rows['hit']?></td>
		</tr>
	<?php
		$total--;
		}
	?>
	</tbody>
	</table>
	<div class="write">
		<div class="box">
		<span class="text" onClick="location.href='./search_book.php'">책 판매하기</span>
		</div>
			
		<div class="box">
		<span class="text" onClick="location.href='./main.php'">메인으로</span>
		</div>
		
		<div class="box">
		<span class="text" onClick="location.href='./search_board.php'">글 검색</span>
		</div>
	</div>
	</section>
</body>
</html>
