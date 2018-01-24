<?php
//*****************************************************************************
//	システム名　　　：インシデント管理システム
//	サブシステム名　：
//	処理名　　　　　：ProjectListGetAction
//	作成日付・作成者：2018.01.22 newtouch
//	修正履歴　　　　：
//*****************************************************************************
// 共通処理読み込み
require_once('./action/CommonAction.php');
// dto読み込み
require_once('./dto/ProjectListGetDto.php');
require_once('./dto/ProjectListGetResultDto.php');
// logic処理読み込み
require_once('./logic/ProjectListGetLogic.php');

class ProjectListGetAction extends CommonAction {

    public function index() {
        // 戻り値用配列
        $rtnAry = array();

        /* Dto作成処理 */
        $projectListGetDto = new ProjectListGetDto();
        $P = $GLOBALS[P]; // 共通パラメータ配列取得
        // 情報検索用パラメータ
        $projectListGetDto->setPjNo($P['pjNo']);
        $projectListGetDto->setInqNo($P['inqNo']);
        $projectListGetDto->setConsumerNm($P['consumerNm']);
        $projectListGetDto->setSummaryNm($P['summaryNm']);

        /* ロジック処理 */
        $projectListGetLogic = new ProjectListGetLogic();
        $eventResult = $projectListGetLogic->execute($projectListGetDto);

        /* 戻り値作成処理 */
        $rtnAry = $this->createReturnArray($eventResult);

        // 値を返す(Angular)
        echo $this->returnAngularJSONP($rtnAry);
    }

    public function createReturnArray(ProjectListGetResultDto $eventResult) {
        $projectListAry = array();

        // 戻り値の作成
        if ($eventResult && $eventResult->getLogicResult() == LOGIC_RESULT_SEIJOU) {
            array_push($projectListAry, array("result" => true));

            if ($eventResult->getProjectList() && is_array($eventResult->getProjectList()) && count($eventResult->getProjectList()) > 0) {
                foreach ($eventResult->getProjectList() as $project) {
                    $projectAry = array();

                    // プロジェクト情報
                    $projectAry["pjId"] = $project->getPjId();
                    $projectAry["pjNo"] = $project->getPjNo();
                    $projectAry["inqNo"] = $project->getInqNo();
                    $projectAry["consumerNm"] = $project->getConsumerNm();
                    $projectAry["summaryNm"] = $project->getSummaryNm();
                    // 1件分の情報をセット
                    array_push($projectListAry, $projectAry);
                }
            }
        } else {
            array_push($projectListAry, array("result" => false));
        }

        return $projectListAry;
    }

}
