<?php
//*****************************************************************************
//	システム名　　　：共通DBAPI
//	サブシステム名　：
//	処理名　　　　　：ユーザDto
//	作成日付・作成者：2018.01.09 ADF)S.Yoshida
//	修正履歴　　　　：
//*****************************************************************************

require_once('./dto/SectionDto.php');

/**
 * Class UserDto
 *
 * @property String $userId
 * @property String $userNm
 * @property String $mail
 * @property String $postCd
 * @property String $postNm
 */
class UserDto extends SectionDto{

    private $userId;
    private $userNm;
    private $mail;
    private $postCd;
    private $postNm;

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

    /**
     * @return String
     */
    public function getUserNm() {
        return $this->userNm;
    }

    /**
     * @param String $userNm
     */
    public function setUserNm($userNm) {
        $this->userNm = $userNm;
    }

    /**
     * @return String
     */
    public function getMail() {
        return $this->mail;
    }

    /**
     * @param String $mail
     */
    public function setMail($mail) {
        $this->mail = $mail;
    }

    /**
     * @return String
     */
    public function getPostCd() {
        return $this->postCd;
    }

    /**
     * @param String $postCd
     */
    public function setPostCd($postCd) {
        $this->postCd = $postCd;
    }

    /**
     * @return String
     */
    public function getPostNm() {
        return $this->postNm;
    }

    /**
     * @param String $postNm
     */
    public function setPostNm($postNm) {
        $this->postNm = $postNm;
    }
}
