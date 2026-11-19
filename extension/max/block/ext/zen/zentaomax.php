<?php
public function printTesttaskBlock(object $block): void
{
    $this->loadExtension('zentaomax')->printTesttaskBlock($block);
}

public function printScrumTestBlock(object $block): void
{
    $this->loadExtension('zentaomax')->printScrumTestBlock($block);
}
