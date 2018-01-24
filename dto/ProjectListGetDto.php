<?php
//*****************************************************************************
//	システム名　　　：インシデント管理システム
//	サブシステム名　：
//	処理名　　　　　：ProjectListGetDto
//	作成日付・作成者：2018.01.22 newtouch
//	修正履歴　　　　：
//*****************************************************************************

require_once('./dto/CommonDto.php');

/**
 * Class ProjectListGetDto
 * @property String $pjNo
 * @property String $inqNo
 * @property String $consumerNm
 * @property String $summaryNm
 */
class ProjectListGetDto extends CommonDto {

    /** PJ番号 */
    private $pjNo;

    /** INQ番号 */
    private $inqNo;

    /** 最終需要家 */
    private $consumerNm;

    /** 総括品 */
    private $summaryNm;

    /**
     * @return String
     */
    public function getPjNo() {
        return $this->pjNo;
    }

    /**
     * @param String $pjNo
     */
    public function setPjNo($pjNo) {
        $this->pjNo = $pjNo;
    }

    /**
     * @return String
     */
    public function getInqNo() {
        return $this->inqNo;
    }

    /**
     * @param String $inqNo
     */
    public function setInqNo($inqNo) {
        $this->inqNo = $inqNo;
    }

    /**
     * @return String
     */
    public function getConsumerNm() {
        return $this->consumerNm;
    }

    /**
     * @param String $consumerNm
     */
    public function setConsumerNm($consumerNm) {
        $this->consumerNm = $consumerNm;
    }

    /**
     * @return String
     */
    public function getSummaryNm() {
        return $this->summaryNm;
    }

    /**
     * @param String $summaryNm
     */
    public function setSummaryNm($summaryNm) {
        $this->summaryNm = $summaryNm;
    }

}
