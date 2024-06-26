<?php

namespace App\Form;

use App\Entity\Products;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProductType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name' ,TextType::class, [
                'attr' => ['class' => 'form-control' , 'placeholder' => 'Name', 'required' => true]
            ])
            ->add('description' ,TextType::class, [
                'attr' => ['class' => 'form-control' , 'placeholder' => 'Description', 'required' => true]
            ])
            ->add('price' , NumberType::class, [
                'attr' => ['class' => 'form-control' , 'placeholder' => 'Price', 'required' => true]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Products::class,
        ]);
    }
}
