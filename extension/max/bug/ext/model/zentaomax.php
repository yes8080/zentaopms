<?php
    /**
     * 按照注入环节统计。
     * Statistics by injection.
     *
     * @access public
     * @return array
     */
    public function getDataOfBugsPerInjection(): array
    {
        return $this->loadExtension('zentaomax')->getDataOfBugsPerInjection();
    }

    /**
     * 按照发现环节统计。
     * Statistics by bug identify.
     *
     * @access public
     * @return array
     */
    public function getDataOfBugsPerIdentify(): array
    {
        return $this->loadExtension('zentaomax')->getDataOfBugsPerIdentify();
    }
    