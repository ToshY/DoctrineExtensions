<?php

namespace DoctrineExtensions\Tests\Entities;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
class Blank
{
    #[ORM\Id]
    #[ORM\Column]
    #[ORM\GeneratedValue]
    public string $id;
}
