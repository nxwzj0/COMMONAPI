<?php
//*****************************************************************************
//	システム名　　　：共通DBAPI
//	サブシステム名　：
//	処理名　　　　　：ユーザ情報取得処理
//	作成日付・作成者：2018.01.09 ADF)S.Yoshida
//	修正履歴　　　　：
//*****************************************************************************
// 共通処理読み込み
require_once('./action/CommonAction.php');
// dto読み込み
require_once('./dto/SectionDto.php');
require_once('./dto/IncidentDto.php');
require_once('./dto/IncidentListGetDto.php');
require_once('./dto/IncidentListGetResultDto.php');

// logic処理読み込み
require_once('./logic/IncidentListGetLogic.php');

class IncidentListGetAction extends CommonAction {

    public function madeCheckboxCondtion($result,$param,$val){
        if($param == null || $param == "" || $param == "false"){
            return $result;
        }elseif($param == "true"){
            if($result == ""){
                $result .= "'".$val."'";
            }else{
                $result .= ","."'".$val."'";
            }
        }
        return $result;
    }
    
    public function index() {
        // 戻り値用配列
        $rtnAry = array();

        /* Dto作成処理 */
        $incidentListGetDto = new IncidentListGetDto();
        $P = $GLOBALS[P]; // 共通パラメータ配列取得
        // 情報検索用パラメータ
        $incidentType = "";
        $incidentType = $this->madeCheckboxCondtion($incidentType,$P["incidentType1"],"1");
        $incidentType = $this->madeCheckboxCondtion($incidentType,$P["incidentType2"],"2");
        $incidentType = $this->madeCheckboxCondtion($incidentType,$P["incidentType3"],"3");
        $incidentType = $this->madeCheckboxCondtion($incidentType,$P["incidentType4"],"4");
        $incidentType = $this->madeCheckboxCondtion($incidentType,$P["incidentType5"],"5");
        $incidentType = $this->madeCheckboxCondtion($incidentType,$P["incidentType6"],"6");
        
        $incidentStatus = "";
        $incidentStatus = $this->madeCheckboxCondtion($incidentStatus,$P["incidentStatus1"],"1");
        $incidentStatus = $this->madeCheckboxCondtion($incidentStatus,$P["incidentStatus2"],"2");
        $incidentStatus = $this->madeCheckboxCondtion($incidentStatus,$P["incidentStatus3"],"3");
        
        $incidentListGetDto->setIncidentNo($P['incidentNo']);
        $incidentListGetDto->setCallContent($P['callContent']);
        $incidentListGetDto->setCallDate($P['callDate']);
        $incidentListGetDto->setCallStartDateFrom($P['callStartDateFrom']);
        $incidentListGetDto->setCallStartDateTo($P['callStartDateTo']);
        $incidentListGetDto->setIncidentType($incidentType);
        $incidentListGetDto->setIncidentStatus($incidentStatus);

        /* ロジック処理 */
        $incidentListGetLogic = new IncidentListGetLogic();
        $eventResult = $incidentListGetLogic->execute($incidentListGetDto);

        /* 戻り値作成処理 */
        $rtnAry = $this->createReturnArray($eventResult);
        
        // 値を返す(Angular)
        echo $this->returnAngularJSONP($rtnAry);
    }
    
    public function createReturnArray(IncidentListGetResultDto $eventResult) {
        $incidentListAry = array();
        
        // 戻り値の作成
        if ($eventResult && $eventResult->getLogicResult() == LOGIC_RESULT_SEIJOU) {
            array_push($incidentListAry, array("result" => true));
            
            if ($eventResult->getIncidentList() && is_array($eventResult->getIncidentList()) && count($eventResult->getIncidentList()) > 0) {
                foreach ($eventResult->getIncidentList() as $incident) {
                    $incidentAry = array();
 
                    // インシデント情報 data?.incidentNo, data?.memo, data?.callDate, data?.incidentType, data?.incidentStatus
                    $incidentAry["incidentNo"] = $incident->getIncidentNo();
                    $incidentAry["callContent"] = $incident->getCallContent();
                    $incidentAry["callDate"] = $incident->getCallDate();
                    $incidentAry["incidentType"] = $incident->getIncidentType();
                    $incidentAry["incidentStatus"] = $incident->getIncidentStatus();
                    // 1件分の情報をセット
                    array_push($incidentListAry, $incidentAry);
                }
            }
            
        } else {
            array_push($incidentListAry, array("result" => false));
        }
        
        return $incidentListAry;
    }

}
