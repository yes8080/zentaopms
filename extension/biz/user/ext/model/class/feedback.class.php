<?php
class feedbackUser extends userModel
{
    /**
     * Get has feedback priv.
     *
     * @param  object $pager
     * @param  string $vision
     * @access public
     * @return array
     */
    public function getHasFeedbackPriv($pager = null, $vision = 'lite')
    {
        $groups = $this->dao->select('`group`')->from(TABLE_GROUPPRIV)->where('module')->eq('feedback')->andWhere('method')->eq('create')->fetchPairs('group', 'group');
        return $this->dao->select('distinct t1.`account`,t1.realname,t1.feedback')->from(TABLE_USER)->alias('t1')
            ->leftJoin(TABLE_USERGROUP)->alias('t2')->on('t1.`account`=t2.`account`')
            ->where('t1.deleted')->eq(0)
            ->beginIF($vision != 'all')
            ->andWhere('t1.visions', true)->eq($vision)
            ->orWhere('t2.`group`')->in($groups)
            ->markRight(1)->fi()
            ->andWhere('t1.`account`')->notIN(trim($this->app->company->admins, ','))
            ->orderBy('t1.`account`')
            ->page($pager, 't1.`account`')
            ->fetchAll('account');
    }

    /**
     * Get product users from user view.
     *
     * @param  int    $productID
     * @access public
     * @return array
     */
    public function getProductViewUsers($productID)
    {
        if(empty($productID)) return array();

        $products = $this->dao->select('*')->from(TABLE_PRODUCT)->where('id')->in($productID)->andWhere('acl')->ne('open')->fetchAll('id');
        if(empty($products)) return array();

        list($productTeams, $productStakeholders) = $this->getProductMembers($products);

        /* Get white list group. */
        $whiteListGroup = array();
        $stmt = $this->dao->select('`objectID`,account')->from(TABLE_ACL)
            ->where('`objectType`')->eq('product')
            ->andWhere('`objectID`')->in($productID)
            ->query();

        while($whiteList = $stmt->fetch()) $whiteListGroup[$whiteList->objectID][$whiteList->account] = $whiteList->account;

        /* Get products' admins. */
        $productAdmins = $this->loadModel('group')->getAdmins(array($productID), 'products');

        /* Get product view list. */
        $product      = $products[$productID];
        $teams        = zget($productTeams, $productID, array());
        $stakeholders = zget($productStakeholders, $productID, array());
        $whiteList    = zget($whiteListGroup, $productID, array());
        $admins       = zget($productAdmins, $productID, array());

        return $this->getProductViewListUsers($product, $teams, $stakeholders, $whiteList, $admins);
    }
}
