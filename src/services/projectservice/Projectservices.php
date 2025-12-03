<?php

namespace App\services\projectservice;

use App\Entity\Projects;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Exception;

class Projectservices implements IProjectserfvices
{
    private EntityManager $entitymanager;
    public function __construct(private EntityManagerInterface $em)
    {
        $this->entitymanager = $em;
    }

    public function insertNewProject(Projects $project): bool
    {
        try {
            $this->entitymanager->persist($project);
            $this->entitymanager->flush();
        } catch (Exception $ex) {

            throw new Exception($ex);
            return false;
        }

        return true;
    }

    public function findAllProjects(): array
    {
        return $this->entitymanager->getRepository(Projects::class)->findAll();
    }

    public function findProjectByTitle(string $title): ?array
    {
        return $this->entitymanager->getRepository(Projects::class)->findOneBy(["title" => $title]);
    }

    public function findProjectByPid(int $id): Projects
    {
        return $this->entitymanager->getRepository(Projects::class)->find($id);
    }

    public function deleteById(int $id): bool
    {
        $tData = $this->findProjectByPid($id);

        if (!$tData) {
            throw new Exception('No product found for id ' . $id);
        }

        try {
            $this->entitymanager->beginTransaction();
            $this->entitymanager->remove($tData);
            $this->entitymanager->flush();
            $this->entitymanager->commit();
        } catch (Exception $ex) {

            throw new Exception($ex);
            return false;
        }
        return true;
    }

    public function deleteByTitle(string $title): bool
    {
        $tData = $this->findProjectByTitle($title);

        if (!$tData) {
            throw new Exception('No product found for id ' . $title);
        }

        try {
             $this->entitymanager->beginTransaction();
            foreach ($tData as $val) {
                $this->entitymanager->remove($val);
            }
                $this->entitymanager->flush();
                $this->entitymanager->commit();
            
        } catch (Exception $ex) {

            throw new Exception($ex);
            return false;
        }
        return true;
    }
}
