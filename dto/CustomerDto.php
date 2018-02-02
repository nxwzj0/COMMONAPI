<?php

//*****************************************************************************
//	システム名　　　：共通DBAPI
//	サブシステム名　：
//	処理名　　　　　：CustomerDto
//	作成日付・作成者：2018.01.09 ADF)S.Yoshida
//	修正履歴　　　　：
//*****************************************************************************

require_once('./dto/CommonDto.php');

/**
 * Class CustomerDto
 *
 * @property String $customerCd
 * @property String $customerNm
 * @property String $address
 * @property String $custAcctSiteId
 * @property String $formalCustName
 * @property String $formalCustName1
 * @property String $formalCustName2
 * @property String $formalCustName3
 */
class CustomerDto extends CommonDto {

    private $customerCd;
    private $customerNm;
    private $address;
    // 不一定有用
    private $custAcctSiteId;
    private $formalCustName;
    private $formalCustName1;
    private $formalCustName2;
    private $formalCustName3;

    /**
     * @return String
     */
    public function getCustomerCd() {
        return $this->customerCd;
    }

    /**
     * @param String $customerCd
     */
    public function setCustomerCd($customerCd) {
        $this->customerCd = $customerCd;
    }

    /**
     * @return String
     */
    public function getCustomerNm() {
        return $this->customerNm;
    }

    /**
     * @param String $customerNm
     */
    public function setCustomerNm($customerNm) {
        $this->customerNm = $customerNm;
    }

    /**
     * @return String
     */
    public function getAddress() {
        return $this->address;
    }

    /**
     * @param String $address
     */
    public function setAddress($address) {
        $this->address = $address;
    }

    /**
     * @return String
     */
    public function getCustAcctSiteId() {
        return $this->custAcctSiteId;
    }

    /**
     * @param String $custAcctSiteId
     */
    public function setCustAcctSiteId($custAcctSiteId) {
        $this->custAcctSiteId = $custAcctSiteId;
    }

    /**
     * @return String
     */
    public function getFormalCustName() {
        return $this->formalCustName;
    }

    /**
     * @param String $formalCustName
     */
    public function setFormalCustName($formalCustName) {
        $this->formalCustName = $formalCustName;
    }

    /**
     * @return String
     */
    public function getFormalCustName1() {
        return $this->formalCustName1;
    }

    /**
     * @param String $formalCustName1
     */
    public function setFormalCustName1($formalCustName1) {
        $this->formalCustName1 = $formalCustName1;
    }

    /**
     * @return String
     */
    public function getFormalCustName2() {
        return $this->formalCustName2;
    }

    /**
     * @param String $formalCustName2
     */
    public function setFormalCustName2($formalCustName2) {
        $this->formalCustName2 = $formalCustName2;
    }

    /**
     * @return String
     */
    public function getFormalCustName3() {
        return $this->formalCustName3;
    }

    /**
     * @param String $formalCustName3
     */
    public function setFormalCustName3($formalCustName3) {
        $this->formalCustName3 = $formalCustName3;
    }

}
