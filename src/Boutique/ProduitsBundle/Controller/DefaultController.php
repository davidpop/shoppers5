<?php

namespace Boutique\ProduitsBundle\Controller;

use Boutique\ProduitsBundle\Entity\Category;
use Boutique\ProduitsBundle\Entity\Commande;
use Boutique\ProduitsBundle\Entity\Product;
use Boutique\ProduitsBundle\Entity\ProductCommande;
use Boutique\ProduitsBundle\Form\CommandeType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;

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
                'lesCounts' =>$lesCatCounts,
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


    // 1 - on remplit un formulaire de commande
    // il faudra l id de la cmd pour le 2
    // 2 - on affiche le panier avec les infos en haut et le total en bas
    /**
     * @Route("/validatecart/{step}", name="validate_cart")
     */
    public function validateCartAction(Request$request, $step=1){
        if ( $step == 1 ) {
            $user = $this->getUser();

            dump($user);
            exit(1);
            // si on n est pas connecté on redirige vers le formLogin
            // si les infos user sont incomplètes, on lui affiche le formUser
            // sinon

            $cmd = new Commande();
            $formCmd = $this->createForm(CommandeType::class, $cmd);
            $formCmd->handleRequest($request);

            if ($formCmd->isSubmitted() && $formCmd->isValid()) {
                $em = $this->getDoctrine()->getManager();
                $em->persist($cmd);
                $em->flush();
                $this->get('session')->set('cid', $cmd->getId() );
                return $this->redirectToRoute('validate_cart',['step'=>2]);
            }

            return $this->render('product/simple.html.twig',
                array('f' => $formCmd->createView(), 'panier_taille'=> $this->getSizeOfCart() )
            );



        }
        if ( $step == 2) {
            $cart = $this->get('session')->get('cart');
            $cid = $this->get('session')->get('cid');
            $em = $this->getDoctrine()->getManager();

            foreach ($cart as $clef => $prod_table) {
                $produit = $em->getRepository(Product::class)->find($prod_table['id']);
                $c = $em->getRepository(Commande::class)->find($cid);
                $produitCommande = new ProductCommande();
                $produitCommande->setPrix($produit->getPrix() * $prod_table['qte']);
                $produitCommande->setProduct($produit);
                $produitCommande->setCommande($c);
                $produitCommande->setQuantite($prod_table['qte']);

                /*
                dump($cart);
                dump('prix : '. $produit->getPrix() );
                dump('qte  : '. $prod_table['qte'] );
                dump($cid);
                dump($produitCommande);
                dump($produit);*/

                $em->persist($produitCommande);
                $this->get('session')->remove('cart');
                // $this->get('session')->clear();
            }
            $em->flush();
            return $this->redirectToRoute('validate_cart',['step'=>3]);
        }
        if ( $step == 3 ){

//            dump( $this->get('session'));

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
                dump( $leProduit );
                $tableau[] = array('pc'=>$lePC, 'p' => $leProduit);
            }

            dump( $tableau );
  //          exit(1);

            // envoi de l email
            $contenu = $this->render('product/product_commande.html.twig',
                array( 'cmd' => $laCommande, 'tableau' => $tableau, 'prix' => $prixTotal )
            );
            $this->sendEmail(
                $laCommande->getEmail(), 'davidpopotte@gmail.com',
                'commande n°'.$laCommande->getId(),
                $contenu
            );

            $this->get('session')->clear();

            return $this->render('product/product_commande.html.twig',
                array(
                    'cmd' => $laCommande,
                    'tableau' => $tableau,
                    'prix' => $prixTotal
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
}
