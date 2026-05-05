<?php

namespace App\Controller;

use App\Entity\Project;
use App\Form\ProjectType;
use App\Repository\ProjectRepository;
use App\Repository\StatusRepository;
use App\Repository\TacheRepository;
use App\Repository\TagRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class ProjetController extends AbstractController
{
    #[Route('/project', name: 'app_home')]
    public function index(ProjectRepository $projectRepository): Response
    {
        $project = $projectRepository->findAll();

        return $this->render('projet/projects.html.twig', [
            'controller_name' => 'ProjetController',
            'projects' => $project,
        ]);
    }

    #[Route('/projet/show/{id}', name: 'app_project_show')]
    public function show(int $id, ProjectRepository $projectRepository, TagRepository $tagRepository, TacheRepository $tacheRepository, StatusRepository $statusRepository): Response
    {
        $project = $projectRepository->myFind($id);

        if (!$project->getUsers()->contains($this->getUser())) {
            throw $this->createAccessDeniedException('Acces refusé');
        }

        $taches = $tacheRepository->findByProjectWithRelations($project);
        $statuses = $statusRepository->findAll();
        $tag = $tagRepository->findAll();

        return $this->render('projet/project.html.twig', [
            'controller_name' => 'ProjetController',
            'project' => $project,
            'taches' => $taches,
            'statuses' => $statuses,
            'tags' => $tag,
        ]);
    }

    #[Route('/projet/add', name: 'app_project_add')]
    public function add(Request $request, EntityManagerInterface $entityManager): Response
    {
        $project = new Project();
        $form = $this->createForm(ProjectType::class, $project);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $project->setStartDate(new \DateTime());
            $project->setDeadline(new \DateTime());
            $project->setArchived(false);
            $entityManager->persist($project);
            $entityManager->flush();

            return $this->redirectToRoute('app_home');
        }

        return $this->render('projet/project-add.html.twig', [
            'form' => $form,
        ]);
    }

    #[Route('/projet/edit/{id}', name: 'app_project_edit')]
    public function edit(ProjectRepository $projectRepository, Request $request, EntityManagerInterface $entityManager, int $id): Response
    {
        $project = $projectRepository->find($id);

        $form = $this->createForm(ProjectType::class, $project);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_project_show', ['id' => $project->getId()]);
        }

        return $this->render('projet/project-edit.html.twig', [
            'form' => $form,
            'project' => $project,
        ]);
    }

    #[Route('/projet/delete/{id}', name: 'app_project_delete')]
    public function delete(ProjectRepository $projectRepository, EntityManagerInterface $entityManager, int $id): Response
    {
        $project = $projectRepository->find($id);

        $entityManager->remove($project);
        $entityManager->flush();

        return $this->redirectToRoute('app_home');
    }
}
