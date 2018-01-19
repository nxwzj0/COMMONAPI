<?php
//*****************************************************************************
//	システム名　　　：インシデント管理システム
//	サブシステム名　：
//	処理名　　　　　：DeptListGetResultDto
//	作成日付・作成者：2018.01.19 newtouch
//	修正履歴　　　　：
//*****************************************************************************

require_once('./dto/CommonDto.php');

/**
 * Class DeptListGetResultDto
 *
 * @property DeptDto[] $deptList
 */
class DeptListGetResultDto extends CommonDto{
    
    private $deptList = array();
 
     /**
     * @return DeptDto[]
     */
    public function getDeptList() {
        return $this->deptList;
    }

    /**
     * @param int $index
     * @return DeptDto
     */
    public function getDept($index = null) {
        if (is_null($index)) {
            return null;
        } else {
            return $this->deptList[$index];
        }
    }

    /**
     * @param DeptDto $deptList
     */
    public function addDeptList(DeptDto $deptList) {
        $this->deptList[] = $deptList;
    }
 
}
