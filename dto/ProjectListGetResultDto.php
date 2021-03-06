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
 * @property String $count
 */
class ProjectListGetResultDto extends CommonDto {

    private $projectList = array();
    private $count;

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
     * @param ProjectDto $project
     */
    public function addProjectList(ProjectDto $project) {
        $this->projectList[] = $project;
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
