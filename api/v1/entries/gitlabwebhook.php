<?php
/**
 * The repo entry point of ZenTaoPMS.
 *
 * @copyright   Copyright 2009-2023 禅道软件（青岛）有限公司(ZenTao Software (Qingdao) Co., Ltd. www.cnezsoft.com)
 * @license     ZPL(http://zpl.pub/page/zplv12.html) or AGPL(https://www.gnu.org/licenses/agpl-3.0.en.html)
 * @author      xiawenlong <xiawenlong@cnezsoft.com>
 * @package     repo
 * @version     1
 * @link        https://www.zentao.net
 */
class gitlabWebhookEntry extends baseEntry
{

    /**
     * 获取请求头值，头名不区分大小写。
     *
     * @param  array  $headers
     * @param  string $name
     * @access private
     * @return string
     */
    private function getHeaderValue(array $headers, string $name): string
    {
        foreach($headers as $key => $value)
        {
            if(strcasecmp($key, $name) === 0) return (string)$value;
        }

        return '';
    }

    /**
     * Repo webhook.
     *
     * @access public
     * @return string
     */
    public function post()
    {
        $headers = getallheaders(); /* Fetch all HTTP request headers. */
        $event   = $this->getHeaderValue($headers, 'X-Gitlab-Event');
        if(empty($event)) return;

        $token     = $this->getHeaderValue($headers, 'X-Gitlab-Token');
        $pipelineID = (int)$this->param('pipelineID');
        $repoID     = (int)$this->param('repoID');
        $gitlab = $this->loadModel('gitlab');
        if($pipelineID > 0)
        {
            $pipeline = $this->loadModel('pipeline')->getByID($pipelineID);
            if(!$pipeline || !empty($pipeline->deleted) || $pipeline->engine !== 'gitlab') return $this->sendError(401, 'Unauthorized');
            $provider = $this->loadModel('provider')->getByID((int)$pipeline->providerID);
            if(!$provider || !empty($provider->deleted) || $provider->type !== 'GitLab') return $this->sendError(401, 'Unauthorized');
            $binding = rtrim($provider->url, '/') . '/' . $pipeline->externalPipeline;
            $expected = $gitlab->webhookToken('pipeline', $pipelineID, $binding);
            if($expected === '' || !hash_equals($expected, $token)) return $this->sendError(401, 'Unauthorized');
            $project = $this->requestBody->project ?? null;
            if(!in_array(rawurldecode($pipeline->externalPipeline), array((string)($project->id ?? ''), (string)($project->path_with_namespace ?? '')), true)) return $this->sendError(401, 'Unauthorized');

            $this->pipeline->handleWebhook($event, $this->requestBody, $pipeline);
            return;
        }

        $expected = $gitlab->webhookToken('repo', $repoID);
        if($expected === '' || !hash_equals($expected, $token)) return $this->sendError(401, 'Unauthorized');

        $this->app->user = new stdclass();
        $this->app->user->account = '';
        $this->app->user->admin   = false;
        $this->app->user->rights['rights'] = array();
        $this->app->user->rights['acls']   = array();

        $repo = $this->loadModel('repo')->fetchByID($repoID);
        if(empty($repo) || !empty($repo->deleted)) return;

        $this->loadController('user', 'login');
        $this->repo->handleWebhook($event, $this->requestBody, $repo);
    }
}
