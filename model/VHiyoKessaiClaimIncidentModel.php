<?php
//*****************************************************************************
//	システム名　　　：インシデント管理システム
//	サブシステム名　：
//	処理名　　　　　：VHiyoKessaiClaimIncidentModel.php
//	作成日付・作成者：2018.02.08 ADF)R.Onishi
//	修正履歴　　　　：
//*****************************************************************************

require_once("./model/CommonModel.php");

class VHiyoKessaiClaimIncidentModel extends CommonModel {

    public function getHiyoKessaiClaimIncidentList($conditions) {

        $SQL_HIYO_KESSAI_CLAIM_INCIDENT = <<< SQL_HIYO_KESSAI_CLAIM_INCIDENT
                SELECT
                    ID_NO
                    ,STATUS
                    ,APPROVAL_NO
                    ,SUBJECT
                    ,AMOUNT
                    ,IDENT_ID
                FROM
                    V_HIYO_KESSAI_CLAIM_INCIDENT
                WHERE
                    1=1
SQL_HIYO_KESSAI_CLAIM_INCIDENT;

         // インシデントID
        if ($conditions['incidentId'] != NULL) {
            $SQL_HIYO_KESSAI_CLAIM_INCIDENT = $SQL_HIYO_KESSAI_CLAIM_INCIDENT . " AND IDENT_ID = " . $conditions['incidentId'];
        }
        $SQL_HIYO_KESSAI_CLAIM_INCIDENT = $SQL_HIYO_KESSAI_CLAIM_INCIDENT . " ORDER BY ID_NO";

        $MultiExecSql = new MultiExecSql();
        $sqlResult = array();
        $MultiExecSql->getResultData($SQL_HIYO_KESSAI_CLAIM_INCIDENT, $sqlResult);
        return $sqlResult;
    }

}
