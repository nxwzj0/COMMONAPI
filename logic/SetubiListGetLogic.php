<?php
//*****************************************************************************
//	システム名　　　：共通DBAPI
//	サブシステム名　：
//	処理名　　　　　：SetubiListGetLogic
//	作成日付・作成者：2018.02.19 ADF)S.Yoshida
//	修正履歴　　　　：
//*****************************************************************************
/* common */
require_once('./logic/CommonLogic.php');
require_once('./inc/const.php');
/* setubi */
require_once('./model/VSetubiModel.php');
require_once('./dto/SetubiDto.php');
require_once('./dto/SetubiListGetDto.php');
require_once('./dto/SetubiListGetResultDto.php');

class SetubiListGetLogic extends CommonLogic {

    public function execute(SetubiListGetDto $setubiListGetDto) {
        // 戻りオブジェクト(SetubiListGetResultDto)を作成
        $setubiListGetResultDto = new SetubiListGetResultDto();

        // setubiListGetResultDtoから、パラメータを取得する、$conditionsを作成
        $conditions = array();
        $conditions['kijoNm'] = $setubiListGetDto->getKijoNm();
        $conditions['setubiNm'] = $setubiListGetDto->getSetubiNm();
        $conditions['paginStart'] = $setubiListGetDto->getPagingStart();
        $conditions['paginEnd'] = $setubiListGetDto->getPagingEnd();

        try {
            // 設備情報を取得
            $vSetubiModel = new VSetubiModel();
            $setubiList = $vSetubiModel->getSetubiList($conditions);
            $setubiListCount = $vSetubiModel->getSetubiListCount($conditions);
        } catch (Exception $e) {
            // LOGIC結果　SQLエラー '1' をセット
            $setubiListGetResultDto->setLogicResult(LOGIC_RESULT_SQL_ERROR);
            // 戻りオブジェクト(SetubiListGetResultDto)
            return $setubiListGetResultDto;
        }

        // 個数分ユーザ情報リストをループ
        foreach ($setubiList as $setubiData) {
            // SetubiDtoを作成
            $setubiDto = new SetubiDto();

            // ユーザ情報の取得
            $setubiDto->setSetubiId($setubiData["SETUBI_ID"]);
            $setubiDto->setSetubiNm($setubiData["SETUBI_NM"]);
            $setubiDto->setKijoId($setubiData["KIJO_ID"]);
            $setubiDto->setKijoNm($setubiData["KIJO_NM"]);
            $setubiDto->setJigyosyutaiId($setubiData["JIGYSYUT_CD"]);
            $setubiDto->setJigyosyutaiNm($setubiData["JIGYSYUT_NM"]);
            $setubiDto->setPrefNm($setubiData["TODOFUKEN"]);

            // setubiDto⇒setubiListGetResultDtoのセット
            $setubiListGetResultDto->addSetubiList($setubiDto);
        }

        if ($setubiListCount) {
            $setubiListGetResultDto->setCount($setubiListCount["COUNT"]);
        }

        // LOGIC結果　正常時 '0' をセット
        $setubiListGetResultDto->setLogicResult(LOGIC_RESULT_SEIJOU);
        // 戻りオブジェクト(SetubiListGetResultDto)
        return $setubiListGetResultDto;
    }

}
