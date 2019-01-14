<?php

namespace Boutique\ProduitsBundle\Controller;

use Boutique\ProduitsBundle\Entity\ProductCommande;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Productcommande controller.
 *
 * @Route("productcommande")
 */
class ProductCommandeController extends Controller
{
    /**
     * Lists all productCommande entities.
     *
     * @Route("/", name="productcommande_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $productCommandes = $em->getRepository('BoutiqueProduitsBundle:ProductCommande')->findAll();

        return $this->render('productcommande/index.html.twig', array(
            'productCommandes' => $productCommandes,
        ));
    }

    /**
     * Creates a new productCommande entity.
     *
     * @Route("/new", name="productcommande_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $productCommande = new Productcommande();
        $form = $this->createForm('Boutique\ProduitsBundle\Form\ProductCommandeType', $productCommande);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($productCommande);
            $em->flush();

            return $this->redirectToRoute('productcommande_show', array('id' => $productCommande->getId()));
        }

        return $this->render('productcommande/new.html.twig', array(
            'productCommande' => $productCommande,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a productCommande entity.
     *
     * @Route("/{id}", name="productcommande_show")
     * @Method("GET")
     */
    public function showAction(ProductCommande $productCommande)
    {
        $deleteForm = $this->createDeleteForm($productCommande);

        return $this->render('productcommande/show.html.twig', array(
            'productCommande' => $productCommande,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing productCommande entity.
     *
     * @Route("/{id}/edit", name="productcommande_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, ProductCommande $productCommande)
    {
        $deleteForm = $this->createDeleteForm($productCommande);
        $editForm = $this->createForm('Boutique\ProduitsBundle\Form\ProductCommandeType', $productCommande);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('productcommande_edit', array('id' => $productCommande->getId()));
        }

        return $this->render('productcommande/edit.html.twig', array(
            'productCommande' => $productCommande,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a productCommande entity.
     *
     * @Route("/{id}", name="productcommande_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, ProductCommande $productCommande)
    {
        $form = $this->createDeleteForm($productCommande);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($productCommande);
            $em->flush();
        }

        return $this->redirectToRoute('productcommande_index');
    }

    /**
     * Creates a form to delete a productCommande entity.
     *
     * @param ProductCommande $productCommande The productCommande entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(ProductCommande $productCommande)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('productcommande_delete', array('id' => $productCommande->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }

    /**
     * @Route("showproduit/{id}", name="produits.show")
     */
    public function showActionByUrl( $id)
    {
        $em = $this->getDoctrine()->getManager();
        $produit = $em->getRepository(Product::class)->find( $id );
        $images = $em->getRepository(Image::class)->findBy(['produit' => $produit]);
        return $this->render('produits/produit/show.html.twig', array
            ('produit' => $produit, 'images' => $images )
        );
    }

}
