<?php

namespace App\Service;

use Exception;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class ImageService
{
    private $params;

    public function __construct(ParameterBagInterface $params)
    {
        $this->params = $params;
    }

    /**
     * Fonction de gestion des image
     * @throws Exception
     */
    public function addThisImage(UploadedFile $image, ?string $dossier = '', ?int $width = 250, ?int $height = 250): string
    {
        //On donne un nouveau nom à l'image
        $fichier = md5(uniqid(rand(), true)) . '.webp';

        //On recupére les infos de l'image (largeur, hauteur..)
        $image_infos = getimagesize($image);

        if ($image_infos === false) {
            throw new Exception("Format d'image incorrecte");
        }

        //On vérifie le format de l'image
        switch ($image_infos['mime']) {
            case 'image/png':
                $image_source = imageCreateFromPng($image);
                break;
            case 'image/jpeg'|| 'image/jpg':
                $image_source = imageCreateFromJpeg($image);
                break;
            case 'image/webp':
                $image_source = imageCreateFromWebp($image);
                break;
            default:
                throw new Exception("Format d'image incorrecte");
        }

        //On recadre l'image
        //On verifie les dimension
        $imageWidth = $image_infos[0];
        $imageHeight = $image_infos[1];

        //On verifie l'oriantation de l'image
        switch ($imageWidth <=> $imageHeight) {
            case -1: //portrait
                $formatCarre = $imageWidth;
                $src_x = 0;
                $src_y = ($imageHeight - $formatCarre) / 2;
                break;
            case 0: //carré
                $formatCarre = $imageWidth;
                $src_x = 0;
                $src_y = 0;
                break;
            case 1: //paysage
                $formatCarre = $imageHeight;
                $src_x = ($imageWidth - $formatCarre) / 2;
                $src_y = 0;
                break;

        }

        // On crée une nouvelle image après découpe
        $resized_image = imagecreatetruecolor($width, $height);

        imagecopyresampled($resized_image, $image_source, 0, 0, $src_x, $src_y, $width, $height, $formatCarre, $formatCarre);

        $path = $this->params->get('images_directory') . '/' . $dossier;

        //On crée le dossier de destination si il n'existe pas
        if (!file_exists($path . '/mini/')) {
            mkdir($path . '/mini', 0755, true);
        }

        //On stocke l'image recadrée
        imagewebp($resized_image, $path . '/mini/' . $width . 'x' . $height . '-' . $fichier);

        $image->move($path . '/', $fichier);

        return $fichier;
    }

    public function deleteThisImage(string $fichier, ?string $dossier = '', ?int $width = 250, ?int $height = 250): bool
    {
        if ($fichier !== 'default.webp') {
            $success = false;

            $path = $this->params->get('images_directory'). '/' . $dossier;

            $mini = $path . '/mini/' . $width . 'x' . $height . '-' . $fichier;

            if (file_exists($mini)) {
                unlink($mini);
                $success = true;
            }
            $original = $path . '/' . $fichier;

            if (file_exists($original)) {
                unlink($original);
                $success = true;
            }
            return $success;
        }
        return false;
    }
    //
}