<?php

//*****************************************************************************
//	システム名　　　：インシデント管理システム
//	サブシステム名　：
//	処理名　　　　　：CustomerListGetResultDto
//	作成日付・作成者：2018.01.19 newtouch
//	修正履歴　　　　：
//*****************************************************************************

require_once('./dto/CommonDto.php');

/**
 * Class CustomerListGetResultDto
 *
 * @property CustomerDto[] $customerList
 * @property String $count
 */
class CustomerListGetResultDto extends CommonDto {

    private $customerList = array();
    private $count;

    /**
     * @return CustomerDto[]
     */
    public function getCustomerList() {
        return $this->customerList;
    }

    /**
     * @param int $index
     * @return CustomerDto
     */
    public function getCustomer($index = null) {
        if (is_null($index)) {
            return null;
        } else {
            return $this->customerList[$index];
        }
    }

    /**
     * @param CustomerDto $customerList
     */
    public function addCustomerList(CustomerDto $customerList) {
        $this->customerList[] = $customerList;
    }

    /**
     * @return String
     */
    public function getCount() {
        return $this->count;
    }

    /**
     * @param String $count
     */
    public function setCount($count) {
        $this->count = $count;
    }
}
