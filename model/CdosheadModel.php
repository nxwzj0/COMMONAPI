<?php
//*****************************************************************************
//	システム名　　　：共通DBAPI
//	サブシステム名　：
//	処理名　　　　　：EescUserModel
//	作成日付・作成者：2018.01.09 ADF)S.Yoshida
//	修正履歴　　　　：
//*****************************************************************************

require_once("./model/CommonModel.php");

class CdosheadModel extends CommonModel {

    public function getProjList($conditions) {			

        $SQL_USER_INFO = <<< SQL_USER_INFO
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
SQL_USER_INFO;

        // ＯＳ番号(PJ番号)
        if ($conditions['pjNo'] != NULL) {
            $SQL_USER_INFO = $SQL_USER_INFO . " AND T1.ＯＳ番号 LIKE " . "'%" . $conditions['pjNo'] . "%' ";
        }
        
        // ＩＮＱ番号
        if ($conditions['inqNo'] != NULL) {
            $SQL_USER_INFO = $SQL_USER_INFO . " AND T1.ＩＮＱ番号 LIKE " . "'%" . $conditions['inqNo'] . "%' ";
        }

        // 最終需要家名
        if ($conditions['consumerNm'] != NULL) {
            $SQL_USER_INFO = $SQL_USER_INFO . " AND T1.最終需要家名 LIKE " . "'%" . $conditions['consumerNm'] . "%' ";
        }

        // 工事件名（総括品）
        if ($conditions['summaryNm'] != NULL) {
            $SQL_USER_INFO = $SQL_USER_INFO . " AND T1.工事件名 LIKE " . "'%" . $conditions['summaryNm'] . "%' ";
        }

        $MultiExecSql = new MultiExecSql();
        $sqlResult = array();
        $MultiExecSql->getResultData($SQL_USER_INFO, $sqlResult);
        return $sqlResult;
    }
    
}
