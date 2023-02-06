<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use App\Builder\ListView\Maker\ListMaker;
use App\Builder\ListView\Builder\Friends\FriendsListBuilder;

class FriendsController extends AbstractController
{
    public function list(): Response
    {
        $listBuilder = new FriendsListBuilder();
        $listBuilder->setAddButton([]);
        $listBuilder->setCheckButton([]);
        $listBuilder->setHeader([]);
        $listBuilder->setRows([]);
        $listBuilder->setPaggination(0);
        $listView = new ListMaker($listBuilder);

        return $this->render('friends/index.html.twig', [
            'controller_name' => 'FriendsController',
            'listView' => $listView->makeList(),
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
