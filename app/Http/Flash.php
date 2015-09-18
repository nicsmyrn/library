<?php

namespace App\Http;


/**
 * Class Flash
 * @package App\Http
 */
class Flash {
    /**
     * @param $title
     * @param $message
     * @param $level
     * @param string $key
     */
    public function create($title, $message, $level, $key = 'flash_message'){

        session()->flash($key, [
            'message' =>$message,
            'title' =>$title,
            'level'=>$level
        ]);

    }

    /**
     * @param $title
     * @param $message
     */
    public function info($title, $message = null){

        $this->create($title, $message, 'info');

    }

    /**
     * @param $title
     * @param $message
     */
    public function success($title, $message = null){

         $this->create($title, $message, 'success');

    }

    /**
     * @param $title
     * @param $message
     */
    public function error($title, $message){

         $this->create($title, $message, 'error');

    }

    /**
     * @param $title
     * @param $message
     * @param string $level
     */
    public function overlay($title, $message, $level = 'success'){

         $this->create($title, $message, $level, 'flash_message_overlay');

    }


//    public function __call($method, $args){
//        if ($method == 'overlay'){
//            $this->create($args[0],$args[1], 'success', 'flash_message_overlay');
//        }else {
//            $this->create($args[0], $args[1], $method);
//        }
//    }
}