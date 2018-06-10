<?php
namespace Alala\MoviedbBundle\Controller;

use Alala\MoviedbBundle\Entity\Movie;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

class MovieController extends Controller
{
    
    public function listAction(){
        return $this->render('@AlalaMoviedb/Movie/list.html.twig');
    }
    
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
        $callback = function ($dateTime) {
            return $dateTime instanceof \DateTime
                ? $dateTime->format('d/m/Y')
                : '';
        };
        $normalizer->setCallbacks(array('year' => $callback));
        $serializer = new Serializer([$normalizer], [$encoder]);
        $moviesJson = $serializer->normalize($movies, 'json');
        

        return $this->json(['total' => $total,'movies' => $moviesJson]);
    }
}
