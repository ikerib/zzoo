<?php

namespace AppBundle\Filter;

use Doctrine\ORM\Mapping\ClassMetaData;
use Doctrine\ORM\Query\Filter\SQLFilter;
use Doctrine\Common\Annotations\Reader;

class EzabatuFilter extends SQLFilter
{
    protected $reader;

    public function addFilterConstraint(ClassMetadata $targetEntity, $targetTableAlias)
    {
        if (empty($this->reader)) {
            return '';
        }

      var_dump($targetEntity);die;
        $query = sprintf('%s.%s = %s', $targetTableAlias, 'ezabatu', 1);

        return $query;
    }

    public function setAnnotationReader(Reader $reader)
    {
        $this->reader = $reader;
    }
}
