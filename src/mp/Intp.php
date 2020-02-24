<?php


namespace fize\third\wechat\mp;

use fize\third\wechat\Mp;

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
