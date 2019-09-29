<?php

namespace Jundat\Cert\Model;

class Post implements \Jundat\Cert\Api\PostInterface
{
    protected $remoteAddress;

    public function __construct(
        \Magento\Framework\HTTP\PhpEnvironment\RemoteAddress $remoteAddress
    ) {
        $this->remoteAddress = $remoteAddress;
    }

    /**
     * {@inheritdoc}
     */
    public function get($value)
    {
        $temp = $this->remoteAddress->getRemoteHost();
        return 'get api with params: ' . $value . '-' . $temp;
//        return 'get api with params: '.$value;
    }
}
