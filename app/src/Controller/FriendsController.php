<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use App\Builder\ListView\Maker\ListMaker;
use App\Builder\ListView\Builder\Friends\FriendsListBuilder;
use App\Repository\FriendsRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Form\FriendsAddFormType;
use Symfony\Component\HttpFoundation\Request;
use App\Helper\FriendsHelper;
use App\Controller\NotificationsController;
use DateTimeImmutable;
use App\Helper\ListHelper;

/**
 * FriendsController
 */
class FriendsController extends AbstractController
{
    /**
     * Class FriendsRepository.
     *
     * @var FriendsRepository
     */
    private FriendsRepository $_repository;

    /**
     * Class UserRepository.
     *
     * @var UserRepository
     */
    private UserRepository $_userRepository;

    /**
     * Interface EntityManagerInterface.
     *
     * @var EntityManagerInterface
     */
    private EntityManagerInterface $_em;
        
        
    /**
     * __construct
     *
     * @param  mixed $friendsRepository
     * @param  mixed $userRepository
     * @param  mixed $em
     * @return void
     */
    public function __construct(FriendsRepository $friendsRepository, UserRepository $userRepository, EntityManagerInterface $em)
    {
        $this->_repository = $friendsRepository;
        $this->_userRepository = $userRepository;
        $this->_em = $em;
    }
    
    /**
     * list
     *
     * @return Response
     */
    public function list(Request $request): Response
    {
        (int) $page = ($request->get('page')) ? $request->get('page') : 1;
        (int) $perPage = ($request->get('per_page')) ? $request->get('per_page') : 13;
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
                'text' => 'Imi??'
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
        $count = $this->_repository->findCountByUserId($this->getUser()->getId());
        $rows = $this->_repository->findByUserId($this->getUser()->getId(), $perPage, $page);
        $listBuilder->setRows($rows);

        $pageCount = ListHelper::getPageCount($count, $perPage);
            
        for ($i=1; $i <= $pageCount; $i++) { 
            $active = ($i === $request->get('page')) ? true : false;
            $listBuilder->addPaggination([
                'label' => $i,
                'value' => $i,
                'active' => $active
            ]);
        }

        $listView = new ListMaker($listBuilder);

        return $this->render('listView/listView.html.twig', [
            'controller_name' => 'FriendsController',
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
     * add
     *
     * @return Response
     */
    public function add(Request $request): Response
    {
        $choices = FriendsHelper::getChoisesForForm(
            $this->_userRepository->findUsersForChoises($this->getUser()->getId())
        );
        $form = $this->createForm(FriendsAddFormType::class,null,['choices' => $choices]);
        $form->handleRequest($request);

        if ($form->isSubmitted() === true && $form->isValid() === true) {
            $newFriend = $form->getData();
            $dataTime = new \DateTimeImmutable();

            $newFriend->setCreatedAt($dataTime);
            $newFriend->setIdOwner($this->getUser()->getId());
            $newFriend->setConfirmed(false);
            
            $this->forward('App\Controller\NotificationsController::add', [
                'from' => $newFriend->getIdOwner(),
                'to' => $newFriend->getIdUser(),
                'type' => 'NEW_FRIENDS',
                'content' => 'Nowe zaproszenie do znajomych'
            ]);

            $this->_em->persist($newFriend);
            $this->_em->flush();

            return $this->redirectToRoute('app_friends_list');
        }//end if

        return $this->render('friends/add.html.twig', [
            'form' => $form->createView(),
            'breadcrumbs' => [
                [
                    'name' => 'Znajomi',
                    'href' => '/friends'
                ],
                [
                    'name' => 'Dodaj znajomego',
                    'href' => '#'
                ],
            ],
        ]);
    }

    /**
     * remove
     *
     * @param  mixed $id
     * @return Response
     */
    public function remove($id): Response
    {
        $friend = $this->_repository->find($id);

        $this->_em->remove($friend);
        $this->_em->flush();

        return $this->redirectToRoute('app_friends_list');
    }
    
    /**
     * accept
     *
     * @param  mixed $id
     * @return Response
     */
    public function accept($idUser, $id): Response
    {
        $date = new DateTimeImmutable();
        $friend = $this->_repository->findFriendById($idUser, $this->getUser()->getId());
        $friend->setConfirmed(true);
        $friend->setLastModification($date);
        $this->_em->persist($friend);
        $this->_em->flush();

        $this->forward('App\Controller\NotificationsController::remove', [
            'id' => $id,
        ]);

        return $this->redirectToRoute('app_friends_list');
    }

    /**
     * accept
     *
     * @param  mixed $id
     * @return Response
     */
    public function decline($idUser, $id): Response
    {
        $friend = $this->_repository->findFriendById($idUser, $this->getUser()->getId());

        $this->_em->remove($friend);
        $this->_em->flush();

        $this->forward('App\Controller\NotificationsController::remove', [
            'id' => $id,
        ]);

        return $this->redirectToRoute('app_friends_list');
    }
}
