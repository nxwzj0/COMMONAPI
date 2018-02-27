<?php
//*****************************************************************************
//	システム名　　　：インシデント管理システム
//	サブシステム名　：
//	処理名　　　　　：HiyoKessaiListGetLogic
//	作成日付・作成者：2018.02.08 ADF)R.Onishi
//	修正履歴　　　　：
//*****************************************************************************
/* common */
require_once('./logic/CommonLogic.php');
require_once('./inc/const.php');
/* プロジェクト */
require_once('./model/VHiyoKessaiShougaiIncidentModel.php');
require_once('./model/VHiyoKessaiClaimIncidentModel.php');
require_once('./dto/HiyoKessaiDto.php');
require_once('./dto/HiyoKessaiListGetDto.php');
require_once('./dto/HiyoKessaiListGetResultDto.php');

/**
 * HiyoKessaiListGetLogic
 */
class HiyoKessaiListGetLogic extends CommonLogic {

    public function execute(HiyoKessaiListGetDto $hiyoKessaiListGetDto) {
        // 戻りオブジェクト(HiyoKessaiListGetResultDto)を作成
        $hiyoKessaiListGetResultDto = new HiyoKessaiListGetResultDto();

        // hiyoKessaiListGetDto、パラメータを取得する、$conditionsを作成
        $conditions = array();
        $conditions['incidentId'] = $hiyoKessaiListGetDto->getIncidentId();

        try {
            // 費用決裁申請情報を取得
            $vHiyoKessaiShougaiIncidentModel = new VHiyoKessaiShougaiIncidentModel();
            $hiyoKessaiShougaiIncidentList = $vHiyoKessaiShougaiIncidentModel->getHiyoKessaiShougaiIncidentList($conditions);
            $vHiyoKessaiClaimIncidentModel = new VHiyoKessaiClaimIncidentModel();
            $hiyoKessaiClaimIncidentList = $vHiyoKessaiClaimIncidentModel->getHiyoKessaiClaimIncidentList($conditions);
        } catch (Exception $e) {
            // LOGIC結果　SQLエラー '1' をセット
            $hiyoKessaiListGetResultDto->setLogicResult(LOGIC_RESULT_SQL_ERROR);
            // 戻りオブジェクト(HiyoKessaiListGetResultDto)
            return $hiyoKessaiListGetResultDto;
        }

        // 個数分「障害対応費用決裁申請」情報リストをループ
        foreach ($hiyoKessaiShougaiIncidentList as $hiyoKessaiData) {
            // hiyoKessaiDtoを作成
            $hiyoKessaiDto = new HiyoKessaiDto();
            // 情報の取得
            $hiyoKessaiDto->setIdNo($hiyoKessaiData["ID_NO"]);
            $hiyoKessaiDto->setStatus($hiyoKessaiData["STATUS"]);
            $hiyoKessaiDto->setDivision(HIYO_KESSAI_TYPE_NAME_SHOUGAI);
            $hiyoKessaiDto->setApprovalNo($hiyoKessaiData["APPROVAL_NO"]);
            $hiyoKessaiDto->setSubject($hiyoKessaiData["SUBJECT"]);
            $hiyoKessaiDto->setAmount($hiyoKessaiData["AMOUNT"]);
            // HiyoKessaiDto⇒HiyoKessaiListGetResultDtoのセット
            $hiyoKessaiListGetResultDto->addHiyoKessaiList($hiyoKessaiDto);
        }
        // 個数分「クレーム対応費用決裁申請」情報リストをループ
        foreach ($hiyoKessaiClaimIncidentList as $hiyoKessaiData) {
            // hiyoKessaiDtoを作成
            $hiyoKessaiDto = new HiyoKessaiDto();

            // 情報の取得
            $hiyoKessaiDto->setIdNo($hiyoKessaiData["ID_NO"]);
            $hiyoKessaiDto->setStatus($hiyoKessaiData["STATUS"]);
            $hiyoKessaiDto->setDivision(HIYO_KESSAI_TYPE_NAME_CLAME);
            $hiyoKessaiDto->setApprovalNo($hiyoKessaiData["APPROVAL_NO"]);
            $hiyoKessaiDto->setSubject($hiyoKessaiData["SUBJECT"]);
            $hiyoKessaiDto->setAmount($hiyoKessaiData["AMOUNT"]);
            // HiyoKessaiDto⇒HiyoKessaiListGetResultDtoのセット
            $hiyoKessaiListGetResultDto->addHiyoKessaiList($hiyoKessaiDto);
        }

        // LOGIC結果　正常時 '0' をセット
        $hiyoKessaiListGetResultDto->setLogicResult(LOGIC_RESULT_SEIJOU);
        // 戻りオブジェクト(HiyoKessaiListGetResultDto)
        return $hiyoKessaiListGetResultDto;
    }

}
