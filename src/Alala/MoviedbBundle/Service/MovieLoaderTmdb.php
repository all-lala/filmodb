<?php
namespace Alala\MoviedbBundle\Service;

use Alala\TmdbBundle\Service\LocalMovieInterface;
use Doctrine\ORM\EntityManager;
use Alala\MoviedbBundle\Entity\Movie;
use Doctrine\ORM\Internal\HydrationCompleteHandler;

class MovieLoaderTmdb implements LocalMovieInterface
{
    private $em;
    private $movieRepository;
    
    /**
     * 
     * @param EntityManager $em
     */
    public function __construct(EntityManager $em){
        $this->em = $em;
        $this->movieRepository = $this->em->getRepository(Movie::class);
    }
    
    /**
     * Sauvegarde les films passés en argument depuis une liste tmdb
     * 
     * @param Array $movies
     * 
     * {@inheritDoc}
     * @see \Alala\TmdbBundle\Service\LocalMovieInterface::saveMovies()
     */
    public function saveMovies($movies){
        
        foreach($movies as $movie){
            $mo = null;
            if(isset($movie['id'])){
                $mo = $this->movieRepository->findOneByTmdbId($movie['id']);
            }
            
            if(!isset($mo)){
                $mo = new Movie();
            }
            
            if(isset($movie['id'])){
                $mo->setTmdbId($movie['id']);
            }
            if(isset($movie['title'])){
                $mo->setTitle($movie['title']);
            }
            if(isset($movie['overview'])){
                $mo->setDescription($movie['overview']);
            }
            if(isset($movie['release_date'])){
                $release = new \DateTime($movie['release_date']);
                $mo->setYear($release);
            }
            
            $this->em->persist($mo);
        }
        
        $this->em->flush();
    }
}

