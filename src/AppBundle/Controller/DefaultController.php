<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Book;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\Serializer\Serializer;

class DefaultController extends Controller
{
    /**
     * Kontroler przygotowujący dane do wyświetlenia książek używane na stronie głównej (wszystkie, nowości, popularne)
     *
     * @Route("/", name="index", options={"expose"=true})
     */
    public function indexAction(Request $request)
    {
        $session = $request->getSession();                                                                               //jeśli w trakcie zakupów w wyborze autoryzacji wybrałem zaloguj lub zarejestruj to przenoszę się do *gdzieśtam*
        $orderingProcess = $session->get('orderingProcess');
        if ($orderingProcess) {
            $session->remove('orderingProcess');

            return $this->redirectToRoute('personal_data');
        };

        $ksi_rep = $this->get('app.book_repository');

        if ($request->isXmlHttpRequest()) {
            $ksiazki = $ksi_rep->findAllMy($request->query->getInt('page'), 12);
            $ksiazki = $ksiazki->getItems();
            $books = [];
            $renderData = [];
            if (!empty($ksiazki)) {
                $i = 0;
                /** @var Book $ksiazka */
                foreach ($ksiazki as $ksiazka) {
                    $books[$i]['isbn'] = $ksiazka->getIsbn();
                    $books[$i]['autor'] = $ksiazka->getAutor();
                    $books[$i]['title'] = $ksiazka->getTitle();
                    $books[$i]['cena'] = $ksiazka->getPrice();
                    $books[$i]['obrazek'] = $ksiazka->getObrazek();
                    $i++;
                }
                $renderData['template'] = $this->renderView('AppBundle:Default:index2.html.twig', array(
                    'books' => $books
                ));
                $renderData['last_page'] = false;
            }
            if (sizeof($ksiazki) < 12) {
                $renderData['last_page'] = true;
            }

            return new JsonResponse($renderData);
        }
        $ksiazki = $ksi_rep->findAllMy($request->query->getInt('page', 1), 6);

        return $this->render('AppBundle:Default:index.html.twig', [
            'ksiazki' => $ksiazki
        ]);
    }

    /**
     * @Route("/popular", name="popular")
     */
    public function popularAction(Request $request)
    {
        $ksi_rep = $this->get('app.book_repository');
        $ksiazki = $ksi_rep->findPopular($request->query->getInt('page', 1));

        return $this->render('AppBundle:Default:popular.html.twig', [
            'ksiazki' => $ksiazki
        ]);
    }

    /**
     * @Route("/news", name="news")
     */
    public function newsAction(Request $request)
    {
        $ksi_rep = $this->get('app.book_repository');
        $ksiazki = $ksi_rep->findNews($request->query->getInt('page', 1));

        return $this->render('AppBundle:Default:news.html.twig', [
            'ksiazki' => $ksiazki
        ]);
    }
}
