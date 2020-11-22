<?php


namespace App\Controller\admin;


use App\Entity\User;
use App\Form\UserregisterType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class UserManagement extends AbstractController
{

    public function __construct(UserRepository $repository , EntityManagerInterface  $em  ){
        $this->repository =$repository;
        $this->em = $em;
    }
    /**
     * @Route  ("/admin/users" , name="admin.users.index")
     * @return Response
     **/
    public function index (){
        $users = $this->repository->findAll();
        return $this->render('admin/users/index.html.twig',compact('users'));
    }

    /**
     * @Route ("/admin/users/{id}", name ="admin.users.edit" , methods="GET|POST")
     * @param User $users
     */
    public function edit(User $users , Request $request){
        $form = $this->createForm(UserregisterType::class,$users);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()){
            $this->em->flush();
            $this->addFlash('success','Bien modifier avec succée');
            return  $this->redirectToRoute('admin.articles.index');
        }
        return $this->render('admin/users/edit.html.twig' , [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route ("/admin/users/{id}", name ="admin.users.delete" , methods="DELETE")
     * @param User $users
     */
    public function delete(User $users , Request $request){
        if ($this->isCsrfTokenValid('delete'.$users->getId(), $request->get('_token'))){
            $this->em->remove($users);
            $this->em->flush();
            $this->addFlash('success','Utilisateur supprimer avec succée');


        }

        return  $this->redirectToRoute('admin.articles.index');
    }
}