<?php
public function buildPieChartConfig(string $title, array $dataMap, int &$xAxis = 0, int &$yAxis = 0, int $index = 0, int $itemCount = 3, string $label = ''): array
{
    return $this->loadExtension('screen')->buildPieChartConfig($title, $dataMap, $xAxis, $yAxis, $index, $itemCount, $label);
}

public function buildBarChartConfig(string $title, array $dataMap, int &$yAxis = 0, string $type = 'cluBarX', int $index = 0, int $itemNum = 1, int $height = 0): array
{
    return $this->loadExtension('screen')->buildBarChartConfig($title, $dataMap, $yAxis, $type, $index, $itemNum, $height);
}

public function addBorderChart(int $height, int $yAxis, array $attr, int $multiplier = 10, int $divider = 0): object
{
    return $this->loadExtension('screen')->addBorderChart($height, $yAxis, $attr, $multiplier, $divider);
}

public function buildTitleChartConfig(string $title, int $xAxis, int $yAxis): object
{
    return $this->loadExtension('screen')->buildTitleChartConfig($title, $xAxis, $yAxis);
}

public function buildTextChartConfig(string $title, string $subTitle, int &$xAxis, int &$yAxis, int $index = 0, int $width = 0, int $gap = 0, string $tips = ''): array
{
    return $this->loadExtension('screen')->buildTextChartConfig($title, $subTitle, $xAxis, $yAxis, $index, $width, $gap, $tips);
}

public function buildWaterChartConfig(string $title, float $rate, int &$xAxis, int &$yAxis, int $index = 0, string $tips = '', int $lineNum = 2): array
{
    return $this->loadExtension('screen')->buildWaterChartConfig($title, $rate, $xAxis, $yAxis, $index, $tips, $lineNum);
}

public function addHelperChart(int|float $xAxis, int|float $yAxis, string $tips): object
{
    return $this->loadExtension('screen')->addHelperChart($xAxis, $yAxis, $tips);
}

public function buildTableChartConfig(string $title, array $headers, array $dataset, int &$yAxis = 0, int $lineNum = 0, array $rowspan = array(), string $noDataTip = '', string $titleTip = ''): array
{
    return $this->loadExtension('screen')->buildTableChartConfig($title, $headers, $dataset, $yAxis, $lineNum, $rowspan, $noDataTip, $titleTip);
}

public function buildTextGroupChartConfig(array $contents, int &$xAxis, int &$yAxis, int $width = 0, int $height = 0): array
{
    return $this->loadExtension('screen')->buildTextGroupChartConfig($contents, $xAxis, $yAxis, $width, $height);
}

public function buildSunburstChartConfig(string $title, array $dataMap, int &$xAxis = 0, int &$yAxis = 0, $tips = ''): array
{
    return $this->loadExtension('screen')->buildSunburstChartConfig($title, $dataMap, $xAxis, $yAxis, $tips);
}

public function getWaterEchartsOptions(string $percent): array
{
    return $this->loadExtension('screen')->getWaterEchartsOptions($percent);
}

public function getBarEchartsOptions(array $settings): array
{
    return $this->loadExtension('screen')->getBarEchartsOptions($settings, false);
}

public function getBarYEchartsOptions(array $settings): array
{
    return $this->loadExtension('screen')->getBarEchartsOptions($settings, true);
}

public function getPieEchartsOptions(array $settings): array
{
    return $this->loadExtension('screen')->getPieEchartsOptions($settings);
}

public function getSunburstEchartsOptions(array $dataMap): array
{
    return $this->loadExtension('screen')->getSunburstEchartsOptions($dataMap);
}

public function getLineEchartsOptions(array $settings): array
{
    return $this->loadExtension('screen')->getLineEchartsOptions($settings);
}
