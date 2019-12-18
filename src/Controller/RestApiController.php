<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class RestApiController extends AbstractController
{
    /**
     * @Route("/api")
     */
    public function index()
    {
        return $this->json([
            'message' => 'Welcome to your new controller!',
        ]);
    }
}
