<?php
/**
 * Created by PhpStorm.
 * User: ruoxigeng
 * Date: 2019-07-14
 * Time: 21:05
 */
use Swoole\Coroutine as co;

class Mysql {
    /**
     * @var string
     */
    public $dbSource = "";
    /**
     * @var array|string
     */
    public $dbConfig = [];

    public function __construct() {
        $this->dbSource = new Swoole\Coroutine\MySQL();

        $this->dbConfig = [
            'host' => '127.0.0.1',
            'port' => 3306,
            'user' => 'root',
            'password' => '',
            'database' => 'swoole',
            'charset' => 'utf8',
        ];
    }

    public function update() {

    }

    public function add() {

    }

    /**
     * mysql 执行
     * @param $id
     * @param $username
     * @return bool
     */
    public function execute($id, $username) {
        //connect
        $res = $this->dbSource->connect($this->dbConfig);
        echo "mysql-connect".PHP_EOL;

        if($res === false) {
            return;
        }
        //$sql = "select * from test where id = 1";
        $sql = "update test set `username`='$username' where `id`=$id";

        $result = $this->dbSource->query($sql);

        if($result == false) {

        }elseif($result === true) {

        } else {
            print_r($result);
        }
        return true;
    }
}

go(function() {
    $obj = new Mysql();
    $flag = $obj->execute(1, 'geng');
    var_dump($flag).PHP_EOL;
    echo "start:".PHP_EOL;
});
