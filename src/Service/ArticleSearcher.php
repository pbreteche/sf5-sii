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

    /**
     * @var \App\Service\SearchExpressionParser
     */
    private $parser;

    public function __construct(ArticleRepository $repository, RouterInterface $router, SearchExpressionParser $parser)
    {
        $this->repository = $repository;
        $this->router = $router;
        $this->parser = $parser;
    }

    public function search(string $expression)
    {
        $criteria = $this->parser->parse($expression);
        if(empty($criteria)) {
            return [];
        }

        $articles = $this->repository->findByTitleContaining($criteria[0]);

        foreach($articles as &$article) {
            $article['url'] = $this->router->generate('app_article_show', ['id' => $article['id']]);
        }
        return $articles;
    }
}