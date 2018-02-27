<?php
//*****************************************************************************
//	システム名　　　：共通DBAPI
//	サブシステム名　：
//	処理名　　　　　：VSetubiModel
//	作成日付・作成者：2018.02.19 ADF)S.Yoshida
//	修正履歴　　　　：
//*****************************************************************************

require_once("./model/CommonModel.php");

class VSetubiModel extends CommonModel {

    public function getSetubiList($conditions) {
        $SQL_SETUBI_INFO = <<< SQL_SETUBI_INFO
                SELECT 
                    T1.SETUBI_ID SETUBI_ID,
                    T1.SETUBI_NO SETUBI_NO,
                    T1.SETUBI_NM SETUBI_NM,
                    T1.KIJO_ID KIJO_ID,
                    T1.KIJO_NM KIJO_NM,
                    T1.JIGYSYUT_CD JIGYSYUT_CD,
                    T1.JIGYSYUT_NM JIGYSYUT_NM,
                    T1.TODOFUKEN
                FROM
                    V_SETUBI T1 
                WHERE
                    1=1
SQL_SETUBI_INFO;

        if ($conditions['kijoNm'] != NULL) {
            $tmp = " upper(to_multi_byte(T1.KIJO_NM||'/'||T1.JIGYOSHON)) like '%'||upper(to_multi_byte('[WORD]'))||'%'";
            $SQL_SETUBI_INFO = $SQL_SETUBI_INFO . " AND " . CMN_MakeMultiKeywordsCond($conditions['kijoNm'], 0, $tmp); // AND
        }

        if ($conditions['setubiNm'] != NULL) {
            $tmp = " upper(to_multi_byte(T1.SETUBI_NM)) like '%'||upper(to_multi_byte('[WORD]'))||'%'";
            $SQL_SETUBI_INFO = $SQL_SETUBI_INFO . " AND " . CMN_MakeMultiKeywordsCond($conditions['setubiNm'], 0, $tmp); // AND
        }

        $SQL_SETUBI_INFO = $SQL_SETUBI_INFO . " ORDER BY SETUBI_ID ASC ";

        $html = "";
        $arr = array();

        $tpl = new ExecTemplate($html, $SQL_SETUBI_INFO);
        $tpl->setResultDataArray($arr);
        if ($conditions['paginStart'] != NULL && $conditions['paginEnd'] != NULL) {
            $tpl->getResult($conditions['paginStart'], $conditions['paginEnd']); // ページング
        } else {
            $tpl->getResult(); // ページング無し
        }
        return $arr;
    }

    public function getSetubiListCount($conditions) {
        $SQL_SETUBI_INFO = <<< SQL_SETUBI_INFO
                SELECT 
                    count(*) COUNT
                FROM
                    V_SETUBI T1 
                WHERE
                    1=1
SQL_SETUBI_INFO;

        if ($conditions['kijoNm'] != NULL) {
            $tmp = " upper(to_multi_byte(T1.KIJO_NM||'/'||T1.JIGYOSHON)) like '%'||upper(to_multi_byte('[WORD]'))||'%'";
            $SQL_SETUBI_INFO = $SQL_SETUBI_INFO . " AND " . CMN_MakeMultiKeywordsCond($conditions['kijoNm'], 0, $tmp); // AND
        }

        if ($conditions['setubiNm'] != NULL) {
            $tmp = " upper(to_multi_byte(T1.SETUBI_NM)) like '%'||upper(to_multi_byte('[WORD]'))||'%'";
            $SQL_SETUBI_INFO = $SQL_SETUBI_INFO . " AND " . CMN_MakeMultiKeywordsCond($conditions['setubiNm'], 0, $tmp); // AND
        }

        $html = "";
        $arr = array();

        $tpl = new ExecTemplate($html, $SQL_SETUBI_INFO);
        $tpl->setResultDataArray($arr);
        $tpl->getResult(); // ページング無し
        return $arr[0];
    }

}
