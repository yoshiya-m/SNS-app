<?php


namespace Middleware;

use Response\HTTPRenderer;



class HttpLoggingMiddleware implements Middleware{
    public function handle(callable $next): HTTPRenderer
    {
        $logFile = "error.log";
        // 最初にリクエストを記録
        error_log(sprintf("URI: %s\n", $_SERVER['REQUEST_URI']), 3, $logFile);
        error_log(sprintf("REQUEST METHOD: %s\n", $_SERVER['REQUEST_METHOD']), 3, $logFile);
        error_log(sprintf("TIMESTAMP: %s\n",  date("Y-m-d H:i:s") ), 3, $logFile);
        error_log(sprintf("QUERY PARAMETERS: %s\n", $_SERVER['QUERY_STRING']), 3, $logFile);
        $headers = getallheaders();
        foreach ($headers as $name => $value) {
            error_log("$name: $value\n", 3, $logFile);
        }
        

        // 次に他のミドルウェアを実行
        // 最後に他のリクエストがおわった後に、ステータスコード、応答時間、ヘッダーなどの詳細をログに記録
        // このミドルウェアを一番最初に実行する
        // 受信したリクエストの詳細（URL、リクエストメソッド、タイムスタンプ、クエリパラメーター、ヘッダーなど）をログに記録


        $response = $next();


        return $response;
    }
}