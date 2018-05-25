<?php
// 回傳的是json的型態
header('content-Type: application/json; charset=utf_8');
include('../../db.php');
// display_errors 預設為 On，當執行php網頁發生錯誤時，會將錯誤、警告訊息顯示在網頁上
ini_set('display_errors', '1');

try {
	// 字串中間的ARRAY不用引號 但是第二第三為參數 需要加上引號
	$pdo = new PDO("mysql:host=$db[host];dbname=$db[dbname];port=$db[port];charset=$db[charset]", $db['username'], $db['password']);
} catch (PDOException $e) {
	echo "Database connection failed.";
	exit;
}

$sql = 'UPDATE todos SET content=:content WHERE id=:id';
$statement = $pdo->prepare($sql);
$statement->bindValue(':content', $_POST['content'], PDO::PARAM_STR);
$statement->bindValue(':id', $_POST['id'], PDO::PARAM_INT);
$result = $statement->execute();

//回傳ID給前端 以json的格式
if (!$result) {
	echo 'error';
}