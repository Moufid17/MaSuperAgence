<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use App\Entity\Property;
use App\Repository\PropertyRepository;


class PropertyController extends AbstractController{
    /** 
     * @var PropertyRepository
    */
    private $repository;

    public function __construct(PropertyRepository $repository){
        $this->repository = $repository;
    }
    /**
     * @Route("/Estate",name="property.index")
     * @return Response
     */
    public function index():Response
    {
        //***INSERT MANUALLY DATAS IN DB
            // $property = new Property();

            // $property->setTitle('First Estate')
            //     ->setPrice(200000)
            //     ->setRooms(4)
            //     ->setDescription('Desc Fisrt Estate')
            //     ->setSurface(60)
            //     ->setBedrooms(3)
            //     ->setFloor(4)
            //     ->setHeat(1)
            //     ->setCity('Montpelliers')
            //     ->setAdress('15 Rue de Gambetta')
            //     ->setPostalCode('34000')
            // ;

            // //en: entity manager
            // $en = $this->getDoctrine()->getManager();
            // $en->persist($property);
            // $en->flush();
        //***INSERT MANUALLY DATAS IN DB

        //1***GET MANUALLY DATAS FROM DB
            //$repository = $this->getDoctrine()->getRepository(Property::class);
            //dump($repository); //Like var_dump

        //1***GET MANUALLY DATAS FROM DB
        //2***GET MANUALLY DATAS FROM DB: 
            /** Create App\Controller\PropertyController constructor
             *  Use Dependencie Injection with PropertyRepository.
             */
        $property = $this->repository->findOneBy(['floor'=> 4]);

        dump($property);
        return $this->render('/property/index.html.twig',[
            'current_menu' => 'properties'
        ]);
    }
}
?>