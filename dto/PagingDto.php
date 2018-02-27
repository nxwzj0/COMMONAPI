<?php
//*****************************************************************************
//	システム名　　　：共通DBAPI
//	サブシステム名　：
//	処理名　　　　　：ページングDto
//	作成日付・作成者：2018.02.19 ADF)S.Yoshida
//	修正履歴　　　　：
//*****************************************************************************

require_once('./dto/CommonDto.php');

/**
 * Class PagingDto
 *
 * @property String $pagingStart
 * @property String $pagingEnd
 */
class PagingDto extends CommonDto {
    private $pagingStart;
    private $pagingEnd;

    /**
     * @return String
     */
    public function getPagingStart() {
        return $this->pagingStart;
    }

    /**
     * @param String $pagingStart
     */
    public function setPagingStart($pagingStart) {
        $this->pagingStart = $pagingStart;
    }

    /**
     * @return String
     */
    public function getPagingEnd() {
        return $this->pagingEnd;
    }

    /**
     * @param String $pagingEnd
     */
    public function setPagingEnd($pagingEnd) {
        $this->pagingEnd = $pagingEnd;
    }

}
