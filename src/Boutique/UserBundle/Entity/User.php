<?php

namespace Boutique\UserBundle\Entity;

use FOS\UserBundle\Model\User as BaseUser ;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * User
 *
 * @ORM\Table(name="user")
 * @ORM\Entity(repositoryClass="Boutique\UserBundle\Repository\UserRepository")
 */
class User extends BaseUser
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     *
     * @Assert\Length(
     *      min = 2,
     *      max = 64,
     *      minMessage = "Your first name must be at least {{ limit }} characters long",
     *      maxMessage = "Your first name cannot be longer than {{ limit }} characters"
     * )
     * @var string
     *
     * @ORM\Column(name="nom", type="string", length=255)
     */
    protected $nom;

    /**
     *
     * @Assert\Length(
     *      min = 2,
     *      max = 64,
     *      minMessage  = "Votre saisie est incorrecte !",
     *      maxMessage  = "Votre saisie est incorrecte !"
     * )
     * @var string
     *
     * @ORM\Column(name="prenom", type="string", length=255)
     */
    protected $prenom;

    /**
     *
     * @Assert\Length(
     *      min = 3,
     *      minMessage = "Votre saisie est incorrecte !"
     * )
     * @var string
     *
     * @ORM\Column(name="adresse", type="text")
     */
    protected $adresse;

    /**
     *
     * @Assert\Length(
     *      min = 3,
     *      minMessage = "Votre saisie est incorrecte !"
     * )
     * @var string
     *
     * @ORM\Column(name="ville", type="string", length=255)
     */
    protected $ville;

    /**
     *
     * @Assert\Length(
     *      min = 4,
     *      max = 5,
     *      minMessage = "Le Code Postal est sur 5 chiffres",
     *      maxMessage = "Le Code Postal est sur 5 chiffres"
     * )
     * @var string
     *
     * @ORM\Column(name="codePostal", type="string", length=255)
     */
    protected $codePostal;

    /**
     * @ORM\Column(name="charge_id", type="string", length=255, nullable=true)
     */
    protected $chargeId;
    

    public function __construct()
    {
        parent::__construct();
        // your own logic
    }

    /**
     * Set nom
     *
     * @param string $nom
     *
     * @return User
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
     * Set prenom
     *
     * @param string $prenom
     *
     * @return User
     */
    public function setPrenom($prenom)
    {
        $this->prenom = $prenom;

        return $this;
    }

    /**
     * Get prenom
     *
     * @return string
     */
    public function getPrenom()
    {
        return $this->prenom;
    }

    /**
     * Set adresse
     *
     * @param string $adresse
     *
     * @return User
     */
    public function setAdresse($adresse)
    {
        $this->adresse = $adresse;

        return $this;
    }

    /**
     * Get adresse
     *
     * @return string
     */
    public function getAdresse()
    {
        return $this->adresse;
    }

    /**
     * Set ville
     *
     * @param string $ville
     *
     * @return User
     */
    public function setVille($ville)
    {
        $this->ville = $ville;

        return $this;
    }

    /**
     * Get ville
     *
     * @return string
     */
    public function getVille()
    {
        return $this->ville;
    }

    /**
     * Set codePostal
     *
     * @param string $codePostal
     *
     * @return User
     */
    public function setCodePostal($codePostal)
    {
        $this->codePostal = $codePostal;

        return $this;
    }

    /**
     * Get codePostal
     *
     * @return string
     */
    public function getCodePostal()
    {
        return $this->codePostal;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     *
     * @return User
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }
    

    /**
     * Set chargeId
     *
     * @param string $chargeId
     *
     * @return User
     */
    public function setChargeId($chargeId)
    {
        $this->chargeId = $chargeId;

        return $this;
    }

    /**
     * Get chargeId
     *
     * @return string
     */
    public function getChargeId()
    {
        return $this->chargeId;
    }
}
