<?php

namespace App\Form;

use App\Entity\Post;
use App\Entity\Visual;
use App\Entity\PostType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\OptionsResolver\OptionsResolver;
use App\Form\DataTransformer\VisualToStringTransformer;
use Symfony\Component\Validator\Constraints\Collection;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class ArticleAddType extends AbstractType
{
    
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        
        $builder
            ->add('fkposttype', EntityType::class, [
                'label' => "Type d'article",
                'class' => PostType::class,
                'choice_label' => function (PostType $postType) {
                    return $postType->getName(); 
                },
            ])
            ->add('title', TextType::class, [
                'label' => "Titre de l'article",
            ])
            ->add('subtitle', TextType::class, [
                'label' => "Sous-titre",
                'required' => false
            ])
            ->add('content', TextareaType::class, [
                'label' => "Contenu de l'article",
            ])
            ->add('visuals', FileType::class, [
                'label' => "Images/Vidéos",
                'required' => false,
                'multiple' => true,
                'mapped' => false,
                /* 'constraints' => [
                    'Assert\File'([
                            'extensions' => [
                                'application/pdf',
                                'image/png',
                                'image/jpeg',
                                'video/x-msvideo',
                            ],
                        'extensionsMessage' => 'Merci de choisir des documents avec les extensions : pdf, png, jpg ou avi',
                        'uploadErrorMessage' => 'Une erreur s\'est produite lors du téléchargement du fichier.',
                    ])
                ], */
            ])

            // ->add('visuals', FileType::class, [
            //     'label' => "Images/Vidéos",
            //     'required' => false,
            //     'multiple' => true,
            //     'mapped' => false
            //     ])

            ->add('Publier', SubmitType::class);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Post::class,
        ]);
    }
}
