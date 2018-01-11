<?php
//*****************************************************************************
//	システム名　　　：共通DBAPI
//	サブシステム名　：
//	処理名　　　　　：共通Dto
//	作成日付・作成者：2018.01.09 ADF)S.Yoshida
//	修正履歴　　　　：
//*****************************************************************************

/**
 * Class CommonDto
 *
 * @property String $insDate
 * @property String $insUserId
 * @property String $insUserNm
 * @property String $insSectionCd
 * @property String $insSectionNm
 * @property String $updDate
 * @property String $updUserId
 * @property String $updUserNm
 * @property String $updSectionCd
 * @property String $updSectionNm
 * @property String $logicResult
 */
class CommonDto {
    private $insDate;
    private $insUserId;
    private $insUserNm;
    private $insSectionCd;
    private $insSectionNm;
    private $updDate;
    private $updUserId;
    private $updUserNm;
    private $updSectionCd;
    private $updSectionNm;
    private $logicResult;

    /**
     * @return String
     */
    public function getInsDate() {
        return $this->insDate;
    }

    /**
     * @param String $insDate
     */
    public function setInsDate($insDate) {
        $this->insDate = $insDate;
    }

    /**
     * @return String
     */
    public function getInsUserId() {
        return $this->insUserId;
    }

    /**
     * @param String $insUserId
     */
    public function setInsUserId($insUserId) {
        $this->insUserId = $insUserId;
    }

    /**
     * @return String
     */
    public function getInsUserNm() {
        return $this->insUserNm;
    }

    /**
     * @param String $insUserNm
     */
    public function setInsUserNm($insUserNm) {
        $this->insUserNm = $insUserNm;
    }

    /**
     * @return String
     */
    public function getInsSectionCd() {
        return $this->insSectionCd;
    }

    /**
     * @param String $insSectionCd
     */
    public function setInsSectionCd($insSectionCd) {
        $this->insSectionCd = $insSectionCd;
    }

    /**
     * @return String
     */
    public function getInsSectionNm() {
        return $this->insSectionNm;
    }

    /**
     * @param String $insSectionNm
     */
    public function setInsSectionNm($insSectionNm) {
        $this->insSectionNm = $insSectionNm;
    }

    /**
     * @return String
     */
    public function getUpdDate() {
        return $this->updDate;
    }

    /**
     * @param String $updDate
     */
    public function setUpdDate($updDate) {
        $this->updDate = $updDate;
    }

    /**
     * @return String
     */
    public function getUpdUserId() {
        return $this->updUserId;
    }

    /**
     * @param String $updUserId
     */
    public function setUpdUserId($updUserId) {
        $this->updUserId = $updUserId;
    }

    /**
     * @return String
     */
    public function getUpdUserNm() {
        return $this->updUserNm;
    }

    /**
     * @param String $updUserNm
     */
    public function setUpdUserNm($updUserNm) {
        $this->updUserNm = $updUserNm;
    }

    /**
     * @return String
     */
    public function getUpdSectionCd() {
        return $this->updSectionCd;
    }

    /**
     * @param String $updSectionCd
     */
    public function setUpdSectionCd($updSectionCd) {
        $this->updSectionCd = $updSectionCd;
    }

    /**
     * @return String
     */
    public function getUpdSectionNm() {
        return $this->updSectionNm;
    }

    /**
     * @param String $updSectionNm
     */
    public function setUpdSectionNm($updSectionNm) {
        $this->updSectionNm = $updSectionNm;
    }

    /**
     * @return String
     */
    public function getLogicResult() {
        return $this->logicResult;
    }

    /**
     * @param String $logicResult
     */
    public function setLogicResult($logicResult) {
        $this->logicResult = $logicResult;
    }

}
