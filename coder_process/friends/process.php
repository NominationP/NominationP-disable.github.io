<?php
include_once("../mysql.php");

class Cut_pr{

    public $file_root;
    public $Season , $Episode , $title , $role , $part , $words_num;
    public $db,$db_friend;
    public $sea_epi,$file_title; //rewrite


    function __construct(){

        $this->db = new Mysql;
        $this->db_friend = $this->initial("localhost","root","#mJl&dcs.6(O","Friends");
    }
    function initial($db_port,$db_user,$db_password,$db_name){

        $this->db->do_connect($db_port,$db_user,$db_password,$db_name);
        return $this->db;
    }





    function run(){

        // $this->from_file_to_datebase();
        $this->rewrite('01-20');
    }


    public function rewrite($sea_epi){

        $this->sea_epi=$sea_epi;
        $this->re_pre();
        $this->re_spe();
    }

    public function re_spe(){

        /*today_max*/
        $max=0;
        $tag;
        $last_name = "";
        $last_num = 0;
        $count = 0;
        $sql = "select * from detail where season=$this->Season and episode=$this->Episode";
        $re = $this->db_friend->select($sql);

        foreach ($re as $key => $value) {
            $count++;
            $name = $value['name'];
            $words_num = $value['words_num'];
            $id = $value['id'];

            if($name == $last_name || $count==1){
                $last_num += $words_num;
                $last_name = $name;
                if($last_num > $max) { $max = $last_num; $tag = $id; }
            }else{

                $last_num = $words_num;
                $last_name = $name;
            }
        }

        print_r($max."\n".$tag);die();

        $spe_arr=array(
            ">Role : $this->role",
            "Part : $this->part",
            "Words : $this->words_num",
            "",
            "`TODAY_MAX` :",
            );

        foreach ($spe_arr as $key => $value) {
            $this->write_file($this->file_title,$value,false);
        }
    }

    public function re_pre(){

        /*get Season and Episode*/
        $sea_epi = explode("-", $this->sea_epi);
        $this->Season = $sea_epi[0];
        $this->Episode = $sea_epi[1];

        /*get title role part words_num*/
        $sql = "select * from list where season=$this->Season and episode=$this->Episode";
        $re = $this->db_friend->select($sql);
        $this->title = $re[0]['title'];
        $this->role = $re[0]['role'];
        $this->part = $re[0]['part_num'];
        $this->words_num = $re[0]['words_num'];

        /*file_title*/
        date_default_timezone_set('Asia/Shanghai');
        $today = date("Y-m-d");
        $this->file_title = $today."-friends-$this->Season$this->Episode-up.md";

        /*get/set pre of a file*/
        date_default_timezone_set('Asia/Shanghai');
        $today = date("Y-m-d H:i:s");

        $pre_arr = array("---","layout: article",
            "title: Friends $this->Season-$this->Episode $this->title UP",
            "date:   $today",
            "modified: $today",
            "category: blog","tags:","- friends","- english","image:","#  feature:","    teaser: /background/dress.jpg","---","","");

        foreach ($pre_arr as $key => $value) {
            // $this->write_file($this->file_title,$value);
        }


        // file_put_contents($root_path.$file_path, $string.PHP_EOL , FILE_APPEND | LOCK_EX."\n");

    }

    public function write_file($file_title,$string){
        $root = "../../_posts/blog/";
        file_put_contents($root.$file_title, $string.PHP_EOL , FILE_APPEND | LOCK_EX."\n");

    }





    /*______________________________________________________________________save_to_mysql_from_file____*/

    // 2017-02-22-friends-0120.md
    // 2017-02-22-friends-0121.md
    public function from_file_to_datebase($file_root="../../_posts/blog/2017-02-22-friends-0121.md"){

        $this->file_root = $file_root;
        print_r("update $file_root ...\n");
        $this->get_Sea_Epi_til_rol();
        $this->collect();
        $this->set_db_Sea_Epi_til_rol();
        print_r("done\n");
    }

    /**
     * get Season && Episode && title && role
     * @return [type] [description]
     */
    public function get_Sea_Epi_til_rol(){

        if ($file = fopen($this->file_root, "r")) {

            while(!feof($file)) {

                $line = fgets($file);
                if(trim($line) != null){
                    if(substr($line,0,2)=="##"){
                        $line = explode(" ", $line);

                        /*get Season && Episode*/
                        $sea_epi = explode("-", $line[1]);
                        $this->Season = $sea_epi[0];
                        $this->Episode = $sea_epi[1];

                        /*get title && role*/
                        $title_role = explode("(", $line[2]);
                        $this->title = $title_role[0];
                        $this->role = substr($title_role[1],0,-2);

                        return 0;
                    }
                }
            }
            fclose($file);
        }
    }

    /**
     * [set_db_Sea_Epi_til_rol description] set list table
     */
    public function set_db_Sea_Epi_til_rol(){

        $sql_words = "select words_num from detail";
        $sum_words = $this->db_friend->select($sql_words);
        $words_num = 0;
        foreach ($sum_words as $key => $value) {
            # code...
            $words_num += $value['words_num'];
        }
        $this->words_num = $words_num;

        $attr = array(
            'season' => $this->Season,
            'episode' => $this->Episode,
            'title' => $this->title,
            'role' => $this->ex_change($this->role),
            'part_num' => $this->part,
            'words_num' => $this->words_num,
            );

        $condition = array(
            'season' => $this->Season,
            'episode' => $this->Episode,
            );

        $table_name = 'list';

        $this->db_friend->smart_up($table_name,$attr,$condition);

        // $sql = "select * from list where season = $this->Season and episode = $this->Episode";
        // $check_exist = $this->db_friend->select($sql);
        // if($check_exist == null){
        //     $sql = "insert into list
        //         (`season`, `episode`, `title`, `role`, `part_num`, `words_num`) VALUES
        //         ($this->Season,$this->Episode,'$this->title','$this->role',0,0)";
        //     $this->db_friend->alter($sql);
        // }
    }

    /**
     * collect info && set to detail table
     * @return [type] [description]
     */
    public function collect(){

        if ($file = fopen($this->file_root, "r")) {
        $count = 0;
        $mark = false;
        $part = 1; // "----------------------"
            while(!feof($file)) {

                /*count line*/
                $count++;

                // print_r(++$count."  ");
                $line = fgets($file);
                if(trim($line) != null){

                    /*change mark begin real doc*/
                    if(!$mark && substr($line, 0,2) == "##"){
                        $mark = true;
                    }

                    /*begin real doc*/
                    if($mark){
                        /*count port numbers*/
                        if(substr($line,0,6)=="------"){
                            $part++; // count part number
                            continue;
                        }

                        /*check if has chinese*/
                        $is_chinese = 0;
                        /*get whole line*/
                        $whole_line = "";
                        $whole_line_count = 0;
                        /**/
                        if(substr($line, 0,1)=="-"){
                            /*find name*/
                            $line_arr = explode(" ", $line);
                            $name = substr($line_arr[0],1);
                            $ex_name = $this->ex_change($name);

                            // print_r($line_arr);

                            for ($i=1; $i < sizeof($line_arr); $i++) {
                                /*check if has chinese*/
                                // if(!preg_match('/[A-Za-z0-9.?,!]/', $line_arr[$i])){
                                if(preg_match("/\p{Han}+/u", $line_arr[$i])){
                                    $is_chinese = 1;
                                }else{
                                    // print_r($line_arr[$i]."(((\n");
                                    $whole_line_count++;
                                }

                                $whole_line .= $line_arr[$i]." ";
                            }
                            $whole_line = trim($whole_line);
                            // print_r($ex_name." ".$whole_line_count." ".$whole_line."\n");
                            // print_r($count." ".$is_chinese." -".$ex_name." ".$whole_line."\n");
                            // return ;

                            /*insert / update mysql*/
                            $arr = array(
                                'line'          =>  $count,
                                'name'          =>  $ex_name,
                                'words'         =>  $whole_line,
                                'words_num'     =>  $whole_line_count,
                                'is_chinese'    =>  $is_chinese,
                                'part'          =>  $part,
                                'season'        =>  $this->Season,
                                'episode'       =>  $this->Episode,
                                );
                            $condition = array(
                                'line' => $count,
                                'season' => $this->Season,
                                'episode' => $this->Episode,
                                );


                            $this->db_friend->smart_up('detail',$arr,$condition);


                        }else {

                            if((substr($line,0,2) != "##") && (substr($line,0,1) != ">")){


                                $line_arr = explode(" ", $line);
                                $whole_line = "";


                                foreach ($line_arr as $key => $value) {

                                    /*check if has chinese*/
                                    if(preg_match("/\p{Han}+/u", $value)){
                                        $is_chinese = 1;
                                    }else{
                                        $whole_line_count++;
                                    }

                                    $whole_line .= $value." ";
                                }

                                // print_r($whole_line_count." ".$whole_line."\n");
                                // print_r($count." ".$is_chinese." ".$whole_line."\n");

                                /*insert / update mysql*/
                                $arr = array(
                                    'line'          =>  $count,
                                    'name'          =>  $ex_name,
                                    'words'         =>  $whole_line,
                                    'words_num'     =>  $whole_line_count,
                                    'is_chinese'    =>  $is_chinese,
                                    'part'          =>  $part,
                                    'season'        =>  $this->Season,
                                    'episode'        =>  $this->Episode,
                                    );
                                $condition = array(
                                    'line' => $count,
                                    'season' => $this->Season,
                                    'episode' => $this->Episode,
                                    );

                                $this->db_friend->smart_up('detail',$arr,$condition);
                                // return 0;
                            }
                        }

                        /*$whole_line , */
                    }
                }

            }

            $this->part = $part;
        }
    }


    public function trasn_big(){

        if ($file = fopen($this->file_root, "r")) {
        $count = 0;

            while(!feof($file)) {
                // print_r(++$count."  ");
                $line = fgets($file);
                if(trim($line) != null){
                    if(substr($line,0,1)=="-" && substr($line,0,5)!="-----"){
                        $name = explode(" ", $line);
                        $name = $name[0];
                        // print_r($name);
                        $name = substr($name,1);
                        $name = $this->ex_change($name);
                        // $big_name = trim(strtoupper($name));
                        print_r($name." ");
                    }

                }
            }
            fclose($file);
        }
    }

    /*______________________________________________________________________basic____*/

    public function ex_change($string){

        $string = trim($string);

        $name_all = array(

            'ch' => 'Chandler',
            'jo' => 'Joey',
            'ro' => 'Ross',
            'mo' => 'Monica',
            'ra' => 'Rachel',
            'ph' => 'Phoebe',
            );


        if(strstr($string,"/")){
            $string = explode("/", $string);
            $first = $string[0];
            $second = $string[1];
            return $name_all[$first]."/".$name_all[$second];
        }

        if(!array_key_exists($string, $name_all)){
            return $string;
        }



        if($name_all[$string]){
            return $name_all[$string];
        }else{
            return $string;
        }
    }

}


$re = new Cut_pr;
$re->run();

