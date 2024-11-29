<?php
return [
  'dashboard' => [
    'title' => 'Panel de Usuario',
    'meta' => [
      'description' => 'Accede a tu panel de control personalizado para gestionar tus servicios, pagos, y más. Organiza y revisa toda la información importante desde tu dashboard.',
      'keywords' => 'dashboard, servicios, pagos, gestión, control, usuario',
      'author' => 'Pedro Luis Condori Cutile',
    ],
  ],

  'service' => [
    'title_service_with_price' => 'Servicios con precio',
    'title_service_without_price' => 'Servicios sin precio',
    'delete_confirmation' => '¿Está seguro de eliminar el servicio',
    'select_category' => 'Seleccionar una categoría',
    'meta' => [
      'create' => [
        'title' => 'Nuevo servicio',
        'description' => 'Crea un nuevo servicio en nuestra plataforma.',
        'keywords' => 'crear servicio, nuevo servicio, plataforma',
      ],
      'edit' => [
        'title' => 'Actualizar servicio',
        'description' => 'Edita y actualiza un servicio existente.',
        'keywords' => 'editar servicio, actualizar servicio, plataforma',
      ],
      'index' => [
        'title' => 'Lista de servicios',
        'description' => 'Explora la lista completa de servicios disponibles.',
        'keywords' => 'lista de servicios, servicios disponibles, plataforma',
      ],
      'show' => [
        'title' => 'Mostrar servicios',
        'description' => 'Consulta los detalles de cada servicio disponible.',
        'keywords' => 'ver servicio, detalles del servicio, plataforma',
      ],
      "author" => 'Pedro Luis Condori Cutile',
    ],
    'resource'=>[
      "create" => "Nuevo servicio",
      "edit" => "Actualizar servicio",
      "show" => "Detalles del servicio",
      "index" => "Lista de servicios",
    ],
    'attribute'=>[
      "name" => "Nombre",
      "description" => "Descripción",
      "amount" => "Monto",
      "commission" => "Comisión",
      "status" => "Estado",
      "category_uuid" => "Categoria",
      "user_id" => "Registrado por",
      "created_at" => "Fecha Registro",
      "updated_at" => "Últ. Act.",
    ],
  ],

  'currency' => [
    'title' => 'Monedas',
    'delete_confirmation' => '¿Está seguro de eliminar la moneda',
    'meta' => [
      'create' => [
        'title' => 'Nueva moneda',
        'description' => 'Crea una nueva moneda en nuestra plataforma.',
        'keywords' => 'crear moneda, nuevo moneda, plataforma',
      ],
      'edit' => [
        'title' => 'Actualizar moneda',
        'description' => 'Edita y actualiza una moneda existente.',
        'keywords' => 'editar moneda, actualizar moneda, plataforma',
      ],
      'index' => [
        'title' => 'Lista de monedas',
        'description' => 'Explora la lista completa de monedas disponibles.',
        'keywords' => 'lista de monedas, monedas disponibles, plataforma',
      ],
      'show' => [
        'title' => 'Mostrar monedas',
        'description' => 'Consulta los detalles de cada moneda disponible.',
        'keywords' => 'ver moneda, detalles de la moneda, plataforma',
      ],
      "author" => 'Pedro Luis Condori Cutile',
    ],
    'resource' => [
      "create" => "Nueva moneda",
      "edit" => "Actualizar moneda",
      "show" => "Detalles de la moneda",
      "index" => "Lista de monedas",
    ],
    'attribute' => [
      "name" => "Nombre",
      "symbol" => "Simbolo",
      "exchange_rate" => "Tasa de cambio",
      "status" => "Estado",
      "created_at" => "Fecha Registro",
      "updated_at" => "Últ. Act.",
    ],
  ],

  'category' => [
    'title' => 'Categorias',
    'delete_confirmation' => '¿Está seguro de eliminar la categoria',
    'meta' => [
      'create' => [
        'title' => 'Nueva categoria',
        'description' => 'Crea una nueva categoria en nuestra plataforma.',
        'keywords' => 'crear categoria, nueva categoria, plataforma',
      ],
      'edit' => [
        'title' => 'Actualizar categoria',
        'description' => 'Edita y actualiza una categoria existente.',
        'keywords' => 'editar categoria, actualizar categoria, plataforma',
      ],
      'index' => [
        'title' => 'Lista de categorias',
        'description' => 'Explora la lista completa de categorias disponibles.',
        'keywords' => 'lista de categorias, categorias disponibles, plataforma',
      ],
      'show' => [
        'title' => 'Mostrar categorias',
        'description' => 'Consulta los detalles de cada categoria disponible.',
        'keywords' => 'ver categoria, detalles de la categoria, plataforma',
      ],
      "author" => 'Pedro Luis Condori Cutile',
    ],
    'resource' => [
      "create" => "Nuevo categoria",
      "edit" => "Actualizar categoria",
      "show" => "Detalles de la categoria",
      "index" => "Lista de categorias",
    ],
    'attribute' => [
      "name" => "Nombre",
      "description" => "Descripción",
      "status" => "Estado",
      "user_id" => "Registrado por",
      "created_at" => "Fecha Registro",
      "updated_at" => "Últ. Act.",
    ],
  ],

  'incomefromtransfer' => [
    'title' => 'Ingresos de transferencias',
    'delete_confirmation' => '¿Está seguro de eliminar el ingreso por transferencia',
    'select_service' => 'Seleccionar un servicio',
    'meta' => [
      'create' => [
        'title' => 'Nuevo ingreso de transferencia',
        'description' => 'Crea un nuevo ingreso de transferencia en nuestra plataforma.',
        'keywords' => 'crear ingreso de transferencia, nuevo ingreso de transferencia, plataforma',
      ],
      'edit' => [
        'title' => 'Actualizar ingreso de transferencia',
        'description' => 'Edita y actualiza un ingreso de transferencia existente.',
        'keywords' => 'editar ingreso de transferencia, actualizar ingreso de transferencia, plataforma',
      ],
      'index' => [
        'title' => 'Lista de ingresos de transferencias',
        'description' => 'Explora la lista completa de ingreso de transferencias disponibles.',
        'keywords' => 'lista de ingreso de transferencias, ingreso de transferencias disponibles, plataforma',
      ],
      'show' => [
        'title' => 'Mostrar ingreso de transferencias',
        'description' => 'Consulta los detalles de cada ingreso de transferencia disponible.',
        'keywords' => 'ver ingreso de transferencia, detalles del ingreso de transferencia, plataforma',
      ],
      "author" => 'Pedro Luis Condori Cutile',
    ],
    'resource' => [
      "create" => "Nuevo ingreso de transferencia",
      "edit" => "Actualizar ingreso de transferencia",
      "show" => "Detalles del ingreso de transferencia",
      "index" => "Lista de ingresos de transferencias",
    ],
    'attribute' => [
      "code" => "Codigo",
      "amount" => "Monto",
      "amount_total" => "Monto Total",
      "commission" => "Comisión",
      "observation" => "Observación",
      "status" => "Estado",
      "service_uuid" => "Servicio",
      "denomination_uuid" => "Denominación",
      "user_id" => "Registrado por",
      "created_at" => "Fecha Registro",
      "updated_at" => "Últ. Act.",
    ],
  ],

  'denomination' => [
    'title' => 'Denominaciones',
    'delete_confirmation' => '¿Está seguro de eliminar la denominación',
    'billete'=>'Billete de ',
    'moneda' => 'Moneda de ',

    'meta' => [
      'create' => [
        'title' => 'Nueva denominación',
        'description' => 'Crea una nueva denominación en nuestra plataforma.',
        'keywords' => 'crear denominación, nuevo denominación, plataforma',
      ],
      'edit' => [
        'title' => 'Actualizar denominación',
        'description' => 'Edita y actualiza una denominación existente.',
        'keywords' => 'editar denominación, actualizar denominación, plataforma',
      ],
      'index' => [
        'title' => 'Lista de denominaciones',
        'description' => 'Explora la lista completa de denominaciones disponibles.',
        'keywords' => 'lista de denominaciones, denominaciones disponibles, plataforma',
      ],
      'show' => [
        'title' => 'Mostrar denominacion',
        'description' => 'Consulta los detalles de cada denominación disponible.',
        'keywords' => 'ver denominación, detalles de la denominación, plataforma',
      ],
      "author" => 'Pedro Luis Condori Cutile',
    ],
    'resource' => [
      "create" => "Nueva denominación",
      "edit" => "Actualizar denominación",
      "show" => "Detalles de la denominación",
      "index" => "Lista de denominaciones",
    ],
    'attribute' => [
      "bill_200" => "200",
      "bill_100" => "100",
      "bill_50" => "50",
      "bill_20" => "20",
      "bill_10" => "10",
      "coin_5" => "5",
      "coin_2" => "2",
      "coin_1" => "1",
      "coin_0_5" => "0.5",
      "coin_0_2" => "0.2",
      "coin_0_1" => "0.1",
      "total" => "TOTAL",
      "total_due" => "TOTAL A COBRAR",
      "change" => "CAMBIO",
      "created_at" => "Fecha Registro",
      "updated_at" => "Últ. Act.",
    ],
  ],

  'customer' => [
    'title' => 'Clientes',
    'delete_confirmation' => '¿Está seguro de eliminar el cliente',
    'meta' => [
      'create' => [
        'title' => 'Nuevo cliente',
        'description' => 'Crea un nuevo cliente en nuestra plataforma.',
        'keywords' => 'crear cliente, nuevo cliente, plataforma',
      ],
      'edit' => [
        'title' => 'Actualizar cliente',
        'description' => 'Edita y actualiza un cliente existente.',
        'keywords' => 'editar cliente, actualizar cliente, plataforma',
      ],
      'index' => [
        'title' => 'Lista de clientes',
        'description' => 'Explora la lista completa de clientes disponibles.',
        'keywords' => 'lista de clientes, clientes disponibles, plataforma',
      ],
      'show' => [
        'title' => 'Mostrar clientes',
        'description' => 'Consulta los detalles de cada cliente disponible.',
        'keywords' => 'ver cliente, detalles del cliente, plataforma',
      ],
      "author" => 'Pedro Luis Condori Cutile',
    ],
    'resource' => [
      "create" => "Nuevo cliente",
      "edit" => "Actualizar cliente",
      "show" => "Detalles del cliente",
      "index" => "Lista de clientes",
    ],
    'attribute' => [
      "first_name" => "Nombres",
      "last_name" => "Apellidos",
      "email" => "Correo electrónico",
      "phone" => "Celular",
      "address" => "Dirección",
      "status" => "Estado",
      "user_id" => "Registrado por",
    ],
  ],

  'user' => [
    'title' => 'Usuarios',
    'delete_confirmation' => '¿Está seguro de eliminar el usuario',
    'assign_roles'=>'Asignar rol',
    'meta' => [
      'create' => [
        'title' => 'Nuevo usuario',
        'description' => 'Crea un nuevo usuario en nuestra plataforma.',
        'keywords' => 'crear usuario, nuevo usuario, plataforma',
      ],
      'edit' => [
        'title' => 'Actualizar usuario',
        'description' => 'Edita y actualiza un usuario existente.',
        'keywords' => 'editar usuario, actualizar usuario, plataforma',
      ],
      'index' => [
        'title' => 'Lista de usuarios',
        'description' => 'Explora la lista completa de usuarios disponibles.',
        'keywords' => 'lista de usuarios, usuarios disponibles, plataforma',
      ],
      'show' => [
        'title' => 'Mostrar usuario',
        'description' => 'Consulta los detalles de cada usuario disponible.',
        'keywords' => 'ver usuario, detalles del usuario, plataforma',
      ],
      "author" => 'Pedro Luis Condori Cutile',
    ],
    'resource' => [
      "create" => "Nuevo usuario",
      "edit" => "Actualizar usuario",
      "show" => "Detalles del usuario",
      "index" => "Lista de usuario",
    ],
    'attribute' => [
      "name" => "Nombre",
      "email" => "Correo electrónico",
      "password" => "Contraseña",
      "created_at" => "Fecha Registro",
      "updated_at" => "Últ. Act.",
    ],
  ],

  'cashcount' => [
    'title' => 'Arqueo de caja',
    'delete_confirmation' => '¿Está seguro de eliminar el arqueo de caja',
    'meta' => [
      'create' => [
        'title' => 'Nuevo arqueo de caja',
        'description' => 'Crea un nuevo arqueo de caja en nuestra plataforma.',
        'keywords' => 'crear arqueo de caja, nuevo arqueo de caja, plataforma',
      ],
      'edit' => [
        'title' => 'Actualizar arqueo de caja',
        'description' => 'Edita y actualiza un arqueo de caja existente.',
        'keywords' => 'editar arqueo de caja, actualizar arqueo de caja, plataforma',
      ],
      'index' => [
        'title' => 'Lista de arqueos de caja',
        'description' => 'Explora la lista completa de arqueos de caja disponibles.',
        'keywords' => 'lista de arqueos de caja, arqueos de caja disponibles, plataforma',
      ],
      'show' => [
        'title' => 'Mostrar arqueo de caja',
        'description' => 'Consulta los detalles de cada arqueo de caja disponible.',
        'keywords' => 'ver arqueo de caja, detalles del arqueo de caja, plataforma',
      ],
      "author" => 'Pedro Luis Condori Cutile',
    ],
    'resource' => [
      "create" => "Nuevo arqueo de caja",
      "edit" => "Actualizar arqueo de caja",
      "show" => "Detalles del arqueo de caja",
      "index" => "Lista de arqueo de caja",
    ],
    'attribute' => [
      "date" => "Fecha de arqueo",
      "opening" => "Monto de apertura",
      "closing" => "Monto de cierre",
      "opening_denomination_uuid" => "Denominaciones de apertura",
      "closing_denomination_uuid" => "Denominaciones de cierre",
      "user_id" => "Registrado por",
      "created_at" => "Fecha Registro",
      "updated_at" => "Últ. Act.",
    ],
  ],


  'income' => [
    "new" => "Nuevo ingreso",
    "list" => "Lista de ingresos",
  ],
  'general' => [
    "app" => "Nuevo amanecer",
    "author" => "Pedro Luis Condori Cutile",
    "show_password" => "Mostrar contraseña",
    'loader' => 'Procesando tu solicitud...',
    'error' => 'Ha ocurrido un error',
    'error_validation' => 'Fallo de validación',
    '10_items' => '10 registros',
    '20_items' => '20 registros',
    '50_items' => '50 registros',
    'delete_title' => 'Confirmar eliminación',
    'delete_warning' => '? Esta acción también eliminará todas las tareas relacionadas y no se puede deshacer.',
  ],
];
