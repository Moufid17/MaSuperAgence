<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use App\Entity\Property;
use App\Repository\PropertyRepository;

use Doctrine\ORM\EntityManagerInterface;

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
    public function index():Response
    {
        return $this->render('/property/index.html.twig',[
            'current_menu' => 'properties'
        ]);
    }

    /**
     * @Route("/Property/{slug}-{id}",name="property.show", requirements={"slug": "[a-z0-9\-]*"})
     * @return Response
     */
    public function show(Property $property,String $slug):Response
    {   
        //1: Get id with find Symfony entity method. | show($slug,$id) | $property = $this->repository->find($id);
        //2: Get id without find Symfony entity method. Include in Route parameter after -> | show(Property $property):Response |
        // return $this->render('/property/show.html.twig',
        // [
        //     'property'=> $property,
        //     'current_menu'=>'property'
        // ]);
        //3: (2) + slug verification/
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
        return $this->render('/property/show.html.twig',
        [
            'property'=> $property,
            'current_menu'=>'property'
        ]);
    }
}
?>