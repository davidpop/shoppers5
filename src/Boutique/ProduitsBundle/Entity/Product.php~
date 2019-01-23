<?php

namespace Boutique\ProduitsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Product
 *
 * @ORM\Table(name="product")
 * @ORM\Entity(repositoryClass="Boutique\ProduitsBundle\Repository\ProductRepository")
 */
class Product
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
     * @var string
     *
     * @ORM\Column(name="nom", type="string", length=255)
     * @Assert\NotNull
     * @Assert\Length(
     *      min = 3,
     *      max = 255,
     *      minMessage = "Your first name must be at least {{ limit }} characters long",
     *      maxMessage = "Your first name cannot be longer than {{ limit }} characters"
     * )
     */
    private $nom;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text")
     */
    private $description;

    /**
     * @var float
     *
     * @ORM\Column(name="prix", type="float")
     */
    private $prix;

    /**
     * @var int
     *
     * @ORM\Column(name="quantite", type="integer")
     * @Assert\Type(
     *     type="integer",
     *     message="Vous devez saisir une valeur entiere !"
     * )
     * @Assert\GreaterThanOrEqual(0)
     *
     */
    private $quantite;

    /**
     * @var PhotoPrincipale
     *
     * @ORM\OneToOne(targetEntity="Boutique\ProduitsBundle\Entity\PhotoPrincipale", cascade={"persist","remove"})
     */
    private $photoPrincipale ;

    /**
     *
     * @ORM\ManyToMany(targetEntity="Boutique\ProduitsBundle\Entity\Category")
     */
    private $categorys ;

    /**
     * @ORM\OneToMany(targetEntity="Image", mappedBy="product", cascade={"persist","remove"})
     */
    private $images;

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
     * Set nom
     *
     * @param string $nom
     *
     * @return Product
     */
    public function setNom($nom)
    {
        $this->nom = $nom;

        return $this;
    }

    /**
     * Get nom
     *
     * @return string
     */
    public function getNom()
    {
        return $this->nom;
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return Product
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set prix
     *
     * @param float $prix
     *
     * @return Product
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
     * Set quantite
     *
     * @param integer $quantite
     *
     * @return Product
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
     * Constructor
     */
    public function __construct()
    {
        //$this->images = new \Doctrine\Common\Collections\ArrayCollection();
        $this->categories = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set photoPrincipale
     *
     * @param \Boutique\ProduitsBundle\Entity\PhotoPrincipale $photoPrincipale
     *
     * @return Product
     */
    public function setPhotoPrincipale(\Boutique\ProduitsBundle\Entity\PhotoPrincipale $photoPrincipale = null)
    {
        $this->photoPrincipale = $photoPrincipale;

        return $this;
    }

    /**
     * Get photoPrincipale
     *
     * @return \Boutique\ProduitsBundle\Entity\PhotoPrincipale
     */
    public function getPhotoPrincipale()
    {
        return $this->photoPrincipale;
    }

    /**
     * Add category
     *
     * @param \Boutique\ProduitsBundle\Entity\Category $category
     *
     * @return Product
     */
    public function addCategory(\Boutique\ProduitsBundle\Entity\Category $category)
    {
        $this->categorys[] = $category;

        return $this;
    }

    /**
     * Remove category
     *
     * @param \Boutique\ProduitsBundle\Entity\Category $category
     */
    public function removeCategory(\Boutique\ProduitsBundle\Entity\Category $category)
    {
        $this->categorys->removeElement($category);
    }

    /**
     * Get categorys
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getCategorys()
    {
        return $this->categorys;
    }
    /**
     * Add image
     *
     * @param \Boutique\ProduitsBundle\Entity\Image $image
     *
     * @return Product
     */
    public function addImage(Image $image)
    {
        $this->images[] = $image;
        return $this;
    }
    /**
     * Remove image
     *
     * @param \Boutique\ProduitsBundle\Entity\Image $image
     */
    public function removeImage(Image $image)
    {
        $this->images->removeElement($image);
    }
    /**
     * Get images
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getImages()
    {
        return $this->images;
    }

    public function __toString() {
        return $this->nom;
    }

}
