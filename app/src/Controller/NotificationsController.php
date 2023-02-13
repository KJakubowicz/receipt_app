<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use App\Builder\ListView\Maker\ListMaker;
use App\Builder\ListView\Builder\Notifications\NotificationsListBuilder;
use App\Repository\NotificationsRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Notifications;
use Doctrine\Persistence\ManagerRegistry;

class NotificationsController extends AbstractController
{
     /**
     * Class NotificationsRepository.
     *
     * @var NotificationsRepository
     */
    private NotificationsRepository $_repository;

    /**
     * Interface EntityManagerInterface.
     *
     * @var EntityManagerInterface
     */
    private EntityManagerInterface $_em;

    /**
     * __construct
     *
     * @param  mixed $NotificationsRepository
     * @param  mixed $userRepository
     * @param  mixed $em
     * @return void
     */
    public function __construct(NotificationsRepository $NotificationsRepository, EntityManagerInterface $em)
    {
        $this->_repository = $NotificationsRepository;
        $this->_em = $em;
    }

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
                'class' => 'large',
                'text' => 'Treść'
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
                'class' => 'basic',
                'text' => 'Opcje'
            ],
        );

        $rows = $this->_repository->findByUserId($this->getUser()->getId());

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
    
    /**
     * add
     *
     * @param  mixed $from
     * @param  mixed $to
     * @param  mixed $type
     * @param  mixed $content
     * @return void
     */
    public function add(int $from, int $to, string $type, string $content): void
    {
        $notification = new Notifications();
        $notification->setIdUser($from);
        $notification->setIdOwner($to);
        $notification->setType($type);
        $notification->setContent($content);
        $notification->setReaded(false);

        $this->_em->persist($notification);
        $this->_em->flush();

    }
    
    /**
     * remove
     *
     * @param  mixed $id
     * @return void
     */
    public function remove(int $id): void
    {
        $notification = $this->_repository->find($id);

        $this->_em->remove($notification);
        $this->_em->flush();
    }
   
    /**
     * getNotifications
     *
     * @return Response
     */
    public function getNotifications(): Response
    {
        $notificationsCount = $this->_repository->getUnreadedCount($this->getUser()->getId());
        return $this->json($notificationsCount);
    }
}
