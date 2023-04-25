<?php

namespace App\Controller;

use App\Entity\Post;
use App\Form\PostType;
use App\Repository\CategoryRepository;
use App\Repository\PostRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PostController extends AbstractController
{
    #[Route('/post/view/{slug}', name: 'app_post_view')]
    public function getPost(string $slug, PostRepository $repo, CategoryRepository $catRepo): Response
    {
        $post = $repo->findOneBySlug($slug);
        $category = $catRepo->findOneById($post->getCategory());

        return $this->render(
            'post/view.html.twig',
            [
                'category' => $category,
                'post' => $post
            ]
        );
    }

    #[Route('/post/new', name: 'app_post_new')]
    public function addPost(Request $request, EntityManagerInterface $entityManager): Response
    {
        $post = new Post();
        $form = $this->createForm(PostType::class, $post);

        $form-> handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()){
            $entityManager->persist($post);
            $entityManager->flush();
        }


        return $this->render(
            'post/new.html.twig',
            [
                'form' => $form->createView(),
                'post' => $post
            ]
        );
    }

    #[Route('/post/edit/{slug}', name: 'app_post_edit')]
    public function editPost(string $slug): Response
    {
        return $this->render('post/edit.html.twig');
    }


    #[Route('/post/delete/{slug}', name: 'app_post_delete')]
    public function deletePost(): Response
    {
        return $this->render('post/delete.html.twig');
    }
}
