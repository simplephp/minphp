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
        go(function() {
            $cli = new \Swoole\Coroutine\Http\Client('127.0.0.1', 80);
            $cli->setHeaders([
                'Host' => "localhost",
                "User-Agent" => 'Chrome/49.0.2587.3',
                'Accept' => 'text/html,application/xhtml+xml,application/xml',
                'Accept-Encoding' => 'gzip',
            ]);
            $cli->set([ 'timeout' => 1]);
            $cli->get('/index.php');

            $cli->close();
            return [];
            yield $cli->body;
        });
    }
}