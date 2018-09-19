<?php
/**
 * Created by PhpStorm.
 * User: levanhuy1996bn
 * Date: 18/09/2018
 * Time: 10:29
 */

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Tests\Fixtures\Entity;
use Symfony\Component\Validator\Constraints\DateTime;
use Symfony\Component\Debug\Exception;

/**
 * @ORM\Entity
 * @ORM\Table(name="product")
 */
class Product
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $name;

    /**
     * @ORM\Column(type="datetime")
     */
    private $created;

    public function setName($name){
        $this->name = $name;
    }
    public function setCreated($created){
        $this->created = $created;
    }
    public function getId(){
        return $this->id;
    }
    public function getName(){
        return $this->name;
    }
    public function getCreated(){
        return $this->created;
    }
}