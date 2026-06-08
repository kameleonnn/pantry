<?php
    const FLASH = 'FLASH_MESSAGES';
    const FLASH_ERROR = 'error';
    const FLASH_WARNING = 'warning';
    const FLASH_INFO = 'info';
    const FLASH_SUCCESS = 'success';

    function create_flash_msg(string $name, string $msg, string $type) : void {
        if(isset($_SESSION[FLASH][$name])){
            unset($_SESSION[FLASH][$name]);
        }
        $_SESSION[FLASH][$name] = ['message' => $msg, 'type' => $type];
    }

    function format_flash_msg(array $flash_msg) : string {
        return sprintf('<div class="alert alert-%s">%s</div>', $flash_msg['type'], $flash_msg['message']);
    }

    function display_flash_msg(string $name) : void {
        if(!isset($_SESSION[FLASH][$name])){
            return;
        }
        $flash_msg = $_SESSION[FLASH][$name];
        unset($_SESSION[FLASH][$name]);
        echo format_flash_msg($flash_msg);
    }

    function display_all_flash_msg() : void {
        if(!isset($_SESSION[FLASH])){
            return;
        }
        $flash_msgs = $_SESSION[FLASH];
        unset($_SESSION[FLASH]);
        foreach($flash_msgs as $flash_msg){
            echo format_flash_msg($flash_msg);
        }
    }

    function flash(string $name = '', string $message = '', string $type = '') : void {
        if($name !== '' && $message !== '' && $type !== ''){
            create_flash_msg($name, $message, $type);
        } elseif ($name !== '' && $message === '' && $type === ''){
            display_flash_msg($name);
        } elseif ($name === '' && $message === '' && $type === ''){
            display_all_flash_msg();
        }
    }
?>