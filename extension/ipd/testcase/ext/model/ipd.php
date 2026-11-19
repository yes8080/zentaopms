<?php
/**
 * 追加 bug 和用例执行结果信息
 * Append bugs and results.
 *
 * @param  array  $cases
 * @param  string $type
 * @param  array  $caseIdList
 * @access public
 * @return void
 */
public function appendData(array $cases, string $type = 'case', array $caseIdList = array()): array
{
    $cases = parent::appendData($cases, $type, $caseIdList);
    return $type == 'case' ? $this->loadModel('story')->getAffectObject($cases, 'case') : $cases;
}
