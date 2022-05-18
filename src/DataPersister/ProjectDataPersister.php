<?php

namespace App\DataPersister;


use ApiPlatform\Core\DataPersister\DataPersisterInterface;
use App\Entity\Project;
use App\Repository\ProjectRepository;
use App\Repository\TagRepository;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Security\Core\Security;

class ProjectDataPersister implements DataPersisterInterface
{
    private $projectRepository;
    private $tagRepository;
    private $slugger;
    private $request;
    private $security;

    public function __construct(
        ProjectRepository $projectRepository,
        SluggerInterface $slugger,
        RequestStack $request,
        TagRepository $tagRepository,
        Security $security
    ) {
        $this->projectRepository = $projectRepository;
        $this->tagRepository = $tagRepository;
        $this->slugger = $slugger;
        $this->request = $request->getCurrentRequest();
        $this->security = $security;
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
        
        if ($this->request->getMethod() == 'POST') {
            $data->setAuthor($this->security->getUser());
        }
        
        foreach ($data->getTags() as $tagItem) {
            $tag = $this->tagRepository->findOneByLabel($tagItem->getLabel());

            if ($tag) {
                $data->removeTag($tag);
                $data->addTag($tagItem);
            } else {
                $this->tagRepository->add($tagItem, false);
            }
        }
        $this->projectRepository->add($data);
    }

    public function remove($data, array $context = [])
    {
        $this->projectRepository->remove($data);
    }
}
