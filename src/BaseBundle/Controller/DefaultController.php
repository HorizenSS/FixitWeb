<?php

namespace BaseBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('BaseBundle:Default:index.html.twig');
    }

    public function dashAction()
    {
        return $this->render('BaseBundle:Default:dash.html.twig');
    }
    public function sendNotificationAction(Request $request)
    {
        $manager = $this->get('mgilet.notification');
        $notif = $manager->generateNotification('Hello friend wiw');
        $notif->setMessage('Hello friend wass up');
        $notif->setLink('http://symfony.com/');
        $manager->addNotification($this->getUser(), $notif);

        // or the one-line method :
        //$manager->createNotification($this->getUser(), 'Notification subject','Some random text','http://google.fr');

        return $this->redirectToRoute('succes');
    }


    public function facturesAction()
    {
        $em = $this->getDoctrine()->getManager();
        $factures = $em->getRepository('CommandeBundle:Commandes')->byFacture($this->getUser());

        return $this->render('BaseBundle:fares:facture.html.twig', array('factures' => $factures));
    }


    public function facturesPDFAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $facture = $em->getRepository('CommandeBundle:Commandes')->findOneBy(array('user' => $this->getUser(),
            'valider' => 1,
            'id' => $id));

        if (!$facture) {
            $this->get('session')->getFlashBag()->add('error', 'Une erreur est survenue');
            return $this->redirect($this->generateUrl('facutres'));
        }

        $this->container->get('setNewFacture')->facture($facture)->Output('Facture.pdf');

        $response = new Response();
        $response->headers->set('Content-type' , 'application/pdf');

        return $response;
    }
}
