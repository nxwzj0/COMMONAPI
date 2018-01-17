<?php
//*****************************************************************************
//	システム名　　　：共通DBAPI
//	サブシステム名　：
//	処理名　　　　　：UserListGetLogic
//	作成日付・作成者：2018.01.09 ADF)S.Yoshida
//	修正履歴　　　　：
//*****************************************************************************
/* common */
require_once('./logic/CommonLogic.php');
require_once('./inc/const.php');
require_once('./common/CommonService.php');
require_once('./dto/SectionDto.php');
require_once('./dto/CommonDto.php');
/* dept */
require_once('./model/CdosheadModel.php');
require_once('./dto/ProjDto.php');
require_once('./dto/ProjListGetDto.php');
require_once('./dto/ProjListGetResultDto.php');

/**
 * Proj service
 */
class ProjListGetLogic extends CommonLogic {

    public function execute(ProjListGetDto $projListGetDto) {
        // 戻りオブジェクト(ProjListGetResultDto)を作成
        $projListGetResultDto = new ProjListGetResultDto();

        // deptListGetDtoから、パラメータを取得する、$conditionsを作成
        $conditions = array();
        $conditions['pjNo'] = $projListGetDto->getPjNo();
        $conditions['inqNo'] = $projListGetDto->getInqNo();
        $conditions['consumerNm'] = $projListGetDto->getConsumerNm();
        $conditions['summaryNm'] = $projListGetDto->getSummaryNm();

        try {
            // ユーザ情報を取得
            $cdosheadModel = new CdosheadModel();
            $projList = $cdosheadModel->getProjList($conditions);
        } catch (Exception $e) {
            // LOGIC結果　SQLエラー '1' をセット
            $IncidentGetResultDto->setLogicResult(LOGIC_RESULT_SQL_ERROR);
            // 戻りオブジェクト(UserListGetResultDto)
            return $projListGetResultDto;
        }

        // 個数分ユーザ情報リストをループ
        foreach ($projList as $projData) {
            // projDtoを作成
            $projDto = new ProjDto();

            // 情報の取得
            $projDto->setPjId($projData["PJ_ID"]);
            $projDto->setPjNo($projData["PJ_NO"]);
            $projDto->setInqNo($projData["INQ_NO"]);
            $projDto->setConsumerNm($projData["CONSUMER_NM"]);
            $projDto->setSummaryNm($projData["SUMMARY_NM"]);
            // ProjDto⇒ProjListGetResultDtoのセット
            $projListGetResultDto->addProjList($projDto);
        }

        // LOGIC結果　正常時 '0' をセット
        $projListGetResultDto->setLogicResult(LOGIC_RESULT_SEIJOU);
        // 戻りオブジェクト(userListGetResultDto)
        return $projListGetResultDto;
    }

}
