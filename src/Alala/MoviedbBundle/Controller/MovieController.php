<?php
namespace Alala\MoviedbBundle\Controller;

use Alala\MoviedbBundle\Entity\Movie;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use Alala\MoviedbBundle\Form\MovieType;

class MovieController extends Controller
{
    /**
     * Vue de la liste des films
     * 
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function listAction(){
        return $this->render('@AlalaMoviedb/Movie/list.html.twig');
    }
    
    
    /**
     * Retourne un Json de la liste des films par page et par filtre
     * 
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function searchAction(Request $request){
        $params = $request->query->all();

        if(!empty($params)){
            $filters = $request->query->get('filter');
            $page = $request->query->get('page');
            $bypage = $request->query->get('pageby');
        }

        $em = $this->getDoctrine()->getManager('default');
        $movieRepository = $em->getRepository(Movie::class);
        
        $movies = $movieRepository->search($filters, $page, $bypage);
        $total = $movieRepository->total($filters, $page, $bypage);

        $encoder = new JsonEncoder();
        $normalizer = new ObjectNormalizer();
        
        // Traiement des dates
        $callback = function ($dateTime) {
            return $dateTime instanceof \DateTime
                ? $dateTime->format('d/m/Y')
                : '';
        };
        $normalizer->setCallbacks(array('year' => $callback));
        
        // Traitement des références circulaires
        $normalizer->setCircularReferenceHandler(function ($object) {
            return $object->getId();
        });
        $serializer = new Serializer([$normalizer], [$encoder]);
        $moviesJson = $serializer->normalize($movies, 'json');
        

        return $this->json(['total' => $total,'movies' => $moviesJson]);
    }

    /**
     * Affiche la fiche d'un film
     * 
     * @param Request $request
     * @param integer $id
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function showAction(Request $request, $id){
        if(empty($id)){
            return $this->redirectToRoute('alala_movie_bundle.movie.list');
        }

        $em = $this->getDoctrine()->getManager('default');
        $movieRepository = $em->getRepository(Movie::class);

        $movie = $movieRepository->findOneById($id);

        if(empty($movie)){
            return $this->redirectToRoute('alala_movie_bundle.movie.list');
        }

        $form = $this->createForm(MovieType::class, $movie);
        
        $form->handleRequest($request);
        
        if($form->isSubmitted() && $form->isValid()){
            $em->persist($movie);
            $em->flush();
        }
        
        return $this->render('@AlalaMoviedb/Movie/show.html.twig',[
            'form' => $form->createView()
        ]);
    }
}
