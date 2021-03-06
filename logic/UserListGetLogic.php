<?php
//*****************************************************************************
//	システム名　　　：共通DBAPI
//	サブシステム名　：
//	処理名　　　　　：UserListGetLogic
//	作成日付・作成者：2018.01.09 ADF)S.Yoshida
//	修正履歴　　　　：
//*****************************************************************************
/* common */
require_once('./logic/CommonLogic.php');
require_once('./inc/const.php');
/* user */
require_once('./model/OEescUserModel.php');
require_once('./dto/UserDto.php');
require_once('./dto/UserListGetDto.php');
require_once('./dto/UserListGetResultDto.php');

class UserListGetLogic extends CommonLogic {

    public function execute(UserListGetDto $userListGetDto) {
        // 戻りオブジェクト(UserListGetResultDto)を作成
        $userListGetResultDto = new UserListGetResultDto();

        // userListGetDtoから、パラメータを取得する、$conditionsを作成
        $conditions = array();
        $conditions['userNmSei'] = $userListGetDto->getUserNmSei();
        $conditions['userNmMei'] = $userListGetDto->getUserNmMei();
        $conditions['sectionCd'] = $userListGetDto->getSectionCd();
        $conditions['sectionNm'] = $userListGetDto->getSectionNm();
        // ::: 2018.02.28 [#42] ページング修正：ユーザモーダル Add Start newtouch
        $conditions['pagingStart'] = $userListGetDto->getPagingStart();
        $conditions['pagingEnd'] = $userListGetDto->getPagingEnd();
        // ::: 2018.02.28 [#42] ページング修正：ユーザモーダル Add End   newtouch

        try {
            // ユーザ情報を取得
            $oEescUserModel = new OEescUserModel();
            $userList = $oEescUserModel->getUserList($conditions);
            // ::: 2018.02.28 [#42] ページング修正：ユーザモーダル Add Start newtouch
            $userListCount = $oEescUserModel->getUserListCount($conditions);
            // ::: 2018.02.28 [#42] ページング修正：ユーザモーダル Add End   newtouch
        } catch (Exception $e) {
            // LOGIC結果　SQLエラー '1' をセット
            $userListGetResultDto->setLogicResult(LOGIC_RESULT_SQL_ERROR);
            // 戻りオブジェクト(UserListGetResultDto)
            return $userListGetResultDto;
        }

        // 個数分ユーザ情報リストをループ
        foreach ($userList as $userData) {
            // IncidentDtoを作成
            $userDto = new UserDto();

            // ユーザ情報の取得
            $userDto->setUserId($userData["USER_ID"]);
            $userDto->setUserNm($userData["USER_NM"]);
            $userDto->setMail($userData["MAIL"]);
            $userDto->setPostCd($userData["POST_CD"]);
            $userDto->setPostNm($userData["POST_NM"]);
            $userDto->setSectionCd($userData["SECTION_CD"]);
            $userDto->setSectionNm($userData["SECTION_NM"]);

            // UserDto⇒UserListGetResultDtoのセット
            $userListGetResultDto->addUserList($userDto);
        }

        // ::: 2018.02.28 [#42] ページング修正：ユーザモーダル Add Start newtouch
        if ($userListCount) {
            $userListGetResultDto->setCount($userListCount["COUNT"]);
        }
        // ::: 2018.02.28 [#42] ページング修正：ユーザモーダル Add End   newtouch
        
        // LOGIC結果　正常時 '0' をセット
        $userListGetResultDto->setLogicResult(LOGIC_RESULT_SEIJOU);
        // 戻りオブジェクト(userListGetResultDto)
        return $userListGetResultDto;
    }

}
