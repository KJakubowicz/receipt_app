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
use App\Helper\ListHelper;

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

    public function madePaymentsList(Request $request): Response
    {
        (int) $page = ($request->get('page')) ? $request->get('page') : 1;

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
                'class' => 'large',
                'text' => 'Osoba do rozliczenia'
            ],
        );
        $count = $this->_repository->findCountByIdUser($this->getUser()->getId());

        $rows = $this->_repository->findByIdUser($this->getUser()->getId());
        $listBuilder->setRows($rows);
        $pageCount = ListHelper::getPageCount($count, ($request->get('per_page')) ? $request->get('per_page') : 0);

        for ($i=1; $i <= $pageCount; $i++) { 
            $active = ($i === (int) $page) ? true : false;
            $listBuilder->addPaggination([
                'label' => $i,
                'href' => '?page='.$i,
                'active' => $active
            ]);
        }
        $listView = new ListMaker($listBuilder);

        return $this->render('listView/listView.html.twig', [
            'controller_name' => 'PaymentsController',
            'listView' => $listView->makeList(),
            'breadcrumbs' => [
                [
                    'name' => 'Wykonane płatności',
                    'href' => '#'
                ]
            ],
        ]);
    }
    
    /**
     * clearingPaymentsList
     *
     * @return Response
     */
    public function clearingPaymentsList(): Response
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
                'class' => 'basic',
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
                    'name' => 'Płatności',
                    'href' => '/payments'
                ],
                [
                    'name' => 'Dodaj płatność',
                    'href' => '#'
                ],
            ],
        ]);
    }

    public function setClearing(int $id): Response
    {
        $date = new DateTimeImmutable();
        $payment = $this->_repository->find($id);
        $payment->setStatus(true);
        $payment->setLastModification($date);
        $this->_em->persist($payment);
        $this->_em->flush();

        $this->forward('App\Controller\NotificationsController::add', [
            'from' => $payment->getIdFriend(),
            'to' => $payment->getIdUser(),
            'type' => 'PAYMENT_CLEARING',
            'content' => 'Płatność o nazwie "'.$payment->getName().'" została rozliczona'
        ]);

        return $this->redirectToRoute('app_payments_clearing_list');
    }

    public function billings(Request $request): Response
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
                'class' => 'basic',
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
                    'name' => 'Raport rozliczeń',
                    'href' => '#'
                ]
            ],
        ]);
    }
}
