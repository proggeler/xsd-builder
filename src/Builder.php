<?php declare(strict_types=1);

namespace DavidBadura\XsdBuilder;

class Builder
{
    /**
     * @var Element[]
     */
    private array $elements = [];

    /**
     * @var Attribute[]
     */
    private array $attributes = [];

    /**
     * @var ComplexType[]
     */
    private array $complexTypes = [];

    /**
     * @var SimpleType[]
     */
    private array $simpleTypes = [];

    public function addElement(Element $element): void
    {
        $this->elements[] = $element;
    }

    public function addAttribute(Attribute $attribute): void
    {
        $this->attributes[] = $attribute;
    }

    public function addComplexType(ComplexType $complexType): void
    {
        $this->complexTypes[] = $complexType;
    }

    public function addSimpleType(SimpleType $simpleType): void
    {
        $this->simpleTypes[] = $simpleType;
    }

    public function toString(): string
    {
        $dom = new \DOMDocument('1.0', 'UTF-8');
        $dom->formatOutput = true;

        $schema = $dom->createElementNS('http://www.w3.org/2001/XMLSchema', 'xs:schema');
        $dom->appendChild($schema);

        foreach ($this->elements as $element) {
            $schema->appendChild($element->createDomElement($dom));
        }

        foreach ($this->attributes as $attribute) {
            $schema->appendChild($attribute->createDomElement($dom));
        }

        foreach ($this->simpleTypes as $simpleType) {
            $schema->appendChild($simpleType->createDomElement($dom));
        }

        foreach ($this->complexTypes as $complexType) {
            $schema->appendChild($complexType->createDomElement($dom));
        }

        $string = $dom->saveXML();

        if ($string === false) {
            throw new \RuntimeException();
        }

        return $string;
    }
}
