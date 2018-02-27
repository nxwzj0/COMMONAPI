<?php
//*****************************************************************************
//	システム名　　　：インシデント管理システム
//	サブシステム名　：
//	処理名　　　　　：SetubiListGetResultDto
//	作成日付・作成者：2018.02.19 ADF)S.Yoshida
//	修正履歴　　　　：
//*****************************************************************************

require_once('./dto/CommonDto.php');

/**
 * Class SetubiListGetResultDto
 *
 * @property SetubiDto[] $setubiList
 * @property String $count
 */
class SetubiListGetResultDto extends CommonDto {

    private $setubiList = array();
    private $count;

    /**
     * @return SetubiDto[]
     */
    public function getSetubiList() {
        return $this->setubiList;
    }

    /**
     * @param int $index
     * @return SetubiDto
     */
    public function getSetubi($index = null) {
        if (is_null($index)) {
            return null;
        } else {
            return $this->setubiList[$index];
        }
    }

    /**
     * @param SetubiDto $setubi
     */
    public function addSetubiList(SetubiDto $setubi) {
        $this->setubiList[] = $setubi;
    }

    /**
     * @return String
     */
    public function getCount() {
        return $this->count;
    }

    /**
     * @param String $count
     */
    public function setCount($count) {
        $this->count = $count;
    }

}
