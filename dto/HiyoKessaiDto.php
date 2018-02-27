<?php
//*****************************************************************************
//	システム名　　　：インシデント管理システム
//	サブシステム名　：
//	処理名　　　　　：HiyoKessaiDto
//	作成日付・作成者：2018.02.08 ADF)R.Onishi
//	修正履歴　　　　：
//*****************************************************************************

require_once('./dto/CommonDto.php');

/**
 * Class HiyoKessaiDto
 * @property String $idNo
 * @property String $status
 * @property String $division
 * @property String $approvalNo
 * @property String $subject
 * @property String $amount
 */
class HiyoKessaiDto extends CommonDto {

    private $idNo;
    private $status;
    private $division;
    private $approvalNo;
    private $subject;
    private $amount;

    /**
     * @return String
     */
    public function getIdNo() {
        return $this->idNo;
    }

    /**
     * @param String $idNo
     */
    public function setIdNo($idNo) {
        $this->idNo = $idNo;
    }

    /**
     * @return String
     */
    public function getStatus() {
        return $this->status;
    }

    /**
     * @param String $status
     */
    public function setStatus($status) {
        $this->status = $status;
    }

    /**
     * @return String
     */
    public function getDivision() {
        return $this->division;
    }

    /**
     * @param String $division
     */
    public function setDivision($division) {
        $this->division = $division;
    }

    /**
     * @return String
     */
    public function getApprovalNo() {
        return $this->approvalNo;
    }

    /**
     * @param String $approvalNo
     */
    public function setApprovalNo($approvalNo) {
        $this->approvalNo = $approvalNo;
    }

    /**
     * @return String
     */
    public function getSubject() {
        return $this->subject;
    }

    /**
     * @param String $subject
     */
    public function setSubject($subject) {
        $this->subject = $subject;
    }

    /**
     * @return String
     */
    public function getAmount() {
        return $this->amount;
    }

    /**
     * @param String $amount
     */
    public function setAmount($amount) {
        $this->amount = $amount;
    }

}
