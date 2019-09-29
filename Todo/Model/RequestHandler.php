<?php

namespace Jundat\Todo\Model;

class RequestHandler
{
    /**
     * @param \Jundat\Todo\Model\AsyncTestData $simpleDataItem
     */
    public function process($simpleDataItem)
    {
        file_put_contents(
            $simpleDataItem->getTextFilePath(),
            'InvokedFromRequestHandler-' . $simpleDataItem->getValue() . PHP_EOL,
            FILE_APPEND
        );
    }
}
