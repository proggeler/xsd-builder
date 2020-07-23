<?php declare(strict_types=1);

namespace DavidBadura\OrangeDb\Test;

use DavidBadura\XsdBuilder\Attribute;
use DavidBadura\XsdBuilder\Builder;
use DavidBadura\XsdBuilder\ComplexType;
use DavidBadura\XsdBuilder\Element;
use DavidBadura\XsdBuilder\Restriction;
use DavidBadura\XsdBuilder\SimpleType;
use DavidBadura\XsdBuilder\Type;
use PHPUnit\Framework\TestCase;
use Spatie\Snapshots\MatchesSnapshots;

/**
 * @author David Badura <d.a.badura@gmail.com>
 */
class BuilderTest extends TestCase
{
    use MatchesSnapshots;

    public function testEmptyXsd()
    {
        $builder = new Builder();

        $this->assertMatchesSnapshot($builder->toString());
    }

    public function testStringElement()
    {
        $builder = new Builder();
        $builder->addElement(Element::string('name'));

        $this->assertMatchesSnapshot($builder->toString());
    }

    public function testIntegerElement()
    {
        $builder = new Builder();
        $builder->addElement(Element::integer('age'));

        $this->assertMatchesSnapshot($builder->toString());
    }

    public function testDecimalElement()
    {
        $builder = new Builder();
        $builder->addElement(Element::decimal('age'));

        $this->assertMatchesSnapshot($builder->toString());
    }

    public function testBooleanElement()
    {
        $builder = new Builder();
        $builder->addElement(Element::boolean('dead'));

        $this->assertMatchesSnapshot($builder->toString());
    }

    public function testDateElement()
    {
        $builder = new Builder();
        $builder->addElement(Element::date('birthdate'));

        $this->assertMatchesSnapshot($builder->toString());
    }

    public function testTimeElement()
    {
        $builder = new Builder();
        $builder->addElement(Element::time('shipped'));

        $this->assertMatchesSnapshot($builder->toString());
    }

    public function testStringAttribute()
    {
        $builder = new Builder();
        $builder->addAttribute(Attribute::string('name'));

        $this->assertMatchesSnapshot($builder->toString());
    }

    public function testIntegerAttribute()
    {
        $builder = new Builder();
        $builder->addAttribute(Attribute::integer('age'));

        $this->assertMatchesSnapshot($builder->toString());
    }

    public function testDecimalAttribute()
    {
        $builder = new Builder();
        $builder->addAttribute(Attribute::decimal('age'));

        $this->assertMatchesSnapshot($builder->toString());
    }

    public function testBooleanAttribute()
    {
        $builder = new Builder();
        $builder->addAttribute(Attribute::boolean('dead'));

        $this->assertMatchesSnapshot($builder->toString());
    }

    public function testDateAttribute()
    {
        $builder = new Builder();
        $builder->addAttribute(Attribute::date('birthdate'));

        $this->assertMatchesSnapshot($builder->toString());
    }

    public function testTimeAttribute()
    {
        $builder = new Builder();
        $builder->addAttribute(Attribute::time('shipped'));

        $this->assertMatchesSnapshot($builder->toString());
    }

    public function testEmptyComplexType()
    {
        $builder = new Builder();
        $builder->addComplexType(new ComplexType('user'));

        $this->assertMatchesSnapshot($builder->toString());
    }

    public function testComplexTypeWithElements()
    {
        $builder = new Builder();
        $user = new ComplexType('user');
        $user->addElement(Element::string('name'));
        $user->addElement(Element::integer('age'));

        $builder->addComplexType($user);

        $this->assertMatchesSnapshot($builder->toString());
    }

    public function testComplexTypeWithAttributes()
    {
        $builder = new Builder();
        $user = new ComplexType('user');
        $user->addAttribute(Attribute::string('name'));
        $user->addAttribute(Attribute::integer('age'));

        $builder->addComplexType($user);

        $this->assertMatchesSnapshot($builder->toString());
    }

    public function testElementWithCustomType()
    {
        $builder = new Builder();
        $builder->addElement(Element::create('user', 'user'));

        $this->assertMatchesSnapshot($builder->toString());
    }

    public function testElementWithEmbeddedComplexType()
    {
        $user = new ComplexType();
        $user->addElement(Element::string('name'));
        $user->addElement(Element::integer('age'));

        $builder = new Builder();
        $builder->addElement(Element::complexType('user', $user));

        $this->assertMatchesSnapshot($builder->toString());
    }

    public function testSimpleTypeElement()
    {
        $builder = new Builder();
        $builder->addSimpleType(new SimpleType('name', Type::STRING));

        $this->assertMatchesSnapshot($builder->toString());
    }

    public function testSimpleElementWithRestriction()
    {
        $regex = Restriction::regex('[0-9]*');

        $builder = new Builder();
        $builder->addSimpleType(new SimpleType('name', null, $regex));

        $this->assertMatchesSnapshot($builder->toString());
    }
}
