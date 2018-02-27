<?php
//*****************************************************************************
//	システム名　　　：インシデント管理システム
//	サブシステム名　：
//	処理名　　　　　：VHiyoKessaiShougaiIncidentModel.php
//	作成日付・作成者：2018.02.08 ADF)R.Onishi
//	修正履歴　　　　：
//*****************************************************************************

require_once("./model/CommonModel.php");

class VHiyoKessaiShougaiIncidentModel extends CommonModel {

    public function getHiyoKessaiShougaiIncidentList($conditions) {

        $SQL_HIYO_KESSAI_SYOUGAI_INCIDENT = <<< SQL_HIYO_KESSAI_SYOUGAI_INCIDENT
                SELECT
                    ID_NO
                    ,STATUS
                    ,APPROVAL_NO
                    ,SUBJECT
                    ,AMOUNT
                    ,IDENT_ID
                FROM
                    V_HIYO_KESSAI_SHOUGAI_INCIDENT
                WHERE
                    1=1
SQL_HIYO_KESSAI_SYOUGAI_INCIDENT;

         // インシデントID
        if ($conditions['incidentId'] != NULL) {
            $SQL_HIYO_KESSAI_SYOUGAI_INCIDENT = $SQL_HIYO_KESSAI_SYOUGAI_INCIDENT . " AND IDENT_ID = " . $conditions['incidentId'];
        }
        $SQL_HIYO_KESSAI_SYOUGAI_INCIDENT = $SQL_HIYO_KESSAI_SYOUGAI_INCIDENT . " ORDER BY ID_NO";

        $MultiExecSql = new MultiExecSql();
        $sqlResult = array();
        $MultiExecSql->getResultData($SQL_HIYO_KESSAI_SYOUGAI_INCIDENT, $sqlResult);
        return $sqlResult;
    }

}
