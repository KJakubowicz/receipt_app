<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\Response;
use App\Serives\ResponseServices;
use OpenApi\Annotations as OA;

class UserController extends AbstractController
{
    /**
     * Class UserRepository.
     *
     * @var UserRepository
     */
    private UserRepository $_userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->_userRepository = $userRepository;
    }

    /**
    * @OA\Tag(name="user")
    */
    public function getActiveUserData(): Response
    {
        $response = new ResponseServices();

        if(!$this->getUser()) {
            $response->setStatus(400);
            $response->setMessage('Błąd podczas pobierania danych');
            $response->setData([]);
        } else {
            $response->setStatus(200);
            $response->setMessage('Poprawnie pobrano liczbę powiadomień');
            $response->setData([
                'email' => $this->getUser()->getEmail(),
                'name' => $this->getUser()->getName(),
                'surname' => $this->getUser()->getSurname(),
                'role' => $this->getUser()->getRoles(),
            ]);
        }

        return $this->json($response->getResponse());
    }
}
