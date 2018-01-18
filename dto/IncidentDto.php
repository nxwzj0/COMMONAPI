<?php
//*****************************************************************************
//	システム名　　　：共通DBAPI
//	サブシステム名　：
//	処理名　　　　　：ユーザDto
//	作成日付・作成者：2018.01.09 ADF)S.Yoshida
//	修正履歴　　　　：
//*****************************************************************************

require_once('./dto/SectionDto.php');

/**
 * Class IncidentDto
 */
class IncidentDto extends SectionDto{

    // INCIDENT_NO
    private $incidentNo;
    // CALL_CONTENT
    private $memo;
    private $callContent;
    // CALL_START_DATE CALL_END_DATE
    private $callDate;
    private $callStartDateFrom;
    private $callStartDateTo;
    // INCIDENT_TYPE
    private $incidentType;
    // INCIDENT_STS
    private $incidentStatus;
    
    public function getIncidentNo() {
        return $this->incidentNo;
    }

    public function getMemo() {
        return $this->memo;
    }

    public function getCallContent() {
        return $this->callContent;
    }

    public function getCallDate() {
        return $this->callDate;
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

    public function setMemo($memo) {
        $this->memo = $memo;
    }

    public function setCallContent($callContent) {
        $this->callContent = $callContent;
    }

    public function setCallDate($callDate) {
        $this->callDate = $callDate;
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
