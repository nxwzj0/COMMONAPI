<?php
//*****************************************************************************
//	システム名　　　：インシデント管理システム
//	サブシステム名　：
//	処理名　　　　　：UserGetDto
//	作成日付・作成者：2018.02.06 ADF)S.Yoshida
//	修正履歴　　　　：
//*****************************************************************************

require_once('./dto/CommonDto.php');

/**
 * Class UserGetDto
 *
 * @property UserDto[] $user
 */
class UserGetResultDto extends CommonDto {

    private $user;

    /**
     * @return UserDto
     */
    public function getUser() {
        return $this->user;
    }

    /**
     * @param UserDto $user
     */
    public function setUser(UserDto $user) {
        $this->user = $user;
    }

}
