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
                    T1.CUST_ACCT_SITE_ID AS CUSTOMER_CD
                    ,T1.FORMAL_CUST_NAME_1 ||' '||T1.FORMAL_CUST_NAME_2 AS CUSTOMER_NM
                    ,T1.ADDRESS1 AS ADDRESS
                FROM
                    EBS_CUSTOMER_SITES T1 
                WHERE
                    1 = 1
SQL_USER_INFO;

        if ($conditions['customerCd'] != NULL) {
            $SQL_USER_INFO = $SQL_USER_INFO . " AND T1.CUST_ACCT_SITE_ID LIKE " . "'" . $conditions['customerCd'] . "%' ";
        }

        if ($conditions['customerNm'] != NULL) {
            $SQL_USER_INFO = $SQL_USER_INFO . " AND( T1.FORMAL_CUST_NAME_1 LIKE " . "'%" . $conditions['customerNm'] . "%' ";
            $SQL_USER_INFO = $SQL_USER_INFO . " OR T1.FORMAL_CUST_NAME_2 LIKE " . "'%" . $conditions['customerNm'] . "%' ";
            $SQL_USER_INFO = $SQL_USER_INFO . " OR T1.FORMAL_CUST_NAME_3 LIKE " . "'%" . $conditions['customerNm'] . "%' )";
        }

        if ($conditions['address'] != NULL) {
            $SQL_USER_INFO = $SQL_USER_INFO . " AND T1.ADDRESS1 LIKE " . "'%" . $conditions['address'] . "%' ";
        }

        $MultiExecSql = new MultiExecSql();
        $sqlResult = array();
        $MultiExecSql->getResultData($SQL_USER_INFO, $sqlResult);
        return $sqlResult;
    }

}
