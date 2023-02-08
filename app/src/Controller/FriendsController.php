<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use App\Builder\ListView\Maker\ListMaker;
use App\Builder\ListView\Builder\Friends\FriendsListBuilder;
use App\Repository\FriendsRepository;

class FriendsController extends AbstractController
{
    public function list(FriendsRepository $friendsRepository): Response
    {

        dd($friendsRepository->findByUserId($this->getUser()->getId()));
        $listBuilder = new FriendsListBuilder();
        $listBuilder->addButton([
            'type' => 'add',
            'properties' => [
                'href' => '/friend/add',
                'name' => 'Dodaj',
                'icon' => 'fa-solid fa-circle-plus'
            ],
        ]);
        $listBuilder->addHeaderElement(
            [
                'class' => 'small',
                'text' => 'LP.'
            ],
        );
        $listBuilder->addHeaderElement(
            [
                'class' => 'basic',
                'text' => 'Imię'
            ],
        );
        $listBuilder->addHeaderElement(
            [
                'class' => 'basic',
                'text' => 'Nazwisko'
            ],
        );
        $listBuilder->addHeaderElement(
            [
                'class' => 'large',
                'text' => 'Opcje'
            ],
        );
        $rows = [
            0 => [
                'ID' => 1,
                'NAME' => 'Test1',
                'SURNAME' => 'Test1',
            ],
            1 => [
                'ID' => 2,
                'NAME' => 'Test2',
                'SURNAME' => 'Test2',
            ],
            2 => [
                'ID' => 3,
                'NAME' => 'Test3',
                'SURNAME' => 'Test3',
            ],
        ];
        $listBuilder->setRows($rows);
        $listBuilder->setPaggination(0);
        $listView = new ListMaker($listBuilder);

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
