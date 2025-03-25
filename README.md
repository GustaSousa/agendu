# Agendu 🏫📅

Agendu é um sistema web para agendamento de ambientes na Unoeste Guarujá (Universidade do Oeste Paulista - Campus Guarujá). Ele permite que usuários reservem salas de aula, salas de tutoria e auditórios de maneira eficiente, garantindo uma melhor organização dos espaços acadêmicos.

## 📌 Funcionalidades

✔️ Cadastro e login de usuários (admin e não admin)
✔️ Agendamento de ambientes com detalhes como data, horário e necessidades audiovisuais
✔️ Listagem de agendamentos em ordem cronológica
✔️ Edição e exclusão de agendamentos (somente para administradores)
✔️ Gerenciamento de usuários (somente para administradores)
✔️ Sistema de permissões para evitar acessos não autorizados
✔️ Redirecionamento automático para usuários logados

## 🛠 Tecnologias utilizadas

    •	Backend: PHP + SQLite
    •	Frontend: HTML, CSS (básico)
    •	Servidor: PHP embutido (php -S localhost:8080) ou Apache
    •	Gerenciamento de dependências: Nenhum (por enquanto)

## 🚀 Como rodar o projeto?

### 1️⃣ Clone o repositório:

> `git clone https://github.com/seu-usuario/agendu.git`
>
> `cd agendu`

### 2️⃣ Inicie o servidor PHP (caso esteja usando o servidor embutido do PHP)

> `php -S localhost:8080 -t public`

### 3️⃣ Acesse no navegador:

> `http://localhost:8080`

📂 Estrutura do projeto

/agendu

│── /public # Arquivos acessíveis pelo navegador (index.php, login.php, etc.)  
│── /src # Código principal (dashboard.php, schedule.php, etc.)  
│── /config # Configurações (config.php)  
│── /database # Banco de dados SQLite (agendu.sqlite)  
│── README.md # Documentação do projeto

## 🔑 Acesso e permissões

    •	Qualquer pessoa pode se registrar e criar um usuário.
    •	Somente administradores podem editar/excluir agendamentos e gerenciar usuários.
    •	Se um usuário não estiver logado, ele será redirecionado automaticamente para a página de login.

## 📌 Próximos passos (ideias de melhorias)

🔹 Melhorar a interface com CSS e Bootstrap
🔹 Implementar pesquisa e filtros nos agendamentos
🔹 Envio de e-mails de confirmação para agendamentos
🔹 Migrar o banco para MySQL/PostgreSQL caso necessário
