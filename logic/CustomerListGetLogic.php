<?php

//*****************************************************************************
//	システム名　　　：共通DBAPI
//	サブシステム名　：
//	処理名　　　　　：CustomerListGetLogic
//	作成日付・作成者：2018.01.19 newtouch
//	修正履歴　　　　：
//*****************************************************************************
/* common */
require_once('./logic/CommonLogic.php');
require_once('./inc/const.php');
/* customer */
require_once('./model/EbsCustomerSitesModel.php');
require_once('./dto/CustomerDto.php');
require_once('./dto/CustomerListGetDto.php');
require_once('./dto/CustomerListGetResultDto.php');

/**
 * CustomerListGetLogic
 */
class CustomerListGetLogic extends CommonLogic {

    public function execute(CustomerListGetDto $conditionDto) {
        // 戻りオブジェクト(CustomerListGetResultDto)を作成
        $resultDto = new CustomerListGetResultDto();

        // customerListGetDtoから、パラメータを取得する、$conditionsを作成
        $conditions = array();
        $conditions['customerCd'] = $conditionDto->getCustomerCd();
        $conditions['customerNm'] = $conditionDto->getCustomerNm();
        $conditions['address'] = $conditionDto->getAddress();
        // ::: 2018.03.01 [#43] ページング修正：顧客モーダル Add Start newtouch
        $conditions['pagingStart'] = $conditionDto->getPagingStart();
        $conditions['pagingEnd'] = $conditionDto->getPagingEnd();
        // ::: 2018.03.01 [#43] ページング修正：顧客モーダル Add End   newtouch

        try {
            // 取引先情報を取得
            $model = new EbsCustomerSitesModel();
            $customerList = $model->getCustomerList($conditions);
            // ::: 2018.03.01 [#43] ページング修正：顧客モーダル Add Start newtouch
            $customerListCount = $model->getCustomerListCount($conditions);
            // ::: 2018.03.01 [#43] ページング修正：顧客モーダル Add End   newtouch

        } catch (Exception $e) {
            // LOGIC結果　SQLエラー '1' をセット
            $resultDto->setLogicResult(LOGIC_RESULT_SQL_ERROR);
            // 戻りオブジェクト(UserListGetResultDto)
            return $resultDto;
        }

        // 個数分取引先情報リストをループ
        foreach ($customerList as $customerData) {
            // customerDtoを作成
            $customerDto = new CustomerDto();

            // 取引先情報の取得
            $customerDto->setCustomerCd($customerData["CUSTOMER_CD"]);
            $customerDto->setCustomerNm($customerData["CUSTOMER_NM"]);
            $customerDto->setAddress($customerData["ADDRESS"]);
            // CustomerDto⇒CustomerListGetResultDtoのセット
            $resultDto->addCustomerList($customerDto);
        }

        // ::: 2018.03.01 [#43] ページング修正：顧客モーダル Add Start newtouch
        if ($customerListCount) {
            $resultDto->setCount($customerListCount["COUNT"]);
        }
        // ::: 2018.03.01 [#43] ページング修正：顧客モーダル Add End   newtouch
        
        // LOGIC結果　正常時 '0' をセット
        $resultDto->setLogicResult(LOGIC_RESULT_SEIJOU);
        // 戻りオブジェクト(userListGetResultDto)
        return $resultDto;
    }

}
