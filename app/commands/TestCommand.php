<?php

/**
 * description
 * @author         kevin <askyiwang@gmail.com>
 * @date           2019/3/19
 * @since          1.0
 */
namespace app\commands;

class TestCommand
{

    public function startAction() {

        $cli = new \Swoole\Http\Client('https://www.baidu.com', 80);
        $cli->setHeaders([
            'Host' => "https://www.baidu.com",
            "User-Agent" => 'Chrome/49.0.2587.3',
            'Accept' => 'text/html,application/xhtml+xml,application/xml',
            'Accept-Encoding' => 'gzip',
        ]);
        $cli->set([ 'timeout' => 1]);
        $cli->get('/', function ($cli) {
            if($cli->statusCode == 200) {
                $this->success();
            } else {
                $this->fail();
            }
        });
        return [];
    }

    public function fail() {
        var_dump('fail');
    }

    public function success() {
        var_dump('success');
    }

}