<?php

namespace Boutique\ProduitsBundle\Controller;

use Boutique\ProduitsBundle\Entity\Product;
use FOS\RestBundle\View\View;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use FOS\RestBundle\Controller\Annotations as Rest;

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
     * @Rest\Get("/produits")
     * @Rest\View()
     */
    public function getProduitsAction()
    {
        $em = $this->getDoctrine()->getManager();
        $products = $em->getRepository('BoutiqueProduitsBundle:Product')->findAll();
        /*
        $res = array();
        foreach ($products as $product)
            $res[] = array(
                'id' => $product->getId(),
                'nom' => $product->getNom(),
                'prix' => $product->getPrix(),
                'description' => $product->getDescription(),
                'image' => $product->getPhotoPrincipale()->getImageName()
            );
        */
        //$viewHandler = $this->get('fos_rest.view_handler');
        $view = View::create($products);
        $view->setFormat('json');
        // dans le config.yml, on a defini le handler donc
        //return $viewHandler->handle($view);
        return $view ;
    }

    /**
     * @Rest\Get("/produits/{id}")
     * @Rest\View()
     */
    public function getProduitAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $product = $em->getRepository('BoutiqueProduitsBundle:Product')->find($id);

        if ( $product ) {
            $res = array(
                'id' => $product->getId(),
                'nom' => $product->getNom(),
                'prix' => $product->getPrix(),
                'description' => $product->getDescription(),
                'image' => $product->getPhotoPrincipale()->getImageName()
            );
            $viewHandler = $this->get('fos_rest.view_handler');
            $view = View::create($res);
            $view->setFormat('json');
            return $view ;
        } else
            return new JsonResponse(
                    ['message' => 'Product not found'],
                    Response::HTTP_NOT_FOUND
            );
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

    /**
     * Lists all product entities sorted .
     *
     * @Route("/sort", name="product_sort")
     * @Method({"POST"})
     */
    public function postSortProductAction(Request $req){
        if ( $req->isXmlHttpRequest() ) {
            $em = $this->getDoctrine()->getManager();
            $crit = $req->request->get('crit');  // crit [name, prix]
            $order = $req->request->get('ord'); // order [ASC, DESC ]
            //        dump($crit, $order);
            //        exit(1);
            $products = $em->getRepository('BoutiqueProduitsBundle:Product')
                ->findBy([], array($crit => $order));
            $tab = array();
            foreach ($products as $product)
                $tab[] = array(
                    'id' => $product->getId(),
                    'nom' => $product->getNom(),
                    'description' => $product->getDescription(),
                    'prix' => $product->getPrix(),
                    'quantite' => $product->getQuantite(),
                    'alt' => $product->getPhotoPrincipale()->getAlt(),
                    'imageName' => $product->getPhotoPrincipale()->getImageName()
                );

            return new JsonResponse($tab);
        }
    }

    /**
     * Lists all product entities sorted .
     *
     * @Route("/sortprices", name="product_prices")
     * @Method({"POST"})
     */
    public function postProductsPriceRangeAction(Request $req){
        $em = $this->getDoctrine()->getManager();
        $min = $req->request->get('min');
        $max =  $req->request->get('max');
        dump($min, $max);
        exit(1);
        $products = $em->getRepository('BoutiqueProduitsBundle:Product')
            ->pricesBetween($min, $max);
        $tab = array();
        foreach( $products as $product)
            $tab[] = array(
                'id' => $product->getId(),
                'nom' => $product->getNom(),
                'description' => $product->getDescription(),
                'prix' => $product->getPrix(),
                'quantite' => $product->getQuantite(),
                'alt' => $product->getPhotoPrincipale()->getAlt(),
                'imageName' => $product->getPhotoPrincipale()->getImageName()
            );

        return new JsonResponse($tab) ;
    }

}
