<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use App\Builder\ListView\Builder\Paymants\PaymansListBuilder;
use App\Builder\ListView\Maker\ListMaker;
use App\Repository\PaymentsRepository;
use Doctrine\ORM\EntityManagerInterface;

class PaymentsController extends AbstractController
{
    /**
     * Class PaymentsRepository.
     *
     * @var PaymentsRepository
     */
    private PaymentsRepository $_repository;

    /**
     * Interface EntityManagerInterface.
     *
     * @var EntityManagerInterface
     */
    private EntityManagerInterface $_em;
    
    /**
     * __construct
     *
     * @param  mixed $repository
     * @param  mixed $em
     * @return void
     */
    public function __construct(PaymentsRepository $repository, EntityManagerInterface $em)
    {
        $this->_repository = $repository;
        $this->_em = $em;
    }

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
                'text' => 'Nazwa płatności'
            ],
        );
        $listBuilder->addHeaderElement(
            [
                'class' => 'basic',
                'text' => 'Suma'
            ],
        );
        $listBuilder->addHeaderElement(
            [
                'class' => 'basic',
                'text' => 'Osoba do rozliczenia'
            ],
        );
        $listBuilder->addHeaderElement(
            [
                'class' => 'basic',
                'text' => 'Status'
            ],
        );
        $listBuilder->addHeaderElement(
            [
                'class' => 'small',
                'text' => 'Opcje'
            ],
        );

        $rows = $this->_repository->findByIdUser($this->getUser()->getId());
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
