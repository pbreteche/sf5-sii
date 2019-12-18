<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/api")
 */
class RestApiController extends AbstractController
{
    /**
     * @Route("")
     */
    public function index()
    {
        return $this->json([
            'message' => 'Welcome to your new controller!',
        ]);
    }

    /**
     * @Route("/{name}",
     *     methods="GET",
     *     requirements={"name":"[^/]+"},
     *     defaults={"name":"tout le monde"})
     */
    public function hello(string $name)
    {
        return $this->json([
            'message' => 'Salut '.$name.'!',
        ]);
    }
}
