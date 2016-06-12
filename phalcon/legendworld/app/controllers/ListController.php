<?php

use Phalcon\Mvc\Controller;

class ListController extends Controller
{

    public function indexAction()
    {

    }

    public function updateAction()
    {

        $userLists = UserLists::findFirst(
           array(
           "order" => "level ASC",
           "limit" => 30
        )
     );

   }
}
