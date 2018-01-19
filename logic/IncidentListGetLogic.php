<?php
//*****************************************************************************
//	システム名　　　：共通DBAPI
//	サブシステム名　：
//	処理名　　　　　：IncidentListGetLogic
//	作成日付・作成者：2018.01.19 newtouch
//	修正履歴　　　　：
//*****************************************************************************
/* common */
require_once('./logic/CommonLogic.php');
require_once('./inc/const.php');
require_once('./model/IncidentModel.php');
require_once('./dto/IncidentDto.php');
require_once('./dto/IncidentListGetDto.php');
require_once('./dto/IncidentListGetResultDto.php');

/**
 * IncidentListGetLogic
 */
class IncidentListGetLogic extends CommonLogic {

    public function execute(IncidentListGetDto $incidentListGetDto) {
        // 戻りオブジェクト(IncidentListGetResultDto)を作成
        $incidentListGetResultDto = new IncidentListGetResultDto();

        // IncidentListGetDtoから、パラメータを取得する、$conditionsを作成
        $conditions = array();
        $conditions['incidentNo'] = $incidentListGetDto->getIncidentNo();
        $conditions['callContent'] = $incidentListGetDto->getCallContent();
        $conditions['callStartDateFrom'] = $incidentListGetDto->getCallStartDateFrom();
        $conditions['callStartDateTo'] = $incidentListGetDto->getCallStartDateTo();
        $conditions['incidentType'] = $incidentListGetDto->getIncidentType();
        $conditions['incidentStatus'] = $incidentListGetDto->getIncidentStatus();

        try {
            // インシデント情報を取得
            $incidentModel = new IncidentModel();
            $incidentList = $incidentModel->getIncidentList($conditions);
        } catch (Exception $e) {
            // LOGIC結果　SQLエラー '1' をセット
            $IncidentGetResultDto->setLogicResult(LOGIC_RESULT_SQL_ERROR);
            // 戻りオブジェクト(IncidentListGetResultDto)
            return $incidentListGetResultDto;
        }

        // 個数分インシデント情報リストをループ
        foreach ($incidentList as $incidentData) {
            // IncidentDtoを作成
            $incidentDto = new IncidentDto();

            // 情報の取得
            $incidentDto->setIncidentId($incidentData["INCIDENT_ID"]);
            $incidentDto->setIncidentNo($incidentData["INCIDENT_NO"]);
            $incidentDto->setCallContent($incidentData["CALL_CONTENT"]);
            $incidentDto->setCallDate($incidentData["CALL_DATE"]);
            $incidentDto->setIncidentType($incidentData["INCIDENT_TYPE"]);
            $incidentDto->setIncidentTypeString($incidentModel->findValueByNameAndKey("INCIDENT_TYPE", $incidentDto->getIncidentType()));
            $incidentDto->setIncidentStatus($incidentData["INCIDENT_STS"]);
            $incidentDto->setIncidentStatusString($incidentModel->findValueByNameAndKey("INCIDENT_STS", $incidentDto->getIncidentStatus()));
            // IncidentDto⇒IncidentListGetResultDtoのセット
            $incidentListGetResultDto->addIncidentList($incidentDto);
        }

        // LOGIC結果　正常時 '0' をセット
        $incidentListGetResultDto->setLogicResult(LOGIC_RESULT_SEIJOU);
        // 戻りオブジェクト(IncidentListGetResultDto)
        return $incidentListGetResultDto;
    }

}
