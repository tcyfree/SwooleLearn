<?php
/**
 * Created by PhpStorm.
 * User: baidu
 * Date: 18/3/11
 * Time: 下午10:40
 */
// 单例模式（口诀：三私一公）
class Singleton{
    /**
     * @var string
     */
    //私有化构造方法，禁止外部实例化对象
    public function __construct()
    {
        $this->instance = new Swoole\Mysql;
    }
    //私有化__clone，防止对象被克隆
    private function __clone(){}
    //私有化内部实例化的对象
    private  $instance = null;
    // 公有静态实例方法
    public  function getInstance(){
        if($this->instance == null){
            //内部实例化对象
            $this->instance = new self();
        }
        return $this->instance;
    }
}
class AsyncMysql {
    /**
     * @var string
     */
    public $dbSource = "";
    /**
     * mysql的配置
     * @var array
     */
    public $dbConfig = [
        'host' => '127.0.0.1',
        'port' => 3306,
        'user' => 'root',
        'password' => 'Lingyuan882018',
        'database' => 'thinkcmf5',
        'charset' => 'utf8',
    ];

    public function __construct() {
        //new swoole_mysql;
        $this->dbSource = (new Singleton())->getInstance();

    }

    public function update() {

    }

    public function add() {

    }

    /**
     * mysql 执行逻辑
     * @param $id
     * @param $username
     * @return bool
     */
    public function execute($id, $username) {
        // connect
	var_dump($this->dbSource);
        $this->dbSource->connect($this->dbConfig, function($db, $result) use($id, $username)  {
            echo "mysql-connect".PHP_EOL;
            if($result === false) {
                var_dump($db->connect_error);
                // todo
            }

            $sql = "select * from cmf_user where id=1";
            //$sql = "update test set `username` = '".$username."' where id=".$id;
            // insert into
            // query (add select update delete)
            $db->query($sql, function($db, $result){
                // select => result返回的是 查询的结果内容

                if($result === false) {
                    // todo
                    var_dump($db->error);
                }elseif($result === true) {// add update delete
                    // todo
                    var_dump($db->affected_rows);
                }else {
                    print_r($result);
                }
                $db->close();
            });

        });
        return true;
    }
}
$obj = new AsyncMysql();
$flag = $obj->execute(1, 'singwa-111112');
var_dump($flag).PHP_EOL;
echo "start".PHP_EOL;


// 详情页 -》mysql(阅读数) -》msyql 文章 +1 -》页面数据呈现出来

