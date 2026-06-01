# Documentação do Sistema - ConfecçãoTA2

## Índice

1. [Visão Geral do Projeto](#1-visão-geral-do-projeto)
2. [Stack Tecnológica](#2-stack-tecnológica)
3. [Estrutura do Projeto](#3-estrutura-do-projeto)
4. [Modelos de Dados (Models)](#4-modelos-de-dados-models)
5. [Banco de Dados (Migrations)](#5-banco-de-dados-migrations)
6. [Filament Resources (CRUDs)](#6-filament-resources-cruds)
7. [Administração e RBAC](#7-administração-e-rbac)
8. [Provider e Configurações](#8-provider-e-configurações)
9. [Rotas](#9-rotas)
10. [Notificações por Email](#10-notificações-por-email)
11. [Fluxos de Negócio](#11-fluxos-de-negócio)
12. [Comandos Úteis](#12-comandos-úteis)

---

## 1. Visão Geral do Projeto

**ConfecçãoTA2** é um sistema web desenvolvido em **Laravel 13 + Filament 5** para gestão de uma confecção (fábrica de roupas). O sistema gerencia:

- **Clientes** (pessoas físicas/jurídicas)
- **Fornecedores** (matéria-prima e insumos)
- **Produtos** (itens finais fabricados)
- **Insumos** (matéria-prima utilizada na produção)
- **Estoque** (controle de inventário dos produtos)
- **Pedidos** (vendas com itens)
- **Usuários, Perfis (Roles) e Permissões** (controle de acesso RBAC)

### Objetivo Principal

Automatizar o processo comercial de uma confecção, desde o cadastro de clientes e fornecedores até a gestão de pedidos e controle de estoque, com um painel administrativo completo baseado em Filament.

---

## 2. Stack Tecnológica

| Componente | Tecnologia | Versão |
|---|---|---|
| **Linguagem** | PHP | ^8.3 |
| **Framework** | Laravel | ^13.0 |
| **Painel Admin** | Filament | ^5 |
| **Banco de Dados** | MySQL (via Laragon) | - |
| **RBAC** | Spatie Laravel Permission | ^7.2 |
| **Template Engine** | Blade (via Filament) | - |
| **Frontend** | Vite + Tailwind CSS (Filament) | - |
| **Autenticação** | Laravel + Filament Shield | - |

### Dependências Principais (composer.json)

```json
{
  "require": {
    "php": "^8.3",
    "filament/filament": "^5",
    "filament/widgets": "^5",
    "laravel/framework": "^13.0",
    "laravel/tinker": "^3.0",
    "spatie/laravel-permission": "^7.2"
  },
  "require-dev": {
    "fakerphp/faker": "^1.23",
    "laravel/pail": "^1.2.5",
    "laravel/pint": "^1.27",
    "mockery/mockery": "^1.6",
    "nunomaduro/collision": "^8.6",
    "phpunit/phpunit": "^12.5.12"
  }
}
```

---

## 3. Estrutura do Projeto

```
confeccaoTA2/
├── app/
│   ├── Filament/
│   │   ├── Resources/
│   │   │   ├── Clientes/        # Recurso de Clientes
│   │   │   ├── Estoques/        # Recurso de Estoque
│   │   │   ├── Fornecedors/     # Recurso de Fornecedores
│   │   │   ├── Insumos/         # Recurso de Insumos
│   │   │   ├── Pedidos/         # Recurso de Pedidos
│   │   │   ├── Permissions/     # Recurso de Permissões (Spatie)
│   │   │   ├── Produtos/        # Recurso de Produtos
│   │   │   ├── Roles/           # Recurso de Perfis (Spatie)
│   │   │   └── Users/           # Recurso de Usuários
│   │   └── Widgets/
│   │       └── MyWidget.php     # Widget customizado do dashboard
│   ├── Http/
│   │   └── Controllers/
│   │       └── Controller.php   # Controller base
│   ├── Models/
│   │   ├── Cliente.php
│   │   ├── Estoque.php
│   │   ├── Fornecedor.php
│   │   ├── Insumo.php
│   │   ├── ItemPedido.php
│   │   ├── Pedido.php
│   │   ├── Produtos.php
│   │   └── User.php
│   └── Providers/
│       ├── AppServiceProvider.php
│       └── Filament/
│           └── AdminPanelProvider.php
├── bootstrap/
│   └── app.php
├── config/
│   ├── app.php
│   ├── database.php
│   ├── permission.php
│   └── ...
├── database/
│   └── migrations/              # Migrations do banco de dados
├── routes/
│   └── web.php
├── composer.json
├── package.json
├── vite.config.js
└── .env.example
```

### Organização dos Resources (Filament)

Cada Resource Filament segue uma estrutura de diretórios padronizada:

```
NomeResource/
├── Pages/
│   ├── CreateNome.php           # Página de criação
│   ├── EditNome.php             # Página de edição
│   ├── ListNome.php             # Página de listagem
│   └── ViewNome.php             # Página de visualização
├── Schemas/
│   ├── NomeForm.php             # Schema do formulário
│   └── NomeInfolist.php         # Schema do infolist (exibição)
├── Tables/
│   └── NomeTable.php            # Schema da tabela
└── NomeResource.php             # Recurso principal
```

---

## 4. Modelos de Dados (Models)

### 4.1 `App\Models\Cliente`

Representa os clientes da confecção (pessoas físicas ou jurídicas).

```php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    protected $fillable = ['nome', 'email', 'documento', 'telefone', 'endereco', 'cidade', 'estado', 'cep'];
    
    // Relationships
    public function pedidos(): HasMany  // → App\Models\Pedido (FK: cliente_id)
}
```

**Campos:**

| Campo | Tipo | Descrição |
|---|---|---|
| `nome` | string | Nome completo do cliente |
| `email` | string | E-mail |
| `documento` | string | CPF ou CNPJ |
| `telefone` | string | Telefone (com máscara) |
| `endereco` | string | Endereço completo |
| `cidade` | string | Cidade |
| `estado` | string | Estado |
| `cep` | string | CEP |

**Relacionamentos:**

| Método | Tipo | Modelo Relacionado | Chave Estrangeira |
|---|---|---|---|
| `pedidos()` | `HasMany` | `Pedido` | `pedidos.cliente_id` |

---

### 4.2 `App\Models\Produtos`

Representa os produtos finais fabricados pela confecção.

```php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Produtos extends Model
{
    protected $fillable = ['nome', 'descricao', 'preco', 'categoria', 'sku'];
    
    // Relationships
    public function estoque(): HasOne        // → App\Models\Estoque
    public function itensPedidos(): HasMany  // → App\Models\ItemPedido (FK: produtos_id)
}
```

**Campos:**

| Campo | Tipo | Descrição |
|---|---|---|
| `nome` | string | Nome do produto |
| `descricao` | text (longText) | Descrição detalhada |
| `preco` | decimal | Preço de venda |
| `categoria` | string | Categoria do produto |
| `sku` | string | SKU (código do produto) |

**Relacionamentos:**

| Método | Tipo | Modelo Relacionado | Chave Estrangeira |
|---|---|---|---|
| `estoque()` | `HasOne` | `Estoque` | `estoques.produtos_Id` |
| `itensPedidos()` | `HasMany` | `ItemPedido` | `item_pedidos.produtos_id` |

---

### 4.3 `App\Models\Fornecedor`

Representa os fornecedores de matéria-prima e insumos.

```php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Fornecedor extends Model
{
    protected $fillable = ['nome', 'email', 'endereco'];
}
```

**Campos:**

| Campo | Tipo | Descrição |
|---|---|---|
| `nome` | string | Nome do fornecedor |
| `email` | string | E-mail de contato |
| `endereco` | string | Endereço completo |

---

### 4.4 `App\Models\Insumo`

Representa as matérias-primas utilizadas na produção.

```php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Insumo extends Model
{
    protected $fillable = ['nome', 'unidade_medida', 'preco_custo', 'estoque'];
    
    // Accessors
    public function getEstoqueAttribute($value): float  // Garante retorno como float
}
```

**Campos:**

| Campo | Tipo | Descrição |
|---|---|---|
| `nome` | string | Nome do insumo |
| `unidade_medida` | string | Unidade de medida (kg, m, un, l, etc.) |
| `preco_custo` | decimal | Preço de custo |
| `estoque` | decimal | Quantidade em estoque |

**Métodos Customizados:**

| Método | Descrição |
|---|---|
| `getEstoqueAttribute($value)` | Accessor que sempre retorna o valor do estoque como float |

---

### 4.5 `App\Models\Pedido`

Representa os pedidos de venda realizados.

```php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pedido extends Model
{
    protected $fillable = [
        'cliente_id', 'data_pedido', 'status', 'observacoes', 
        'subtotal', 'desconto', 'valor_total', 'forma_pagamento'
    ];
    
    // Relationships
    public function cliente(): BelongsTo       // → App\Models\Cliente
    public function itens(): HasMany           // → App\Models\ItemPedido (FK: pedido_id)
    
    // Custom Methods
    public function calcularTotal(): float     // Soma preco_unitario * quantidade de cada item
    public function atualizarStatus($status)   // Atualiza o status do pedido
}
```

**Campos:**

| Campo | Tipo | Descrição |
|---|---|---|
| `cliente_id` | int (FK) | Cliente associado |
| `data_pedido` | datetime | Data do pedido |
| `status` | string | Status (pendente, confirmado, em_andamento, finalizado, cancelado) |
| `observacoes` | text | Observações |
| `subtotal` | decimal | Subtotal antes do desconto |
| `desconto` | decimal | Valor do desconto |
| `valor_total` | decimal | Valor total do pedido |
| `forma_pagamento` | string | Forma de pagamento (dinheiro, credito, debito, pix, boleto) |

**Relacionamentos:**

| Método | Tipo | Modelo Relacionado | Chave Estrangeira |
|---|---|---|---|
| `cliente()` | `BelongsTo` | `Cliente` | `pedidos.cliente_id` |
| `itens()` | `HasMany` | `ItemPedido` | `item_pedidos.pedido_id` |

**Métodos Customizados:**

| Método | Parâmetros | Retorno | Descrição |
|---|---|---|---|
| `calcularTotal()` | nenhum | `float` | Percorre todos os itens e calcula a soma de `preco_unitario * quantidade` |
| `atualizarStatus($status)` | `string $status` | void | Atualiza o campo `status` do pedido |

---

### 4.6 `App\Models\ItemPedido`

Representa cada item/produto individual dentro de um pedido.

```php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ItemPedido extends Model
{
    protected $fillable = ['pedido_id', 'produtos_id', 'quantidade', 'preco_unitario', 'subtotal'];
    
    // Relationships
    public function pedido(): BelongsTo  // → App\Models\Pedido
    public function produto(): BelongsTo // → App\Models\Produtos (FK: produtos_id)
}
```

**Campos:**

| Campo | Tipo | Descrição |
|---|---|---|
| `pedido_id` | int (FK) | Pedido associado |
| `produtos_id` | int (FK) | Produto associado |
| `quantidade` | integer | Quantidade do produto |
| `preco_unitario` | decimal | Preço unitário no momento da venda |
| `subtotal` | decimal | Subtotal (quantidade * preco_unitario) |

**Relacionamentos:**

| Método | Tipo | Modelo Relacionado | Chave Estrangeira |
|---|---|---|---|
| `pedido()` | `BelongsTo` | `Pedido` | `item_pedidos.pedido_id` |
| `produto()` | `BelongsTo` | `Produtos` | `item_pedidos.produtos_id` |

---

### 4.7 `App\Models\Estoque`

Representa o controle de inventário/estoque dos produtos.

```php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Estoque extends Model
{
    protected $fillable = [
        'produtos_Id', 'localizacao', 'quantidade', 
        'valor', 'quantidade_minima', 'lote'
    ];
    
    // Relationships
    public function produto(): BelongsTo  // → App\Models\Produtos (FK: produtos_Id)
}
```

**Campos:**

| Campo | Tipo | Descrição |
|---|---|---|
| `produtos_Id` | int (FK) | Produto associado |
| `localizacao` | string | Localização no depósito |
| `quantidade` | integer | Quantidade em estoque |
| `valor` | decimal | Valor unitário do produto |
| `quantidade_minima` | integer | Quantidade mínima (alerta de reposição) |
| `lote` | string | Número do lote |

**Relacionamentos:**

| Método | Tipo | Modelo Relacionado | Chave Estrangeira |
|---|---|---|---|
| `produto()` | `BelongsTo` | `Produtos` | `estoques.produtos_Id` |

---

### 4.8 `App\Models\User`

Representa os usuários administrativos do sistema. Utiliza o pacote **Spatie Laravel Permission** para RBAC.

```php
namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasRoles;
    
    protected $fillable = ['name', 'email', 'password'];
    protected $hidden = ['password', 'remember_token'];
    
    // Relationships
    public function roles(): BelongsToMany  // Spatie Permission
    public function permissions(): BelongsToMany  // Spatie Permission
}
```

**Traits Utilizadas:**

| Trait | Pacote | Funcionalidade |
|---|---|---|
| `HasRoles` | `spatie/laravel-permission` | Gerencia perfis e permissões do usuário |

**Campos:**

| Campo | Tipo | Descrição |
|---|---|---|
| `name` | string | Nome do usuário |
| `email` | string | E-mail (login) |
| `password` | string | Senha (hash) |
| `remember_token` | string | Token de "lembrar-me" |

**Relacionamentos (via Spatie):**

| Método | Tipo | Descrição |
|---|---|---|
| `roles()` | `BelongsToMany` | Perfis associados ao usuário |
| `permissions()` | `BelongsToMany` | Permissões diretas associadas ao usuário |

---

## 5. Banco de Dados (Migrations)

### 5.1 Tabelas do Sistema (Laravel)

| Migration | Tabela | Finalidade |
|---|---|---|
| `users` | `users` | Usuários do sistema |
| `password_reset_tokens` | Redefinição de senha |
| `sessions` | Sessões |
| `cache` | Cache |
| `cache_locks` | Locks de cache |
| `jobs` | Filas de jobs |
| `job_batches` | Batches de jobs |
| `failed_jobs` | Jobs com falha |

### 5.2 Tabelas do Sistema (Spatie Permission)

| Migration | Tabela | Finalidade |
|---|---|---|
| `permissions` | Permissões do sistema |
| `roles` | Perfis (papéis) |
| `model_has_permissions` | Relação usuário ↔ permissão direta |
| `model_has_roles` | Relação usuário ↔ perfil |
| `role_has_permissions` | Relação perfil ↔ permissão |

### 5.3 Tabelas da Aplicação

#### `clientes`

```php
Schema::create('clientes', function (Blueprint $table) {
    $table->id();
    $table->string('nome');
    $table->string('email')->unique()->nullable();
    $table->string('telefone')->nullable();
    $table->string('documento')->nullable();
    $table->string('endereco')->nullable();
    $table->string('cidade')->nullable();
    $table->string('estado')->nullable();
    $table->string('cep')->nullable();
    $table->timestamps();
});
```

| Coluna | Tipo | Restrições |
|---|---|---|
| `id` | bigIncrements | PK |
| `nome` | string | Obrigatório |
| `email` | string | Unique, nullable |
| `telefone` | string | Nullable |
| `documento` | string | Nullable |
| `endereco` | string | Nullable |
| `cidade` | string | Nullable |
| `estado` | string | Nullable |
| `cep` | string | Nullable |
| `created_at` | timestamp | -
| `updated_at` | timestamp | -

#### `fornecedors`

```php
Schema::create('fornecedors', function (Blueprint $table) {
    $table->id();
    $table->string('nome');
    $table->string('email')->nullable();
    $table->string('endereco')->nullable();
    $table->timestamps();
});
```

| Coluna | Tipo | Restrições |
|---|---|---|
| `id` | bigIncrements | PK |
| `nome` | string | Obrigatório |
| `email` | string | Nullable |
| `endereco` | string | Nullable |
| `created_at` | timestamp | -
| `updated_at` | timestamp | -

#### `produtos`

```php
Schema::create('produtos', function (Blueprint $table) {
    $table->id();
    $table->string('nome');
    $table->longText('descricao')->nullable();
    $table->decimal('preco', 10, 2)->nullable();
    $table->string('categoria')->nullable();
    $table->string('sku')->nullable();
    $table->timestamps();
});
```

| Coluna | Tipo | Restrições |
|---|---|---|
| `id` | bigIncrements | PK |
| `nome` | string | Obrigatório |
| `descricao` | longText | Nullable |
| `preco` | decimal(10,2) | Nullable |
| `categoria` | string | Nullable |
| `sku` | string | Nullable |
| `created_at` | timestamp | -
| `updated_at` | timestamp | -

#### `insumos`

```php
Schema::create('insumos', function (Blueprint $table) {
    $table->id();
    $table->string('nome');
    $table->string('unidade_medida');
    $table->decimal('preco_custo', 10, 2)->nullable();
    $table->decimal('estoque', 10, 2)->default(0);
    $table->timestamps();
});
```

| Coluna | Tipo | Restrições |
|---|---|---|
| `id` | bigIncrements | PK |
| `nome` | string | Obrigatório |
| `unidade_medida` | string | Obrigatório |
| `preco_custo` | decimal(10,2) | Nullable |
| `estoque` | decimal(10,2) | Default: 0 |
| `created_at` | timestamp | -
| `updated_at` | timestamp | -

#### `pedidos`

```php
Schema::create('pedidos', function (Blueprint $table) {
    $table->id();
    $table->foreignId('cliente_id')->constrained('clientes')->onDelete('cascade');
    $table->dateTime('data_pedido')->nullable();
    $table->string('status')->default('pendente');
    $table->text('observacoes')->nullable();
    $table->decimal('subtotal', 10, 2)->nullable();
    $table->decimal('desconto', 10, 2)->nullable();
    $table->decimal('valor_total', 10, 2)->nullable();
    $table->string('forma_pagamento')->nullable();
    $table->timestamps();
});
```

| Coluna | Tipo | Restrições |
|---|---|---|
| `id` | bigIncrements | PK |
| `cliente_id` | bigInt (FK) | `constrained('clientes')`, `onDelete('cascade')` |
| `data_pedido` | dateTime | Nullable |
| `status` | string | Default: `'pendente'` |
| `observacoes` | text | Nullable |
| `subtotal` | decimal(10,2) | Nullable |
| `desconto` | decimal(10,2) | Nullable |
| `valor_total` | decimal(10,2) | Nullable |
| `forma_pagamento` | string | Nullable |
| `created_at` | timestamp | -
| `updated_at` | timestamp | -

**FKs:** `cliente_id` → `clientes(id)` ON DELETE CASCADE

#### `item_pedidos`

```php
Schema::create('item_pedidos', function (Blueprint $table) {
    $table->id();
    $table->foreignId('pedido_id')->constrained('pedidos')->onDelete('cascade');
    $table->foreignId('produtos_id')->constrained('produtos')->onDelete('cascade');
    $table->integer('quantidade');
    $table->decimal('preco_unitario', 10, 2)->nullable();
    $table->decimal('subtotal', 10, 2)->nullable();
    $table->timestamps();
});
```

| Coluna | Tipo | Restrições |
|---|---|---|
| `id` | bigIncrements | PK |
| `pedido_id` | bigInt (FK) | `constrained('pedidos')`, `onDelete('cascade')` |
| `produtos_id` | bigInt (FK) | `constrained('produtos')`, `onDelete('cascade')` |
| `quantidade` | integer | Obrigatório |
| `preco_unitario` | decimal(10,2) | Nullable |
| `subtotal` | decimal(10,2) | Nullable |
| `created_at` | timestamp | -
| `updated_at` | timestamp | -

**FKs:**
- `pedido_id` → `pedidos(id)` ON DELETE CASCADE
- `produtos_id` → `produtos(id)` ON DELETE CASCADE

#### `estoques`

```php
Schema::create('estoques', function (Blueprint $table) {
    $table->id();
    $table->foreignId('produtos_Id')->constrained('produtos')->onDelete('cascade');
    $table->string('localizacao')->nullable();
    $table->integer('quantidade');
    $table->decimal('valor', 10, 2)->nullable();
    $table->integer('quantidade_minima')->nullable();
    $table->string('lote')->nullable();
    $table->timestamps();
});
```

| Coluna | Tipo | Restrições |
|---|---|---|
| `id` | bigIncrements | PK |
| `produtos_Id` | bigInt (FK) | `constrained('produtos')`, `onDelete('cascade')` |
| `localizacao` | string | Nullable |
| `quantidade` | integer | Obrigatório |
| `valor` | decimal(10,2) | Nullable |
| `quantidade_minima` | integer | Nullable |
| `lote` | string | Nullable |
| `created_at` | timestamp | -
| `updated_at` | timestamp | -

**FKs:** `produtos_Id` → `produtos(id)` ON DELETE CASCADE

---

### 5.4 Diagrama de Relacionamento do Banco

```
┌─────────────┐       ┌───────────────┐       ┌───────────────────┐
│   clientes  │       │   produtos    │       │    fornecedors    │
├─────────────┤       ├───────────────┤       ├───────────────────┤
│ id (PK)     │       │ id (PK)       │       │ id (PK)           │
│ nome        │       │ nome          │       │ nome              │
│ email       │       │ descricao     │       │ email             │
│ telefone    │◄──┐   │ preco         │       │ endereco          │
│ documento   │   │   │ categoria     │       └───────────────────┘
│ endereco    │   │   │ sku           │
│ cidade      │   │   └───────┬───────┘              ┌─────────────┐
│ estado      │   │           │                      │   insumos   │
│ cep         │   │           │                      ├─────────────┤
└─────────────┘   │           │                      │ id (PK)     │
                  │           │                      │ nome        │
         ┌────────┘           │                      │ unidade_med │
         ▼                    │                      │ preco_custo │
┌────────────────┐            │                      │ estoque     │
│    pedidos     │            │                      └─────────────┘
├────────────────┤            │
│ id (PK)        │            │
│ cliente_id(FK) │◄───────────┼──┐
│ data_pedido    │            │  │
│ status         │            │  │
│ observacoes    │            │  │
│ subtotal       │            │  │
│ desconto       │            │  │
│ valor_total    │            │  │
│ forma_pagamento│            │  │
└────────┬───────┘            │  │
         │                    │  │
         ▼                    │  │
┌─────────────────┐           │  │
│  item_pedidos   │           │  │
├─────────────────┤           │  │
│ id (PK)         │           │  │
│ pedido_id (FK)  │──┘        │  │
│ produtos_id (FK)│───────────┘  │
│ quantidade      │              │
│ preco_unitario  │              │
│ subtotal        │              │
└─────────────────┘              │
                                 │
                        ┌────────┘
                        ▼
                ┌────────────────┐
                │   estoques     │
                ├────────────────┤
                │ id (PK)        │
                │ produtos_Id(FK)│
                │ localizacao    │
                │ quantidade     │
                │ valor          │
                │ quant_minima   │
                │ lote           │
                └────────────────┘
```

---

## 6. Filament Resources (CRUDs)

### 6.1 Estrutura Padrão de um Resource

Cada Resource no sistema segue a mesma arquitetura:

1. **Resource Principal** (`NomeResource.php`) - Define modelo, navegação, permissões, e delega formulário/tabela/infolist para schemas específicos.
2. **Form Schema** (`Schemas/NomeForm.php`) - Define todos os campos do formulário com validações.
3. **Table Schema** (`Tables/NomeTable.php`) - Define colunas da tabela de listagem com busca e ordenação.
4. **Infolist Schema** (`Schemas/NomeInfolist.php`) - Define a visualização detalhada do registro.
5. **Pages** - CRUD: `Create`, `Edit` (com View e Delete), `List`, `View` (opcional).

### 6.2 Client Resource (`Clientes\ClienteResource`)

**Navegação:**
- Grupo: `Cadastros Gerais`
- Ordem: 1
- Ícone: `OutlinedRectangleStack`
- Permissão: `access_clientes`

**Formulário (`ClienteForm`):**

| Campo | Tipo | Validação | Observação |
|---|---|---|---|
| `nome` | TextInput | **required** | - |
| `email` | TextInput | `email()` | - |
| `telefone` | TextInput | `tel()`, com máscara `(99) 99999-9999` | - |
| `documento` | TextInput | Máscara dinâmica via RawJs (CPF ≤14 chars, CNPJ >14) | - |

**Tabela (`ClientesTable`):**

| Coluna | Buscável | Ordenável | Visível por padrão |
|---|---|---|---|
| `nome` | ✅ | ❌ | ✅ |
| `email` | ✅ | ❌ | ✅ |
| `telefone` | ✅ | ❌ | ✅ |
| `documento` | ✅ | ❌ | ✅ |
| `created_at` | ❌ | ✅ | ❌ (toggleable) |
| `updated_at` | ❌ | ✅ | ❌ (toggleable) |

**Infolist (`ClienteInfolist`):** Exibe todos os campos em entries com ícones (Heroicon).

### 6.3 Fornecedor Resource (`Fornecedors\FornecedorResource`)

**Navegação:**
- Grupo: `Cadastros Gerais`
- Ordem: 2
- Ícone: `OutlinedRectangleStack`
- Permissão: `access_fornecedors`

**Formulário (`FornecedorForm`):**

| Campo | Tipo | Validação |
|---|---|---|
| `nome` | TextInput | **required**, max 255 |
| `email` | TextInput | `email()`, max 255 |
| `endereco` | TextInput | max 255 |

**Tabela (`FornecedorsTable`):**

| Coluna | Buscável | Ordenável |
|---|---|---|
| `nome` | ✅ | ❌ |
| `email` | ✅ | ❌ |
| `endereco` | ✅ | ❌ |
| `created_at` | ❌ | ✅ |

### 6.4 Produto Resource (`Produtos\ProdutosResource`)

**Navegação:**
- Grupo: `Cadastros Gerais`
- Ordem: 3
- Ícone: `OutlinedRectangleStack`
- Permissão: `access_produtos`

**Formulário (`ProdutosForm`):**

| Campo | Tipo | Validação |
|---|---|---|
| `nome` | TextInput | **required**, max 255 |
| `descricao` | Textarea | - |
| `preco` | TextInput | Input com prefixo `R$`, `numeric()`, `minValue(0)` |
| `categoria` | Select | Opções: Tecido, Aviamento, Roupa, Acessório, Outro |
| `sku` | TextInput | - |

**Tabela (`ProdutosTable`):**

| Coluna | Buscável | Ordenável |
|---|---|---|
| `nome` | ✅ | ❌ |
| `preco` | ❌ | ✅ |
| `categoria` | ❌ | ❌ |
| `sku` | ✅ | ❌ |
| `created_at` | ❌ | ✅ |

**Infolist (`ProdutosInfolist`):** Exibe nome, preço (monetário), categoria (badge colorida), SKU e descrição.

### 6.5 Insumo Resource (`Insumos\InsumoResource`)

**Navegação:**
- Grupo: `Cadastros Gerais`
- Ordem: 4
- Ícone: `OutlinedRectangleStack`
- Permissão: `access_insumos`

**Formulário (`InsumoForm`):**

| Campo | Tipo | Validação |
|---|---|---|
| `nome` | TextInput | **required**, max 255 |
| `unidade_medida` | TextInput | **required**, max 50 |
| `preco_custo` | TextInput | Prefixo `R$`, `numeric()`, `minValue(0)` |
| `estoque` | TextInput | Máscara dinâmica via RawJs |
| `created_at` | DateTimePicker (hidden) | Apenas disabled |

**Tabela (`InsumosTable`):**

| Coluna | Buscável | Ordenável |
|---|---|---|
| `nome` | ✅ | ❌ |
| `unidade_medida` | ❌ | ❌ |
| `preco_custo` | ❌ | ✅ |
| `estoque` | ❌ | ✅ |
| `created_at` | ❌ | ✅ |

### 6.6 Pedido Resource (`Pedidos\PedidoResource`)

**Navegação:**
- Grupo: `Movimentos`
- Ordem: 1
- Ícone: `OutlinedRectangleStack`
- Permissão: `access_pedidos`

Este é o Resource mais complexo do sistema, com lógica de negócio no Create e Edit.

#### Formulário (`PedidoForm`)

| Campo | Tipo | Validação |
|---|---|---|
| `cliente_id` | Select (Relationship) | **required**, busca por `nome` |
| `data_pedido` | DateTimePicker | **required**, formato `d/m/Y H:i:s` |
| `status` | Select | Opções: pendente, confirmado, em_andamento, finalizado, cancelado |
| `observacoes` | Textarea | - |
| `subtotal` | TextInput | Prefixo `R$`, `numeric()`, `minValue(0)`, disabled |
| `desconto` | TextInput | Prefixo `R$`, `numeric()`, `minValue(0)` |
| `valor_total` | TextInput | Prefixo `R$`, `numeric()`, `minValue(0)`, disabled |
| `forma_pagamento` | Select | Opções: dinheiro, credito, debito, pix, boleto |

#### Página Create (`CreatePedido`)

Possui lógica customizada para gerenciamento de itens do pedido:

```php
use Filament\Resources\Pages\CreateRecord;
use Filament\Forms\Components\Repeater;

class CreatePedido extends CreateRecord
{
    // Hooks
    protected function afterCreate(): void
    {
        // Processa os itens adicionados via Repeater
        foreach ($this->data['itens'] ?? [] as $itemData) {
            $this->record->itens()->create([
                'produtos_id' => $itemData['produtos_id'],
                'quantidade' => $itemData['quantidade'],
                'preco_unitario' => $itemData['preco_unitario'],
                'subtotal' => $itemData['quantidade'] * $itemData['preco_unitario'],
            ]);
        }
    }
    
    // Método para buscar preço do produto via AJAX
    public function getPrecoProduto($produtoId): float
    {
        return Produtos::find($produtoId)?->preco ?? 0;
    }
    
    // Cálculo automático do valor total antes de salvar
    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $total = 0;
        foreach ($data['itens'] ?? [] as $item) {
            $total += $item['quantidade'] * $item['preco_unitario'];
        }
        $data['subtotal'] = $total;
        $data['valor_total'] = $total - ($data['desconto'] ?? 0);
        return $data;
    }
}
```

**Funcionalidades:**
- **Repeater** para adicionar múltiplos itens (produtos) ao pedido
- Cálculo automático de subtotal e valor total
- Busca de preço do produto via `getPrecoProduto()`
- Criação dos registros de `ItemPedido` no hook `afterCreate()`

#### Página Edit (`EditPedido`)

```php
class EditPedido extends EditRecord
{
    // Ações de cabeçalho
    protected function getHeaderActions(): array
    {
        return [
            \Filament\Actions\ViewAction::make(),
            \Filament\Actions\DeleteAction::make(),
        ];
    }
}
```

#### Tabela (`PedidosTable`)

| Coluna | Buscável | Ordenável | Observação |
|---|---|---|---|
| `id` | ❌ | ✅ | Formato `#000001` |
| `cliente.nome` | ✅ (via `relationship`) | ❌ | Relacionamento |
| `data_pedido` | ❌ | ✅ | Formato `d/m/Y H:i:s` |
| `status` | ❌ | ❌ | Badge colorida |
| `valor_total` | ❌ | ✅ | Monetário |
| `forma_pagamento` | ❌ | ❌ | Badge colorida |
| `created_at` | ❌ | ✅ | - |

**Badge de Status (cores):**

| Status | Cor |
|---|---|
| `pendente` | warning (amarelo) |
| `confirmado` | success (verde) |
| `em_andamento` | info (azul) |
| `finalizado` | success (verde escuro) |
| `cancelado` | danger (vermelho) |

### 6.7 Estoque Resource (`Estoques\EstoqueResource`)

**Navegação:**
- Grupo: `Movimentos`
- Ordem: 2
- Ícone: `OutlinedRectangleStack`
- Permissão: `access_estoques`

**Formulário (`EstoqueForm`):**

| Campo | Tipo | Validação |
|---|---|---|
| `produtos_Id` | Select (Relationship) | **required**, busca por `nome` |
| `localizacao` | TextInput | max 255 |
| `quantidade` | TextInput | **required**, `numeric()`, `minValue(0)` |
| `valor` | TextInput | Prefixo `R$`, `numeric()`, `minValue(0)` |
| `quantidade_minima` | TextInput | `numeric()`, `minValue(0)` |
| `lote` | TextInput | max 255 |

**Tabela (`EstoquesTable`):**

| Coluna | Buscável | Ordenável |
|---|---|---|
| `id` | ❌ | ✅ |
| `produto.nome` | ✅ (via `relationship`) | ❌ |
| `localizacao` | ✅ | ❌ |
| `quantidade` | ❌ | ✅ |
| `quantidade_minima` | ❌ | ✅ |
| `lote` | ❌ | ❌ |
| `created_at` | ❌ | ✅ |

---

## 7. Administração e RBAC

### 7.1 Painel de Administração (`AdminPanelProvider`)

```php
namespace App\Providers\Filament;

class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->default()
            ->id('admin')
            ->path('admin')
            ->login()
            ->colors([
                'primary' => Color::Amber,
            ])
            ->discoverResources(in: app_path('Filament/Resources'), for: 'App\\Filament\\Resources')
            ->discoverPages(in: app_path('Filament/Resources'), for: 'App\\Filament\\Resources')
            ->discoverWidgets(in: app_path('Filament/Widgets'), for: 'App\\Filament\\Widgets')
            ->middleware(['web', 'auth', 'verified'])
            ->authMiddleware(['auth']);
    }
}
```

**Características:**
- URL base: `/admin`
- Autenticação: login com verificação de email
- Cor primária: Amber (âmbar)
- Descoberta automática de Resources, Pages e Widgets

### 7.2 Sistema de Perfis e Permissões (Spatie Permission)

O sistema utiliza o pacote `spatie/laravel-permission` para controle de acesso baseado em funções (RBAC).

#### Permissões (Permission Resource)

Cada recurso possui uma permissão de acesso registrada no banco.

**Permissões existentes (criadas no `AppServiceProvider`):**

| Nome da Permissão | Descrição |
|---|---|
| `access_clientes` | Acesso ao módulo Clientes |
| `access_fornecedors` | Acesso ao módulo Fornecedores |
| `access_produtos` | Acesso ao módulo Produtos |
| `access_insumos` | Acesso ao módulo Insumos |
| `access_pedidos` | Acesso ao módulo Pedidos |
| `access_estoques` | Acesso ao módulo Estoque |
| `access_users` | Acesso ao módulo Usuários |
| `access_roles` | Acesso ao módulo Perfis |
| `access_permissions` | Acesso ao módulo Permissões |

#### User Resource (`Users\UsuarioResource`)

**Navegação:**
- Grupo: `Administração`
- Ordem: 3
- Ícone: `OutlinedRectangleStack`
- Permissão: `access_users`

**Formulário (`UserForm`):**

| Campo | Tipo | Validação | Observação |
|---|---|---|---|
| `name` | TextInput | **required**, max 255 | - |
| `email` | TextInput | **required**, `email()`, max 255, unique (ignora registro atual) | - |
| `password` | TextInput | `password()`, `min(8)` | Apenas no Create; opcional no Edit |
| `roles` | CheckboxList | - | Lista de perfis disponíveis |

**Seleção de Perfis:** Ao criar/editar um usuário, é possível associar perfis (roles) via CheckboxList que lista todos os papéis cadastrados.

#### Role Resource (`Roles\RoleResource`)

**Navegação:**
- Grupo: `Administração`
- Ordem: 1
- Permissão: `access_roles`

**Formulário (`RoleForm`):**

| Campo | Tipo |
|---|---|
| `name` | TextInput (obrigatório, unique) |
| `permissions` | CheckboxList (todas as permissões disponíveis) |

#### Permission Resource (`Permissions\PermissionResource`)

**Navegação:**
- Grupo: `Administração`
- Ordem: 2
- Permissão: `access_permissions`

**Formulário (`PermissionForm`):**

| Campo | Tipo |
|---|---|
| `name` | TextInput (obrigatório, unique) |
| `guard_name` | TextInput (default: `web`) |

### 7.3 Widget do Dashboard (`MyWidget`)

```php
namespace App\Filament\Widgets;

class MyWidget extends Widget
{
    protected static string $view = 'filament::widgets/table-widget'; // Placeholder
    protected int | string | array $columnSpan = 'full';
}
```

Widget placeholder disponível para customização do dashboard. Atualmente usa um template padrão do Filament com span de coluna total.

### 7.4 Navegação do Sistema

```
Cadastros Gerais (Ordem: 1)
├── Clientes      (Ordem: 1) - access_clientes
├── Fornecedores  (Ordem: 2) - access_fornecedors
├── Produtos      (Ordem: 3) - access_produtos
└── Insumos       (Ordem: 4) - access_insumos

Movimentos (Ordem: 2)
├── Pedidos       (Ordem: 1) - access_pedidos
└── Estoque       (Ordem: 2) - access_estoques

Administração (Ordem: 3)
├── Perfis        (Ordem: 1) - access_roles
├── Permissões    (Ordem: 2) - access_permissions
└── Usuários      (Ordem: 3) - access_users
```

---

## 8. Provider e Configurações

### 8.1 AppServiceProvider

```php
namespace App\Providers;

class AppServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        // Criação automática de permissões no banco
        $permissions = [
            'access_clientes',
            'access_fornecedors',
            'access_produtos',
            'access_insumos',
            'access_pedidos',
            'access_estoques',
            'access_users',
            'access_roles',
            'access_permissions',
        ];
        
        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission, 'guard_name' => 'web']);
        }
    }
}
```

O `AppServiceProvider` garante que todas as permissões do sistema sejam criadas no banco de dados durante o boot da aplicação, usando `firstOrCreate()` para evitar duplicatas.

### 8.2 Controller Base

```php
namespace App\Http\Controllers;

abstract class Controller
{
    //
}
```

Controller base abstrato (vazio) para futuros controllers HTTP, caso sejam necessários além do Filament.

---

## 9. Rotas

### 9.1 `routes/web.php`

Define a rota raiz do sistema:

```php
<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect('/admin');
});
```

- **`GET /`** → Redireciona para `/admin` (painel Filament)
- Todas as demais rotas são gerenciadas automaticamente pelo Filament via descoberta de Resources

---

## 10. Notificações por Email

Sistema de notificação automática que envia um e-mail para o cliente sempre que um pedido é criado.

### 10.1 Arquivos do Sistema de Notificação

| Arquivo | Descrição |
|---|---|
| `app/Mail/PedidoCriado.php` | Mailable que prepara os dados do pedido e renderiza o template |
| `resources/views/emails/pedido-criado.blade.php` | Template HTML do e-mail com layout responsivo |
| `app/Filament/Resources/Pedidos/Pages/CreatePedido.php` | Dispara o e-mail no hook `afterCreate()` |

### 10.2 Fluxo de Envio

```
Usuário cria pedido no Filament
        │
        ▼
afterCreate() executa:
  1. Calcula valor_total (SUM dos itens)
  2. Salva valor_total no pedido
  3. Carrega relacionamentos (cliente, itens, produto)
  4. Verifica se cliente possui email cadastrado
  5. Envia e-mail via Mailpit (desenvolvimento) ou SMTP (produção)
```

### 10.3 Mailable (`app/Mail/PedidoCriado.php`)

```php
class PedidoCriado extends Mailable
{
    public Pedido $pedido;

    public function __construct(Pedido $pedido)
    {
        $this->pedido = $pedido;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Pedido #' . $this->pedido->id . ' criado com sucesso!',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.pedido-criado',
        );
    }
}
```

### 10.4 Template do E-mail (`resources/views/emails/pedido-criado.blade.php`)

O template HTML é autossuficiente (sem dependência de componentes externos) com:
- Cabeçalho com nome do cliente
- Detalhes do pedido (número, data, status)
- Tabela de itens (produto, quantidade, preço unitário, subtotal)
- Valor total em destaque
- Layout responsivo com cores da marca

### 10.5 Configuração de Email

#### Desenvolvimento (Mailpit)

O Mailpit já vem instalado no Laragon. Para usar:

```
MAIL_MAILER=smtp
MAIL_HOST=127.0.0.1
MAIL_PORT=1025
MAIL_FROM_ADDRESS="noreply@confeccaota2.com.br"
```

- Interface web: http://localhost:8025
- O Mailpit é iniciado automaticamente pelo Laragon

#### Produção (SMTP)

```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=seuemail@gmail.com
MAIL_PASSWORD=senha-de-app
MAIL_FROM_ADDRESS=seuemail@gmail.com
MAIL_FROM_NAME="Nome da Loja"
```

> **Nota:** Para Gmail, use uma senha de app (App Password) em vez da senha normal.

### 10.6 Segurança e Validação

- O e-mail só é enviado se o cliente possuir email cadastrado (`if ($pedido->cliente && $pedido->cliente->email)`)
- O template trata valores nulos com `$item->produto->nome ?? 'Produto'`
- O mailer `log` pode ser usado para testes sem enviar e-mails reais

### 10.7 Testando o Envio

```bash
# Ver e-mail no log (quando MAIL_MAILER=log)
grep -A 30 "Pedido #" storage/logs/laravel.log

# Renderizar e-mail no terminal
php artisan tinker --execute="echo (new App\Mail\PedidoCriado(App\Models\Pedido::find(1)))->render();"

# Ver e-mails no Mailpit (quando configurado com SMTP)
# Acesse http://localhost:8025
```

---

## 11. Fluxos de Negócio

### 11.1 Cadastro de Clientes

1. Acessar `Cadastros Gerais > Clientes`
2. Clicar em "Novo Cliente"
3. Preencher nome (obrigatório), email, telefone (com máscara), documento (CPF/CNPJ com máscara dinâmica)
4. Salvar → registro disponível para associação em pedidos

### 11.2 Criação de Pedido

1. Acessar `Movimentos > Pedidos` > "Novo Pedido"
2. Selecionar **cliente** (obrigatório) - busca pelo nome
3. Definir **data do pedido** (obrigatório)
4. Adicionar **itens** via Repeater:
   - Selecionar produto (busca pelo nome)
   - Definir quantidade
   - Preço unitário (preenchido automaticamente ou manual)
5. Informar **desconto** (opcional)
6. Escolher **forma de pagamento**
7. Adicionar **observações** (opcional)
8. Sistema calcula automaticamente:
   - `subtotal` = soma de (quantidade × preco_unitário) de todos os itens
   - `valor_total` = subtotal - desconto
9. Salvar → `afterCreate()` cria os registros de `ItemPedido`

### 11.3 Controle de Estoque

1. Acessar `Movimentos > Estoque`
2. Associar um **produto** ao registro de estoque
3. Definir **quantidade**, **localização** e **quantidade mínima** (alerta)
4. Opcional: informar **lote** e **valor**

### 11.4 Gerenciamento de Usuários e Permissões

1. **Perfis (Roles):** Criar perfis como "Admin", "Vendedor", "Estoquista" e associar permissões específicas
2. **Permissões:** Definir permissões granulares (ex: `access_pedidos`, `access_estoques`)
3. **Usuários:** Criar usuários e atribuir perfis; a senha é exigida apenas na criação

---

## 12. Comandos Úteis

### Desenvolvimento

```bash
# Iniciar ambiente de desenvolvimento completo
npm run dev

# Compilar assets para produção
npm run build

# Script de setup completo do projeto
composer run setup

# Rodar testes
composer run test
```

### Laravel

```bash
# Migrations
php artisan migrate
php artisan migrate:fresh   # Recria todas as tabelas
php artisan migrate:fresh --seed  # Recria + seed

# Criar usuário admin (Filament)
php artisan make:filament-user

# Cache
php artisan optimize:clear   # Limpa todos os caches

# Queue
php artisan queue:listen --tries=1

# Logs (Laravel Pail)
php artisan pail
```

### Filament

```bash
# Criar novo Resource completo
php artisan make:filament-resource NomeResource --generate

# Criar Widget
php artisan make:filament-widget NomeWidget
```

---

## Apêndice

### A. Convenções de Nomenclatura

| Contexto | Convenção | Exemplo |
|---|---|---|
| Models | Singular, PascalCase | `Cliente`, `Produtos` |
| Migrations | snake_case (plural) | `create_clientes_table` |
| Tabelas | snake_case (plural) | `item_pedidos` |
| FKs | `model_id` (snake_case) | `cliente_id`, `produtos_id` |
| Permissões | prefixo `access_` + plural | `access_produtos` |
| Resources | Singular, PascalCase + `Resource` | `ClienteResource` |

### B. Dependências do Node

```json
// package.json
{
  "private": true,
  "type": "module",
  "scripts": {
    "dev": "vite",
    "build": "vite build"
  },
  "devDependencies": {
    "@ant-design/icons": "^5.5.2",
    "@types/react": "^18.3.12",
    "autoprefixer": "^10.4.20",
    "axios": "^1.7.4",
    "concurrently": "^9.1.2",
    "laravel-vite-plugin": "^1.2.0",
    "postcss": "^8.5.3",
    "tailwindcss": "^3.4.17",
    "vite": "^6.2.4"
  }
}
```

### C. Controle de Versão

Repositório Git:
- **Remote:** `origin: https://github.com/juliosena141916/confeccaoTA2.git`
- **Último commit:** `4f9727d6a1952b764a6ca3dd98899106c0f9cd7c`