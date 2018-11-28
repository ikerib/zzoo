<?php

namespace AppBundle\Filter;

use Doctrine\ORM\Mapping\ClassMetaData;
use Doctrine\ORM\Query\Filter\SQLFilter;
use Doctrine\Common\Annotations\Reader;

class EzabatuMarka extends SQLFilter
{
    protected $reader;

    public function addFilterConstraint(ClassMetadata $targetEntity, $targetTableAlias)
    {
        if (empty($this->reader)) {
            return '';
        }


        // The Doctrine filter is called for any query on any entity
        // Check if the current entity is "user aware" (marked with an annotation)


      $udalaEgiaztatu = $this->reader->getClassAnnotation(
        $targetEntity->getReflectionClass(),
        'AppBundle\\Annotation\\EzabatuMarka'
      );



      if (!$udalaEgiaztatu) {
        return '';
      }

      $fieldName = $udalaEgiaztatu->userFieldName;

      $query = sprintf('%s.%s is null or %s.%s = 0', $targetTableAlias, $fieldName, $targetTableAlias, $fieldName);

        return $query;
    }

    public function setAnnotationReader(Reader $reader)
    {
        $this->reader = $reader;
    }
}
