<?php
//*****************************************************************************
//	システム名　　　：共通DBAPI
//	サブシステム名　：
//	処理名　　　　　：部門情報Dto
//	作成日付・作成者：2018.01.19 newtouch
//	修正履歴　　　　：
//*****************************************************************************

require_once('./dto/SectionDto.php');

/**
 * Class DeptDto
 * entity->model
 */
class DeptDto extends SectionDto{

    /** 職制コード */
    private $postCd;
    /** 簡略名 */
    private $sectionNm;
    /** 会社cd */
    private $companyCd;
    /** 会社名 */
    private $companyNm;
    
    public function getPostCd() {
        return $this->postCd;
    }

    public function getSectionNm() {
        return $this->sectionNm;
    }

    public function getCompanyCd() {
        return $this->companyCd;
    }

    public function getCompanyNm() {
        return $this->companyNm;
    }

    public function setPostCd($postCd) {
        $this->postCd = $postCd;
    }

    public function setSectionNm($sectionNm) {
        $this->sectionNm = $sectionNm;
    }

    public function setCompanyCd($companyCd) {
        $this->companyCd = $companyCd;
    }

    public function setCompanyNm($companyNm) {
        $this->companyNm = $companyNm;
    }

}
