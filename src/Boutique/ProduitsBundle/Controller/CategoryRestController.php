<?php

namespace Boutique\ProduitsBundle\Controller;

use Boutique\ProduitsBundle\Entity\Category;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use FOS\RestBundle\View\View;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\HttpFoundation\Request;

class CategoryRestController extends Controller
{
    /**
     * @Rest\Get("/categories")
     * @Rest\View()
     */
    public function getCategoriesAction()
    {
        $em = $this->getDoctrine()->getManager();
        $cats = $em->getRepository('BoutiqueProduitsBundle:Category')->findAll();
        $view = View::create($cats);
        $view->setFormat('json');
        return $view ;
    }
    /**
     * @Rest\Get("/category/{id}")
     * @Rest\View()
     */
    public function getCategorieAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $cat = $em->getRepository('BoutiqueProduitsBundle:Category')->find($id);
        if ( $cat ) {
            $view = View::create($cat);
            $view->setFormat('json');
            return $view;
        }

    }
    /**
     * @Rest\Post("/category")
     * @Rest\View()
     */
    public function postCategoryAction(Request $r){
        $cat = new Category();
        $cat->setNom($r->get("nom") );
        $cat->setDescription($r->get("desc"));
        $em = $this->getDoctrine()->getManager();
        $em->persist($cat);
        $em->flush();
        $view = View::create($cat);
        $view->setFormat('json');
        return $view;
    }

    /**
     *
     * @Rest\View()
     */
    public function removeCategorieAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $cat = $em->getRepository('BoutiqueProduitsBundle:Category')->find($id);
        if ( $cat ) {
            $em->remove($cat);
            $em->flush();
            $view = View::create($cat);
            $view->setFormat('json');
            return $view;
        }

    }
    /**
     * @Rest\Put("/category/{id}")
     * @Rest\View()
     */
    public function updateCategorieAction(Request $r,$id)
    {
        $em = $this->getDoctrine()->getManager();
        $cat = $em->getRepository('BoutiqueProduitsBundle:Category')
            ->find($id);
        if ( $cat ) {
            if ( $r->get("nom") )
                $cat->setNom($r->get("nom") );
            if ( $r->get("desc") )
                $cat->setDescription($r->get("desc"));

            $em->merge($cat);
            $em->flush();
            $view = View::create($cat);
            $view->setFormat('json');
            return $view;
        }

    }
    /**
     * @Rest\Put("/category_chg")
     * @Rest\View()
     */
    public function updateCategorieByNameAction(Request $r)
    {
        $em = $this->getDoctrine()->getManager();
        $cats = $em->getRepository('BoutiqueProduitsBundle:Category')
            ->findBy(['nom' => $r->get('old')]);
        $changed = 0 ;
        if ( $cats ) {
           foreach( $cats as $cat ){
               $cat->setNom( $r->get('new') );
               $em->merge($cat);
           }
           $em->flush();
        }
        $view = View::create($cats);
        $view->setFormat('json');
        return $view;
    }
}
