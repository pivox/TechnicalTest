<?php

namespace App\Exporter;

use Doctrine\ORM\EntityManager;

/**
 * Class DataCollector
 * @package App\Exporter
 */
class DataCollector
{
    /** @var array */
    private $data;

    /** @var WriterInterface $writer */
    private $writer;

    /** @var EntityManager */
    private $entityManager;

    /**
     * DataCollector constructor.
     * @param EntityManager $entityManager
     */
    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @param WriterInterface $writer
     * @return DataCollector
     */
    public function setWriter(WriterInterface $writer): DataCollector
    {
        $this->writer = $writer;
        return $this;
    }

    /**
     * @param $entityName
     * @return DataCollector
     * @throws \ReflectionException
     */
    public function init($entityName): DataCollector
    {
        $listObject = $this->entityManager->getRepository("App:".$entityName)->findAll();
        $array = [];
        $header = [];
        foreach ($listObject as $object) {
            $listMethods = get_class_methods($object);
            if(!$header) {
                $header = $this->getHeaderNames($object, $listMethods);
            }
            $item = [];
            foreach ($listMethods as $methodName) {
                if(strpos($methodName, 'get') === false) {
                    continue;
                }

                $method = new \ReflectionMethod($object, $methodName);
                $methodType = $method->getReturnType() ? $method->getReturnType()->getName(): null;
                $item[] = $this->resolveValue($object, $methodName, $methodType);

            }
            $array[] = $item;
        }
        $this->data = array_merge([$header], $array);

        return $this;
    }

    public function write()
    {
        $this->writer->write($this->data);
    }
    /**
     * @param $object
     * @param array $listMethods
     * @return array
     */
    private function getHeaderNames($object, array $listMethods): array
    {
        $header = [];
        foreach ($listMethods as $methodName) {
            if (strpos($methodName, 'get') === false) {
                continue;
            }
            $header[] = lcfirst(str_replace('get', '', $methodName));
        }
        return  $header;
    }
    /**
     * @param $object
     * @param string $methodName
     * @param string $methodType
     * @return string
     */
    private function resolveValue($object, string $methodName, string $methodType): ?string
    {
        $value = null;
        switch ($methodType) {
            case "int":
            case "string":
            $value = $object->{$methodName}();
                break;
            case "Datetime":
            case "DateTimeInterface":
            $value = $object->{$methodName}() ? $object->{$methodName}()->format("d-m-Y H:i:s"): null;
                break;
            case "boolean":
                $value = $object->{$methodName}() ? "oui": "non";
                break;
            default:
                break;
        }

        return $value;
    }
}