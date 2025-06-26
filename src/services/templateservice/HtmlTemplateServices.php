<?php

namespace App\services\templateservice;

use App\Entity\Htmltemplates;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Exception;

class HtmlTemplateServices implements IHtmlTemplateServices
{
    private EntityManager $entitymanager;
    public function __construct(private EntityManagerInterface $em)
    {
        $this->entitymanager = $em;
    }

    public function insertNewHtmltTemplate(Htmltemplates $htmlTp): bool
    {

        try {

            $this->entitymanager->persist($htmlTp);
            $this->entitymanager->flush();
        } catch (Exception $ex) {

            throw new Exception($ex);
            return false;
        }

        return true;
    }

    public function deleteAHtmltemplate(int $tId): bool
    {
        $tmpl = $this->findHtmlTemplateById($tId);

        if (!$tmpl) {
            throw new Exception('No product found for id ' . $tId);
        }

        try {
            $this->entitymanager->beginTransaction();
            $this->entitymanager->remove($tmpl);
            $this->entitymanager->flush();
            $this->entitymanager->commit();
        } catch (Exception $ex) {
            
            throw new Exception($ex);
            return false;
        }
        return true;
    }

    public function findAllHtmlTemplate(): array
    {
        return $this->entitymanager->getRepository(Htmltemplates::class)->findAll();
    }

    public function findHtmlTemplateById($tId): Htmltemplates
    {
        return $this->entitymanager->getRepository(Htmltemplates::class)->find($tId);
    }

    public function findHtmlTemplateByName($tName): array
    {
        $rslt[] = $this->entitymanager->getRepository(Htmltemplates::class)->findOneBy(['templateName' => $tName]);
        return $rslt;
    }
}
