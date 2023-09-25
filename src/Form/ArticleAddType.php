<?php

namespace App\Form;

use App\Entity\Post;
use App\Entity\PostType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
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
            ->add('submit', SubmitType::class,[
                'label' => 'Publier'
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Post::class,
        ]);
    }
}
