<?php

// JSON形式で出力するためにヘッダーを定義
header("Content-Type: application/json; charset=utf-8");

// To do 自分のレベルを$_POSTを使って入力処理で受け取るように変更する
$level = 300;//$_POST['level'];

// To do レベルを入力していなかった場合もしくは整数以外が入力されたら例外処理する
/*
if(empty($level)){
	throw new Exception("何も入力されていません");
}elseif(!is_int($level)){
	throw new Exception("不正な値です");
}
*/


// ユーザーリスト(ツッコミ感満載ｗ)
$user_lists= [
['name'=>'メイジン橋本','level'=>600,'synthetic_strength'=>99999,'main_job'=>'はっしーの最終定理','isKillerEquiped'=>true],
['name'=>'アレウス','level'=>160,'synthetic_strength'=>7600,'main_job'=>'結界破壊斬','isKillerEquiped'=>true],
['name'=>'カルチョス','level'=>177,'synthetic_strength'=>5031,'main_job'=>'神奏:エターナル・シンフォニー','isKillerEquiped'=>true],
['name'=>'lw_user','level'=>253,'synthetic_strength'=>6366,'main_job'=>'【英雄】業炎ノ天魔：カズサ','isKillerEquiped'=>true],
['name'=>'ルー','level'=>300,'synthetic_strength'=>8700,'main_job'=>'オーバブルシュート','isKillerEquiped'=>true],
];

	// 近くの冒険者((自分のLV -30)以上 かつ (自分のレベル + 5)以下)をJSON形式で出力
	foreach($user_lists as $key => $val){
		if(($level + 5) >= ($user_lists[$key]['level']) && ($level - 30) <= ($user_lists[$key]['level'])){
			echo json_encode($user_lists[$key],JSON_UNESCAPED_UNICODE);
		}
	}
?>

