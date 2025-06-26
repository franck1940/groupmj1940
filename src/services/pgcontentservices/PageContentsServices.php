<?php

namespace App\services\pgcontentservices;

use App\Entity\Menu;
use App\Entity\Pagecontents;
use App\services\menuservice\IMenuServices;
use App\services\menuservice\MenuServices;
use App\services\pgcontentservices\IPageContentsServices;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Exception;

class PageContentsServices implements IPageContentsServices
{

    private EntityManager $entitymanager;
    private  IMenuServices $menuServices;
    public function __construct(private EntityManagerInterface $em)
    {
        $this->entitymanager = $em;
        $this->menuServices = new MenuServices($em);
    }

    public function insertPgContents(Pagecontents $pgCts): bool
    {
        try {

            $this->entitymanager->persist($pgCts);
            $this->entitymanager->flush();
        } catch (Exception $ex) {

            throw new Exception($ex);
            return false;
        }

        return true;
    }

    public function findContentsById(int $contentId): Pagecontents
    {
        return $this->entitymanager->getRepository(Pagecontents::class)->find($contentId);
    }

    public function findContentsByTitle(String $title): Pagecontents
    {
        return $this->entitymanager->getRepository(Pagecontents::class)->findOneBy(["title" => $title]);
    }

    public function deleteContentsById(int $contentId): bool
    {
        $tData = $this->findContentsById($contentId);

        if (!$tData) {
            throw new Exception('No product found for id ' . $contentId);
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

    public function findContentsByMenuId(int $menuId): array
    {
        $menu = $this->menuServices->findMenuById($menuId);
        // $query = $this->entitymanager->createQueryBuilder('Pagecontents')
        //     ->where('Pagecontents.menu = :param')
        //     ->setParameter('param', $menu)
        //     ->orderBy('p.arg', 'ASC')
        //     ->getQuery()
        //     ->getResult();
     //  $result[] = $this->entitymanager->getRepository(Pagecontents::class)->findBy(["menu" => $menu]);
       //$result[] = [$menu];
        return  $this->entitymanager->getRepository(Pagecontents::class)->findBy(["menu" => $menu]);
    }

    public function deleteContentsByMenuId(int $contentId): bool
    {
        $tData[] = $this->findContentsByMenuId($contentId);

        if (!$tData) {
            throw new Exception('No product found for id ' . $contentId);
        }

        try {
            $this->entitymanager->beginTransaction();
            foreach ($tData as $x) {
                $this->entitymanager->remove($x);
            }
            $this->entitymanager->flush();
            $this->entitymanager->commit();
        } catch (Exception $ex) {

            throw new Exception($ex);
            return false;
        }
        return true;
    }

    public function findAllContents(): array
    {
        return $this->entitymanager->getRepository(Pagecontents::class)->findAll();
    }
}
