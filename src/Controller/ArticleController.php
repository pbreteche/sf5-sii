<?php

namespace App\Controller;

use App\Entity\Article;
use App\Repository\ArticleRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class ArticleController extends AbstractController
{

    /**
     * @Route("/", methods="GET")
     */
    public function index(ArticleRepository $repository)
    {
        $articles = $repository->findAll();

        return $this->render('article/index.html.twig', [
            'articles' => $articles
        ]);
    }

    /**
     * @Route("/{id}", requirements={"id":"\d+"})
     */
    public function show(Article $article)
    {
        return $this->render('article/show.html.twig', [
            'article' => $article
        ]);
    }

    /**
     * @Route("/add", methods={"GET", "POST"})
     */
    public function create(Request $request)
    {
        $article = new Article();
        $article->setCreatedAt(new \DateTimeImmutable());

        $form = $this->createFormBuilder($article)
            ->add('title')
            ->add('body')
            ->getForm();
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($article);
            $em->flush();

            $this->addFlash('success', 'Votre article a bien été ajouté');
            return $this->redirectToRoute('app_article_show', ['id' => $article->getId()]);
        }

        return $this->render('article/create.html.twig', [
            'article_form' => $form->createView()
        ]);
    }



    /**
     * @Route("/edit/{id}", methods={"GET", "POST"})
     */
    public function edit(Request $request, Article $article)
    {
        $form = $this->createFormBuilder($article)
            ->add('title')
            ->add('body')
            ->getForm();
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($article);
            $em->flush();

            $this->addFlash('success', 'Votre article a bien été mis à jour');
            return $this->redirectToRoute('app_article_show', ['id' => $article->getId()]);
        }

        return $this->render('article/edit.html.twig', [
            'article_form' => $form->createView()
        ]);
    }
}