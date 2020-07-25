<?php declare(strict_types=1);

namespace DavidBadura\XsdBuilder;

class ComplexType
{
    private ?string $name;
    private bool $sequence = false;

    /**
     * @var Element[]
     */
    private array $elements = [];

    /**
     * @var Attribute[]
     */
    private array $attributes = [];

    private function __construct()
    {
    }

    public static function create(?string $name = null, bool $sequence = false): self
    {
        $self = new self();
        $self->name = $name;
        $self->sequence = $sequence;

        return $self;
    }

    public static function createSequence(?string $name = null): self
    {
        return self::create($name, true);
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
            $container = $dom->createElement($this->sequence ? 'xs:sequence' : 'xs:all');
            $el->appendChild($container);

            foreach ($this->elements as $element) {
                $container->appendChild($element->createDomElement($dom));
            }
        }

        foreach ($this->attributes as $attribute) {
            $el->appendChild($attribute->createDomElement($dom));
        }

        return $el;
    }
}
