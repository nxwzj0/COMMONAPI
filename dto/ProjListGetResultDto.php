<?php
//*****************************************************************************
//	システム名　　　：インシデント管理システム
//	サブシステム名　：
//	処理名　　　　　：DeptListGetDto
//	作成日付・作成者：2018.01.09 ADF)S.Yoshida
//	修正履歴　　　　：
//*****************************************************************************

require_once('./dto/CommonDto.php');

/**
 * Class UserListGetDto
 *
 * @property DeptDto[] $projList
 */
class ProjListGetResultDto extends CommonDto{
    
    private $projList = array();
 
     /**
     * @return ProjDto[]
     */
    public function getProjList() {
        return $this->projList;
    }

    /**
     * @param int $index
     * @return ProjDto
     */
    public function getProj($index = null) {
        if (is_null($index)) {
            return null;
        } else {
            return $this->projList[$index];
        }
    }

    /**
     * @param ProjDto $projList
     */
    public function addProjList(ProjDto $projList) {
        $this->projList[] = $projList;
    }
 
}
