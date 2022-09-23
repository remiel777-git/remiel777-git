// sexy.pe.kr/tc/30 | archive.org로 가면 나오는 페이징 그러나 좀 직접 추가 하고 많이 뜯어 고친 페이징.
<?php
include("connect.php");
$block_per_page=3;  // 너무 많이 주면... 문제가 됨. 버튼링크 갯수. 설정값대로 뿌려줌.. 10개로 설정하면. 1~10 
$page_per_record=5;   
@$page=$_REQUEST['page']; // 어쩔수 없음..따지기 잘하기 증세 생기면 방법이 없음. @붙이는 수밖에.. $_GET으로 해도... No답
if( !intval($page) || $page == false || $page == null)  { $page=1; }
else {	$page=preg_replace('#[^0-9]#','',$_REQUEST['page']);}  $_GET 대신 $_REQUEST. 문자열 거의 불능[포기가 빠름. 되는 경우가 이해가 안갈정도로 힘듬] 

$count_check="select count(tbl_number) as total_pst from board";
$sql_query=mysqli_query($connect,$count_check);
$total_record=mysqli_fetch_assoc($sql_query);
$sql_cnt=stripslashes($total_record['total_pst']); // 전체글
$total_page=ceil($sql_cnt/ $page_per_record);  // 전체페이지
$total_block=ceil($total_page / $block_per_page); // 전체 블록 수
$now_block=ceil($page/$block_per_page); 
$start_record=intval(($page -1) * $page_per_record); 
if($start_record < 1) { $start_record=0;}
else {$start_record=$start_record;}
$start_page=intval(($now_block -1) * $block_per_page)+1; 
$end_page=intval($start_page + $block_per_page)-1;
if($end_page <= $total_page) {$end_page == $total_page;}
$info_sql="select * from board limit $start_record, $page_per_record";
$result=mysqli_query($connect,$info_sql);
while() {}

// 여기서부터 중요 핵심 소스 추가로 직접 작성해서 투입 들어간 부분 포함. 
$next_page=$page+1;
$prev_page=$page-1;

if($page == 1 && $total_page < 1) {  // &&문구가 맞는지 || 문구가 맞는지....  모르겠음.. 다시보니.
//echo "[FirstPage_Only]";
}


if($page > 1 )  { // 2페이지 이상일 경우 
echo "<a href=?page=1>[First]</a>";
echo "<a href=?page=$prev_page>[Prev]</a>";}

#if($start_page <= $total_page){} 주석친것: 삭제해도 무방해도 상관 없어보임.
	
for($i=$start_page;$i<=$end_page;$i++) {
if($page-1 < 1) {} // -값페이징 : -1 -2 -3 -4 -5 .... 차단.
if($page+1>$total_page) {} // 현재 페이지에 1을 더해서 결과값이 총페이지값보다 클경우, 아닐경우 for구문 페이징을 한다
else { 	
 	echo "<a href=?page=$i>[$i]</a>";
  }
}
if($now_block+1 >$total_block) {} // 41번 라인과 뜻은 같음 / 현재 블록에 1더한값이 총 블록을 넘으면 처리 없음
elseif(($now_block <=$total_block) ) { // 현재 블록이 최대블록보다 작을경우
echo "<a href=?page=$next_page>[Next]</a>"; // 다음페이지 링크
echo "<a href=?page=$total_page>[Last]</a>"; // 마지막 페이지 링크 , 적어도 상관이 없을듯..[소스상 작동링크에 문제없어 보일듯] 
}
else{} 
if($total_page <$page+1) {} // 41 , 45라인 개념같음. 현재 페이지에 1더한값이 총페이값보다 크면 처리 없음.
if($total_page >=$page) { // 임의 페이지값 넣을때 최대 페이지값 보다 작을경우 
echo "<a href=?page=1>[First]</a>"; // 1페이지,마지막페이지 링크로 처리
echo "<a href=?page=$total_page>[Last]</a>"; // 최대페이지
} 
else{}
?>
