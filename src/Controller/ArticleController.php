<?php

namespace App\Controller;

use App\Entity\Article;
use App\Repository\ArticleRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class ArticleController extends AbstractController
{

    /**
     * @Route("/", methods="GET")
     */
    public function index(ArticleRepository $repository)
    {
        $articles = $repository->findAll();

        return $this->json($articles);
    }

    /**
     * @Route("/{id}", requirements={"id":"\d+"})
     */
    public function show(Article $article)
    {
        return $this->json($article);
    }
}