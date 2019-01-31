<?php

namespace Boutique\FrontBundle\Controller;

use Boutique\FrontBundle\Form\ContactType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\Form\SubmitButton;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="accueil")
     */
    public function indexAction()
    {
        return $this->render('front/default/index.html.twig');
    }
    /**
     * @Route("/about", name="about")
     */
    public function aboutAction()
    {
        return $this->render('front/default/about.html.twig');
    }
    /**
     * @Route("/contact", name="contact")
     */
    public function contactAction()
    {
        $form = $this->createForm(ContactType::class);
        return $this->render( "front/default/contact.html.twig",
            ['form' => $form->createView() ]);
    }

    /**
     * @Route("/contactform", name="contactform")
     * @Method({"POST"})
     */
    public function postContactAction(Request $req)
    {

        $form = $this->createForm(ContactType::class);
//        $form->add("Envoyer", SubmitButton::class);

        if ( $req->isXmlHttpRequest() ) {
            $form->handleRequest($req);
            if ($form->isSubmitted() && $form->isValid() ) {
                /*
                            $nom = $req->request->get('c_fname');
                            $pnom = $req->request->get('c_lname');
                            $eml = $req->request->get('c_email');
                            $msg = $req->request->get('c_message');*/

//                dump( $form->getData('nom')['nom'] );
//                exit(1);
                // envoi de l email
                $contenu = $this->render('front/default/mail.html.twig',
                    array('nom' => $form->get('nom')->getData() ,
                        'prenom' => $form->get('prenom')->getData(),
                        'email' => $form->get('email')->getData() ,
                        'sujet' => $form->get('sujet')->getData(),
                        'message' => $form->get('message')->getData() )
                );

                $this->sendEmail($form->get('email')->getData(),
                    $form->get('email')->getData(),'contact', $contenu );
                return new JsonResponse("OK");
            }
        }
        return $this->render( "front/default/contact.html.twig",
            ['form' => $form->createView() ]);
    }

    public function sendEmail($from, $to, $subject,$text,$type='text/html'){

        $mailer = $this->get('mailer');
        $message = (new \Swift_Message($subject))
            ->setFrom($from)
            ->setTo($to)
            ->setBody($text, $type);

        return $mailer->send($message);
    }
}
