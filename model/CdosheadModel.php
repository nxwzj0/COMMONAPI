<?php
//*****************************************************************************
//	システム名　　　：インシデント管理システム
//	サブシステム名　：
//	処理名　　　　　：CdosheadModel
//	作成日付・作成者：2018.01.22·newtouch
//	修正履歴　　　　：
//*****************************************************************************

require_once("./model/CommonModel.php");

class CdosheadModel extends CommonModel {

    public function getProjectList($conditions) {

        $SQL_PJ_INFO = <<< SQL_PJ_INFO
                SELECT 
                    T1.物件番号  PJ_ID
                    ,T1.ＯＳ番号	 PJ_NO
                    ,T1.ＩＮＱ番号 INQ_NO
                    ,T1.最終需要家名 CONSUMER_NM
                    ,T1.工事件名 SUMMARY_NM
                FROM
                    CDOSHEAD T1 
                WHERE
                    1=1
SQL_PJ_INFO;

        // ＯＳ番号(PJ番号)
        if ($conditions['pjNo'] != NULL) {
            $SQL_PJ_INFO = $SQL_PJ_INFO . " AND " . CMN_MakeLikeCond(" " . "T1.ＯＳ番号", $conditions['pjNo'], "%", "%") . " ";
        }

        // ＩＮＱ番号
        if ($conditions['inqNo'] != NULL) {
            $SQL_PJ_INFO = $SQL_PJ_INFO . " AND " . CMN_MakeLikeCond(" " . "T1.ＩＮＱ番号", $conditions['inqNo'], "%", "%") . " ";
        }

        // 最終需要家名
        if ($conditions['consumerNm'] != NULL) {
            $SQL_PJ_INFO = $SQL_PJ_INFO . " AND " . CMN_MakeLikeCond(" " . "T1.最終需要家名", $conditions['consumerNm'], "%", "%") . " ";
        }

        // 工事件名（総括品）
        if ($conditions['summaryNm'] != NULL) {
            $SQL_PJ_INFO = $SQL_PJ_INFO . " AND " . CMN_MakeLikeCond(" " . "T1.工事件名", $conditions['summaryNm'], "%", "%") . " ";
        }

        $SQL_PJ_INFO = $SQL_PJ_INFO . " ORDER BY DECODE( RTRIM('T1.ＯＳ番号'), NULL, RTRIM('T1.ＩＮＱ番号'), RTRIM('T1.ＯＳ番号') ) ";

        $html = "";
        $arr = array();

        $tpl = new ExecTemplate($html, $SQL_PJ_INFO);
        $tpl->setResultDataArray($arr);
        if ($conditions['pagingStart'] != NULL && $conditions['pagingEnd'] != NULL) {
            $tpl->getResult($conditions['pagingStart'], $conditions['pagingEnd']); // ページング
        } else {
            $tpl->getResult(); // ページング無し
        }
        return $arr;
    }

    public function getProjectListCount($conditions) {

        $SQL_PJ_INFO = <<< SQL_PJ_INFO
                SELECT 
                    count(*) COUNT
                FROM
                    CDOSHEAD T1 
                WHERE
                    1=1
SQL_PJ_INFO;

        // ＯＳ番号(PJ番号)
        if ($conditions['pjNo'] != NULL) {
            $SQL_PJ_INFO = $SQL_PJ_INFO . " AND " . CMN_MakeLikeCond(" " . "T1.ＯＳ番号", $conditions['pjNo'], "%", "%") . " ";
        }

        // ＩＮＱ番号
        if ($conditions['inqNo'] != NULL) {
            $SQL_PJ_INFO = $SQL_PJ_INFO . " AND " . CMN_MakeLikeCond(" " . "T1.ＩＮＱ番号", $conditions['inqNo'], "%", "%") . " ";
        }

        // 最終需要家名
        if ($conditions['consumerNm'] != NULL) {
            $SQL_PJ_INFO = $SQL_PJ_INFO . " AND " . CMN_MakeLikeCond(" " . "T1.最終需要家名", $conditions['consumerNm'], "%", "%") . " ";
        }

        // 工事件名（総括品）
        if ($conditions['summaryNm'] != NULL) {
            $SQL_PJ_INFO = $SQL_PJ_INFO . " AND " . CMN_MakeLikeCond(" " . "T1.工事件名", $conditions['summaryNm'], "%", "%") . " ";
        }

        $html = "";
        $arr = array();

        $tpl = new ExecTemplate($html, $SQL_PJ_INFO);
        $tpl->setResultDataArray($arr);
        $tpl->getResult(); // ページング無し
        return $arr[0];
    }

}
