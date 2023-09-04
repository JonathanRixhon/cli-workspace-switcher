<?php
return [
    [
        'table' => 'workspaces',
        'columns' => [
            'id' => 'INTEGER PRIMARY KEY',
            'name' => 'VARCHAR(255)',
            'path' => 'VARCHAR(255)',
        ]
    ],
    [
        'table' => 'favorite_workspaces',
        'columns' => [
            'id' => 'INTEGER PRIMARY KEY',
            'workspace_id' => 'INT NOT NULL',
            'path' => 'VARCHAR(255)'
        ],
        'fk' => [
            'column' => 'workspace_id',
            'references' => [
                'column' => 'id',
                'table' => 'workspaces',
            ],
        ]
    ],
    [
        'table' => 'ignored_workspaces',
        'columns' => [
            'id' => 'INTEGER PRIMARY KEY',
            'workspace_id' => 'INT NOT NULL',
            'path' => 'VARCHAR(255)'
        ],
        'fk' => [
            'column' => 'workspace_id',
            'references' => [
                'column' => 'id',
                'table' => 'workspaces',
            ],
        ]
    ]
];

/*
CREATE TABLE $table
(
    id INT PRIMARY KEY NOT NULL,
    code_postal VARCHAR(5),
    nombre_achat INT
)
*/