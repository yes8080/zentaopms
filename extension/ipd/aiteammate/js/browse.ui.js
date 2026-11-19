/* 开始聊天 */
window.startChat = function(id)
{
    const aiPanel = zui.AIPanel.shared;
    if(!aiPanel) return;

    const teammate    = teammateData[id];
    const collections = [];
    if(teammate.klibs && teammate.klibs.length)
    {
        teammate.klibs.forEach((klibID) => collections.push(`zentao:${klibID}`));
    }

    const promptParts = [];
    if(teammate.roleName)
    {
        promptParts.push(`${teammatePromptPrefix}${teammate.roleName}`);
    }
    if(teammate.desc) promptParts.push(teammate.desc);
    if(teammate.klibNames && teammate.klibNames.length)
    {
        const klibNamesStr = teammate.klibNames.join(', ');
        promptParts.push(`${teammateKnowledgePrefix}${klibNamesStr}${teammateKnowledgeSuffix}`);
    }

    const data = {prompt: promptParts.join(', ')};
    if(collections.length) data.memory = {collections};

    const contexts = [{
        title: teammate.name,
        hint: teammate.desc || teammate.name,
        code: `zentao-aiteammate-${teammate.id}`,
        data,
        llm: teammate.llm || undefined,
    }];

    aiPanel.open({chat: {contexts}, select: true});
};
