<?php
//*****************************************************************************
//	システム名　　　：共通DBAPI
//	サブシステム名　：
//	処理名　　　　　：DeptListDataGetDto
//	作成日付・作成者：2018.01.19 newtouch
//	修正履歴　　　　：
//*****************************************************************************

require_once('./dto/CommonDto.php');

/**
 * Class DeptListDataGetDto
 * 部門情報検索用パラメータ
 */
class DeptListGetDto extends CommonDto{
    /** 職制コード */
    private $postCd;
    /** 部署名 */
    private $sectionNm;
    /** 会社名 */
    private $companyNm;
    
    public function getPostCd() {
        return $this->postCd;
    }

    public function getSectionNm() {
        return $this->sectionNm;
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

    public function setCompanyNm($companyNm) {
        $this->companyNm = $companyNm;
    }
}