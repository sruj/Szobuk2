<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use AppBundle\Entity\Ksiazka;
use AppBundle\Form\KsiazkaType;

/**
 * Ksiazka controller.
 *
 * @Route("/ksiazka")
 */
class KsiazkaController extends Controller
{

    /**
     * Lists all Ksiazka entities.
     *
     * @Route("/", name="ksiazka")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('AppBundle:Ksiazka')->findAll();

        return array(
            'entities' => $entities,
        );
    }
    /**
     * Creates a new Ksiazka entity.
     *
     * @Route("/", name="ksiazka_create")
     * @Method("POST")
     * @Template("AppBundle:Ksiazka:new.html.twig")
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
            return $this->redirect($this->generateUrl('ksiazka_show', array('id' => $entity->getIsbn())));
//            return $this->redirect($this->generateUrl('ksiazka_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Creates a form to create a Ksiazka entity.
     *
     * @param Ksiazka $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Ksiazka $entity)
    {
        $form = $this->createForm(new KsiazkaType(), $entity, array(
            'action' => $this->generateUrl('ksiazka_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new Ksiazka entity.
     *
     * @Route("/new", name="ksiazka_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new Ksiazka();
        $form   = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a Ksiazka entity.
     *
     * @Route("/{id}", name="ksiazka_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:Ksiazka')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Ksiazka entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Ksiazka entity.
     *
     * @Route("/{id}/edit", name="ksiazka_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:Ksiazka')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Ksiazka entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
    * Creates a form to edit a Ksiazka entity.
    *
    * @param Ksiazka $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Ksiazka $entity)
    {
        $form = $this->createForm(new KsiazkaType(), $entity, array(
            'action' => $this->generateUrl('ksiazka_update', array('id' => $entity->getIsbn())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing Ksiazka entity.
     *
     * @Route("/{id}", name="ksiazka_update")
     * @Method("PUT")
     * @Template("AppBundle:Ksiazka:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
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
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Deletes a Ksiazka entity.
     *
     * @Route("/{id}", name="ksiazka_delete")
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
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('ksiazka_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
