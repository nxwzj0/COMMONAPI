<?php

//*****************************************************************************
//	システム名　　　：共通DBAPI
//	サブシステム名　：
//	処理名　　　　　：EbsCustomerSitesModel
//	作成日付・作成者：2018.01.19 newtouch
//	修正履歴　　　　：
//*****************************************************************************

require_once("./model/CommonModel.php");

/**
 * EbsCustomerSitesModel
 */
class EbsCustomerSitesModel extends CommonModel {

    public function getCustomerList($conditions) {
        $SQL_USER_INFO = <<< SQL_USER_INFO
                SELECT 
                    T1.CUST_ACCOUNT_ID AS CUSTOMER_CD
                    ,T1.FORMAL_CUST_NAME_1 ||' '||T1.FORMAL_CUST_NAME_2 ||' '||T1.FORMAL_CUST_NAME_3 AS CUSTOMER_NM
                    ,T1.ADDRESS1 AS ADDRESS
                FROM
                    EBS_CUSTOMER_SITES T1 
                WHERE
                    1 = 1
SQL_USER_INFO;

        if ($conditions['customerCd'] != NULL) {
            $SQL_USER_INFO = $SQL_USER_INFO . " AND " . CMN_MakeLikeCond(" " . "T1.CUST_ACCT_SITE_ID", $conditions['customerCd'], "", "%") . " ";
        }

        if ($conditions['customerNm'] != NULL) {
            $SQL_USER_INFO = $SQL_USER_INFO . " AND( " . CMN_MakeLikeCond(" " . "T1.FORMAL_CUST_NAME_1", $conditions['customerNm'], "%", "%") . " ";
            $SQL_USER_INFO = $SQL_USER_INFO . " OR " . CMN_MakeLikeCond(" " . "T1.FORMAL_CUST_NAME_2", $conditions['customerNm'], "%", "%") . " ";
            $SQL_USER_INFO = $SQL_USER_INFO . " OR " . CMN_MakeLikeCond(" " . "T1.FORMAL_CUST_NAME_3", $conditions['customerNm'], "%", "%") . " ) ";
        }

        if ($conditions['address'] != NULL) {
            $SQL_USER_INFO = $SQL_USER_INFO . " AND " . CMN_MakeLikeCond(" " . "T1.ADDRESS1", $conditions['address'], "%", "%") . " ";
        }

        $SQL_USER_INFO .= " ORDER BY T1.CUST_ACCT_SITE_ID ASC ";

        $html = "";
        $arr = array();

        $tpl = new ExecTemplate($html, $SQL_USER_INFO);
        $tpl->setResultDataArray($arr);
        if ($conditions['pagingStart'] != NULL && $conditions['pagingEnd'] != NULL) {
            $tpl->getResult($conditions['pagingStart'], $conditions['pagingEnd']); // ページング
        } else {
            $tpl->getResult(); // ページング無し
        }
        return $arr;
    }

    public function getCustomerListCount($conditions){
        $SQL_USER_INFO = <<< SQL_USER_INFO
                SELECT 
                    count(*) COUNT
                FROM
                    EBS_CUSTOMER_SITES T1 
                WHERE
                    1 = 1
SQL_USER_INFO;

        if ($conditions['customerCd'] != NULL) {
            $SQL_USER_INFO = $SQL_USER_INFO . " AND " . CMN_MakeLikeCond(" " . "T1.CUST_ACCT_SITE_ID", $conditions['customerCd'], "", "%") . " ";
        }

        if ($conditions['customerNm'] != NULL) {
            $SQL_USER_INFO = $SQL_USER_INFO . " AND( " . CMN_MakeLikeCond(" " . "T1.FORMAL_CUST_NAME_1", $conditions['customerNm'], "%", "%") . " ";
            $SQL_USER_INFO = $SQL_USER_INFO . " OR " . CMN_MakeLikeCond(" " . "T1.FORMAL_CUST_NAME_2", $conditions['customerNm'], "%", "%") . " ";
            $SQL_USER_INFO = $SQL_USER_INFO . " OR " . CMN_MakeLikeCond(" " . "T1.FORMAL_CUST_NAME_3", $conditions['customerNm'], "%", "%") . " ) ";
        }

        if ($conditions['address'] != NULL) {
            $SQL_USER_INFO = $SQL_USER_INFO . " AND " . CMN_MakeLikeCond(" " . "T1.ADDRESS1", $conditions['address'], "%", "%") . " ";
        }

        $html = "";
        $arr = array();

        $tpl = new ExecTemplate($html, $SQL_USER_INFO);
        $tpl->setResultDataArray($arr);
        $tpl->getResult(); // ページング無し
        return $arr[0];
    }
}
