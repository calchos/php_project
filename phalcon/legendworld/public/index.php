<?php

use Phalcon\Loader;
use Phalcon\Mvc\View;
use Phalcon\Mvc\Application;
use Phalcon\Di\FactoryDefault;
use Phalcon\Mvc\Url as UrlProvider;
use Phalcon\Db\Adapter\Pdo\Mysql as DbAdapter;

error_reporting(E_ALL);

define('APP_PATH', realpath('..'));

try {

    /**
     * Read the configuration
     */
    $config = include APP_PATH . "/app/config/config.php";

    /**
     * Read auto-loader
     */
    include APP_PATH . "/app/config/loader.php";

    /**
     * Read services
     */
    include APP_PATH . "/app/config/services.php";


    // オートローダにディレクトリを登録する
    $loader = new Loader();
    $loader->registerDirs(array(
        '../app/controllers/',
        '../app/models/'
    ))->register();

    // DIコンテナを作る
    $di = new FactoryDefault();

    // データベースサービスのセットアップ
    $di->set('db', function () {
        return new DbAdapter(array(
            "host"     => "localhost",
            "username" => "calchos",
            "password" => "2txxMI5i",
            "dbname"   => "lw_sample_db"
        ));
    });

    // ビューのコンポーネントの組み立て
    $di->set('view', function () {
        $view = new View();
        $view->setViewsDir('../app/views/');
        return $view;
    });

    // ベースURIを設定して、生成される全てのURIが「legendworld」を含むようにする
    $di->set('url', function () {
        $url = new UrlProvider();
        $url->setBaseUri('/legendworld/');
        return $url;
    });

    /**
     * Handle the request
     */
    $application = new \Phalcon\Mvc\Application($di);

    echo $application->handle()->getContent();

} catch (\Exception $e) {
    echo $e->getMessage() . '<br>';
    echo '<pre>' . $e->getTraceAsString() . '</pre>';
}
