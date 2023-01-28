<?php

namespace App\Security;

use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Http\Authenticator\AbstractLoginFormAuthenticator;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\CsrfTokenBadge;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\UserBadge;
use Symfony\Component\Security\Http\Authenticator\Passport\Credentials\PasswordCredentials;
use Symfony\Component\Security\Http\Authenticator\Passport\Passport;
use Symfony\Component\Security\Http\Util\TargetPathTrait;

/**
 * LoginFormAuthenticator
 */
class LoginFormAuthenticator extends AbstractLoginFormAuthenticator
{
    use TargetPathTrait;

    public const LOGIN_ROUTE = 'app_login';
    
    /**
     * __construct
     *
     * @param  mixed $urlGenerator
     * @return void
     */
    public function __construct(private UrlGeneratorInterface $urlGenerator)
    {
    }
    
    /**
     * authenticate
     *
     * @param  mixed $request
     * @return Passport
     */
    public function authenticate(Request $request): Passport
    {
        $email = $request->request->all('login_form')['email'];

        $request->getSession()->set(Security::LAST_USERNAME, $email);

        return new Passport(
            new UserBadge($email),
            new PasswordCredentials($request->request->all('login_form')['password']),
            [
                new CsrfTokenBadge('authenticate', $request->request->all('login_form')['_csrf_token']),
            ]
        );
    }
    
    /**
     * onAuthenticationSuccess
     *
     * @param  mixed $request
     * @param  mixed $token
     * @param  mixed $firewallName
     * @return Response
     */
    public function onAuthenticationSuccess(Request $request, TokenInterface $token, string $firewallName): ?Response
    {
        if ($targetPath = $this->getTargetPath($request->getSession(), $firewallName)) {
            return new RedirectResponse($targetPath);
        }

        return new RedirectResponse($this->urlGenerator->generate('app_payments'));
    }
    
    /**
     * getLoginUrl
     *
     * @param  mixed $request
     * @return string
     */
    protected function getLoginUrl(Request $request): string
    {
        return $this->urlGenerator->generate(self::LOGIN_ROUTE);
    }
}
