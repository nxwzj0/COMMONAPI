<?php
require_once('./dto/SectionDto.php');

/**
 * Class IncidentDto
 * entity->model
 */
class IncidentDto extends SectionDto{

    /** インシデント番号 */
    private $incidentNo;
    /** 受付内容 */
    private $callContent;
    /** 受付日 */
    private $callDate;
    /** 受付開始時刻 */
    private $callStartDateFrom;
    /** 受付終了時刻 */
    private $callStartDateTo;
    /** インシデント分類 */
    private $incidentType;
    /** インシデント分類String */
    private $incidentTypeString;
    /** ステータス */
    private $incidentStatus;
    /** ステータスString */
    private $incidentStatusString;
    
    public function getIncidentNo() {
        return $this->incidentNo;
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

    public function getIncidentTypeString() {
        return $this->incidentTypeString;
    }

    public function getIncidentStatus() {
        return $this->incidentStatus;
    }

    public function getIncidentStatusString() {
        return $this->incidentStatusString;
    }

    public function setIncidentNo($incidentNo) {
        $this->incidentNo = $incidentNo;
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

    public function setIncidentTypeString($incidentTypeString) {
        $this->incidentTypeString = $incidentTypeString;
    }

    public function setIncidentStatus($incidentStatus) {
        $this->incidentStatus = $incidentStatus;
    }

    public function setIncidentStatusString($incidentStatusString) {
        $this->incidentStatusString = $incidentStatusString;
    }
}
