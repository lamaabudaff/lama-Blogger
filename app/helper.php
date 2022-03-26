<?php


function get_username(){
    return "Fadi";
}

function get_auth_username(){
    return optional(auth()->user())->name;
}

function dashboard(){

}
