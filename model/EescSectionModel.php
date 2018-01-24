<?php
//*****************************************************************************
//	システム名　　　：共通DBAPI
//	サブシステム名　：
//	処理名　　　　　：EescSectionModel
//	作成日付・作成者：2018.01.19 newtouch
//	修正履歴　　　　：
//*****************************************************************************

require_once("./model/CommonModel.php");

/**
 * EescSectionModel
 */
class EescSectionModel extends CommonModel {

    public function getSectionList($conditions) {
        $SQL_USER_INFO = <<< SQL_USER_INFO
                SELECT 
                    T1.職制コード POST_CD
                    ,T1.簡略名 SECTION_NM
                    ,T1.会社コード COMPANY_CD
                    ,T1.会社名 COMPANY_NM
                FROM
                    EESC_SECTION T1 
                WHERE
                     T1.部課内細区分職制コード IS NULL
                    AND NVL(T1.変更区分,' ')!='3'
                    AND T1.会社コード IS NOT NULL
SQL_USER_INFO;

        if ($conditions['postCd'] != NULL) {
            $SQL_USER_INFO = $SQL_USER_INFO . " AND T1.職制コード LIKE " . "'%" . $conditions['postCd'] . "%' ";
        }

        if ($conditions['sectionNm'] != NULL) {
            $SQL_USER_INFO = $SQL_USER_INFO . " AND T1.簡略名 LIKE " . "'%" . $conditions['sectionNm'] . "%' ";
        }

        if ($conditions['companyNm'] != NULL) {
            $SQL_USER_INFO = $SQL_USER_INFO . " AND T1.会社名 LIKE " . "'%" . $conditions['companyNm'] . "%' ";
        }

        $MultiExecSql = new MultiExecSql();
        $sqlResult = array();
        $MultiExecSql->getResultData($SQL_USER_INFO, $sqlResult);
        return $sqlResult;
    }

}
