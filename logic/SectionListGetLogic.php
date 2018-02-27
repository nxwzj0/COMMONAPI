<?php
//*****************************************************************************
//	システム名　　　：共通DBAPI
//	サブシステム名　：
//	処理名　　　　　：SectionListGetLogic
//	作成日付・作成者：2018.01.19 newtouch
//	修正履歴　　　　：
//*****************************************************************************
/* common */
require_once('./logic/CommonLogic.php');
require_once('./inc/const.php');
/* section */
require_once('./model/EescSectionModel.php');
require_once('./dto/SectionDto.php');
require_once('./dto/SectionListGetDto.php');
require_once('./dto/SectionListGetResultDto.php');

/**
 * SectionListGetLogic
 */
class SectionListGetLogic extends CommonLogic {

    public function execute(SectionListGetDto $sectionListGetDto) {
        // 戻りオブジェクト(SectionListGetResultDto)を作成
        $sectionListGetResultDto = new SectionListGetResultDto();

        // sectionListGetDtoから、パラメータを取得する、$conditionsを作成
        $conditions = array();
        $conditions['postCd'] = $sectionListGetDto->getPostCd();
        $conditions['sectionNm'] = $sectionListGetDto->getSectionNm();
        $conditions['companyNm'] = $sectionListGetDto->getCompanyNm();
        // ::: 2018.02.27 [#41] ページング修正：部門モーダル Add Start newtouch
        $conditions['pagingStart'] = $sectionListGetDto->getPagingStart();
        $conditions['pagingEnd'] = $sectionListGetDto->getPagingEnd();
        // ::: 2018.02.27 [#41] ページング修正：部門モーダル Add End   newtouch

        try {
            // 部門情報を取得
            $eescSectionModel = new EescSectionModel();
            $sectionList = $eescSectionModel->getSectionList($conditions);
            // ::: 2018.02.27 [#41] ページング修正：部門モーダル Add Start newtouch
            $sectionListCount = $eescSectionModel->getSectionListCount($conditions);
            // ::: 2018.02.27 [#41] ページング修正：部門モーダル Add End   newtouch
        } catch (Exception $e) {
            // LOGIC結果　SQLエラー '1' をセット
            $sectionListGetResultDto->setLogicResult(LOGIC_RESULT_SQL_ERROR);
            // 戻りオブジェクト(UserListGetResultDto)
            return $sectionListGetResultDto;
        }

        // 個数分部門情報リストをループ
        foreach ($sectionList as $sectionData) {
            // sectionDtoを作成
            $sectionDto = new SectionDto();

            // 部門情報の取得
            $sectionDto->setPostCd($sectionData["POST_CD"]);
            $sectionDto->setSectionNm($sectionData["SECTION_NM"]);
            $sectionDto->setCompanyCd($sectionData["COMPANY_CD"]);
            $sectionDto->setCompanyNm($sectionData["COMPANY_NM"]);
            // SectionDto⇒SectionListGetResultDtoのセット
            $sectionListGetResultDto->addSectionList($sectionDto);
        }

        // ::: 2018.02.27 [#41] ページング修正：部門モーダル Add Start newtouch
        if ($sectionListCount) {
            $sectionListGetResultDto->setCount($sectionListCount["COUNT"]);
        }
        // ::: 2018.02.27 [#41] ページング修正：部門モーダル Add End   newtouch

        // LOGIC結果　正常時 '0' をセット
        $sectionListGetResultDto->setLogicResult(LOGIC_RESULT_SEIJOU);
        // 戻りオブジェクト(sectionListGetResultDto)
        return $sectionListGetResultDto;
    }

}
