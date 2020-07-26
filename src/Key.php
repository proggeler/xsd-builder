<?php declare(strict_types=1);

namespace DavidBadura\XsdBuilder;

class Key
{
    private string $name;
    private string $selector;
    private array $fields;

    private function __construct()
    {
    }

    public static function create(string $name, string $selector, array $fields): self
    {
        $self = new self();
        $self->name = $name;
        $self->selector = $selector;
        $self->fields = $fields;

        return $self;
    }

    public function createDomElement(\DOMDocument $dom): \DOMElement
    {
        $el = $dom->createElement('xs:key');
        $el->setAttribute('name', $this->name);

        $selector = $dom->createElement('xs:selector');
        $selector->setAttribute('xpath', $this->selector);
        $el->appendChild($selector);

        foreach ($this->fields as $field) {
            $fieldElement = $dom->createElement('xs:field');
            $fieldElement->setAttribute('xpath', $field);
            $el->appendChild($fieldElement);
        }

        return $el;
    }
}
