<p align="center">
<a href="hhttps://www.adoorei.com.br/" target="_blank">
<img src="https://adoorei.s3.us-east-2.amazonaws.com/images/loje_teste_logoadoorei_1662476663.png" width="160"></a>
</p>

# Este code challenge foi promovido pela adoorei
Este projeto é uma API Rest desenvolvida em Laravel, utilizando Docker para facilitar a execução do ambiente de desenvolvimento.
Diversos conceitos de DDD e clean code foram aplicados para modelar e organizar o código de acordo com as regras de negócios do domínio.

# O Problema proposto
* Listar produtos disponíveis
* Cadastrar nova venda
* Consultar vendas realizadas
* Consultar uma venda específica
* Cancelar uma venda
* Cadastrar novas produtos a uma venda

## Configuração do Ambiente
Certifique-se de ter o Docker e o Docker Compose instalados no seu sistema antes de prosseguir.

### Comandos Principais
1. **Construir o Contêiner Docker:**
```bash
   docker-compose build
```
2. Iniciar o Contêiner Docker:
```bash
docker-compose up -d
```
3. Instalar Dependências PHP (Dentro do Contêiner):
```bash
docker-compose exec app composer install
``` 
4. Executar Migrations e Seeds (Dentro do Contêiner):
```bash
docker-compose exec app php artisan migrate --seed
```

5. Executar Testes (Dentro do Contêiner):
```bash
docker-compose exec app php artisan test 
```

# Documentação
A documentação detalhada da API está disponível no arquivo JSON do Postman, localizado em doc/LaravelChallengeApiDoc.postman_collection.json. Este arquivo pode ser importado no Postman para obter informações detalhadas sobre os endpoints, parâmetros e exemplos de requisições.

# Agradecimentos
Deixo aqui meus agradecimentos a este desafio proposto, é bem legal montar uma stack backend full para endpoints e deixar tudo redondinho hehehe
Como uma lição extra irei criar um action para esse projeto no github.
