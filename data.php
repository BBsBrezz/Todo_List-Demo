<?php
include('../db.php');

try {
	// 字串中間的ARRAY不用引號 但是第二第三為參數 需要加上引號
	$pdo = new PDO("mysql:host=$db[host];dbname=$db[dbname];port=$db[port];charset=$db[charset]", $db['username'], $db['password']);
}catch (PDOException $e) {
	echo "Database connection failed.";
	exit;
}

// 把todos table資料全部撈出來存在變數todos裡
$sql = 'SELECT * FROM todos ORDER BY `order` ASC'; //遞減排序
$statement = $pdo->prepare($sql);
$statement->execute();
$todos = $statement->fetchAll(PDO::FETCH_ASSOC);
?>

<script>
	//把PHP格式轉成json丟到前端 JS才看得懂
	//JSON_NUMERIC_CHECK: 資料庫內像is_complete 跟 order 是INT型別 不希望被轉換成STRING丟回前端
  var todos = <?= json_encode($todos, JSON_NUMERIC_CHECK)?> 
</script>