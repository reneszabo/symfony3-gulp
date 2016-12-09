<?php

namespace AppBundle\Controller;

use AppBundle\Entity\ContactMe;
use AppBundle\Form\ContactMeType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
  /**
   * @Route("/", name="homepage")
   */
  public function indexAction(Request $request)
  {
    $contacts = $this->getDoctrine()->getRepository('AppBundle:ContactMe')->findBy([],['createdAt'=>'desc'],6);
    $contactMe = new ContactMe();
    $form = $this->createForm(ContactMeType::class, $contactMe);
    $form->add('submit', SubmitType::class, array(
      'label' => 'Create',
      'attr'  => array('class' => 'btn btn-default pull-right')
    ));
    $form->handleRequest($request);
    if ($form->isSubmitted() && $form->isValid()) {
      $em = $this->getDoctrine()->getManager();
      $em->persist($contactMe);
      $em->flush();

      $message = \Swift_Message::newInstance()
        ->setSubject('Testing a Thank You Email')
        ->setFrom('hello@aviro.io')
        ->setTo($contactMe->getUsername())
        ->setBody(
          $this->renderView(
            'AppBundle:email:thanks.html.twig',
            []
          ),
          'text/html'
        )
        ->addPart(
          $this->renderView(
            'AppBundle:email:thanks.txt.twig',
            []
          ),
          'text/plain'
        )
      ;
      $this->get('mailer')->send($message);


      $this->addFlash('success', 'What an awesome message !');
      return $this->redirect( $this->generateUrl('homepage', [] ));
    }

    return $this->render( 'AppBundle:default:index.html.twig', ['form'=> $form->createView(), 'contacts' => $contacts ]);
  }
}
