<?php
//*****************************************************************************
//	システム名　　　：共通DBAPI
//	サブシステム名　：
//	処理名　　　　　：設備Dto
//	作成日付・作成者：2018.02.19 ADF)S.Yoshida
//	修正履歴　　　　：
//*****************************************************************************

require_once('./dto/CommonDto.php');

/**
 * Class SetubiDto
 *
 * @property String $setubiId
 * @property String $setubiNm
 * @property String $kijoId
 * @property String $kijoNm
 * @property String $jigyosyutaiId
 * @property String $jigyosyutaiNm
 * @property String $prefNm
 */
class SetubiDto extends CommonDto {

    private $setubiId;
    private $setubiNm;
    private $kijoId;
    private $kijoNm;
    private $jigyosyutaiId;
    private $jigyosyutaiNm;
    private $prefNm;

    /**
     * @return String
     */
    public function getSetubiId() {
        return $this->setubiId;
    }

    /**
     * @param String $setubiId
     */
    public function setSetubiId($setubiId) {
        $this->setubiId = $setubiId;
    }

    /**
     * @return String
     */
    public function getSetubiNm() {
        return $this->setubiNm;
    }

    /**
     * @param String $setubiNm
     */
    public function setSetubiNm($setubiNm) {
        $this->setubiNm = $setubiNm;
    }

    /**
     * @return String
     */
    public function getKijoId() {
        return $this->kijoId;
    }

    /**
     * @param String $kijoId
     */
    public function setKijoId($kijoId) {
        $this->kijoId = $kijoId;
    }

    /**
     * @return String
     */
    public function getKijoNm() {
        return $this->kijoNm;
    }

    /**
     * @param String $kijoNm
     */
    public function setKijoNm($kijoNm) {
        $this->kijoNm = $kijoNm;
    }

    /**
     * @return String
     */
    public function getJigyosyutaiId() {
        return $this->jigyosyutaiId;
    }

    /**
     * @param String $jigyosyutaiId
     */
    public function setJigyosyutaiId($jigyosyutaiId) {
        $this->JigyosyutaiId = $jigyosyutaiId;
    }

    /**
     * @return String
     */
    public function getJigyosyutaiNm() {
        return $this->jigyosyutaiNm;
    }

    /**
     * @param String $jigyosyutaiNm
     */
    public function setJigyosyutaiNm($jigyosyutaiNm) {
        $this->jigyosyutaiNm = $jigyosyutaiNm;
    }

    /**
     * @return String
     */
    public function getPrefNm() {
        return $this->prefNm;
    }

    /**
     * @param String $prefNm
     */
    public function setPrefNm($prefNm) {
        $this->prefNm = $prefNm;
    }

}
