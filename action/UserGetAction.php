<?php
//*****************************************************************************
//	システム名　　　：共通DBAPI
//	サブシステム名　：
//	処理名　　　　　：ユーザ情報取得処理
//	作成日付・作成者：2018.02.06 ADF)S.Yoshida
//	修正履歴　　　　：
//*****************************************************************************
// 共通処理読み込み
require_once('./action/CommonAction.php');
// dto読み込み
require_once('./dto/UserDto.php');
require_once('./dto/UserGetDto.php');
require_once('./dto/UserGetResultDto.php');
// logic処理読み込み
require_once('./logic/UserGetLogic.php');

class UserGetAction extends CommonAction {

    public function index() {
        // 戻り値用配列
        $rtnAry = array();

        $P = $GLOBALS[P]; // 共通パラメータ配列取得
        // 画面からパラメータ取得
        $userId = $P['userId'];

        /* Dto作成処理 */
        $userGetDto = new UserGetDto();
        // 情報検索用パラメータ
        $userGetDto->setUserId($userId);

        /* ロジック処理 */
        $userGetLogic = new UserGetLogic();
        $eventResult = $userGetLogic->execute($userGetDto);

        /* 戻り値作成処理 */
        $rtnAry = $this->createReturnArray($eventResult);

        // 値を返す(Angular)
        echo $this->returnAngularJSONP($rtnAry);
    }

    public function createReturnArray($eventResult) {
        $resultAry = array();

        // 戻り値の作成
        if ($eventResult && $eventResult->getLogicResult() == LOGIC_RESULT_SEIJOU) {
            $resultAry[] = array("result" => true);

            if ($eventResult->getUser()) {
                $userAry = array();
                $user = $eventResult->getUser();
                // インシデント情報
                $userAry["userId"] = $user->getUserId();
                $userAry["userNm"] = $user->getUserNm();
                $userAry["mail"] = $user->getMail();
                $userAry["sectionCd"] = $user->getSectionCd();
                $userAry["sectionNm"] = $user->getSectionNm();
                $userAry["postCd"] = $user->getPostCd();
                $userAry["postNm"] = $user->getPostNm();

                $userAry["callback"] = $_GET[ANGULAR_CALLBACK_FUNCTION];

                // 1件分の情報をセット
                $resultAry[] = $userAry;
            }
        } else {
            $resultAry[] = array("result" => false);
        }

        return $resultAry;
    }

}
