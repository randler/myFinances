

![Logo](https://github.com/randler/myFinances/blob/master/finance-logo-6277C6570C-seeklogo.com.png?raw=true)

# My Finance

Projeto criado com a finalidade de ajudar no seu orçamento mensal e ajudar a economizar dinheiro.



## Autores

- [@Randler](https://github.com/randler)
- [@Diego](https://github.com/DiegoFerraz07)


## Referência

Os pre-requisitos para que o projeto funcione são os seguintes

 - [Docker](https://docs.docker.com/engine/install/)
 - [Composer](https://getcomposer.org/download/)

## Instalação

Para instalar o projeto você precisa rodar os seguintes comandos.

```bash
  $ git clone https://github.com/randler/myFinances.git
  $ cd myFinance
  $ composer install
  $ ./vendor/bin/sail up -d
```

### Alias sail
Crie um alias para o sail para ficar mais facil com o seguinte comando:

Se estiver usando o **zsh**
```bash
nano ~/.zshrc
```

Então adicione a seguinte linha
```bash
alias sail='[ -f sail ] && bash sail || bash vendor/bin/sail'
```

então rode o comando 
```bash
source ~/.zshrc
```

Caso esteja usando o **bash** 
```bash
nano ~/.bash_profile
```

E então adicione a seguinte linha
```bash
alias sail='[ -f sail ] && bash sail || bash vendor/bin/sail'
```


então rode o comando 

```bash
source ~/.bash_profile
```

### Iniciando projeto

Agora copie o **.env-example** para um arquivo **.env** e gere uma nova gave do projeto conforme os comandos abaixo:
```bash
  $ cp .env.example .env
  $ php artisan key:generate
```

### Iniciando Banco de dados
Agora crie o banco de dados e as tabelas com o seguinte comando:
```bash
  $ sail artisan migrate
  $ sail artisan db:seed
```

Crie um novo usuário para ter acesso ao admin do filament com o seguinte comando:
```bash
  $ sail artisan make:filament-user
```

Preencha todos os dados que for pedido


### Testando

Agora basta acessar a rota localhost para verificar se está ok:
```bash
http://localhost
```

Para verificar o projeto com o filement basta acessar 
```bash
http://localhost/admin
```