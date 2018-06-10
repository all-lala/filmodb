<?php

namespace Alala\MoviedbBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * MoviePeople
 *
 * @ORM\Table(name="movie_people")
 * @ORM\Entity(repositoryClass="Alala\MoviedbBundle\Repository\MoviePeopleRepository")
 */
class MoviePeople
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
     * @var Movie
     * 
     * @ORM\ManyToOne(targetEntity="Movie", inversedBy="moviePeoples")
     * @ORM\JoinColumn(name="mp_mo_id", referencedColumnName="mo_id")
     */
    private $movie;
    
    /**
     * @var Movie
     *
     * @ORM\ManyToOne(targetEntity="People", inversedBy="moviesPeople")
     * @ORM\JoinColumn(name="mp_pp_id", referencedColumnName="pp_id")
     */
    private $people;
    
    /**
     * @var Movie
     *
     * @ORM\ManyToOne(targetEntity="Job", inversedBy="moviesPeoples")
     * @ORM\JoinColumn(name="mp_jb_id", referencedColumnName="jb_id")
     */
    private $job;

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
     * @return \Alala\MoviedbBundle\Entity\Movie
     */
    public function getMovie()
    {
        return $this->movie;
    }

    /**
     * @return \Alala\MoviedbBundle\Entity\Movie
     */
    public function getPeople()
    {
        return $this->people;
    }

    /**
     * @return \Alala\MoviedbBundle\Entity\Movie
     */
    public function getJob()
    {
        return $this->job;
    }

    /**
     * @param \Alala\MoviedbBundle\Entity\Movie $movie
     */
    public function setMovie($movie)
    {
        $this->movie = $movie;
    }

    /**
     * @param \Alala\MoviedbBundle\Entity\Movie $people
     */
    public function setPeople($people)
    {
        $this->people = $people;
    }

    /**
     * @param \Alala\MoviedbBundle\Entity\Movie $job
     */
    public function setJob($job)
    {
        $this->job = $job;
    }

}

