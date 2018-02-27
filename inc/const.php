<?php

// Angularのコールバック関数名を格納しているインデックス
define('ANGULAR_CALLBACK_FUNCTION', 'callback');

// 関連インシデント　同一機場
define('RELATE_INCIDENT_TYPE_KIJO', '1');
// 関連インシデント　同一顧客名
define('RELATE_INCIDENT_TYPE_CUST', '2');

// 関連フラグ true : 関連有り、false : 関連無し
define('RELATE_FLG_ON', TRUE);
define('RELATE_FLG_OFF', FALSE);

// 変更履歴フラグ true : 変更履歴有り、false : 変更履歴無し
define('LOG_FLG_ON', TRUE);
define('LOG_FLG_OFF', FALSE);

//  異常結果　正常時 '0'
define('LOGIC_RESULT_SEIJOU', '0');
//  異常結果　SQLエラー '1'
define('LOGIC_RESULT_SQL_ERROR', '1');
//  異常結果　ファイルが見つからない '2'
define('LOGIC_RESULT_FILE_ERROR', '2');

// 登録と更新処理成功判定フラグ　true : 成功、false : 失敗
define('SAVE_TRUE', TRUE);
define('SAVE_FALSE', FALSE);

// インシデント関係者のデータ 有無のFlg   true : 有、false : 無し
define('RELATE_USER_FLG_TRUE', TRUE);
define('RELATE_USER_FLG_FALSE', FALSE);

// 新規作成
define('SINKI_SAKUSEI', '新規作成');
// 更新
define('KOUSINN', '更新');
// インシデント番号
define('INCIDENT_NO', 'インシデント番号');
// インシデントステータス
define('INCIDENT_STS', 'インシデントステータス');
// インシデント分類
define('INCIDENT_TYPE', 'インシデント分類');
// 親インシデント番号
define('PARENT_INCIDENT_NO', '親インシデント番号');
// 発生日時
define('INCIDENT_START_DATETIME', '発生日時');
// 情報提供元
define('INFO_SOURCE', '情報提供元');
// 情報提供者名
define('INFO_PROVIDER', '情報提供者名');
// 情報提供TEL
define('INFO_PROVIDER_TEL', '情報提供TEL');
// 注記
define('MEMO', '注記');
// 機場ID
define('KIJO_ID', '機場ID');
// 事業主体ID
define('JIGYOSYUTAI_ID', '事業主体ID');
// 設備ID
define('SETUBI_ID', '設備ID');
// 都道府県ID
define('PREF_ID', '都道府県ID');
// 都道府県名
define('PREF_NM', '都道府県名');
// 納入プロジェクト番号
define('DELIVERY_PJ_NO', '納入プロジェクト番号');
// 納入プロジェクト名
define('DELIVERY_PJ_NM', '納入プロジェクト名');
// 顧客ID
define('CUST_ID', '顧客ID');
// 顧客名
define('CUST_NM', '顧客名');
// 顧客分類CD
define('CUST_TYPE_CD', '顧客分類CD');
// 顧客分類名
define('CUST_TYPE_NM', '顧客分類名');
// 会社名・所属部署
define('CUST_DEPT', '会社名・所属部署');
// 依頼者名
define('REQUESTER', '依頼者名');
// 連絡先(TEL)
define('CONTACT_TEL', '連絡先(TEL)');
// 連絡先(FAX)
define('CONTACT_FAX', '連絡先(FAX)');
// 連絡先(E-mail)
define('CONTACT_MAIL', '連絡先(E-mail)');
// 営業部門コード
define('SALES_DEPT_CD', '営業部門コード');
// 営業部門名
define('SALES_DEPT_NM', '営業部門名');
// 営業担当者ID
define('SALES_USER_ID', '営業担当者ID');
// 営業担当者名
define('SALES_USER_NM', '営業担当者名');
// 主管部門コード
define('SKAN_DEPT_CD', '主管部門コード');
// 主管部門名
define('SKAN_DEPT_NM', '主管部門名');
// 主管担当者ID
define('SKAN_USER_ID', '主管担当者ID');
// 主管担当者名
define('SKAN_USER_NM', '主管担当者名');
// 受付開始時刻
define('CALL_START_DATE', '受付開始時刻');
// 受付終了時刻
define('CALL_END_DATE', '受付終了時刻');
// 受付部署コード
define('CALL_DEPT_CD', '受付部署コード');
// 受付部署名
define('CALL_DEPT_NM', '受付部署名');
// 受付者ID
define('CALL_USER_CD', '受付者ID');
// 受付者名
define('CALL_USER_NM', '受付者名');
// 受付電話番号
define('CALL_TEL', '受付電話番号');
// 受付メール
define('CALL_MAIL', '受付メール');
// 受付内容
define('CALL_CONTENT', '受付内容');
// 対応開始時刻
define('TAIO_START_DATE', '対応開始時刻');
// 対応終了時刻
define('TAIO_END_DATE', '対応終了時刻');
// 対応部署コード
define('TAIO_DEPT_CD', '対応部署コード');
// 対応部署名
define('TAIO_DEPT_NM', '対応部署名');
// 対応者ID
define('TAIO_USER_ID', '対応者ID');
// 対応者名
define('TAIO_USER_NM', '対応者名');
// 対応電話番号
define('TAIO_TEL', '対応電話番号');
// 対応メール
define('TAIO_MAIL', '対応メール');
// 対応内容
define('TAIO_CONTENT', '対応内容');
// 処置予定日
define('ACT_DATE', '処置予定日');
// 処置区分
define('ACT_TYPE', '処置区分');
// 処置開始日時
define('ACT_START_TIME', '処置開始日時');
// 処置終了日時
define('ACT_END_TIME', '処置終了日時');
// 処置部署コード
define('ACT_DEPT_CD', '処置部署コード');
// 処置部署名
define('ACT_DEPT_NM', '処置部署名');
// 処置者ID
define('ACT_USER_ID', '処置者ID');
// 処置者名
define('ACT_USER_NM', '処置者名');
// 処置電話番号
define('ACT_TEL', '処置電話番号');
// 処置メール
define('ACT_MAIL', '処置メール');
// 処置内容
define('ACT_CONTENT', '処置内容');
// 機種区分
define('PRODUCT_TYPE', '機種区分');
// 障害状況トリガー
define('PRODUCT_TRIGGER', '障害状況トリガー');
// 障害状況頻度
define('PRODUCT_HINDO', '障害状況頻度');
// 障害状況現象
define('PRODUCT_GENSYO', '障害状況現象');
// 障害状況状態
define('PRODUCT_STATUS', '障害状況状態');

// 変更履歴に値を表示する項目
define('CHANGE_LOG_VALUE_DSP_ITEM',
serialize(array(
    'KIJO_NM' => '機場名', // 機場名
    'JIGYOSYUTAI_NM' => '事業主体名', // 事業主体名
    'SETUBI_NM' => '設備名'  // 設備名
)));

// インシデントステータス名
define('INCIDENT_STS_NAME',
serialize(array(
    '1' => '受付済',
    '2' => '対応入力済',
    '3' => '処置入力済'
)));

// インシデント分類名
define('INCIDENT_TYPE_NAME',
serialize(array(
    '1' => '障害',
    '2' => '事故',
    '3' => '問合せ',
    '4' => 'クレーム',
    '5' => '情報',
    '6' => 'その他'
)));

// 情報提供元名
define('INCIDENT_INFO_SOURCE',
serialize(array(
    '1' => '顧客',
    '2' => '特約店',
    '3' => '営業',
    '4' => '技術',
    '5' => 'その他'
)));

// 費用決裁申請分類名
define('HIYO_KESSAI_TYPE_NAME_SHOUGAI','障害対応');
define('HIYO_KESSAI_TYPE_NAME_CLAME','クレーム対応');

