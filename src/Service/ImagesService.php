<?php

namespace App\Service;

use App\Entity\Image;
use App\Entity\Hall;
use App\Repository\ImageRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;

class ImagesService
{
    /**
     * HallService constructor.
     * @param ImageRepository $repo
     * @param EntityManagerInterface $em
     */
    public function __construct(ImageRepository $repo, EntityManagerInterface $em)
    {
        $this->repo = $repo;
        $this->em = $em;
    }

    /**
     * @param $hallId
     * @return Image[]
     */
    public function getList($hallId): array
    {
        return $this->repo->findBy(['hall' => $hallId]);
    }

    /**
     * @param Request $request
     * @param Hall $hall
     * @param $filePath
     * @return Image
     */
    public function addImage(Request $request, Hall $hall, $filePath): Image
    {
        $image = new Image();
        /** @var UploadedFile $file */
        $file = $request->files->get('image');
        $fileName = $hall->getName() . '_' . \uniqid('', true) . '.jpg';
        $file->move($filePath, $fileName);
        $image->setFilePath($fileName);
        $image->setHall($hall);

        $this->em->persist($image);
        $this->em->flush();

        return $image;
    }

    /**
     * @param $id
     * @return Image|null
     */
    public function removeImage($id): ?Image
    {
        $image = $this->repo->find($id);

        $this->em->remove($image);
        $this->em->flush();

        return $image;
    }
}
