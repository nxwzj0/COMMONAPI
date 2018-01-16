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
