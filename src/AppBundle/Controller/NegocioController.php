<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Personal;
use AppBundle\Entity\Negocio;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;


/**
 * Negocio controller.
 *
 * @Route("pers/negocio/")
 */
class NegocioController extends Controller
{
    /**
     * Lists all negocio entities.
     *
     * @Route("/", name="pers_negocio_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $negocios = $em->getRepository('AppBundle:Negocio')->findAll();

        return $this->render('negocio/index.html.twig', array(
            'negocios' => $negocios,
        ));
    }

    /**
     * Creates a new negocio entity.
     *
     * @Route("new", name="pers_negocio_new")
     * @Method({"GET", "POST"})
     * @param Request $request Request
     * @return Response
     *
     */
    public function newAction(Request $request)
    {
//        $rubroId = $request->get('rubroID');

        $negocio = new Negocio();
        $form = $this->createForm('AppBundle\Form\NegocioType', $negocio);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($negocio);
            $em->flush($negocio);



//            $idnegocio=( int )$negocio->getId();
//            $userid = ( int )$this->getUser()->getId();
////            echo $userid;
////            exit();
//
//            $personal = new Personal();
//            $personal->setNegocio(1);
//            $personal->setUser(3);
//
//            $em = $this->getDoctrine()->getManager();
//            $em->persist($personal);
//            $em->flush();
//


//            $userid = $this->getUser()->getId();
//            $personal =   $product = $this->getDoctrine()
//                ->getRepository('AppBundle:Personal');
//            $form->get('id')->setData($negocio);
//            $form->get('user')->setData($userid);
//            $form->get('negocio')->setData($negocio);



//            return $this->render('default/paso2.html.twig', array(
//                'negocioid' => $negocio,
//            ));
//            return $this->redirectToRoute('', array('id' => $negocio->getId()));

            // Recogemos el fichero
            $file=$form['negFoto1']->getData();

// Sacamos la extensión del fichero
            $ext=$file->guessExtension();
// Le ponemos un nombre al fichero
            $file_name=time().".".$ext;

// Guardamos el fichero en el directorio uploads que estará en el directorio /web del framework
            $file->move("uploads", $file_name);

// Establecemos el nombre de fichero en el atributo de la entidad

            $negocio->setNegFoto1($file_name);
            $em->persist($negocio);

            $flush = $em->flush();
            if ($flush == null) {
                echo "Post creado correctamente";
            } else {
                echo "El post no se ha creado";
            }

            return $this->redirectToRoute('pers_negocio_show', array('id' => $negocio->getId()));
        }

//        $opcion =   $product = $this->getDoctrine()
//            ->getRepository('AppBundle:Rubro')
//            ->find($rubroId);
//
//        $form->get('rubro')->setData($opcion);

        return $this->render('negocio/new.html.twig', array(
            'negocio' => $negocio,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a negocio entity.
     *
     * @Route("/{id}", name="pers_negocio_show")
     * @Method("GET")
     */
    public function showAction(Negocio $negocio)
    {
        $deleteForm = $this->createDeleteForm($negocio);

        return $this->render('negocio/show.html.twig', array(
            'negocio' => $negocio,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing negocio entity.
     *
     * @Route("/{id}/edit", name="pers_negocio_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Negocio $negocio)
    {
        $deleteForm = $this->createDeleteForm($negocio);
        $editForm = $this->createForm('AppBundle\Form\NegocioType', $negocio);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('pers_negocio_edit', array('id' => $negocio->getId()));
        }

        return $this->render('negocio/edit.html.twig', array(
            'negocio' => $negocio,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a negocio entity.
     *
     * @Route("/{id}", name="pers_negocio_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Negocio $negocio)
    {
        $form = $this->createDeleteForm($negocio);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($negocio);
            $em->flush($negocio);
        }

        return $this->redirectToRoute('pers_negocio_index');
    }

    /**
     * Creates a form to delete a negocio entity.
     *
     * @param Negocio $negocio The negocio entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Negocio $negocio)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('pers_negocio_delete', array('id' => $negocio->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }

    /**
     * Lists all negocio entities.
     *
     * @Route("publicar", name="publicar")
     * @Method("GET")
     */
    public function publicar()
    {
        $em = $this->getDoctrine()->getManager();

        $rubros = $em->getRepository('AppBundle:Rubro')->findAll();


        return $this->render(':default:publicar.html.twig', array(
            'rubros' => $rubros,
        ));

    }
    /**
     * Creates a new opcion entity.
     *
     * @Route("/paso2/", name="recurso")
     * @Method({"GET", "POST"})
     * @param Request $request Request
     * @return Response
     *
     */
    public function recurso(Request $request)
    {
        $negocioId = $request->get('idnegocio');
        $em = $this->getDoctrine()->getManager();
        $opciones = $em->getRepository('AppBundle:Opcion')->findByopciones($negocioId );
        
        return $this->render('opcion/index.html.twig', array(
            'opcions' => $opciones,
            'negocioid'=>$negocioId,
        ));

    }

}
