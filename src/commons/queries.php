<?php
const REGISTER = "INSERT INTO users (email, name, password, accepted_tos) VALUES(?,?,?,?)";
const USER_EXISTS = "SELECT id from users where email=?";
const NEW_PANTRY = "INSERT INTO pantries (owner_id, name) VALUES(?,'New Pantry')";
const DELETE_PANTRY = "DELETE FROM pantries WHERE id=? AND owner_id=?";
const GET_ALL_PANTRIES = "SELECT * FROM pantries WHERE owner_id=?";
const GET_ALL_PANTRY_ITEMS = "SELECT * FROM pantry_item WHERE pantry_id=?";
const GET_SHOPPING_LIST = "SELECT * FROM shopping_list WHERE owner_id=?";