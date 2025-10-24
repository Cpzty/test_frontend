<?php

namespace App\Controller;

use League\OAuth2\Client\Provider\Google;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class GoogleAuthController extends AbstractController
{
    #[Route('/login/google', name: 'google_login')]
    public function login(Request $request): Response
    {
        $provider = new Google([
            'clientId'     => $_ENV['GOOGLE_CLIENT_ID'],
            'clientSecret' => $_ENV['GOOGLE_CLIENT_SECRET'],
            'redirectUri'  => $_ENV['GOOGLE_REDIRECT_URI'],
        ]);

        if (!$request->query->has('code')) {
            $authUrl = $provider->getAuthorizationUrl([
                'scope' => ['email', 'profile']
            ]);

            return $this->redirect($authUrl);
        }

        $token = $provider->getAccessToken('authorization_code', [
            'code' => $request->query->get('code')
        ]);

        $googleUser = $provider->getResourceOwner($token);

        return $this->redirectToRoute('summary_list');

    }
}
