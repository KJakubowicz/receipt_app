<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use App\Builder\ListView\Maker\ListMaker;

class FriendsController extends AbstractController
{
    public function list(): Response
    {
        return $this->render('friends/index.html.twig', [
            'controller_name' => 'FriendsController',
            'breadcrumbs' => [
                [
                    'name' => 'Znajomi',
                    'href' => '/friends'
                ],
                [
                    'name' => 'Dodaj znajomego',
                    'href' => '/friend/add'
                ],
            ],
        ]);
    }
}
