<?php

// JSON形式で出力するためにヘッダーを定義
header("Content-Type: application/json; charset=utf-8");

// To do 自分のレベルを$_POSTを使って入力処理で受け取るように変更する
$level = 630;//$_POST['level'];

// To do レベルを入力していなかった場合もしくは整数以外が入力されたら例外処理する
/*
if(empty($level)){
    throw new Exception("何も入力されていません");
}elseif(!is_int($level)){
    throw new Exception("不正な値です");
}
*/

// MySQLコネクション設定
$servername = getenv('IP');
$username = getenv('C9_USER');
$password = "*****";// 伏せてあります！m(_ _)m
$database= "lw_sample_db";
$dbport = 3306;

// MySQLコネクション作成
$db = new mysqli($servername, $username, $password, $database, $dbport);

// MySQLコネクションチェック
if ($db->connect_error) {
    die("Connection failed: " . $db->connect_error);
}
//   echo "Connected successfully (".$db->host_info.")";


// MySQLサーバーに接続
$conn = mysql_connect("localhost", "calchos", "2txxMI5i");

// MySQL サーバーに接続できない場合の処理
if (!$conn) {
    echo "Unable to connect to DB: " . mysql_error();
    exit;
}
// mysqlデータベースが選択できない場合の処理
if (!mysql_select_db('lw_sample_db')) {
    echo "Unable to select lw_sample_db: " . mysql_error();
    exit;
}

// MySQL文字コード設定
mysql_set_charset('utf8');

// ユーザーリスト(ツッコミ感満載ｗ)をlw_sample_dbのuser_listsテーブルから取得
$sql = 'SELECT * FROM user_lists';

// MySQLクエリ送信
$sql_results = mysql_query($sql);

// MySQLクエリが見つからない場合の処理
if (!$sql_results) {
    echo "Could not successfully run query ($sql) from DB: " . mysql_error();
    exit;
}

// $sql_resultsにおける行の数を得られない場合の処理
if(mysql_num_rows($sql_results) == 0){
    echo "No rows found, nothing to proint so am exiting";
    exit;
}

// 近くの冒険者((自分のLV -30)以上 かつ (自分のレベル + 5)以下)をJSON形式で出力
// *注意* PHP5.5.0では非推奨になっている…。
// cf. http://qiita.com/fantm21/items/891192da1a095e94c9e1
while($rows = mysql_fetch_array($sql_results,MYSQL_ASSOC)){
        if(($level + 5) >= ($rows['level']) && ($level - 30) <= ($rows['level'])){
            $user_lists[]=array(
            'name'=>$rows['name'],
            'level'=>$rows['level'],
            'synthetic_strength'=>$rows['synthetic_strength'],
            'mainjob'=>$rows['mainjob'],
            'isKillerEquiped'=>$rows['isKillerEquiped']
            );
    }
}

echo json_encode($user_lists,JSON_UNESCAPED_UNICODE);

// 結果保持用メモリの解放
mysql_free_result($sql_results);

?>