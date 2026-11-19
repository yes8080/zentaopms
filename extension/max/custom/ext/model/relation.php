<?php
public function getRelationByID(int $id): object
{
    return $this->loadExtension('relation')->getRelationByID($id);
}

public function getAllRelationName(int $excludedID = 0): array
{
    return $this->loadExtension('relation')->getAllRelationName($excludedID);
}

public function createRelation(array $formData)
{
    $this->loadExtension('relation')->createRelation($formData);
}

public function editRelation(int $id, array $formData)
{
    return $this->loadExtension('relation')->editRelation($id, $formData);
}

public function getRelationObjectCount(int $key = 0)
{
    return $this->loadExtension('relation')->getRelationObjectCount($key);
}

public function getObjects(string $objectType, string $browseType = '', string $orderBy = 'id_desc', ?object $pager = null, int $excludedID = 0): array
{
    return $this->loadExtension('relation')->getObjects($objectType, $browseType, $orderBy, $pager, $excludedID);
}

public function getObjectCols(string $objectType): array
{
    return $this->loadExtension('relation')->getObjectCols($objectType);
}

public function getRelationList(bool $getParis = false, bool $addDefault = false): array
{
    return $this->loadExtension('relation')->getRelationList($getParis, $addDefault);
}

public function relateObject(int $objectID, string $objectType, array $objectRelation, string $relatedObjectType)
{
    return $this->loadExtension('relation')->relateObject($objectID, $objectType, $objectRelation, $relatedObjectType);
}

public function removeObjects(int $objectID, string $objectType, string $relationName, int $relatedObjectID, string $relatedObjectType): bool
{
    return $this->loadExtension('relation')->removeObjects($objectID, $objectType, $relationName, $relatedObjectID, $relatedObjectType);
}

public function removeRelationByID(int $relationID): bool
{
    return $this->loadExtension('relation')->removeRelationByID($relationID);
}

public function getObjectInfoByType(array $objectList): array
{
    return $this->loadExtension('relation')->getObjectInfoByType($objectList);
}

public function getRelatedObjectList(int|array $objectID, string $objectType, string $browseType = 'byRelation', bool $getCount = false): array|int
{
    return $this->loadExtension('relation')->getRelatedObjectList($objectID, $objectType, $browseType, $getCount);
}

public function setConfig4Workflow()
{
    return $this->loadExtension('relation')->setConfig4Workflow();
}

public function canSearch(string $objectType): bool
{
    return $this->loadExtension('relation')->canSearch($objectType);
}
