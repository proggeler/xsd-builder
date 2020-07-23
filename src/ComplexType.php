<?php declare(strict_types=1);

namespace DavidBadura\XsdBuilder;

class ComplexType
{
    private ?string $name;

    /**
     * @var Element[]
     */
    private array $elements = [];

    /**
     * @var Attribute[]
     */
    private array $attributes = [];

    public function __construct(?string $name = null)
    {
        $this->name = $name;
    }

    public function name(): ?string
    {
        return $this->name;
    }

    public function addElement(Element $element): void
    {
        $this->elements[] = $element;
    }

    public function elements(): array
    {
        return $this->elements;
    }

    public function addAttribute(Attribute $attribute): void
    {
        $this->attributes[] = $attribute;
    }

    public function attributes(): array
    {
        return $this->attributes;
    }

    public function createDomElement(\DOMDocument $dom): \DOMElement
    {
        $el = $dom->createElement('xs:complexType');

        if ($this->name) {
            $el->setAttribute('name', $this->name);
        }

        if (count($this->elements) > 0) {
            $sequence = $dom->createElement('xs:sequence');
            $el->appendChild($sequence);

            foreach ($this->elements as $element) {
                $sequence->appendChild($element->createDomElement($dom));
            }
        }

        foreach ($this->attributes as $attribute) {
            $el->appendChild($attribute->createDomElement($dom));
        }

        return $el;
    }
}
