<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Articles;
use App\Repository\ArticlesRepository;


class ArticlesController extends AbstractController
{

    public function index(): Response
    {
        return $this->render('articles/index.html.twig', [
            'controller_name' => 'ArticlesController',
        ]);
    }
    /**
     * @Route("/{slugcategorie}/{years}/{month}/{day}/{slugtitle}", name="property.show" ,requirements={"slugcategorie":"[a-z0-9\-]*"})
     */
    public function show(  $slugcategorie , $years, $month, $day, $slugtitle )
    {
        $repository = $this->getDoctrine()->getRepository(Articles::class);
        $articles = $repository->findOneBy([
            'titleslug' => $slugtitle,
            'categorieslug' => $slugcategorie,
        ]);
        dump($articles);
        return $this->render("articles/show.html.twig" ,[
            'articles'=>$articles,
        ]);
    }
}
