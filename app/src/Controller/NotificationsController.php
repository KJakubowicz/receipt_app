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

    public static function send(int $from, int $to, string $type, string $content): void
    {
        $entity = new Notifications();
        $repository = new NotificationsRepository(new ManagerRegistry);
        $entity->setIdUser($from);
        $entity->setIdOwner($to);
        $entity->setType($type);
        $entity->setContent($content);
        $repository->save($entity, true);
    }
}
