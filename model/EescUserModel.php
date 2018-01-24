<?php
//*****************************************************************************
//	システム名　　　：共通DBAPI
//	サブシステム名　：
//	処理名　　　　　：EescUserModel
//	作成日付・作成者：2018.01.09 ADF)S.Yoshida
//	修正履歴　　　　：
//*****************************************************************************

require_once("./model/CommonModel.php");

class EescUserModel extends CommonModel {

    public function getUserList($conditions) {
        $SQL_USER_INFO = <<< SQL_USER_INFO
                SELECT 
                    T1.従業員ＮＯ USER_ID,
                    T1.氏名＿漢字 USER_NM,
                    T1.メールアドレス MAIL,
                    T1.職位コード１ POST_CD,
                    T1.職位名１ POST_NM,
                    T1.所属職制コード１ SECTION_CD,
                    T1.所属職制簡略名１ SECTION_NM
                FROM
                    EESC_USER T1 
                WHERE
                    NVL(T1.異動区分,' ')!='3'
SQL_USER_INFO;

        if ($conditions['userNmSei'] != NULL) {
            $SQL_USER_INFO = $SQL_USER_INFO . " AND T1.氏名＿漢字 LIKE " . "'" . $conditions['userNmSei'] . "%' ";
        }
        
        if ($conditions['userNmMei'] != NULL) {
            $SQL_USER_INFO = $SQL_USER_INFO . " AND T1.氏名＿漢字 LIKE " . "'%" . $conditions['userNmMei'] . "%' ";
        }

        if ($conditions['sectionCd'] != NULL) {
            $SQL_USER_INFO = $SQL_USER_INFO . " AND T1.所属職制コード１ LIKE " . "'%" . $conditions['sectionCd'] . "%' ";
        }

        if ($conditions['sectionNm'] != NULL) {
            $SQL_USER_INFO = $SQL_USER_INFO . " AND T1.所属職制簡略名１ LIKE " . "'%" . $conditions['sectionNm'] . "%' ";
        }

        $MultiExecSql = new MultiExecSql();
        $sqlResult = array();
        $MultiExecSql->getResultData($SQL_USER_INFO, $sqlResult);
        return $sqlResult;
    }
    
}
