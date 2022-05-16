<?php

namespace App\DataPersister;

use ApiPlatform\Core\DataPersister\DataPersisterInterface;
use App\Entity\Utilisateur;
use App\Repository\UtilisateurRepository;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserDataPersister implements DataPersisterInterface
{


    private $userRepository;
    private $passwordEncoder;


    public function __construct(
        UtilisateurRepository $userRepository,
        UserPasswordHasherInterface $passwordEncoder

    ) {
        $this->userRepository = $userRepository;
        $this->passwordEncoder = $passwordEncoder;
    }


    public function supports($data): bool
    {
        return $data instanceof Utilisateur;
    }


    public function persist($data)
    {
        if ($data->getPassword()) {
            $data->setPassword(
                $this->passwordEncoder->hashPassword(
                    $data,
                    $data->getPassword()
                )
            );
        }

        $this->userRepository->add($data);
    }


    public function remove($data)
    {
        $this->userRepository->remove($data);
    }
}
