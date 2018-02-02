<?php

//*****************************************************************************
//	システム名　　　：共通DBAPI
//	サブシステム名　：
//	処理名　　　　　：CustomerListGetDto
//	作成日付・作成者：2018.01.19 newtouch
//	修正履歴　　　　：
//*****************************************************************************

require_once('./dto/CommonDto.php');

/**
 * Class CustomerListGetDto
 * @property String $customerCd
 * @property String $customerNm
 * @property String $address
 */
class CustomerListGetDto extends CommonDto {

    /** 顧客コード */
    private $customerCd;

    /** 顧客名 事業所名 */
    private $customerNm;

    /** 所在地 */
    private $address;

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

}
