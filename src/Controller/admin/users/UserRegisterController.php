<?php


namespace App\Controller\admin\users;


use App\Entity\User;
use App\Form\UserregisterType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController ;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Csrf\TokenGenerator\TokenGeneratorInterface;

class UserRegisterController extends AbstractController
{

    public function __construct(UserRepository $repository , EntityManagerInterface  $em ,UserPasswordEncoderInterface $encoder  )
    {
        $this->repository =$repository;
        $this->em = $em;
        $this->encoder = $encoder;

    }

    /**
     * @Route  ("/admin/users/create" , name="admin.users.new")
     */
    public function new (  Request  $request ,  \Swift_Mailer $mailer, TokenGeneratorInterface $tokenGenerator){
        $user = New User();
        $form = $this->createForm(UserregisterType::class,$user);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()){

            $token = $tokenGenerator->generateToken();
            try{
                $user->setResetToken($token);
                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($user);
                $entityManager->flush();
            } catch (\Exception $e) {
                $this->addFlash('warning', $e->getMessage());
                return $this->redirectToRoute('app_login');
            }
            $url = $this->generateUrl('app_reset_password', array('token' => $token), UrlGeneratorInterface::ABSOLUTE_URL);

            // On génère l'e-mail
            $message = (new \Swift_Message('Mot de passe oublié'))
                ->setFrom('samsvr75@gmail.com')
                ->setTo($user->getEmail())
                ->setBody(
                    "Bonjour,<br><br>Une demande de réinitialisation de mot de passe a été effectuée pour le site Nouvelle-Techno.fr. Veuillez cliquer sur le lien suivant : " . $url,
                    'text/html'
                )
            ;

            // On envoie l'e-mail
            $mailer->send($message);

            return  $this->redirectToRoute('admin.users.index');
        }

        return $this->render('admin/users/new.html.twig' , [
            'form' => $form->createView()
        ]);




    }
}
