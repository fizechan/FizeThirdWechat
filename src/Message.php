<?php


namespace fize\third\wechat;


class Message
{

    /**
     * @var string
     */
    protected $token;

    protected $encrypt_type;

    protected $encodingAesKey;

    /**
     * 构造
     * @param array $options 配置参数
     */
    public function __construct(array $options)
    {
        $this->token = isset($options['token']) ? $options['token'] : '';
        $this->encodingAesKey = isset($options['encodingaeskey']) ? $options['encodingaeskey'] : '';
    }
}
