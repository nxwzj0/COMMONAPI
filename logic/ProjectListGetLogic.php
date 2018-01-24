<?php
//*****************************************************************************
//	システム名　　　：インシデント管理システム
//	サブシステム名　：
//	処理名　　　　　：ProjectListGetLogic
//	作成日付・作成者：2018.01.22 newtouch
//	修正履歴　　　　：
//*****************************************************************************
/* common */
require_once('./logic/CommonLogic.php');
require_once('./inc/const.php');
require_once('./common/CommonService.php');
require_once('./dto/SectionDto.php');
require_once('./dto/CommonDto.php');
/* プロジェクト */
require_once('./model/CdosheadModel.php');
require_once('./dto/ProjectDto.php');
require_once('./dto/ProjectListGetDto.php');
require_once('./dto/ProjectListGetResultDto.php');

/**
 * ProjectListGetLogic
 */
class ProjectListGetLogic extends CommonLogic {

    public function execute(ProjectListGetDto $projectListGetDto) {
        // 戻りオブジェクト(ProjectListGetResultDto)を作成
        $projectListGetResultDto = new ProjectListGetResultDto();

        // projectListGetDto、パラメータを取得する、$conditionsを作成
        $conditions = array();
        $conditions['pjNo'] = $projectListGetDto->getPjNo();
        $conditions['inqNo'] = $projectListGetDto->getInqNo();
        $conditions['consumerNm'] = $projectListGetDto->getConsumerNm();
        $conditions['summaryNm'] = $projectListGetDto->getSummaryNm();

        try {
            // プロジェクト情報を取得
            $cdosheadModel = new CdosheadModel();
            $projectList = $cdosheadModel->getProjectList($conditions);
        } catch (Exception $e) {
            // LOGIC結果　SQLエラー '1' をセット
            $IncidentGetResultDto->setLogicResult(LOGIC_RESULT_SQL_ERROR);
            // 戻りオブジェクト(ProjectListGetResultDto)
            return $projectListGetResultDto;
        }

        // 個数分プロジェクト情報リストをループ
        foreach ($projectList as $projectData) {
            // projectDtoを作成
            $projectDto = new ProjectDto();

            // 情報の取得
            $projectDto->setPjId($projectData["PJ_ID"]);
            $projectDto->setPjNo($projectData["PJ_NO"]);
            $projectDto->setInqNo($projectData["INQ_NO"]);
            $projectDto->setConsumerNm($projectData["CONSUMER_NM"]);
            $projectDto->setSummaryNm($projectData["SUMMARY_NM"]);
            // ProjectDto⇒ProjectListGetResultDtoのセット
            $projectListGetResultDto->addProjectList($projectDto);
        }

        // LOGIC結果　正常時 '0' をセット
        $projectListGetResultDto->setLogicResult(LOGIC_RESULT_SEIJOU);
        // 戻りオブジェクト(ProjectListGetResultDto)
        return $projectListGetResultDto;
    }

}
