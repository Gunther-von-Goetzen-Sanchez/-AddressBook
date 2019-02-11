<?php

namespace AppBundle\Controller;

use AppBundle\Entity\AddressBook;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

/**
 * Controller used to manage address book entries.
 *
 * @author Gunther von Goetzen Sanchez <info@appstelle.de>
 */
class AddressBookController extends AbstractController
{
    /**
     * @Route("/", methods={"GET"}, name="overview")
     * 
     * NOTE: the Method annotation is optional, but it's a recommended practice
     * to constraint the HTTP methods each controller responds to (by default
     * it responds to all methods).
     */
    public function indexAction(Request $request) :Response
    {
        $contact = $this->getDoctrine()->getRepository(AddressBook::class)->findAll();

        return $this->render('AddressBook/index.html.twig', array( 'contact' => $contact ));
    }

     /**
     * @Route("/add", methods={"GET", "POST"}, name="add")
     * 
     * This is the form to add a new entry to the address book.
     */
    public function addAction(Request $request) :Response
    {

        $entityManager = $this->getDoctrine()->getManager();
        
        $city = new AddressBook();
 
        $form = $this->createFormBuilder($city)
                    ->add('Firstname',TextType::class, array('attr' => array('class'=> 'form-control')))
                    ->add('Lastname',TextType::class, array('attr' => array('class'=> 'form-control')))
                    ->add('Street',TextType::class, array('attr' => array('class'=> 'form-control')))
                    ->add('Street',TextType::class, array('attr' => array('class'=> 'form-control')))
                    ->add('Zip',TextType::class, array('attr' => array('class'=> 'form-control')))
                    ->add('City',TextType::class, array('attr' => array('class'=> 'form-control')))
                    ->add('Country',TextType::class, array('attr' => array('class'=> 'form-control')))
                    ->add('Phonenumber',TextType::class, array('attr' => array('class'=> 'form-control')))
                    ->add('Birthday', DateType::class, array('years' => range(date('Y')-100, date('Y')), 'attr' => array('class'=> 'form-control')))
                    ->add('Email',TextType::class, array('attr' => array('class'=> 'form-control')))
                    ->add('Picture',TextType::class, array('required' => false, 'attr' => array('class'=> 'form-control', 'style' => 'margin-bottom:50px')))
       
                    ->add('save',SubmitType::class, array('attr' => array('class'=> 'btn btn-primary')))
                    ->getForm();

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
                     
            $data=$form->getData();

            $entityManager->persist($data);
            $entityManager->flush();
                
            $this->addFlash(
                'message',
                'New contact has successfully been added!'
            );

            return $this->redirectToRoute('overview');
        }

        return $this->render('AddressBook/add.html.twig', array('form' => $form->createView()));
    }

     /**
     * @Route("/delete/{id}", methods={"GET"}, name="delete", requirements={"id"="\d+"})
     * 
     * This controller is called by the delete button. Requires the "id" of the entry. 
     */
    public function deleteAction(Request $request , $id) :Response
    {

        $city = $this->getDoctrine()->getRepository(AddressBook::class)->find($id);
        
        if($city){
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($city);
            $entityManager->flush();    
        }

        $this->addFlash(
        'message',
        'Contact with the id: '. $id . ' has been successfully deleted!' 
        );

        return $this->redirectToRoute('overview');
    }

     /**
     * @Route("/edit/{id}", methods={"GET", "POST"}, name="edit", requirements={"id"="\d+"})
     * 
     * This controller implements the functionality to edit existing entries. Requires the "id" of the entry.  
     */
    public function editAction(Request $request, $id) :Response
    {
        
        $contact = new AddressBook();
        $contact = $this->getDoctrine()->getRepository(AddressBook::class)->find($id);

        $form = $this->createFormBuilder($contact)
        ->add('Firstname',TextType::class, array('attr' => array('class'=> 'form-control')))
        ->add('Lastname',TextType::class, array('attr' => array('class'=> 'form-control')))
        ->add('Street',TextType::class, array('attr' => array('class'=> 'form-control')))
        ->add('Street',TextType::class, array('attr' => array('class'=> 'form-control')))
        ->add('Zip',TextType::class, array('attr' => array('class'=> 'form-control')))
        ->add('City',TextType::class, array('attr' => array('class'=> 'form-control')))
        ->add('Country',TextType::class, array('attr' => array('class'=> 'form-control')))
        ->add('Phonenumber',TextType::class, array('attr' => array('class'=> 'form-control')))
        ->add('Birthday', DateType::class, array('years' => range(date('Y')-100, date('Y')), 'attr' => array('class'=> 'form-control')))
        ->add('Email',TextType::class, array('attr' => array('class'=> 'form-control')))
        ->add('Picture',TextType::class, array('required' => false, 'attr' => array('class'=> 'form-control', 'style' => 'margin-bottom:50px')))
       
        ->add('save', SubmitType::class, array('attr' => array('class'=> 'btn btn-primary')))
        ->getForm();

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            
            $entityManager = $this->getDoctrine()->getManager();

            $entityManager->flush();

            $this->addFlash(
                'message',
                'Contact with the id: '. $id .' has been successfully edited!'
            );

            return $this->redirectToRoute('overview');
        }
      
        return $this->render('AddressBook/edit.html.twig' , array('form' => $form->createView()));
        
    }
}
