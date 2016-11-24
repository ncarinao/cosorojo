<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Rubro;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Rubro controller.
 *
 * @Route("admin/rubro")
 */
class RubroController extends Controller
{
    /**
     * Lists all rubro entities.
     *
     * @Route("/", name="admin_rubro_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $rubros = $em->getRepository('AppBundle:Rubro')->findAll();

        return $this->render('rubro/index.html.twig', array(
            'rubros' => $rubros,
        ));
    }

    /**
     * Creates a new rubro entity.
     *
     * @Route("/new", name="admin_rubro_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $rubro = new Rubro();
        $form = $this->createForm('AppBundle\Form\RubroType', $rubro);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($rubro);
            $em->flush($rubro);

            return $this->redirectToRoute('admin_rubro_show', array('id' => $rubro->getId()));
        }

        return $this->render('rubro/new.html.twig', array(
            'rubro' => $rubro,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a rubro entity.
     *
     * @Route("/{id}", name="admin_rubro_show")
     * @Method("GET")
     */
    public function showAction(Rubro $rubro)
    {
        $deleteForm = $this->createDeleteForm($rubro);

        return $this->render('rubro/show.html.twig', array(
            'rubro' => $rubro,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing rubro entity.
     *
     * @Route("/{id}/edit", name="admin_rubro_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Rubro $rubro)
    {
        $deleteForm = $this->createDeleteForm($rubro);
        $editForm = $this->createForm('AppBundle\Form\RubroType', $rubro);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('admin_rubro_edit', array('id' => $rubro->getId()));
        }

        return $this->render('rubro/edit.html.twig', array(
            'rubro' => $rubro,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a rubro entity.
     *
     * @Route("/{id}", name="admin_rubro_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Rubro $rubro)
    {
        $form = $this->createDeleteForm($rubro);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($rubro);
            $em->flush($rubro);
        }

        return $this->redirectToRoute('admin_rubro_index');
    }

    /**
     * Creates a form to delete a rubro entity.
     *
     * @param Rubro $rubro The rubro entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Rubro $rubro)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('admin_rubro_delete', array('id' => $rubro->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
