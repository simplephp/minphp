<?php

/**
 * description
 * @author         kevin <askyiwang@gmail.com>
 * @date           2019/3/19
 * @since          1.0
 */

namespace app\commands;

use min\console\BaseCommand;
use min\process\BaseProcess;

class TestCommand extends BaseCommand
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
        $response = $this->http_request($data['request_url']);
        list($status, $responseHeader, $body) = $response;
        if ($status && $responseHeader['http_code'] == 200) {
            $this->success();
        } else {
            $this->fail();
        }
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