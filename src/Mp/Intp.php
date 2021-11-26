<?php


namespace Fize\Third\Wechat\Mp;

use Fize\Third\Wechat\Mp;

class Intp extends Mp
{

    /**
     * 获取用户IP
     * @return array
     */
    public function getuserclientip()
    {
        return $this->httpGet("/intp/getuserclientip");
    }
}
