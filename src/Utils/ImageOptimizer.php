<?php 

namespace App\Utils;

use Imagine\Gd\Imagine;
use Imagine\Image\Box;

class ImageOptimizer
{
private const MAX_WIDTH = 200;
private const MAX_HEIGHT = 150;

private $imagine;

public function __construct()
{
$this->imagine = new Imagine();
}

    public function resize(string $filename): void
    {
        // Obtenez les dimensions de l'image d'origine
        list($iwidth, $iheight) = getimagesize($filename);

        // Calculez les dimensions de l'image redimensionnée en conservant le ratio d'origine
        $ratio = $iwidth / $iheight;
        $width = self::MAX_WIDTH;
        $height = self::MAX_HEIGHT;
        if ($width / $height > $ratio) {
            $width = $height * $ratio;
        } else {
            $height = $width / $ratio;
        }

        // Chargez l'image d'origine
        $photo = $this->imagine->open($filename);

        // Vérifiez si la taille du fichier dépasse la limite de 2 MiB
        $maxFileSize = 2 * 1024 * 1024; // 2 MiB
        if (filesize($filename) > $maxFileSize) {
            // Redimensionnez l'image en utilisant les nouvelles dimensions calculées
            $photo->resize(new Box($width, $height))->save($filename, ['jpeg_quality' => 90]);

            // Vérifiez à nouveau si la taille du fichier après redimensionnement dépasse toujours la limite de 2 MiB
            if (filesize($filename) > $maxFileSize) {
                // Si la taille du fichier reste supérieure à 2 MiB, utilisez une boucle pour réduire progressivement la qualité de l'image jusqu'à ce qu'elle soit en dessous de la limite
                $quality = 90;
                while (filesize($filename) > $maxFileSize && $quality > 10) {
                    $quality -= 10;
                    $photo->save($filename, ['jpeg_quality' => $quality]);
                }
            }
        } else {
            // Si la taille du fichier est inférieure à la limite de 2 MiB, redimensionnez simplement l'image sans modifier la qualité
            $photo->resize(new Box($width, $height))->save($filename);
        }
    }
}