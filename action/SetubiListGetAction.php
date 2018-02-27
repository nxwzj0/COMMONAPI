<?php
//*****************************************************************************
//	システム名　　　：共通DBAPI
//	サブシステム名　：
//	処理名　　　　　：設備情報取得処理
//	作成日付・作成者：2018.02.19 ADF)S.Yoshida
//	修正履歴　　　　：
//*****************************************************************************
// 共通処理読み込み
require_once('./action/CommonAction.php');
// dto読み込み
require_once('./dto/SetubiDto.php');
require_once('./dto/SetubiListGetDto.php');
require_once('./dto/SetubiListGetResultDto.php');
// logic処理読み込み
require_once('./logic/SetubiListGetLogic.php');

class SetubiListGetAction extends CommonAction {

    public function index() {
        // 戻り値用配列
        $rtnAry = array();

        $P = $GLOBALS[P]; // 共通パラメータ配列取得
        // 画面からパラメータ取得
        $kijoNm = $P['kijoNm'];
        $setubiNm = $P['setubiNm'];
        $pagingStart = $P['pagingStart'];
        $pagingEnd = $P['pagingEnd'];

        /* Dto作成処理 */
        $setubiListGetDto = new SetubiListGetDto();
        // 情報検索用パラメータ
        $setubiListGetDto->setKijoNm($kijoNm);
        $setubiListGetDto->setSetubiNm($setubiNm);
        $setubiListGetDto->setPagingStart($pagingStart);
        $setubiListGetDto->setPagingEnd($pagingEnd);

        /* ロジック処理 */
        $setubiListGetLogic = new SetubiListGetLogic();
        $eventResult = $setubiListGetLogic->execute($setubiListGetDto);

        /* 戻り値作成処理 */
        $rtnAry = $this->createReturnArray($eventResult);

        // 値を返す(Angular)
        echo $this->returnAngularJSONP($rtnAry);
    }

    public function createReturnArray(SetubiListGetResultDto $eventResult) {
        $setubiListAry = array();

        // 戻り値の作成
        if ($eventResult && $eventResult->getLogicResult() == LOGIC_RESULT_SEIJOU) {
            $setubiListAry[] = array("result" => true, "count" => $eventResult->getCount());

            if (is_array($eventResult->getSetubiList()) && count($eventResult->getSetubiList()) > 0) {
                foreach ($eventResult->getSetubiList() as $setubi) {
                    $setubiAry = array();

                    // 設備情報
                    $setubiAry["setubiId"] = $setubi->getSetubiId();
                    $setubiAry["setubiNm"] = $setubi->getSetubiNm();
                    $setubiAry["kijoId"] = $setubi->getKijoId();
                    $setubiAry["kijoNm"] = $setubi->getKijoNm();
                    $setubiAry["jigyosyutaiId"] = $setubi->getJigyosyutaiId();
                    $setubiAry["jigyosyutaiNm"] = $setubi->getJigyosyutaiNm();
                    $setubiAry["prefNm"] = $setubi->getPrefNm();

                    // 1件分の情報をセット
                    $setubiListAry[] = $setubiAry;
                }
            }
        } else {
            $setubiListAry[] = array("result" => false);
        }

        return $setubiListAry;
    }

}
