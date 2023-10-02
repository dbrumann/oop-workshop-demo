<?php

namespace App\Form;

use App\Product\ProductDto;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CurrencyType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProductType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [])
            ->add('description', TextareaType::class, [])
            ->add('amount', MoneyType::class, ['divisor' => 100, 'currency' => false])
            ->add('currency', CurrencyType::class, ['choice_loader' => null, 'choices' => ['€' => 'EUR', '$' => 'USD']]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => ProductDto::class,
        ]);
    }
}