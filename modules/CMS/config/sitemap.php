<?php
return [
	[
		'name' => 'Dashboard',
		'label' => 'cms::core.sections.dashboard',
		'icon' => 'dashboard',
		'url' => route('backend.dashboard'),
		'priority' => 0,
	],
	[
		'name' => 'Content',
		'label' => 'cms::core.sections.content',
		'icon' => 'pencil-square-o',
		'priority' => 200,
	],
	[
		'name' => 'Design',
		'label' => 'cms::core.sections.design',
		'icon' => 'desktop',
		'priority' => 7000
	],
	[
		'name' => 'System',
		'label' => 'cms::core.sections.system',
		'icon' => 'cog',
		'priority' => 8000,
		'children' => [
			[
				'name' => 'Information',
				'label' => 'cms::core.sections.about',
				'url' => route('backend.about'),
				'permissions' => 'system.about',
				'priority' => 90,
				'icon' => 'info-circle',
			],
			[
				'name' => 'Settings',
				'label' => 'cms::core.sections.settings',
				'url' => route('backend.settings'),
				'permissions' => 'system.settings',
				'priority' => 100,
				'icon' => 'cog',
			]
		]
	],
];