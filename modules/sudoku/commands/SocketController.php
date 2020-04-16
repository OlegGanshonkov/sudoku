<?php

namespace app\modules\sudoku\commands;

use app\modules\sudoku\commands\SudokuServer;
use Ratchet\Http\HttpServer;
use Ratchet\Server\IoServer;
use Ratchet\WebSocket\WsServer;
use yii\console\Controller;

/**
 * Class SudokuController
 * @package app\modules\sudoku\commands
 */
class SocketController extends Controller
{
    /**
     * @param int $port
     * @throws \Exception
     */
    public function actionStart($port = 8082)
    {
        try {
            $pusher = new SudokuServer;
            $wsServer = new WsServer($pusher);
            $server = IoServer::factory(
                new HttpServer(
                    $wsServer
                ),
                $port
            );
            $wsServer->enableKeepAlive($server->loop);
            $server->run();
        } catch (\Exception $exception) {
            throw $exception;
        }

    }
}