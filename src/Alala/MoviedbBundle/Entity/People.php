<?php

namespace Alala\MoviedbBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * People
 *
 * @ORM\Table(name="people")
 * @ORM\Entity(repositoryClass="Alala\MoviedbBundle\Repository\PeopleRepository")
 */
class People
{
    /**
     * @var int
     *
     * @ORM\Column(name="pp_id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="pp_firstname", type="string", length=255)
     */
    private $firstname;

    /**
     * @var string
     *
     * @ORM\Column(name="pp_lastname", type="string", length=255)
     */
    private $lastname;

    /**
     * @var string
     *
     * @ORM\Column(name="pp_birthdate", type="datetime", nullable=true)
     */
    private $birthdate;

    /**
     * @var string
     *
     * @ORM\Column(name="pp_description", type="text", nullable=true)
     */
    private $description;

    /**
     * @var \Doctrine\Common\Collections\ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="MoviePeople", mappedBy="people")
     */
    private $moviesPeople;
    
    public function __construct() {
        $this->moviesPeople = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set firstname
     *
     * @param string $firstname
     *
     * @return People
     */
    public function setFirstname($firstname)
    {
        $this->firstname = $firstname;

        return $this;
    }

    /**
     * Get firstname
     *
     * @return string
     */
    public function getFirstname()
    {
        return $this->firstname;
    }

    /**
     * Set lastname
     *
     * @param string $lastname
     *
     * @return People
     */
    public function setLastname($lastname)
    {
        $this->lastname = $lastname;

        return $this;
    }

    /**
     * Get lastname
     *
     * @return string
     */
    public function getLastname()
    {
        return $this->lastname;
    }

    /**
     * Set birthdate
     *
     * @param \DateTime $birthdate
     *
     * @return People
     */
    public function setBirthdate($birthdate)
    {
        $this->birthdate = $birthdate;

        return $this;
    }

    /**
     * Get birthdate
     *
     * @return \DateTime
     */
    public function getBirthdate()
    {
        return $this->birthdate;
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return People
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
     * Get description
     *
     * @return string
     */
    public function getFullName()
    {
        return $this->firstname . ' ' . $this->lastname;
    }
}

