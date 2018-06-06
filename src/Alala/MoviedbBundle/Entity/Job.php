<?php

namespace Alala\MoviedbBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Job
 *
 * @ORM\Table(name="job")
 * @ORM\Entity(repositoryClass="Alala\MoviedbBundle\Repository\JobRepository")
 */
class Job
{
    /**
     * @var int
     *
     * @ORM\Column(name="jb_id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="jb_libelle", type="string", length=255, unique=true)
     */
    private $libelle;

    /**
     * @var string
     *
     * @ORM\Column(name="jb_description", type="string", length=255, nullable=true)
     */
    private $description;

    /**
     * @var \Doctrine\Common\Collections\ArrayCollection
     * 
     * @ORM\OneToMany(targetEntity="MoviePeople", mappedBy="job")
     */
    private $moviesPeoples;

    public function __construct() {
        $this->moviesPeoples = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
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
     * Set libelle
     *
     * @param string $libelle
     *
     * @return Job
     */
    public function setLibelle($libelle)
    {
        $this->libelle = $libelle;

        return $this;
    }

    /**
     * Get libelle
     *
     * @return string
     */
    public function getLibelle()
    {
        return $this->libelle;
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return Job
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
}

