<?php

namespace App\Controller;

use App\Entity\Article;
use App\Entity\Tag;
use App\Form\ArticleType;
use App\Repository\ArticleRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Entity;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Form;
use Symfony\Component\Form\FormInterface;
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

    public function indexByTag(Tag $tag, ArticleRepository $repository)
    {
        $articles = $repository->findByTag($tag);

        return $this->render('article/index_by_tag.html.twig', [
            'tag' => $tag,
            'articles' => $articles,
        ]);
    }

    /**
     * @Route("/search")
     */
    public function search(Request $request, ArticleRepository $repository)
    {
        $term = $request->query->get('search-term');
        if(!$term) {
            return $this->json([]);
        }

        $articles = $repository->findByTitleContaining($term);

        foreach($articles as &$article) {
            $article['url'] = $this->generateUrl('app_article_show', ['id' => $article['id']]);
        }

        return $this->json($articles);
    }

    /**
     * @Route("/{id}", requirements={"id":"\d+"})
     * @Entity("article", expr="repository.findWithTag(id)")
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

        $form = $this->createForm(ArticleType::class, $article);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            return $this->handleForm($article,
                'Votre article a bien été ajouté');
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
        $form = $this->createForm(ArticleType::class, $article);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            return $this->handleForm($article,
                'Votre article a bien été mis à jour');
        }

        return $this->render('article/edit.html.twig', [
            'article_form' => $form->createView(),
            'article' =>$article,
        ]);
    }

    private function handleForm(Article $article, string $successMessage) {
        $em = $this->getDoctrine()->getManager();
        $em->persist($article);
        $em->flush();

        $this->addFlash('success', $successMessage);
        return $this->redirectToRoute('app_article_show', ['id' => $article->getId()]);
    }
}