<?php

/**
 * description
 * @author         kevin <askyiwang@gmail.com>
 * @date           2019/3/19
 * @since          1.0
 */

namespace app\commands;

use min\process\BaseProcess;
use Swoole\Http\Client;

class TestCommand
{

    public function startAction()
    {
        $process = new BaseProcess();
        $process->processName = 'Test';
        $process->on('Worker', [$this, 'excute']);
        $process->start();
    }

    /**
     *
     */
    public function excute($data)
    {
        $this->awaitClient($data);
        return;
    }

    /**
     * @param $data
     */
    public function awaitClient($data)
    {
        $JPush = new \JPush\Client('dc5fd52a21f3e2b4d157dd14' ,'37fe864e43e44b3e2dd89d50');
        $response = $this->http_request($data['request_url']);
        list($status, $responseHeader, $body) = $response;
        if ($status && $responseHeader['http_code'] == 200) {
            $this->success();
        } else {
            $this->fail();
        }
    }

    /**
     * @param $data
     */
    public function asyncClient($data)
    {
        echo $data['request_url'].PHP_EOL;
        $cli = new Client($data['request_url'], 80);
        $cli->set([
            'timeout' => 5.0
        ]);
        $cli->setHeaders([
            "Accept" => "text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,image/apng,*/*;q=0.8",
            "Accept-Encoding" => "gzip, deflate",
            "Accept-Language" => "zh-CN,zh;q=0.9,en-US;q=0.8,en;q=0.7,ja;q=0.6,und;q=0.5",
            "Cache-Control" => "no-cache",
            "Connection" => "keep-alive",
            "Cookie" => "browserupdateorg=pause",
            "DNT" => "1",
            "Host" => "mail.ireadercity.com",
            "Pragma" => "no - cache",
            "Upgrade-Insecure-Requests" => "1",
            "User - Agent" => "Mozilla/5.0 (Windows NT 6.1; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/68.0.3440.106 Safari/537.36",
        ]);
        $cli->get('/', function ($cli) {
            var_dump($cli->statusCode);
            if ($cli->statusCode == 200) {
                $this->success();
            } else {
                $this->fail();
            }
            $cli->close();
        });
    }

    /**
     * http 请求
     * @param $url
     * @param array $data
     * @param int $second
     * @return bool|mixed
     */
    function http_request($url, $data = [], $header = [], $second = 5)
    {
        $curl_handle = curl_init();
        curl_setopt($curl_handle, CURLOPT_TIMEOUT, $second);
        curl_setopt($curl_handle, CURLOPT_URL, $url);
        curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl_handle, CURLOPT_HEADER, 0);
        if (!empty($header)) {
            curl_setopt($curl_handle, CURLOPT_HTTPHEADER, $header);
        }
        if (!empty($data)) {
            curl_setopt($curl_handle, CURLOPT_POST, 1);
            curl_setopt($curl_handle, CURLOPT_POSTFIELDS, $data);
        }

        curl_setopt($curl_handle, CURLOPT_SSL_VERIFYHOST, 2);
        curl_setopt($curl_handle, CURLOPT_SSL_VERIFYPEER, 0);
        $response_json = curl_exec($curl_handle);
        //返回结果
        $headerInfo = curl_getinfo($curl_handle);
        if ($response_json) {
            curl_close($curl_handle);
            return [true, $headerInfo, $response_json];
        } else {
            $error = curl_errno($curl_handle);
            curl_close($curl_handle);
            return [false, $headerInfo, $error];
        }
    }

    public function fail()
    {
        var_dump('fail');
    }

    public function success()
    {
        var_dump('success');
    }

}