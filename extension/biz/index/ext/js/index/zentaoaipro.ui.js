window.waitAIPanel = () => zui.waitUntil(() => window.checkZAIPanel());

function initAITeammates(aiPanel)
{
    const plugin = aiPanel.store.reactions.getPlugin('zentao');
    if(!plugin) return;

    const lang = window.zaiLang || {};
    plugin.defineContextProvider({
        code: 'ai-teammate',
        title: lang.teammate,
        icon: 'hand-right',
        items: async function()
        {
            const res = await zui.fetchData($.createLink('ai', 'ajaxGetTeammates'));
            if(!res || res.result !== 'success' || !res.data) return [];

            const teammates = res.data;
            if(!teammates.length) return;

            const items = teammates.map((item) => {
                const collections = [];
                if(item.klibs && item.klibs.length)
                {
                    item.klibs.forEach(klibID => collections.push(`zentao:${klibID}`));
                }

                const promptParts = [];
                if(item.roleName)
                {
                    const prefix = lang.teammatePromptPrefix;
                    promptParts.push(`${prefix}${item.roleName}`);
                }
                if(item.desc) promptParts.push(item.desc);
                if(item.klibNames && item.klibNames.length)
                {
                    const klibNamesStr = item.klibNames.join(', ');
                    const knowledgePrefix = lang.teammateKnowledgePrefix;
                    const knowledgeSuffix = lang.teammateKnowledgeSuffix;
                    promptParts.push(`${knowledgePrefix}${klibNamesStr}${knowledgeSuffix}`);
                }

                const data = {
                    prompt: promptParts.join(', '),
                };
                if(collections.length) data.memory = {collections};

                let avatar = {src: item.avatar || '', size: 20, circle: true};
                if(!item.avatar)
                {
                    avatar.src = config.webRoot + 'static/zentaoaipro/ai-teammate-default.png';
                    avatar.style = {filter: `hue-rotate(${item.id * 53 % 360}deg)`};
                }
                else if(!avatar.src.startsWith(config.webRoot))
                {
                    avatar.src = config.webRoot + item.avatar;
                }
                return {
                    code: `zentao-aiteammate-${item.id}`,
                    title: item.name,
                    avatar: avatar,
                    hint: item.desc || item.name,
                    data,
                    llm: item.llm || undefined
                };
            });

            return items;
        },
    });

    const tabs = aiPanel.$.props.tabs || [];
    const taskTab = tabs.find(x => x.key === 'TASKS');
    if(!taskTab || taskTab.searchBox) return;
    const langs = {zh_cn: '搜索数字员工任务', zh_tw: '搜索數字員工任務', en: 'Search Teammate Tasks'};
    taskTab.searchBox = {placeholder: langs[zui.i18n.getCode()] || langs.en};
}

window.getWorkbenchURL = function(url)
{
    if (typeof url === 'number' || (typeof url === 'string' && /^[a-zA-Z0-9_]+$/.test(url))) url = {current: url};
    if(typeof url === 'object' && url) url = $.createLink('aiprocedure', 'workbench', `types=${url.types || 'all'}&current=${url.current || (url.objectType && url.objectID ? `${url.objectType}_${url.objectID}` : '')}`);
    return url || $('#aiWorkbench').attr('data-url') || $.createLink('aiprocedure', 'workbench');
};

window.openWorkbenchPanel = async (url) =>
{
    const aiEnabled = await window.checkZAIPanel(true);
    if(!aiEnabled) return;
    if(!window.zai.workbench) return;

    const $panel = $('#aiWorkbench');
    if($panel.length)
    {
        zui.AIPanel.shared.$.toggleWorkbench(true);
        return window.loadAIWorkbenchPanel(url);
    }

    zui.AIPanel.shared.$.toggleWorkbench(
    {
        ...zui.AIPanel.DEFAULT.workbench,
        fetcher: getWorkbenchURL(url),
    });
};

window.runProcedureInWorkbenchPanel = async (procedureID, objectType, objectID) =>
{
    const aiEnabled = await window.checkZAIPanel(true);
    if(!aiEnabled) return;
    zui.ajaxSubmit({url: $.createLink('aiprocedure', 'ajaxRunProcedure', `procedureID=${procedureID}&objectType=${objectType}&objectID=${objectID}`)});
};

(async () => {
    /* Init ai workbench: */
    if(window.zai && window.zai.workbench)
    {
        zui.AIPanel.DEFAULT.workbench =
        {
            contentClass: 'ai-workbench-panel',
            contentAttrs: {id: 'aiWorkbench'},
            fetcher:      getWorkbenchURL(),
        };
    }

    const aiPanel = await window.waitAIPanel();
    if(!aiPanel) return;

    initAITeammates(aiPanel);
})();
