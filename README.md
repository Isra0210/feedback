# Sistema para Controle de Feedback

**Exame de Suficiência, Desenvolvimento Web Servidor.**

Formulário público para envio de feedbacks e uma área administrativa (protegida por login) para listar, visualizar e atualizar o status de cada feedback. Desenvolvido em **PHP + SQLite (via PDO)**, padrão **MVC**, **sem frameworks** e **sem ORM**.

## Requisitos

- PHP 8.0+ 
- Extensões `pdo` e `pdo_sqlite`
- Composer

## Instalação

```bash
git clone https://github.com/Isra0210/feedback.git
cd feedback
composer install
```

O `composer install` apenas gera o autoloader, o projeto não tem dependências externas.

## Banco de dados

O banco é um arquivo SQLite em `database/database.sqlite`. Ele é criado automaticamente na primeira execução, a partir do `schema.sql`. Para criar/recriar manualmente:

```bash
sqlite3 database/database.sqlite < schema.sql
```

Esquema da tabela (`schema.sql`):

```sql
CREATE TABLE feedbacks (
    id        INTEGER PRIMARY KEY AUTOINCREMENT,
    titulo    TEXT NOT NULL,
    descricao TEXT NOT NULL,
    tipo      TEXT NOT NULL CHECK (tipo IN ('bug','sugestão','reclamação','feedback')),
    status    TEXT NOT NULL DEFAULT 'recebido'
              CHECK (status IN ('recebido','em análise','em desenvolvimento','finalizado'))
);
```

## Execução

```bash
php -S localhost:8000 -t public public/index.php
```

Acesse <http://localhost:8000>. (Sob Apache, o `public/.htaccess` faz o redirecionamento para o `index.php`.)

## Login

| Usuário | Senha    |
|---------|----------|
| `admin` | `123456` |

## Rotas

| Método | Rota                      | Ação                               | Acesso    |
|--------|---------------------------|------------------------------------|-----------|
| GET    | `/`                       | `FeedbackController::formulario()` | Público   |
| POST   | `/feedback/cadastrar`     | `FeedbackController::store()`      | Público   |
| GET    | `/login`                  | `AuthController::showLogin()`      | Público   |
| POST   | `/login`                  | `AuthController::login()`          | Público   |
| GET    | `/logout`                 | `AuthController::logout()`         | -         |
| GET    | `/feedbacks`              | `FeedbackController::index()`      | Protegido |
| GET    | `/feedbacks/{idFeedback}` | `FeedbackController::show($id)`    | Protegido |
| PUT    | `/feedback/atualizar`     | `FeedbackController::update()`     | Protegido |

Como o HTML não envia `PUT`, a atualização de status é um `POST` com o campo oculto `_method=PUT`, que o `index.php` interpreta como `PUT`.

## Arquitetura (MVC)

- **Models** (`app/Models`): `Conexao` gerencia a conexão PDO/SQLite; `Feedback` **herda de `Conexao`** e faz o acesso à tabela com consultas preparadas.
- **Controllers** (`app/Controllers`): `FeedbackController` (`index`, `show`, `store`, `update`) e `AuthController` (login/logout). Recebem a requisição, validam e escolhem a View.
- **Views** (`app/Views`): apenas apresentação (HTML), com dados escapados via `htmlspecialchars`.
- **Rotas**: `rotas.php` define as rotas e é carregado pelo `public/index.php` (ponto de entrada único); `App\Router` casa método + URL e extrai parâmetros como `{idFeedback}`.
- **Autenticação**: `App\Auth` usa sessão (`$_SESSION`); rotas protegidas redirecionam para `/login` quando não autenticadas.

## Funcionalidades

- Composer (autoload) e padrão MVC
- `rotas.php` carregado pelo `index.php` + roteador próprio com parâmetros de URL
- `Conexao` (PDO/SQLite) e `Feedback extends Conexao`
- `FeedbackController` com `index()`, `show($id)`, `store()`, `update($id, $status)`
- Formulário público sem o campo `status` (definido como `recebido`)
- Listagem em tabela com link "Detalhes", detalhes e alteração de status
- Autenticação `admin` / `123456` (apenas `/` pública)
- Validação de `id`, `tipo` e `status`; consultas preparadas; escape de HTML
