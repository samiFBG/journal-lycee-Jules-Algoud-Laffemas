<?php


namespace App\Controller\admin;


use App\Entity\User;
use App\Form\UserregisterType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController ;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Address;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserRegisterController extends AbstractController
{

    public function __construct(UserRepository $repository , EntityManagerInterface  $em ,UserPasswordEncoderInterface $encoder  ){
        $this->repository =$repository;
        $this->em = $em;
        $this->encoder = $encoder;

    }

    /**
     * @Route  ("/admin/users/create" , name="admin.users.new")
     */
    public function new (  Request  $request ,  MailerInterface $mailer){
        $user = New User();
        $form = $this->createForm(UserregisterType::class,$user);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()){
            $chaine ="mnoTUzS5678kVvwxy9WXYZRNCDEFrslq41GtuaHIJKpOPQA23LcdefghiBMbj0";
            srand((double)microtime()*1000000);
            $pass = '';
            for($i=0; $i<10; $i++){
                $pass .= $chaine[rand()%strlen($chaine)];
            }
            $user->setPassword($this->encoder->encodePassword($user,$pass));
            $this->em->persist($user);
            $this->em->flush();
            $email = (new TemplatedEmail())
                ->from(new Address('no-reply@journalalgoudlaffemas.xnh.fr', 'JournalAlgoudLaffemas'))
                ->to($user->getemail())
                ->subject('Your account ')
                ->htmlTemplate('admin/users/mail/adduser.html.twig')
                ->context([
                    'name'=> $user->getUsername(),
                    'password' => $pass,
                ])
            ;

            $mailer->send($email);
            return  $this->redirectToRoute('admin.users.index');
        }

        return $this->render('admin/users/new.html.twig' , [
            'form' => $form->createView()
        ]);




    }
}
