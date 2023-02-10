<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use App\Builder\ListView\Maker\ListMaker;
use App\Builder\ListView\Builder\Notifications\NotificationsListBuilder;

class NotificationsController extends AbstractController
{
    public function list(): Response
    {
        $listBuilder = new NotificationsListBuilder();
        $listBuilder->addButton();
        $listBuilder->addHeaderElement(
            [
                'class' => 'small',
                'text' => 'LP.'
            ],
        );
        $listBuilder->addHeaderElement(
            [
                'class' => 'large',
                'text' => 'Typ powiadomienia'
            ],
        );
        $listBuilder->addHeaderElement(
            [
                'class' => 'basic',
                'text' => 'Treść'
            ],
        );
        $listBuilder->addHeaderElement(
            [
                'class' => 'large',
                'text' => 'Opcje'
            ],
        );
        $rows = [];
        $listBuilder->setRows($rows);
        $listBuilder->setPaggination(0);
        $listView = new ListMaker($listBuilder);

        return $this->render('listView/listView.html.twig', [
            'breadcrumbs' => [
                [
                    'name' => 'Powiadomienia',
                    'href' => '#'
                ]
            ],
            'listView' => $listView->makeList(),
            'controller_name' => 'NotificationController',
        ]);
    }
}
