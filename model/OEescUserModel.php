<?php
//*****************************************************************************
//	システム名　　　：共通DBAPI
//	サブシステム名　：
//	処理名　　　　　：OEescUserModel
//	作成日付・作成者：2018.02.22 ADF)S.Yoshida
//	修正履歴　　　　：
//*****************************************************************************

require_once("./model/CommonModel.php");

class OEescUserModel extends CommonModel {

    public function getUser($userId) {
        $SQL_USER_INFO = <<< SQL_USER_INFO
                SELECT 
                    EU.従業員ＮＯ USER_ID,
                    EU.氏名＿漢字 USER_NM,
                    EU.メールアドレス MAIL,
                    EU.職位コード１ POST_CD,
                    EU.職位名１ POST_NM,
                    EU.所属職制コード１ SECTION_CD,
                    EU.所属職制簡略名１ SECTION_NM
                FROM
                    EESC_USER EU 
                    LEFT JOIN EESC_SECTION ES ON EU.所属職制コード１ = ES.職制コード
                WHERE
                    NVL(EU.異動区分,' ')!='3'
                AND EU.従業員ＮＯ = '$userId'
                AND ES.職務コード != 'S'
SQL_USER_INFO;

        $MultiExecSql = new MultiExecSql();
        $sqlResult = array();
        $MultiExecSql->getResultData($SQL_USER_INFO, $sqlResult);
        return $sqlResult;
    }

    public function getUserList($conditions) {
        $SQL_USER_INFO = <<< SQL_USER_INFO
                SELECT 
                    EU.従業員ＮＯ USER_ID,
                    EU.氏名＿漢字 USER_NM,
                    EU.メールアドレス MAIL,
                    EU.職位コード１ POST_CD,
                    EU.職位名１ POST_NM,
                    EU.所属職制コード１ SECTION_CD,
                    EU.所属職制簡略名１ SECTION_NM
                FROM
                    EESC_USER EU 
                    LEFT JOIN EESC_SECTION ES ON EU.所属職制コード１ = ES.職制コード
                WHERE
                    NVL(EU.異動区分,' ')!='3'
                AND ES.職務コード != 'S'
SQL_USER_INFO;

        if ($conditions['userNmSei'] != NULL) {
            $SQL_USER_INFO = $SQL_USER_INFO . " AND " . CMN_MakeLikeCond(" " . "EU.氏名＿漢字", $conditions['userNmSei'], "", "%") . " ";
        }

        if ($conditions['userNmMei'] != NULL) {
            $SQL_USER_INFO = $SQL_USER_INFO . " AND " . CMN_MakeLikeCond(" " . "EU.氏名＿漢字", $conditions['userNmMei'], "%", "%") . " ";
        }

        if ($conditions['sectionCd'] != NULL) {
            $SQL_USER_INFO = $SQL_USER_INFO . " AND " . CMN_MakeLikeCond(" " . "EU.所属職制コード１", $conditions['sectionCd'], "%", "%") . " ";
        }

        if ($conditions['sectionNm'] != NULL) {
            $SQL_USER_INFO = $SQL_USER_INFO . " AND " . CMN_MakeLikeCond(" " . "EU.所属職制簡略名１", $conditions['sectionNm'], "%", "%") . " ";
        }

        $MultiExecSql = new MultiExecSql();
        $sqlResult = array();
        $MultiExecSql->getResultData($SQL_USER_INFO, $sqlResult);
        return $sqlResult;

//      $html = "";
//      $arr = array();
//
//      $tpl = new ExecTemplate($html, $SQL_USER_INFO);
//      $tpl->setResultDataArray($arr);
//      $tpl->getResult(1, 50);// ページング
//      return $arr;
    }

}
