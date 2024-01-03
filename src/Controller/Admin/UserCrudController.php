<?php

namespace App\Controller\Admin;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Config\Assets;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\ArrayField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserCrudController extends AbstractCrudController
{
    private $UserPasswordHasherInterface;

    public static function getEntityFqcn(): string
    {
        return User::class;
    }

    public function __construct(UserPasswordHasherInterface $UserPasswordHasherInterface)
    {
        $this->UserPasswordHasherInterface = $UserPasswordHasherInterface;
    }



    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            TextField::new('firstname'),
            TextField::new('lastname'),
            ArrayField::new('roles')->formatValue(
                function ($value, $entity) {
                    foreach ($value as $role) {
                        if ('ROLE_ADMIN' == $role) {
                            return '<span class="material-symbols-outlined">manage_accounts</span>';
                        }
                        if ('ROLE_USER' == $role) {
                            return '<span class="material-symbols-outlined">person</span>';
                        }
                    }

                    return '';
                }
            ),
            TextField::new('email'),
            TextField::new('password', 'mot de passe')->setFormTypeOptions(
                [
                    'required' => false,
                    'empty_data' => '',
                    'attr' => ['autocomplete' => 'new-password'],
                ]
            )->setFormType(PasswordType::class),
        ];
    }

    public function setUserPassword(mixed $Password, $entityInstance, EntityManagerInterface $entityManager): void
    {
        if (!empty($Password)) {
            $encodedPassword = $this->UserPasswordHasherInterface->hashPassword($entityInstance, $Password);
            $entityInstance->setPassword($encodedPassword);
            $entityManager->flush();
        }
    }
}
