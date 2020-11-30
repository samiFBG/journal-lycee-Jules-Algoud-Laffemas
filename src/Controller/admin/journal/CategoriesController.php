<?php


namespace App\Controller\admin\journal;


use App\Entity\Categorie;
use App\Form\CategorieType;
use App\Repository\CategorieRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class CategoriesController extends AbstractController
{
    /**
     * @var CategorieRepository
     */
    private $repository;
    /**
     * @var EntityManagerInterface
     */
    private $em;


    /**
     * CategoriesController constructor.
     * @param CategorieRepository $repository
     * @param EntityManagerInterface $em
     */
    public function __construct(CategorieRepository $repository , EntityManagerInterface $em){
        $this->repository = $repository;
        $this->em = $em;
    }

    /**
     * @Route ("/admin/categories" , name="admin.categorie.index")
     */
    public function index(){
        $categories =$this->repository->findAll();
        return $this->render('admin/categorie/index.html.twig ' ,compact('categories'));
    }

    /**
     * @Route ("/admin/categories/create" , name="admin.categorie.new")
     */
    public function new(Request  $request){
        $categorie = new Categorie();
        $form = $this->createForm(CategorieType::class,$categorie);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()){
            $this->em->persist($categorie);
            $this->em->flush();
            return  $this->redirectToRoute('admin.categorie.index');
        }
        return $this->render('admin/categorie/new.html.twig' , [
            'categorie' => $categorie,
            'form' => $form->createView()
        ]);

    }

    /**
     * @Route ("/admin/categories/edit/{id}" , name="admin.categorie.edit", methods="GET|POST")
     */
    public function edit(Categorie $categorie , Request $request){
        $form = $this->createForm(CategorieType::class,$categorie);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()){
            $this->em->flush();
            $this->addFlash('success','Bien modifier avec succée');
            return  $this->redirectToRoute('admin.categorie.index');
        }
        return $this->render('admin/categorie/edit.html.twig' , [
            'categorie' => $categorie,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route ("/admin/categories/delete/{id}" , name="admin.categorie.delete", methods="GET|POST")
     */
    public function delete(Request $request ,Categorie $categorie){
        if ($this->isCsrfTokenValid('delete'.$categorie->getId(), $request->get('_token'))){
            $this->em->remove($categorie);
            $this->em->flush();
            $this->addFlash('success','Bien supprimer avec succée');


        }

        return  $this->redirectToRoute('admin.categorie.index');
    }
}