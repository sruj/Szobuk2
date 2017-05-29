<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use AppBundle\Entity\Ksiazka;
use AppBundle\Form\KsiazkaType;
use AppBundle\Form\KsiazkaListType;
use AppBundle\Entity\KsiazkaList;
use AppBundle\Exception\BookNotFoundException;

/**
 * @Route("/book")
 */
class BookController extends Controller
{
    /**
     * Lists all Ksiazka entities.
     *
     * @Route("/", name="book")
     */
    public function indexAction(Request $request)
    {
        $rep = $this->get('app.ksiazka_repository');
        $books = [];
        if ($this->isGranted('ROLE_ADMIN')) {
            $lpr = 9999;
            $books = $rep->findAllAdmin($request->query->getInt('page', 1), $lpr);
        }
        if (!$this->isGranted('ROLE_ADMIN')) {
            $books = $rep->findAllMy($request->query->getInt('page', 1), KsiazkaList::NUM_ITEMS);
        }

        //[-Formularz Główny-]Ładowanie $zamowieniaList - zmiennej potrzebnej do głównego formularza.
        //To kluczowa zmienna. Obiekt ZamowienieList() to kolekcja formularzy
        //pozwala na stworzenie wielu formularzy z jednym buttonem
        $bookList = new KsiazkaList();
        foreach ($books as $book) {
            $bookList->getKsiazki()->add($book);
        }

        //[-Formularz Główny-]Główny formularz $form. Struktura to kolekcja formularzy KsiazkaListType()
        //a zawartość to $KsiazkiList
        $form = $this->createForm(KsiazkaListType::class, $bookList);

        //[-Formularz Główny-]Jeśli w panelu zmienionio ilos i kliknięto zapisz to odbieram
        //zawartość formularza i aktualizuję bazę danych
        $form->handleRequest($request);
        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            foreach ($form->getData() as $task) {
                $em->merge($task);
            }
            $em->flush();
        }

        return $this->render('AppBundle:Book:index.html.twig', [
            'ksiazki' => $books, 'form' => $form->createView(),
        ]);
    }

    /**
     * 1.[dodawanie nowej książki]
     * Displays a form to create a new Ksiazka entity.
     *
     * @Route("/admin/new", name="book_new")
     * @Method("GET")
     */
    public function newAction()
    {
        $entity = new Ksiazka();
        $form = $this->createCreateForm($entity);

        return $this->render('AppBundle:Book:new.html.twig', [
            'entity' => $entity,
            'form' => $form->createView(),

        ]);
    }

    /**
     * 2.[dodawanie nowej książki]
     * Creates a form to create a Ksiazka entity.
     *
     * @param Ksiazka $entity The entity
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Ksiazka $entity)
    {
        $form = $this->createForm(KsiazkaType::class, $entity, array(
            'action' => $this->generateUrl('book_create'),
            'method' => 'GET', 'attr' => array('class' => 'form_new_book')
        ));

        $form->add('submit', 'submit', array('label' => 'Dodaj'));

        return $form;
    }

    /**
     * 3.[dodawanie nowej książki] Tu przechodzę po kliknięciu w template submit button.
     * Creates a new Ksiazka entity.
     *
     * @Route("/admin/create", name="book_create")
     * @Method("GET")
     */
    public function createAction(Request $request)
    {
        $entity = new Ksiazka();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();
            return $this->redirect($this->generateUrl('book_show', array('id' => $entity->getIsbn())));
        }
        return $this->render('AppBundle:Book:new.html.twig', [
            'entity' => $entity,
            'form' => $form->createView(),
        ]);
    }

    /**
     * 4.[dodawanie nowej książki]
     * Finds and displays a Ksiazka entity.
     *
     * @Route("/show/{id}", name="book_show")
     * @Method("GET")
     */
    public function showAction($id)
    {
        $entity = $this->getDoctrine()->getRepository('AppBundle:Ksiazka')->find($id);
        if (!$entity) {
            throw new BookNotFoundException('Nie można znaleźć książki');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('AppBundle:Book:show.html.twig', [
            'entity' => $entity,
            'delete_form' => $deleteForm->createView(),

        ]);
    }

    /**
     * 1.[edycja ksiazki]
     * Displays a form to edit an existing Ksiazka entity.
     *
     * @Route("/admin/edit/{id}", name="book_edit")
     * @Method("GET")
     */
    public function editAction($id)
    {
        $entity = $this->getDoctrine()->getRepository('AppBundle:Ksiazka')->find($id);
        if (!$entity) {
            throw new BookNotFoundException('Nie można znaleźć książki.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('AppBundle:Book:edit.html.twig', [
            'entity' => $entity,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ]);
    }

    /**
     * 2.[edycja ksiazki]
     * Creates a form to edit a Ksiazka entity.
     *
     * @param Ksiazka $entity The entity
     * @return \Symfony\Component\Form\Form The form
     */
    private function createEditForm(Ksiazka $entity)
    {
        $form = $this->createForm(KsiazkaType::class, $entity, array(
            'action' => $this->generateUrl('book_update', array('id' => $entity->getIsbn())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Zaktualizuj',
            'attr' => array('class' => 'guzikZaktualizuj')));

        return $form;
    }

    /**
     * 3.[edycja ksiazki], Tu wpadam po kliknięciu guzika Zaktualizuj
     * Edits an existing Ksiazka entity.
     *
     * @Route("/admin/{id}/update", name="book_update")
     * @Method("PUT")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('AppBundle:Ksiazka')->find($id);
        if (!$entity) {
            throw $this->createNotFoundException('Nie można znaleźć książki.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();
            return $this->redirect($this->generateUrl('book_edit', array('id' => $id)));
        }

        return $this->render('AppBundle:Book:edit.html.twig', [
            'entity' => $entity,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ]);
    }

    /**
     * Deletes a Ksiazka entity.
     *
     * @Route("/admin/{id}/delete", name="book_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('AppBundle:Ksiazka')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Nie można znaleźć książki.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl(('book')));
    }

    /**
     * Creates a form to delete a Ksiazka entity by id.
     *
     * @param mixed $id The entity id
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('book_delete', ['id' => $id]))
            ->setMethod('DELETE')
            ->add('submit', 'submit', ['label' => 'Usuń',
                'attr' => ['class' => 'OrangeButton']])
            ->getForm();
    }

    /**
     * wyszukiwarka.
     *
     * @Route("/search/", name="search", options={"expose"=true})
     * @Method("GET")
     */
    public function searchAction(Request $request)
    {
        if ($request->isXmlHttpRequest()) {
            $word = $request->query->keys();
            $word = $word[0];
            $rep = $this->get('app.ksiazka_repository');
            $query = $rep->queryWyszukiwarka($word);
            $books = $query->getResult();

            $renderData = [];
            if (!empty($books)) {
                $renderData['template'] = $this->renderView('AppBundle:Book:searchSuggestionAjax.html.twig', array(
                    'books' => $books, 'word' => strtolower($word)
                ));
            }

            return new JsonResponse($renderData);
        }

        $form = $this->createFormBuilder()
            ->setAction($this->generateUrl('search'))
            ->setMethod('GET')
            ->add('input', 'text',
                ['attr' => ['placeholder' => 'szukaj książki', 'class' => 'NavSearch'],
                    'label' => false])
            ->add('szukaj', 'submit', [
                'attr' => ['class' => 'NavSearch-searchIcon']])
            ->getForm();

        $form->handleRequest($request);

        if ($form->isValid()) {
            $data = $form->get('input')->getData();
            return $this->redirect($this->generateUrl('search_results', ['word' => $data]));
        }

        return $this->render('AppBundle:Book:search.html.twig', ['form' => $form->createView()]);
    }

    /**
     * wyszukiwarka.
     *
     * @Route("/search/results/{word}", name="search_results")
     * @Method("GET")
     */
    public function searchResultsAction(Request $request, $word = false)
    {
        $ksi_rep = $this->get('app.ksiazka_repository');
        $ksiazki = $ksi_rep->findWyszukiwarka($word, $request->query->getInt('page', 1));

        return $this->render('AppBundle:Book:searchResults.html.twig',
            ['entities' => $ksiazki, 'word' => strtolower($word)]);
    }

    /**
     * ksiazki wg wybranego parametru. (np /ksiazka/rokwydania-1956/show_books_by)
     *
     * @Route("/{findby}-{what}/show-books-by", name="show_books_by")
     * @Method("GET")
     */
    public function showBooksByAction(Request $request, $findby = false, $what = false)
    {
        $ksi_rep = $this->get('app.ksiazka_repository');
        $ksiazki = $ksi_rep->findByWhat($findby, $what, $request->query->getInt('page', 1));

        return $this->render('AppBundle:Book:show_books_by.html.twig', [
            'findby' => $findby,
            'what' => $what,
            'pagination' => $ksiazki,
        ]);
    }
}
