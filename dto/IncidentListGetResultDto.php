<?php
//*****************************************************************************
//	システム名　　　：共通DBAPI
//	サブシステム名　：
//	処理名　　　　　：IncidentListGetResultDto
//	作成日付・作成者：2018.01.19 newtouch
//	修正履歴　　　　：
//*****************************************************************************
require_once('./dto/CommonDto.php');

/**
 * Class IncidentListGetResultDto
 *
 * @property IncidentDto[] $incidentList
 */
class IncidentListGetResultDto extends CommonDto{
    
    private $incidentList = array();

    /**
     * @return IncidentDto[]
     */
    public function getIncidentList() {
        return $this->incidentList;
    }

    /**
     * @param int $index
     * @return IncidentDto
     */
    public function getIncident($index = null) {
        if (is_null($index)) {
            return null;
        } else {
            return $this->incidentList[$index];
        }
    }

    /**
     * @param IncidentDto $incidentList
     */
    public function addIncidentList(IncidentDto $incidentList) {
        $this->incidentList[] = $incidentList;
    }
 
}
