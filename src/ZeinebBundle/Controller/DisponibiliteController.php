<?php

namespace ZeinebBundle\Controller;

use Symfony\Component\Validator\Constraints\IsNull;
use ZeinebBundle\Entity\Disponibilite;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Disponibilite controller.
 *
 */
class DisponibiliteController extends Controller
{

    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $disponibilites = $em->getRepository('ZeinebBundle:Disponibilite')->findAll();

        return $this->render('@Zeineb/disponibilite/index.html.twig', array(
            'disponibilites' => $disponibilites,
        ));
    }
    public function disponibiliteTecAction()
    {
        $user = $this->container->get('security.token_storage')->getToken()->getUser();
        $em = $this->getDoctrine()->getManager();

        $user= $em->getRepository('UserBundle:User')->find($user->getId());
        $dispo=$user->getDisponibilite();
        dump($dispo);
        if ( $dispo !=null)
{
    return $this->redirectToRoute("disponibilite_show",['id'=>$user->getDisponibilite()->getId()]);

}
        return    $this->redirectToRoute("disponibilite_new");



    }


    public function newAction(Request $request)
    {
        $disponibilite = new Disponibilite();
        $form = $this->createForm('ZeinebBundle\Form\DisponibiliteType', $disponibilite);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $user = $this->container->get('security.token_storage')->getToken()->getUser();
            $user->setDisponibilite($disponibilite);
            $disponibilite->setUser($user);
            $em->persist($disponibilite);
            $em->persist($user);
            $em->flush();

            return $this->redirectToRoute('disponibilite_show', array('id' => $disponibilite->getId()));
        }

        return $this->render('@Zeineb/disponibilite/new.html.twig', array(
            'disponibilite' => $disponibilite,
            'form' => $form->createView(),
        ));
    }


    public function showAction(Disponibilite $disponibilite)
    {

        return $this->render('@Zeineb/disponibilite/show.html.twig', array(
            'disponibilite' => $disponibilite,
        ));
    }


    public function editAction(Request $request, Disponibilite $disponibilite)
    {
        $editForm = $this->createForm('ZeinebBundle\Form\DisponibiliteType', $disponibilite);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('disponibilite_show', array('id' => $disponibilite->getId()));
        }

        return $this->render('@Zeineb/disponibilite/edit.html.twig', array(
            'disponibilite' => $disponibilite,
            'form' => $editForm->createView(),
        ));
    }

    public function deleteAction( $id)
    {
        $em = $this->getDoctrine()->getManager();

        $dispo = $em->getRepository('ZeinebBundle:Disponibilite')->find($id);
        $em->remove($dispo);
        $em->flush();

        return $this->redirectToRoute('disponibilite_index');

    }




}
