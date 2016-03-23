<?php

// JSON形式で出力するためにヘッダーを定義
header("Content-Type: application/json; charset=utf-8");

// To do 自分のレベルを$_POSTを使って入力処理で受け取るように変更する⇛弄っていないので対応できるか確認
$level = 172;//$_POST['level'];

// To do レベルを入力していなかった場合もしくは整数以外が入力されたら例外処理する⇛弄っていないので対応できるか確認
/*
if(empty($level)){
    throw new Exception("何も入力されていません");
}elseif(!is_int($level)){
    throw new Exception("不正な値です");
}
*/

// PDOでMySQLに接続
try {
$pdo = new PDO('mysql:host=127.0.0.1;dbname=lw_sample_db;charset=utf8','calchos','*****');
} catch (PDOException $e) {
 exit('データベース接続失敗。'.$e->getMessage());
}

// ユーザーリスト(ツッコミ感満載ｗ)をlw_sample_dbのuser_listsテーブルから取得
$stmt = $pdo->query("SELECT * FROM user_lists");

// 近くの冒険者((自分のLV -30)以上 かつ (自分のレベル + 5)以下)をJSON形式で出力
// *注意* PHP5.5.0では非推奨になっている…。
// cf. http://qiita.com/fantm21/items/891192da1a095e94c9e1
while($rows = $stmt->fetch(PDO::FETCH_ASSOC)){
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

?>