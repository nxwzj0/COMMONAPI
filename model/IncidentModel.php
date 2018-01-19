<?php
//*****************************************************************************
//	システム名　　　：共通DBAPI
//	サブシステム名　：
//	処理名　　　　　：IncidentModel
//	作成日付・作成者：2018.01.19 newtouch
//	修正履歴　　　　：
//*****************************************************************************

require_once("./model/CommonModel.php");

date_default_timezone_set('Asia/Tokyo');

class IncidentModel extends CommonModel {

    public function getIncidentList($conditions) {
        $format = "yyyy/mm/dd hh24:mi:ss";

        $SQL_USER_INFO = <<< SQL_USER_INFO
                SELECT 
                    T1.INCIDENT_ID
                    ,T1.INCIDENT_NO
                    ,T1.CALL_CONTENT 
                    ,TO_CHAR(T1.CALL_START_DATE,'$format') AS CALL_DATE
                    ,T1.INCIDENT_TYPE
                    ,T1.INCIDENT_STS
                FROM
                    IDENT_T_INCIDENT T1 
                WHERE
                    DEL_FLG = '0'
SQL_USER_INFO;

        // インシデント番号
        if ($conditions['incidentNo'] != NULL) {
            $SQL_USER_INFO = $SQL_USER_INFO . " AND T1.INCIDENT_NO LIKE " . "'%" . $conditions['incidentNo'] . "%' ";
        }

        // 受付内容
        if ($conditions['callContent'] != NULL) {
            $SQL_USER_INFO = $SQL_USER_INFO . " AND T1.CALL_CONTENT LIKE " . "'%" . $conditions['callContent'] . "%' ";
        }

        // 受付開始時刻
        if ($conditions['callStartDateFrom'] != NULL) {
            $SQL_USER_INFO = $SQL_USER_INFO . " AND T1.CALL_START_DATE >= to_date( '" . $conditions['callStartDateFrom'] . "'||' 00:00:00','$format')";
        }

        // 受付終了時刻
        if ($conditions['callStartDateTo'] != NULL) {
            $SQL_USER_INFO = $SQL_USER_INFO . " AND T1.CALL_START_DATE <= to_date('" . $conditions['callStartDateTo'] . "'||' 23:59:59','$format')";
        }

        // インシデント分類
        if ($conditions['incidentType'] != NULL) {
            $SQL_USER_INFO = $SQL_USER_INFO . " AND T1.INCIDENT_TYPE IN(" . $conditions['incidentType'] . ")";
        }

        // インシデントステータス
        if ($conditions['incidentStatus'] != NULL) {
            $SQL_USER_INFO = $SQL_USER_INFO . " AND T1.INCIDENT_STS IN(" . $conditions['incidentStatus'] . ")";
        }

        $MultiExecSql = new MultiExecSql();
        $sqlResult = array();
        $MultiExecSql->getResultData($SQL_USER_INFO, $sqlResult);
        return $sqlResult;
    }

    /**
     * Key-Valueデータ
     * @param type $name
     * @return string
     */
    public function findKeyValue($name) {
        $result = array();
        switch ($name) {
            case "INCIDENT_TYPE":
                $result = array("1,障害", "2,事故", "3,問合せ", "4,クレーム", "5,情報", "6,その他");
                break;
            case "INCIDENT_STS":
                $result = array("1,受付済", "2,対応入力済", "3,処置入力済");
                break;
            default :
                return null;
        }
        return $result;
    }

    /**
     * 戻り値の名前に応じて
     * @param unknown $name
     * @param unknown $key
     * @return Ambigous <>|NULL
     */
    function findValueByNameAndKey($name, $key) {
        $array = $this->findKeyValue($name);
        if ($array != null) {
            foreach ($array as $value) {
                $val = explode(",", $value);
                if ($val[0] == $key) {
                    return $val[1];
                }
            }
        }
        return null;
    }

}
