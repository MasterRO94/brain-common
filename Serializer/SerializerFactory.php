<?php

declare(strict_types=1);

namespace Brain\Common\Serializer;

use JMS\Serializer\Construction\ObjectConstructorInterface;
use JMS\Serializer\EventDispatcher\EventDispatcherInterface;
use JMS\Serializer\Expression\ExpressionEvaluatorInterface;
use JMS\Serializer\GraphNavigator;
use JMS\Serializer\Handler\HandlerRegistryInterface;
use JMS\Serializer\JsonSerializationVisitor;
use JMS\Serializer\SerializationContext;
use Metadata\MetadataFactoryInterface;

class SerializerFactory
{
    private $metadataFactory;
    private $handlerRegistry;
    private $objectConstructor;
    private $eventDispatcher;
    private $expressionEvaluator;
    private $jsonSerializationVisitor;

    public function __construct(
        MetadataFactoryInterface $metadataFactory,
        HandlerRegistryInterface $handlerRegistry,
        ObjectConstructorInterface $objectConstructor,
        EventDispatcherInterface $eventDispatcher,
        ExpressionEvaluatorInterface $expressionEvaluator,
        JsonSerializationVisitor $jsonSerializationVisitor
    ) {
        $this->metadataFactory = $metadataFactory;
        $this->handlerRegistry = $handlerRegistry;
        $this->objectConstructor = $objectConstructor;
        $this->eventDispatcher = $eventDispatcher;
        $this->expressionEvaluator = $expressionEvaluator;
        $this->jsonSerializationVisitor = $jsonSerializationVisitor;
    }

    /**
     * @param string[] $groups
     */
    public function createContext(array $groups): SerializationContext
    {
        $context = new SerializationContext();
        $context->setGroups($groups);

        $navigator = $this->createGraphNavigator();

        $visitor = $this->createVisitor();
        $visitor->setNavigator($navigator);

        $context->initialize('json', $visitor, $navigator, $this->metadataFactory);

        return $context;
    }

    public function createGraphNavigator(): GraphNavigator
    {
        $navigator = new GraphNavigator(
            $this->metadataFactory,
            $this->handlerRegistry,
            $this->objectConstructor,
            $this->eventDispatcher,
            $this->expressionEvaluator
        );

        return $navigator;
    }

    public function createVisitor(): JsonSerializationVisitor
    {
        return $this->jsonSerializationVisitor;
    }
}
