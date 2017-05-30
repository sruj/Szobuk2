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
            $books = $ksi_rep->findAllMy($request->query->getInt('page'), 12);
            $books = $books->getItems();
            $books = [];
            $renderData = [];
            if (!empty($books)) {
                $i = 0;
                /** @var Book $ksiazka */
                foreach ($books as $ksiazka) {
                    $books[$i]['isbn'] = $ksiazka->getIsbn();
                    $books[$i]['author'] = $ksiazka->getAuthor();
                    $books[$i]['title'] = $ksiazka->getTitle();
                    $books[$i]['cena'] = $ksiazka->getPrice();
                    $books[$i]['picture'] = $ksiazka->getPicture();
                    $i++;
                }
                $renderData['template'] = $this->renderView('AppBundle:Default:index2.html.twig', array(
                    'books' => $books
                ));
                $renderData['last_page'] = false;
            }
            if (sizeof($books) < 12) {
                $renderData['last_page'] = true;
            }

            return new JsonResponse($renderData);
        }
        $books = $ksi_rep->findAllMy($request->query->getInt('page', 1), 6);

        return $this->render('AppBundle:Default:index.html.twig', [
            'books' => $books
        ]);
    }

    /**
     * @Route("/popular", name="popular")
     */
    public function popularAction(Request $request)
    {
        $ksi_rep = $this->get('app.book_repository');
        $books = $ksi_rep->findPopular($request->query->getInt('page', 1));

        return $this->render('AppBundle:Default:popular.html.twig', [
            'books' => $books
        ]);
    }

    /**
     * @Route("/news", name="news")
     */
    public function newsAction(Request $request)
    {
        $ksi_rep = $this->get('app.book_repository');
        $books = $ksi_rep->findNews($request->query->getInt('page', 1));

        return $this->render('AppBundle:Default:news.html.twig', [
            'books' => $books
        ]);
    }
}
