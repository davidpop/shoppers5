<?php

namespace Boutique\ProduitsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * PhotoPrincipale
 *
 * @ORM\Table(name="photo_principale")
 * @ORM\Entity(repositoryClass="Boutique\ProduitsBundle\Repository\PhotoPrincipaleRepository")
 */
class PhotoPrincipale
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
     * @ORM\Column(name="path", type="text")
     * @Assert\Url(
     *    message = "L url '{{ value }}' n'est pas valide ! ",
     *    protocols = {"http", "https", "ftp"}
     *    )
     */
    private $path;

    /**
     * @var string
     *
     * @ORM\Column(name="alt", type="text")
     */
    private $alt;


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
     * Set path
     *
     * @param string $path
     *
     * @return PhotoPrincipale
     */
    public function setPath($path)
    {
        $this->path = $path;

        return $this;
    }

    /**
     * Get path
     *
     * @return string
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * Set alt
     *
     * @param string $alt
     *
     * @return PhotoPrincipale
     */
    public function setAlt($alt)
    {
        $this->alt = $alt;

        return $this;
    }

    /**
     * Get alt
     *
     * @return string
     */
    public function getAlt()
    {
        return $this->alt;
    }
}
