# Backend Dictionary API - Challenge by Coodesh

Este é um teste para avaliar as habilidades de desenvolvimento backend para a vaga de Desenvolvedor PHP.

## Introdução

Neste README, será abordado os passos de desenvolvimento da atividade

### Passo 1

O primeiro passo foi a escolha das tecnologias e frameworks a serem usadas para o desenvolvimento da atividade. Devido a familiaridade, foi decidido o uso do Laravel como framework principal para o projeto com o banco de dados MySQL. Mais a frente, também foi decidido o uso do Redis como tecnologia principal para realizar o caching das requisições.

Outra tecnologia usada para este projeto foi o Laradock, que é um conjunto de contêineres Docker pré-configurados para rodar projetos Laravel facilmente, garantindo praticidade e um desenvolvimento mais ágil.

### Passo 2

O segundo passo foi dar início a criação e estruturação das endpoints. Foi definido que a arquitetura do projeto seguiria por uma linha mas simples, onde as rotas seriam definidas no arquivo de rotas padrão do Laravel e os Controllers iriam acessar e manipular os dados do banco utilizando o Eloquent.

A partir disso, os endpoints foram criados e testados, retornando as respostas com o body igual o especificado no readme original da atividade.

Para alguns grupos de endpoints, foi necessário a criação de modelos e migrations para o banco de dados com base nas demandas da atividade, como por exemplo histórico de acessos e palavras favoritas. Não possuem controllers próprios, mas servem como um auxiliar para satisfazer os requisitos do projeto.

### Passo 3

O terceiro passo foi basicamente importar os dados do Json do repositório original da API para alimentar a base de dados com todas as palavras necessárias para o funcionamento da API da atividade.

Para isso, foi criado um modelo e um seeder para popular a tabela no banco. O seeder, por sua vez, realiza uma requisição HTTP na url do arquivo RAW e cria os registros para cada palavra encontrada utilizando o próprio Eloquent.

### Passo 4

O quarto passo foi definir a tecnologia a ser usada para realizar o caching das requisições. Para essa tarefa, foi definido que seria utilizado o Redis para maior praticidade e eficiência para o projeto.

O caching foi feito por um middleware, que realiza o caching para toda requisição do tipo GET feito na API.

#### Tecnologias (Back-End):
- API - PHP Laravel
- Banco de dados MySQL
- Gerenciamento de cache - Redis

### Modelo de Dados:

<details open>
<summary>[GET] /</summary>
<p>
Retornar a mensagem "Fullstack Challenge 🏅 - Dictionary"
</p>

```json
{
    "message": "Fullstack Challenge 🏅 - Dictionary"
}
```
</details>
<details open>
<summary>[POST] /auth/signup</summary>

```json
{
    "name": "User 1",
    "email": "example@email.com",
    "password": "test"
}
```

```json
{
    "id": "f3a10cec013ab2c1380acef",
    "name": "User 1",
    "token": "Bearer JWT.Token"
}
```
</details>
<details open>
<summary>[POST] /auth/signin</summary>

```json
{
    "email": "example@email.com",
    "password": "test"
}
```

```json
{
    "id": "f3a10cec013ab2c1380acef",
    "name": "User 1",
    "token": "Bearer JWT.Token"
}
```
</details>
<details open>
<summary>[GET] /entries/en</summary>

```json
{
    "results": [
        "fire",
        "firefly",
        "fireplace",
        "fireman"
    ],
    "totalDocs": 20,
    "page": 1,
    "totalPages": 5, 
    "hasNext": true,
    "hasPrev": false
}
```
</details>
<details open>
<summary>[GET] /entries/en/:word</summary>

```json
[
    {
    "word": "fire",
    "phonetic": "/ˈfɑeə(ɹ)/",
    "phonetics": [
			{
				"text": "/ˈfɑeə(ɹ)/",
				"audio": ""
			},
			{
				"text": "/ˈfaɪə(ɹ)/",
				"audio": ""
			},
			{
				"text": "/ˈfaɪɚ/",
				"audio": "https://api.dictionaryapi.dev/media/pronunciations/en/fire-us.mp3",
				"sourceUrl": "https://commons.wikimedia.org/w/index.php?curid=424744",
				"license": {
					"name": "BY-SA 3.0",
					"url": "https://creativecommons.org/licenses/by-sa/3.0"
				}
			}
		],
    }   
]
```

</details>
<details open>
<summary>[POST] /entries/en/:word/favorite</summary>

```json
{
	"user_id": "8bfee185-0d92-45d3-8cb5-6f119c57c439",
	"word": "water"
}
```

</details>
<details open>
<summary>[DELETE] /entries/en/:word/unfavorite</summary>

```json
{
	"user_id": "8bfee185-0d92-45d3-8cb5-6f119c57c439",
	"word": "water"
}
```

</details> 
<details open>
<summary>[GET] /user/me</summary>

```json
{
	"id": "8bfee185-0d92-45d3-8cb5-6f119c57c439",
	"name": "User 1",
	"email": "example@email.com",
	"email_verified_at": null,
	"created_at": "2025-03-23T14:06:15.000000Z",
	"updated_at": "2025-03-23T14:06:15.000000Z"
}
```

</details> 
<details open>
<summary>[GET] /user/me/history</summary>

```json
{
    "results": [
        {
            "word": "fire",
            "added": "2022-05-05T19:28:13.531Z"
        },
        {
            "word": "firefly",
            "added": "2022-05-05T19:28:44.021Z"
        },
        {
            "word": "fireplace",
            "added": "2022-05-05T19:29:28.631Z"
        },
        {
            "word": "fireman",
            "added": "2022-05-05T19:30:03.711Z"
        }
    ],
    "totalDocs": 20,
    "page": 2,
    "totalPages": 5,
    "hasNext": true,
    "hasPrev": true
}
```
</details> 
<details open>
<summary>[GET] /user/me/favorites</summary>

```json
{
    "results": [
        {
            "word": "fire",
            "added": "2022-05-05T19:30:23.928Z"
        },
        {
            "word": "firefly",
            "added": "2022-05-05T19:30:24.088Z"
        },
        {
            "word": "fireplace",
            "added": "2022-05-05T19:30:28.963Z"
        },
        {
            "word": "fireman",
            "added": "2022-05-05T19:30:33.121Z"
        }
    ],
    "totalDocs": 20,
    "page": 2,
    "totalPages": 5,
    "hasNext": true,
    "hasPrev": true
}
```

</details>

Mensagem de erro:

```json
{
    "message": "Error message"
}
```

**Diferencial** - Documentação da API feita em OpenAPI 3.0 utilizando swagger, para visualizar, basta acessar [http://localhost/swagger](http://localhost/swagger)

**Diferencial** - Projeto configurado em docker utilizando Laradock. Para rodar, basta seguir as instruções na [documentação oficial](https://laradock.io/docs/Intro).

