<?php
//*****************************************************************************
//	システム名　　　：共通DBAPI
//	サブシステム名　：
//	処理名　　　　　：DeptListDataGetDto
//	作成日付・作成者：2018.01.09 ADF)S.Yoshida
//	修正履歴　　　　：
//*****************************************************************************

require_once('./dto/CommonDto.php');

/**
 * Class IncidentListDataGetDto
 * 情報検索用パラメータ
 */
class IncidentListGetDto extends CommonDto{
 
    private $incidentNo;
    private $callContent;
    private $callDate;
    private $callStartDateFrom;
    private $callStartDateTo;
    private $incidentType;
    private $incidentType1;
    private $incidentType2;
    private $incidentType3;
    private $incidentType4;
    private $incidentType5;
    private $incidentType6;
    private $incidentStatus;
    private $incidentStatus1;
    private $incidentStatus2;
    private $incidentStatus3;
    
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

    public function getIncidentType1() {
        return $this->incidentType1;
    }

    public function getIncidentType2() {
        return $this->incidentType2;
    }

    public function getIncidentType3() {
        return $this->incidentType3;
    }

    public function getIncidentType4() {
        return $this->incidentType4;
    }

    public function getIncidentType5() {
        return $this->incidentType5;
    }

    public function getIncidentType6() {
        return $this->incidentType6;
    }

    public function getIncidentStatus() {
        return $this->incidentStatus;
    }

    public function getIncidentStatus1() {
        return $this->incidentStatus1;
    }

    public function getIncidentStatus2() {
        return $this->incidentStatus2;
    }

    public function getIncidentStatus3() {
        return $this->incidentStatus3;
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

    public function setIncidentType1($incidentType1) {
        $this->incidentType1 = $incidentType1;
    }

    public function setIncidentType2($incidentType2) {
        $this->incidentType2 = $incidentType2;
    }

    public function setIncidentType3($incidentType3) {
        $this->incidentType3 = $incidentType3;
    }

    public function setIncidentType4($incidentType4) {
        $this->incidentType4 = $incidentType4;
    }

    public function setIncidentType5($incidentType5) {
        $this->incidentType5 = $incidentType5;
    }

    public function setIncidentType6($incidentType6) {
        $this->incidentType6 = $incidentType6;
    }

    public function setIncidentStatus($incidentStatus) {
        $this->incidentStatus = $incidentStatus;
    }

    public function setIncidentStatus1($incidentStatus1) {
        $this->incidentStatus1 = $incidentStatus1;
    }

    public function setIncidentStatus2($incidentStatus2) {
        $this->incidentStatus2 = $incidentStatus2;
    }

    public function setIncidentStatus3($incidentStatus3) {
        $this->incidentStatus3 = $incidentStatus3;
    }


}