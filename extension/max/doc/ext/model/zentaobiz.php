<?php
public function mergeFiles($docID)
{
    return $this->loadExtension('zentaobiz')->mergeFiles($docID);
}

public function diff($text1, $text2)
{
    return $this->loadExtension('zentaobiz')->diff($text1, $text2);
}

public function isImage($text)
{
    return $this->loadExtension('zentaobiz')->isImage($text);
}

public function diffImage($image1, $image2)
{
    return $this->loadExtension('zentaobiz')->diffImage($image1, $image2);
}

public function checkPrivLib(object|bool|null $object, string $extra = '', string $docID = ''): bool
{
    return $this->loadExtension('zentaobiz')->checkPrivLib($object, $extra, $docID);
}

public function checkPrivDoc(object $doc, bool $checkLib = true): bool
{
    return $this->loadExtension('zentaobiz')->checkPrivDoc($doc, $checkLib);
}

public function createLib(object $lib, string $type = '', string $libType = ''): int|bool
{
    return $this->loadExtension('zentaobiz')->createLib($lib, $type, $libType);
}

public function updateLib(int $libID, object $lib): array|bool
{
    return $this->loadExtension('zentaobiz')->updateLib($libID, $lib);
}

public function create(object $doc, array|bool $labels = false): array|bool|string
{
    return $this->loadExtension('zentaobiz')->create($doc, $labels);
}

public function update(int $docID, object $doc, ?object $oldDoc = null): array|string|bool
{
    return $this->loadExtension('zentaobiz')->update($docID, $doc, $oldDoc);
}

public function getAdminCatalog($bookID, $nodeID, $serials)
{
    return $this->loadExtension('zentaobiz')->getAdminCatalog($bookID, $nodeID, $serials);
}

public function computeSN($bookID, $from = 'doc')
{
    return $this->loadExtension('zentaobiz')->computeSN($bookID, $from);
}

public function getChildren($bookID, $nodeID = 0)
{
    return $this->loadExtension('zentaobiz')->getChildren($bookID, $nodeID);
}

public function manageCatalog($bookID, $nodeID)
{
    return $this->loadExtension('zentaobiz')->manageCatalog($bookID, $nodeID);
}

public function getBookStructure($bookID)
{
    return $this->loadExtension('zentaobiz')->getBookStructure($bookID);
}

public function getFrontCatalogItems($bookID, $serials, $articleID = 0)
{
    return $this->loadExtension('zentaobiz')->getFrontCatalogItems($bookID, $serials, $articleID);
}

public function getFrontCatalog($bookID, $serials, $articleID = 0)
{
    return $this->loadExtension('zentaobiz')->getFrontCatalog($bookID, $serials, $articleID);
}

public function sortBookOrder()
{
    return $this->loadExtension('zentaobiz')->sortBookOrder();
}

public function getBookOptionMenu($bookID, $removeRoot = false, $nodeID = 0)
{
    return $this->loadExtension('zentaobiz')->getBookOptionMenu($bookID, $removeRoot, $nodeID);
}

public function fixPath($bookID)
{
    return $this->loadExtension('zentaobiz')->fixPath($bookID);
}

public function getChildModules($parentID)
{
    return $this->loadExtension('zentaobiz')->getChildModules($parentID);
}

public function setDocPOST($docID, $version = 0)
{
    return $this->loadExtension('zentaobiz')->setDocPOST($docID, $version);
}

public function getPairs($type, $parentID)
{
    return $this->loadExtension('zentaobiz')->getPairs($type, $parentID);
}