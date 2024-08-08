# Transações e Estatísticas API

Este é um projeto de exemplo para um teste de prova. 
O projeto consiste em uma API desenvolvida em Laravel para gerenciar transações e calcular estatísticas em tempo real 
com base nas transações realizadas nos últimos 60 segundos.

## Funcionalidades Principais

### Endpoints da API

1. **POST /api/transactions**
    - **Descrição**: Cria uma nova transação.
    - **Corpo da Requisição**:
      ```json
      {
        "amount": "12.3343",
        "timestamp": "2024-08-07T09:59:51.312Z"
      }
      ```
    - **Respostas**:
        - `201`: Transação criada com sucesso.
        - `204`: Transação fora do intervalo de 60 segundos (muito antiga).
        - `422`: Timestamp inválido ou no futuro.

2. **GET /api/statistics**
    - **Descrição**: Retorna as estatísticas das transações realizadas nos últimos 60 segundos.
    - **Resposta**:
      ```json
      {
        "sum": "1000.00",
        "avg": "100.53",
        "max": "200000.49",
        "min": "50.23",
        "count": 10
      }
      ```

3. **DELETE /api/transactions**
    - **Descrição**: Exclui todas as transações.
    - **Respostas**:
        - `204`: Todas as transações foram excluídas com sucesso.

## Requisitos

- PHP 8.2 ou superior
- Laravel 8.x
- Composer
    
