<?php

namespace App\Controller;

use App\Entity\Category;
use App\Form\CategoryType;
use App\Repository\CategoryRepository;
use App\Repository\PostRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CategoryController extends AbstractController
{
    #[Route('/category/list', name: 'app_category_list')]
    // injection de dépendance "categoryRepository"
    public function index(CategoryRepository $repo): Response
    {
        // Récupérer depuis la base de données la liste de toutes les catégories
        // Transmettre la liste à la vue
        // Rendre la vue

        $categoriesList = $repo->findAll();

        //je peux faire un header("location: ./")

        //je rends une vue
        return $this->render(
            'category/list.html.twig', 
            [
            'categories' => $categoriesList
        ]);
    }

    #[Route('/category/view/{name}', name: 'app_category_view')]
    public function getCategory(string $name, CategoryRepository $catRepo, PostRepository $postRepo): Response {
        // Récupérer la catégorie dont le nom est passé dans l'url
        // Récupérer depuis la base de données la liste de tous les articles de cette catégorie
        // Transmettre la catégorie + la liste des articles à la vue
        // Rendre la vue

        $category = $catRepo-> findOneByName($name);
        $posts = $postRepo-> findByCategory($category-> getId());

        // header("Location: /category/list");
        return $this-> render(
            "category/view.html.twig",
            [
                'category' => $category,
                'posts' => $posts
            ]
        );
    }
    
    
    #[Route('/category/new', name: 'app_category_new')]
    public function addCategory(Request $request, EntityManagerInterface $entityManager): Response {

        $categorie = new Category();
        $form = $this->createForm(CategoryType::class, $categorie);

        $form-> handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()){

            $entityManager-> persist($categorie);
            $entityManager-> flush();
        }


        return $this-> render("category/new.html.twig",
        [
            'form' => $form->createView(),
            'categorie' => $categorie
        ]
    );
    }
    
    
    #[Route('/category/edit/{name}', name: 'app_category_edit')]
    public function editCategory(string $name): Response {
        return $this-> render("category/edit.html.twig");
    }
    
    #[Route('/category/delete/{name}', name: 'app_category_name')]
   public function deleteCategory(string $name): Response {
       return $this-> render("category/delete.html.twig");
   }


}
