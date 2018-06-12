<?php
namespace Alala\MoviedbBundle\Controller;

use Alala\MoviedbBundle\Entity\People;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use Alala\MoviedbBundle\Form\PeopleType;

class PeopleController extends Controller
{
    /**
     * Vue de la liste des personnes
     * 
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function listAction(){
        return $this->render('@AlalaMoviedb/People/list.html.twig');
    }
    
    
    /**
     * Retourne un Json de la liste des personnes par page et par filtre
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
        $peopleRepository = $em->getRepository(People::class);
        
        $peoples = $peopleRepository->search($filters, $page, $bypage);
        $total = $peopleRepository->total($filters, $page, $bypage);

        $encoder = new JsonEncoder();
        $normalizer = new ObjectNormalizer();
        
        // Traiement des dates
        $callback = function ($dateTime) {
            return $dateTime instanceof \DateTime
                ? $dateTime->format('d/m/Y')
                : '';
        };
        $normalizer->setCallbacks(array('birthdate' => $callback));
        
        // Traitement des références circulaires
        $normalizer->setCircularReferenceHandler(function ($object) {
            return $object->getId();
        });
        $serializer = new Serializer([$normalizer], [$encoder]);
        $peoplesJson = $serializer->normalize($peoples, 'json');
        

        return $this->json(['total' => $total,'peoples' => $peoplesJson]);
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
            return $this->redirectToRoute('alala_movie_bundle.people.list');
        }

        $em = $this->getDoctrine()->getManager('default');
        $peopleRepository = $em->getRepository(People::class);

        $people = $peopleRepository->findOneById($id);

        if(empty($people)){
            return $this->redirectToRoute('alala_movie_bundle.people.list');
        }

        $form = $this->createForm(PeopleType::class, $people);
        
        $form->handleRequest($request);
        
        if($form->isSubmitted() && $form->isValid()){
            $em->persist($people);
            $em->flush();
        }
        
        return $this->render('@AlalaMoviedb/People/show.html.twig',[
            'form' => $form->createView()
        ]);
    }
}
