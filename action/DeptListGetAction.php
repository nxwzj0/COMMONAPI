<?php
//*****************************************************************************
//	システム名　　　：共通DBAPI
//	サブシステム名　：
//	処理名　　　　　：部門情報取得処理
//	作成日付・作成者：2018.01.19 newtouch
//	修正履歴　　　　：
//*****************************************************************************
// 共通処理読み込み
require_once('./action/CommonAction.php');
// dto読み込み
require_once('./dto/SectionDto.php');
require_once('./dto/DeptDto.php');
require_once('./dto/DeptListGetDto.php');
require_once('./dto/DeptListGetResultDto.php');

// logic処理読み込み
require_once('./logic/DeptListGetLogic.php');

class DeptListGetAction extends CommonAction {

    public function index() {
        // 戻り値用配列
        $rtnAry = array();

        $P = $GLOBALS[P]; // 共通パラメータ配列取得
        /* Dto作成処理 */
        $deptListGetDto = new DeptListGetDto();
        // 部門情報検索用パラメータ
        $deptListGetDto->setPostCd($P['postCd']);
        $deptListGetDto->setSectionNm($P['sectionNm']);
        $deptListGetDto->setCompanyNm($P['companyNm']);

        /* ロジック処理 */
        $deptListGetLogic = new DeptListGetLogic();
        $eventResult = $deptListGetLogic->execute($deptListGetDto);

        /* 戻り値作成処理 */
        $rtnAry = $this->createReturnArray($eventResult);
        
        // 値を返す(Angular)
        echo $this->returnAngularJSONP($rtnAry);
    }
    
    public function createReturnArray(DeptListGetResultDto $eventResult) {
        $deptListAry = array();
        
        // 戻り値の作成
        if ($eventResult && $eventResult->getLogicResult() == LOGIC_RESULT_SEIJOU) {
            array_push($deptListAry, array("result" => true));
            
            if ($eventResult->getDeptList() && is_array($eventResult->getDeptList()) && count($eventResult->getDeptList()) > 0) {
                foreach ($eventResult->getDeptList() as $dept) {
                    $deptAry = array();
 
                    // 部門情報
                    $deptAry["postCd"] = $dept->getPostCd();
                    $deptAry["sectionNm"] = $dept->getSectionNm();
                    $deptAry["companyNm"] = $dept->getCompanyNm();
                    // 1件分の情報をセット
                    array_push($deptListAry, $deptAry);
                }
            }
            
        } else {
            array_push($deptListAry, array("result" => false));
        }
        
        return $deptListAry;
    }

}
