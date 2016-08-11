<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use AppBundle\Entity\Kategoria;
use AppBundle\Form\KategoriaType;

/**
 * Kategoria controller.
 *
 * @Route("/kategoria")
 */
class KategoriaController extends Controller
{

    /**
     * Lists all Kategoria entities.
     *
     * @Route("/", name="kategoria")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('AppBundle:Kategoria')->findAll();

        return array(
            'entities' => $entities,
        );
    }
//     * @Route("/admin/create", name="kategoria_create")
    /**
     * Creates a new Kategoria entity.
     *
     * @Route(name="kategoria_create")
     * @Method("POST")
     * @Template("AppBundle:Kategoria:new.html.twig")
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

            return $this->redirect($this->generateUrl('kategoria_show', array('id' => $entity->getIdkategoria())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Creates a form to create a Kategoria entity.
     *
     * @param Kategoria $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Kategoria $entity)
    {
        $form = $this->createForm(new KategoriaType(), $entity, array(
            'action' => $this->generateUrl('kategoria_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Dodaj'));

        return $form;
    }

    /**
     * Displays a form to create a new Kategoria entity.
     *
     * @Route("/admin/new", name="kategoria_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new Kategoria();
        $form   = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a Kategoria entity.
     *
     * @Route("/{id}", name="kategoria_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:Kategoria')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Nie można znaleźć kategorii.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $ksiazki = $em->getRepository('AppBundle:Ksiazka')
                ->findBy(array('idkategoria' => $id));
        
        return array(
            'entity'      => $entity,
            'ksiazki'     => $ksiazki,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Kategoria entity.
     *
     * @Route("/admin/{id}/edit", name="kategoria_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:Kategoria')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Nie można znaleźć kategorii.');
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
    * Creates a form to edit a Kategoria entity.
    *
    * @param Kategoria $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Kategoria $entity)
    {
        $form = $this->createForm(new KategoriaType(), $entity, array(
            'action' => $this->generateUrl('kategoria_update', array('id' => $entity->getIdkategoria())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Zaktualizuj'));

        return $form;
    }
    /**
     * Cwaniackie zabezpieczenie by adresy /admin/xxxxxxx wyświetlały mój nadpisany error, a nie brzydki komunikat "No route found for "GET /kategoria/admin/xxxxxx"" 
     *
     * @Route("/admin/{szatan}")
     */    
    public function pageNotFoundAction($szatan)
    {
        throw $this->createNotFoundException('Strona .../kategoria/admin/'.$szatan.' nie istnieje');
    }
    
    
    
    /**
     * Edits an existing Kategoria entity.
     *
     * @Route("/admin/{id}/edits", name="kategoria_update")
     * @Method("PUT")
     * @Template("AppBundle:Kategoria:edit.html.twig")
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

            return $this->redirect($this->generateUrl('kategoria_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Deletes a Kategoria entity.
     *
     * @Route("/admin/{id}/deletes", name="kategoria_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
//        $em = $this->getDoctrine()->getManager();
//        $entity = $em->getRepository('AppBundle:Kategoria')->find($id);
//        if (!$entity) {
//            throw $this->createNotFoundException('Nie można znaleźć kategorii.');
//        }
        
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
//            } catch (\PDOException $pdo_ex) {
            } catch (\Doctrine\DBAL\DBALException $pdo_ex) {
//            } catch (\Exception $pdo_ex) {
                throw $this->createNotFoundException("Próbujesz usunąć kategorię, do której przypisane są istniejące książki. Najpierw usuń te książki.\n\n\n\nOryginalna treść błędu PDOException: \n\n".$pdo_ex->getMessage().''.(int)$pdo_ex->getCode());
            }

        }

        return $this->redirect($this->generateUrl('kategoria'));
    }

    /**
     * Creates a form to delete a Kategoria entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('kategoria_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Usuń'))
            ->getForm()
        ;
    }
}
