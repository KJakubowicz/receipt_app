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
        $listBuilder->addButton([
            'type' => 'add',
            'properties' => [
                'href' => '/friend/add',
                'name' => 'Dodaj',
                'icon' => 'fa-solid fa-circle-plus'
            ],
        ]);

        $listBuilder->setHeader([]);
        $listBuilder->setRows([]);
        $listBuilder->setPaggination(0);
        $listView = new ListMaker($listBuilder);
        // dd($listView->makeList());
        return $this->render('listView/listView.html.twig', [
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
