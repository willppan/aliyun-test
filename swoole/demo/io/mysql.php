<?php
/**
 * Created by PhpStorm.
 * User: panwei
 * Date: 2019-10-09
 * Time: 15:06
 */
class Mysql
{
    /**
     * 数据库资源
     * @var $db
     */
    protected $db;

    /**
     * 数据库连接配置
     * @var $config
     */
    protected $config;

    public function __construct()
    {
        $this->db = new swoole_mysql();
        $this->config = [
            'host' => '127.0.0.1',
            'port' => 3306,
            'user' => 'root',
            'password' => '',
            'database' => 'test',
            'charset' => 'utf8', //指定字符集
        ];
    }

    public function update()
    {
        
    }

    public function add()
    {

    }

    public function exec($id, $sort)
    {
        $this->db->connect($this->config,function ($db, $result) use($id,$sort){
            if($result === false) {
                var_dump($db->content_error);
            }
            echo "mysql-content".PHP_EOL;

//            $sql = "select * from corp_banner where id = ".$id;
//            $sql = "update corp_banner set sort = ".$sort." where id = ".$id;
            $sql = "insert into corp_banner (`sort`,`value_type`,`value_content`) values('2','1','{123:h12}')";
            $db->query($sql, function ($db, $result){
                if($result === false) {
                    var_dump($db->error);
                }else if($result === true){
                    var_dump($db->affected_rows);
                }else{
                    print_r($result);
                }
                $db->close();
            });
        });
        return true;
    }
}
$obj = new Mysql();
$flag = $obj->exec(1,100);
var_dump($flag).PHP_EOL;
echo "start".PHP_EOL;
