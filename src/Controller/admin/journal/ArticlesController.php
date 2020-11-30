<?php


namespace App\Controller\admin\journal;


use App\Entity\Articles;

use App\Form\ArticlesType;
use App\Repository\ArticlesRepository;
use Cocur\Slugify\Slugify;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;

class ArticlesController extends AbstractController
{
    /**
     * @var ArticlesRepository
     */
    private $repository;

    /**
     * @var  EntityManagerInterface
     */

    private $em;
    /**
     * ArticlesController constructor.
     * @param ArticlesRepository $repository
     * @param EntityManagerInterface $em
     */

    public function  __construct (ArticlesRepository $repository , EntityManagerInterface  $em )
    {
        $this->repository =$repository;
        $this->em = $em;
    }

    /**
     * @Route  ("/admin/articles" , name="admin.articles.index")
     * @return Response
     */
    public function index (){
        $articles = $this->repository->findAll();
        return $this->render('admin/articles/index.html.twig' ,compact('articles'));
    }
    /**
     * @Route  ("/admin/articles/create" , name="admin.articles.new")
     * @return Response
     */

    public function new (Request  $request , UserInterface $user){
        $article = new Articles();
        $form = $this->createForm(ArticlesType::class,$article);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()){
            $categorie = $article->getCategorie()->getName();
            $categorieslug = (new slugify())->slugify($categorie);
            $article = $article->setCategorieslug($categorieslug);
            $article->setAuthore($user->getUsername());
            $this->em->persist($article);
            $this->em->flush();
            return  $this->redirectToRoute('admin.articles.index');
        }
        return $this->render('admin/articles/new.html.twig' , [
            'article' => $article,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route ("/admin/property/{id}", name ="admin.articles.edit" , methods="GET|POST")
     * @param Articles $article
     */
    public function edit(Articles $article , Request $request){
        $form = $this->createForm(ArticlesType::class,$article);
        $form->handleRequest($request);
        $article->setupdateat( New \DateTime());
        if ($form->isSubmitted() && $form->isValid()){
            $categorie = $article->getCategorie()->getName();
            $categorieslug = (new slugify())->slugify($categorie);
             $article->setCategorieslug($categorieslug);
            $this->em->flush();
            $this->addFlash('success','Bien modifier avec succée');
            return  $this->redirectToRoute('admin.articles.index');
        }
        return $this->render('admin/articles/edit.html.twig' , [
            'article' => $article,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route ("/admin/property/{id}", name ="admin.articles.delete" , methods="DELETE")
     * @param Articles $article
     */
    public function delete(Articles $article , Request $request){
        if ($this->isCsrfTokenValid('delete'.$article->getId(), $request->get('_token'))){
            $this->em->remove($article);
            $this->em->flush();
            $this->addFlash('success','Bien supprimer avec succée');


        }

        return  $this->redirectToRoute('admin.articles.index');
    }
}