<?php
//*****************************************************************************
//	システム名　　　：共通DBAPI
//	サブシステム名　：
//	処理名　　　　　：SetubiListGetDto
//	作成日付・作成者：2018.02.19 ADF)S.Yoshida
//	修正履歴　　　　：
//*****************************************************************************

require_once('./dto/PagingDto.php');

/**
 * Class SetubiListGetDto
 * 
 * @property String $kijoNm
 * @property String $setubiNm
 */
class SetubiListGetDto extends PagingDto {

    private $kijoNm;
    private $setubiNm;

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
    function getSetubiNm() {
        return $this->setubiNm;
    }

    /**
     * @param String $setubiNm
     */
    function setSetubiNm($setubiNm) {
        $this->setubiNm = $setubiNm;
    }

}
