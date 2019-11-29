<?php
function d($el)
{
    echo '<pre>';
    print_r($el);
    echo '</pre>';
}
function dd($el)
{
    echo '<pre>';
    print_r($el);
    echo '</pre>';
    die;
}
function vd($el)
{
    echo '<pre>';
    var_dump($el);
    echo '</pre>';
    die;
}