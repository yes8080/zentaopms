<?php
$lang->aiteammate->disabled         = 'Standby';
$lang->aiteammate->enabled          = 'Working';
$lang->aiteammate->taskList         = 'Task List';
$lang->aiteammate->create           = 'Create AI Teammate';
$lang->aiteammate->edit             = 'Edit AI Teammate';
$lang->aiteammate->teammateTaskList = 'AI Teammate Task List';
$lang->aiteammate->noData           = 'No AI Teammate';
$lang->aiteammate->name             = 'Name';
$lang->aiteammate->nameDuplicated   = 'This name is already taken, please enter another name';
$lang->aiteammate->role             = 'Role';
$lang->aiteammate->agents           = 'Abilities';
$lang->aiteammate->llm              = 'Default Conversation Model';
$lang->aiteammate->desc             = 'Description';
$lang->aiteammate->descPlaceholder  = 'Please enter content';
$lang->aiteammate->klibs            = 'Mount Knowledge Library';
$lang->aiteammate->klibsAddTip      = 'Mount Knowledge Library to enhance your AI Teammate capabilities.';
$lang->aiteammate->avatar           = 'Upload AI Teammate Avatar';
$lang->aiteammate->uploadAvatar     = 'Upload Avatar';
$lang->aiteammate->avatarTips       = 'Click to add, max 1MB';
$lang->aiteammate->errorUploadSize  = 'File size cannot exceed 1MB';
$lang->aiteammate->promptTips       = 'Want to generate the same AI Teammate avatar? Click the card below to copy and view the prompts of built-in AI Teammates!';
$lang->aiteammate->browse           = 'Browse AI Teammate';
$lang->aiteammate->enable           = 'Enable AI Teammate';
$lang->aiteammate->disable          = 'Disable AI Teammate';
$lang->aiteammate->delete           = 'Delete AI Teammate';
$lang->aiteammate->assignedTo       = 'Assign AI Teammate';
$lang->aiteammate->noticeTime       = 'Notice Time';
$lang->aiteammate->afterSaving      = 'After Saving';
$lang->aiteammate->back             = 'Back';

$lang->aiteammate->action['disable'] = 'Disable';
$lang->aiteammate->action['enable']  = 'Enable';

$lang->aiteammate->confirmEnable  = 'Are you sure you want to enable this AI Teammate?';
$lang->aiteammate->confirmDisable = 'After disabling, users will not be able to use this AI Teammate. Are you sure you want to disable it?';
$lang->aiteammate->confirmDelete  = 'Are you sure you want to delete this AI Teammate?';
$lang->aiteammate->enableSuccess  = 'AI Teammate enabled';
$lang->aiteammate->disableSuccess = 'AI Teammate disabled';
$lang->aiteammate->disableHint    = 'This teammate has unclosed tasks and cannot be disabled.';
$lang->aiteammate->copySuccess    = 'Copy success';

$lang->aiteammate->defaultRoles = array();
$lang->aiteammate->defaultRoles['achan'] = array(
    'avatar' => 'static/zentaoaipro/ai-teammate-po.jpg',
    'name'   => 'Achan',
    'role'   => 'Product Manager',
    'prompt' => <<<PROMPT
    A realistic digital teammate portrait with "ZenTao-style professional temperament":
    Not flashy, not pretentious, not relying on marketing packaging, but gaining trust through real capabilities and habits.
    Calm but powerful eyes, reflecting long-termism, structured thinking, and trustworthy collaboration.

    【Role Information】
    Position: Product Manager
    Gender: Female
    Age: 26 years old
    Education: Well-known university product design major, double major in Computer Science + Product Design
    Work Style: No boasting, no chasing trends, speaking through real progress, clear logic, and verifiable results.

    【ZenTao Values Presentation】
    Truth-seeking and goodness: Avoid over-packaged speech, use facts and logic to avoid empty statements.
    Mutual trust and altruism: Direct but friendly communication, focusing on team results rather than personal performance shows.
    Self-improvement and responsibility: No blame-shifting, self-driven, think through problems clearly before collaborating to solve them.
    Knowledge-seeking and practice: Like learning while practicing, don't blindly follow big concepts, value actionable methods more.
    Integrity and simplicity: No tricks, no excessive decoration, no showing off, maintaining simplicity and trustworthiness.

    【Character Core Story】
    Personality: Humble, self-disciplined, not competing for expression rights, but clear and solid when expressing.
    Interests and professional philosophy connections:
    Love for mountaineering: Believe that problem-solving is not a burst, but gradual progress upward, and willing to put in effort
    Weekly running: Maintaining rhythm is more important than sprinting, just like iteration
    Hobby of reading: Prefer structured information, dislike fragmented inspirational quotes, favor logic and frameworks
    She/He believes: Good tools can improve efficiency, but good habits create value.

    【Realistic Appearance and Details】
    Asian, skin with real pores preserved, overall clean but with slight dark circles or natural texture, no excessive skin smoothing or beauty enhancement;
    Face brightness slightly enhanced but maintaining soft and natural, no oily shine, no highlighter;
    Eyes with a thoughtful sense, as if listening to questions and preparing to give clear advice;
    Hair long wavy, with some real stray strands, styled elegantly and professionally;
    Clothing is minimalist solid color, white, not flashy.

    【Image Style】
    Lighting: Soft natural light or neutral studio light, face clear but not commercialized, no hard light modification;
    Background: Light gray, light neutral solid color background, clean and not distracting.
    Composition: Above chest or portrait close-up, 50mm natural perspective, looking directly at the camera, showing teeth with smile but not overly commercial

    【Temperament Metaphor】
    Like someone who truly gets things done:
    Not relying on rhetoric, but on clear logic;
    Not pursuing short-term applause, but caring about long-term value;
    Quiet but reliable, low-key yet indispensable.

    PROMPT,
);
$lang->aiteammate->defaultRoles['adao'] = array(
    'avatar' => 'static/zentaoaipro/ai-teammate-td.jpg',
    'name'   => 'Adao',
    'role'   => 'Development Lead',
    'prompt' => <<<PROMPT
    A realistic digital teammate portrait with "ZenTao-style professional temperament":
    Not flashy, not pretentious, not relying on marketing packaging, but gaining trust through real capabilities and habits.
    Calm but powerful eyes, reflecting long-termism, structured thinking, and trustworthy collaboration.

    【Role Information】
    Position: Development Engineer
    Gender: Male
    Age: 28 years old
    Education: Well-known university computer science major
    Work Style: Focus on technical implementation, not flashy, emphasize actual results and verifiable code quality.

    【ZenTao Values Presentation】
    Truth-seeking and goodness: Based on technical facts and logic, avoid empty promises or over-packaging.
    Mutual trust and altruism: Willing to collaborate, focus on team's overall technical progress, rather than personal showing off.
    Self-improvement and responsibility: Proactively solve problems, don't shirk responsibility, remain calm and confident when facing technical challenges.
    Knowledge-seeking and practice: Like to continuously learn new technologies and apply them to actual projects, don't blindly follow authority, value actionable solutions.
    Integrity and simplicity: Maintain technical purity, avoid excessive decoration of code or technical solutions, focus on practicality and maintainability.

    【Character Core Story】
    Personality: Humble, self-disciplined, not competing for expression rights, but clear logic and well-organized in technical communication.
    Interests and professional philosophy connections:
    Love programming: Enjoy the process of solving complex problems through code, believe that technology can bring real value.
    Weekly fitness: Maintain the rhythm of body and mind, like continuously optimizing code and systems.
    Like reading technical books: Prefer clear structure and rigorous logic in technical documentation, not addicted to fragmented information.
    He believes: Excellent tools can improve efficiency, but good coding habits create lasting value.

    【Realistic Appearance and Details】
    Asian male, skin with real pores preserved, overall clean but with slight dark circles or natural texture, no excessive skin smoothing or beauty enhancement;
    Face brightness slightly enhanced but maintaining soft and natural, no oily shine, no highlighter;
    Focused eyes, with a thoughtful sense, as if focusing on solving problems;
    Hair short, naturally fluffy, slightly messy, closer to real male image;
    Clothing is minimalist solid color, white, not flashy.

    【Image Style】
    Lighting: Soft natural light or neutral studio light, face clear but not commercialized, no hard light modification;
    Background: Light gray, light neutral solid color background, clean and not distracting.
    Composition: Above chest or portrait close-up, 50mm natural perspective, looking directly at the camera, slight smile but not overly commercial

    【Temperament Metaphor】
    Like someone who truly implements technology:
    Not relying on flashy code or technical jargon, but on clear logic and high-quality implementation;
    Not pursuing short-term showing off, but caring about long-term technical value and system stability;
    Quiet but reliable, low-key yet indispensable.

    PROMPT,
);
$lang->aiteammate->defaultRoles['lijuan'] = array(
    'avatar' => 'static/zentaoaipro/ai-teammate-qa.jpg',
    'name'   => 'Lijuan',
    'role'   => 'QA',
    'prompt' => <<<PROMPT
    A realistic digital teammate portrait with "ZenTao-style professional temperament":
    Not flashy, not pretentious, not relying on marketing packaging, but gaining trust through real capabilities and habits.
    Calm but powerful eyes, reflecting long-termism, structured thinking, and trustworthy collaboration.

    【Role Information】
    Position: QA Engineer
    Gender: Female
    Age: 32 years old
    Education: Well-known university software engineering or computer-related major
    Work Style: Focus on details, rigorous logic, good at discovering potential problems, pursue system stability and quality assurance.

    【ZenTao Values Presentation】
    Truth-seeking and goodness: Based on data and test results, not relying on subjective judgment or vague descriptions.
    Mutual trust and altruism: Value team collaboration, proactively communicate test findings and risks, promote continuous product improvement.
    Self-improvement and responsibility: Responsible for test quality, don't avoid problems, courageously promote process optimization and tool upgrades.
    Knowledge-seeking and practice: Like to study testing methods, automation scripts and performance analysis, focus on practical results.
    Integrity and simplicity: Maintain the purity of testing work, don't pursue formal "high-end", focus on actual value.

    【Character Core Story】
    Personality: Steady, meticulous, patient, not competing for expression, but clear logic and persuasive when expressing.
    Interests and professional philosophy connections:
    Love reading technical documentation and testing-related books, prefer structured and systematic knowledge systems.
    Like logic reasoning games, such as Sudoku or logic puzzles, consider this an extension of testing thinking.
    Believe: Precise test cases and rigorous execution are the core of ensuring system quality.

    【Realistic Appearance and Details】
    Asian female, skin with real pores preserved, overall clean but with slight dark circles or natural texture, no excessive skin smoothing or beauty enhancement;
    Face brightness slightly enhanced but maintaining soft and natural, no oily shine, no highlighter;
    Focused and calm eyes, with a sense of logical analysis and steadiness;
    Hair naturally flowing or short, slightly messy, closer to real female image;
    Clothing is minimalist solid color, light gray or beige, not flashy.

    【Image Style】
    Lighting: Soft natural light or neutral studio light, face clear but not commercialized, no hard light modification;
    Background: Light gray, light neutral solid color background, clean and not distracting;
    Composition: Above chest or portrait close-up, 50mm natural perspective, looking directly at the camera, slight smile but not overly commercial.

    【Temperament Metaphor】
    Like someone who truly ensures quality:
    Not relying on subjective judgment, but on systematic testing methods and rigorous execution;
    Not pursuing short-term surface results, but caring about long-term system stability and user experience;
    Quiet but reliable, low-key yet indispensable.

    PROMPT,
);
$lang->aiteammate->defaultRoles['xiangqian'] = array(
    'avatar' => 'static/zentaoaipro/ai-teammate-pm.jpg',
    'name'   => 'Xiangqian',
    'role'   => 'Project Manager',
    'prompt' => <<<PROMPT
    A realistic digital teammate portrait with "ZenTao-style professional temperament":
    Not flashy, not pretentious, not relying on marketing packaging, but gaining trust through real capabilities and habits.
    Calm but powerful eyes, reflecting long-termism, structured thinking, and trustworthy collaboration.

    【Role Information】
    Position: Project Manager
    Gender: Male
    Age: 35 years old
    Education: Well-known university management science and engineering or related major
    Work Style: Focus on communication and coordination, goal-oriented, good at coordinating resources and promoting project implementation.

    【ZenTao Values Presentation】
    Truth-seeking and goodness: Based on facts and data, avoid vague statements and ineffective communication.
    Mutual trust and altruism: Value team trust and collaboration, promote overall project progress, rather than personal performance.
    Self-improvement and responsibility: Responsible for project results, proactively solve problems when encountered, no shirking or delay.
    Knowledge-seeking and practice: Like to learn project management methods, tools and process optimization, focus on practical results.
    Integrity and simplicity: Don't pursue formal "high-end", focus on actual project results and team value.

    【Character Core Story】
    Personality: Steady, responsible, good at listening, not competing for expression rights, but organized and persuasive when expressing.
    Interests and professional philosophy connections:
    Love marathon: Believe that project advancement is like long-distance running, focus on rhythm and continuous effort.
    Like reading project management books, prefer structured and systematic knowledge systems.
    Believe: Excellent team cooperation and clear plans are the core of project success.

    【Realistic Appearance and Details】
    Asian male, skin with real pores preserved, overall clean but with slight dark circles or natural texture, no excessive skin smoothing or beauty enhancement;
    Face brightness slightly enhanced but maintaining soft and natural, no oily shine, no highlighter;
    Firm eyes with leadership, reflecting calm judgment and decision-making ability;
    Hair short, slightly sparse but neat, closer to real male image;
    Clothing is minimalist solid color, dark gray, not flashy.

    【Image Style】
    Lighting: Soft natural light or neutral studio light, face clear but not commercialized, no hard light modification;
    Background: Light gray, light neutral solid color background, clean and not distracting;
    Composition: Above chest or portrait close-up, 50mm natural perspective, looking directly at the camera, slight smile but not overly commercial.

    【Temperament Metaphor】
    Like someone who truly implements projects:
    Not relying on flashy expressions or slogans, but on clear plans, effective communication and firm execution;
    Not pursuing short-term surface results, but caring about long-term project stability and team development;
    Steady but reliable, low-key yet indispensable.

    PROMPT,
);

$lang->aiteammate->featureBar['browse'] = array();
$lang->aiteammate->featureBar['browse']['all'] = $lang->all;
$lang->aiteammate->featureBar['browse']['0']   = $lang->aiteammate->enabled;
$lang->aiteammate->featureBar['browse']['1']   = $lang->aiteammate->disabled;

$lang->aiteammate->noticeTimeOptions[] = array('text' => 'Notify me immediately after completion', 'value' => '1');
$lang->aiteammate->noticeTimeOptions[] = array('text' => 'Notify me at a specified time',          'items' => array());

$lang->aiteammate->optionsAfterSaving['1'] = 'Continue delegating work tasks';
$lang->aiteammate->optionsAfterSaving['2'] = 'Return to details';
$lang->aiteammate->optionsAfterSaving['3'] = 'Return to current page';

$lang->aiteammate->tips = new stdClass();
$lang->aiteammate->tips->selectAgent  = 'Hello, I am your AI teammate %name. I can %agent. What would you like me to do for you?';
$lang->aiteammate->tips->assignAITask = 'Good, to ensure the accurate completion of %s, please provide the following information: ';
$lang->aiteammate->tips->invalidName  = '『Name』 length should be <=『10』and >『0』.';
