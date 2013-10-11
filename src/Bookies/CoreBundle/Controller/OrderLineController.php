<?php

namespace Bookies\CoreBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Bookies\CoreBundle\Entity\OrderLine;
use Bookies\CoreBundle\Form\OrderLineType;

/**
 * OrderLine controller.
 *
 * @Route("/order/line")
 */
class OrderLineController extends Controller
{

    /**
     * Lists all OrderLine entities.
     *
     * @Route("/", name="order_line")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('BookiesCoreBundle:OrderLine')->findAll();

        return array(
            'entities' => $entities,
        );
    }
    /**
     * Creates a new OrderLine entity.
     *
     * @Route("/", name="order_line_create")
     * @Method("POST")
     * @Template("BookiesCoreBundle:OrderLine:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity  = new OrderLine();
        $form = $this->createForm(new OrderLineType(), $entity);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('order_line_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Displays a form to create a new OrderLine entity.
     *
     * @Route("/new", name="order_line_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new OrderLine();
        $form   = $this->createForm(new OrderLineType(), $entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a OrderLine entity.
     *
     * @Route("/{id}", name="order_line_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('BookiesCoreBundle:OrderLine')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find OrderLine entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing OrderLine entity.
     *
     * @Route("/{id}/edit", name="order_line_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('BookiesCoreBundle:OrderLine')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find OrderLine entity.');
        }

        $editForm = $this->createForm(new OrderLineType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Edits an existing OrderLine entity.
     *
     * @Route("/{id}", name="order_line_update")
     * @Method("PUT")
     * @Template("BookiesCoreBundle:OrderLine:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('BookiesCoreBundle:OrderLine')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find OrderLine entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createForm(new OrderLineType(), $entity);
        $editForm->bind($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('order_line_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Deletes a OrderLine entity.
     *
     * @Route("/{id}", name="order_line_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('BookiesCoreBundle:OrderLine')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find OrderLine entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('order_line'));
    }

    /**
     * Creates a form to delete a OrderLine entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder(array('id' => $id))
            ->add('id', 'hidden')
            ->getForm()
        ;
    }
}
