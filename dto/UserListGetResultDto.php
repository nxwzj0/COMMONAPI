<?php
//*****************************************************************************
//	システム名　　　：インシデント管理システム
//	サブシステム名　：
//	処理名　　　　　：UserListGetDto
//	作成日付・作成者：2018.01.09 ADF)S.Yoshida
//	修正履歴　　　　：
//*****************************************************************************

require_once('./dto/CommonDto.php');

/**
 * Class UserListGetDto
 *
 * @property UserDto[] $userList
 */
class UserListGetResultDto extends CommonDto{
    
    private $userList = array();
 
     /**
     * @return UserDto[]
     */
    public function getUserList() {
        return $this->userList;
    }

    /**
     * @param int $index
     * @return UserDto
     */
    public function getUser($index = null) {
        if (is_null($index)) {
            return null;
        } else {
            return $this->userList[$index];
        }
    }

    /**
     * @param UserDto $userList
     */
    public function addUserList(UserDto $userList) {
        $this->userList[] = $userList;
    }
 
}
