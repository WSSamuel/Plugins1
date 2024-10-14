<?php

return [
    'general' => [
        'label'    => '',
        'sections' => [
            'main' => [
                'fields' => [
                    'useWpBodyOpen'   => [
                        'label'   => sprintf(
                            esc_html__('Use hook %s', 'galaksion-tag-manager'),
                            '<code>wp_body_open</code>'
                        ),
                        'widget'  => 'checkbox',
                        'params'  => [
                            'checkboxOptions' => [
                                'label' => esc_html__('Enable', 'galaksion-tag-manager'),
                            ],
                        ],
                        'desc'    => sprintf(
                            esc_html__('Check if your theme support hook %s', 'galaksion-tag-manager'),
                            '<code>wp_body_open</code>'
                        ),
                        'default' => false,
                    ],
                    'usePlaceholders' => [
                        'label'   => sprintf(
                            esc_html__('%s<placeholders>%s support', 'galaksion-tag-manager'),
                            '<code>',
                            '</code>'
                        ),
                        'widget'  => 'checkbox',
                        'params'  => [
                            'checkboxOptions' => [
                                'label' => esc_html__('Enable', 'galaksion-tag-manager'),
                            ],
                        ],
                        'desc'    => esc_html__('Check if you want to put tags in any place of your page by inserting placeholders in theme templates', 'galaksion-tag-manager'),
                        'default' => false,
                    ],
                ],
            ],
        ],
    ],
];
