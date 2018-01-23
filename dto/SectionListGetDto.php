<?php
//*****************************************************************************
//	システム名　　　：共通DBAPI
//	サブシステム名　：
//	処理名　　　　　：SectionListGetDto
//	作成日付・作成者：2018.01.19 newtouch
//	修正履歴　　　　：
//*****************************************************************************

require_once('./dto/CommonDto.php');

/**
 * Class SectionListGetDto
 * @property String $postCd
 * @property String $sectionNm
 * @property String $companyNm
 */
class SectionListGetDto extends CommonDto {

    /** 職制コード */
    private $postCd;

    /** 部署名 */
    private $sectionNm;

    /** 会社名 */
    private $companyNm;

    /**
     * @return String
     */
    public function getPostCd() {
        return $this->postCd;
    }

    /**
     * @param String $postCd
     */
    public function setPostCd($postCd) {
        $this->postCd = $postCd;
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

    /**
     * @return String
     */
    public function getCompanyNm() {
        return $this->companyNm;
    }

    /**
     * @param String $companyNm
     */
    public function setCompanyNm($companyNm) {
        $this->companyNm = $companyNm;
    }

}
