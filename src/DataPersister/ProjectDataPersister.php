<?php

namespace App\DataPersister;


use ApiPlatform\Core\DataPersister\DataPersisterInterface;
use App\Entity\Project;
use App\Repository\ProjectRepository;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Component\HttpFoundation\RequestStack;

class ProjectDataPersister implements DataPersisterInterface
{
    private $projectRepository;
    private $slugger;
    private $request;

    public function __construct(ProjectRepository $projectRepository, SluggerInterface $slugger, RequestStack $request)
    {
        $this->projectRepository = $projectRepository;
        $this->slugger = $slugger;
        $this->request = $request->getCurrentRequest();
    }

    public function supports($data, array $context = []): bool
    {
        return $data instanceof Project;
    }

    public function persist($data, array $context = [])
    {
        if (!$data->getIsPublished()) {
            $data->setName(
                $this->slugger
                    ->slug(strtolower($data->getName()) . '-' . uniqid())
            );
        }
        if ($this->request->getMethod() != 'POST') {
            $data->setIsPublished(true);
            $data->setUpdatedAt(new \DateTime);
        }

        $this->projectRepository->add($data);
    }

    public function remove($data, array $context = [])
    {
        $this->projectRepository->remove($data);
    }
}
