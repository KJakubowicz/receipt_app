<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use App\Builder\ListView\Builder\Paymants\PaymansListBuilder;
use App\Builder\ListView\Maker\ListMaker;

class PaymentsController extends AbstractController
{
    public function list(): Response
    {
        $listBuilder = new PaymansListBuilder();
        $listBuilder->addButton([
            'type' => 'add',
            'properties' => [
                'href' => '/payment/add',
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
                'class' => 'small',
                'text' => 'Opcje'
            ],
        );
        $rows = [];
        $listBuilder->setRows($rows);
        $listBuilder->setPaggination(0);
        $listView = new ListMaker($listBuilder);

        return $this->render('listView/listView.html.twig', [
            'controller_name' => 'PaymentsController',
            'listView' => $listView->makeList(),
            'breadcrumbs' => [
                [
                    'name' => 'Znajomi',
                    'href' => '#'
                ]
            ],
        ]);
    }
}
