<?php

namespace App\Form;

use App\Entity\Category;
use App\Entity\Contact;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ContactType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('firstname', TextType::class, ['empty_data' => 'John'])
            ->add('lastname', TextType::class, ['empty_data' => 'Doe'])
            ->add('email', TextType::class, ['empty_data' => 'JohnDoe@gmail.com'])
            ->add('phone', TelType::class, ['empty_data' => '0123456789'])
            ->add('category', EntityType::class, [
                'required' => false,
                    'class' => Category::class,
                    'choice_label' => 'name',
                    'query_builder' => function (EntityRepository $entityRepository) {
                        return $entityRepository->createQueryBuilder('c')
                            ->orderBy('c.name', 'ASC');
                    },
            ])
            ->add('delete', SubmitType::class, ['label' => 'supprimer'])
            ->add('cancel', SubmitType::class, ['label' => 'annuler']);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Contact::class,
        ]);
    }
}
