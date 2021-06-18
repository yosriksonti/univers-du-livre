<?php

namespace ProduitBundle\Controller;

use AppBundle\AppBundle;
use AppBundle\Entity\commande;
use AppBundle\Entity\prodCom;
use Doctrine\ORM\Mapping\Entity;
use ProduitBundle\Entity\produit;
use ProduitBundle\ProduitBundle;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use ProduitBundle\Form\produitType;
use ProduitBundle\Repository\produitRepository;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\TextType;

use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

/**
 * Produit controller.
 *
 */
class produitController extends Controller
{
    /**
     * a propos
     *
     */
    public function aproposAction()
    {

        return $this->render('default/apropos.html.twig'
        );
    }
    /**
     * Lists all produit entities front.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $produits = $em->getRepository('ProduitBundle:produit')->findAll();
        $categories = $em->getRepository('CategorieBundle:categorie')->findAll();


        return $this->render('produit/ProduitsFront.html.twig', array(
            'produits' => $produits,
            'categories' => $categories,
        ));
    }


    /**
     * Finds and displays a produit entity.
     *
     */
    public function showAction(produit $produit, Request $request)
    {

        $form = $this->createFormBuilder()
            ->add('quantite', null, array('label' => false))
            ->getForm();

        return $this->render('produit/ProdDetails.html.twig', array(
            'produit' => $produit,
            'form' => $form->createView(),
        ));
    }


    /**
     * Displays a form to edit an existing produit entity.
     *
     */
    public function editAction(Request $request, produit $produit,$id)
    {
        $produit = $this->getDoctrine()->getRepository(produit::class)->find($id);
        $form = $this->createForm(produitType::class,$produit);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->flush();
            return $this->redirectToRoute('produit_indexB');
        }
            return $this->render('produit/edit.html.twig', [
                "produits" => $produit,
                "form" => $form->createView()
            ]);
        }


    /**
     * Deletes a produit entity.
     *
     */
    public function deleteAction(Request $request, produit $produit)
    {

        if ($produit) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($produit);
            $em->flush();
        }

        return $this->redirectToRoute('produit_indexB');
    }

    /**
     * Lists all produit entities back.
     *
     */
    public function indexBAction()
    {

        $em = $this->getDoctrine()->getManager();

        $produits = $em->getRepository('ProduitBundle:produit')->findAll();

        return $this->render('produit/ProduitsBack.html.twig', array(
            'produits' => $produits,
        ));
    }

    /**
     * Ajout produit entity back
     */
    public function AjoutAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $produit = new Produit();
        $form = $this->createForm('ProduitBundle\Form\produitType', $produit);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid())
        {
            $produit->setDateAjout(new \DateTime());
            $produit->setUpdatedAt(new \DateTime('now'));
            $em->persist($produit);
            $em->flush();

        }
        $em = $this->getDoctrine()->getManager();

        $produits = $em->getRepository('ProduitBundle:produit')->findAll();

        return $this->render('produit/ProduitsBack.html.twig', array(
            'produits' => $produits,
            'produit' => $produit,
            'form' => $form->createView(),
        ));
    }


    /**
     * Affichage du panier.
     *
     */
    public function affichePanierAction(SessionInterface $session)
    {

        $panier = $session->get('panier', []);
        $panierWithData = [];

        $em = $this->getDoctrine()->getManager();
        foreach ($panier as $id => $quantite)
        {

            $panierWithData[] = [
                'produit'=> $em->getRepository('ProduitBundle:produit')->find($id),
                'quantite'=>$quantite
            ];
        }

        $total= 0 ;

        foreach ($panierWithData as $item)
        {
            $totalItem = $item['produit']->getPrix()* $item['quantite'];
            $total+=$totalItem;
        }

        return $this->render('produit/Panier.html.twig', array(
            'items'=>$panierWithData,
            'total'=>$total,
        ));

    }


    /**
     * Ajout d'un produit dans panier.
     *
     */
    public function ajoutAuPanierAction($id, SessionInterface $session, Request $request)
    {
        $panier = $session->get('panier',[]);

        if(!empty($panier[$id]))
        {
            $panier[$id]++;
        }
        else
        {
            $panier[$id]=1;
        }

        $session->set('panier',$panier);



        return $this->redirectToRoute('produit_index');
    }


    /**
     * Suppression d'un produit dans panier.
     *
     */

    public function removeAction($id , SessionInterface $session)
    {
        $panier = $session->get('panier',[]);
        if (!empty($panier[$id]))
        {
            unset($panier[$id]);
        }
        $session->set('panier', $panier);

        return $this->redirectToRoute('produit_affichePanier');
    }

    /**
     * Confirmer commande.
     *
     */

    public function changerEtatAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $commande = $em->getRepository('AppBundle:commande')->find($id);
        $entityManager = $this->getDoctrine()->getManager();

        $commande -> setEtat('Confirmée');
        $entityManager->persist($commande);
        $entityManager->flush();


        $commandes = $em->getRepository('AppBundle:commande')->findAll();

        return $this->render('produit/CommandeBack.html.twig', array(
            'commandes' => $commandes,
        ));
    }

    public function changerEtat2Action($id)
    {
        $em = $this->getDoctrine()->getManager();
        $commande = $em->getRepository('AppBundle:commande')->find($id);
        $entityManager = $this->getDoctrine()->getManager();

        $commande -> setEtat('Livrée');
        $entityManager->persist($commande);
        $entityManager->flush();


        $commandes = $em->getRepository('AppBundle:commande')->findAll();

        return $this->render('produit/CommandeBack.html.twig', array(
            'commandes' => $commandes,
        ));
    }

    /**
     * Afficher les produits d'une commande
     *
     */

    public function prodParCommandeAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $prodComs = $em->getRepository('AppBundle:prodCom')->findBy(array('idCommande' => $id));

        return $this->render('produit/prodCom.html.twig', array(
            'prodComs' => $prodComs,
        ));

    }


    /**
     * Afficher les produits d'une categorie
     *
     */

    public function prodParCategorieAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $prodCats = $em->getRepository('ProduitBundle:produit')->findBy(array('categorie' => $id));
        $cat = $em->getRepository('CategorieBundle:categorie')->find($id);
        $catNom = $cat->getNomCat();
        return $this->render('produit/prodCategorie.html.twig', array(
            'prodCats' => $prodCats,
            'categories' => $catNom,
        ));

    }

    /**
     * Afficher les produits d'une commande archive des commandes
     *
     */

    public function prodParCommandeArchiveAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $prodComs = $em->getRepository('AppBundle:prodCom')->findBy(array('idCommande' => $id));

        return $this->render('produit/prodComArchive.html.twig', array(
            'prodComs' => $prodComs,
        ));

    }

    /**
     * Changer la quantite d'un produit d'une commande
     */
    public function changQuantProdComAction(Request $request, $id)
    {
        $nouvQuant = $request->query->get('nouvQuant');


        $em = $this->getDoctrine()->getManager();
        $product = $em->getRepository('AppBundle:prodCom')->find($id);
        $idCom = $product->getIdCommande();

        $product->setQuantiteProduit($nouvQuant);
        $em->persist($product);
        $em->flush();


        $prodComs = $em->getRepository('AppBundle:prodCom')->findBy(array('idCommande' => $idCom));


        return $this->render('produit/prodComArchive.html.twig', array(
            'prodComs' => $prodComs,
        ));
    }

    /**
     * Supprimer un produit d'une commande
     */
    public function deleteProdComAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $product = $em->getRepository('AppBundle:prodCom')->find($id);
        $idCom = $product->getIdCommande();

        $em->remove($product);
        $em->flush();

        $prodComs = $em->getRepository('AppBundle:prodCom')->findBy(array('idCommande' => $idCom));


        return $this->render('produit/prodComModifier.html.twig', array(
            'prodComs' => $prodComs,
        ));
    }

    /**
     * Annuler commande
     *
     */
    public function annulerCommandeAction(Request $request, commande $commande)
    {

        if ($commande) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($commande);
            $em->flush();
        }

        return $this->redirectToRoute('produit_archiveCommande');
    }

    /**
     * Modifier commande
     *
     */
    public function modifierCommandeAction($id)
    {

        $em = $this->getDoctrine()->getManager();
        $prodComs = $em->getRepository('AppBundle:prodCom')->findBy(array('idCommande' => $id));

        return $this->render('produit/prodComModifier.html.twig', array(
            'prodComs' => $prodComs,
        ));

    }



    /**
     * Archive des commandes d'un utilisateur
     */
    public function archiveCommandeAction()
    {

        $user = $this->getUser();
        $idClient=$user->getId();
        $em = $this->getDoctrine()->getManager();
        $archives = $em->getRepository('AppBundle:commande')->findBy(array('idClient' => $idClient));

        return $this->render('produit/ArchiveCommandes.html.twig', array(
            'archives' => $archives,
        ));
    }

    /**
     * Afficher les produits par mot clé
     *
     */

    public function rechercheAction(Request $request)
    {
        $key = $request->query->get('key');
        $em = $this->getDoctrine()->getManager();
        $conn = $em->getConnection();
        $sql = 'SELECT * FROM produit WHERE nomP LIKE "%'.$key.'%"';
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $array = $stmt->fetchAll();
        $categories = $em->getRepository('CategorieBundle:categorie')->findAll();
        return $this->render('produit/ProduitsFront.html.twig', array(
            'produits' => $array,
            'categories' => $categories,
        ));

    }


    /**
     * Afficher les produits par ordre croissant
     *
     */

    public function croissantAction()
    {

        $em = $this->getDoctrine()->getManager();
        $conn = $em->getConnection();
        $sql = 'SELECT * FROM produit  WHERE prix ORDER BY prix ASC';
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $array = $stmt->fetchAll();
        $categories = $em->getRepository('CategorieBundle:categorie')->findAll();
        return $this->render('produit/ProduitsFront.html.twig', array(
            'produits' => $array,
            'categories' => $categories,
        ));

    }


    /**
     * Afficher les produits par ordre decroissant
     *
     */

    public function decroissantAction()
    {

        $em = $this->getDoctrine()->getManager();
        $conn = $em->getConnection();
        $sql = 'SELECT * FROM produit  WHERE prix ORDER BY prix DESC ';
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $array = $stmt->fetchAll();
        $categories = $em->getRepository('CategorieBundle:categorie')->findAll();
        return $this->render('produit/ProduitsFront.html.twig', array(
            'produits' => $array,
            'categories' => $categories,
        ));

    }


    /**
     * Afficher les produits par mot clé
     *
     */

    public function maxminAction(Request $request)
    {           $key1 = 0 ;
        $key2 = 100000;

        $key1 = $request->query->get('min');
        $key2 = $request->query->get('max');
        $em = $this->getDoctrine()->getManager();
        $conn = $em->getConnection();
        $sql = 'SELECT * FROM produit WHERE prix >= "'.$key1.'" AND prix <= "'.$key2.'"';
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $array = $stmt->fetchAll();
        $categories = $em->getRepository('CategorieBundle:categorie')->findAll();
        return $this->render('produit/ProduitsFront.html.twig', array(
            'produits' => $array,
            'categories' => $categories,
        ));

    }


    /**
     * Afficher les produits par mot clé
     *
     */

    public function recherche1Action(Request $request)
    {
        $id = $request->query->get('x');
        $key = $request->query->get('key');
        $em = $this->getDoctrine()->getManager();
        $conn = $em->getConnection();
        $sql = 'SELECT * FROM produit WHERE nomP LIKE "%'.$key.'%" AND categorie.id = "'.$id.'"';
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $array = $stmt->fetchAll();
        $em = $this->getDoctrine()->getManager();
        $prodCats = $em->getRepository('ProduitBundle:produit')->findBy(array('categorie' => $id));
        $cat = $em->getRepository('CategorieBundle:categorie')->find($id);
        $catNom = $cat->getNomCat();
        return $this->render('produit/prodCategorie.html.twig', array(
            'prodCats' => $prodCats,
            'categorie' => $catNom,
            'produits' => $array,
        ));

    }


    /**
     * Afficher les produits par ordre croissant
     *
     */

    public function croissant1Action()
    {

        $em = $this->getDoctrine()->getManager();
        $conn = $em->getConnection();
        $sql = 'SELECT * FROM produit  WHERE prix ORDER BY prix ASC';
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $array = $stmt->fetchAll();
        $categories = $em->getRepository('CategorieBundle:categorie')->findAll();
        return $this->render('produit/ProduitsFront.html.twig', array(
            'produits' => $array,
            'categories' => $categories,
        ));

    }


    /**
     * Afficher les produits par ordre decroissant
     *
     */

    public function decroissant1Action()
    {

        $em = $this->getDoctrine()->getManager();
        $conn = $em->getConnection();
        $sql = 'SELECT * FROM produit  WHERE prix ORDER BY prix DESC ';
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $array = $stmt->fetchAll();
        $categories = $em->getRepository('CategorieBundle:categorie')->findAll();
        return $this->render('produit/ProduitsFront.html.twig', array(
            'produits' => $array,
            'categories' => $categories,
        ));

    }


    /**
     * Afficher les produits par mot clé
     *
     */

    public function maxmin1Action(Request $request)
    {           $key1 = 0 ;
        $key2 = 100000;

        $key1 = $request->query->get('min');
        $key2 = $request->query->get('max');
        $em = $this->getDoctrine()->getManager();
        $conn = $em->getConnection();
        $sql = 'SELECT * FROM produit WHERE prix >= "'.$key1.'" AND prix <= "'.$key2.'"';
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $array = $stmt->fetchAll();
        $categories = $em->getRepository('CategorieBundle:categorie')->findAll();
        return $this->render('produit/ProduitsFront.html.twig', array(
            'produits' => $array,
            'categories' => $categories,
        ));

    }

    /**
     * recherche ajax
     */
    public function searchajaxAction(Request $request)
    {
        $requestString=$request->get('searchValue');
        $produits = $this->getDoctrine()->getRepository(produit::class)
            ->findOneByName($requestString);
        return $this->render('produit/RechercheProduitajax.html.twig', [
            "produits"=>$produits
        ]);

    }







}
