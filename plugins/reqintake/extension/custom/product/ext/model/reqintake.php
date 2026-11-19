<?php
public function create(object $product, string $lineName = ''): int|false
{
    $id = parent::create($product, $lineName);
    if($id && !dao::isError()) $this->saveReqintakeOwner($id, 'create');
    return $id;
}

public function update(int $productID, object $product): array|false
{
    $changes = parent::update($productID, $product);
    if($changes !== false && !dao::isError()) $this->saveReqintakeOwner($productID, 'edit');
    return $changes;
}

private function saveReqintakeOwner(int $productID, string $method): void
{
    if($this->app->rawModule !== 'product' || $this->app->rawMethod !== $method || !isset($_POST['reqintakeOwner'])) return;
    if(!common::hasPriv('product', $method)) return;

    $model = $this->loadModel('reqintake');
    if(!$model->canAccess('index')) return;

    $this->app->loadLang('reqintake');
    try
    {
        $owner = $this->post->reqintakeOwner;
        if(!is_string($owner)) throw new DomainException('owner');
        $model->setOwner($productID, trim($owner), $method);
    }
    catch(DomainException | PDOException $error)
    {
        dao::$errors['reqintakeOwner'][] = $this->lang->reqintake->productOwnerSaveFailed;
    }
}
