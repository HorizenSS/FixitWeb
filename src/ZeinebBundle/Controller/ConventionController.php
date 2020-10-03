<?php

namespace ZeinebBundle\Controller;

use ZeinebBundle\Entity\Convention;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Convention controller.
 *
 */
class ConventionController extends Controller
{

    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $conventions = $em->getRepository('ZeinebBundle:Convention')->findBy(array("status"=>"accepted"));

        return $this->render('@Zeineb/convention/index.html.twig', array(
            'conventions' => $conventions,
        ));
    }

    public function conventionTecAction()
    {
        $user = $this->container->get('security.token_storage')->getToken()->getUser();
        $convention=$user->getConvention();

        if ($convention != null)
        {
            return  $this->redirectToRoute("convention_show",['id'=>$user->getConvention()->getId()]);

        }

        return  $this->redirectToRoute("convention_new");


    }

    public function indexAdminAction()
    {
        $em = $this->getDoctrine()->getManager();

        $conventions = $em->getRepository('ZeinebBundle:Convention')->findAll();

        return $this->render('@Zeineb/convention/indexA.html.twig', array(
            'conventions' => $conventions,
        ));
    }

    public function indexPendingAdminAction()
    {
        $em = $this->getDoctrine()->getManager();

        $conventions = $em->getRepository('ZeinebBundle:Convention')->findBy(array("status"=>"pending"));

        return $this->render('@Zeineb/convention/indexA.html.twig', array(
            'conventions' => $conventions,
        ));
    }

    public function indexAcceptedAdminAction()
    {
        $em = $this->getDoctrine()->getManager();

        $conventions = $em->getRepository('ZeinebBundle:Convention')->findBy(array("status"=>"accepted"));

        return $this->render('@Zeineb/convention/indexA.html.twig', array(
            'conventions' => $conventions,
        ));
    }
    public function indexRefusedAdminAction()
    {
        $em = $this->getDoctrine()->getManager();

        $conventions = $em->getRepository('ZeinebBundle:Convention')->findBy(array("status"=>"refused"));

        return $this->render('@Zeineb/convention/indexA.html.twig', array(
            'conventions' => $conventions,
        ));
    }

    public function newAction(Request $request)
    {
        $convention = new Convention();
        $form = $this->createForm('ZeinebBundle\Form\ConventionType', $convention);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $file = $convention->getImgUrl();
            $filename = md5(uniqid()).'.'.$file->guessExtension();
            $file->move($this->getParameter('img_directory'),$filename);
            $convention->setImgUrl($filename);
            $em = $this->getDoctrine()->getManager();
            try {
                $convention->setCreatedAt(new \DateTime());} catch (\Exception $e) {
            }
            $user = $this->container->get('security.token_storage')->getToken()->getUser();
            $user->setConvention($convention);
            $convention->setUser($user);
            $convention->setStatus("pending");
            $em->persist($convention);
            $em->persist($user);
            $em->flush();

            return $this->redirectToRoute('convention_show', array('id' => $convention->getId()));
        }

        return $this->render('@Zeineb/convention/new.html.twig', array(
            'convention' => $convention,
            'form' => $form->createView(),
        ));
    }

    public function rechercheParSocAction(Request $request)
    {
        $nomS=$request->request->get('recherche');
        $em = $this->getDoctrine()->getManager();

        $conventions = $em->getRepository('ZeinebBundle:Convention')->findBy(array("nomSoc"=>$nomS));

        return $this->render('@Zeineb/convention/indexA.html.twig', array(
            'conventions' => $conventions,
        ));

    }

    public function showAction(Convention $convention)
    {

        return $this->render('@Zeineb/convention/show.html.twig', array(
            'convention' => $convention,
        ));
    }


    public function editAction(Request $request, Convention $convention)
    {
        $editForm = $this->createForm('ZeinebBundle\Form\ConventionType', $convention);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $file = $convention->getImgUrl();
            $filename = md5(uniqid()).'.'.$file->guessExtension();
            $file->move($this->getParameter('img_directory'),$filename);
            $convention->setImgUrl($filename);
            $convention->setStatus("pending");
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('convention_show', array('id' => $convention->getId()));
        }

        return $this->render('@Zeineb/convention/edit.html.twig', array(
            'convention' => $convention,
            'edit_form' => $editForm->createView(),
        ));
    }

    public function acceptConventionAction( $id)
    {
        $em = $this->getDoctrine()->getManager();

        $convention = $em->getRepository('ZeinebBundle:Convention')->find($id);
        $convention->setStatus("accepted");
        $em->persist($convention);
        $em->flush();

        return $this->redirectToRoute('convention_show', array('id' => $convention->getId()));

    }

    public function refuserConventionAction( $id)
    {
        $em = $this->getDoctrine()->getManager();

        $convention = $em->getRepository('ZeinebBundle:Convention')->find($id);
        $convention->setStatus("refused");
        $em->persist($convention);
        $em->flush();

        return $this->redirectToRoute('convention_show', array('id' => $convention->getId()));

    }


    public function deleteConventionAction( $id)
    {
        $em = $this->getDoctrine()->getManager();

        $convention = $em->getRepository('ZeinebBundle:Convention')->find($id);
        $em->remove($convention);
        $em->flush();

        return $this->redirectToRoute('convention_index');

    }




}
