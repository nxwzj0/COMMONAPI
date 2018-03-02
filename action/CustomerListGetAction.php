<?php

//*****************************************************************************
//	システム名　　　：共通DBAPI
//	サブシステム名　：
//	処理名　　　　　：CustomerListGetAction
//	作成日付・作成者：2018.01.19 newtouch
//	修正履歴　　　　：
//*****************************************************************************
// 共通処理読み込み
require_once('./action/CommonAction.php');
// dto読み込み
require_once('./dto/CustomerListGetDto.php');
require_once('./dto/CustomerListGetResultDto.php');
// logic処理読み込み
require_once('./logic/CustomerListGetLogic.php');

class CustomerListGetAction extends CommonAction {

    public function index() {
        // 戻り値用配列
        $rtnAry = array();

        $P = $GLOBALS[P]; // 共通パラメータ配列取得
        /* Dto作成処理 */
        $conditionDto = new CustomerListGetDto();
        // 取引先情報検索用パラメータ
        $conditionDto->setCustomerCd($P['customerCd']);
        $conditionDto->setCustomerNm($P['customerNm']);
        $conditionDto->setAddress($P['address']);
        // ::: 2018.03.01 [#43] ページング修正：顧客モーダル Add Start newtouch
        $conditionDto->setPagingStart($P['pagingStart']);
        $conditionDto->setPagingEnd($P['pagingEnd']);
        // ::: 2018.03.01 [#43] ページング修正：顧客モーダル Add End   newtouch

        /* ロジック処理 */
        $logic = new CustomerListGetLogic();
        $eventResult = $logic->execute($conditionDto);

        /* 戻り値作成処理 */
        $rtnAry = $this->createReturnArray($eventResult);

        // 値を返す(Angular)
        echo $this->returnAngularJSONP($rtnAry);
    }

    public function createReturnArray(CustomerListGetResultDto $eventResult) {
        $customerListAry = array();

        // 戻り値の作成
        if ($eventResult && $eventResult->getLogicResult() == LOGIC_RESULT_SEIJOU) {
            // ::: 2018.03.01 [#43] ページング修正：顧客モーダル Del Start newtouch
            // ::: array_push($customerListAry, array("result" => true));
            // ::: 2018.03.01 [#43] ページング修正：顧客モーダル Del End   newtouch
            // ::: 2018.03.01 [#43] ページング修正：顧客モーダル Add Start newtouch
            $customerListAry[] = array("result" => true, "count" => $eventResult->getCount());
            // ::: 2018.03.01 [#43] ページング修正：顧客モーダル Add End   newtouch

            if ($eventResult->getCustomerList() && is_array($eventResult->getCustomerList()) && count($eventResult->getCustomerList()) > 0) {
                foreach ($eventResult->getCustomerList() as $customer) {
                    $customerAry = array();

                    // 顧客情報
                    $customerAry["customerCd"] = $customer->getCustomerCd();
                    $customerAry["customerNm"] = $customer->getCustomerNm();
                    $customerAry["address"] = $customer->getAddress();
                    // 1件分の情報をセット
                    // ::: 2018.03.01 [#43] ページング修正：顧客モーダル Del Start newtouch
                    // ::: array_push($customerListAry, $customerAry);
                    // ::: 2018.03.01 [#43] ページング修正：顧客モーダル Del End   newtouch
                    // ::: 2018.03.01 [#43] ページング修正：顧客モーダル Add Start newtouch
                    $customerListAry[] = $customerAry;
                    // ::: 2018.03.01 [#43] ページング修正：顧客モーダル Add End   newtouch
                }
            }
        } else {
            // ::: 2018.03.01 [#43] ページング修正：顧客モーダル Del Start newtouch
            // ::: array_push($customerListAry, array("result" => false));
            // ::: 2018.03.01 [#43] ページング修正：顧客モーダル Del End   newtouch
            // ::: 2018.03.01 [#43] ページング修正：顧客モーダル Add Start newtouch
            $customerListAry[] = array("result" => false);
            // ::: 2018.03.01 [#43] ページング修正：顧客モーダル Add End   newtouch
        }

        return $customerListAry;
    }

}
