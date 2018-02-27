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
        $SQL_INFO = <<< SQL_INFO
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
                    AND NVL(T1.職務コード,' ')  != 'S'
SQL_INFO;

        if ($conditions['postCd'] != NULL) {
            $SQL_INFO = $SQL_INFO . " AND " . CMN_MakeLikeCond(" " . "T1.職制コード", $conditions['postCd'], "%", "%") . " ";
        }

        if ($conditions['sectionNm'] != NULL) {
            $SQL_INFO = $SQL_INFO . " AND " . CMN_MakeLikeCond(" " . "T1.簡略名", $conditions['sectionNm'], "%", "%") . " ";
        }

        if ($conditions['companyNm'] != NULL) {
            $SQL_INFO = $SQL_INFO . " AND " . CMN_MakeLikeCond(" " . "T1.会社名", $conditions['companyNm'], "%", "%") . " ";
        }

        $SQL_INFO = $SQL_INFO . " ORDER BY DECODE( RTRIM('T1.職制コード'), NULL, RTRIM('T1.会社コード'), RTRIM('T1.職制コード') ) ";
        
        $html = "";
        $arr = array();

        $tpl = new ExecTemplate($html, $SQL_INFO);
        $tpl->setResultDataArray($arr);
        if ($conditions['pagingStart'] != NULL && $conditions['pagingEnd'] != NULL) {
            $tpl->getResult($conditions['pagingStart'], $conditions['pagingEnd']); // ページング
        } else {
            $tpl->getResult(); // ページング無し
        }
        return $arr;
    }

    public function getSectionListCount($conditions){
                $SQL_INFO = <<< SQL_INFO
                SELECT 
                    count(*) COUNT
                FROM
                    EESC_SECTION T1 
                WHERE
                     T1.部課内細区分職制コード IS NULL
                    AND NVL(T1.変更区分,' ')!='3'
                    AND T1.会社コード IS NOT NULL
                    AND NVL(T1.職務コード,' ')  != 'S'
SQL_INFO;

        if ($conditions['postCd'] != NULL) {
            $SQL_INFO = $SQL_INFO . " AND " . CMN_MakeLikeCond(" " . "T1.職制コード", $conditions['postCd'], "%", "%") . " ";
        }

        if ($conditions['sectionNm'] != NULL) {
            $SQL_INFO = $SQL_INFO . " AND " . CMN_MakeLikeCond(" " . "T1.簡略名", $conditions['sectionNm'], "%", "%") . " ";
        }

        if ($conditions['companyNm'] != NULL) {
            $SQL_INFO = $SQL_INFO . " AND " . CMN_MakeLikeCond(" " . "T1.会社名", $conditions['companyNm'], "%", "%") . " ";
        }

        $html = "";
        $arr = array();

        $tpl = new ExecTemplate($html, $SQL_INFO);
        $tpl->setResultDataArray($arr);
        $tpl->getResult(); // ページング無し
        return $arr[0];
    }
}
