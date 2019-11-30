<?php


namespace App\controllers;


use DB\DataBase;
use MyQueryBuilder\QueryFactory;
use MyQueryBuilder\QueryBuilder;

class MainController
{
    public function index()
    {
        require '../app/views/index.view.php';
    }

    public function home($vars)
    {
        d($vars);
        require '../app/views/home.view.php';
    }

    public function about($vars)
    {
        d($vars);
        require '../app/views/about.view.php';
    }

    public function news($vars)
    {
        d($vars);
        switch (empty($vars['id']))
        {
            case true:
                $queryBuilder = new QueryBuilder(DataBase::getPDO(), new QueryFactory());
                $posts = $queryBuilder->getAll('posts');
                require '../app/views/posts.view.php';
                break;
            case false:
                $queryBuilder = new QueryBuilder(DataBase::getPDO(), new QueryFactory());
                $posts = $queryBuilder->getOne('posts', $vars['id']);
                require '../app/views/posts.view.php';
                break;
        }
    }
}
