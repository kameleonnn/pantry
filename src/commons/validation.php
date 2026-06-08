<?php
const EMAIL_PTTRN = "/(^[[:alnum:]_.+-]*)@([[:alnum:]-]*)([.][[:alnum:]-]*)*([.][a-z]{2,})$/Ais";
const NAME_PTTRN = "/[[:alnum:]._ '-]{1,40}/sA";
const PASS_PTTRN = "/^(?=.*\d)(?=.*[A-Z])(?=.*[a-z])(?=.*[^\w\d\s:])([^\s]){8,40}$/m";

function validate_regex(string $str, $pattern)
{
    switch ($pattern) {
        case EMAIL_PTTRN:
            return preg_match_all(EMAIL_PTTRN, $str) == 1;
        case NAME_PTTRN:
            return preg_match_all(NAME_PTTRN, $str) == 1;
        case PASS_PTTRN:
            return preg_match_all(PASS_PTTRN, $str) == 1;
        default:
            return false;
    }
}

function pass_confirm($pass, $pass_check)
{
    return $pass === $pass_check;
}

function check_tos($consent)
{
    if ($consent === 'yes') {
        return true;
    }
    return false;
}

function validate_form($email, $name, $pass, $pass_conf, $consent)
{
    if (validate_regex($email, EMAIL_PTTRN) == false) {
        flash('reg_invalid_email', 'Please enter a valid e-mail address.', FLASH_ERROR);
        return false;
    }
    if (validate_regex($name, NAME_PTTRN) == false) {
        flash('reg_invalid _name', 'The entered name contains invalid characters.', FLASH_ERROR);
        return false;
    }
    if (validate_regex($pass, PASS_PTTRN) == false) {
        flash('reg_invalid_pass', 'Please enter a valid password.', FLASH_ERROR);
        return false;
    }
    if (pass_confirm($pass, $pass_conf) == false) {
        flash('reg_diff_pass', "The passwords don't match.", FLASH_ERROR);
        return false;
    }
    if (check_tos($consent) == false) {
        flash('reg_consent_false', 'You must accept the Pantry terms of service.', FLASH_ERROR);
        return false;
    }
    return true;
}

function validate_table_column($table, $column){
    $columns = [
        "users"         => ["id", "email", "name", "password", "accepted_tos"], 
        "pantries"      => ["id", "owner_id", "name"], 
        "pantry_item"   => ["id", "pantry_id", "name", "quantity", "notes"], 
        "shopping_list" => ["id", "owner_id", "item_id", "name", "quantity"]
    ];
    if(key_exists($table, $columns)){
        if(in_array($column, $columns[$table],true)){
            return true;
        }
    }
    return false;
}

function validate_table($table){
    $tables = ["users", "pantries", "pantry_item", "shopping_list"];
    if(in_array($table, $tables, true)){
        return true;
    }
    return false;
}