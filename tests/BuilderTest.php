<?php declare(strict_types=1);

namespace DavidBadura\OrangeDb\Test;

use DavidBadura\XsdBuilder\Attribute;
use DavidBadura\XsdBuilder\Builder;
use DavidBadura\XsdBuilder\ComplexType;
use DavidBadura\XsdBuilder\Element;
use DavidBadura\XsdBuilder\Restriction;
use DavidBadura\XsdBuilder\SimpleType;
use PHPUnit\Framework\TestCase;
use Spatie\Snapshots\MatchesSnapshots;

/**
 * @author David Badura <d.a.badura@gmail.com>
 */
class BuilderTest extends TestCase
{
    use MatchesSnapshots;

    public function testEmptyXsd(): void
    {
        $builder = new Builder();

        $this->assertMatchesSnapshot($builder->toString());
    }

    public function testStringElement(): void
    {
        $builder = new Builder();
        $builder->addElement(Element::string('name'));

        $this->assertMatchesSnapshot($builder->toString());
    }

    public function testIntegerElement(): void
    {
        $builder = new Builder();
        $builder->addElement(Element::integer('age'));

        $this->assertMatchesSnapshot($builder->toString());
    }

    public function testDecimalElement(): void
    {
        $builder = new Builder();
        $builder->addElement(Element::decimal('age'));

        $this->assertMatchesSnapshot($builder->toString());
    }

    public function testBooleanElement(): void
    {
        $builder = new Builder();
        $builder->addElement(Element::boolean('dead'));

        $this->assertMatchesSnapshot($builder->toString());
    }

    public function testDateElement(): void
    {
        $builder = new Builder();
        $builder->addElement(Element::date('birthdate'));

        $this->assertMatchesSnapshot($builder->toString());
    }

    public function testTimeElement(): void
    {
        $builder = new Builder();
        $builder->addElement(Element::time('shipped'));

        $this->assertMatchesSnapshot($builder->toString());
    }

    public function testStringAttribute(): void
    {
        $builder = new Builder();
        $builder->addAttribute(Attribute::string('name'));

        $this->assertMatchesSnapshot($builder->toString());
    }

    public function testIntegerAttribute(): void
    {
        $builder = new Builder();
        $builder->addAttribute(Attribute::integer('age'));

        $this->assertMatchesSnapshot($builder->toString());
    }

    public function testDecimalAttribute(): void
    {
        $builder = new Builder();
        $builder->addAttribute(Attribute::decimal('age'));

        $this->assertMatchesSnapshot($builder->toString());
    }

    public function testBooleanAttribute(): void
    {
        $builder = new Builder();
        $builder->addAttribute(Attribute::boolean('dead'));

        $this->assertMatchesSnapshot($builder->toString());
    }

    public function testDateAttribute(): void
    {
        $builder = new Builder();
        $builder->addAttribute(Attribute::date('birthdate'));

        $this->assertMatchesSnapshot($builder->toString());
    }

    public function testTimeAttribute(): void
    {
        $builder = new Builder();
        $builder->addAttribute(Attribute::time('shipped'));

        $this->assertMatchesSnapshot($builder->toString());
    }

    public function testEmptyComplexType(): void
    {
        $builder = new Builder();
        $builder->addComplexType(new ComplexType('user'));

        $this->assertMatchesSnapshot($builder->toString());
    }

    public function testComplexTypeWithElements(): void
    {
        $builder = new Builder();
        $user = new ComplexType('user');
        $user->addElement(Element::string('name'));
        $user->addElement(Element::integer('age'));

        $builder->addComplexType($user);

        $this->assertMatchesSnapshot($builder->toString());
    }

    public function testComplexTypeWithAttributes(): void
    {
        $builder = new Builder();
        $user = new ComplexType('user');
        $user->addAttribute(Attribute::string('name'));
        $user->addAttribute(Attribute::integer('age'));

        $builder->addComplexType($user);

        $this->assertMatchesSnapshot($builder->toString());
    }

    public function testElementWithCustomType(): void
    {
        $builder = new Builder();
        $builder->addElement(Element::create('user', 'user'));

        $this->assertMatchesSnapshot($builder->toString());
    }

    public function testElementWithEmbeddedComplexType(): void
    {
        $user = new ComplexType();
        $user->addElement(Element::string('name'));
        $user->addElement(Element::integer('age'));

        $builder = new Builder();
        $builder->addElement(Element::complexType('user', $user));

        $this->assertMatchesSnapshot($builder->toString());
    }

    public function testElementWithEmbeddedSimpleType(): void
    {
        $name = SimpleType::string('name');

        $builder = new Builder();
        $builder->addElement(Element::simpleType('user', $name));

        $this->assertMatchesSnapshot($builder->toString());
    }

    public function testSimpleTypeElement(): void
    {
        $builder = new Builder();
        $builder->addSimpleType(SimpleType::string('name'));

        $this->assertMatchesSnapshot($builder->toString());
    }

    public function testSimpleElementWithRestriction(): void
    {
        $regex = Restriction::regex('[0-9]*');

        $builder = new Builder();
        $builder->addSimpleType(SimpleType::withRestriction('name', $regex));

        $this->assertMatchesSnapshot($builder->toString());
    }

    public function testIds(): void
    {
        $book = new ComplexType();
        $book->addElement(Element::string('isbn'));
        $book->addElement(Element::integer('title'));
        $book->addElement(Element::idRef('author-ref'));
        $book->addElement(Element::idRefs('character-refs'));
        $book->addAttribute(Attribute::id('identifier'));

        $builder = new Builder();
        $builder->addElement(Element::complexType('book', $book));

        $this->assertMatchesSnapshot($builder->toString());
    }


    /*
     *
     <xs:element name="book">
    <xs:complexType>
        <xs:sequence>
            <xs:element name="isbn" type="xs:int"/>
            <xs:element name="title" type="xs:string"/>
            <xs:element name="author-ref">
                <xs:complexType>
                    <xs:attribute name="ref" type="xs:IDREF" use="required"/>
                </xs:complexType>
            </xs:element>
            <xs:element name="character-refs" type="xs:IDREFS"/>
        </xs:sequence>
        <xs:attribute name="identifier" type="xs:ID" use="required"/>
    </xs:complexType>
</xs:element>
     */
}
