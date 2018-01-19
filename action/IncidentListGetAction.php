<?php
//*****************************************************************************
//	システム名　　　：共通DBAPI
//	サブシステム名　：
//	処理名　　　　　：インシデント情報取得処理
//	作成日付・作成者：2018.01.18 newtouch
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
    
    public function index() {
        // 戻り値用配列
        $rtnAry = array();

        /* Dto作成処理 */
        $incidentListGetDto = new IncidentListGetDto();
        $P = $GLOBALS[P]; // 共通パラメータ配列取得
        // 情報検索用パラメータ
        $incidentType = "";
        $incidentType = $this->madeCheckboxCondtion($incidentType,$P["incidentTypeSyougai"],"1");
        $incidentType = $this->madeCheckboxCondtion($incidentType,$P["incidentTypeJiko"],"2");
        $incidentType = $this->madeCheckboxCondtion($incidentType,$P["incidentTypeClaim"],"3");
        $incidentType = $this->madeCheckboxCondtion($incidentType,$P["incidentTypeToiawase"],"4");
        $incidentType = $this->madeCheckboxCondtion($incidentType,$P["incidentTypeInfo"],"5");
        $incidentType = $this->madeCheckboxCondtion($incidentType,$P["incidentTypeOther"],"6");
        
        $incidentStatus = "";
        $incidentStatus = $this->madeCheckboxCondtion($incidentStatus,$P["incidentStatusCall"],"1");
        $incidentStatus = $this->madeCheckboxCondtion($incidentStatus,$P["incidentStatusTaio"],"2");
        $incidentStatus = $this->madeCheckboxCondtion($incidentStatus,$P["incidentStatusAct"],"3");
        
        $incidentListGetDto->setIncidentNo($P['incidentNo']);
        $incidentListGetDto->setCallContent($P['callContent']);
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
 
                    // インシデント情報
                    $incidentAry["incidentNo"] = $incident->getIncidentNo();
                    $incidentAry["callContent"] = $incident->getCallContent();
                    $incidentAry["callDate"] = $incident->getCallDate();
                    $incidentAry["callDateTime"] = $incident->getCallDateTime();
                    $incidentAry["incidentType"] = $incident->getIncidentType();
                    $incidentAry["incidentTypeString"] = $incident->getIncidentTypeString();
                    $incidentAry["incidentStatus"] = $incident->getIncidentStatus();
                    $incidentAry["incidentStatusString"] = $incident->getIncidentStatusString();
                    // 1件分の情報をセット
                    array_push($incidentListAry, $incidentAry);
                }
            }
            
        } else {
            array_push($incidentListAry, array("result" => false));
        }
        
        return $incidentListAry;
    }

    /**
     * チェックボックスの状態に応じて検索条件を作成する
     * @param type $result 結果
     * @param type $param チェックボックスの状態
     * @param type $val 対応する値
     * @return string
     */
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
}
