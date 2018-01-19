<?php
//*****************************************************************************
//	システム名　　　：共通DBAPI
//	サブシステム名　：
//	処理名　　　　　：IncidentListGetDto
//	作成日付・作成者：2018.01.19 newtouch
//	修正履歴　　　　：
//*****************************************************************************
require_once('./dto/CommonDto.php');

/**
 * Class IncidentListGetDto
 * 情報検索用パラメータ
 */
class IncidentListGetDto extends CommonDto {

    /** インシデント番号 */
    private $incidentNo;

    /** 受付内容 */
    private $callContent;

    /** 受付開始時刻 */
    private $callStartDateFrom;

    /** 受付終了時刻 */
    private $callStartDateTo;

    /** インシデント分類 */
    private $incidentType;

    /** ステータス */
    private $incidentStatus;

    public function getIncidentNo() {
        return $this->incidentNo;
    }

    public function getCallContent() {
        return $this->callContent;
    }

    public function getCallStartDateFrom() {
        return $this->callStartDateFrom;
    }

    public function getCallStartDateTo() {
        return $this->callStartDateTo;
    }

    public function getIncidentType() {
        return $this->incidentType;
    }

    public function getIncidentStatus() {
        return $this->incidentStatus;
    }

    public function setIncidentNo($incidentNo) {
        $this->incidentNo = $incidentNo;
    }

    public function setCallContent($callContent) {
        $this->callContent = $callContent;
    }

    public function setCallStartDateFrom($callStartDateFrom) {
        $this->callStartDateFrom = $callStartDateFrom;
    }

    public function setCallStartDateTo($callStartDateTo) {
        $this->callStartDateTo = $callStartDateTo;
    }

    public function setIncidentType($incidentType) {
        $this->incidentType = $incidentType;
    }

    public function setIncidentStatus($incidentStatus) {
        $this->incidentStatus = $incidentStatus;
    }

}
