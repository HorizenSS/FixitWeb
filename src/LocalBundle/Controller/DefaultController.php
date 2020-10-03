<?php

namespace LocalBundle\Controller;
use Knp\Bundle\SnappyBundle\Snappy\Response\PdfResponse;

use LocalBundle\Repository\AnnonceRepository;
use LocalBundle\Entity\Annonce;
use LocalBundle\Entity\Local;
use LocalBundle\Entity\Rating;
use LocalBundle\Form\AnnonceType;
use LocalBundle\Form\LocalType;
use LocalBundle\Form\RatingType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use LocalBundle\Entity\SignalisationAnnonces;
use Symfony\Component\HttpFoundation\Response;
use Twilio\Rest\Client;


class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('LocalBundle:Default:index.html.twig');
    }

    public function succesAction()
    {
        return $this->render('LocalBundle:Default:succes.html.twig');
    }

    public function ajoutAction(Request $request)
    {
        $local = new Local();
        $form = $this->createForm(LocalType::class, $local);
        $form->handleRequest($request);
        $local->setProp($this->getUser());

                if ($form->isValid() ) { // suite au clic sur le bouton


                    $em = $this->getDoctrine()->getManager();

                    $em->persist($local);
                    $em->flush();
                    return $this->redirectToRoute('all_local',array('id' => $this->getUser()->getId()));
                }


        return $this->render('LocalBundle:Default:ajout_local.html.twig', array(

            "Form" => $form->createView()

        ));

    }

    public function locauxAction($id)
    {

        $em = $this->getDoctrine()->getManager();
        $locaux = $em->getRepository("LocalBundle:Local")->findBy(array('prop' => $id));
        return $this->render('LocalBundle:Default:all_local.html.twig', array(

            "locaux" => $locaux
        ));

    }

    public function deleteAction($id)
    {

        $em = $this->getDoctrine()->getManager();
        $local = $em->getRepository("LocalBundle:Local")->find($id);
        $em->remove($local);
        $em->flush();
        return $this->redirectToRoute('all_local',array('id' => $this->getUser()->getId()));

    }

    public function modifierAction(Request $request , $id)
    {
        $em = $this->getDoctrine()->getManager();
        $local = $em->getRepository("LocalBundle:Local")->find($id);
        $form = $this->createForm(LocalType::class, $local);
        $form->handleRequest($request);
        $local->setProp($this->getUser());

        if ($form->isValid()) { // suite au clic sur le bouton

            $em = $this->getDoctrine()->getManager();
            $em->persist($local);
            $em->flush();
            return $this->redirectToRoute('all_local',array('id' => $this->getUser()->getId()));
        }
        return $this->render('LocalBundle:Default:edit_local.html.twig', array(

            "Form" => $form->createView()

        ));

    }

    public function deleteAdminAction($id)
    {

        $em = $this->getDoctrine()->getManager();
        $local = $em->getRepository("LocalBundle:Local")->find($id);
        $em->remove($local);
        $em->flush();
        $em = $this->getDoctrine()->getManager();
        $locaux = $em->getRepository("LocalBundle:Local")->findAll();
        return $this->render('LocalBundle:Default:all_localAdmin.html.twig', array(

            "locaux" => $locaux
        ));

    }

    public function testAction(Request $request , $id)
    {
        $em = $this->getDoctrine()->getManager();
        $local = $em->getRepository("LocalBundle:Local")->find($id);
        $form = $this->createForm(LocalType::class, $local);
        $form->handleRequest($request);
        $local->setProp($this->getUser());
        $em = $this->getDoctrine()->getManager();
        $locaux = $em->getRepository("LocalBundle:Local")->findAll();
        if ($form->isValid()) { // suite au clic sur le bouton

            $em = $this->getDoctrine()->getManager();
            $em->persist($local);
            $em->flush();
            return $this->render('LocalBundle:Default:all_localAdmin.html.twig', array(

                "locaux" => $locaux
            ));
        }

        return $this->render('LocalBundle:Default:edit_localAdmin.html.twig', array(

            "Form" => $form->createView()

        ));

    }


    public function addAction(Request $request)
    {
        $annonce = new Annonce();
        $form = $this->createForm(AnnonceType::class, $annonce);
        $form->handleRequest($request);
        $annonce->setIdProp($this->getUser());
        $annonce->setInsertdate(new \DateTime('today') );
        $annonce->setOwner($this->getUser()->getUsername());


        if ($form->isValid()) {
            // suite au clic sur le bouton

            $file = $annonce->getImage();
            $fileName = md5(uniqid()) . '.' . $file->guessExtension();
            $annonce->setImage($fileName);
            $file->move(
                $this->getParameter('user_directory'),
                $fileName
            );
            $em = $this->getDoctrine()->getManager();
            $em->persist($annonce);
            $em->flush();
            return $this->redirectToRoute('succes');
        }
        return $this->render('LocalBundle:Default:add_annonce.html.twig', array(

            "Form" => $form->createView()

        ));

    }

    public function mes_annoncesAction($id)
    {

        $em = $this->getDoctrine()->getManager();
        $annonces = $em->getRepository("LocalBundle:Annonce")->findBy(array('id_prop' => $id));
        return $this->render('LocalBundle:Default:mes_annonces.html.twig', array(

            "annonces" => $annonces
        ));

    }




    public function edit_annonceAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $annonce = $em->getRepository("LocalBundle:Annonce")->find($id);

        $form = $this->createForm(AnnonceType::class, $annonce);
        $form->handleRequest($request);
        $annonce->setIdProp($this->getUser());


        if ($form->isValid()) {
            // suite au clic sur le bouton

            $file = $annonce->getImage();
            $fileName = md5(uniqid()) . '.' . $file->guessExtension();
            $annonce->setImage($fileName);
            $annonce->setApprouve(false);
            $file->move(
                $this->getParameter('user_directory'),
                $fileName
            );
            $em = $this->getDoctrine()->getManager();
            $em->persist($annonce);
            $em->flush();
            return $this->redirectToRoute('succes');

        }
        return $this->render('LocalBundle:Default:edit_annonce.html.twig', array(

            "Form" => $form->createView()

        ));

    }
    public function delete_annonceAction($id)
    {

        $em = $this->getDoctrine()->getManager();
        $annonce = $em->getRepository("LocalBundle:Annonce")->find($id);


        $em->remove($annonce);
        $em->flush();
        $manager = $this->get('mgilet.notification');
        $guest= $this->getUser()->getUsername();

        $notif = $manager->createNotification('Salut' .$guest);
        $notif->setMessage('Votre Annonce a ete suppriméé ');
        $notif->setLink('http://symfony.com/');
        $manager->addNotification($this->getUser(), $notif);

        return $this->redirectToRoute('mes_annonces',array('id' => $this->getUser()->getId()));

    }
    public function delete_annonceAdAction($id)
    {

        $em = $this->getDoctrine()->getManager();
        $annonce = $em->getRepository("LocalBundle:Annonce")->find($id);


        $em->remove($annonce);
        $em->flush();
        $manager = $this->get('mgilet.notification');
        $guest= $this->getUser()->getUsername();

        $notif = $manager->createNotification('Salut' .$guest);
        $notif->setMessage('Votre Annonce a ete suppriméé ');
        $notif->setLink('http://symfony.com/');
        $manager->addNotification($this->getUser(), $notif);
        $em = $this->getDoctrine()->getManager();
        $annonces = $em->getRepository("LocalBundle:Annonce")->findAll();
        return $this->render('LocalBundle:Default:admin.html.twig', array(

            "annonces" => $annonces
        ));

    }

    public function annonce_allAction(Request $request)
    {

        $em = $this->getDoctrine()->getManager();
        $annonces = $em->getRepository("LocalBundle:Annonce")->findAll();
        $paginator=$this->get('knp_paginator');
        $annonces=$paginator->paginate(
            $annonces,
            $request->query->getInt('page',1),
            $request->query->getInt('page',4)
        );

        return $this->render('LocalBundle:Default:annonces_all.html.twig', array(

            "annonces" => $annonces
        ));

    }

    public function annoncesAdminAction()
    {

        $em = $this->getDoctrine()->getManager();
        $annonces = $em->getRepository("LocalBundle:Annonce")->findAll();
        return $this->render('LocalBundle:Default:admin.html.twig', array(

            "annonces" => $annonces
        ));

    }
    public function localAdminAction()
    {

        $em = $this->getDoctrine()->getManager();
        $locaux = $em->getRepository("LocalBundle:Local")->findAll();
        return $this->render('LocalBundle:Default:all_localAdmin.html.twig', array(

            "locaux" => $locaux
        ));

    }


    public function mapAction()
    {
        return $this->render('LocalBundle:Default:map.html.twig');
    }


    public function singleAction(Request $request ,$id)
    {
        $rate = new Rating();
        $okk = 0;

        $form = $this->createForm(RatingType::class, $rate);
        $form->handleRequest($request);
        $user = $this->container->get('security.token_storage')->getToken()->getUser();
        $em1 = $this->getDoctrine()->getManager();
        $signaler=$em1->getRepository("LocalBundle:SignalisationAnnonces")->DejaSignaler($user,$request->get('id'));
        if(!$signaler){$result="false";}else{$result="true";}
        $em = $this->getDoctrine()->getManager();
        $annonce = $em->getRepository("LocalBundle:Annonce")->find($id);

        $koko = $em->getRepository('LocalBundle:Rating')->findOneBy(array('user' => $this->getUser(), 'annonce' => $annonce));
        if (!empty($koko)) {
            $okk = 1;
            $rate = $koko;
        }


        if ($form->isSubmitted()) {

            if (!$this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_FULLY')) {
                throw $this->createAccessDeniedException();

            }
            $rate0 = $form->get('rating')->getData();
            $rate->setUser($this->getUser());
            $rate->setAnnonce($annonce);
            $rate->setRating($rate0);
            $em->persist($rate);
            $em->flush();
            $okk = 1;

        }
            return $this->render('LocalBundle:Default:single.html.twig', array(

                "annonce" => $annonce,
                'rate' => $rate,
                'form' => $form->createView(),
                'okk' => $okk,
                "signaler"=>$result
            ));



    }

    public function pdfAction(Request $request){


        $user=$this->getUser();
        $id=$request->get("id");
        $em=$this->getDoctrine()->getManager();
        $annonce=$em->getRepository("LocalBundle:Annonce")->find($id);
        $snappy = $this->get('knp_snappy.pdf');
        $html = $this->renderView('LocalBundle:Default:pdf.html.twig',array(
            'annonce'=>$annonce,
            'user'=>$user
        ));

        $filename = 'myFirstSnappyPDF';

        return new Response(
            $snappy->getOutputFromHtml($html), 200, array(
                'Content-Type' => 'application/pdf',
                'Content-Disposition' => 'inline; filename="' . $filename . '.pdf"')
        );
    }

    public function signalerAction(Request $Request)
    { $manager = $this->get('mgilet.notification');
        $guest= $this->getUser()->getUsername();
        $notif = $manager->createNotification('Salut' .$guest);
        $notif->setMessage('Nous prendrons en consideration votre geste  ');
        $notif->setLink('http://symfony.com/');
        $manager->addNotification($this->getUser(), $notif);
        $securityContext = $this->container->get('security.authorization_checker');
        if($securityContext->isGranted('IS_AUTHENTICATED_FULLY'))
        {
            $annonces= new Annonce();
            $em = $this->getDoctrine()->getManager();


            $annonces = $em->getRepository("LocalBundle:Annonce")->findOneById($Request->get('id'));


            if($annonces->getNbrSignal()==5)
            {
                $em->remove($annonces);
            }
            else
            {
                $em1 = $this->getDoctrine()->getManager();
                $signalisation= new SignalisationAnnonces();
                $user = $this->container->get('security.token_storage')->getToken()->getUser();
                $signalisation->setIdAnnonce($annonces);
                $signalisation->setIdUser($user);
                $em1->persist($signalisation);
                $em1->flush();

                $annonces->setNbrSignal($annonces->getNbrSignal()+1);
                $em->persist($annonces);
            }
            $em->flush();

            return $this->redirectToRoute('annonce_all');
        }
        else
        {return $this->redirectToRoute('annonce_all');}

    }//end signalerAction



    public function ApprouverAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $annonce = $em->getRepository('LocalBundle:Annonce')->findOneBy(array('id'=>$id));
        $annonce->setApprouve(true);
        $em->merge($annonce);
        $em->flush();
        return $this->redirectToRoute('annonce_all');
    }


    public function annoncesAdAction()
    {

        $em = $this->getDoctrine()->getManager();
        $annonces = $em->getRepository("LocalBundle:Annonce")->findAll();

        return $this->render('LocalBundle:Default:mes_annonces.html.twig', array(

            "annonces" => $annonces
        ));

    }


    public function archieveAction(Request $request){
        $em=$this->getDoctrine()->getManager();
        $approuve=1;
        $annonces=$em->getRepository(Annonce::class)->TrierAnnoncesExpire($approuve);
        $paginator=$this->get('knp_paginator');
        $annonces=$paginator->paginate(
            $annonces,
            $request->query->getInt('page',1),
            $request->query->getInt('page',4)
        );
        return $this->render('LocalBundle:Default:admin.html.twig',array('annonces'=>$annonces));
    }

    public function updatedAction(Request $request){
        $user=$this->getUser();
        if ($request->isXmlHttpRequest()) {
            $nom = $request->get('nom');
            $em = $this->getDoctrine()->getManager();
            $E = $em->getRepository("LocalBundle:Annonce")->findEventDQL($nom);
            $ser = new Serializer(array(new ObjectNormalizer()));
            $data = $ser->normalize($E);
            return new JsonResponse($data);
        }
        return $this->render('LocalBundle:Default:recherche.html.twig', array(
        ));
    }

    public function edit_annonceAdAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $annonce = $em->getRepository("LocalBundle:Annonce")->find($id);

        $form = $this->createForm(AnnonceType::class, $annonce);
        $form->handleRequest($request);
        $annonce->setIdProp($this->getUser());


        if ($form->isValid()) {
            // suite au clic sur le bouton

            $file = $annonce->getImage();
            $fileName = md5(uniqid()) . '.' . $file->guessExtension();
            $annonce->setImage($fileName);
            $annonce->setApprouve(false);
            $file->move(
                $this->getParameter('user_directory'),
                $fileName
            );
            $em = $this->getDoctrine()->getManager();
            $em->persist($annonce);
            $em->flush();
            $em = $this->getDoctrine()->getManager();
            $annonces = $em->getRepository("LocalBundle:Annonce")->findAll();

            return $this->render('LocalBundle:Default:admin.html.twig', array(

                "annonces" => $annonces
            ));


        }
        return $this->render('LocalBundle:Default:edit_annonceAd.html.twig', array(

            "Form" => $form->createView()

        ));

    }
    public function affichAnnonceAction(Request $request){

        //créer une instance de notre entity  manager
        $em=$this->getDoctrine()->getManager();


        $Annonce=$em->getRepository("LocalBundle:Annonce")->findBy(array(

            'type'=>'offre'));
        if ($request->isMethod("POST")) {
            if ($request->isXmlHttpRequest()) {
                $serializer = new Serializer(
                    array(
                        new ObjectNormalizer()
                    )
                );
                $annonce = $em->getRepository("LocalBundle:Annonce")
                    ->findannonceAjax($request->get('prixx'),$request->get('prixx'));

                //print_r($modeles);
                $data = $serializer->normalize($annonce);
                return new JsonResponse($data);

            }
        }
        return $this->render("LocalBundle:Default:annonces_all.html.twig",
            array(
                'annonces'=>$Annonce

            ));

    }



    public function smsAction()
    {
        /** @var \Twilio\Rest\Client */
        $twilio = $this->get('twilio.client');

        $date = date('r');

        $message = $twilio->messages->create(
            '+21650693720', // Text any number
            array(
                'from' => '+21650693720', // From a Twilio number in your account
                'body' => "Hi there, it's $date and Twilio is working properly."
            )
        );

        return new Response("Sent message [$message->sid] via Twilio.");
    }

    /**
     * @Route("/send-notification", name="send_notification")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function sendNotification(Request $request)
    {
        $manager = $this->get('mgilet.notification');
        $notif = $manager->createNotification('Hello world !');
        $notif->setMessage('This a notification.');
        $notif->setLink('http://symfony.com/');
        // or the one-line method :
        // $manager->createNotification('Notification subject','Some random text','http://google.fr');

        // you can add a notification to a list of entities
        // the third parameter ``$flush`` allows you to directly flush the entities
        $manager->addNotification(array($this->getUser()), $notif, true);

        return $this->redirectToRoute('succes');
    }

    public function recherchefAction(Request $request)
    {
        $nomS=$request->request->get('recherche');
        $em = $this->getDoctrine()->getManager();

        $annonces = $em->getRepository("LocalBundle:Annonce")->findBy(array("nom"=>$nomS));

        return $this->render('LocalBundle:Default:admin.html.twig', array(
            'annonces' => $annonces,
        ));

    }



    public function ajax_searchAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $requestString = $request->get('q');
        $entities =  $em->getRepository('LocalBundle:Annonce')->findEntitiesByString($requestString);
        if(!$entities) {
            $result['entities']['error'] = "erreur";
        } else {
            $result['entities'] = $this->getRealEntities($entities);
        }
        return new Response(json_encode($result));
    }
    public function getRealEntities($entities){
        foreach ($entities as $entity){
            $realEntities[$entity->getId()] = $entity->getNom();
        }
        return $realEntities;
    }
}
