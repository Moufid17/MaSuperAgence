<?php 

namespace App\Controller\Admin;

use App\Form\PropertyType;
use App\Entity\Property;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\PropertyRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;

class AdminPropertyController extends AbstractController{
    
    /**
     * @var PropertyRepository
     */
    private  $repository;
    private  $em;

    public function __construct(PropertyRepository $repository, EntityManagerInterface $em)
    {
        $this->repository = $repository;
        $this->em = $em;
    }

    /**
     * @Route("/admin/", name="admin.property.index")
     */
    public function index()
    {
        $properties = $this->repository->findAll();
        return $this->render('admin/property/index.html.twig',compact('properties'));
    }

    /**
     * @Route("/admin/property/create",name="admin.property.new")
     */
    public function new(Request $request){

        $property = new Property();
        $form = $this->createForm(PropertyType::class,$property);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->em->persist($property);
            $this->em->flush();
            $this->addFlash('success', 'Ajouter avec success!');
            return $this->redirectToRoute('admin.property.index');
        }

        return $this->render('/admin/property/new.html.twig', 
                                [
                                    'property'=>$property,
                                    'form'=>$form->createView()
                                ]
        );
    }

    /**
     * @Route("/admin/property-{id}", name="admin.property.edit", methods="POST|GET")
     * @param Property $property
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function edit(Property $property,Request $request)
    {
        $form = $this->createForm(PropertyType::class,$property);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->em->flush();
            $this->addFlash('success', 'Modifier avec success!');
            return $this->redirectToRoute('admin.property.index');
        }

        return $this->render('/admin/property/edit.html.twig', 
                                [
                                    'property'=>$property,
                                    'form'=>$form->createView()
                                ]
        );
    }
    /**
     * @Route("/admin/property/delete-{id}", name="admin.property.delete", methods="DELETE")
     * @param Property $property
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function delete(Property $property,Request $request){
        if($this->getTokenValide($property,$request)){
            $this->em->remove($property);
            $this->em->flush();
            $this->addFlash('success', 'Supprimer avec success!');
        }
        return $this->redirectToRoute('admin.property.index');
    }

    private function getTokenValide(Property $property,Request $request){
        return $this->isCsrfTokenValid('delete' . $property->getId(), $request->get('_token'));
    }
}