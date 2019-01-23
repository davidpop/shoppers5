<?php

namespace Boutique\ProduitsBundle\Controller;

use Boutique\ProduitsBundle\Entity\Category;
use Boutique\ProduitsBundle\Entity\Commande;
use Boutique\ProduitsBundle\Entity\Product;
use Boutique\ProduitsBundle\Entity\ProductCommande;
use Boutique\ProduitsBundle\Form\CommandeType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Validator\Constraints\NotBlank;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="boutique.accueil")
     */
    public function indexAction()
    {
        $lesProduits = $this->getDoctrine()->getRepository(Product::class)->findAll();
        $lesCategories = $this->getDoctrine()->getRepository(Category::class)->findAll();
        $lesCatCounts = array();
        foreach( $lesCategories as $laCat )
            $lesCatCounts[$laCat->getId()] = count(
                $this->getDoctrine()
                ->getRepository(Product::class)
                ->findByCategory($laCat->getId())
            );

        return $this->render(
            'product/boutique.html.twig',
            [
                'lesProduits' => $lesProduits,
                'lesCategories' => $lesCategories,
                'lesCounts' => $lesCatCounts,
                'panier_taille' => $this->getSizeOfCart()
            ]);
    }

    /**
     * @Route("/cart", name="cart")
     */
    public function cartAction(){
        $cart = $this->get('session')->get('cart');
        $lespqs = array();

        if ( isset($cart) )
            foreach( $cart as $clef => $prod_table ) {
                $p = $this->getDoctrine()
                        ->getRepository(Product::class)->find($prod_table['id']);
                $qte = $prod_table['qte'] ;
                $prix = $p->getPrix() * $qte ;
                $lespqs[] = array('p'=>$p, 'qte'=>$qte, 'prix'=>$prix) ;

            }
        return $this->render('product/cart.html.twig',
            array( 'ps' => $lespqs,
                'panier_taille' => $this->getSizeOfCart() )
        );
    }

    /**
     * @Route("/recalcul", name="recalc")
     */
    public function recalculerAction(Request $req){
        //dump($req);
        $oldCart = $this->get('session')->get('cart');
        $newCart = array();
        foreach( $_POST as $pid => $qte ){
            if ( is_int($pid) && is_numeric($qte) ) {
                $temp = array('id' => $pid, 'qte' => $qte);
                $newCart[] = $temp;
            }
        }
        $this->get('session')->set('cart', $newCart);

        return $this->redirectToRoute('cart');
    }
    /**
     * @Route("/resetcart", name="reset_cart")
     */
    public function resetCartAction(Request $req){
        $this->get('session')->set('cart', array());
        return $this->redirectToRoute('cart');
    }
    /**
     * @Route("/paiement", name="paiement")
     */
    public function paiementAction(Request $request){
        $cid = $this->get('session')->get('cid');
        $cmd = $this->getDoctrine()->getRepository(Commande::class)->find($cid);
        $form = $this->get('form.factory')
            ->createNamedBuilder('payment-form')
            ->add('token', HiddenType::class, [
                'constraints' => [new NotBlank()],
            ])
            ->add('submit', SubmitType::class)
            ->getForm();
        if ( $request->isMethod('POST')  ) {
            $form->handleRequest($request);
            if ( $form->isValid() ) {
                // TODO: charge the card
                try {
                    //$amount = $this->get('session')->get('amount' );

                    $stripe = $this->get('app.client.stripe');
                    $stripe->createPremiumCharge(
                            $cmd,
                            $form->get('token')->getData()
                        );
                    $this->addFlash('success',"Votre paiement effectué avec succès !" );
//                    $this->get('session')->set('PaymentStatus',true);
                    $redirect = $this->generateUrl('validate_cart',['step' => 3]);
                } catch (\Stripe\Error\Base $e) {
                    $this->addFlash('warning',
                        sprintf('Impossible de valider le paiement , %s',
                            $e instanceof \Stripe\Error\Card ? lcfirst($e->getMessage()) : 'Veuillez réessayer. .'));
//                    $this->get('session')->set('PaymentStatus',false);
                    $redirect = $this->generateUrl('paiement');
                } finally {
//                    $this->get('session')->remove('amount');
                    $em = $this->getDoctrine()->getManager();
                    $em->merge($cmd);
                    $em->flush();
                    return $this->redirect($redirect);
                }
            }
        }
        return $this->render('product/paiement.html.twig', [
            'form' => $form->createView(),
            'stripe_public_key' => $this->getParameter('stripe_public_key'),
            'montant' => $cmd->getMontant()
        ]);
    }


    // a - si on est connecté on préremplit le formulaire d infos pour qu'il le valide
    // b - sinon on lui dmd soit de se connecter, soit de s'enregistrer puis retour au 1
    // c - formumaire de paiement
    // d - persistance de la commande
    // e - persistance des produits-commandés
    // f - affichage de la facture envoyé par mail + lien-btn('boutique.accueil')
    /**
     * @Route("/validatecart/{step}", name="validate_cart")
     */
    public function validateCartAction(Request$request, $step=1){
        if ( $step == 1 ){
            $utilisateur = $this->getUser();
            if (  $utilisateur == null ){
                return $this->render('product/demande_connexion.html.twig');
            }
            return $this->redirectToRoute('validate_cart',['step'=>2]);
        }
        /*****************************************************************/
        /*****************************************************************/
        if ( $step == 2 ) {
            $cart = $this->get('session')->get('cart');
            $em = $this->getDoctrine()->getManager();
            $total = 0 ;
            foreach ($cart as $clef => $prod_table) {
                $produit = $em->getRepository(Product::class)
                    ->find($prod_table['id']);
                $total += $produit->getPrix() * $prod_table['qte'] ;
            }
            $this->get('session')->set('amount', $total );
            $cmd = new Commande();
            $cmd->setUser( $this->getUser() );
            $cmd->setMontant( $total );
            $em = $this->getDoctrine()->getManager();
            $em->persist($cmd);
            $em->flush();
            $this->get('session')->set('cid', $cmd->getId() );
            return $this->redirectToRoute('paiement');
        }
        if ( $step == 3 ) {

            // on va persister la cmd et les produits commandés
            // et effacer le panier
            $user = $this->getUser();
            ///
            $cart = $this->get('session')->get('cart');
            $cid = $this->get('session')->get('cid');
            $em = $this->getDoctrine()->getManager();

//            dump($cart, $cid);

            foreach ($cart as $clef => $prod_table) {
                $produit = $em->getRepository(Product::class)
                    ->find($prod_table['id']);
                $c = $em->getRepository(Commande::class)
                    ->find($cid);
                $produitCommande = new ProductCommande();
                $produitCommande->setPrix($produit->getPrix() * $prod_table['qte']);
                $produitCommande->setProduct($produit);
                $produitCommande->setCommande($c);
                $produitCommande->setQuantite($prod_table['qte']);
                $em->persist($produitCommande);
                $this->get('session')->remove('cart');
                // $this->get('session')->clear();
            }
            $em->flush();
            return $this->redirectToRoute('validate_cart',['step'=>4]);
        }
        if ( $step == 4 ){
//            dump( $this->get('session'));
            $utilisateur = $this->getUser();
            $laCommande = $this->getDoctrine()
                ->getRepository(Commande::class)
                ->find($this->get('session')->get('cid'));
            $lesPC = $this->getDoctrine()
                ->getRepository(ProductCommande::class)
                ->findBy(['commande' => $laCommande->getId() ]);
            $prixTotal = 0 ;
            $tableau = array();
            foreach ($lesPC as $lePC ) {
                $prixTotal += $lePC->getPrix() * $lePC->getQuantite();
                $id = $lePC->getProduct()->getId();
                $leProduit = $this->getDoctrine()->getManager()
                    ->getRepository(Product::class)
                    ->find($id);
//                dump( $leProduit );
                $tableau[] = array('pc'=>$lePC, 'p' => $leProduit);
            }
            // envoi de l email
            $contenu = $this->render('product/mail_commande.html.twig',
                array( 'cmd' => $laCommande, 'tableau' => $tableau,
                    'prix' => $prixTotal, 'user' => $utilisateur )
            );
/*
            dump($tableau);
            die("");
*/
            $this->sendEmail(
                $utilisateur->getEmail(), $utilisateur->getEmail(),
                'commande n°'.$laCommande->getId(), $contenu
            );
            $this->get('session')->clear();
            return $this->render('product/product_commande.html.twig',
                array(
                    'cmd' => $laCommande,
                    'tableau' => $tableau,
                    'prix' => $prixTotal,
                    'user' => $utilisateur
                )
            );
        }
    }

    //  nbr de Produits VS nb d Articles
    //  count($cart) ;
    //  foreach( $cart as $clef => $prod_table )  $taille ++ ;
    public function getSizeOfCart(){
        $cart = $this->get('session')->get('cart');


        if ( isset($cart) )
            return count($cart) ;
        return 0 ;

    }
    public function sendEmail($from, $to, $subject,$text,$type='text/html'){

        $mailer = $this->get('mailer');
        $message = (new \Swift_Message($subject))
            ->setFrom($from)
            ->setTo($to)
            ->setBody($text, $type);

        return $mailer->send($message);
    }

    /**
     * @Route("/chglng", name="change_lang")
     */
    public function changeLanguageAction(Request $r){
        $locale = $r->getLocale();
        $l = $r->get('_locale');
//        dump( $locale , $l);
//        exit(1);

        if ( $locale == 'fr')
            $this->get('session')->set('_locale','en');
        else
            $this->get('session')->set('_locale','fr');

        $url = $r->headers->get('referer');
        if( empty( $url) )
            $url = $this->container->get('router')->generate('boutique.accueil');
        return $this->redirect($url);

    }
}
