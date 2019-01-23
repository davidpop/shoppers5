<?php

namespace Boutique\ProduitsBundle\Entity;

use Boutique\UserBundle\Entity\User;
use Doctrine\DBAL\Types\BooleanType;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\Tests\StringableObject;

/**
 * Commande
 *
 * @ORM\Table(name="commande")
 * @ORM\Entity(repositoryClass="Boutique\ProduitsBundle\Repository\CommandeRepository")
 */
class Commande
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
     * @var User
     *
     * @ORM\ManyToOne(targetEntity="Boutique\UserBundle\Entity\User")
     */
    private $user ;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created_at", type="datetime")
     */
    private $createdAt;

    /**
     * @var bool
     * @ORM\Column(name="payment_status", type="boolean")
     */
    private $paymentStatus ;

    /**
     * @var float
     *
     * @ORM\Column(name="montant", type="float")
     */
    private $montant ;

    /**
     * @var String
     * @ORM\Column(name="charge_id", type="string",  nullable=true)
     */
    private $chargeId ;


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
     * Set createdAt
     *
     * @param \DateTime $createdAt
     *
     * @return Commande
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Get createdAt
     *
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    public function __construct()
    {

        $this->createdAt = new \DateTime();
        $this->paymentStatus = false ;

    }


    /**
     * Set user
     *
     * @param \Boutique\UserBundle\Entity\User $user
     *
     * @return Commande
     */
    public function setUser(\Boutique\UserBundle\Entity\User $user = null)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \Boutique\UserBundle\Entity\User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Set paymentStatus
     *
     * @param boolean $paymentStatus
     *
     * @return Commande
     */
    public function setPaymentStatus($paymentStatus)
    {
        $this->paymentStatus = $paymentStatus;

        return $this;
    }

    /**
     * Get paymentStatus
     *
     * @return boolean
     */
    public function getPaymentStatus()
    {
        return $this->paymentStatus;
    }

    /**
     * Set chargeId
     *
     * @param integer $chargeId
     *
     * @return Commande
     */
    public function setChargeId($chargeId)
    {
        $this->chargeId = $chargeId;

        return $this;
    }

    /**
     * Get chargeId
     *
     * @return integer
     */
    public function getChargeId()
    {
        return $this->chargeId;
    }

    /**
     * Set montant
     *
     * @param float $montant
     *
     * @return Commande
     */
    public function setMontant($montant)
    {
        $this->montant = $montant;

        return $this;
    }

    /**
     * Get montant
     *
     * @return float
     */
    public function getMontant()
    {
        return $this->montant;
    }
}
