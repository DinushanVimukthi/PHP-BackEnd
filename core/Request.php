<?php

namespace app\core;

class Request
{
    public function getPath()
    {
        $path = $_SERVER['REQUEST_URI'] ?? '/';
        $position = strpos($path, '?');
        $dash=substr_count($path, '/');

        if($dash>1)
        {
            $path=trim($path,'/');
            $arr=explode('/',$path);
            $len=count($arr);
            foreach ($arr as $key=>$value)
            {
                $arr[$key]='/'.$value;
            }
            $position = strpos($arr[$len-1], '?');
            if($position)
            {
            $arr[$len-1]=substr($arr[$len-1],0,$position);
            }
            return $arr;
        }
        if($position !== false) {
            return $path = substr($path, 0, $position);
        }
        return $path;

    }




    public function method()
    {
        return strtolower($_SERVER['REQUEST_METHOD']);
    }
    public function isGet()
    {
        return $this->method() === 'get';
    }
    public function isPost()
    {
        return $this->method() === 'post';
    }
    public function getBody()
    {
        $body=[];
        if($this->method()=='get'){
            foreach ($_GET as $key => $value) {
                $body[$key]=filter_input(INPUT_GET, $key, FILTER_SANITIZE_SPECIAL_CHARS);
            }
        }
        if($this->method()=='post'){

            foreach ($_POST as $key => $value) {
                if(is_array($value)){
                    $body[$key]=filter_input(INPUT_POST, $key, FILTER_SANITIZE_SPECIAL_CHARS, FILTER_REQUIRE_ARRAY);
                }else {
                    $body[$key] = filter_input(INPUT_POST, $key, FILTER_SANITIZE_SPECIAL_CHARS);
                }
            }
        }
        return $body;
    }
}