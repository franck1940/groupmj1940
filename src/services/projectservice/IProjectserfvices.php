<?php
namespace App\services\projectservice;

use App\Entity\Projects;

interface IProjectserfvices{
    public function insertNewProject( Projects $project):?bool;
    public function findAllProjects():?array;
    public function findProjectByTitle(string $title):?array;
    public function findProjectByPid(int $id):?Projects;
    public function deleteById(int $id):bool;
    public function deleteByTitle(string $title):bool;
}
?>