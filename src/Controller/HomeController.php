<?php

namespace App\Controller;
use App\Repository\ArticlesRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

use Symfony\Component\Routing\Annotation\Route;


Class HomeController extends AbstractController
{



    /**
     *@Route("/" , name="home" )
     *@param ArticlesRepository $repository
     */
    public function index( ArticlesRepository $repository)
    {
        $properties = $repository->findLatest();
        return $this->render('pages/home.html.twig',
        [
        'properties' => $properties
        ]
        );
    }
}