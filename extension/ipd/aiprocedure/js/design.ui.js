/**
 * AI procedure designer for a page that already loads ZUI 3 + ZenTao Flow/Picker.
 * Load this file after zui.js and load ai-procedure-app.css once on the page.
 * This is the editable source: no build step or second Preact runtime is needed.
 */
(function (zui) {
    'use strict';

    if (!zui?.ReactComponent || !zui.ComponentFromReact || !zui.jsx
        || !zui.Flow || !zui.Picker?.Component || !zui.Modal || !zui.Messager) {
        throw new Error('AiProcedureDesigner requires ZUI 3 with Flow, Picker, Modal and Messager.');
    }
    // Repeated script loads must not replace the constructor of mounted instances.
    if (zui.AiProcedureDesigner?.EXTERNAL) {
        return;
    }

    const {ReactComponent, ComponentFromReact, jsx, createRef, Flow, Modal, Messager} = zui;
    const Picker = zui.Picker.Component;
    const escape = value => zui.escapeHtml(String(value ?? ''));
    const labelsDefault = {
        'load-failed-title': '数据加载失败',
        'load-failed-message': '请稍后重试',
        'save-failed-title': '保存失败',
        'save-failed-message': '请检查内容是否正确',
        'save-success': '保存成功',
        'publish-success': '发布成功',
        'step-config': '步骤配置',
        'step-output': '步骤的输出结果',
        'last-step-warning': '至少需要保留一个步骤',
        'select-agent': '选择禅道智能体',
        'agent-required': '请选择禅道智能体',
        'select-input': '选择输入内容',
        'select-input-hint': '选择之前步骤的输出结果作为这一步骤的提词',
        'agent-process-object': '处理对象',
        'agent-action-purpose': '操作对象',
        'agent-display-position': '显示位置',
        'agent-role': '角色',
        'agent-purpose': '提词',
        'agent-skills-list': '挂载技能',
        'agent-knowledge-list': '挂载知识库',
        'no-agents': '暂无可用的禅道智能体',
        'add-step': '添加步骤',
        'delete-step': '删除步骤',
        back: '返回',
        retry: '重试',
        save: '保存',
        publish: '发布',
        confirm: '确定',
        start: '开始',
        end: '结束',
        step: '步骤',
        'agent-status-draft': '未发布',
        'agent-status-deleted': '已删除',
        'publish-failed-title': '发布失败',
        'publish-need-active-agents': '发布失败，工序中的智能体"%s"未上架或已被删除，请先上架智能体后再发布工序。',
    };

    // The three original node icons are embedded below so the file is portable.
    const icons = {
        step: `<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
    <path d="M0 4C0 1.79086 1.79086 0 4 0H20C22.2091 0 24 1.79086 24 4V20C24 22.2091 22.2091 24 20 24H4C1.79086 24 0 22.2091 0 20V4Z" fill="#007AFF"/>
    <path d="M5.53218 9.5873C5.36714 9.70019 5.29592 9.88732 5.31854 10.0643L5.31854 13.9357C5.29592 14.1127 5.36714 14.2998 5.53218 14.4127L11.7176 18.6433C11.8878 18.7597 12.1119 18.7597 12.2821 18.6433L18.4675 14.4127C18.6286 14.3026 18.7003 14.1217 18.6826 13.9485V10.0515C18.7003 9.87837 18.6286 9.69748 18.4675 9.58731L12.2821 5.35671C12.1119 5.24031 11.8878 5.24031 11.7176 5.35671L5.53218 9.5873ZM6.43442 10L11.5748 6.48413V9.45433L8.60573 11.4851L6.43442 10ZM12.4248 9.45433V6.48413L17.5653 10L15.394 11.4851L12.4248 9.45433ZM7.85291 12L6.16854 13.1521V10.848L7.85291 12ZM17.8326 10.847V13.1531L16.1468 12L17.8326 10.847ZM15.394 12.5149L17.5653 14L12.4248 17.5159V14.5457L15.394 12.5149ZM11.5748 14.5457V17.5159L6.43442 14L8.60573 12.5149L11.5748 14.5457ZM14.6412 12L11.9999 13.8066L9.35855 12L11.9998 10.1935L14.6412 12Z" fill="white"/>
</svg>`,
        'step-start': `<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
    <path d="M0 4C0 1.79086 1.79086 0 4 0H20C22.2091 0 24 1.79086 24 4V20C24 22.2091 22.2091 24 20 24H4C1.79086 24 0 22.2091 0 20V4Z" fill="#12A772"/>
    <path d="M11.9999 18.6666C15.6818 18.6666 18.6666 15.6819 18.6666 12C18.6666 8.31808 15.6818 5.33331 11.9999 5.33331C8.31802 5.33331 5.33325 8.31808 5.33325 12C5.33325 15.6819 8.31802 18.6666 11.9999 18.6666Z" fill="white" stroke="white" stroke-width="2" stroke-linejoin="round"/>
    <path d="M10.6667 12V9.69061L12.6667 10.8453L14.6667 12L12.6667 13.1547L10.6667 14.3094V12Z" fill="#12A772" stroke="#12A772" stroke-width="2" stroke-linejoin="round"/>
</svg>`,
        'step-end': `<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
  <path d="M0 4C0 1.79086 1.79086 0 4 0H20C22.2091 0 24 1.79086 24 4V20C24 22.2091 22.2091 24 20 24H4C1.79086 24 0 22.2091 0 20V4Z" fill="#12A772"/>
  <path d="M11.9999 18.6666C15.6818 18.6666 18.6666 15.6819 18.6666 12C18.6666 8.31808 15.6818 5.33331 11.9999 5.33331C8.31802 5.33331 5.33325 8.31808 5.33325 12C5.33325 15.6819 8.31802 18.6666 11.9999 18.6666Z" fill="white" stroke="white" stroke-width="2" stroke-linejoin="round"/>
  <path d="M10.3333 10V14V10Z" fill="#12A772"/>
  <path d="M13.6666 10V14V10Z" fill="#12A772"/>
  <path d="M10.3333 10V14H13.6666V10H10.3333Z" fill="#12A772"/>
  <path d="M10.3333 10V14V10Z" stroke="#12A772" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
  <path d="M13.6666 10V14V10Z" stroke="#12A772" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
  <path d="M10.3333 10V14H13.6666V10H10.3333Z" stroke="#12A772" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
</svg>`,
    };

    const newStepId = () => 'tmp_' + Array.from(window.crypto.getRandomValues(new Uint8Array(8)), value => value.toString(36).slice(-1)).join('');
    const inputIds = value => String(value || '').split(',').filter(Boolean);

    function createLink(method, params) {
        const helpers = window.$?.createLink ? window.$ : zui.$;
        if (!helpers?.createLink) {
            throw new Error('AiProcedureDesigner requires ZenTao $.createLink or a custom api option.');
        }
        return helpers.createLink('aiprocedure', method, params);
    }

    const defaultAPI = {
        getProcedureInfo(id) {
            return zui.fetchData(createLink('ajaxGetInfo', `id=${encodeURIComponent(id)}`));
        },
        getAgents() {
            return zui.fetchData(createLink('ajaxGetAgents'));
        },
        async saveProcedureData(id, data, publish = false) {
            // Suppress the generic AjaxForm feedback: the designer owns save/publish feedback.
            const [result, error] = await zui.ajaxSubmit({
                url: createLink('ajaxEditProcedure', `id=${encodeURIComponent(id)}&type=${publish ? 'active' : 'draft'}`),
                data,
            });
            if (error) {
                throw error;
            }
            return result;
        },
    };

    function graphData(props, width) {
        const {steps, labels, currentNode, disabled, addStep, editStep, deleteStep} = props;
        const items = [
            {id: 'step-start', name: labels.start, nodeType: 'step-start'},
            ...steps.map(step => ({...step, nodeType: 'step'})),
            {id: 'step-end', name: labels.end, nodeType: 'step-end'},
        ];
        const nodes = items.map((step, index) => {
            const isStep = step.nodeType === 'step';
            const nodeWidth = isStep ? 240 : 84;
            const nodeHeight = 42;
            const name = escape(step.name || labels.step);
            /* 只有未上架、已删除的智能体需要展示状态，已上架的无需展示。 */
            const statusKey = isStep && ['draft', 'deleted'].includes(String(step.agentStatus || '')) ? String(step.agentStatus) : '';
            const statusLabel = statusKey ? labels[`agent-status-${statusKey}`] : '';
            const statusHtml = statusLabel ? `<span class="step-status step-status-${escape(statusKey)}">${escape(statusLabel)}</span>` : '';
            const html = isStep
                ? `<div class="step-node">
                    <button type="button" class="step-edit nodrag" data-procedure-action="edit" title="${name}" ${disabled ? 'disabled' : ''}>
                        <span class="step-head">${icons.step}<span class="step-title">${name}</span></span>
                        ${statusHtml}
                    </button>
                    <button type="button" class="step-delete nodrag" data-procedure-action="delete" aria-label="${escape(labels['delete-step'])}: ${name}" ${disabled ? 'disabled' : ''}>
                        <i class="icon icon-close" aria-hidden="true"></i>
                    </button>
                </div>`
                : `<div class="step-terminal">${icons[step.nodeType]}<span>${name}</span></div>`;
            return {
                id: step.id,
                type: 'customType1',
                width: nodeWidth,
                height: nodeHeight,
                position: {x: Math.max(10, (width - nodeWidth) / 2), y: 10 + index * 82},
                draggable: false,
                selectable: false,
                connectable: false,
                class: [
                    isStep && !step.agent ? 'procedure-invalid' : '',
                    step.id === currentNode ? 'procedure-current' : '',
                ].filter(Boolean).join(' '),
                data: {
                    nodeType: step.nodeType,
                    html,
                    handles: [
                        ...(index ? [{id: 'top', type: 'target', position: 'top'}] : []),
                        ...(index < items.length - 1 ? [{id: 'bottom', type: 'source', position: 'bottom'}] : []),
                    ],
                    onNodeClick: (event) => {
                        if (!isStep || disabled) {
                            return;
                        }
                        const action = event.detail.event.target?.closest?.('[data-procedure-action]')?.dataset.procedureAction;
                        if (action === 'delete') {
                            deleteStep(step.id);
                        } else {
                            editStep(step.id);
                        }
                    },
                },
            };
        });
        const edges = nodes.slice(0, -1).map((node, index) => ({
            id: `edge-${node.id}-${nodes[index + 1].id}`,
            type: 'buttonedge',
            source: node.id,
            target: nodes[index + 1].id,
            selectable: false,
            markerEnd: {type: 'arrowclosed'},
            data: {
                html: `<i class="icon icon-plus" aria-hidden="true"></i><span class="procedure-sr-only">${escape(labels['add-step'])}</span>`,
                onEdgeClick: () => !disabled && addStep(index),
            },
        }));
        return {nodes, edges, nodeTypes: ['customType1'], edgeTypes: ['buttonedge']};
    }

    // Use the public vanilla Flow class; its private Preact entry is not a dependency.
    class ProcedureFlow extends Flow {
        render(options, reset) {
            if (!this.destroyed) {
                super.render(options, reset);
            }
        }
    }

    class ProcedureCanvas extends ReactComponent {
        _root = createRef();
        _mounted = false;
        _loadId = 0;
        state = {loading: true, failed: false};

        componentDidMount() {
            this._mounted = true;
            this._resize = new window.ResizeObserver(() => this.updateFlow());
            this._resize.observe(this._root.current);
            this.loadFlow();
        }

        componentDidUpdate() {
            this.updateFlow();
        }

        componentWillUnmount() {
            this._mounted = false;
            this._loadId++;
            this._resize.disconnect();
            this._flow?.destroy();
        }

        loadFlow = async () => {
            const loadId = ++this._loadId;
            this.setState({loading: true, failed: false});
            try {
                await Flow.loadModule();
                if (!this._mounted || loadId !== this._loadId) {
                    return;
                }
                this._flow = new ProcedureFlow(this._root.current, {
                    width: '100%',
                    height: '100%',
                    controls: {showZoom: true, showFitView: true, showLock: false},
                    minimap: false,
                    flow: graphData(this.props, this._root.current.clientWidth),
                });
                this.setState({loading: false});
            } catch (_error) {
                if (this._mounted && loadId === this._loadId) {
                    this.setState({loading: false, failed: true});
                }
            }
        };

        updateFlow() {
            if (this._flow?.inited) {
                this._flow.render({flow: graphData(this.props, this._root.current.clientWidth)});
            }
        }

        onKeyDown = (event) => {
            // XYFlow also handles Enter/Space on its parent node. Own action buttons
            // use native keyboard activation without dispatching a second node action.
            if (event.target.closest('[data-procedure-action]') && ['Enter', ' '].includes(event.key)) {
                event.stopPropagation();
            }
        };

        render({labels, disabled}, {loading, failed}) {
            return jsx`<div class=${zui.classes('procedure-canvas load-indicator', {loading, 'procedure-busy': disabled})} aria-busy=${loading}>
                <div class="flow" ref=${this._root} onKeyDownCapture=${this.onKeyDown}></div>
                ${failed && jsx`<div class="procedure-load-error" role="alert">
                    <p>${labels['load-failed-title']}</p>
                    <button type="button" class="btn" onClick=${this.loadFlow}>${labels.retry}</button>
                </div>`}
            </div>`;
        }
    }

    class AgentCard extends ReactComponent {
        render({data, labels}) {
            const fields = [
                ['processObject', 'agent-process-object'],
                ['displayPosition', 'agent-display-position'],
                ['role', 'agent-role'],
                ['purpose', 'agent-purpose'],
            ];
            const lists = [['skills', 'agent-skills-list'], ['knowledgeLibs', 'agent-knowledge-list']].map(([field, label]) => {
                if (!data[field]?.length) {
                    return null;
                }
                return jsx`<div key=${field}><h4>${labels[label]}</h4><ul>${data[field].map((value, index) => jsx`<li key=${index}>${value}</li>`)}</ul></div>`;
            });
            return jsx`<div class="agent-card w-full">
                ${fields.map(([field, label]) => jsx`<div key=${field}><h4>${labels[label]}</h4><p>${data[field]}</p></div>`)}
                ${lists}
            </div>`;
        }
    }

    class StepForm extends ReactComponent {
        _id = `procedure-form-${newStepId()}`;
        _agentPicker = createRef();
        _inputsPicker = createRef();
        state = {...this.props.data, error: false};

        componentDidUpdate(oldProps) {
            if (oldProps.data !== this.props.data) {
                this.setState({...this.props.data, error: false});
            }
        }

        getAgent = value => this.props.agentGroups.flatMap(group => group.items).find(agent => String(agent.id) === value);

        agentOnChange = (value) => {
            const agent = this.getAgent(value);
            this.setState({
                agent: value,
                name: agent?.name || this.state.name,
                inputs: value === this.state.agent ? this.state.inputs : '',
                error: false,
            });
        };

        beforeSubmit = (event) => {
            event.preventDefault();
            if (this.props.disabled) {
                return;
            }
            if (!this.state.agent) {
                this.setState({error: true}, () => document.getElementById(`pick-${this._id}-agent`)?.focus());
                return;
            }
            const {name, agent, inputs} = this.state;
            this.props.onSubmit(this.props.data.id, {name, agent, inputs});
        };

        pickerAttrs(name, ref) {
            return {
                tabIndex: this.props.disabled ? -1 : 0,
                'aria-labelledby': `${this._id}-${name}-label`,
                onKeyDown: (event) => {
                    if (!this.props.disabled && event.target === event.currentTarget && ['Enter', ' ', 'ArrowDown'].includes(event.key)) {
                        event.preventDefault();
                        ref.current?.open();
                    }
                },
            };
        }

        render({data, steps, agentGroups, labels, disabled}, {agent, inputs, error}) {
            const index = steps.findIndex(step => step.id === data.id);
            const agentOptions = agentGroups.map(group => ({text: group.text, items: group.items.map(item => ({text: item.name, value: String(item.id)}))}));
            const inputsOptions = steps.slice(0, index).map(step => ({value: step.id, text: `${step.name}${labels['step-output']}`}));
            const selectedAgent = this.getAgent(agent);
            return jsx`<form class="form form-grid" noValidate onSubmit=${this.beforeSubmit}>
                <div class="form-group w-full">
                    <label id=${`${this._id}-agent-label`} class="form-label required">${labels['select-agent']}</label>
                    <${Picker} ref=${this._agentPicker} id=${`${this._id}-agent`} className="form-control" items=${agentOptions} name="agent" value=${agent || ''}
                        disabled=${disabled} popWidth="100%"
                        attrs=${{...this.pickerAttrs('agent', this._agentPicker), 'aria-required': true, 'aria-invalid': error, 'aria-describedby': error ? `${this._id}-error` : undefined}}
                        onChange=${this.agentOnChange} />
                    ${error && jsx`<p id=${`${this._id}-error`} class="procedure-field-error" role="alert">${labels['agent-required']}</p>`}
                    ${!agentGroups.some(group => group.items.length) && jsx`<p class="procedure-empty" role="status">${labels['no-agents']}</p>`}
                </div>
                ${index > 0 && jsx`<div class="form-group w-full">
                    <label id=${`${this._id}-inputs-label`} class="form-label">${labels['select-input']}
                        <i class="icon icon-help text-gray-400" title=${labels['select-input-hint']} aria-hidden="true"></i>
                    </label>
                    <${Picker} ref=${this._inputsPicker} id=${`${this._id}-inputs`} className="form-control" multiple items=${inputsOptions} name="inputs" value=${inputs || ''}
                        disabled=${disabled} popWidth="100%" attrs=${this.pickerAttrs('inputs', this._inputsPicker)}
                        onChange=${value => this.setState({inputs: value})} />
                </div>`}
                <div class="form-actions">
                    <button type="submit" class="btn primary btn-wide" disabled=${disabled}>${labels.confirm}</button>
                </div>
                ${selectedAgent && jsx`<hr class="w-full" /><${AgentCard} data=${selectedAgent} labels=${labels} />`}
            </form>`;
        }
    }

    class AiProcedureDesignerView extends ReactComponent {
        _active = false;
        _request = 0;
        _saving = false;
        _loaded = false;
        state = {loading: true, saving: false, failed: false, saveFailed: false, steps: [], agentGroups: [], currentNode: ''};

        get labels() {
            return {...labelsDefault, ...this.props.labels};
        }

        get api() {
            return {...defaultAPI, ...this.props.api};
        }

        componentDidMount() {
            this._active = true;
            this.loadData();
        }

        componentDidUpdate(oldProps) {
            if (oldProps.id !== this.props.id || oldProps.api !== this.props.api) {
                this.loadData();
            }
        }

        componentWillUnmount() {
            this._active = false;
            this._request++;
        }

        navGoBack = () => {
            if (this.props.goBack) {
                this.props.goBack();
            } else {
                window.history.go(-1);
            }
        };

        loadData = async () => {
            const request = ++this._request;
            this._loaded = false;
            this._saving = false;
            this.setState({loading: true, saving: false, failed: false, saveFailed: false, steps: [], currentNode: '', agentGroups: []});
            try {
                const api = this.api;
                const [procedure, agents] = await Promise.all([api.getProcedureInfo(this.props.id), api.getAgents()]);
                if (!this._active || request !== this._request) {
                    return;
                }
                const sourceSteps = procedure?.data?.steps ?? [];
                if (!procedure?.data || !Array.isArray(sourceSteps) || !Array.isArray(agents?.data?.agents)) {
                    throw new Error('Invalid procedure response');
                }
                const steps = sourceSteps.map(step => ({
                    id: String(step.id ?? newStepId()),
                    name: step.name || this.labels.step,
                    agent: String(step.agent ?? ''),
                    agentStatus: String(step.agentStatus ?? ''),
                    inputs: String(step.inputs ?? ''),
                }));
                if (!steps.length) {
                    steps.push({id: newStepId(), name: this.labels.step, agent: '', agentStatus: '', inputs: ''});
                }
                this._loaded = true;
                this.setState({loading: false, steps, agentGroups: agents.data.agents, currentNode: steps[0].id});
            } catch (_error) {
                if (this._active && request === this._request) {
                    this.setState({loading: false, failed: true});
                }
            }
        };

        editStep = (id) => {
            if (this._active && this._loaded && !this._saving && this.state.steps.some(step => step.id === id)) {
                this.setState({currentNode: id});
            }
        };

        addStep = (index) => {
            if (!this._active || !this._loaded || this._saving) {
                return;
            }
            const step = {id: newStepId(), name: this.labels.step, agent: '', agentStatus: '', inputs: ''};
            const steps = [...this.state.steps];
            steps.splice(index, 0, step);
            this.setState({steps, currentNode: step.id});
        };

        deleteStep = (id) => {
            if (!this._active || !this._loaded || this._saving) {
                return;
            }
            const index = this.state.steps.findIndex(step => step.id === id);
            if (index < 0) {
                return;
            }
            if (this.state.steps.length === 1) {
                Messager.show({type: 'danger', message: this.labels['last-step-warning']});
                return;
            }
            const steps = this.state.steps.filter(step => step.id !== id).map(step => ({...step, inputs: inputIds(step.inputs).filter(input => input !== id).join(',')}));
            this.setState({steps, currentNode: this.state.currentNode === id ? steps[Math.min(index, steps.length - 1)].id : this.state.currentNode});
        };

        updateStepData = (id, data) => {
            if (!this._active || !this._loaded || this._saving) {
                return;
            }
            this.setState(({steps}) => ({
                steps: steps.map(step => step.id === id ? {...step, ...data, agentStatus: this.agentStatusOf(data.agent)} : step),
            }), () => this.onSave());
        };

        /* 智能体重新选择后状态会变为已上架，未重新选择时保留原有状态。 */
        agentStatusOf = (agentID) => {
            if (!agentID) {
                return '';
            }
            const isActive = this.state.agentGroups.some(group => group.items.some(item => String(item.id) === String(agentID)));
            if (isActive) {
                return 'active';
            }
            const step = this.state.steps.find(item => String(item.agent) === String(agentID) && item.agentStatus);
            return step ? step.agentStatus : '';
        };

        /* 步骤引用的智能体未上架（或已删除）时，不允许发布。 */
        unpublishedSteps = steps => steps.filter(step => step.agent && step.agentStatus && step.agentStatus !== 'active');

        showPublishBlocked = (steps) => {
            const labels = this.labels;
            const seen = new Set();
            const names = [];
            steps.forEach(step =>
            {
                if (seen.has(step.agent)) {
                    return;
                }
                seen.add(step.agent);
                const status = labels[`agent-status-${step.agentStatus}`] || step.agentStatus;
                names.push(`${step.name || labels.step}（${status}）`);
            });
            Modal.alert({title: labels['publish-failed-title'], message: String(labels['publish-need-active-agents']).replace('%s', names.join('、'))});
        };

        onSave = async (publish = false) => {
            const {steps} = this.state;
            if (!this._active || !this._loaded || this._saving || !steps.length || steps.some(step => !step.agent)) {
                return;
            }
            if (publish) {
                const blocked = this.unpublishedSteps(steps);
                if (blocked.length) {
                    this.setState({saveFailed: false});
                    this.showPublishBlocked(blocked);
                    return;
                }
            }
            this._saving = true;
            this.setState({saving: true, saveFailed: false});
            const request = this._request;
            const labels = this.labels;
            const payload = {};
            steps.forEach((step, index) => {
                const values = {id: step.id, agent: step.agent, inputs: index ? step.inputs : ''};
                Object.entries(values).forEach(([key, value]) => {
                    payload[`steps[${index}][${key}]`] = value;
                });
            });
            try {
                const result = await this.api.saveProcedureData(this.props.id, payload, publish);
                if (!this._active || request !== this._request) {
                    return;
                }
                if (result?.result !== 'success') {
                    const serverMessage = typeof result?.message === 'string' ? result.message.trim() : '';
                    const failure = new Error('Procedure save failed');
                    failure.serverMessage = serverMessage;
                    throw failure;
                }
                if (publish) {
                    this.navGoBack();
                }
            } catch (error) {
                if (this._active && request === this._request) {
                    this.setState({saveFailed: true});
                    const message = error?.serverMessage ? error.serverMessage : labels['save-failed-message'];
                    Modal.alert({title: labels[publish ? 'publish-failed-title' : 'save-failed-title'], message});
                }
            } finally {
                if (this._active && request === this._request) {
                    this._saving = false;
                    this.setState({saving: false});
                }
            }
        };

        render({name, published, height = '648px'}, {loading, saving, failed, saveFailed, steps, agentGroups, currentNode}) {
            const labels = this.labels;
            const disabled = loading || saving || failed;
            const saveDisabled = disabled || !steps.length || steps.some(step => !step.agent);
            const currentStep = steps.find(step => step.id === currentNode);
            return jsx`<div class=${zui.classes('ai-procedure-app ai-procedure-designer load-indicator', {loading})}
                style=${{'--ai-procedure-app-height': height}} aria-busy=${loading || saving}>
                <div class="ai-procedure-app-toolbar">
                    <div class="toolbar-back">
                        <button type="button" class="btn primary square circle" title=${labels.back} aria-label=${labels.back} onClick=${this.navGoBack}>
                            <i class="icon icon-2x icon-angle-left" aria-hidden="true"></i>
                        </button>
                        <span title=${name}>${name}</span>
                    </div>
                    <div class="toolbar-btns">
                        <button type="button" class="btn rounded-md" disabled=${saveDisabled} onClick=${() => this.onSave()}>
                            <i class=${saving ? 'animate-spin icon icon-spinner-indicator' : 'icon icon-save'} aria-hidden="true"></i>${labels.save}
                        </button>
                        ${!published && jsx`<button type="button" class="btn rounded-md primary" disabled=${saveDisabled} onClick=${() => this.onSave(true)}>
                            <i class=${saving ? 'animate-spin icon icon-spinner-indicator' : 'icon icon-publish'} aria-hidden="true"></i>${labels.publish}
                        </button>`}
                    </div>
                </div>
                ${failed ? jsx`<div class="procedure-load-error" role="alert">
                    <p>${labels['load-failed-title']}：${labels['load-failed-message']}</p>
                    <button type="button" class="btn" onClick=${this.loadData}>${labels.retry}</button>
                </div>` : jsx`<div class="ai-procedure-view">
                    ${!loading && jsx`<${ProcedureCanvas} steps=${steps} currentNode=${currentNode} labels=${labels} disabled=${disabled}
                        addStep=${this.addStep} editStep=${this.editStep} deleteStep=${this.deleteStep} />`}
                    ${currentStep && jsx`<aside class="ai-procedure-panel show" aria-label=${labels['step-config']}>
                        <div class="ai-procedure-panel-header"><span>${labels['step-config']}</span></div>
                        <hr />
                        <div class="ai-procedure-panel-content">
                            <${StepForm} key=${currentStep.id} data=${currentStep} steps=${steps} agentGroups=${agentGroups}
                                labels=${labels} disabled=${disabled} onSubmit=${this.updateStepData} />
                        </div>
                    </aside>`}
                </div>`}
            </div>`;
        }
    }

    class AiProcedureDesigner extends ComponentFromReact {
        static NAME = 'AiProcedureDesigner';
        static Component = AiProcedureDesignerView;
        static EXTERNAL = true;
    }

    AiProcedureDesigner.register();
    // Registration alone does not expose a global constructor.
    zui.AiProcedureDesigner = AiProcedureDesigner;
})(window.zui);
