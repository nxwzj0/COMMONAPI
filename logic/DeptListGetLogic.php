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
require_once('./model/EescSectionModel.php');
require_once('./dto/DeptDto.php');
require_once('./dto/DeptListGetDto.php');
require_once('./dto/DeptListGetResultDto.php');

/**
 * Dept service
 */
class DeptListGetLogic extends CommonLogic {

    public function execute(DeptListGetDto $deptListGetDto) {
        // 戻りオブジェクト(DeptListGetResultDto)を作成
        $deptListGetResultDto = new DeptListGetResultDto();
        // CommonServiceを作成
        $CommonService = new CommonService();

        // deptListGetDtoから、パラメータを取得する、$conditionsを作成
        $conditions = array();
        $conditions['postCd'] = $deptListGetDto->getPostCd();
        $conditions['sectionNm'] = $deptListGetDto->getSectionNm();
        $conditions['companyNm'] = $deptListGetDto->getCompanyNm();

        try {
            // ユーザ情報を取得
            $eescSectionModel = new EescSectionModel();
            $deptList = $eescSectionModel->getDeptList($conditions);
        } catch (Exception $e) {
            // LOGIC結果　SQLエラー '1' をセット
            $IncidentGetResultDto->setLogicResult(LOGIC_RESULT_SQL_ERROR);
            // 戻りオブジェクト(UserListGetResultDto)
            return $deptListGetResultDto;
        }

        // 個数分ユーザ情報リストをループ
        foreach ($deptList as $deptData) {
            // deptDtoを作成
            $deptDto = new DeptDto();

            // ユーザ情報の取得
//                    T1.職制コード POST_CD
//                    ,T1.簡略名 SECTION_NM
//                    ,T1.会社コード COMPANY_CD
//                    ,T1.会社名 COMPANY_NM
            $deptDto->setPostCd($deptData["POST_CD"]);
            $deptDto->setSectionNm($deptData["SECTION_NM"]);
            $deptDto->setCompanyCd($deptData["COMPANY_CD"]);
            $deptDto->setCompanyNm($deptData["COMPANY_NM"]);
            // DeptDto⇒DeptListGetResultDtoのセット
            $deptListGetResultDto->addDeptList($deptDto);
        }

        // LOGIC結果　正常時 '0' をセット
        $deptListGetResultDto->setLogicResult(LOGIC_RESULT_SEIJOU);
        // 戻りオブジェクト(userListGetResultDto)
        return $deptListGetResultDto;
    }

}