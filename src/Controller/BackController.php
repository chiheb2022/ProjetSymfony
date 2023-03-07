<?php

namespace App\Controller;

use App\Entity\Don;
use App\Form\DonType;
use App\Repository\CategorieDRepository;
use App\Repository\DonRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Knp\Component\Pager\PaginatorInterface;

#[Route('/admin')]
class BackController extends AbstractController
{
    #[Route('/', name: 'app_back')]
    public function index(): Response
    {
        return $this->render('back/index.html.twig', [
            'controller_name' => 'BackController',
        ]);
    }


    // gestion Don

    #[Route('/dons', name: 'app_don_home_admin', methods: ['GET'])]
    public function HomeDon(DonRepository $donRepository , CategorieDRepository $categorieDRepository , UserRepository $userRepository): Response
    {
        $donRepository = $this->getDoctrine()->getRepository(Don::class);
        $em = $this->getDoctrine()->getManager();

        $total = $em->getRepository(Don::class)->count([]);

        $totalDonCount = $donRepository->count([]);
        $dispoDonCount = $donRepository->count(['etat' => 1]);
        $valideDonCount = $donRepository->count(['etat' => 3]);
        $encourDonCount = $donRepository->count(['etat' => 2]);

        // Calcul des pourcentages
        $totalDonPercentage = $totalDonCount > 0 ? round(($totalDonCount / $totalDonCount) * 100, 2) : 0;
        $dispoDonPercentage = $totalDonCount > 0 ? round(($dispoDonCount / $totalDonCount) * 100, 2) : 0;
        $valideDonPercentage = $totalDonCount > 0 ? round(($valideDonCount / $totalDonCount) * 100, 2) : 0;
        $encourDonPercentage = $totalDonCount > 0 ? round(($encourDonCount / $totalDonCount) * 100, 2) : 0;


        return $this->render('back/don_admin/home.html.twig', [
             'total' => $donRepository->total(),
               // 'users' => $userRepository->findAll(),
                'categoriesdon' => $donRepository->categoriesdon(),
                'categoriesdons' => $donRepository->categoriesdons(),
                'poidsTotal' =>  $donRepository->poidsTotal(),
                'usersDon' => $donRepository -> usersDon() ,
                'totalcategorie' => $categorieDRepository-> totalcategorie(),
                'categorie' => $categorieDRepository->findAll(),
                'totaldonDispo' =>  $donRepository->totaldonDispo(),
                'donDispo' =>  $donRepository->findValidDon(),

            'totals' => $total,

           'users' => $donRepository->sumPoidsByUser(),

            'totalDonCount' => $totalDonCount,
            'valideDonCount' => $valideDonCount,
            'attenteDonCount' => $encourDonCount,
            'dispoDonCount' => $dispoDonCount,
            // Calcul des pourcentages
            'totalDonPercentage' => $totalDonPercentage,
            'valideDonPercentage' => $valideDonPercentage,
            'attenteDonPercentage' => $encourDonPercentage,
            'dispoDonPercentage' => $dispoDonPercentage,

        ]);
    }




    #[Route('/don', name: 'app_don_index_admin', methods: ['GET'])]
    public function indexDon(categorieDRepository $categorieDRepository  , PaginatorInterface $paginator, Request $request , DonRepository $donRepository , ): Response
    {
      //  $dons = $this->getDoctrine()->getRepository(Don::class)->findByCategorie($idCategorie);
        $dons = $this->getDoctrine()->getRepository(Don::class)->findAll();
       // $dons = $this->getDoctrine()->getRepository(Don::class)->findBy([],['created_at' => 'desc']);
        $pagination = $paginator->paginate(
            $dons,
            $request->query->getInt('page', 1),
            10
        );


        return $this->render('back/don_admin/index.html.twig', [
            'dons'  => $pagination,
            'categories' => $categorieDRepository->findAll(),
        ]);
    }


    #[Route('/dons/{idCategorie}', name: 'app_dons_categories_admin', methods: ['GET'])]
    public function donsCategorie(Request $request, PaginatorInterface $paginator, $idCategorie)
    {
        $dons = $this->getDoctrine()->getRepository(Don::class)->findByCategorie($idCategorie);

        $pagination = $paginator->paginate(
            $dons, /* query NOT result */
            $request->query->getInt('page', 1)/*page number*/,
            10/*limit per page*/
        );

        return $this->render('back/don_admin/donsCategories.html.twig', [
            'dons' => $pagination,
        ]);
    }

    #[Route('/don/new', name: 'app_don_new_admin', methods: ['GET', 'POST'])]
    public function new(Request $request, DonRepository $donRepository , SessionInterface $session): Response
    {
        $don = new Don();
        $form = $this->createForm(DonType::class, $don);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $donRepository->save($don, true);
            $session->getFlashBag()->add('success', 'Don created successfully!');

            return $this->redirectToRoute('app_don_index_admin', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('back/don_admin/new.html.twig', [
            'don' => $don,
            'form' => $form,
        ]);
    }

    #[Route('/don/{id}', name: 'app_don_show_admin', methods: ['GET'])]
    public function show(Don $don): Response
    {
        return $this->render('back/don_admin/show.html.twig', [
            'don' => $don,
        ]);
    }

    #[Route('/don/{id}/edit', name: 'app_don_edit_admin', methods: ['GET', 'POST'])]
    public function edit(Request $request, Don $don, DonRepository $donRepository): Response
    {
        $form = $this->createForm(DonType::class, $don);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $donRepository->save($don, true);

            return $this->redirectToRoute('app_don_index_admin', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('back/don_admin/edit.html.twig', [
            'don' => $don,
            'form' => $form,
        ]);
    }

    #[Route('/don/{id}', name: 'app_don_delete_admin', methods: ['POST'])]
    public function delete(Request $request, Don $don, DonRepository $donRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$don->getId(), $request->request->get('_token'))) {
            $donRepository->remove($don, true);
        }

        return $this->redirectToRoute('app_don_index_admin', [], Response::HTTP_SEE_OTHER);
    }
   /* #[Route('/admin', name: 'app_back')]
    public function index(): Response
    {
        return $this->render('back/index.html.twig', [
            'controller_name' => 'BackController',
        ]);
    }
    */


}
