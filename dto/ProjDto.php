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
 * Class ProjDto
 * entity->model
 */
class ProjDto extends SectionDto{

    private $pjId;

    private $pjNo;

    private $inqNo;

    private $consumerNm;
    
    private $summaryNm;
    
    public function getPjId() {
        return $this->pjId;
    }

    public function getPjNo() {
        return $this->pjNo;
    }

    public function getInqNo() {
        return $this->inqNo;
    }

    public function getConsumerNm() {
        return $this->consumerNm;
    }

    public function getSummaryNm() {
        return $this->summaryNm;
    }

    public function setPjId($pjId) {
        $this->pjId = $pjId;
    }

    public function setPjNo($pjNo) {
        $this->pjNo = $pjNo;
    }

    public function setInqNo($inqNo) {
        $this->inqNo = $inqNo;
    }

    public function setConsumerNm($consumerNm) {
        $this->consumerNm = $consumerNm;
    }

    public function setSummaryNm($summaryNm) {
        $this->summaryNm = $summaryNm;
    }

}
