<?php

namespace App\Form;

use App\Entity\FilterProperty;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use App\Entity\Option;


class FilterPropertyType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('roomsMin',IntegerType::class, 
                [
                    'required' => false,
                    'label' => false,
                    // 'help'  =>  'Ex: Au moins 2 chambre.',
                    'attr' => [
                        'placeholder' => 'Chambre Minimal'
                    ]
                ])
            ->add('priceMax',IntegerType::class, 
                [
                    'required' => false,
                    'label' => false,
                    // 'help'  =>  'Ex: Coûte au plus 500000 €.',
                    'attr' => [
                        'placeholder' => 'Prix Maximal'
                    ]
                ])
            ->add('surfaceMin',IntegerType::class, 
                [
                    'required' => false,
                    'label' => false,
                    // 'help'  =>  'Ex: Au plus 250 m² de surface.',
                    'attr' => [
                        'placeholder' => 'Surface Minimale'
                    ]
                ])
            ->add('options',EntityType::class,
                [
                    'class' => Option::class, 
                    'choice_label' => 'name', // Field Name from Option::class
                    // 'help'  =>  'Option(s)',
                    'label' => false,
                    'multiple' => true,
                    'required'=> false,
                ])
            // ->add('Rechercher', SubmitType::class)   
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => FilterProperty::class,
            'method' => 'GET',
            'csrf_protection' => false,
        ]);
    }
    /**
     * To make url link prefix clear
     * @return empty character
     */
    
    public function getBlockPrefix(){
        return '';
    }
}
