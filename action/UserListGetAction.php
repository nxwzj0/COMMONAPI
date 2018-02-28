<?php
//*****************************************************************************
//	システム名　　　：共通DBAPI
//	サブシステム名　：
//	処理名　　　　　：ユーザ情報取得処理
//	作成日付・作成者：2018.01.09 ADF)S.Yoshida
//	修正履歴　　　　：
//*****************************************************************************
// 共通処理読み込み
require_once('./action/CommonAction.php');
// dto読み込み
require_once('./dto/UserDto.php');
require_once('./dto/UserListGetDto.php');
require_once('./dto/UserListGetResultDto.php');
// logic処理読み込み
require_once('./logic/UserListGetLogic.php');

class UserListGetAction extends CommonAction {

    public function index() {
        // 戻り値用配列
        $rtnAry = array();

        $P = $GLOBALS[P]; // 共通パラメータ配列取得
        // 画面からパラメータ取得
        $userNmSei = $P['userNmSei'];
        $userNmMei = $P['userNmMei'];
        $sectionCd = $P['sectionCd'];
        $sectionNm = $P['sectionNm'];

        /* Dto作成処理 */
        $userListGetDto = new UserListGetDto();
        // 情報検索用パラメータ
        $userListGetDto->setUserNmSei($userNmSei);
        $userListGetDto->setUserNmMei($userNmMei);
        $userListGetDto->setSectionCd($sectionCd);
        $userListGetDto->setSectionNm($sectionNm);
        // ::: 2018.02.28 [#42] ページング修正：ユーザモーダル Add Start newtouch
        $userListGetDto->setPagingStart($P['pagingStart']);
        $userListGetDto->setPagingEnd($P['pagingEnd']);
        // ::: 2018.02.28 [#42] ページング修正：ユーザモーダル Add End   newtouch

        /* ロジック処理 */
        $userListGetLogic = new UserListGetLogic();
        $eventResult = $userListGetLogic->execute($userListGetDto);

        /* 戻り値作成処理 */
        $rtnAry = $this->createReturnArray($eventResult);
        
        // 値を返す(Angular)
        echo $this->returnAngularJSONP($rtnAry);
    }
    
    public function createReturnArray($eventResult) {
        $userListAry = array();
        
        // 戻り値の作成
        if ($eventResult && $eventResult->getLogicResult() == LOGIC_RESULT_SEIJOU) {
            // ::: 2018.02.28 [#42] ページング修正：ユーザモーダル Del Start newtouch
            // ::: array_push($userListAry, array("result" => true));
            // ::: 2018.02.28 [#42] ページング修正：ユーザモーダル Del End   newtouch
            // ::: 2018.02.28 [#42] ページング修正：ユーザモーダル Add Start newtouch
            $userListAry[] = array("result" => true, "count" => $eventResult->getCount());
            // ::: 2018.02.28 [#42] ページング修正：ユーザモーダル Add End   newtouch
            
            if ($eventResult->getUserList() && is_array($eventResult->getUserList()) && count($eventResult->getUserList()) > 0) {
                foreach ($eventResult->getUserList() as $user) {
                    $userAry = array();

                    // インシデント情報
                    $userAry["userId"] = $user->getUserId();
                    $userAry["userNm"] = $user->getUserNm();
                    $userAry["mail"] = $user->getMail();
                    $userAry["sectionCd"] = $user->getSectionCd();
                    $userAry["sectionNm"] = $user->getSectionNm();
                    $userAry["postCd"] = $user->getPostCd();
                    $userAry["postNm"] = $user->getPostNm();

                    // 1件分の情報をセット
                    // ::: 2018.02.28 [#42] ページング修正：ユーザモーダル Del Start newtouch
                    // ::: array_push($userListAry, $userAry);
                    // ::: 2018.02.28 [#42] ページング修正：ユーザモーダル Del End   newtouch
                    // ::: 2018.02.28 [#42] ページング修正：ユーザモーダル Add Start newtouch
                    $userListAry[] = $userAry;
                    // ::: 2018.02.28 [#42] ページング修正：ユーザモーダル Add End   newtouch
                }
            }
            
        } else {
            // ::: 2018.02.28 [#42] ページング修正：ユーザモーダル Del Start newtouch
            // ::: array_push($userListAry, array("result" => false));
            // ::: 2018.02.28 [#42] ページング修正：ユーザモーダル Del End   newtouch
            // ::: 2018.02.28 [#42] ページング修正：ユーザモーダル Add Start newtouch
            $userListAry[] = array("result" => false);
            // ::: 2018.02.28 [#42] ページング修正：ユーザモーダル Add End   newtouch
        }
        
        return $userListAry;
    }

}
