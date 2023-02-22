<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use App\Builder\ListView\Builder\Paymants\PaymansMadeListBuilder;
use App\Builder\ListView\Builder\Paymants\PaymansClearingListBuilder;
use App\Builder\ListView\Maker\ListMaker;
use App\Repository\PaymentsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use App\Form\PaymentsAddFormType;
use DateTimeImmutable;
use App\Helper\FriendsHelper;
use App\Repository\FriendsRepository;

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
     * Class FriendsRepository.
     *
     * @var FriendsRepository
     */
    private FriendsRepository $_friendsRepository;
    
    /**
     * __construct
     *
     * @param  mixed $repository
     * @param  mixed $em
     * @return void
     */
    public function __construct(PaymentsRepository $repository, EntityManagerInterface $em, FriendsRepository $friendsRepository)
    {
        $this->_repository = $repository;
        $this->_em = $em;
        $this->_friendsRepository = $friendsRepository;
    }

    public function madePayments(): Response
    {
        $listBuilder = new PaymansMadeListBuilder();
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
                'text' => 'Status'
            ],
        );
        $listBuilder->addHeaderElement(
            [
                'class' => 'basic',
                'text' => 'Osoba do rozliczenia'
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
    
    /**
     * clearingPayments
     *
     * @return Response
     */
    public function clearingPayments(): Response
    {
        $listBuilder = new PaymansClearingListBuilder();

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
                'text' => 'Status'
            ],
        );
        $listBuilder->addHeaderElement(
            [
                'class' => 'basic',
                'text' => 'Osoba rozliczająca'
            ],
        );
        $listBuilder->addHeaderElement(
            [
                'class' => 'small',
                'text' => 'Opcje'
            ],
        );

        $rows = $this->_repository->findClearingByIdUser($this->getUser()->getId());
        $listBuilder->setRows($rows);
        $listBuilder->setPaggination(0);
        $listView = new ListMaker($listBuilder);

        return $this->render('listView/listView.html.twig', [
            'controller_name' => 'PaymentsController',
            'listView' => $listView->makeList(),
            'breadcrumbs' => [
                [
                    'name' => 'Płatności do rozliczenia',
                    'href' => '#'
                ]
            ],
        ]);
    }

    public function add(Request $request): Response
    {
        $choices = FriendsHelper::getChoisesForForm(
            $this->_friendsRepository->findFriendsByUserId($this->getUser()->getId())
        );

        $form = $this->createForm(PaymentsAddFormType::class, null, ['choices' => $choices]);
        $form->handleRequest($request);

        if ($form->isSubmitted() === true && $form->isValid() === true) {
            $newPayment = $form->getData();
            $dataTime = new \DateTimeImmutable();
            $newPayment->setIdUser($this->getUser()->getId());
            $newPayment->setCreatedAt($dataTime);

            $this->forward('App\Controller\NotificationsController::add', [
                'from' => $this->getUser()->getId(),
                'to' => $newPayment->getIdFriend(),
                'type' => 'NEW_PAYMENT',
                'content' => 'Nowa płatność'
            ]);

            $this->_em->persist($newPayment);
            $this->_em->flush();

            return $this->redirectToRoute('app_payments_list');
        }//end if

        return $this->render('payments/add.html.twig', [
            'form' => $form->createView(),
            'breadcrumbs' => [
                [
                    'name' => 'Znajomi',
                    'href' => '/payments'
                ],
                [
                    'name' => 'Dodaj płatność',
                    'href' => '#'
                ],
            ],
        ]);
    }
}
