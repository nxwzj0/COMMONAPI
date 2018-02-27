<?php
//*****************************************************************************
//	システム名　　　：共通DBAPI
//	サブシステム名　：
//	処理名　　　　　：UserGetLogic
//	作成日付・作成者：2018.02.06 ADF)S.Yoshida
//	修正履歴　　　　：
//*****************************************************************************
/* common */
require_once('./logic/CommonLogic.php');
require_once('./inc/const.php');
/* user */
require_once('./model/OEescUserModel.php');
require_once('./dto/UserDto.php');
require_once('./dto/UserGetDto.php');
require_once('./dto/UserGetResultDto.php');

class UserGetLogic extends CommonLogic {

    public function execute(UserGetDto $userGetDto) {
        // 戻りオブジェクト(UserGetResultDto)を作成
        $userGetResultDto = new UserGetResultDto();

        // userGetDtoから、パラメータを取得する、$conditionsを作成
        $userId = $userGetDto->getUserId();

        try {
            // ユーザ情報を取得
            $oEescUserModel = new OEescUserModel();
            $userData = $oEescUserModel->getUser($userId);
        } catch (Exception $e) {
            // LOGIC結果　SQLエラー '1' をセット
            $userGetResultDto->setLogicResult(LOGIC_RESULT_SQL_ERROR);
            // 戻りオブジェクト(UserGetResultDto)
            return $userGetResultDto;
        }

        // ユーザ情報
        if ($userData) {
            // UserDtoを作成
            $userDto = new UserDto();

            // ユーザ情報の取得
            $userDto->setUserId($userData[0]["USER_ID"]);
            $userDto->setUserNm($userData[0]["USER_NM"]);
            $userDto->setMail($userData[0]["MAIL"]);
            $userDto->setPostCd($userData[0]["POST_CD"]);
            $userDto->setPostNm($userData[0]["POST_NM"]);
            $userDto->setSectionCd($userData[0]["SECTION_CD"]);
            $userDto->setSectionNm($userData[0]["SECTION_NM"]);

            // UserDto⇒UserGetResultDtoのセット
            $userGetResultDto->setUser($userDto);
        }

        // LOGIC結果　正常時 '0' をセット
        $userGetResultDto->setLogicResult(LOGIC_RESULT_SEIJOU);
        // 戻りオブジェクト(userGetResultDto)
        return $userGetResultDto;
    }

}
