<?php
namespace App\Forms;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType as TextValid;
use Symfony\Component\Validator\Constraints\Length;

class Car extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('name',TextValid::class,[
            'constraints' => [new Length(['min' => 3])],
        ])
        ->add('save',SubmitType::class,[
            'attr'  => [
                'class' =>'btn btn-primary'
            ]
        ]);
    }
}