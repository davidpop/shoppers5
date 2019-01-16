<?php

namespace Boutique\ProduitsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ProductCommande
 *
 * @ORM\Table(name="product_commande")
 * @ORM\Entity(repositoryClass="Boutique\ProduitsBundle\Repository\ProductCommandeRepository")
 */
class ProductCommande
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var int
     *
     * @ORM\Column(name="quantite", type="integer")
     */
    private $quantite;

    /**
     *
     * @ORM\ManyToOne(targetEntity="Boutique\ProduitsBundle\Entity\Product")
     * @ORM\JoinColumn(nullable=false)
     */
    private $product;

    /**
     * @ORM\ManyToOne(targetEntity="Boutique\ProduitsBundle\Entity\Commande")
     * @ORM\JoinColumn(nullable=false)
     */
    private $commande;

    /**
     * @var float
     *
     * @ORM\Column(name="prix", type="float")
     */
    private $prix;


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set quantite
     *
     * @param integer $quantite
     *
     * @return ProductCommande
     */
    public function setQuantite($quantite)
    {
        $this->quantite = $quantite;

        return $this;
    }

    /**
     * Get quantite
     *
     * @return int
     */
    public function getQuantite()
    {
        return $this->quantite;
    }


    /**
     * Set prix
     *
     * @param float $prix
     *
     * @return ProductCommande
     */
    public function setPrix($prix)
    {
        $this->prix = $prix;

        return $this;
    }

    /**
     * Get prix
     *
     * @return float
     */
    public function getPrix()
    {
        return $this->prix;
    }

    /**
     * Set product
     *
     * @param \Boutique\ProduitsBundle\Entity\Product $product
     *
     * @return ProductCommande
     */
    public function setProduct(\Boutique\ProduitsBundle\Entity\Product $product)
    {
        $this->product = $product;

        return $this;
    }

    /**
     * Get product
     *
     * @return \Boutique\ProduitsBundle\Entity\Product
     */
    public function getProduct()
    {
        return $this->product;
    }

    /**
     * Set commande
     *
     * @param \Boutique\ProduitsBundle\Entity\Commande $commande
     *
     * @return ProductCommande
     */
    public function setCommande(\Boutique\ProduitsBundle\Entity\Commande $commande)
    {
        $this->commande = $commande;

        return $this;
    }

    /**
     * Get commande
     *
     * @return \Boutique\ProduitsBundle\Entity\Commande
     */
    public function getCommande()
    {
        return $this->commande;
    }
}
