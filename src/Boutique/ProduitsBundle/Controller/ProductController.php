<?php

namespace Boutique\ProduitsBundle\Controller;

use Boutique\ProduitsBundle\Entity\Product;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

/**
 * Product controller.
 *
 * @Route("product")
 */
class ProductController extends Controller
{
    /**
     * Lists all product entities.
     *
     * @Route("/", name="product_index")
     * @Method("GET")
     */
    public function indexAction(){
        $em = $this->getDoctrine()->getManager();

        $products = $em->getRepository('BoutiqueProduitsBundle:Product')->findAll();

        return $this->render('product/index.html.twig', array(
            'products' => $products, 'panier_taille' => 0
        ));
    }
    /**
     * @Route("/search", name="product_search")
     *
     */
    public function searchByNameAction(Request $request){
        $terme = $request->request->get('terme') ;
        $em = $this->getDoctrine()->getManager();
        $ps = $em->getRepository(Product::class)->findNameLike($terme);
        return $this->render('product/search.html.twig', array
            ('text_haut'=>'Resultats de la recherche','ps' => $ps)
        );
    }

    /**
     * @Route("/showbytype/{catid}", name="product_typed")
     */
    public function showByType($catid){
        $em = $this->getDoctrine()->getManager();
        //$type = $request->query()->get('catid');

        $products = $em->getRepository('BoutiqueProduitsBundle:Product')
            ->findByCategory($catid);

        return $this->render('product/search.html.twig',
            array(
                'text_haut'=>'',
            'ps' => $products
        ));
    }

    /**
     * @Route("/addtocart/{pid}", name="product_addtocart")
     */
    public function addToCartAction(Request $req, $pid){
/*
        dump($_POST, $_GET);
        exit(1);*/

        $s = $this->get('session');
        $cart = $s->get('cart');
        $qte = $req->request->get('quantite');
        $t = array('id' => $pid, 'qte' => $qte);

//        dump($t);

        if (!isset($cart) )
            $cart = array();
        foreach( $cart as $clef => $prod_table ) {
            if ( $pid == $prod_table['id'] ) {
                $t = array('id' => $pid, 'qte' => $prod_table['qte'] + $qte);
                unset($cart[$clef]);
            }
        }
        $cart[] = $t;

        $s->set('cart', $cart);
        return $this->redirectToRoute('boutique.accueil');
    }
    /**
     * @Route("/delfromcart/{pid}", name="product_delfromcart")
     */
    public function delFromCartAction(Request $req, $pid){

        $s = $this->get('session');
        $cart = $s->get('cart');
        foreach( $cart as $clef => $prod_table ) {
            if ( $pid == $prod_table['id'] ) {
                unset($cart[$clef]);
            }
        }
        $s->set('cart', $cart);
        return $this->redirectToRoute('boutique.accueil');
    }

    /**
     * Creates a new product entity.
     *
     * @Security("is_granted('ROLE_ADMIN')")
     *
     * @Route("/new", name="product_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $product = new Product();
        $form = $this->createForm('Boutique\ProduitsBundle\Form\ProductType', $product);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($product);
            $em->flush();

            //return $this->redirectToRoute('product_show', array('id' => $product->getId()));
            return $this->redirectToRoute('product_index');
        }

        return $this->render('product/new.html.twig', array(
            'product' => $product,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a product entity.
     *
     * @Route("/{id}", name="product_show")
     * @Method("GET")
     */
    public function showAction(Product $product)
    {
        // pas bon du tout, les img ont disparu apres la V4
        $images = null ;
/*        $deleteForm = $this->createDeleteForm($product);

        return $this->render('product/show.html.twig',
            array('product' => $product,'delete_form' => $deleteForm->createView(),));
*/
        return $this->render('product/show2.html.twig',
            array('product' => $product,'images' => $images));
    }

    /**
     * Displays a form to edit an existing product entity.
     *
     * @Security("is_granted('ROLE_ADMIN')")
     *
     * @Route("/{id}/edit", name="product_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Product $product)
    {
        $deleteForm = $this->createDeleteForm($product);
        $editForm = $this->createForm('Boutique\ProduitsBundle\Form\ProductType', $product);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('product_edit', array('id' => $product->getId()));
        }

        return $this->render('product/edit.html.twig', array(
            'product' => $product,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a product entity.
     *
     * @Security("is_granted('ROLE_ADMIN')")
     *
     * @Route("/{id}", name="product_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Product $product)
    {
        $form = $this->createDeleteForm($product);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($product);
            $em->flush();
        }
        return $this->redirectToRoute('product_index');
    }

    /**
     * Creates a form to delete a product entity.
     *
     * @Security("is_granted('ROLE_ADMIN')")
     *
     * @param Product $product The product entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Product $product)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('product_delete', array('id' => $product->getId())))
            ->setMethod('DELETE')
            ->getForm();
    }


}
