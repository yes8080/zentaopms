if(window.loadAIWorkbenchPanel) return;

const openPageFormOrigin = window.openPageForm;
window.openPageForm = function(url, options, callback)
{
    const $aiprocedurerun = $(this.base).closest('[z-use-aiprocedurerun]');
    if($aiprocedurerun.length)
    {
        const procedureRun = $aiprocedurerun.zui();
        if(procedureRun && procedureRun.$) return procedureRun.$.openPageForm(url, options, callback);
    }
    return openPageFormOrigin.call(this, url, options, callback);
}

function handleWorkbenchShow(show)
{
    $('body').toggleClass('has-workbench-show', !!show);
    if(show)
    {
        const $appTabs   = $('#appTabs');
        let $appTabsItem = $('#appTab-aiworkbench');
        if(!$appTabsItem.length)
        {
            $appTabsItem = $(`<li class="nav-item active" id="appTab-aiworkbench"><a class="active"><span class="text">${$('#aiWorkbenchMain').attr('data-apps-label')}</span></a></li>`).appendTo($appTabs);
            $appTabsItem.on('click', () => openWorkbenchPanel())
        }
        $appTabs.children('.active').removeClass('active').find('.active').removeClass('active');
        $appTabsItem.addClass('active').find('a').addClass('active');
    }
    else
    {
        const $appTabsItem = $('#appTab-aiworkbench');
        if(!$appTabsItem.length) return;
        if($appTabsItem.data('onlyHide'))
        {
            $appTabsItem.data('onlyHide', false).removeClass('active').find('.active').removeClass('active');
        }
        else
        {
            $appTabsItem.remove();
        }
        const lastApp = $.apps.getLastApp();
        if(lastApp) $.apps.showApp(lastApp.code);
    }
}

function updateProcedureRunStatus()
{
    const generatingRunIDs = new Set();
    AIProcedureRunJSX.generatingChatSet$.value.forEach(chatID =>
    {
        const procedureRunID = AIProcedureRunJSX.chatProcedureRunMap.get(chatID);
        if(procedureRunID) generatingRunIDs.add(+procedureRunID);
    });
    $('#aiWorkbench .aiworkbench-todo-list>.item[zui-key]').each(function(_, item)
    {
        const $item = $(item);
        const $status = $item.find('.ai-procedure-run-status');
        const generating = generatingRunIDs.has(+$item.attr('zui-key'));
        $status.find('.text').text($status.attr(generating ? 'data-running-text' : 'data-doing-text'));
        $status.find('.label-dot').toggleClass('status-doing', !generating).toggleClass('text-gray', generating);
    });
}

window.loadAIWorkbenchPanel = async (url) =>
{
    if(!url) $('#workbenchRefreshBtn').find('.icon').addClass('spin disabled');
    const $panel = $('#aiWorkbench');
    url = window.getWorkbenchURL(url);
    const html = await $.get(url);
    $panel.attr('data-url', url);
    $panel.find('.zin-page-js').remove();
    $panel.morphInner(`<div>${html}</div>`);
    updateProcedureRunStatus();
};

window.initAIWorkbenchPanel = ($element, url) =>
{
    const $panel = $element.closest('#aiWorkbench');
    if($panel.length && !$panel.data('initClickEvents'))
    {
        $panel.attr('data-url', url).data('initClickEvents', true);
        $panel.on('click', 'a', async (event) =>
        {
            const $target = $(event.currentTarget);
            const url = $target.attr('href');
            if(!url || url.startsWith('javascript:') || url.startsWith('#')) return;

            if($target.closest('.open-in-workbench').length)
            {
                event.preventDefault();
                loadAIWorkbenchPanel(url);
            }
            else if(!$target.attr('data-toggle') && !$target.attr('zui-toggle'))
            {
                zui.AIPanel.shared.$.toggleWorkbench();
            }
        });
        $panel.closest('.ai-workbench').on('aiworkbenchshow', () =>
        {
            handleWorkbenchShow(true);
            loadAIWorkbenchPanel();
        }).on('aiworkbenchhide', () =>
        {
            handleWorkbenchShow(false);
        });

        $(document).on('openapp.apps', (e, args) =>
        {
            if(!$('body').hasClass('has-workbench-show')) return;
            $('#appTab-aiworkbench').data('onlyHide', true);
            zui.AIPanel.shared.$.toggleWorkbench(false);
        });
        handleWorkbenchShow(true);
    }

    /* Update procedure run status. */
    parent.waitAIPanel().then(() =>
    {
        const tryUpdateStatus = zui.debounce(updateProcedureRunStatus, 200);
        zui.effect(() =>
        {
            const chats = zui.AIPanel.shared.store.chats;
            const oldGeneratingRunIDSet = AIProcedureRunJSX.generatingChatSet$.value;
            const generatingChatSet = chats.reduce((ids, chat) =>
            {
                const lastMessage = chat.messages && chat.messages[chat.messages.length - 1];
                const generating = lastMessage && lastMessage.role === 'assistant' && lastMessage.$state === 'generating';
                if(generating) ids.add(chat.id);
                return ids;
            }, new Set());
            if(oldGeneratingRunIDSet.size !== generatingChatSet.size || ![...oldGeneratingRunIDSet].every(chatID => generatingChatSet.has(chatID)))
            {
                AIProcedureRunJSX.generatingChatSet$.value = generatingChatSet;
                tryUpdateStatus();
            }
        });
    });
};

const {jsx, ReactComponent, ComponentFromReact, signal, computed, createRef, batch} = zui;
const {FormBuilder} = zui.reactComponents;
const AIChatView = zui.AIChatView.Component;

class ZentaoEntityDetail extends zui.Component
{
    static NAME = 'ZentaoEntityDetail';

    afterInit()
    {
        this.render();
    }

    render(options, reset)
    {
        super.render(options);
        this.load();
    }

    async load()
    {
        const {type, id} = this.options;
        const url = $.createLink(type, 'view', `${type}ID=${id}`);
        const html = await $.get(url);
        if(type !== this.options.type || id !== this.options.id) return;

        this.$element.empty();
        this.$element.morphInner(`<div>${html}</div>`);
    }
}

ZentaoEntityDetail.register();

class AIProcedureHistoryChatJSX extends AIChatView
{
    async postMessage() {}

    _handleSubmitForm = () => {};

    _handleSubmitQuestions = () => {};

    _disableFormControls()
    {
        const $element = $(this.base);
        $element.find('input, textarea, select, button[type="submit"], .ai-questions-panel button').prop('disabled', true);
        $element.find('[contenteditable]').attr('contenteditable', 'false');
    }

    componentDidMount()
    {
        super.componentDidMount();
        this._disableFormControls();
    }

    componentDidUpdate(props)
    {
        super.componentDidUpdate(props);
        this._disableFormControls();
    }
}

class AgentResultFormJSX extends zui.ReactComponent
{
    async load()
    {
        const {location, data, onSave} = this.props;
        const html = await $.get(location);
        if(location !== this.props.location) return;

        const $element = $(this.base);
        $element.html(html);

        await zui.delay(500);

        $element.find('.form-actions > .btn[data-back]').text(zui.i18n.getLang('cancel'));
        const $form = $element.find('form').filter(function() {return $(this).closest('#formSettingBtn').length === 0;});
        const ajaxForm = zui.AjaxForm.query($form);
        if(ajaxForm)
        {
            const onSuccess = ajaxForm.options.onSuccess;
            ajaxForm.options.load = false;
            ajaxForm.options.onSuccess = (result) =>
            {
                onSave && onSave((typeof result === 'object' && result) ? result.changes : undefined);
                if(onSuccess) return onSuccess(result);
            }
        }

        $element.toggleClass('has-batch-form', !!$element.find('.panel-form-batch').length);

        this.applyFormData($form);
    }

    applyFormData($form)
    {
        $form = $form || $(this.base).find('form').filter(function() {return $(this).closest('#formSettingBtn').length === 0;});
        let formData = this.props.data;
        if(typeof formData === 'object' && !Array.isArray(formData))
        {
            const keys = Object.keys(formData);
            if(keys.length === 1 && Array.isArray(formData[keys[0]])) formData = formData[keys[0]];
        }
        window.top.applyFormData(formData, $form);
        this.props.onApplied && this.props.onApplied();
    }

    componentDidMount()
    {
        this.load();
    }

    componentDidUpdate(prevProps)
    {
        if(prevProps.location !== this.props.location)
        {
            this.load();
            return;
        }
        if(prevProps.data !== this.props.data || prevProps.applyID !== this.props.applyID)
        {
            this.applyFormData();
        }
    }

    _handleClick = (event) =>
    {
        const $target = $(event.target);
        if($target.closest('[data-back]').length)
        {
            event.preventDefault();
            event.stopPropagation();
            this.props.onBack && this.props.onBack();
        }
    };

    render()
    {
        return jsx`<div class="ai-agent-result-form" onClick=${this._handleClick}></div>`;
    }
}

class AIProcedureRunJSX extends zui.ReactComponent
{
    static sharedStates = {};

    static chatProcedureRunMap = new Map();

    static generatingChatSet$ = signal(new Set());

    _store$ = signal(zui.AIPanel.shared?.store);

    _preparing$ = signal(false);

    _generating$ = computed(() => this._preparing$.value || AIProcedureRunJSX.generatingChatSet$.value.has(this._chat$.value));

    _stopping$ = signal(false);

    _accepting$ = signal(false);

    _stopped = false;

    _chat$ = signal(null);

    _openForm$ = signal(null);

    _result$ = signal(null);

    _viewStep$ = signal(null);

    _formRef = createRef();

    _formData = null;

    _agentInfo = null;

    _procedureRunID = null;

    _saveQueue = Promise.resolve();

    _mounted = false;

    _autoGenerateKey = '';

    constructor(props)
    {
        super(props);
        this.resetState(this.props, true);

        this._chatEffect = zui.effect(() => {
            const chatID = this._chat$.value;
            if(chatID) AIProcedureRunJSX.chatProcedureRunMap.set(chatID, this._procedureRunID);
        });
    }

    _getSharedStateKey(props = this.props)
    {
        const procedureRun = props?.procedureRun;
        if(!procedureRun) return '';

        return `${procedureRun.id}:${procedureRun.currentStep}`;
    }

    _saveSharedState(props = this.props)
    {
        if(this._stopped) return;

        const stateKey = this._getSharedStateKey(props);
        if(!stateKey) return;

        const state = {
            chatID: this._chat$.value,
            openForm: this._openForm$.value,
            formData: this._formRef.current?.formData ?? this._formData,
            agentInfo: this._agentInfo,
            result: this._result$.value,
        };
        Object.assign(AIProcedureRunJSX.sharedStates[stateKey] ||= {}, state);
    }

    componentDidMount()
    {
        this._mounted = true;
        if(!this._store$.value)
        {
            parent.waitAIPanel().then(() =>
            {
                if(!this._mounted) return;
                this._store$.value = zui.AIPanel.shared.store;
                this._autoGenerate();
            });
        }
        this._autoGenerate();
    }

    componentDidUpdate()
    {
        this._autoGenerate();
    }

    componentWillUnmount()
    {
        this._mounted = false;
        this._saveSharedState();
        this._chatEffect && this._chatEffect();
    }

    _autoGenerate()
    {
        const stateKey = this._getSharedStateKey();
        if(!this._mounted || !this._store$.value || this._chat$.value || this._result$.value || this._autoGenerateKey === stateKey) return;
        if(this._viewingHistory || this._stopped || this._stopping$.value || this._accepting$.value || this.props.procedureRun.status !== 'doing') return;
        if(this.props.procedureRun.stepAgent?.fields?.length) return;

        this._autoGenerateKey = stateKey;
        this._formData = this._formRef.current?.formData ?? this._formData;
        return this.generate();
    }

    resetState(props, init)
    {
        if(!init) this._saveSharedState();

        const stateKey = this._getSharedStateKey(props);
        const sharedState = AIProcedureRunJSX.sharedStates[stateKey] || {};
        const procedureRun = props.procedureRun;
        const stepData = procedureRun ? procedureRun.stepsData.steps.find(step => step.id === procedureRun.currentStep) : null;
        this._procedureRunID = procedureRun?.id ?? null;
        batch(() =>
        {
            this._preparing$.value = false;
            this._chat$.value = sharedState.chatID ?? (stepData ? stepData.sessionID : null);
            this._openForm$.value = sharedState.openForm ?? null;
            this._formData = sharedState.formData ?? stepData?.formData ?? null;
            this._agentInfo = sharedState.agentInfo ?? null;
            this._result$.value = sharedState.result ?? (stepData ? stepData.result : null);
            this._viewStep$.value = procedureRun?.currentStep ?? null;
        });
    }

    get _viewingHistory()
    {
        return this._viewStep$.value !== this.props.procedureRun.currentStep;
    }

    _handleViewStep = (stepID) =>
    {
        const {procedureRun} = this.props;
        const steps = procedureRun.stepsData.steps;
        const stepIndex = steps.findIndex(step => step.id === stepID);
        const currentIndex = steps.findIndex(step => step.id === procedureRun.currentStep);
        if(stepIndex < 0 || stepIndex > currentIndex || this._stopping$.value || this._accepting$.value || this._stopped) return;

        this._viewStep$.value = stepID;
    };

    async generate()
    {
        if(this._viewingHistory || this._stopped || this._stopping$.value || this._accepting$.value || this._generating$.value || !this._store$.value || this.props.procedureRun.status !== 'doing') return;

        const stateKey = this._getSharedStateKey();
        const sharedState = AIProcedureRunJSX.sharedStates[stateKey] ||= {};
        const pendingGeneration = sharedState.generating;
        this._preparing$.value = true;
        try
        {
            if(!pendingGeneration)
            {
                sharedState.generating = (async () =>
                {
                    const checkedResult = await window.checkZAIPanel(true);
                    if(!checkedResult || this._stopped || this._viewingHistory || stateKey !== this._getSharedStateKey()) return;

                    await this._generate(stateKey);
                })();
            }
            await sharedState.generating;
        }
        catch(error)
        {
            if(this._mounted && !this._stopped && stateKey === this._getSharedStateKey()) zui.Messager.fail(this.props.langData.generateFailed);
        }
        finally
        {
            if(!pendingGeneration) sharedState.generating = null;
            if(stateKey === this._getSharedStateKey())
            {
                if(pendingGeneration) batch(() =>
                {
                    const viewStep = this._viewStep$.value;
                    this.resetState(this.props, true);
                    this._viewStep$.value = viewStep;
                });
                this._preparing$.value = false;
                this._saveSharedState();
            }
        }
    }

    async _generate(stateKey)
    {
        const store = this._store$.value;
        const oldChatID = this._chat$.value;
        const {procedureRun, langData} = this.props;
        const {stepAgent, currentStepInfo, steps, stepsData, objectID, objectType} = procedureRun;
        const isFirstStep = currentStepInfo.id === steps[0].id;
        const panelLang = zui.AIPanel.shared.options.langData;
        const objectTypes = langData.objectTypes || {};

        let agentInfo = {...stepAgent};
        if(isFirstStep)
        {
            const promptExecuteResult = await $.getJSON($.createLink('ai', 'promptExecute', `promptId=${stepAgent.id}&objectId=${objectID}`));
            if(promptExecuteResult && promptExecuteResult.callback) agentInfo = promptExecuteResult.callback.params[0];
        }
        else
        {
            const promptExecuteResult = await $.getJSON($.createLink('ai', 'ajaxTestPrompt', `promptId=${agentInfo.id}`));
            const remoteAgentInfo = promptExecuteResult && promptExecuteResult.data;
            if(remoteAgentInfo)
            {
                ['schema', 'dataPropNames'].forEach(key =>
                {
                    if(agentInfo[key] === undefined) agentInfo[key] = remoteAgentInfo[key];
                });
            }
        }
        if(this._stopped || stateKey !== this._getSharedStateKey()) return;
        agentInfo = $.extend({}, agentInfo, {fields: null, promptID: stepAgent.id, noTargetForm: !agentInfo.targetForm || agentInfo.targetForm === 'empty.empty' || agentInfo.targetForm === 'coding'});
        if(agentInfo.actionPurpose === 'coding') agentInfo.targetForm = 'coding';
        const creatingOptions = window.top.getAgentCreatingOptions(agentInfo);

        if(!isFirstStep)
        {
            const agentTool = creatingOptions.tools[0];
            if(agentTool)
            {
                agentTool.parameters.properties.objectType = {type: 'string', description: '本次操作需要修改的对象类型，如果为空则可以忽略'};
                agentTool.parameters.properties.objectID = {type: 'string', description: '本次操作需要修改的对象ID，如果为空则可以忽略'};
            }

            const prompts = [agentInfo.role, zui.formatString(langData.stepPromptPrefix, {objectType, objectID})];
            const stepsDataMap = stepsData.steps.reduce((map, step) => {map[step.id] = step; return map;}, {});
            let inputs = currentStepInfo.inputs || {};
            if(typeof inputs === 'string') inputs = JSON.parse(inputs);
            Object.values(inputs).forEach(inputStepID => {
                const inputStep = stepsDataMap[inputStepID];
                if(!inputStep || !inputStep.result) return;

                let stepResult = inputStep.result;
                if(Array.isArray(stepResult)) stepResult = {changes: stepResult};

                const stepPromps = [zui.formatString(langData.stepResultPrefix, {title: stepResult.title || [procedureRun.objectTitle, procedureRun.procedureName, stepAgent.name].join(' - ')})];
                if(stepResult.output !== undefined && stepResult.output !== null)
                {
                    stepPromps.push(typeof stepResult.output === 'string' ? stepResult.output : JSON.stringify(stepResult.output));
                }

                if(Array.isArray(stepResult.changes))
                {
                    for(const change of stepResult.changes)
                    {
                        stepPromps.push((change.desc ? `${change.change}: ` : '') + zui.formatString(langData.stepResultChangeInfo, {
                            action: langData.stepResultActions[change.type] || change.type,
                            count: change.objectList.length,
                            objectType: change.objectType,
                            objectName: objectTypes[change.objectType] || change.objectType,
                            ids: change.objectList.join(',')
                        }));
                    }
                }
                prompts.push(stepPromps.join('\n'));
            });
            prompts.push(langData.stepPurposeHint);
            creatingOptions.prompt = prompts.filter(Boolean).join('\n\n');
        }

        if(!agentInfo.noTargetForm)
        {
            const toolFn = creatingOptions.tools[0].fn;
            creatingOptions.tools[0].fn = async (response) =>
            {
                if(!isFirstStep && response.objectID)
                {
                    const promptExecuteResult = await $.getJSON($.createLink('ai', 'promptExecute', `promptId=${agentInfo.id}&objectId=${response.objectID}`));
                    if(!promptExecuteResult || promptExecuteResult.result === 'fail' || !promptExecuteResult.callback)
                    {
                        return zui.formatString(langData.promptExecuteFailed, {action: agentInfo.name});
                    }
                    const remoteAgentInfo = promptExecuteResult && promptExecuteResult.callback.params[0];
                    if(remoteAgentInfo)
                    {
                        remoteAgentInfo.objectData = remoteAgentInfo.objectData || remoteAgentInfo.object;
                        ['formLocation', 'objectData', 'objectID', 'objectProps', 'objectType', 'targetFormName', 'dataPropNames'].forEach(key =>
                        {
                            if(agentInfo[key] === undefined) agentInfo[key] = remoteAgentInfo[key];
                        });
                    }
                }
                const result = await toolFn(response);
                const taskResult = result.message.custom_data.taskResults[0];
                taskResult.onOpenTargetForm = this.openPageForm;
                return result;
            };
        }

        const chatID = await store.createChat(creatingOptions);
        if(!chatID) throw new Error('Cannot create procedure chat.');
        if(this._stopped || stateKey !== this._getSharedStateKey()) return;
        const previousState = {agentInfo: this._agentInfo, result: this._result$.value, openForm: this._openForm$.value};
        batch(() =>
        {
            this._chat$.value = chatID;
            this._agentInfo = agentInfo;
            this._result$.value = null;
            this._openForm$.value = null;
        });

        try
        {
            let saved = false;
            await this._saveProcedureRunStep({sessionID: chatID}, () => {saved = true;}, {onMessage: () => {}});
            if(!saved) throw new Error('Cannot save procedure chat.');
        }
        catch(error)
        {
            if(!this._stopped && stateKey === this._getSharedStateKey()) batch(() =>
            {
                this._chat$.value = oldChatID;
                this._agentInfo = previousState.agentInfo;
                this._result$.value = previousState.result;
                this._openForm$.value = previousState.openForm;
            });
            throw error;
        }
        if(this._stopped || stateKey !== this._getSharedStateKey()) return;

        this._saveSharedState();
        const formData = this._formData;
        const message = {invisibleContent: formData ? [agentInfo.purpose, panelLang.formCurrentData, JSON.stringify(formData)].join('\n') : agentInfo.purpose};
        await store.postMessage({content: [message], chat: chatID});

        if(oldChatID && oldChatID !== chatID)
        {
            try {
                await store.deleteChat(oldChatID);
            } catch {}
        }
    }

    openPageForm = (location, data, callback) =>
    {
        const hash = location.split('#')[1];
        if(hash === 'open-modal' || hash.startsWith('open-modal?')) return openPageFormOrigin.call(this, location, data, callback);
        if(this._stopped) return;
        this._openForm$.value = {location, data, onApplied: callback, applyID: zui.nextGid()};
    };

    _handleGenerate = () => {
        if(this._viewingHistory || this._stopped || this._stopping$.value || this._accepting$.value || this.props.procedureRun.status !== 'doing') return;

        const form = this._formRef.current;
        if(form && !form.validate()) return;

        this._formData = form ? form.formData : null;
        return this.generate();
    };

    _cancelOpenForm = () => {
        this._openForm$.value = null;
    };

    _handleAcceptResult = async () =>
    {
        if(this._viewingHistory || this._stopped || this._stopping$.value || this._accepting$.value || this.props.procedureRun.status !== 'doing') return;

        this._accepting$.value = true;
        this._formData = this._formRef.current?.formData ?? this._formData;
        const result = this._result$.value;
        const {procedureRun} = this.props;
        try
        {
            await this._saveProcedureRunStep({result, status: 'done'}, (savedRun) =>
            {
                window.loadAIWorkbenchPanel(savedRun.status === 'done' ? {objectID: procedureRun.objectID, objectType: procedureRun.objectType} : null);
            });
        }
        finally
        {
            this._accepting$.value = false;
        }
    };

    _handleStopProcedureRun = async () =>
    {
        if(this._viewingHistory || this._stopped || this._stopping$.value || this._accepting$.value || this.props.procedureRun.status !== 'doing') return;

        const {procedureRun, langData} = this.props;
        this._stopping$.value = true;
        try
        {
            await zui.ajaxSubmit({
                url: $.createLink('aiprocedure', 'ajaxStopProcedureRun', `procedureRunID=${procedureRun.id}`),
                confirm: {
                    title: langData.stopProcedureRun,
                    message: jsx`<span>${zui.formatString(langData.confirmStopProcedureRun, {name: procedureRun.procedureName})}</span>`,
                    actions: [{key: 'confirm', text: langData.stopProcedureRun}, 'cancel'],
                },
                beforeSubmit: () => this._saveQueue,
                onSuccess: () =>
                {
                    this._stopped = true;
                    const chatID = this._chat$.value;
                    if(chatID) this._store$.value?.stopGenerating(chatID);
                    Object.keys(AIProcedureRunJSX.sharedStates).forEach(key =>
                    {
                        if(key.startsWith(`${procedureRun.id}:`)) delete AIProcedureRunJSX.sharedStates[key];
                    });
                    window.loadAIWorkbenchPanel({objectID: procedureRun.objectID, objectType: procedureRun.objectType});
                },
                onError: () => zui.Messager.fail(langData.stopProcedureRunFailed),
            });
        }
        finally
        {
            this._stopping$.value = false;
        }
    };

    _saveProcedureRunStep(extraStepData, onSuccess, options)
    {
        if(this._stopped) return Promise.resolve();

        const {procedureRun} = this.props;
        const {id}     = procedureRun;
        const formSchema = window.top.getPromptFormConfig(procedureRun.stepAgent?.fields)?.schema;
        const stepData = {id: procedureRun.currentStep, formData: this._formData, formSchema, result: this._result$.value, sessionID: this._chat$.value, ...extraStepData};
        const submitOptions = options || {};
        const optionsOnSuccess = submitOptions.onSuccess;
        const savePromise = this._saveQueue.then(() => this._stopped ? undefined : zui.ajaxSubmit(
        {
            ...submitOptions,
            url: $.createLink('aiprocedure', 'ajaxSaveProcedureRunStep', `procedureRunID=${id}`),
            data: {stepData: JSON.stringify(stepData)},
            onSuccess: (data) =>
            {
                if(data.result !== 'success' || this._stopped) return;
                const optionsResult = optionsOnSuccess && optionsOnSuccess(data);
                if(optionsResult === false) return false;
                return onSuccess ? onSuccess(data.data) : optionsResult;
            },
        }));
        this._saveQueue = savePromise.catch(() => {});
        return savePromise;
    }

    _renderStepsNav()
    {
        const {procedureRun, langData} = this.props;
        const {stepsData} = procedureRun;
        const currentIndex = stepsData.steps.findIndex(step => step.id === procedureRun.currentStep);
        const isLastStep = procedureRun.currentStep === stepsData.steps[stepsData.steps.length - 1].id;
        const disabled = this._stopped || this._stopping$.value || this._accepting$.value || procedureRun.status !== 'doing';
        return jsx`<div className="ai-procedure-run-steps-nav row items-center px-4 py-3 border-b">
            <ol class="list-unstyled flex items-center ai-procedure-steps scrollbar-thin scrollbar-hover">
                ${stepsData.steps.map((step, index) => jsx`<li key=${step.id} class=${step.id === this._viewStep$.value ? 'bg-primary text-white' : (index <= currentIndex ? 'primary-pale' : '')}>
                    <button type="button" class="ai-procedure-step-btn" disabled=${disabled || index > currentIndex}
                        aria-current=${step.id === procedureRun.currentStep ? 'step' : undefined}
                        aria-pressed=${step.id === this._viewStep$.value} title=${step.name}
                        onClick=${() => this._handleViewStep(step.id)}>
                        <span class="index">${index < currentIndex ? jsx`<i class="icon icon-check text-success"></i>` : index + 1}</span>
                        <span class="name text-ellipsis">${step.name}</span>
                    </button>
                </li>`)}
            </ol>
            <div class="flex-auto"></div>
            <div class="toolbar gap-4">
                ${this._viewingHistory ? jsx`<button type="button" class="btn secondary" onClick=${() => this._handleViewStep(procedureRun.currentStep)}>${langData.returnToCurrentStep}</button>` : jsx`
                    <button type="button" class="btn secondary" disabled=${disabled} aria-busy=${this._stopping$.value} onClick=${this._handleStopProcedureRun}>${langData.stopProcedureRun}</button>
                    <button type="button" class="btn primary" disabled=${disabled} aria-busy=${this._accepting$.value} onClick=${this._handleAcceptResult}>${isLastStep ? langData.complete : langData.acceptAndContinue}</button>
                `}
            </div>
        </div>`;
    }

    _handleSaveForm = (data) =>
    {
        if(this._stopped) return;

        const {procedureRun} = this.props;
        const {stepAgent} = procedureRun;
        let result = data;
        const defaultTitle = [procedureRun.objectTitle, procedureRun.procedureName, stepAgent.name].join(' - ');
        if(result && typeof result === 'object')
        {
            if(Array.isArray(result)) result = {changes: result, title: defaultTitle};
        }
        else if((stepAgent.targetForm || '').startsWith(stepAgent.module + '.'))
        {
            result = {
                changes: [
                    {type: 'update', objectType: procedureRun.objectType, objectList: [procedureRun.objectID]}
                ],
                title: defaultTitle,
            };
        }
        else
        {
            result = {
                title: defaultTitle,
            };
            console.warn(`[AIProcedureRun] Cannot get procedure step result for ${defaultTitle}`);
        }

        batch(() =>
        {
            this._result$.value = result;
            this._openForm$.value = null;
            this._saveProcedureRunStep(null, null, {onMessage: () => {}});
        });
    };

    _handleChatUpdate = (chat) =>
    {
        if(this._stopped || chat.id !== this._chat$.value) return;

        if(this.props.requireFillFormForNextStep)
        {
            const agentInfo = this._agentInfo;
            if(!agentInfo || (agentInfo.targetForm && agentInfo.targetForm !== 'empty.empty')) return;
        }

        if(!chat.messages?.length) return;

        const lastMessage = chat.messages[chat.messages.length - 1];
        if(lastMessage.role === 'assistant' && lastMessage.$state === 'synced' && lastMessage.content.length)
        {
            const {procedureRun} = this.props;
            const {stepAgent} = procedureRun;
            this._result$.value = {title: [procedureRun.objectTitle, procedureRun.procedureName, stepAgent.name].join(' - '), output: lastMessage.content};
            this._saveProcedureRunStep(null, null, {onMessage: () => {}});
        }
    };

    _renderOpenForm()
    {
        const openForm = this._openForm$.value;
        if(!openForm) return null;

        const {location, data, onApplied, applyID} = openForm;
        return jsx`<div class="flex-auto center min-w-0" key="result-form">
            <${AgentResultFormJSX}
                location=${location}
                data=${data}
                applyID=${applyID}
                agent=${this._agentInfo}
                onApplied=${onApplied}
                onBack=${this._cancelOpenForm}
                onSave=${this._handleSaveForm}
            //>
        </div>`;
    }

    _renderAgentForm()
    {
        if(this._openForm$.value) return this._renderOpenForm();

        const {procedureRun, langData} = this.props;
        const {stepAgent} = procedureRun;
        const formConfig = stepAgent ? window.top.getPromptFormConfig(stepAgent.fields) : null;
        const generating = this._generating$.value;
        const disabled = !this._store$.value || generating || this._stopping$.value || this._accepting$.value || this._stopped || procedureRun.status !== 'doing';
        return jsx`<div class="w-1/2 p-3 border-r flex-none" key=${`form-${procedureRun.id}-${procedureRun.currentStep}`} style="max-width: 500px">
            ${formConfig ? jsx`<${FormBuilder}
                schema=${{...formConfig.schema, title: langData.fillFormInfo}}
                defaultData=${this._formData}
                ref=${this._formRef}
            //>` : null}
            <div class="mt-5 mx-2">
                <button type="button" class="btn primary w-full" disabled=${disabled} aria-busy=${generating} onClick=${this._handleGenerate}>${generating ? langData.generating : (this._chat$.value ? langData.regenerate : langData.generate)}</button>
            </div>
        </div>`;
    }

    _renderSessionChat()
    {
        const store  = this._store$.value;
        const chatID = this._chat$.value;
        if(!store || !chatID)
        {
            return jsx`<div class="flex-auto center" key="chat-empty">
                <div class="muted">${this._generating$.value ? this.props.langData.generating : this.props.langData.noChatHint}</div>
            </div>`;
        }

        const openForm = this._openForm$.value;
        return jsx`<div class=${`${openForm ? 'flex-none' : 'flex-auto'} relative`} style=${openForm ? {width: '400px'} : undefined} key="chat">
            <${AIChatView}
                key=${chatID}
                store=${store}
                chatID=${chatID}
                hideHeader
                onUpdate=${this._handleChatUpdate}
            //>
        </div>`;
    }

    _handleHistoryChatAction = (event) =>
    {
        // Chat forms and tool actions can submit independently of the sendbox.
        if(event.type === 'keydown' && event.key === 'Tab') return;
        if(event.type !== 'submit' && !$(event.target).closest('.ai-chat-sendbox, .ai-questions-panel, .ai-message-form, .ai-message-tool-calling-actions, .ai-tool-call-result-actions').length) return;

        event.preventDefault();
        event.stopPropagation();
    };

    _renderHistoryStep()
    {
        if(!this._viewingHistory) return null;

        const {procedureRun, langData} = this.props;
        const stepID = this._viewStep$.value;
        const stepData = procedureRun.stepsData.steps.find(step => step.id === stepID);
        if(!stepData) return null;

        const stepInfo = procedureRun.steps.find(step => step.id === stepID);
        const formSchema = stepData.formSchema ?? window.top.getPromptFormConfig(stepInfo?.fields)?.schema;
        const store = this._store$.value;
        return jsx`<div class="ai-procedure-history col flex-auto min-h-0" key=${`history-${stepID}`}>
            <div class="row items-stretch flex-auto min-h-0">
                <div class="w-1/2 p-3 border-r flex-none overflow-y-auto" style="max-width: 400px">
                    <div class="mb-3 text-gray">${langData.historyReadonlyHint}</div>
                    ${formSchema && stepData.formData ? jsx`<${FormBuilder}
                        schema=${{...formSchema, title: langData.stepFormData}}
                        defaultData=${stepData.formData}
                        readonly=${true}
                    //>` : jsx`<div class="muted">${langData.noStepFormData}</div>`}
                </div>
                <div class="ai-procedure-history-chat flex-auto relative min-w-0 min-h-0" aria-label=${langData.historyReadonlyHint}
                    onClickCapture=${this._handleHistoryChatAction}
                    onKeyDownCapture=${this._handleHistoryChatAction}
                    onBeforeInputCapture=${this._handleHistoryChatAction}
                    onChangeCapture=${this._handleHistoryChatAction}
                    onPasteCapture=${this._handleHistoryChatAction}
                    onDropCapture=${this._handleHistoryChatAction}
                    onSubmitCapture=${this._handleHistoryChatAction}>
                    ${store && stepData.sessionID ? jsx`<${AIProcedureHistoryChatJSX}
                        key=${stepData.sessionID}
                        store=${store}
                        chatID=${stepData.sessionID}
                        hideHeader
                        sendbox=${false}
                    //>` : jsx`<div class="h-full center muted">${stepData.sessionID ? zui.i18n.getLang('loading') : langData.noStepChat}</div>`}
                </div>
            </div>
        </div>`;
    }

    render()
    {
        const {procedureRun} = this.props;
        return jsx`<div className="ai-procedure-run h-full col" key=${procedureRun.id}>
            <div className="ai-procedure-run-header row items-center gap-3 p-3 border-b flex-none">
                <div className="label label-id gray-300-outline size-sm rounded-full flex-none ml-1">
                    ${procedureRun.objectID}
                </div>
                <div className="text-lg font-bold">
                    ${procedureRun.objectTitle}
                </div>
            </div>
            ${this._renderStepsNav()}
            <div class="row items-stretch flex-auto min-h-0" style=${this._viewingHistory ? {display: 'none'} : undefined}>
                ${this._renderAgentForm()}
                ${this._renderSessionChat()}
            </div>
            ${this._renderHistoryStep()}
        </div>`;
    }
}

class AIProcedureRun extends zui.ComponentFromReact
{
    static NAME = 'AIProcedureRun';

    static Component = AIProcedureRunJSX;
}

AIProcedureRun.register();

class ObjectTypesPickerJSX extends zui.ReactComponent
{
    _selections$ = signal([]);

    _userSelections$ = signal([]);

    _show$ = signal(false);

    _menuRef = createRef();

    _all$ = computed(() => {
        const selections = new Set(this._selections$.value);
        return this.props.items.every(item => selections.has(item.key) || item.key === 'all');
    });

    _hideEffect = zui.effect(() => {
        if(this._show$.value) return;

        const selectionsBeforeHide = this._selectionsBeforeHide
        const selections = this._selections$.value.sort().join('_');
        if(selectionsBeforeHide === selections) return;

        this._selectionsBeforeHide = selections;
        loadAIWorkbenchPanel({types: selections});
    });

    constructor(props)
    {
        super(props);
        this._selections$.value = this._formatSelections(props.selections);
        this._selectionsBeforeHide = this._selections$.peek().slice().sort().join('_');
    }

    _formatSelections(selections)
    {
        if(!selections || selections === 'all') return (this.props.items || []).filter(item => item.key !== 'all').map(x => x.key);
        return Array.from(new Set(typeof selections === 'string' ? selections.split('_') : selections)).filter(x => x.length);
    }

    _select(key)
    {
        if(key === 'all')
        {
            this._selections$.value = this._formatSelections('all');
            this._show$.value = false;
            return;
        }
        const selections = new Set(this._selections$.value);
        if(selections.has(key))
        {
            if(selections.size === 1) return;
            selections.delete(key);
        }
        else selections.add(key);

        this._selections$.value = Array.from(selections);
    }

    _handleCheckItem = (change, checks) =>
    {
        this._userSelections$.value = checks;
    };

    _handleClick = () =>
    {
        this._show$.value = !this._show$.value;
        if(this._show$.value)
        {
            this._userSelections$.value = this._selections$.value;
        }
    };

    _handleCancelClick = () =>
    {
        zui.batch(() =>
        {
            this._show$.value = false;
            this._userSelections$.value = [];
        });
    };

    _handleConfirmClick = () =>
    {
        zui.batch(() =>
        {
            this._show$.value = false;
            if(this._userSelections$.value.length) this._selections$.value = this._userSelections$.value;
        });
    };

    _handleSelectAllClick = () =>
    {
        const selections = new Set(this._userSelections$.value);
        const allItems   = this.props.items.filter(item => item.key !== 'all');
        const all        = allItems.every(item => selections.has(item.key));
        this._userSelections$.value = all ? [] : allItems.map(item => item.key);
        this._menuRef.current.toggleAllChecked(!all);
    };

    _renderMenu(props)
    {
        if(!this._show$.value) return null;

        const Menu       = zui.Menu.Component;
        const items      = [];
        const selections = new Set(this._userSelections$.value);
        let all          = true;
        let allText      = '';
        for(const item of props.items)
        {
            if(item.key === 'all')
            {
                allText = item.text;
                continue;
            }
            const selected = selections.has(item.key);
            if(!selected) all = false;
            items.push({text: item.text, key: item.key, checked: selected});
        }

        return jsx`<div class="popup absolute right-0 top-full z-10" style="min-width: 180px;">
            <${Menu}
                items=${items}
                checkbox
                checkOnClick="any"
                ref=${this._menuRef}
                onCheck=${this._handleCheckItem}
            //>
            <div class="toolbar p-2 border-t gap-2">
                <div class=${`ml-2 checkbox-primary${all ? ' checked' : ''}`} onClick=${this._handleSelectAllClick}><label>${allText || zui.i18n.getLang('selectAll')}</label></div>
                <div class="flex-auto"></div>
                <button type="button" class="btn size-sm primary" disabled=${!this._userSelections$.value.length} onClick=${this._handleConfirmClick}>${zui.i18n.getLang('confirm')}</button>
                <button type="button" class="btn size-sm" onClick=${this._handleCancelClick}>${zui.i18n.getLang('cancel')}</button>
            </div>
        </div>`;
    }

    _handleClickOutside = (event) =>
    {
        if(!this._show$.value || $(event.target).closest('.object-types-picker').length) return;
        this._show$.value = false;
    };

    componentDidMount()
    {
        $(document).on('click', this._handleClickOutside);
    }

    componentWillUnmount()
    {
        $(document).off('click', this._handleClickOutside);
        this._hideEffect();
    }

    render(props)
    {
        const selections = this._selections$.value;
        const typeMap = (this.props.items || []).reduce((map, item) => {map[item.key] = item.text; return map;}, {});
        let displayText = '';
        if(this._all$.value) displayText = typeMap.all;
        else if(selections.length < 3) displayText = selections.map(x => typeMap[x] || x).join(', ');
        else displayText = zui.formatString(props.selectedTypesText, {count: selections.length});

        return jsx`<div class="object-types-picker relative">
            <button type="button" class="btn size-md" onClick=${this._handleClick}>
                ${displayText}
                <span class=${this._show$.value ? 'caret-up' : 'caret'}></span>
            </button>
            ${this._renderMenu(props)}
        </div>`;
    }
}

class ObjectTypesPicker  extends zui.ComponentFromReact
{
    static NAME = 'ObjectTypesPicker';

    static Component = ObjectTypesPickerJSX;
}

ObjectTypesPicker.register();
