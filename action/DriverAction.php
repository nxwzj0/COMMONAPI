<?php
//*****************************************************************************
//	システム名　　　：共通DBAPI
//	サブシステム名　：
//	処理名　　　　　：テスト用ドライバアクション
//	作成日付・作成者：2018.01.09 ADF)S.Yoshida
//	修正履歴　　　　：
//*****************************************************************************
// 共通処理読み込み
require_once('./action/CommonAction.php');

// dto読み込み
// todo
require_once('./dto/UserDto.php');
require_once('./dto/SectionDto.php');

// logic処理読み込み
require_once('./logic/UserListGetLogic.php');

class DriverAction extends CommonAction {

    public function index() {
        // 戻り値用配列
        $rtnAry = array();

//        /* パラメータ取得処理 */
//        $postdata = $this->getRequestJSONData();
//        if ($postdata != false) {
//            // パラメータを取得
//            $request = json_decode($postdata);
//        } else {
//            // パラメータの取得に失敗
//            array_push($rtnAry, array("result" => false));
//            echo json_encode($rtnAry);
//            exit;
//        }

        /* Dto作成処理 */
        // todo
//        $CreateArrayDto = new CreateArrayDto();
//        foreach ($request as $user) {
//            // ユーザオブジェクトを作成
//            $userDto = new UserDto();
//            $userDto->setId($user->id);
//            $userDto->setName($user->name);
//
//            $CreateArrayDto->addUserList($userDto);
//        }

        /* ロジック処理 */
        // @property CreateArrayResultDto $eventResult
        //todo
        //$CreateArrayLogic = new CreateArrayLogic();
        //$eventResult = $CreateArrayLogic->execute($CreateArrayDto);
        // #3セット値
        $IncidentGetDto = new IncidentGetDto();
//        $IncidentGetDto->setIncidentId('10');
        $IncidentGetDto->setRelateFlg(FALSE);
        $IncidentGetDto->setLogFlg(FALSE);

        // #4セット値
        $IncidentListGetDto = new IncidentListGetDto();
//        $IncidentListGetDto->setIncidentId('10');
        $IncidentListGetDto->setRelateFlg(FALSE);
        $IncidentListGetDto->setLogFlg(FALSE);
        
//        $IncidentListGetDto->setProductType('1');
//        $IncidentListGetDto->setIncidentStartDateTimeFrom('1999/12/30 00:00:00');
//        $IncidentListGetDto->setIncidentStartDateTimeTo('1999/12/30 02:00:00');
//        $IncidentListGetDto->setCallStartDateFrom('1999/12/30 00:00:00');
//        $IncidentListGetDto->setCallStartDateTo('1999/12/31 02:00:00');
//        $IncidentListGetDto->setCallEndDateFrom('1999/12/30 00:00:00');
//        $IncidentListGetDto->setCallEndDateTo('1999/12/31 02:00:00');
//        $IncidentListGetDto->setTaioStartDateFrom('1999/12/30 00:00:00');
//        $IncidentListGetDto->setTaioStartDateTo('1999/12/31 02:00:00');
//        $IncidentListGetDto->setTaioEndDateFrom('1999/12/30 00:00:00');
//        $IncidentListGetDto->setTaioEndDateTo('1999/12/31 02:00:00');
//        $IncidentListGetDto->setActDateFrom('1999/12/30 00:00:00');
//        $IncidentListGetDto->setActDateTo('1999/12/31 02:00:00');
//        $IncidentListGetDto->setActStartTimeFrom('1999/12/30 00:00:00');
//        $IncidentListGetDto->setActStartTimeTo('1999/12/31 02:00:00');
//        $IncidentListGetDto->setActEndTimeFrom('1999/12/30 00:00:00');
//        $IncidentListGetDto->setActEndTimeTo('1999/12/31 02:00:00');
        
        // #5セット値
        $IncidentSaveDto = new IncidentSaveDto();
        $IncidentDto = new IncidentDto();
        $IncidentMainDto = new IncidentMainDto();


        $loginuserDto = new UserDto();
        $loginuserDto->setUserId('newUId');
        $loginuserDto->setUserNm('newUrNm');
        $loginuserDto->setSectionCd('newSCd');
        $loginuserDto->setSectionNm('newSNm');

        $relateuserDto1 = new UserDto();

        $relateuserDto1->setUserId('USER01');
        $relateuserDto1->setUserNm('関係者ユーザ01');
        $relateuserDto1->setSectionCd('SECTION1');
        $relateuserDto1->setSectionNm('関係者ユーザ部門名01');
        $IncidentMainDto->addRelateList($relateuserDto1);

        $relateuserDto2 = new UserDto();

        $relateuserDto2->setUserId('USER02');
        $relateuserDto2->setUserNm('関係者ユーザ02');
        $relateuserDto2->setSectionCd('SECTION2');
        $relateuserDto2->setSectionNm('関係者ユーザ部門名02');
        $IncidentMainDto->addRelateList($relateuserDto2);

        $relateuserDto10 = new UserDto();

        $relateuserDto10->setUserId('USER10');
        $relateuserDto10->setUserNm('関係者ユーザ10');
        $relateuserDto10->setSectionCd('SECTIO10');
        $relateuserDto10->setSectionNm('関係者ユーザ部門名10');
        $IncidentMainDto->addRelateList($relateuserDto10);

        $IncidentSaveDto->setLoginUser($loginuserDto);

        $IncidentMainDto->setincidentId(2000);
        $IncidentMainDto->setIncidentStsCd(1);
        $IncidentMainDto->setIncidentTypeCd(2);
        $IncidentMainDto->setParentIncidentNo(PARENT01);
        $IncidentMainDto->setIncidentStartDateTime('1899/12/30 01:00:00');
        $IncidentMainDto->setInfoSource('情報提供元01');
        $IncidentMainDto->setInfoProvider('情報提供者名01');
        $IncidentMainDto->setInfoProviderTel(13840912123);
        $IncidentMainDto->setMemo('注記01');
        $IncidentMainDto->setKijoId('KI00001');
        $IncidentMainDto->setKijoNm('機場名01');
        $IncidentMainDto->setJigyosyutaiId('JI001');
        $IncidentMainDto->setJigyosyutaiNm('事業主体名01');
        $IncidentMainDto->setSetubiId('SI001');
        $IncidentMainDto->setSetubiNm('設備名01');
        $IncidentMainDto->setPrefId(01);
        $IncidentMainDto->setPrefNm('府県名01');
        $IncidentMainDto->setDeliveryPjNo('DPNO01');
        $IncidentMainDto->setDeliveryPjNm('納入プロジェクト名01');
        $IncidentMainDto->setCustId('CI001');
        $IncidentMainDto->setCustNm('顧客名01');
        $IncidentMainDto->setCustTypeCd('C1');
        $IncidentMainDto->setCustTypeNm('分類名01');
        $IncidentMainDto->setCustDept('会社名・所属部署01');
        $IncidentMainDto->setRequester('依頼者名01');
        $IncidentMainDto->setContactTel('TEL001');
        $IncidentMainDto->setContactFax('FAX001');
        $IncidentMainDto->setContactMail('mail001');
        $SectionDto = new SectionDto();
        $SectionDto->setSectionCd('SDC01');
        $SectionDto->setSectionNm('営業部門名01');
        $IncidentMainDto->setSalesDept($SectionDto);
        $UserDto = new UserDto();
        $UserDto->setUserId('SUI');
        $UserDto->setUserNm(SUN);
        $IncidentMainDto->setSalesUser($UserDto);
        $SectionDto = new SectionDto();
        $SectionDto->setSectionCd(SDC);
        $SectionDto->setSectionNm(SDN);
        $IncidentMainDto->setSkanDept($SectionDto);
        $UserDto = new UserDto();
        $UserDto->setUserId(SUI);
        $UserDto->setUserNm(SUN);
        $IncidentMainDto->setSkanUser($UserDto);
        $IncidentMainDto->setCallStartDate('1899/12/30 01:00:00');
        $IncidentMainDto->setCallEndDate('1899/12/30 01:00:00');
        $SectionDto = new SectionDto();
        $SectionDto->setSectionCd('CDC');
        $SectionDto->setSectionNm('CDN');
        $IncidentMainDto->setCallDept($SectionDto);
        $UserDto = new UserDto();
        $UserDto->setUserId('CUC');
        $UserDto->setUserNm('CUN');
        $IncidentMainDto->setCallUser($UserDto);
        $IncidentMainDto->setCallTel('CT');
        $IncidentMainDto->setCallMail('CM');
        $IncidentMainDto->setCallContent('CC');
        $IncidentMainDto->setTaioStartDate('1899/12/30 01:00:00');
        $IncidentMainDto->setTaioEndDate('1899/12/30 01:00:00');
        $SectionDto = new SectionDto();
        $SectionDto->setSectionCd('TDC');
        $SectionDto->setSectionNm('TDN');
        $IncidentMainDto->setTaioDept($SectionDto);
        $UserDto = new UserDto();
        $UserDto->setUserId('TI');
        $UserDto->setUserNm('TN');
        $IncidentMainDto->setTaioUser($UserDto);
        $IncidentMainDto->setTaioTel('TT');
        $IncidentMainDto->setTaioMail('TM');
        $IncidentMainDto->setTaioContent(1);
        $IncidentMainDto->setActDate('1899/12/30 01:00:00');
        $IncidentMainDto->setActType(1);
        $IncidentMainDto->setActStartTime('1899/12/30 01:00:00');
        $IncidentMainDto->setActEndTime('1899/12/30 01:00:00');
        $SectionDto = new SectionDto();
        $SectionDto->setSectionCd('ADC');
        $SectionDto->setSectionNm('ADN');
        $IncidentMainDto->setActDept($SectionDto);
        $UserDto = new UserDto();
        $UserDto->setUserId('AUI');
        $UserDto->setUserNm('AUN');
        $IncidentMainDto->setActUser($UserDto);
        $IncidentMainDto->setActTel('AC');
        $IncidentMainDto->setActMail('AM');
        $IncidentMainDto->setActContent('AC');
        $IncidentMainDto->setProductType('PT');
        $IncidentMainDto->setProductTrigger('PT');
        $IncidentMainDto->setProductHindo('PH');
        $IncidentMainDto->setProductGensyo('PG');
        $IncidentMainDto->setProductStatus('PS');
//        $IncidentMainDto->setInsDate();
//        $IncidentMainDto->setInsUserId();
//        $IncidentMainDto->setInsUserNm();
//        $IncidentMainDto->setInsSectionCd();
//        $IncidentMainDto->setInsSectionNm();



        $IncidentDto->setIncidentMainInfo($IncidentMainDto);
        $IncidentSaveDto->setIncidentInfo($IncidentDto);
//        // #5実行
//        $IncidentSaveLogic = new IncidentSaveLogic();
//        $eventResult = $IncidentSaveLogic->execute($IncidentSaveDto);
        // #4実行
        $IncidentListGetLogic = new IncidentListGetLogic();
        $eventResult = $IncidentListGetLogic->execute($IncidentListGetDto);
//        // #3実行
//        $IncidentGetLogic = new IncidentGetLogic();
//        $eventResult = $IncidentGetLogic->execute($IncidentGetDto);

//        echo mb_detect_encoding($eventResult->getIncidentInfo()->getIncidentMainInfo()->getSalesDept()->getSectionNm());
//        echo $eventResult->getIncidentInfo()->getIncidentMainInfo()->getSalesDept()->getSectionNm();
//        echo mb_convert_encoding($eventResult->getIncidentInfo()->getIncidentMainInfo()->getSalesDept()->getSectionNm(), 'UTF-8');

//        print_r($eventResult);
        var_dump($eventResult);
        for( $i=0; $i<count($eventResult->getIncidentList());$i++){
            var_dump($eventResult->getIncident($i));
        }
//        var_dump($eventResult->getIncident(0)->getIncidentMainInfo()->getRelateList());
//        var_dump($eventResult->getIncident(0)->GetRelateLink());

//        var_dump($eventResult->getIncidentInfo()->getIncidentMainInfo()->getRelateList());
//        var_dump($eventResult->getIncidentInfo()->GetRelateLink());
//        var_dump($eventResult->getIncidentInfo()->getLogList());
//        var_dump($eventResult->getIncidentInfo()->getLog(0));

//        print_r($eventResult->getIncidentInfo()->getIncidentMainInfo()->getSalesDept()->getSectionNm());

//        $log;
//        $name = "test";
//        $logpath = $GLOBALS["COMMON_DEBUG_LOG_PATH"];
//        if ($logpath != "") {
//            $this->log = new Logging($logpath);
//        }
//        $str = $this->vd($eventResult);
//        $str = $this->vd($json_xencode($eventResult));
//        $str = $this->json_xencode($eventResult);
//        $str = $eventResult->getIncidentInfo()->getIncidentMainInfo()->getSalesDept()->getSectionNm();

//        if (DEBUG_LOGGING_LEVEL > 0) {
//            if ($this->log)
//                $this->log->write("*$this->name:$str", TRUE);
//        }

//        print $this->vd($eventResult);
        exit();
        /* 戻り値作成処理 */
//        if (isset($eventResult)) {
//            // ロジック処理に成功
//            array_push($rtnAry, array("result" => true));
//            foreach ($eventResult->getResultAry() as $result) {
//                array_push($rtnAry, $result);
//            }
//        } else {
//            // ロジック処理に失敗
//            array_push($rtnAry, array("result" => false));
//            echo json_encode($rtnAry);
//            exit;
//        }
//        // 値を返す
//        echo json_encode($eventResult);
    }

//    function vd($variable) {
//        $dump_object = '';
//        ob_start();
//        {
//            var_dump($variable);
//            $dump_object = ob_get_contents();
//        }
//        ob_end_clean();
//        return '<pre>' . $dump_object . '</pre>';
//    }

}
