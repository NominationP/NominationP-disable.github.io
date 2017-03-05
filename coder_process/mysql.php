<?php

class Mysql {


    public $conn;
    public $i;

    /**
     * initial
     */

    function __construct(){

        $this->i = 0;
        // print 'construct'."\n";

        // $servername = "localhost";
        // $username = "root";
        // $password = "#mJl&dcs.6(O";
        // $dbname = $db_name;

        // // Create connection
        // $err_level = error_reporting(0);
        // $this->conn = new mysqli($servername, $username, $password, $dbname);
        // mysql_query( "SET NAMES utf8",$this->conn);
        // error_reporting($err_level);
        // // Check connection
        // if ($this->conn->connect_error) {
        //     die("Connection failed: " . $this->conn->connect_error);
        // }
    }

    //连接数据库
    function do_connect($db_port,$db_user,$db_password,$db_name)
    {

        $db_name = $db_name;
        $err_level = error_reporting(0);
        $db=new mysqli;
        $db->connect($db_port,$db_user,$db_password,$db_name);

        if($db->connect_errno){die("connect error:".$db->connect_errno." ".$db->connect_error);}
        error_reporting($err_level);
        $this->conn = $db;

        $this->conn->query("set names 'utf8'");
        // return $db;
    }





    /**
     * destroy
     */

    function __destruct(){

        // print 'destruct '. "\n";

        $this->conn->close();
    }


    //执行普通sql语句,返回true或者false
    function query_normal($sql)
    {

        $err_level = error_reporting(0);

        $result=$this->conn->query($sql);
        error_reporting($err_level);


        if(!$result)    //发生错误时记录日志
        {
            $err="Error ".$this->conn->errno."   ".$this->conn->error."\r\n sql:   ".$sql."\r\n";
            $this->writedblog($err);
            $this->i++;
            if($this->i > 10){
                die("sql error");
            }
            return $result;
        }
        else
        {
            return $result;
        }
    }

    //写数据库相关日志
    function writedblog($loginfo)
    {
        date_default_timezone_set('Asia/Shanghai');//or change to whatever timezone you want

        $f=fopen(date("Ymd")."-dblog.txt","a+");      //DBLOG_PATH常量在const.inc中
        fwrite($f,date("Y-m-d H:i:s").":   ".$loginfo);
        fclose($f);
    }


    function smart_up($table_name,$attr,$condition){

        $condition = $this->arr_sql_select($table_name,$condition);
        // print_r($condition);

        if($condition == null){
            $this->arr_sql_insert($table_name,$attr);
        }else{
            $this->arr_sql_update($table_name,$attr);
        }

    }

    function arr_sql_select($table_name,$arr){
        $sql = "";
        foreach ($arr as $key => $value) {

            if(preg_match("/[']/", $value)){
                $value = addcslashes($value,'\'');
            }
            # code...
            $sql .= "`".$key."`".'='."'".$value."'".",";
        }
        $sql = "select * from $table_name where $sql";
        $sql = rtrim($sql,',');
        $re = $this->select($sql);
        return $re;
    }
    function arr_sql_insert($table_name,$attr){

        $attribute = "";
        $value = "";
        foreach ($attr as $key => $each) {
            if(preg_match("/[']/", $each)){
                $each = addcslashes($each,'\'');
            }
            $attribute .= "`".$key."`,";
            $value .= "'".$each."',";

        }
        $attribute = rtrim($attribute,",");
        $value = rtrim($value,",");

        $sql_insert = "insert into $table_name ($attribute) values ($value)";
        $this->insert($sql_insert);
    }
    function arr_sql_update($table_name,$attr){

        $sql = "";
        foreach ($attr as $key => $value) {
            # code...
            if(preg_match("/[']/", $value)){
                $value = addcslashes($value,'\'');
            }
            $sql .= "`".$key."`".'='."'".$value."'".",";
        }
        $sql = rtrim($sql,",");

        $sql_insert = "update  $table_name set $sql";
        print_r($sql_insert);
        $this->alter($sql_insert);
    }




    /**
     * insert
     */

    function insert($sql){

        // print 'insert ' . "\n";
        if ($this->query_normal($sql) != 0) {
            // echo "New record created successfully";
        } else {
            echo "Error: " . $sql . "<br>" . $this->conn->error;
        }
    }



    /**
     * select array
     */

    function select($sql){

        // $connection = mysql_connect('localhost', 'user', 'pw');
        // mysql_select_db('yourdb', $connection);
        // mysql_query("SET NAMES 'utf8'", $this->conn);

        $result = $this->query_normal($sql);
        if ($result->num_rows > 0) {

            $arr = array();

            while ($row = $result->fetch_assoc()){
                array_push($arr, $row);
                // print_r ($row);
            }
            return $arr;

        } else {

           return null;
        }
    }

    /**
     * select one value
     */
    function select_one($sql){

        $result = $this->query_normal($sql);
        return mysql_fetch_object($result);

    }


    /**
     * get all date
     */

    function get_all($table_name){

        $sql = "SELECT * FROM ".$table_name;

        $result = $this->query_normal($sql);

        // print_r ($result->num_rows);

        if ($result->num_rows > 0) {

            $arr = array();


            while ($row = $result->fetch_assoc()){

                array_push($arr, $row);
            }

            return $arr;

        } else {

           return null;
        }
    }

    /**
     * get all date ---> format ---> proxy ip
     */

    function get_all_proxy($table_name){

            $sql = "SELECT * FROM ".$table_name;

            $result = $this->query_normal($sql);

            // print_r ($result->num_rows);

            if ($result->num_rows > 0) {


                $all_proxy = array();

                while ($row = $result->fetch_assoc()){

                    array_push($all_proxy, $row['ip'].":".$row['port']);
                }

                return $all_proxy;

            } else {

               return null;
            }
        }


    /**
     * delete by id
     * @return [type] [description]
     */
    function delete_by_id($id, $table_name){

        $sql = "DELETE FROM $table_name WHERE goods_id=$id";
        $this->query_normal($sql);

    }

    function delete_all($table_name){

        $sql = "DELETE FROM $table_name";
        $this->query_normal($sql);
    }


    /**
     * alter
     * @return [type] [description]
     */
    function alter($sql){

        // $sql = "UPDATE $table_name SET `count`= $count WHERE id=$id";
        $this->query_normal($sql);

    }

    /**
     * exist
     * @param  [type] $sql [description]
     * @return [type]      [description]
     */
    function exist($sql){

        return $this->query_normal($sql);
    }

}

// $db_name="three_model_suning";
// $db = new Mysql;
// $db->do_connect($db_name);

// $re = $db->get_all("ecs_brand");
// $re = $db->select("select goods_name from ecs_goods  limit 0,1");

// print_r($re);


?>