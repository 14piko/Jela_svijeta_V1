<?php


namespace App\Controller;

use App\Entity\Food;
use App\Form\SearchForm;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class FoodController extends AppController
{
    /**
     * @Route("/", name="app_homepage")
     */
    public function homepage(Request $request)
    {

        $form = $this->createForm(SearchForm::class);
        $form->handleRequest($request);
        if ($form->isSubmitted())
        {
            $input = $form->getData()['input'];
            $search = $this->manager->getRepository(Food::class)
                ->search($input,);

            return $this->render("food/show.html.twig", [
                'foods' => $this->paginate($search, $request, $form->get('search')->isClicked()),
                'form' => $form->createView(),
            ]);
        }

        $foods = $this->manager->getRepository(Food::class)->findAllFood();

        if(isset($_GET['lang']))
        {
            $locale = $_GET['lang'];
            $this->translator->setLocale($locale);
        }

        if(isset($_GET['category']))
        {
            $category = $_GET['category'];
            if($category == 'NULL'){
                $foods = $this->manager->getRepository(Food::class)
                    ->findBy(['category' => null]);
            }elseif($category == '!NULL'){
                $foods = $this->manager->getRepository(Food::class)->findAllFood();
            }else{
                $explode = explode(",",$category);
                $foods = $this->manager->getRepository(Food::class)
                    ->findBy(['category' => $explode]);
            }
        }


        if(isset($_GET['per_page']))
        {
            $per_page = $_GET['per_page'];
            $foodsPaginate = $this->paginate($foods,$request,false,$per_page);
        }else{
            $foodsPaginate = $this->paginate($foods,$request,false,5);
        }

        if(isset($_GET['with'])) {
            $with = $_GET['with'];

            if ($with == 'ingredients') {
                return $this->render('food/showIngredients.html.twig', [
                    'foods' => $foodsPaginate,
                    'form' => $form->createView(),
                ]);
            }
            if ($with == 'category') {
                return $this->render('food/showCategory.html.twig', [
                    'foods' => $foodsPaginate,
                    'form' => $form->createView(),
                ]);
            }
            if ($with == 'tags') {
                return $this->render('food/showTags.html.twig', [
                    'foods' => $foodsPaginate,
                    'form' => $form->createView(),
                ]);
            }
            if($with == 'tags,category' or $with == 'category,tags'){
                return $this->render('food/showTagsCategory.html.twig', [
                    'foods' => $foodsPaginate,
                    'form' => $form->createView(),
                ]);
            }
            if ($with == 'ingredients,category,tags'
                or $with == 'category,ingredients,tags'
                or $with == 'tags,category,ingredients'
                or $with == 'category,tags,ingredients'
                or $with == 'ingredients,category,tags'
                or $with == 'ingredients,tags,category') {
                return $this->render('food/showAll.html.twig', [
                    'foods' => $foodsPaginate,
                    'form' => $form->createView(),
                ]);
            }
        }

        return $this->render('food/show.html.twig', [
            'foods' => $foodsPaginate,
            'form' => $form->createView(),
        ]);
        }
}