<?php
//*****************************************************************************
//	システム名　　　：共通DBAPI
//	サブシステム名　：
//	処理名　　　　　：共通DB処理
//	作成日付・作成者：2018.01.09 ADF)S.Yoshida
//	修正履歴　　　　：
//*****************************************************************************

class CommonModel {

    // IN句の条件文字列を作成する
    public function getInConditionStrByArray($condition,$len) {
        $count = 0;
        foreach($condition as $one) {
            if ($one != NULL) {
                $inConditionStr = $inConditionStr . "'" . $one . "'";
                if (++$count !== $len) {
                    $inConditionStr = $inConditionStr . " , ";
                }
            }
        }
        return $inConditionStr;
    }
}

