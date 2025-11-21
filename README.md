# Video Sharing Platform

Uma plataforma de compartilhamento e armazenamento de vídeos desenvolvida com Laravel (API) e Vue.js (Frontend).

## 📋 Pré-requisitos

- Docker e Docker Compose
- Git

## 🏗️ Arquitetura do Projeto

Este projeto é composto por:

- **Backend (laravel-api)**: API REST desenvolvida em Laravel 12 com autenticação JWT
- **Frontend (vue-spa)**: SPA desenvolvida em Vue.js 3 com Vite
- **Banco de Dados**: PostgreSQL
- **Cache**: Redis
- **Busca**: Meilisearch
- **Email**: Mailpit (desenvolvimento)

## 🚀 Como Inicializar o Projeto

### 1. Clone o Repositório

```bash
git clone https://github.com/luizdevfelipe/video-sharing.git
cd video-sharing
```

### 2. Configuração do Backend (Laravel API)

#### 2.1. Configure o arquivo de ambiente

```bash
cp .env.example .env
```

```bash
cd laravel-api
cp .env.example .env
```

```bash
cd vue-spa
cp .env.example .env
```

### 3. Inicialização com Docker

#### 3.1. Suba os serviços Docker

Na raiz do projeto:

```bash
docker-compose up -d
```

Isso irá inicializar:
- **Laravel API**: http://localhost:80
- **Vue.js Frontend**: http://localhost:5173
- **PostgreSQL**: porta 5432
- **Redis**: porta 6379
- **Meilisearch**: http://localhost:7700
- **Mailpit**: http://localhost:8025

### 3.2. Instalação de Dependências

#### Backend (Laravel):
```bash
docker-compose exec laravel composer install
```

#### Frontend (Vue.js):
```bash
docker-compose exec vue npm install
```

#### 3.3. Execute as migrações e seeders

```bash
docker-compose exec laravel php artisan migrate --seed
```

#### 3.4. Gere a chave JWT

```bash
docker-compose exec laravel php artisan jwt:secret
```

#### 3.5. Crie o link simbólico para storage

```bash
docker-compose exec laravel php artisan storage:link
```

## 📡 Endpoints da API

### Autenticação
- `POST /api/register` - Registro de usuário
- `POST /api/login` - Login
- `GET /api/user` - Dados do usuário autenticado
- `PUT /api/user` - Atualizar dados do usuário
- `POST /api/logout` - Logout

### Vídeos
- `GET /api/video` - Listar vídeos recomendados
- `POST /api/profile/video` - Upload de vídeo (autenticado)
- `GET /api/video/{fileName}` - Stream do vídeo
- `GET /api/video/thumb/{fileName}` - Thumbnail do vídeo
- `GET /api/video/{videoId}/data` - Dados do vídeo
- `GET /api/video/{videoId}/comment` - Comentários do vídeo
- `POST /api/video/{videoId}/comment` - Adicionar comentário

### Categorias
- `GET /api/categories` - Listar categorias

## 🔧 Comandos Úteis

### Laravel (Backend)
```bash
# Acessar container do Laravel
docker-compose exec laravel bash

# Executar migrações
docker-compose exec laravel php artisan migrate

# Executar seeders
docker-compose exec laravel php artisan db:seed

# Limpar cache
docker-compose exec laravel php artisan cache:clear
docker-compose exec laravel php artisan config:clear
docker-compose exec laravel php artisan route:clear

# Executar testes
docker-compose exec laravel php artisan test
```

### Vue.js (Frontend)
```bash
# Acessar container do Vue
docker-compose exec vue sh

# Instalar dependências
docker-compose exec vue npm install

# Build para produção
docker-compose exec vue npm run build
```

### Banco de Dados
```bash
# Acessar PostgreSQL
docker-compose exec pgsql psql -U sail -d video_sharing
```

## 🛠️ Tecnologias Utilizadas

### Backend
- Laravel 12
- PHP 8.2+
- PostgreSQL
- Redis
- JWT Auth (tymon/jwt-auth)
- Laravel Sanctum
- Laravel Fortify
- FFmpeg (processamento de vídeo)

### Frontend
- Vue.js 3
- Vite
- Vue Router
- Pinia (gerenciamento de estado)
- Tailwind CSS
- Flowbite
- Axios
- Video.js

## 📂 Estrutura de Pastas

```
video-sharing/
├── laravel-api/          # Backend Laravel
│   ├── app/
│   │   ├── Http/Controllers/
│   │   ├── Models/
│   │   ├── Services/
│   │   └── ...
│   ├── routes/api.php    # Rotas da API
│   └── ...
├── vue-spa/              # Frontend Vue.js
│   ├── src/
│   │   ├── components/
│   │   ├── views/
│   │   ├── router/
│   │   └── stores/
│   └── ...
└── docker-compose.yml    # Configuração Docker
```

## 🔐 Autenticação

O projeto utiliza JWT (JSON Web Tokens) para autenticação. Após o login, o token deve ser incluído no header das requisições:

```
Authorization: Bearer {token}
```

## 📧 Emails (Desenvolvimento)

Durante o desenvolvimento, os emails são capturados pelo Mailpit e podem ser visualizados em:
http://localhost:8025

## 🚨 Solução de Problemas

### Erro de permissões
```bash
docker-compose exec laravel chmod -R 775 storage/
docker-compose exec laravel chmod -R 775 bootstrap/cache/
```

### Recriar containers
```bash
docker-compose down
docker-compose up -d --build
```

### Limpar volumes Docker
```bash
docker-compose down -v
docker-compose up -d
```

## 📄 Licença

Este projeto está licenciado sob a Licença MIT - veja o arquivo [LICENSE](LICENSE) para detalhes.
