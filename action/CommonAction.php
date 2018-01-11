<?php

//*****************************************************************************
//	システム名　　　：インシデント管理システム
//	サブシステム名　：
//	処理名　　　　　：共通ACTION処理
//	作成日付・作成者：2017.10.05 ADF)S.Yoshida
//	修正履歴　　　　：
//*****************************************************************************

class CommonAction {

    // リクエストパラメータを取得
    function getRequestJSONData() {
        $postdata = file_get_contents("php://input");
        if ($postdata === FALSE) {
            // パラメータの取得に失敗した場合は、falseを返す
            return false;
        } else {
            return $postdata;
        }
    }

    // PHP→Javascript
    // 値チェック処理
    function json_safe_encode($data) {
        return json_encode($data, JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT);
    }

    /**
     * PHP5.4からでないと対応していないUnicodeアンエスケープをPHP5.3でもできるようにしたラッパー関数
     * @param mixed   $value
     * @param int     $options
     * @param boolean $unescapee_unicode
     */
    function json_xencode($value, $options = 0, $unescapee_unicode = true) {
        $v = json_encode($value, $options);
        if ($unescapee_unicode) {
            $v = $this->unicode_encode($v);
            // スラッシュのエスケープをアンエスケープする
            $v = preg_replace('/\\\\\//', '/', $v);
        }
        return $v;
    }

    /**
     * Unicodeエスケープされた文字列をUTF-8文字列に戻す。
     * 参考:http://d.hatena.ne.jp/iizukaw/20090422
     * @param unknown_type $str
     */
    function unicode_encode($str) {
        return preg_replace_callback("/\\\\u([0-9a-zA-Z]{4})/", "encode_callback", $str);
    }

    /**
     * AngularとのJSONPでの通信　結果をAngularへ返す
     * @param mixed   $rtnArray
     */
    function returnAngularJSONP($rtnArray){
        return $_GET[ANGULAR_CALLBACK_FUNCTION] . '('.$this->json_xencode($rtnArray).')';
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

function encode_callback($matches) {
    return mb_convert_encoding(pack("H*", $matches[1]), "UTF-8", "UTF-16");
}
