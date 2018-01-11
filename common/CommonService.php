<?php

class CommonService {

    // リクエストタイプを確認
    function checkRequestType($requestType) {
        if ($requestType == $_SERVER['REQUEST_METHOD']) {
            // リクエストタイプが一致
            return true;
        } else {
            // リクエストタイプが不一致
            return false;
        }
    }

    /**
     * 定数配列から安全に値を取り出す
     * @param const $constArray 定数配列
     * @param string $constKey 定数キー
     * @return type 定数
     */
    public static function getConstArrayString($constArray, $constKey) {
        return isset($constArray[$constKey]) ? $constArray[$constKey] : NULL;
    }

}

