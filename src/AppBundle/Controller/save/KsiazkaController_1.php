<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use AppBundle\Entity\Ksiazka;
use AppBundle\Form\KsiazkaType;

use AppBundle\Form\KsiazkaListType;
use AppBundle\Entity\KsiazkaList;

/**
 * Ksiazka controller.
 *
 * @Route("/ksiazka")
 */
class KsiazkaController extends Controller {

//     * @Method("GET")
    /**
     * Lists all Ksiazka entities.
     *
     * @Route("/", name="ksiazka")
     * @Template()
     */
    public function indexAction(Request $request) {
        $em = $this->getDoctrine()->getManager();
        $ksiazki = $em->getRepository('AppBundle:Ksiazka')->findAll();

        
        $em    = $this->get('doctrine.orm.entity_manager');
        $dql   = "SELECT a FROM AppBundle:Ksiazka a";
        $query = $em->createQuery($dql);

        $paginator  = $this->get('knp_paginator');
        if ($this->isGranted('ROLE_ADMIN')) {$lpr=99999;}else{$lpr=30;}/*limit per page. 9999 bo form_end dodaje przy paginacji na pierwszej stronie dodaje brakujáce elementy formularzy calej zawartoßci*/

        $pagination = $paginator->paginate(
            $query,
            $request->query->getInt('page', 1)/*page number*/,
            $lpr/*limit per page*/
        );
        

        //[-Formularz Główny-]Ładowanie $zamowieniaList - zmiennej potrzebnej do głównego formularza. 
        //To kluczowa zmienna. Obiekt ZamowienieList() to kolekcja formularzy
        //pozwala na stworzenie wielu formularzy z jednym buttonem
        $KsiazkiList = new KsiazkaList();     
        foreach ($ksiazki as $ksiazka) {
            $KsiazkiList->getKsiazki()->add($ksiazka);
        }  

        //[-Formularz Główny-]Główny formularz $form. Struktura to kolekcja formularzy KsiazkaListType()
        //a zawartość to $KsiazkiList
        $form = $this->createForm(new KsiazkaListType(), $KsiazkiList);

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
        
        
        return array(
            'pagination' => $pagination,'form' => $form->createView(),
        );
    }

    /**
     * 1.[dodawanie nowej książki]
     * Displays a form to create a new Ksiazka entity.
     *
     * @Route("/admin/new", name="ksiazka_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction() {
        $entity = new Ksiazka();
        $form = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form' => $form->createView(),
        );
    }

    /**
     * 2.[dodawanie nowej książki]
     * Creates a form to create a Ksiazka entity.
     *
     * @param Ksiazka $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Ksiazka $entity) {
        $form = $this->createForm(new KsiazkaType(), $entity, array(
            'action' => $this->generateUrl('ksiazka_create'),
            'method' => 'GET',
        ));

        $form->add('submit', 'submit', array('label' => 'Dodaj'));

        return $form;
    }

    /**
     * 3.[dodawanie nowej książki] Tu przechodzę po kliknięciu w template submit button. 
     * Creates a new Ksiazka entity.
     *
     * @Route("/admin/create", name="ksiazka_create")
     * @Method("GET")
     * @Template("AppBundle:Ksiazka:new.html.twig")
     */
    public function createAction(Request $request) {
        $entity = new Ksiazka();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();
            return $this->redirect($this->generateUrl('ksiazka_show', array('id' => $entity->getIsbn())));
        }

        return array(
            'entity' => $entity,
            'form' => $form->createView(),
        );
    }

    /**
     * 4.[dodawanie nowej książki] 
     * Finds and displays a Ksiazka entity.
     *
     * @Route("/show/{id}", name="ksiazka_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id) {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:Ksiazka')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Ksiazka entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity' => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * 1.[edycja ksiazki]
     * Displays a form to edit an existing Ksiazka entity.
     *
     * @Route("/admin/edit/{id}", name="ksiazka_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id) {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:Ksiazka')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Ksiazka entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity' => $entity,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * 2.[edycja ksiazki]
     * Creates a form to edit a Ksiazka entity.
     *
     * @param Ksiazka $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createEditForm(Ksiazka $entity) {
        $form = $this->createForm(new KsiazkaType(), $entity, array(
            'action' => $this->generateUrl('ksiazka_update', array('id' => $entity->getIsbn())),
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
     * @Route("/admin/update/{id}", name="ksiazka_update")
     * @Method("PUT")
     * @Template("AppBundle:Ksiazka:edit.html.twig")
     */
    public function updateAction(Request $request, $id) {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:Ksiazka')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Ksiazka entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('ksiazka_edit', array('id' => $id)));
        }

        return array(
            'entity' => $entity,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Deletes a Ksiazka entity.
     *
     * @Route("/admin/delete/{id}", name="ksiazka_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id) {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('AppBundle:Ksiazka')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Ksiazka entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('ksiazka'));
    }

    /**
     * Creates a form to delete a Ksiazka entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id) {
        return $this->createFormBuilder()
                        ->setAction($this->generateUrl('ksiazka_delete', array('id' => $id)))
                        ->setMethod('DELETE')
                        ->add('submit', 'submit', array('label' => 'Usuń',
                            'attr' => array('class' => 'OrangeButton')))
//            ->add('submit', 'submit', array('label' => 'Usuń'))
                        ->getForm()
        ;
    }

//            ->add('submit', 'submit', array('label' => 'Usuń', 
//                                            'attr' => array('class' => 'OrangeButton')))

    /**
     * wyszukiwarka.
     *
     * @Route("/search/", name="search")
     * @Method("GET")
     */
    public function searchAction(Request $request) {
        $form = $this->createFormBuilder()
        ->setAction($this->generateUrl('search'))
        ->setMethod('GET')
        ->add('input', 'text', 
            array('attr' => array('placeholder' => 'szukaj książki','class' => 'NavSearch'),
                'label' => false))
        ->add('szukaj', 'submit', array(
                    'attr' => array('class' => 'NavSearch-searchIcon')))
                ->getForm();

        $form->handleRequest($request);

        if ($form->isValid()) {
            $data = $form->get('input')->getData();
            return $this->redirect($this->generateUrl('search_results', array('word' => $data)));
        }

        return $this->render('AppBundle:Ksiazka:search.html.twig', array('form' => $form->createView()));
    }

    /**
     * wyszukiwarka.
     *
     * @Route("/search/results/{word}", name="search_results")
     * @Method("GET")
     */
    public function searchResultsAction(Request $request, $word = false) {
        $em = $this->getDoctrine()->getManager();
        $repository = $em->getRepository('AppBundle:Ksiazka');
        $query = $repository->createQueryBuilder('a')
                ->where('a.tytul LIKE :word')
                ->orWhere('a.autor LIKE :word')
                ->orWhere('a.wydawnictwo LIKE :word')
                ->setParameter('word', '%' . $word . '%')
                ->getQuery();
        $ksiazki = $query->getResult();

//        $entities = $em->getRepository('AppBundle:Ksiazka')->find($id);
//        if (!$ksiazki) {
//            throw $this->createNotFoundException('Nie ma powiązanych książek, autorów lub wydawnictw z hasłem: "'.$word.'".');
//        }
        $word = strtolower($word);
        
        return $this->render('AppBundle:Ksiazka:searchResults.html.twig', array(
                    'entities' => $ksiazki, 'word' => $word));
    }
    
    
    /**
     * ksiazki wg wybranego parametru.
     *
     * @Route("/showBooksBy/{findby}-{what}", name="showBooksBy")
     * @Method("GET")
     */
    public function showBooksByAction(Request $request, $findby = false, $what = false) {
        $em = $this->getDoctrine()->getManager();

        $ksiazki = $em->getRepository('AppBundle:Ksiazka')
                ->findBy(array($findby => $what));

//        $dql   = "SELECT a FROM AppBundle:Ksiazka a";
//        $query = $em->createQuery($dql);        
        
        $query = $em->createQuery(
            'SELECT a
            FROM AppBundle:Ksiazka a
            WHERE a.'.$findby.' = :param'
        )->setParameter('param', $what);
        
        $paginator  = $this->get('knp_paginator');

        $pagination = $paginator->paginate(
            $query,
            $request->query->getInt('page', 1)/*page number*/,
            45/*limit per page*/
        );        
        
        
        return $this->render('AppBundle:Ksiazka:showBooksBy.html.twig', array(
            'findby'      => $findby,
            'what'        => $what,
            'pagination'  => $pagination,
        ));
    }

    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    /**
     * test.
     *
     * @Route("/atest", name="atest")
     * @Method("GET")
     */
    public function atestAction() {
        return $this->render('AppBundle:Ksiazka:atest.html.twig', array());
    }

    /**
     * test.
     *
     * @Route("/a", name="a")
     * @Method("GET")
     */
    public function aAction(Request $request) {
        return $this->render('AppBundle:Ksiazka:a.html.twig', array());
    }

    /**
     * test.
     *
     * @Route("/asearch", name="asearch")
     * @Method("GET")
     */
    public function asearchAction(Request $request) {
        $form = $this->createFormBuilder()
                ->setAction($this->generateUrl('asearch'))
                ->setMethod('GET')
                ->add('input', 'text')
                ->add('save', 'submit')
                ->getForm();

        $form->handleRequest($request);

        if ($form->isValid()) {
            $data = $form->get('input')->getData();
            echo 'dupa';
            echo '<pre>', print_r($data), '</pre>';
            $ksiazki = $data;
            return $this->redirect($this->generateUrl('asearch_results', array('ksiazki' => $ksiazki)));
        } else {
            echo'niewalid';
        }

        return
                $this->render('AppBundle:Ksiazka:asearch.html.twig', array('form' => $form->createView()));
    }

//     * @Route("/asearch/results/", name="asearch_results")
    /**
     * wyszukiwarka.
     *
     * @Route("/asearch/results/{ksiazki}", name="asearch_results")
     * @Method("GET")
     */
    public function asearchResultsAction(Request $request, $ksiazki = false) {

        return $this->render('AppBundle:Ksiazka:searchResults.html.twig', array(
                    'entity' => $ksiazki));
//        return $this->render('AppBundle:Ksiazka:searchResults.html.twig');
    }

}
