<?php
//*****************************************************************************
//	システム名　　　：共通DBAPI
//	サブシステム名　：
//	処理名　　　　　：SectionDto
//	作成日付・作成者：2018.01.09 ADF)S.Yoshida
//	修正履歴　　　　：
//*****************************************************************************

require_once('./dto/CommonDto.php');

/**
 * Class SectionDto
 *
 * @property String $sectionCd
 * @property String $sectionNm
 */
class SectionDto extends CommonDto{

    private $sectionCd;
    private $sectionNm;

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
