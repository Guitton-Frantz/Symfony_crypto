<?php

namespace App\Form;

use App\Entity\Cryptomonnaie;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class CryptoSearchType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('MarketCap', IntegerType::class, [
                'constraints' => [new Length(['max' => 11])],
                'required' => false,
            ])
            ->add('projet',  TextType::class, [
                'constraints' => [new Length(['max' => 255])],
                'required' => false,
            ])
            ->add('categorie',  TextType::class, [
                'constraints' => [new Length(['max' => 255])],
                'required' => false,
            ])
            ->add('price',  IntegerType::class, [
                'constraints' => [new Length(['max' => 11])],
                'required' => false,
            ])
            ->add('dateCreation', DateType::class)
            ->add('name',  TextType::class, [
                'constraints' => [new Length(['max' => 255])],
                'required' => false,
            ])
            ->add('slug',  TextType::class, [
                'constraints' => [new Length(['max' => 5])],
                'required' => false,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Cryptomonnaie::class,

        ]);
    }
}
