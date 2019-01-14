<?php

namespace Boutique\ProduitsBundle\Controller;

use Boutique\ProduitsBundle\Entity\Category;
use Boutique\ProduitsBundle\Entity\Product;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="boutique.accueil")
     */
    public function indexAction()
    {
        $lesProduits = $this->getDoctrine()->getRepository(Product::class)->findAll();
        $lesCategories = $this->getDoctrine()->getRepository(Category::class)->findAll();
        /*
                $lesCatCounts = array();
                foreach( $lesCategories as $laCat){

                }*/

        return $this->render(
            'product/boutique.html.twig',
            ['lesProduits' => $lesProduits, 'lesCategories' => $lesCategories ]);
    }
}
