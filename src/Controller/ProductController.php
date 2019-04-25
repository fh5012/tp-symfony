<?php 
namespace App\Controller;

use Symfony\Component\HttpFonudation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use App\Entity\Product;
class ProductController extends AbstractController{
    /**
     * @Route("/product",name="product_list")
     * @Method({"GET"})
     */
     public function index(){
        $entityManager = $this->getDoctrine()->getManager();
        $products = $this->getDoctrine()->getRepository(Product::class)->findAll();
        return $this->render('products/product.html.twig', array('products'=> $products));
    }

    /**
     * @Route("/product/delete/{id}")
     * @Method({"DELETE"})
     */
    public function delete(Request $request, $id) {
        $product = $this->getDoctrine()->getRepository(Product::class)->find($id);
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($product);
        $entityManager->flush();

        $response = new Response();
        $response->send();
    }


    /**
     * @Route("/product/add",name="new_add")
     * @Method({"GET", "POST"})
     */
     public function new(Request $request){
         $products = new Product();
         $form = $this->createFormBuilder($products)
         ->add('name', TextType::class,array('attr'=> array('class'=>'our_form')))
         ->add('description', null, array('attr' => array('rows' => 4)))
         ->add('price', MoneyType::class,array('required' =>true,'attr'=>array('class'=>'our_form')))
         ->add('submit', SubmitType::class,array('label'=>'Create','attr'=>array('class'=>'btn btn-mt-3')))
         ->getForm();

         $form->handleRequest($request);
        
         if($form->isSubmitted() && $form->isValid()){
            $products = $form->getData();
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($products);
            $entityManager->flush();

            return $this->redirectToRoute('product_list');
         }

        
         return $this->render( 'products/contact.html.twig',array( 
         'our_form' => $form->createView()
     ));
         }


    /**
     * @Route("/product/edit/{id}",name="edit_product")
     * @Method({"GET", "POST"})
     */
     public function edit(Request $request ,$id){
        $products = new Product();
        $products = $this->getDoctrine()->getRepository(Product::class)->find($id);
        $form = $this->createFormBuilder($products)
        ->add('name', TextType::class,array('attr'=> array('class'=>'our_form')))
        ->add('description', null, array('attr' => array('rows' => 4)))
        ->add('price', MoneyType::class,array('required' =>true,'attr'=>array('class'=>'our_form')))
        ->add('submit', SubmitType::class,array('label'=>'Create','attr'=>array('class'=>'btn btn-mt-3')))
        ->getForm();

        $form->handleRequest($request);
       
        if($form->isSubmitted() && $form->isValid()){
           $entityManager = $this->getDoctrine()->getManager();
           $entityManager->flush();

           return $this->redirectToRoute('product_list');
        }

       
        return $this->render( 'products/edit.html.twig',array( 
        'our_form' => $form->createView()
    ));
        }

    /**
     * @Route("/product/show",name="product_show")
     * @Method({"GET"})
     */
     public function show(){
        $entityManager = $this->getDoctrine()->getManager();
        $products = $this->getDoctrine()->getRepository(Product::class)->findAll();
        shuffle($products);
        return $this->render('products/show.html.twig', array('products'=> $products));
    }

    


        public function configureOptions(OptionsResolver $resolver)
        {
            $resolver->setDefaults([
                // Configure your form options here
            ]);
        }




}

