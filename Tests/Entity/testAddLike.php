<?php

namespace App\Tests\Entity;

use App\Entity\Post;
use PHPUnit\Framework\TestCase;
use App\Entity\PostLike;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class PostTest extends KernelTestCase
{
    public function testAddLike(): void
    {
        $post = new Post();
        $like = new PostLike();

        // Appeler la méthode addLike()
        $result = $post->addLike($like);

        // Vérifier que le like a été ajouté à la liste des likes du post
        $this->assertTrue($post->getLikes()->contains($like));

        // Vérifier que le like est correctement associé au post
        $this->assertSame($post, $like->getPost());

        // Vérifier que la méthode retourne bien l'instance du post
        $this->assertSame($post, $result);
    }
}
