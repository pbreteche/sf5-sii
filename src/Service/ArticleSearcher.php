<?php


namespace App\Service;


use App\Repository\ArticleRepository;
use Symfony\Component\Routing\RouterInterface;

class ArticleSearcher
{

    /**
     * @var \App\Repository\ArticleRepository
     */
    private $repository;

    /**
     * @var \Symfony\Component\Routing\RouterInterface
     */
    private $router;

    public function __construct(ArticleRepository $repository, RouterInterface $router)
    {
        $this->repository = $repository;
        $this->router = $router;
    }

    public function search(string $term)
    {
        if(!$term) {
            return [];
        }

        $articles = $this->repository->findByTitleContaining($term);

        foreach($articles as &$article) {
            $article['url'] = $this->router->generate('app_article_show', ['id' => $article['id']]);
        }
        return $articles;
    }
}