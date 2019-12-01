<?php


namespace App\Tests\Shipping\Domain\Model\Client;

use App\Shipping\Domain\Model\Client\FullName;
use PHPUnit\Framework\TestCase;

class FullNameTest extends TestCase
{
    /**
     * @test
     * @expectedException \InvalidArgumentException
     */
    public function cannotCreateFullNameWithShortFirstName()
    {
        FullName::create('a', 'Smith');
    }

    /**
     * @test
     * @expectedException \InvalidArgumentException
     */
    public function cannotCreateFullNameWithLongFirstName()
    {
        FullName::create(str_repeat('a', 51), 'Smith');
    }

    /**
     * @test
     * @expectedException \InvalidArgumentException
     */
    public function cannotCreateFullNameWithInvalidCharsInFirstName()
    {
        FullName::create('123', 'Smith');
    }

    /**
     * @test
     * @expectedException \InvalidArgumentException
     */
    public function cannotCreateFullNameWithShortLastName()
    {
        FullName::create('John', 'a');
    }

    /**
     * @test
     * @expectedException \InvalidArgumentException
     */
    public function cannotCreateFullNameWithLongLastName()
    {
        FullName::create('John', str_repeat('a', 51));
    }

    /**
     * @test
     * @expectedException \InvalidArgumentException
     */
    public function cannotCreateFullNameWithInvalidCharsInLastName()
    {
        FullName::create('John', '123');
    }

    /**
     * @test
     */
    public function createFullNameWithAccentedCharsInNames()
    {
        $fullName = FullName::create('Luís', 'Camões');
        $this->assertSame('Luís', $fullName->firstName());
        $this->assertSame('Camões', $fullName->lastName());
    }

    /**
     * @test
     */
    public function equals()
    {
        $fullName1 = FullName::create('John', 'Smith');
        $fullName2 = FullName::create('John', 'Smith');
        $fullName3 = FullName::create('David', 'Duchovny');
        $this->assertTrue($fullName1->equals($fullName2));
        $this->assertFalse($fullName1->equals($fullName3));
    }
}