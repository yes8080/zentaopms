<?php
namespace zin;

global $config, $lang, $app;
$edition     = $config->edition;
$editionName = $edition != 'open' ? $lang->{$edition . 'Name'} : $lang->pmsName;
$version     = $edition != 'open' ? $config->{$edition . 'Version'} : $config->version;
$versionName = $editionName . $version;

query('#appsToolbar')->find('.btn-zentao .text')->text($versionName);

/* Zentao API 插件定义： */
$app->loadLang('aitools');
$zentaoAPILang = $lang->aitools;

/* Zentao API Sql 查询默认关闭，只有开启 $config->features->apiSqlQuery 才能使用：*/
$zentaoAPISqlQueryCode = '';
if(!empty($config->features->apiSqlQuery))
{
    $zentaoAPISqlQueryCode = <<<JS_CODE
    plugin.defineAgent(ZENTAO_ANALYSIS_AGENT_CODE, {
        name: `{$zentaoAPILang->dataAnalysisName}`,
        icon: 'zentao',
        desc: `{$zentaoAPILang->dataInsightDesc}`,
        prompt: $zentaoAPILang->dataInsightPrompt,
        tools: [
            {
                name: 'getZentaoDatabaseTables',
                displayName: `{$zentaoAPILang->tools['getZentaoDatabaseTables']->name}`,
                description: `{$zentaoAPILang->tools['getZentaoDatabaseTables']->description}`,
                parameters: {
                    type: 'object',
                    properties: {
                        keyword: {type: 'string', description: `{$zentaoAPILang->tools['getZentaoDatabaseTables']->parameters->keyword}`},
                        group: {type: 'string', description: `{$zentaoAPILang->tools['getZentaoDatabaseTables']->parameters->group}`},
                    },
                },
                fn: async (...args) => {
                    const {keyword = '', group = ''} = args[0] ?? {};
                    if (typeof keyword !== 'string' || typeof group !== 'string') {
                        return `{$zentaoAPILang->tools['getZentaoDatabaseTables']->invalidFilters}`;
                    }
                    const search = keyword.trim().toLowerCase();
                    const tableGroup = group.trim();
                    if (!search && !tableGroup) {
                        return callAction('db/tables', {}, `{$zentaoAPILang->tools['getZentaoDatabaseTables']->name}`);
                    }
                    const result = await callAction('db/tables', {}, `{$zentaoAPILang->tools['getZentaoDatabaseTables']->name}`, {
                        convert: tables => tables.filter(table => (!tableGroup || table.group === tableGroup)
                            && (!search || ['name', 'title', 'description', 'group'].some(key => typeof table[key] === 'string' && table[key].toLowerCase().includes(search)))),
                    });
                    if (result.result.status !== 'success' || !('data' in result.result) || !Array.isArray(result.result.data)) {
                        return result;
                    }
                    const conditions = [search ? `keyword=\${JSON.stringify(keyword.trim())}` : '', tableGroup ? `group=\${JSON.stringify(tableGroup)}` : ''].filter(Boolean).join(`{$zentaoAPILang->tools['getZentaoDatabaseTables']->conditionSeparator}`);
                    const scope = `{$zentaoAPILang->tools['getZentaoDatabaseTables']->filteredScope}`.replace('%s', () => conditions);
                    const message = result.result.data.length ? `\${scope}\\n\${result.info.markdown}` : `\${scope}\\n{$zentaoAPILang->tools['getZentaoDatabaseTables']->emptyFilteredResult}`;
                    return {...result, message, info: {markdown: message}};
                },
            },
            {
                name: 'getZentaoDatabaseTable',
                displayName: `{$zentaoAPILang->tools['getZentaoDatabaseTable']->name}`,
                description: `{$zentaoAPILang->tools['getZentaoDatabaseTable']->description}`,
                parameters: {
                    type: 'object',
                    properties: {
                        table: {type: 'string', description: `{$zentaoAPILang->tools['getZentaoDatabaseTable']->parameters->table}`},
                        type: {type: 'string', description: `{$zentaoAPILang->tools['getZentaoDatabaseTable']->parameters->type}`},
                    },
                    required: ['table'],
                },
                fn: (...args) => {
                    const {table, type = 'meta'} = args[0] ?? {};
                    if (typeof table !== 'string' || !table.trim()) {
                        return `{$zentaoAPILang->tools['getZentaoDatabaseTable']->missingTable}`;
                    }
                    if (type !== 'meta' && type !== 'sql') {
                        return `{$zentaoAPILang->tools['getZentaoDatabaseTable']->invalidType}`;
                    }
                    const label = `{$zentaoAPILang->tools['getZentaoDatabaseTable']->resultLabel}`.replace('%s', table.trim()).replace('%s', type === 'sql' ? `{$zentaoAPILang->tools['getZentaoDatabaseTable']->sqlLabel}` : `{$zentaoAPILang->tools['getZentaoDatabaseTable']->metaLabel}`);
                    return callAction('db/table', {table: table.trim(), type}, label);
                },
            },
            {
                name: 'queryZentaoDatabase',
                displayName: `{$zentaoAPILang->tools['queryZentaoDatabase']->name}`,
                description: `{$zentaoAPILang->tools['queryZentaoDatabase']->description}`,
                parameters: {
                    type: 'object',
                    properties: {
                        sql: {type: 'string', description: `{$zentaoAPILang->tools['queryZentaoDatabase']->parameters->sql}`},
                        page: {type: 'integer', description: `{$zentaoAPILang->tools['queryZentaoDatabase']->parameters->page}`},
                        limit: {type: 'integer', description: `{$zentaoAPILang->tools['queryZentaoDatabase']->parameters->limit}`},
                        count: {type: 'boolean', description: `{$zentaoAPILang->tools['queryZentaoDatabase']->parameters->count}`},
                    },
                    required: ['sql'],
                },
                fn: (...args) => {
                    const {sql, page = 1, limit = 100, count = true} = args[0] ?? {};
                    if (typeof sql !== 'string' || !sql.trim()) {
                        return `{$zentaoAPILang->tools['queryZentaoDatabase']->missingSQL}`;
                    }
                    if (!Number.isSafeInteger(page) || page < 1 || !Number.isSafeInteger(limit) || limit < 1) {
                        return `{$zentaoAPILang->tools['queryZentaoDatabase']->invalidPagination}`;
                    }
                    if (typeof count !== 'boolean') {
                        return `{$zentaoAPILang->tools['queryZentaoDatabase']->invalidCount}`;
                    }
                    return callAction('db/query', {sql: sql.trim(), page, limit, count}, `{$zentaoAPILang->tools['queryZentaoDatabase']->name}`);
                },
            },
        ],
    });

    plugin.defineContextProvider({
        code: ZENTAO_ANALYSIS_AGENT_CODE,
        icon: 'zentao',
        title: `{$zentaoAPILang->dataAnalysisName}`,
        hint: `{$zentaoAPILang->dataInsightDesc}`,
        recommend: true,
        data: {
            agent: ZENTAO_ANALYSIS_AGENT_CODE,
        },
    });
    JS_CODE;
}

$zentaoAPIPluginCode = <<<JS_CODE
const ZENTAO_AGENT_CODE = 'zentao-api';
if(zui.AIPlugin.map.value.get(ZENTAO_AGENT_CODE)) return;
const zentao = $.zentao;
const ZENTAO_READONLY_AGENT_CODE = 'zentao-api-readonly';
const ZENTAO_ANALYSIS_AGENT_CODE = 'zentao-insight';
const plugin = zui.AIPlugin.define(ZENTAO_AGENT_CODE, {
    name: 'Zentao API',
    icon: 'zentao',
});

function formatResponse(label, response, options) {
    if (options?.raw) {
        const markdown = `\${label}\\n{$zentaoAPILang->common->rawResponseLabel}\\n\`\`\`json\\n\${JSON.stringify(response, null, 2)}\\n\`\`\``;
        return {title: label, result: response, message: markdown, info: {markdown}};
    }
    const parts = [`\${label}\\n\${response.status === 'success' ? 'Success' : 'Failed'}.`];
    if (response.message) {
        parts.push(response.message);
    }
    if (response.pager) {
        if (response.pager.total < response.pager.recPerPage) {
            delete response.pager;
        } else {
            parts.push(`Pagination: \${response.pager.total} items, page \${response.pager.page}, \${response.pager.recPerPage} items per page.`);
        }
    }
    const hasData = response.data !== undefined;
    if (hasData && Array.isArray(response.data) && !response.message) {
        if (response.data.length) {
            response.message = `{$zentaoAPILang->common->foundCountMessage}`.replace('%s', response.data.length);
            if (response.pager && response.pager.total > response.data.length) {
                response.message += `{$zentaoAPILang->common->totalWithPaginationHint}`.replace('%s', response.pager.total);
            }
            parts.push(response.message);
        } else {
            const pager = response.pager;
            const hasNextPage = Boolean(pager && pager.page * pager.recPerPage < pager.total);
            const locallyProcessed = Boolean(options?.filter?.length || options?.search?.length || options?.limit !== undefined);
            const emptyScope = locallyProcessed ? `{$zentaoAPILang->common->emptyScopeLocal}` : `{$zentaoAPILang->common->emptyScopeServer}`;
            const nextPageHint = hasNextPage ? `{$zentaoAPILang->common->nextPageHint}`.replace('%s', pager.page + 1) : `{$zentaoAPILang->common->noRetryHint}`;
            const message = `{$zentaoAPILang->common->emptyResultMessage}`.replace('%s', emptyScope).replace('%s', nextPageHint);
            return {
                title: label,
                result: response,
                message,
                info: {markdown: message},
            };
        }
    }

    const head = parts.join('\\n');
    const markdown = hasData ? `\${head}\\nResponse:\\n\`\`\`json\\n\${JSON.stringify(response.data, null, 2)}\\n\`\`\`` : head;
    return {
        title: label,
        result: response,
        message: markdown,
        info: {markdown},
    };
}

function getErrorMessage(error) {
    return error instanceof Error ? error.message : String(error);
}

async function callAction(name, params, label, options) {
    try {
        const response = await zentao.request(name, params, options);
        return formatResponse(label, response, options);
    } catch (error) {
        return {
            title: label,
            result: {
                status: 'failed',
                message: getErrorMessage(error),
            },
            info: {markdown: `\${label} error: \${getErrorMessage(error)}`},
        };
    }
}

const getTools = (readonly = false) => {
    const tools = [
        {
            name: 'getZentaoModuleActions',
            displayName: `{$zentaoAPILang->tools['getZentaoModuleActions']->name}`,
            description: `{$zentaoAPILang->tools['getZentaoModuleActions']->description}`,
            parameters: {
                type: 'object',
                properties: {
                    moduleName: {type: 'string', description: `{$zentaoAPILang->tools['getZentaoModuleActions']->parameters->moduleName}`},
                    noActionParams: {type: 'boolean', description: `{$zentaoAPILang->tools['getZentaoModuleActions']->parameters->noActionParams}`},
                },
                required: ['moduleName'],
            },
            fn: async (...args) => {
                await zentao.init();
                const {moduleName, noActionParams = false} = args[0] || {};
                if (!moduleName) {
                    return `{$zentaoAPILang->common->missingModuleName}`;
                }
                const moduleInfo = zentao.module.getModule(moduleName);
                if (!moduleInfo) {
                    return `{$zentaoAPILang->common->moduleNotFound}`.replace('%s', moduleName);
                }
                let actions = moduleInfo.actions ?? [];
                if (readonly) {
                    actions = actions.filter(action => action.method?.toLowerCase() === 'get');
                }
                const formatAction = (action) => {
                    let line = `- \`\${moduleName}/\${action.name}\`(\${action.display ?? action.name}), \${action.description ?? ''}`;
                    if (!noActionParams) {
                        const params = zentao.module.getModuleActionParams(moduleName, action.name);
                        if (params.length) {
                            line += `, {$zentaoAPILang->tools['getZentaoModuleActions']->paramsLabel}:\\n`;
                            for (const param of params) {
                                line += `    - \`\${param.name}\`\${param.required ? ` ({$zentaoAPILang->common->requiredMark})` : ''}\${param.type ? `: \${param.type}，` : ''} \${param.description ?? ''}\${param.defaultValue !== undefined ? `, {$zentaoAPILang->tools['getZentaoModuleAction']->defaultLabel}=\`\${JSON.stringify(param.defaultValue)}\`` : ''}\${param.options?.length ? `, {$zentaoAPILang->tools['getZentaoModuleAction']->optionsLabel}：\${param.options.map(option => `\`\${JSON.stringify(option.value)}\`(\${option.label})`).join('、')}` : ''}\\n`;
                            }
                        } else {
                            line += `, {$zentaoAPILang->tools['getZentaoModuleActions']->noParamsLabel}`;
                        }
                    }
                    return line;
                };
                const message = [
                    `{$zentaoAPILang->tools['getZentaoModuleActions']->moduleLabel} \`\${moduleName}\` (\${moduleInfo.display ?? moduleName}) {$zentaoAPILang->tools['getZentaoModuleActions']->supportLabel} \${actions.length} {$zentaoAPILang->tools['getZentaoModuleActions']->actionsCountLabel}：`,
                    ...actions.map(formatAction),
                ].join('\\n');
                return {
                    title: `{$zentaoAPILang->tools['getZentaoModuleActions']->resultTitleLabel}`.replace('%s', moduleInfo.display ?? moduleName),
                    info: {markdown: message},
                    message,
                };
            },
        },
        {
            name: 'getZentaoModuleAction',
            displayName: `{$zentaoAPILang->tools['getZentaoModuleAction']->name}`,
            description: `{$zentaoAPILang->tools['getZentaoModuleAction']->description}`,
            parameters: {
                type: 'object',
                properties: {
                    moduleName: {type: 'string', description: `{$zentaoAPILang->common->moduleNameDesc}`},
                    actionName: {type: 'string', description: readonly ? `{$zentaoAPILang->tools['getZentaoModuleAction']->parameters->readonlyActionName}` : `{$zentaoAPILang->tools['getZentaoModuleAction']->parameters->actionName}`},
                },
                required: ['moduleName', 'actionName'],
            },
            fn: async (...args) => {
                await zentao.init();
                const {moduleName, actionName} = args[0] || {};
                if (!moduleName || !actionName) {
                    return `{$zentaoAPILang->common->missingModuleAndActionName}`;
                }
                const moduleInfo = zentao.module.getModule(moduleName);
                if (!moduleInfo) {
                    return `{$zentaoAPILang->common->moduleNotFound}`.replace('%s', moduleName);
                }
                const action = zentao.module.getModuleAction(moduleName, actionName);
                if (!action || (readonly && action.method?.toLowerCase() !== 'get')) {
                    return `{$zentaoAPILang->common->actionNotSupported}`.replace('%s', moduleName).replace('%s', `\`\${actionName}\``);
                }
                const lines = [
                    `\${moduleInfo.display ?? moduleInfo.name}{$zentaoAPILang->tools['getZentaoModuleAction']->actionLabel} \`\${moduleName}/\${action.name}\` - \${action.display ?? ''}`,
                ];
                if (action.description) {
                    lines.push(`\\n\${action.description}`);
                }
                const params = zentao.module.getModuleActionParams(moduleName, actionName);
                if (params.length) {
                    lines.push(`\\n{$zentaoAPILang->tools['getZentaoModuleActions']->paramsLabel}：`);
                    for (const param of params) {
                        lines.push(` - \`\${param.name}\`\${param.required ? ` ({$zentaoAPILang->common->requiredMark})` : ''}\${param.type ? `: \${param.type}，` : ''} \${param.description ?? ''}\${param.defaultValue !== undefined ? `, {$zentaoAPILang->tools['getZentaoModuleAction']->defaultLabel}=\`\${JSON.stringify(param.defaultValue)}\`` : ''}\${param.options?.length ? `, {$zentaoAPILang->tools['getZentaoModuleAction']->optionsLabel}：\${param.options.map(option => `\`\${JSON.stringify(option.value)}\`(\${option.label})`).join('、')}` : ''}`);
                    }
                }
                const message = lines.join('\\n');
                return {
                    title: `{$zentaoAPILang->tools['getZentaoModuleAction']->resultTitleLabel}`.replace('%s', moduleName).replace('%s', action.name),
                    message,
                    info: {markdown: message},
                };
            },
        }, {
            name: 'getZentaoObjectProps',
            displayName: `{$zentaoAPILang->tools['getZentaoObjectProps']->name}`,
            description: `{$zentaoAPILang->tools['getZentaoObjectProps']->description}`,
            parameters: {
                type: 'object',
                properties: {
                    objectType: {
                        anyOf: [
                            {type: 'string'},
                            {type: 'array', items: {type: 'string'}},
                        ],
                        description: `{$zentaoAPILang->tools['getZentaoObjectProps']->parameters->objectType}`,
                    },
                },
            },
            fn: async (...args) => {
                await zentao.init();
                const {objectType} = args[0] || {};
                if (!objectType) {
                    return `{$zentaoAPILang->common->missingObjectType}`;
                }
                const objectTypes = Array.isArray(objectType) ? objectType : [objectType];
                const objectProps = objectTypes.reduce((props, type) => {
                    props[type] = zentao.module.getObjectProps(type);
                    return props;
                }, {});
                return {
                    title: `{$zentaoAPILang->tools['getZentaoObjectProps']->resultTitleLabel}`.replace('%s', objectTypes.join()),
                    result: objectProps,
                    info: {markdown: `\`\`\`json\\n\${JSON.stringify(objectProps, null, 2)}\\n\`\`\``},
                };
            },
        }, {
            name: 'executeZentaoModuleAction',
            displayName: `{$zentaoAPILang->tools['executeZentaoModuleAction']->name}`,
            description: readonly ? `{$zentaoAPILang->tools['executeZentaoModuleAction']->readonlyDescription}` : `{$zentaoAPILang->tools['executeZentaoModuleAction']->description}`,
            parameters: {
                type: 'object',
                properties: {
                    moduleName: {type: 'string', description: `{$zentaoAPILang->common->moduleNameDesc}`},
                    actionName: {type: 'string', description: `{$zentaoAPILang->tools['executeZentaoModuleAction']->parameters->actionName}`},
                    params: {type: 'object', description: `{$zentaoAPILang->tools['executeZentaoModuleAction']->parameters->params}`, properties: {}},
                    raw: {type: 'boolean', description: `{$zentaoAPILang->tools['executeZentaoModuleAction']->parameters->raw}`},
                },
                required: ['moduleName', 'actionName'],
            },
            fn: async (...args) => {
                await zentao.init();
                const {moduleName, actionName, params = {}, raw = false} = args[0] || {};
                if (!moduleName || !actionName) {
                    return `{$zentaoAPILang->common->missingModuleAndActionName}`;
                }
                if (typeof raw !== 'boolean') {
                    return `{$zentaoAPILang->tools['executeZentaoModuleAction']->invalidRaw}`;
                }
                const moduleInfo = zentao.module.getModule(moduleName);
                if (!moduleInfo) {
                    return `{$zentaoAPILang->common->moduleNotFound}`.replace('%s', moduleName);
                }
                const action = zentao.module.getModuleAction(moduleName, actionName);
                if (!action || (readonly && action.method?.toLowerCase() !== 'get')) {
                    return `{$zentaoAPILang->common->actionNotSupported}`.replace('%s', moduleName).replace('%s', `\`\${actionName}\``);
                }
                return callAction(`\${moduleName}/\${actionName}`, params, `{$zentaoAPILang->tools['executeZentaoModuleAction']->resultLabel}`.replace('%s', moduleName).replace('%s', actionName), {raw});
            },
        }, {
            name: 'getZentaoObjectList',
            displayName: `{$zentaoAPILang->tools['getZentaoObjectList']->name}`,
            description: `{$zentaoAPILang->tools['getZentaoObjectList']->description}`,
            parameters: {
                type: 'object',
                properties: {
                    objectType: {type: 'string', description: `{$zentaoAPILang->common->objectTypeDesc}`},
                    recPerPage: {type: 'number', description: `{$zentaoAPILang->tools['getZentaoObjectList']->parameters->recPerPage}`},
                    pageID: {type: 'number', description: `{$zentaoAPILang->tools['getZentaoObjectList']->parameters->page}`},
                    params: {type: 'object', description: `{$zentaoAPILang->tools['getZentaoObjectList']->parameters->params}`, properties: {}},
                    pick: {type: 'array', description: `{$zentaoAPILang->tools['getZentaoObjectList']->parameters->pick}`, items: {type: 'string'}},
                    sort: {type: 'string', description: `{$zentaoAPILang->tools['getZentaoObjectList']->parameters->sort}`},
                    limit: {type: 'number', description: `{$zentaoAPILang->tools['getZentaoObjectList']->parameters->limit}`},
                    filter: {type: 'array', description: `{$zentaoAPILang->tools['getZentaoObjectList']->parameters->filter}`, items: {type: 'string'}},
                    search: {type: 'array', description: `{$zentaoAPILang->tools['getZentaoObjectList']->parameters->search}`, items: {type: 'string'}},
                    searchFields: {type: 'array', description: `{$zentaoAPILang->tools['getZentaoObjectList']->parameters->searchFields}`, items: {type: 'string'}},
                },
                required: ['objectType'],
            },
            fn: async (...args) => {
                await zentao.init();
                const {objectType, recPerPage, pageID, params = {}, pick, sort, limit, filter, search, searchFields} = args[0] || {};
                if (!objectType) {
                    return `{$zentaoAPILang->common->missingObjectType}`;
                }
                const moduleInfo = zentao.module.getModule(objectType);
                if (!moduleInfo) {
                    return `{$zentaoAPILang->common->moduleNotFound}`.replace('%s', objectType);
                }
                const requestParams = {...params};
                if (recPerPage !== undefined) {
                    requestParams.recPerPage = recPerPage;
                }
                if (pageID !== undefined) {
                    requestParams.pageID = pageID;
                }
                return callAction(`\${objectType}/list`, requestParams, `{$zentaoAPILang->tools['getZentaoObjectList']->resultLabel}`.replace('%s', moduleInfo.display ?? objectType), {
                    pick,
                    sort,
                    limit: limit === undefined ? undefined : String(limit),
                    filter,
                    search,
                    searchFields,
                });
            },
        }, {
            name: 'getZentaoObject',
            displayName: `{$zentaoAPILang->tools['getZentaoObject']->name}`,
            description: `{$zentaoAPILang->tools['getZentaoObject']->description}`,
            parameters: {
                type: 'object',
                properties: {
                    objectType: {type: 'string', description: `{$zentaoAPILang->common->objectTypeDesc}`},
                    objectID: {
                        anyOf: [
                            {type: 'number'},
                            {type: 'array', items: {type: 'number'}},
                        ],
                        description: `{$zentaoAPILang->tools['getZentaoObject']->parameters->objectID}`,
                    },
                    pick: {type: 'array', description: `{$zentaoAPILang->tools['getZentaoObject']->parameters->pick}`, items: {type: 'string'}},
                },
                required: ['objectType', 'objectID'],
            },
            fn: async (...args) => {
                await zentao.init();
                const {objectType, objectID: objectIDInput, pick} = args[0] || {};
                if (!objectType || objectIDInput === undefined) {
                    return `{$zentaoAPILang->common->missingObjectTypeAndID}`;
                }
                const moduleInfo = zentao.module.getModule(objectType);
                if (!moduleInfo) {
                    return `{$zentaoAPILang->common->moduleNotFound}`.replace('%s', objectType);
                }
                const moduleLabel = moduleInfo.display ?? objectType;
                const objectIDs = (Array.isArray(objectIDInput) ? objectIDInput : [objectIDInput])
                    .map(id => Number(id))
                    .filter(id => Number.isFinite(id));
                if (!objectIDs.length) {
                    return `{$zentaoAPILang->tools['getZentaoObject']->invalidObjectIDs}`;
                }
                if (objectIDs.length === 1) {
                    return callAction(`\${objectType}/get`, {id: objectIDs[0]}, `{$zentaoAPILang->tools['getZentaoObject']->resultLabelPrefix}\${moduleLabel} #\${objectIDs[0]}`, {pick});
                }

                const successItems = [];
                const failedItems = [];
                for (const id of objectIDs) {
                    const result = await callAction(`\${objectType}/get`, {id}, `{$zentaoAPILang->tools['getZentaoObject']->resultLabelPrefix}\${moduleLabel} #\${id}`, {pick});
                    const response = result.result;
                    if (response?.status === 'success' && 'data' in response) {
                        successItems.push({id, data: response.data});
                    } else {
                        failedItems.push({id, message: response?.message ?? `{$zentaoAPILang->common->unknownError}`});
                    }
                }
                const label = `{$zentaoAPILang->tools['getZentaoObject']->batchLabel}`.replace('%s', moduleLabel).replace('%s', objectIDs.length);
                const summary = `{$zentaoAPILang->common->batchSummary}`.replace('%s', successItems.length).replace('%s', failedItems.length);
                const lines = [`\${label}\\n\${summary}`];
                if (successItems.length) {
                    lines.push(`{$zentaoAPILang->common->successListPrefix}` + successItems.map(item => `#\${item.id}`).join(`{$zentaoAPILang->common->listSeparator}`));
                    lines.push(`Response:\\n\`\`\`json\\n\${JSON.stringify(successItems.map(item => item.data), null, 2)}\\n\`\`\``);
                }
                if (failedItems.length) {
                    lines.push(`{$zentaoAPILang->common->failedListPrefix}` + failedItems.map(item => `{$zentaoAPILang->common->failedItemFormat}`.replace('%s', item.id).replace('%s', item.message)).join(`{$zentaoAPILang->common->listSeparator}`));
                }
                const markdown = lines.join('\\n');
                return {
                    title: label,
                    result: {
                        status: failedItems.length ? (successItems.length ? 'partial' : 'failed') : 'success',
                        total: objectIDs.length,
                        data: successItems.map(item => item.data),
                        success: successItems.map(item => item.id),
                        failed: failedItems,
                    },
                    info: {markdown},
                    message: markdown,
                };
            },
        }, readonly ? null : {
            name: 'updateZentaoObject',
            displayName: `{$zentaoAPILang->tools['updateZentaoObject']->name}`,
            description: `{$zentaoAPILang->tools['updateZentaoObject']->description}`,
            parameters: {
                type: 'object',
                properties: {
                    objectType: {type: 'string', description: `{$zentaoAPILang->common->objectTypeDesc}`},
                    objectID: {type: 'number', description: `{$zentaoAPILang->tools['updateZentaoObject']->parameters->objectID}`},
                    data: {type: 'object', description: `{$zentaoAPILang->tools['updateZentaoObject']->parameters->data}`, properties: {}},
                },
                required: ['objectType', 'objectID', 'data'],
            },
            fn: async (...args) => {
                await zentao.init();
                const {objectType, objectID, data = {}} = args[0] || {};
                if (!objectType || objectID === undefined) {
                    return `{$zentaoAPILang->common->missingObjectTypeAndID}`;
                }
                const moduleInfo = zentao.module.getModule(objectType);
                if (!moduleInfo) {
                    return `{$zentaoAPILang->common->moduleNotFound}`.replace('%s', objectType);
                }
                return callAction(`\${objectType}/update`, {id: objectID, ...data}, `{$zentaoAPILang->tools['updateZentaoObject']->resultLabelPrefix}\${moduleInfo.display ?? objectType} #\${objectID}`);
            },
        }, readonly ? null : {
            name: 'deleteZentaoObject',
            displayName: `{$zentaoAPILang->tools['deleteZentaoObject']->name}`,
            description: `{$zentaoAPILang->tools['deleteZentaoObject']->description}`,
            parameters: {
                type: 'object',
                properties: {
                    objectType: {type: 'string', description: `{$zentaoAPILang->common->objectTypeDesc}`},
                    objectIDs: {
                        anyOf: [
                            {type: 'number'},
                            {type: 'array', items: {type: 'number'}},
                        ],
                        description: `{$zentaoAPILang->tools['deleteZentaoObject']->parameters->objectIDs}`,
                    },
                },
                required: ['objectType', 'objectIDs'],
            },
            fn: async (...args) => {
                await zentao.init();
                const {objectType, objectIDs: objectIDsInput} = args[0] || {};
                if (!objectType || objectIDsInput === undefined) {
                    return `{$zentaoAPILang->tools['deleteZentaoObject']->missingParams}`;
                }
                const moduleInfo = zentao.module.getModule(objectType);
                if (!moduleInfo) {
                    return `{$zentaoAPILang->common->moduleNotFound}`.replace('%s', objectType);
                }
                const moduleLabel = moduleInfo.display ?? objectType;
                const objectIDs = (Array.isArray(objectIDsInput) ? objectIDsInput : [objectIDsInput])
                    .map(id => Number(id))
                    .filter(id => Number.isFinite(id));
                if (!objectIDs.length) {
                    return `{$zentaoAPILang->tools['deleteZentaoObject']->invalidObjectIDs}`;
                }

                const confirmed = await zui.Modal.confirm({
                    title: `{$zentaoAPILang->tools['deleteZentaoObject']->confirmTitle}`.replace('%s', moduleLabel).replace('%s', objectIDs.join(', ')),
                    message: `{$zentaoAPILang->tools['deleteZentaoObject']->confirmMessage}`.replace('%s', objectIDs.length),
                    key: `_ai_tool_alert_\${zui.nextGid()}`,
                });

                if (!confirmed) {
                    return {
                        title: `{$zentaoAPILang->tools['deleteZentaoObject']->cancelledTitle}`,
                        message: `{$zentaoAPILang->tools['deleteZentaoObject']->cancelledMessage}`,
                    };
                }

                if (objectIDs.length === 1) {
                    return callAction(`\${objectType}/delete`, {id: objectIDs[0]}, `{$zentaoAPILang->tools['deleteZentaoObject']->resultLabelPrefix}\${moduleLabel} #\${objectIDs[0]}`);
                }

                const results = await Promise.all(objectIDs.map(id => callAction(`\${objectType}/delete`, {id}, `{$zentaoAPILang->tools['deleteZentaoObject']->resultLabelPrefix}\${moduleLabel} #\${id}`)));
                const successIDs = [];
                const failedItems = [];
                results.forEach((result, index) => {
                    const id = objectIDs[index];
                    if (result.result?.status === 'success') {
                        successIDs.push(id);
                    } else {
                        failedItems.push({id, message: result.result?.message ?? `{$zentaoAPILang->common->unknownError}`});
                    }
                });
                const label = `{$zentaoAPILang->tools['deleteZentaoObject']->batchLabel}`.replace('%s', moduleLabel).replace('%s', objectIDs.length);
                const summary = `{$zentaoAPILang->common->batchSummary}`.replace('%s', successIDs.length).replace('%s', failedItems.length);
                const lines = [`\${label}\\n\${summary}`];
                if (successIDs.length) {
                    lines.push(`{$zentaoAPILang->common->successListPrefix}` + successIDs.map(id => `#\${id}`).join(`{$zentaoAPILang->common->listSeparator}`));
                }
                if (failedItems.length) {
                    lines.push(`{$zentaoAPILang->common->failedListPrefix}` + failedItems.map(item => `{$zentaoAPILang->common->failedItemFormat}`.replace('%s', item.id).replace('%s', item.message)).join(`{$zentaoAPILang->common->listSeparator}`));
                }
                const markdown = lines.join('\\n');
                return {
                    title: label,
                    result: {
                        status: failedItems.length ? (successIDs.length ? 'partial' : 'failed') : 'success',
                        total: objectIDs.length,
                        success: successIDs,
                        failed: failedItems,
                    },
                    info: {markdown},
                    message: markdown,
                };
            },
        }, readonly ? null : {
            name: 'createZentaoObject',
            displayName: `{$zentaoAPILang->tools['createZentaoObject']->name}`,
            description: `{$zentaoAPILang->tools['createZentaoObject']->description}`,
            parameters: {
                type: 'object',
                properties: {
                    objectType: {type: 'string', description: `{$zentaoAPILang->common->objectTypeDesc}`},
                    data: {type: 'object', description: `{$zentaoAPILang->tools['createZentaoObject']->parameters->data}`, properties: {}},
                },
                required: ['objectType', 'data'],
            },
            fn: async (...args) => {
                await zentao.init();
                const {objectType, data = {}} = args[0] || {};
                if (!objectType) {
                    return `{$zentaoAPILang->common->missingObjectType}`;
                }
                const moduleInfo = zentao.module.getModule(objectType);
                if (!moduleInfo) {
                    return `{$zentaoAPILang->common->moduleNotFound}`.replace('%s', objectType);
                }
                return callAction(`\${objectType}/create`, {...data}, `{$zentaoAPILang->tools['createZentaoObject']->resultLabel}`.replace('%s', moduleInfo.display ?? objectType));
            },
        },
    ].filter(Boolean);
    return readonly ? tools.map(tool => ({...tool, shortcuts: false})) : tools;
};

plugin.defineAgent(ZENTAO_AGENT_CODE, {
    name: 'Zentao API',
    icon: 'zentao',
    prompt: $zentaoAPILang->prompt,
    alias: ['zentao', `{$lang->zentaoPMS}`],
    tools: getTools(),
});

plugin.defineAgent(ZENTAO_READONLY_AGENT_CODE, {
    name: `{$zentaoAPILang->readonlyName}`,
    icon: 'zentao',
    prompt: $zentaoAPILang->readonlyPrompt,
    alias: ['zentao-readonly', `{$zentaoAPILang->readonlyAlias}`],
    tools: getTools(true),
});

plugin.defineContextProvider({
    code: ZENTAO_AGENT_CODE,
    icon: 'zentao',
    title: `{$lang->zentaoPMS}`,
    hint: `{$zentaoAPILang->contextHint}`,
    recommend: true,
    data: {
        agent: ZENTAO_AGENT_CODE,
    },
});

plugin.defineContextProvider({
    code: ZENTAO_READONLY_AGENT_CODE,
    icon: 'zentao',
    title: `{$zentaoAPILang->readonlyAlias}`,
    hint: `{$zentaoAPILang->readonlyContextHint}`,
    hidden: true,
    data: {
        agent: ZENTAO_READONLY_AGENT_CODE,
    },
});

plugin.defineCallback('onCreateLocalChat', function (info) {
    const {chat, context} = info;
    const readonlySelected = chat.\$local.agents?.some(agent => agent.code === ZENTAO_READONLY_AGENT_CODE);
    if (readonlySelected) {
        const agents = chat.\$local.agents?.filter(agent => agent.code !== ZENTAO_AGENT_CODE);
        const contexts = chat.\$local.contexts?.filter(item => item.code !== ZENTAO_AGENT_CODE);
        chat.custom_data.agents = chat.custom_data.agents?.filter(agent => agent !== ZENTAO_AGENT_CODE);
        chat.custom_data.contexts = chat.custom_data.contexts?.filter(item => item.code !== ZENTAO_AGENT_CODE);
        context.store.updateChatLocalData(chat.id, {agents, contexts});
        context.store.reactions.addChatContext(chat.id, ZENTAO_READONLY_AGENT_CODE);
        return;
    }
    context.store.reactions.addChatContext(chat.id, ZENTAO_AGENT_CODE);
});

$zentaoAPISqlQueryCode
JS_CODE;

pageJS("(()=>{ $zentaoAPIPluginCode })();");
