<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use App\Entity\Property;
use App\Form\FilterPropertyType;
use App\Entity\FilterProperty;
use App\Repository\PropertyRepository;
use App\Entity\Contact;
use App\Form\ContactType;
// use App\Repository\ContactRepository;
use App\Notification\ContactNotification;


use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;

class PropertyController extends AbstractController{
    
    private $repository;
    private $em;

    public function __construct(PropertyRepository $repository, EntityManagerInterface $em){
        $this->repository = $repository;
        $this->em = $em;
    }

    /**
     * @Route("/Estate",name="property.index")
     * @return Response
     */
    public function index(Request $request,PaginatorInterface $paginator):Response
    {
        //Gérer les traitements (index Filter)
        $filter = new FilterProperty();
        $form = $this->createForm(FilterPropertyType::class, $filter);

        $form->handleRequest($request);
        
        //Gérer les traitements (index default)
        $filters_properties = $paginator->paginate(
            $this->repository->findAllVisibleQuery($filter),
            $request->query->getInt('page',1),
            12
        );

        return $this->render('/property/index.html.twig',[
            'current_menu' => 'properties',
            'properties' => $filters_properties,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/estate/{slug}-{id}",name="property.show", requirements={"slug": "[a-z0-9\-]*"})
     * @return Response
     */
    public function show(Property $property,String $slug,Request $request,ContactNotification $notification):Response
    {   
        //1: Get id with find Symfony entity method. | show($slug,$id) | $property = $this->repository->find($id);
        //2: Get id without find Symfony entity method. Include in Route parameter after -> | show(Property $property):Response |
        // return $this->render('/property/show.html.twig',
        // [
        //     'property'=> $property,
        //     'current_menu'=>'property'
        // ]);
        //3: (2) + slug verification/

        //Gérer URL pour la route
        if($property->getSlug() !== $slug){

            return $this->redirectToRoute(
                'property.show',
                [
                    'id'=>$property->getId(), 
                    'slug'=>$property->getSlug()
                ],
                301
            );
        }

        //--- Gérer le formulaire de contact ---//
        $contact = new Contact();
        
        $contact->setProperty($property);

        $form = $this->createForm(ContactType::class, $contact);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){

            $contact = $form->getData();
            // dd($contact);

            $notification->notify($contact);

            $this->addFlash('success', 'Votre message a bien été envoyé');

            return $this->redirectToRoute(
                'property.show',
                [
                    'id'=>$property->getId(), 
                    'slug'=> $property->getSlug(),
                ]
            );
        }
        
        /**
         * Resultat d'une demande de propriété.
         */
        return $this->render('/property/show.html.twig',
        [
            'property'=> $property,
            'current_menu'=>'property',
            'form' => $form->createView(),
        ]);
    }
}
?>