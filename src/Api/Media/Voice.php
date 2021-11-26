<?php


namespace Fize\Third\Wechat\Api\Media;

use CURLFile;
use Fize\Third\Wechat\Api;

/**
 * 语音
 */
class Voice extends Api
{

    /**
     * 提交语音
     * @param string $file 语音MP3文件
     * @param string $voice_id 唯一标识
     * @param string $lang 语言
     */
    public function addvoicetorecofortext($file, $voice_id, $lang = 'zh_CN')
    {
        $params = [
            'media' => new CURLFile(realpath($file))
        ];
        $this->httpPost("/media/voice/addvoicetorecofortext?access_token={$this->accessToken}&format=&voice_id={$voice_id}&lang={$lang}", $params, false);
    }

    /**
     * 获取语音识别结果
     * @param string $voice_id 唯一标识
     * @param string $lang 语言
     * @return string
     */
    public function queryrecoresultfortext($voice_id, $lang = 'zh_CN')
    {
        $params = [
            'voice_id' => $voice_id,
            'lang' => $lang
        ];
        $result = $this->httpPost("/media/voice/queryrecoresultfortext?access_token={$this->accessToken}", $params, false);
        return $result['result'];
    }

    /**
     * 微信翻译
     * @param string $file 语音MP3文件
     * @param string $lfrom 源语言
     * @param string $lto 目标语言
     */
    public function translatecontent($file, $lfrom, $lto)
    {
        $params = [
            'media' => new CURLFile(realpath($file))
        ];
        $this->httpPost("/media/voice/translatecontent?access_token={$this->accessToken}&lfrom={$lfrom}&lto={$lto}", $params, false);
    }
}
