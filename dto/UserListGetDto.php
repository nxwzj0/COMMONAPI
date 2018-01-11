<?php
//*****************************************************************************
//	システム名　　　：共通DBAPI
//	サブシステム名　：
//	処理名　　　　　：UserListGetDto
//	作成日付・作成者：2018.01.09 ADF)S.Yoshida
//	修正履歴　　　　：
//*****************************************************************************

require_once('./dto/CommonDto.php');

/**
 * Class UserListGetDto
 * 
 * @property String $userNmSei
 * @property String $userNmMei
 * @property String $sectionCd
 * @property String $sectionNm
 */
class UserListGetDto extends CommonDto{
    private $userNmSei;
    private $userNmMei;
    private $sectionCd;
    private $sectionNm;

    /**
     * @return String
     */
    public function getUserNmSei() {
        return $this->userNmSei;
    }

    /**
     * @param String $userNmSei
     */
    public function setUserNmSei($userNmSei) {
        $this->userNmSei = $userNmSei;
    }

    /**
     * @return String
     */
    function getUserNmMei() {
        return $this->userNmMei;
    }

    /**
     * @param String $userNmMei
     */
    function setUserNmMei($userNmMei) {
        $this->userNmMei = $userNmMei;
    }

    /**
     * @return String
     */
    public function getSectionCd() {
        return $this->sectionCd;
    }

    /**
     * @param String $sectionCd
     */
    public function setSectionCd($sectionCd) {
        $this->sectionCd = $sectionCd;
    }

    /**
     * @return String
     */
    public function getSectionNm() {
        return $this->sectionNm;
    }

    /**
     * @param String $sectionNm
     */
    public function setSectionNm($sectionNm) {
        $this->sectionNm = $sectionNm;
    }

}