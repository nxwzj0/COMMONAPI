<?php
//*****************************************************************************
//	システム名　　　：インシデント管理システム
//	サブシステム名　：
//	処理名　　　　　：ProjectListGetResultDto
//	作成日付・作成者：2018.01.22 newtouch
//	修正履歴　　　　：
//*****************************************************************************

require_once('./dto/CommonDto.php');

/**
 * Class ProjectListGetResultDto
 *
 * @property ProjectDto[] $projectList
 */
class ProjectListGetResultDto extends CommonDto {

    private $projectList = array();

    /**
     * @return ProjectDto[]
     */
    public function getProjectList() {
        return $this->projectList;
    }

    /**
     * @param int $index
     * @return ProjectDto
     */
    public function getProject($index = null) {
        if (is_null($index)) {
            return null;
        } else {
            return $this->projectList[$index];
        }
    }

    /**
     * @param ProjectDto $projectList
     */
    public function addProjectList(ProjectDto $projectList) {
        $this->projectList[] = $projectList;
    }

}
