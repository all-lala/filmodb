<?php

namespace Alala\MoviedbBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Movie
 *
 * @ORM\Table(name="movie")
 * @ORM\Entity(repositoryClass="Alala\MoviedbBundle\Repository\MovieRepository")
 */
class Movie
{
    /**
     * @var int
     *
     * @ORM\Column(name="mo_id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="mo_tmdb_id", type="string", length=255, unique=true)
     */
    private $tmdbId;
    
    /**
     * @var string
     *
     * @ORM\Column(name="mo_title", type="string", length=255)
     */
    private $title;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="mo_year", type="datetime", nullable=true)
     */
    private $year;

    /**
     * @var string
     *
     * @ORM\Column(name="mo_description", type="text", nullable=true)
     */
    private $description;

    /**
     * @var \Doctrine\Common\Collections\ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="MoviePeople", mappedBy="movie")
     */
    private $moviePeoples;
    
    public function __construct() {
        $this->moviePeoples = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set tmdbId
     *
     * @param string $tmdbId
     *
     * @return Movie
     */
    public function setTmdbId($tmdbId)
    {
        $this->tmdbId = $tmdbId;
        
        return $this;
    }
    
    /**
     * Get tmdbId
     *
     * @return string
     */
    public function getTmdbId()
    {
        return $this->tmdbId;
    }
    
    /**
     * Set title
     *
     * @param string $title
     *
     * @return Movie
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set year
     *
     * @param \DateTime $year
     *
     * @return Movie
     */
    public function setYear($year)
    {
        $this->year = $year;

        return $this;
    }

    /**
     * Get year
     *
     * @return \DateTime
     */
    public function getYear()
    {
        return $this->year;
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return Movie
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

