<?php
//*****************************************************************************
//	システム名　　　：インシデント管理システム
//	サブシステム名　：
//	処理名　　　　　：SectionListGetResultDto
//	作成日付・作成者：2018.01.19 newtouch
//	修正履歴　　　　：
//*****************************************************************************

require_once('./dto/CommonDto.php');

/**
 * Class SectionListGetResultDto
 *
 * @property SectionDto[] $sectionList
 * @property String $count
 */
class SectionListGetResultDto extends CommonDto {

    private $sectionList = array();
    private $count;

    /**
     * @return SectionDto[]
     */
    public function getSectionList() {
        return $this->sectionList;
    }

    /**
     * @param int $index
     * @return SectionDto
     */
    public function getSection($index = null) {
        if (is_null($index)) {
            return null;
        } else {
            return $this->sectionList[$index];
        }
    }

    /**
     * @param SectionDto $sectionList
     */
    public function addSectionList(SectionDto $sectionList) {
        $this->sectionList[] = $sectionList;
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
