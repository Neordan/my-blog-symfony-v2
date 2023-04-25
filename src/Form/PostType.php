<?php

namespace App\Form;

use App\Entity\Post;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PostType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('slug', TextType::class, ["attr" => ["class" => "input-post", "placeholder" => "Slug unique pour l'article"]])

        ->add('title', TextType::class, ["attr" => ["class" => "input-post", "placeholder" => "Titre de l'article"]])

        ->add('content', TextareaType::class, ["attr" => ["class" => "input-post", "placeholder" => "Votre article"]])

        //->add('created_at', TextareaType::class)
        ->add('category')
    ;

    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Post::class,
        ]);
    }
}
