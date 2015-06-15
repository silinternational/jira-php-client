<?php return [
    'baseUrl' => 'https://jira63d.jaars.org/secure/rest/api',
    'apiVersion' => '2',
    'operations' => [
        'GetUser' => [
            'httpMethod' => 'GET',
            'uri' => '/{ApiVersion}/user?username={username}',
            'responseModel' => 'User',
            'parameters' => [
                'ApiVersion' => [
                    'required' => true,
                    'type'     => 'string',
                    'location' => 'uri',
                ],
                'username' => [
                    'required' => true,
                    'type' => 'string',
                    'location' => 'uri',
                ],
            ]
        ],
        'AddUser' => [
            'httpMethod' => 'POST',
            'uri' => '/{ApiVersion}/user',
            'responseModel' => 'User',
            'parameters' => [
                'ApiVersion' => [
                    'required' => true,
                    'type'     => 'string',
                    'location' => 'uri',
                ],
                'name' => [
                    'required' => true,
                    'type' => 'string',
                    'location' => 'json'
                ],
                'password' => [
                    'required' => false,
                    'type' => 'string',
                    'location' => 'json'
                ],
                'emailAddress' => [
                    'required' => false,
                    'type' => 'string',
                    'location' => 'json'
                ],
                'displayName' => [
                    'required' => false,
                    'type' => 'string',
                    'location' => 'json'
                ],
                'active' => [
                    'required' => false,
                    'type' => 'boolean',
                    'location' => 'json'
                ]
            ]
        ],
        'UpdateUser' => [
            'httpMethod' => 'PUT',
            'uri' => '/{ApiVersion}/user?username={username}',
            'responseModel' => 'Result',
            'parameters' => [
                'ApiVersion' => [
                    'required' => true,
                    'type'     => 'string',
                    'location' => 'uri',
                ],
                'username' => [
                    'required' => true,
                    'type' => 'string',
                    'location' => 'uri',
                ]
                'password' => [
                    'required' => false,
                    'type' => 'string',
                    'location' => 'json'
                ],
                'emailAddress' => [
                    'required' => false,
                    'type' => 'string',
                    'location' => 'json'
                ],
                'displayName' => [
                    'required' => false,
                    'type' => 'string',
                    'location' => 'json'
                ],
                'active' => [
                    'required' => false,
                    'type' => 'boolean',
                    'location' => 'json'
                ]
            ]
        ],
        'DeactivateUser' => [
            'httpMethod' => 'PUT',
            'uri' => '/{ApiVersion}/user?username={username}',
            'responseModel' => 'User',
            'parameters' => [
                'ApiVersion' => [
                    'required' => true,
                    'type'     => 'string',
                    'location' => 'uri',
                ],
                'username' => [
                    'required' => true,
                    'type' => 'string',
                    'location' => 'uri',
                ],
                'active' => [
                    'required' => true,
                    'type' => 'boolean',
                    'location' => 'json'
                ]
            ]
        ],
        'ActivateUser' => [
            'httpMethod' => 'PUT',
            'uri' => '/{ApiVersion}/user?username={username}',
            'responseModel' => 'User',
            'parameters' => [
                'ApiVersion' => [
                    'required' => true,
                    'type'     => 'string',
                    'location' => 'uri',
                ],
                'username' => [
                    'required' => true,
                    'type' => 'string',
                    'location' => 'uri',
                ],
                'active' => [
                    'required' => true,
                    'type' => 'boolean',
                    'location' => 'json'
                ]
            ]
        ],
        'DeleteUser' => [
            'httpMethod' => 'DELETE',
            'uri' => '/{ApiVersion}/user?username={username}',
            'responseModel' => 'User',
            'parameters' => [
                'ApiVersion' => [
                    'required' => true,
                    'type'     => 'string',
                    'location' => 'uri',
                ],
                'username' => [
                    'required' => true,
                    'type' => 'string',
                    'location' => 'uri',
                ],
            ]
        ]
    ],
    'models' => [
        'User' => [
            'type' => 'object',
            'properties' => [
                'statusCode' => ['location' => 'statusCode']
            ],
            'additionalProperties' => [
                'location' => 'json'
            ]
        ],
        'Result' => [
            'type' => 'object',
            'properties' => [
                'statusCode' => ['location' => 'statusCode']
            ],
            'additionalProperties' => [
                'location' => 'json'
            ]
        ]
    ]

];