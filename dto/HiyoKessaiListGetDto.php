<?php
//*****************************************************************************
//	システム名　　　：インシデント管理システム
//	サブシステム名　：
//	処理名　　　　　：HiyoKessaiListGetDto
//	作成日付・作成者：2018.02.08 ADF)R.Onishi
//	修正履歴　　　　：
//*****************************************************************************

require_once('./dto/CommonDto.php');

/**
 * Class HiyoKessaiListGetDto
 * @property String $incidentId
 */
class HiyoKessaiListGetDto extends CommonDto {

    /** インシデントID */
    private $incidentId;

    /**
     * @return String
     */
    public function getIncidentId() {
        return $this->incidentId;
    }

    /**
     * @param String $incidentId
     */
    public function setIncidentId($incidentId) {
        $this->incidentId = $incidentId;
    }

}
