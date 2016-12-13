<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Disponibilidad;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Disponibilidad controller.
 *
 * @Route("pers/disponibilidad")
 */
class DisponibilidadController extends Controller
{
    /**
     * Lists all disponibilidad entities.
     *
     * @Route("/", name="pers_disponibilidad_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $disponibilidads = $em->getRepository('AppBundle:Disponibilidad')->findAll();

        return $this->render('disponibilidad/index.html.twig', array(
            'disponibilidads' => $disponibilidads,
        ));
    }

    /**
     * Creates a new disponibilidad entity.
     *
     * @Route("/new", name="pers_disponibilidad_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $opcionid = $request->get('id');
        $negocioId = $request->get('idnegocio');


        $disponibilidad = new Disponibilidad();
        $form = $this->createForm('AppBundle\Form\DisponibilidadType', $disponibilidad);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($disponibilidad);
            $em->flush($disponibilidad);

            $opciones = $em->getRepository('AppBundle:Opcion')->findByopciones($negocioId );


            return $this->render('opcion/index.html.twig', array(
                'opcions' => $opciones,
                'negocioid'=>$negocioId,
            ));

//            return $this->redirectToRoute('pers_disponibilidad_show', array('id' => $disponibilidad->getId()));
        }
        $opcion =   $product = $this->getDoctrine()
            ->getRepository('AppBundle:Opcion')
            ->find($opcionid);

        $form->get('opcion')->setData($opcion);

        return $this->render('disponibilidad/new.html.twig', array(
            'disponibilidad' => $disponibilidad,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a disponibilidad entity.
     *
     * @Route("/{id}", name="pers_disponibilidad_show")
     * @Method("GET")
     */
    public function showAction(Disponibilidad $disponibilidad)
    {
        $deleteForm = $this->createDeleteForm($disponibilidad);

        return $this->render('disponibilidad/show.html.twig', array(
            'disponibilidad' => $disponibilidad,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing disponibilidad entity.
     *
     * @Route("/{id}/edit", name="pers_disponibilidad_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Disponibilidad $disponibilidad)
    {
        $deleteForm = $this->createDeleteForm($disponibilidad);
        $editForm = $this->createForm('AppBundle\Form\DisponibilidadType', $disponibilidad);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('pers_disponibilidad_edit', array('id' => $disponibilidad->getId()));
        }

        return $this->render('disponibilidad/edit.html.twig', array(
            'disponibilidad' => $disponibilidad,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a disponibilidad entity.
     *
     * @Route("/{id}", name="pers_disponibilidad_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Disponibilidad $disponibilidad)
    {
        $form = $this->createDeleteForm($disponibilidad);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($disponibilidad);
            $em->flush($disponibilidad);
        }

        return $this->redirectToRoute('pers_disponibilidad_index');
    }

    /**
     * Creates a form to delete a disponibilidad entity.
     *
     * @param Disponibilidad $disponibilidad The disponibilidad entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Disponibilidad $disponibilidad)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('pers_disponibilidad_delete', array('id' => $disponibilidad->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }

    /**
     * Creates a new opcion entity.
     *
     * @Route("/disponibilidad/", name="index_disponibilidad")
     * @Method({"GET", "POST"})
     * @param Request $request Request
     * @return Response
     *
     */
    public function recurso(Request $request)
    {
        $idopcion = $request->get('idopcion');
        $em = $this->getDoctrine()->getManager();
        $disponibilidad = $em->getRepository('AppBundle:Disponibilidad')->findByopcion($idopcion );

        return $this->render('disponibilidad/index.html.twig', array(
            'disponibilidads' => $disponibilidad,
            'idopcion'=>$idopcion,
        ));

    }
}
