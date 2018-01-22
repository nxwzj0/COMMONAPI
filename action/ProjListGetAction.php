<?php
//*****************************************************************************
//	システム名　　　：インシデント管理システム
//	サブシステム名　：
//	処理名　　　　　：ProjListGetAction
//	作成日付・作成者：2018.01.22 newtouch
//	修正履歴　　　　：
//*****************************************************************************
// 共通処理読み込み
require_once('./action/CommonAction.php');
// dto読み込み
require_once('./dto/SectionDto.php');
require_once('./dto/ProjDto.php');
require_once('./dto/ProjListGetDto.php');
require_once('./dto/ProjListGetResultDto.php');
// logic処理読み込み
require_once('./logic/ProjListGetLogic.php');

class ProjListGetAction extends CommonAction {

    public function index() {
        // 戻り値用配列
        $rtnAry = array();

        /* Dto作成処理 */
        $projListGetDto = new ProjListGetDto();
        $P = $GLOBALS[P]; // 共通パラメータ配列取得
        // 情報検索用パラメータ
        $projListGetDto->setPjNo($P['pjNo']);
        $projListGetDto->setInqNo($P['inqNo']);
        $projListGetDto->setConsumerNm($P['consumerNm']);
        $projListGetDto->setSummaryNm($P['summaryNm']);

        /* ロジック処理 */
        $projListGetLogic = new ProjListGetLogic();
        $eventResult = $projListGetLogic->execute($projListGetDto);

        /* 戻り値作成処理 */
        $rtnAry = $this->createReturnArray($eventResult);

        // 値を返す(Angular)
        echo $this->returnAngularJSONP($rtnAry);
    }

    public function createReturnArray(ProjListGetResultDto $eventResult) {
        $projListAry = array();

        // 戻り値の作成
        if ($eventResult && $eventResult->getLogicResult() == LOGIC_RESULT_SEIJOU) {
            array_push($projListAry, array("result" => true));

            if ($eventResult->getProjList() && is_array($eventResult->getProjList()) && count($eventResult->getProjList()) > 0) {
                foreach ($eventResult->getProjList() as $proj) {
                    $projAry = array();

                    // プロジェクト情報
                    $projAry["pjId"] = $proj->getPjId();
                    $projAry["pjNo"] = $proj->getPjNo();
                    $projAry["inqNo"] = $proj->getInqNo();
                    $projAry["consumerNm"] = $proj->getConsumerNm();
                    $projAry["summaryNm"] = $proj->getSummaryNm();
                    // 1件分の情報をセット
                    array_push($projListAry, $projAry);
                }
            }
        } else {
            array_push($projListAry, array("result" => false));
        }

        return $projListAry;
    }

}
