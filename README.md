# TESTE BUDMOL

## 📌 Descrição  
Event Manager é um sistema web desenvolvido em Laravel para gerenciamento de eventos e inscrições.  
- **Admin**: Gerencia eventos.  
- **Participante**: Inscreve-se e cancela inscrições.  

## 🚀 Funcionalidades  
- **Autenticação**: Login, registro, logout e controle de acesso (Admin/Participante).  
- **Eventos**: CRUD de eventos com título, descrição, data, local, status e capacidade.  
- **Inscrição**: Participantes podem se inscrever e cancelar inscrições.  
- **Notificações**: Envio de e-mails de confirmação/cancelamento.  
- **API RESTful**: Endpoints protegidos com Laravel Sanctum.  

## ⚙️ Tecnologias  
- **Laravel 12 (PHP 8.x)**  
- **Banco de Dados:** SQLite / MySQL  
- **Autenticação:** Sanctum  
- **Estilização:** Blade + CSS  
- **Testes:** PHPUnit  

## 👅 Instalação e Configuração  

### 1️⃣ Clonar o Repositório  
```bash
git clone https://github.com/daviwliam/TESTE-BUDMOL.git
cd event-manager
```

### 2️⃣ Instalar Dependências  
```bash
composer install
```

### 3️⃣ Configurar o Ambiente  
```bash
cp .env.example .env
php artisan key:generate
```
- Edite o arquivo `.env` e configure a conexão com o banco de dados.

### 4️⃣ Migrar o Banco de Dados  
```bash
php artisan migrate
```

### 5️⃣ Configuração de Envio de E-mails  
No arquivo `.env`, configure as seguintes variáveis para envio de e-mails:  
```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=465
MAIL_USERNAME=testebudmol@gmail.com
MAIL_PASSWORD="xoae bwrf sumo zgyp"
MAIL_ENCRYPTION=ssl
MAIL_FROM_ADDRESS=testebudmol@gmail.com
MAIL_FROM_NAME="Teste Budmol"
```

### 6️⃣ Iniciar o Servidor  
```bash
php artisan serve
```
Acesse a aplicação em: [http://localhost:8000](http://localhost:8000)

---

## 🔗 API & Documentação  
- **Collection Postman**: Disponível no diretório do projeto (`API-Events.json`).  
- **Endpoints**: Veja todas as rotas com:  
  ```bash
  php artisan route:list
  ```

## ✅ Execução de Testes  
Para rodar os testes:  
```bash
php artisan test
```

## 📂 Repositório  
[GitHub - Teste Budmol](https://github.com/daviwiliam/TESTE-BUDMOL)

## 📝 Licença  
Este projeto está licenciado sob a Licença MIT - veja o arquivo [LICENSE](LICENSE) para mais detalhes.