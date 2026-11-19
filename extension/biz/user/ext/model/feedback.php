<?php
public function getHasFeedbackPriv($pager = null, $vision = 'lite')
{
    return $this->loadExtension('feedback')->getHasFeedbackPriv($pager, $vision);
}

public function getProductViewUsers($productID)
{
    return $this->loadExtension('feedback')->getProductViewUsers($productID);
}
