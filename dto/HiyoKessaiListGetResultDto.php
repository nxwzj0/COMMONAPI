<?php
//*****************************************************************************
//	システム名　　　：インシデント管理システム
//	サブシステム名　：
//	処理名　　　　　：HiyoKessaiListGetResultDto
//	作成日付・作成者：2018.02.08 ADF)R.Onishi
//	修正履歴　　　　：
//*****************************************************************************

require_once('./dto/CommonDto.php');

/**
 * Class HiyoKessaiListGetResultDto
 *
 * @property HiyoKessaiDto[] $hiyoKessaiList
 */
class HiyoKessaiListGetResultDto extends CommonDto {

    private $hiyoKessaiList = array();

    /**
     * @return HiyoKessaiDto[]
     */
    public function getHiyoKessaiList() {
        return $this->hiyoKessaiList;
    }

    /**
     * @param int $index
     * @return HiyoKessaiDto
     */
    public function getHiyoKessai($index = null) {
        if (is_null($index)) {
            return null;
        } else {
            return $this->hiyoKessaiList[$index];
        }
    }

    /**
     * @param HiyoKessaiDto $hiyoKessaiList
     */
    public function addHiyoKessaiList(HiyoKessaiDto $hiyoKessai) {
        $this->hiyoKessaiList[] = $hiyoKessai;
    }

}
