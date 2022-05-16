<?php

namespace App\Controller;

use App\Entity\Project;
use App\Repository\ProjectRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ApiController extends AbstractController
{
    public $projectRepository;


    public function __construct(ProjectRepository $projectRepository)
    {
        $this->projectRepository = $projectRepository;
    }

    /**
     * @Route("/project", name="project_index" , methods = {"GET"})
     */
    public function index(): Response
    {
        // liste des produits
        $products = $this->projectRepository->findAll();
        $data = [];

        foreach ($products as $product) {
            $data[] = [
                'id' => $product->getId(),
                'name' => $product->getName()
            ];
        }

        return $this->json($data);
    }


    /**
     * @Route("project" , name="project_new" , methods = {"POST"})
     */
    public function new(Request $request)
    {
        $project = new Project();

        $name = $request->get('name');
        $project->setName($name);
        $this->projectRepository->add($project);

        return $this->json('project enregistré ' . $project->getId());
    }

    /**
     * @Route("project/{id}" , name="project_show" , methods = {"GET"})
     */
    public function show(int $id)
    {

        $project = $this->projectRepository->find($id);

        if (!$project) {
            return $this->json('project non trouvé ' . $id, 404);
        }
        $data[] = [
            'id' => $project->getId(),
            'name' => $project->getName()
        ];

        return $this->json($data);
    }


    /**
     * @Route("project/{id}" , name="project_edit" , methods = {"PUT"})
     */
    public function edit(Request $request, int $id)
    {

        $project = $this->projectRepository->find($id);

        if (!$project) {
            return $this->json('project non trouvé ' . $id, 404);
        }
        $content = json_decode($request->getContent());
        $$project->setName($content->getName());
        $this->projectRepository->add($project);

        $data[] = [
            'id' => $project->getId(),
            'name' => $project->getName()
        ];

        return $this->json($data);
    }


    /**
     * @Route("project/{id}" , name="project_delete" , methods = {"GET"})
     */
    public function delete(Request $request, int $id)
    {

        $project = $this->projectRepository->find($id);

        if (!$project) {
            return $this->json('project non trouvé ' . $id, 404);
        }
        $this->projectRepository->remove($project);

        return $this->json('Deleted a project successfully with id ' . $id);
    }
}
