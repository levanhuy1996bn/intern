<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Product;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints\DateTime;
use Symfony\Component\Validator\Tests\Fixtures\Entity;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class DefaultController extends Controller
{
    /**
     * @Route("/create")
     */
    public function createAction(){
        $entityManager = $this->getDoctrine()->getManager();
        $product = new Product();
        $product->setName('Skirt');
        $now = new \DateTime('2016/01/01');
        $product->setCreated($now);
        $entityManager->persist($product);
        $entityManager->flush();
        return new Response('Saved new product with id '.$product->getId());
    }
    /**
     * @Route("/show/all", name="show_off")
     */
    public function showAction(){
        $product = $this->getDoctrine()->getRepository(Product::class)->findAll();
            return $this->render('showproduct.html.twig',array('product' => $product));
    }
    /**
     * @Route("/show/new", name="create_new")
     * Method({"GET","POST"})
     */
    public function addProduct(Request $request)
    {
        $product = new Product();
        $form = $this->createFormBuilder($product)
            ->add('name', TextType::class, array("attr" => array("pattern" => ".{10,100}")))
            ->add('save', SubmitType::class, array("attr"=>array('lable' => "Create")))->getForm();
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $product = $form->getData();
            $time = new \DateTime();
            $product->setCreated($time);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($product);
            $entityManager->flush();
            return $this->redirectToRoute("show_off");

        }
        return $this->render('addproduct.html.twig', array("form" => $form->createView()));
    }
    /**
     * @Route("/show/delete/{id}")
     * method({"DELETE"})
     */
    public function deleteProduct(Request $request, $id){
        $product = $this->getDoctrine()->getRepository(Product::class)->find($id);
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($product);
        $entityManager->flush();
        $respone = new Response();
        $respone->send();
    }
    /**
     * @Route("/show/edit/{id}", name="edit_product")
     * Method({"GET","POST"})
     */
    public function editProduct(Request $request, $id){
        $product = new Product();
        $product = $this->getDoctrine()->getRepository(Product::class)->find($id);
        //return $this->render('editproduct.html.twig', array("product" => $product));
        $form = $this->createFormBuilder($product)
            ->add('name', TextType::class, array("attr" => array("pattern" => ".{10,100}")))
            ->add('created', DateTimeType::class)
            ->add('save', SubmitType::class, array("attr"=>array('lable' => "Update")))->getForm();
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            //$product = $form->getData();
            $time = new \DateTime();
            $product->setCreated($time);
            $entityManager = $this->getDoctrine()->getManager();
            //$entityManager->persist($product);
            $entityManager->flush();
            return $this->redirectToRoute("show_off");

        }
        return $this->render('editproduct.html.twig', array("form" => $form->createView()));
    }
}