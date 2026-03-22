<?php

namespace App\Controller;

use App\Entity\Article;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Commentaire;
use App\Form\CommentaireType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;

class ArticlesController extends AbstractController
{
    #[Route('/articles', name: 'app_articles')]
        public function index(ManagerRegistry $doctrine): Response
    {
        $articles = $doctrine
            ->getRepository(Article::class)
            ->findBy([], ['created_at' => 'DESC']);

        return $this->render('articles/index.html.twig', [
            'articles' => $articles,
        ]);
    }

    #[Route('/articles/{id}', name: 'app_articles_detail')]
public function detail(
    Article $article,
    Request $request,
    EntityManagerInterface $em
): Response
{
    $commentaire = new Commentaire();
    $form = $this->createForm(CommentaireType::class, $commentaire);

    $form->handleRequest($request);
    if ($form->isSubmitted() && $form->isValid() && $this->getUser()) {
        $commentaire->setArticle($article);
        $commentaire->setUser($this->getUser());
        $em->persist($commentaire);
        $em->flush();

        return $this->redirectToRoute('app_articles_detail', ['id' => $article->getId()]);
    }

    return $this->render('articles/detail.html.twig', [
        'article' => $article,
        'form' => $form->createView(),
    ]);
}
}

