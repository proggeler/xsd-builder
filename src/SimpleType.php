<?php declare(strict_types=1);

namespace DavidBadura\XsdBuilder;

class SimpleType
{
    private ?string $name;
    private ?string $type;
    private ?Restriction $restriction;

    public function __construct(?string $name = null, ?string $type = null, ?Restriction $restriction = null)
    {
        $this->name = $name;
        $this->type = $type;
        $this->restriction = $restriction;
    }

    public function name():?string
    {
        return $this->name;
    }

    public function type(): ?string
    {
        return $this->type;
    }

    public function restriction(): ?Restriction
    {
        return $this->restriction;
    }

    public function createDomElement(\DOMDocument $dom): \DOMElement
    {
        $el = $dom->createElement('xs:simpleType');
        $el->setAttribute('name', $this->name);

        if ($this->type) {
            $el->setAttribute('type', $this->type);

            return $el;
        }

        if ($this->restriction) {
            $el->appendChild($this->restriction->createDomElement($dom));

            return $el;
        }

        throw new \RuntimeException();
    }
}
