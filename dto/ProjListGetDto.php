<?php
//*****************************************************************************
//	システム名　　　：インシデント管理システム
//	サブシステム名　：
//	処理名　　　　　：ProjListGetDto
//	作成日付・作成者：2018.01.22 newtouch
//	修正履歴　　　　：
//*****************************************************************************

require_once('./dto/CommonDto.php');

/**
 * Class ProjListGetDto
 * 情報検索用パラメータ
 */
class ProjListGetDto extends CommonDto {

    /** PJ番号 */
    private $pjNo;

    /** INQ番号 */
    private $inqNo;

    /** 最終需要家 */
    private $consumerNm;

    /** 総括品 */
    private $summaryNm;

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
