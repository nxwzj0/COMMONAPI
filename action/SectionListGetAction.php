<?php
//*****************************************************************************
//	システム名　　　：共通DBAPI
//	サブシステム名　：
//	処理名　　　　　：SectionListGetAction
//	作成日付・作成者：2018.01.19 newtouch
//	修正履歴　　　　：
//*****************************************************************************
// 共通処理読み込み
require_once('./action/CommonAction.php');
// dto読み込み
require_once('./dto/SectionListGetDto.php');
require_once('./dto/SectionListGetResultDto.php');
// logic処理読み込み
require_once('./logic/SectionListGetLogic.php');

class SectionListGetAction extends CommonAction {

    public function index() {
        // 戻り値用配列
        $rtnAry = array();

        $P = $GLOBALS[P]; // 共通パラメータ配列取得
        /* Dto作成処理 */
        $sectionListGetDto = new SectionListGetDto();
        // 部門情報検索用パラメータ
        $sectionListGetDto->setPostCd($P['postCd']);
        $sectionListGetDto->setSectionNm($P['sectionNm']);
        $sectionListGetDto->setCompanyNm($P['companyNm']);
        // ::: 2018.02.27 [#41] ページング修正：部門モーダル Add Start newtouch
        $sectionListGetDto->setPagingStart($P['pagingStart']);
        $sectionListGetDto->setPagingEnd($P['pagingEnd']);
        // ::: 2018.02.27 [#41] ページング修正：部門モーダル Add End   newtouch

        /* ロジック処理 */
        $sectionListGetLogic = new SectionListGetLogic();
        $eventResult = $sectionListGetLogic->execute($sectionListGetDto);

        /* 戻り値作成処理 */
        $rtnAry = $this->createReturnArray($eventResult);

        // 値を返す(Angular)
        echo $this->returnAngularJSONP($rtnAry);
    }

    public function createReturnArray(SectionListGetResultDto $eventResult) {
        $sectionListAry = array();

        // 戻り値の作成
        if ($eventResult && $eventResult->getLogicResult() == LOGIC_RESULT_SEIJOU) {
            // ::: 2018.02.27 [#41] ページング修正：部門モーダル Del Start newtouch
            // ::: array_push($sectionListAry, array("result" => true));
            // ::: 2018.02.27 [#41] ページング修正：部門モーダル Del End   newtouch
            // ::: 2018.02.27 [#41] ページング修正：部門モーダル Add Start newtouch
            $sectionListAry[] = array("result" => true, "count" => $eventResult->getCount());
            // ::: 2018.02.27 [#41] ページング修正：部門モーダル Add End   newtouch

            if ($eventResult->getSectionList() && is_array($eventResult->getSectionList()) && count($eventResult->getSectionList()) > 0) {
                foreach ($eventResult->getSectionList() as $section) {
                    $sectionAry = array();

                    // 部門情報
                    $sectionAry["postCd"] = $section->getPostCd();
                    $sectionAry["sectionNm"] = $section->getSectionNm();
                    $sectionAry["companyNm"] = $section->getCompanyNm();
                    // 1件分の情報をセット
                    // ::: 2018.02.27 [#41] ページング修正：部門モーダル Del Start newtouch
                    // ::: array_push($sectionListAry, $sectionAry);
                    // ::: 2018.02.27 [#41] ページング修正：部門モーダル Del End   newtouch
                    // ::: 2018.02.27 [#41] ページング修正：部門モーダル Add Start newtouch
                    $sectionListAry[] = $sectionAry;
                    // ::: 2018.02.27 [#41] ページング修正：部門モーダル Add End   newtouch

                }
            }
        } else {
            // ::: 2018.02.27 [#41] ページング修正：部門モーダル Del Start newtouch
            // :::             array_push($sectionListAry, array("result" => false));
            // ::: 2018.02.27 [#41] ページング修正：部門モーダル Del End   newtouch
            // ::: 2018.02.27 [#41] ページング修正：部門モーダル Add Start newtouch
            $sectionListAry[] = array("result" => false);
            // ::: 2018.02.27 [#41] ページング修正：部門モーダル Add End   newtouch
        }

        return $sectionListAry;
    }

}
