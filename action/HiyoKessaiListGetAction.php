<?php
//*****************************************************************************
//	システム名　　　：インシデント管理システム
//	サブシステム名　：
//	処理名　　　　　：HiyoKessaiListGetAction
//	作成日付・作成者：2018.02.08 ADF)R.Onishi
//	修正履歴　　　　：
//*****************************************************************************
// 共通処理読み込み
require_once('./action/CommonAction.php');
// dto読み込み
require_once('./dto/HiyoKessaiListGetDto.php');
require_once('./dto/HiyoKessaiListGetResultDto.php');
// logic処理読み込み
require_once('./logic/HiyoKessaiListGetLogic.php');

class HiyoKessaiListGetAction extends CommonAction {

    public function index() {
        // 戻り値用配列
        $rtnAry = array();

        /* Dto作成処理 */
        $hiyoKessaiListGetDto = new HiyoKessaiListGetDto();
        $P = $GLOBALS[P]; // 共通パラメータ配列取得
        // 情報検索用パラメータ
        $hiyoKessaiListGetDto->setIncidentId($P['incidentId']);

        /* ロジック処理 */
        $hiyoKessaiListGetLogic = new HiyoKessaiListGetLogic();
        $eventResult = $hiyoKessaiListGetLogic->execute($hiyoKessaiListGetDto);

        /* 戻り値作成処理 */
        $rtnAry = $this->createReturnArray($eventResult);

        // 値を返す(Angular)
        echo $this->returnAngularJSONP($rtnAry);
    }

    public function createReturnArray(HiyoKessaiListGetResultDto $eventResult) {
        $hiyoKessaiListAry = array();

        // 戻り値の作成
        if ($eventResult && $eventResult->getLogicResult() == LOGIC_RESULT_SEIJOU) {
            $hiyoKessaiListAry[] = array("result" => true);

            if ($eventResult->getHiyoKessaiList() && is_array($eventResult->getHiyoKessaiList()) && count($eventResult->getHiyoKessaiList()) > 0) {
                foreach ($eventResult->getHiyoKessaiList() as $hiyoKessai) {
                    $hiyoKessaiAry = array();

                    // 費用決裁申請情報
                    $hiyoKessaiAry["idNo"] = $hiyoKessai->getIdNo();
                    $hiyoKessaiAry["status"] = $hiyoKessai->getStatus();
                    $hiyoKessaiAry["division"] = $hiyoKessai->getDivision();
                    $hiyoKessaiAry["approvalNo"] = $hiyoKessai->getApprovalNo();
                    $hiyoKessaiAry["subject"] = $hiyoKessai->getSubject();
                    $hiyoKessaiAry["amount"] = $hiyoKessai->getAmount();
                    // 1件分の情報をセット
                    $hiyoKessaiListAry[] = $hiyoKessaiAry;
                }
            }
        } else {
            $hiyoKessaiListAry[] = array("result" => false);
        }

        return $hiyoKessaiListAry;
    }

}
