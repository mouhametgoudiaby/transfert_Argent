<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Lexik\Bundle\JWTAuthenticationBundle\Tests\Stubs\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Lexik\Bundle\JWTAuthenticationBundle\Encoder\JWTEncoderInterface;

class SecurityController extends AbstractController
{
    /**
     * @Route("/security", name="security")
     */
    public function index()
    {
        return $this->render('security/index.html.twig', [
            'controller_name' => 'SecurityController',
        ]);
    }

    
    /**
     * @Route("/login", name="login", methods={"POST","GET"})
     * @param JWTEncoderInterface $JWTEncoder
     * @param JsonResponse
     * @throws \Lexik\Bundle\JWTAuthenticationBundle\Exception\JWTEncodeFailureException
     */
    public function login(Request $request , JWTEncoderInterface $JWTEncoder)
    {

        $values = json_decode($request->getContent());
        $user = $this->getDoctrine()->getRepository(User::class)->findOneBy([
            'username' => $values->username,
        ]);
        $token = $JWTEncoder->encode([
                'username' => $user->getUsername(),
                'roles' => $user->getRoles(),
                'exp' => time() + 3600 // 1 hour expiration
            ]);
        return $this->json([
            'token' => $token
        ]);
    }
}
