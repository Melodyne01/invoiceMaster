<?php

namespace App\Form;

use App\Entity\ProductInvoice;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Doctrine\DBAL\Types\FloatType;

class CreateProductInvoiceType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('quantity', NumberType::class)
            ->add('size', ChoiceType::class, [
                'label' => false,
                'choices'  => [
                    'XS' => 'XS',
                    'S' => 'S',
                    'M' => 'M',
                    'L' => 'L',
                    'XL' => 'XL',
                    'XXL' => 'XXL',
                    'XXXL' => 'XXXL',
                    '/' => '/',
                ],

            ])
            ->add('priceHT', NumberType::class)
            ->add('color', ChoiceType::class, [
                'label' => false,
                'choices'  => [
                    'Noir' => 'Noir',
                    'Blanc' => 'Blanc',
                    'Bleu roi' => 'Bleu roi',
                    'Bleu marine' => 'Bleu marine',
                    'Bleu carolina' => 'Bleu carolina',
                    'Bleu saphir' => 'Bleu saphir',
                    'Rose' => 'Rose',
                    'Rouge' => 'Rouge',
                    'Jaune' => 'Jaune',
                    'Gris' => 'Gris',
                    'Beige' => 'Beige',
                    'Brun' => 'Brun',
                    'Orange' => 'Orange',
                    'Vert' => 'Vert',
                ],
            ])
            ->add('product')
            ->add('invoice')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => ProductInvoice::class,
        ]);
    }
}
