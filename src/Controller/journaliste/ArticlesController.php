<?php


namespace App\Controller\journaliste;


use App\Entity\Articles;
use App\Form\ArticlesType;
use App\Repository\ArticlesRepository;
use Cocur\Slugify\Slugify;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ArticlesController extends AbstractController
{
    public function  __construct (ArticlesRepository $repository , EntityManagerInterface  $em )
    {
        $this->repository =$repository;
        $this->em = $em;
    }

    /**
     * @Route  ("/journaliste" , name="journaliste.articles.index")
     * @return Response
     */
    public function index (){
        $articles = $this->repository->findAll();
        return $this->render('journaliste/articles/index.html.twig' ,compact('articles'));
    }
    /**
     * @Route  ("/journaliste/articles/create" , name="journaliste.articles.new")
     * @return Response
     */
    public function new (Request  $request){
        $article = new Articles();
        $form = $this->createForm(ArticlesType::class,$article);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()){
            $categorie = $article->getCategorie()->getName();
            $categorieslug = (new slugify())->slugify($categorie);
            $article = $article->setCategorieslug($categorieslug);
            $this->em->persist($article);
            $this->em->flush();
            return  $this->redirectToRoute('journaliste.articles.index');
        }
        return $this->render('journaliste/articles/new.html.twig' , [
            'article' => $article,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route ("/journaliste/property/{id}", name ="journaliste.articles.edit" , methods="GET|POST")
     * @param Articles $property
     */
    public function edit(Articles $article , Request $request){
        $form = $this->createForm(ArticlesType::class,$article);
        $form->handleRequest($request);
        $article->setupdateat( New \DateTime());
        if ($form->isSubmitted() && $form->isValid()){
            $categorie = $article->getCategorie()->getName();
            $categorieslug = (new slugify())->slugify($categorie);
            $article = $article->setCategorieslug($categorieslug);
            $this->em->flush();
            $this->addFlash('success','Bien modifier avec succée');
            return  $this->redirectToRoute('journaliste.articles.index');
        }
        return $this->render('journaliste/articles/edit.html.twig' , [
            'article' => $article,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route ("/journaliste/property/{id}", name ="journaliste.articles.delete" , methods="DELETE")
     * @param Articles $article
     */
    public function delete(Articles $article , Request $request){
        if ($this->isCsrfTokenValid('delete'.$article->getId(), $request->get('_token'))){
            $this->em->remove($article);
            $this->em->flush();
            $this->addFlash('success','Bien supprimer avec succée');


        }

        return  $this->redirectToRoute('journaliste.articles.index');
    }
}