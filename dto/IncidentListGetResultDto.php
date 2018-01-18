<?php
require_once('./dto/CommonDto.php');

/**
 * Class IncidentListGetDto
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
