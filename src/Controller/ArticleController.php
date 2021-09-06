<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;//pour utiliser les routes
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;//pour utiliser render

use App\Entity\Article;
use Doctrine\ORM\QueryBuilder;

//datatable
use Omines\DataTablesBundle\Adapter\Doctrine\ORMAdapter;
use Omines\DataTablesBundle\Column\TextColumn;
use Omines\DataTablesBundle\Column\DateTimeColumn;
use Omines\DataTablesBundle\Column\NumberColumn;
use Omines\DataTablesBundle\DataTableFactory;

class ArticleController extends AbstractController {

    /**
      * @Route("/")
      * @Route("/article/liste", name="article_liste") . le name est important pour l'utiliser dans les href!
      */
    public function showListe(Request $request, DataTableFactory $dataTableFactory): Response
    {
        $datatable = $dataTableFactory->create()
        ->add('date_creation', DateTimeColumn::class, ['label' => 'Date création', 'format' => 'd/m/Y'])
        ->add('nom', TextColumn::class, ['label' => 'Nom'])
        ->add('description', TextColumn::class, ['label' => 'Description'])
        ->add('prix', NumberColumn::class, ['label' => 'Prix'])
        ->add('quantite', NumberColumn::class, ['label' => 'Quantité'])
        ->add('image', TextColumn::class, ['label' => 'Image', 'render' => function($value, $context) {
            return '<img src="/uploads/article/' . $value . '" alt="test">';
        }])
        ->createAdapter(ORMAdapter::class, [
            'entity' => Article::class,
            'query' => function (QueryBuilder $builder) {
                $builder
                    ->select('a')
                    ->from(Article::class, 'a')
                ;
            },
        ])->handleRequest($request);

        if ($datatable->isCallback()) {
            return $datatable->getResponse();
        }

        return $this->render('article/list.html.twig', [
            'datatable' => $datatable
        ]);
    }
}
