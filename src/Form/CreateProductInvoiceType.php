<?php

namespace App\Form;

use App\Entity\Product;
use App\Entity\ProductInvoice;
use App\Repository\ProductRepository;
use Doctrine\DBAL\Types\FloatType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;

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
                    '04' => '04',
                    '06' => '06',
                    '08' => '08',
                    '10' => '10',
                    '12' => '12',
                    '39/42' => '39/42',
                    '40/44' => '40/44',
                    '43/46' => '43/46',
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
            ->add('product', EntityType::class, [
                'required' => true,
                'class' => Product::class,
                'query_builder' => function (ProductRepository $pr) {
                    return $pr->createQueryBuilder('p')
                        ->orderBy('p.name', 'ASC');
                },
                'choice_label' => 'name',
                'label' => false
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => ProductInvoice::class,
        ]);
    }
}
