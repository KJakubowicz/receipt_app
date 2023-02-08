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
use App\Helper\FriendsHelper;
use Symfony\Component\HttpFoundation\Request;

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
     * Interface EntityManagerInterface.
     *
     * @var FriendsHelper
     */
    private FriendsHelper $_helper;
        
    /**
     * __construct
     *
     * @param  mixed $friendsRepository
     * @param  mixed $userRepository
     * @param  mixed $em
     * @return void
     */
    public function __construct(FriendsRepository $friendsRepository, UserRepository $userRepository, EntityManagerInterface $em, FriendsHelper $helper)
    {
        $this->_repository = $friendsRepository;
        $this->_userRepository = $userRepository;
        $this->_em = $em;
        $this->_helper = $helper;
    }
    
    /**
     * list
     *
     * @return Response
     */
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
        $rows = $this->_repository->findByUserId($this->getUser()->getId());
        $listBuilder->setRows($rows);
        $listBuilder->setPaggination(0);
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
        $choices = $this->_userRepository->findUsersForChoises($this->getUser()->getId());
        $form = $this->createForm(FriendsAddFormType::class,null,[
            'choices' => $choices,
        ]);
        $form->handleRequest($request);

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
}
