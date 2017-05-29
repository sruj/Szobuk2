<?php

namespace AppBundle\Controller;

use Doctrine\DBAL\DBALException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use AppBundle\Entity\Kategoria;
use AppBundle\Form\KategoriaType;

/**
 * @Route("/category")
 */
class CategoryController extends Controller
{
    /**
     * Lista kategorii.
     *
     * @Route("/", name="category")
     * @Method("GET")
     */
    public function indexAction()
    {
        $entities = $this->getDoctrine()->getRepository('AppBundle:Kategoria')->findAll();

        return $this->render('AppBundle:Category:index.html.twig', [
            'entities' => $entities
        ]);
    }

    /**
     * Wyświetla książki wybranej kategorii.
     *
     * @Route("/{id}", name="category_show")
     * @Method("GET")
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $category = $em->getRepository(Kategoria::class)->find($id);

        if (!$category) {
            throw $this->createNotFoundException('Nie można znaleźć kategorii.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $books = $em->getRepository('AppBundle:Ksiazka')
            ->findBy(array('idkategoria' => $id));

        return $this->render('AppBundle:Category:show.html.twig', [
            'category' => $category,
            'books' => $books,
            'delete_form' => $deleteForm->createView(),
        ]);
    }

    /**
     * Creates a new Category entity.
     *
     * @Route(name="category_create")
     * @Method("POST")
     */
    public function createAction(Request $request)
    {
        $entity = new Kategoria();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('category_show', array('id' => $entity->getIdkategoria())));
        }

        return $this->render('AppBundle:Category:new.html.twig', [
            'entity' => $entity,
            'form' => $form->createView()
        ]);
    }

    /**
     * Creates a form to create a Category entity.
     *
     * @param Kategoria $entity The entity
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Kategoria $entity)
    {
        $form = $this->createForm(KategoriaType::class, $entity, array(
            'action' => $this->generateUrl('category_create'),
            'method' => 'POST',
        ));
        $form->add('submit', 'submit', array('label' => 'Dodaj'));

        return $form;
    }

    /**
     * Displays a form to create a new Category entity.
     *
     * @Route("/admin/new", name="category_new")
     * @Method("GET")
     */
    public function newAction()
    {
        $entity = new Kategoria();
        $form = $this->createCreateForm($entity);

        return $this->render('AppBundle:Category:new.html.twig', [
            'entity' => $entity,
            'form' => $form->createView(),
        ]);
    }

    /**
     * Displays a form to edit an existing Category entity.
     *
     * @Route("/admin/{id}/edit", name="category_edit")
     * @Method("GET")
     */
    public function editAction($id)
    {
        $category = $this->getDoctrine()->getRepository('AppBundle:Kategoria')->find($id);

        if (!$category) {
            throw $this->createNotFoundException('Nie można znaleźć kategorii.');
        }

        $editForm = $this->createEditForm($category);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('AppBundle:Category:edit.html.twig', [
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ]);
    }

    /**
     * Cwaniackie zabezpieczenie by adresy /admin/xxxxxxx wyświetlały mój nadpisany error, a nie brzydki komunikat "No route found for "GET /kategoria/admin/xxxxxx""
     *
     * @Route("/admin/{szatan}")
     */
    public function pageNotFoundAction($szatan)
    {
        throw $this->createNotFoundException('Strona .../kategoria/admin/' . $szatan . ' nie istnieje');
    }

    /**
     * Edits an existing Category entity.
     *
     * @Route("/admin/{id}/edits", name="category_update")
     * @Method("PUT")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('AppBundle:Kategoria')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Nie można znaleźć kategorii.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('category_edit', array('id' => $id)));
        }

        return $this->render('AppBundle:Category:edit.html.twig', [
            'entity' => $entity,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ]);
    }

    /**
     * Deletes a Category entity.
     *
     * @Route("/admin/{id}/deletes", name="category_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('AppBundle:Kategoria')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Nie można znaleźć kategorii.');
            }

            try {
                $em->remove($entity);
                $em->flush();
            } catch (DBALException $pdo_ex) {
                throw $this->createNotFoundException("Próbujesz usunąć kategorię, do której przypisane są istniejące książki. Najpierw usuń te książki.\n\n\n\nOryginalna treść błędu PDOException: \n\n" . $pdo_ex->getMessage() . '' . (int)$pdo_ex->getCode());
            }

        }

        return $this->redirect($this->generateUrl('category'));
    }

    /**
     * Creates a form to edit a Category entity.
     *
     * @param Kategoria $entity The entity
     * @return \Symfony\Component\Form\Form The form
     */
    private function createEditForm(Kategoria $entity)
    {
        $form = $this->createForm(KategoriaType::class, $entity, array(
            'action' => $this->generateUrl('category_update', array('id' => $entity->getIdkategoria())),
            'method' => 'PUT',
        ));
        $form->add('submit', 'submit', array('label' => 'Zaktualizuj'));

        return $form;
    }

    /**
     * Creates a form to delete a Category entity by id.
     *
     * @param mixed $id The entity id
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('category_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Usuń'))
            ->getForm();
    }
}
