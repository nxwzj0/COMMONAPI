<?php
//*****************************************************************************
//	システム名　　　：共通DBAPI
//	サブシステム名　：
//	処理名　　　　　：UserGetDto
//	作成日付・作成者：2018.02.06 ADF)S.Yoshida
//	修正履歴　　　　：
//*****************************************************************************

require_once('./dto/CommonDto.php');

/**
 * Class UserGetDto
 * 
 * @property String $userId
 */
class UserGetDto extends CommonDto {

    private $userId;

    /**
     * @return String
     */
    public function getUserId() {
        return $this->userId;
    }

    /**
     * @param String $userId
     */
    public function setUserId($userId) {
        $this->userId = $userId;
    }

}
