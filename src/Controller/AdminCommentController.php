<?php

namespace App\Controller;

use App\Entity\Comment;
use App\Form\Comment1Type;
use App\Repository\CommentRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("admin/comment")
 */
class AdminCommentController extends AbstractController
{
    /**
     * @Route("/", name="admin_comment_index", methods={"GET"})
     */
    public function index(CommentRepository $commentRepository,PaginatorInterface $paginator, Request $request): Response
    {
        $comment = $commentRepository->findAll();
        return $this->render('admin/comment/index.html.twig', [
            'comments' => $comment,
        ]);
    }

    /**
     * @Route("/active", name="admin_comment_active", methods={"GET"})
     */
    public function active(CommentRepository $commentRepository,PaginatorInterface $paginator, Request $request): Response
    {
        $comment = $commentRepository->findActiveComment();
        $comments = $paginator->paginate($comment, $request->query->getInt('page', 1), /*page number*/
            6 /*limit per page*/);
        return $this->render('admin/comment/active.html.twig', [
            'comments' => $comments,
        ]);
    }

    /**
     * @Route("/notActive", name="admin_comment_notActive", methods={"GET"})
     */
    public function notActive(CommentRepository $commentRepository,PaginatorInterface $paginator, Request $request): Response
    {
        $comment = $commentRepository->findNotActiveComment();
        $comments = $paginator->paginate($comment, $request->query->getInt('page', 1), /*page number*/
            6 /*limit per page*/);
        return $this->render('admin/comment/notActive.html.twig', [
            'comments' => $comments,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="admin_comment_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Comment $comment): Response
    {
        $form = $this->createForm(Comment1Type::class, $comment);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();
            $this->addFlash('success','Votre modification est bien enregistrée');

            return $this->redirectToRoute('admin_comment_index');
        }

        return $this->render('admin/comment/edit.html.twig', [
            'comment' => $comment,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="admin_comment_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Comment $comment): Response
    {
        if ($this->isCsrfTokenValid('delete'.$comment->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($comment);
            $entityManager->flush();
            $this->addFlash('success','Votre suppréssion est bien enregistrée');
        }

        return $this->redirectToRoute('admin_comment_index');
    }
}
