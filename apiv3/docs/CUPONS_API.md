# API de Cupons de Desconto

> Documentação para o sistema de cupons de desconto por parceiro para hospedagens, eventos e experiências.

---

## Índice

1. [Visão Geral](#visão-geral)
2. [Gerenciamento de Cupons (Parceiro)](#gerenciamento-de-cupons-parceiro)
3. [Uso de Cupons (Cliente)](#uso-de-cupons-cliente)
4. [Integração com Reservas](#integração-com-reservas)
5. [Histórico e Estatísticas](#histórico-e-estatísticas)

---

## Visão Geral

O sistema de cupons permite que parceiros (anunciantes) criem cupons de desconto para seus anúncios. Os cupons podem ser:

- **Por anúncio específico** ou **todos os anúncios do parceiro**
- **Percentual** (ex: 10% de desconto) ou **Valor fixo** (ex: R$ 50,00 de desconto)
- **Limitados por tempo** (data início e fim)
- **Limitados por uso** (uso máximo total e/ou por usuário)
- **Restritos por categoria** (hospedagem, experiência, evento)
- **Com valor mínimo** de compra

### Tipos de Desconto

| tipo_desconto | Descrição |
|---------------|-----------|
| 1 | Percentual (ex: 10% de desconto) |
| 2 | Valor Fixo (ex: R$ 50,00 de desconto) |

### Categorias

| id_categoria | Descrição |
|--------------|-----------|
| 1 | Hospedagem |
| 2 | Experiência |
| 3 | Evento |

---

## Gerenciamento de Cupons (Parceiro)

### Criar Cupom

Cria um novo cupom de desconto.

**Endpoint:** `POST /apiv3/user/cupons/criar`

**Headers:**
```
Content-Type: application/json
```

**Payload:**
```json
{
  "token": "Qd721n2E",
  "id_user": 10,
  "id_anuncio": null,
  "codigo": "NATAL2025",
  "descricao": "Desconto de Natal - 15% em todas as reservas",
  "tipo_desconto": 1,
  "valor_desconto": 15,
  "valor_minimo": 100,
  "uso_maximo": 100,
  "uso_por_usuario": 1,
  "data_inicio": "2025-12-01",
  "data_fim": "2025-12-31",
  "categorias": [1, 2, 3]
}
```

| Campo | Tipo | Obrigatório | Descrição |
|-------|------|-------------|-----------|
| token | string | Sim | Token de autenticação do app |
| id_user | int | Sim | ID do parceiro/anunciante |
| id_anuncio | int | Não | ID do anúncio específico (null = todos) |
| codigo | string | Sim | Código do cupom (único, será convertido para maiúsculas) |
| descricao | string | Não | Descrição do cupom |
| tipo_desconto | int | Sim | 1=percentual, 2=valor fixo |
| valor_desconto | decimal | Sim | Valor ou percentual de desconto |
| valor_minimo | decimal | Não | Valor mínimo da reserva (default: 0) |
| uso_maximo | int | Não | Limite de usos totais (null = ilimitado) |
| uso_por_usuario | int | Não | Limite de usos por usuário (default: 1) |
| data_inicio | date | Sim | Data início de validade (YYYY-MM-DD) |
| data_fim | date | Sim | Data fim de validade (YYYY-MM-DD) |
| categorias | array | Não | Categorias permitidas [1,2,3] (null = todas) |

**Retorno Sucesso:**
```json
[
  {
    "status": "01",
    "id": 5,
    "msg": "Cupom criado com sucesso."
  }
]
```

**Retorno Erro - Código duplicado:**
```json
[
  {
    "status": "02",
    "msg": "Este código de cupom já está em uso."
  }
]
```

---

### Atualizar Cupom

**Endpoint:** `POST /apiv3/user/cupons/atualizar`

**Payload:**
```json
{
  "token": "Qd721n2E",
  "id": 5,
  "id_user": 10,
  "codigo": "NATAL2025",
  "descricao": "Desconto de Natal - 20% em todas as reservas",
  "tipo_desconto": 1,
  "valor_desconto": 20,
  "valor_minimo": 150,
  "uso_maximo": 200,
  "uso_por_usuario": 2,
  "data_inicio": "2025-12-01",
  "data_fim": "2025-12-31",
  "categorias": [1, 2, 3],
  "ativo": 1
}
```

| Campo | Tipo | Obrigatório | Descrição |
|-------|------|-------------|-----------|
| id | int | Sim | ID do cupom |
| ativo | int | Não | 1=ativo, 0=inativo (default: 1) |
| (demais campos) | - | - | Mesmos campos da criação |

**Retorno Sucesso:**
```json
[
  {
    "status": "01",
    "msg": "Cupom atualizado com sucesso."
  }
]
```

---

### Excluir Cupom

Desativa o cupom (soft delete).

**Endpoint:** `POST /apiv3/user/cupons/excluir`

**Payload:**
```json
{
  "token": "Qd721n2E",
  "id": 5,
  "id_user": 10
}
```

**Retorno Sucesso:**
```json
[
  {
    "status": "01",
    "msg": "Cupom excluído com sucesso."
  }
]
```

---

### Listar Cupons do Parceiro

Lista todos os cupons criados pelo parceiro.

**Endpoint:** `POST /apiv3/user/cupons/listar`

**Payload:**
```json
{
  "token": "Qd721n2E",
  "id_user": 10,
  "ativo": 1
}
```

| Campo | Tipo | Obrigatório | Descrição |
|-------|------|-------------|-----------|
| token | string | Sim | Token de autenticação |
| id_user | int | Sim | ID do parceiro |
| ativo | int | Não | Filtrar por status (null = todos) |

**Retorno:**
```json
[
  {
    "id": 5,
    "app_users_id": 10,
    "app_anuncios_id": null,
    "codigo": "NATAL2025",
    "descricao": "Desconto de Natal - 20% em todas as reservas",
    "tipo_desconto": 1,
    "tipo_desconto_label": "percentual",
    "valor_desconto": "20.00",
    "valor_minimo": "150.00",
    "uso_maximo": 200,
    "uso_por_usuario": 2,
    "usos_realizados": 15,
    "data_inicio": "2025-12-01",
    "data_fim": "2025-12-31",
    "categorias": "1,2,3",
    "categorias_array": ["1", "2", "3"],
    "ativo": 1,
    "valido": true,
    "total_usos": 15,
    "nome_anuncio": null
  }
]
```

---

### Detalhes do Cupom

**Endpoint:** `POST /apiv3/user/cupons/detalhes`

**Payload:**
```json
{
  "token": "Qd721n2E",
  "id": 5,
  "id_user": 10
}
```

**Retorno:**
```json
[
  {
    "status": "01",
    "cupom": {
      "id": 5,
      "codigo": "NATAL2025",
      "descricao": "Desconto de Natal - 20% em todas as reservas",
      "tipo_desconto": 1,
      "tipo_desconto_label": "percentual",
      "valor_desconto": "20.00",
      "valor_minimo": "150.00",
      "uso_maximo": 200,
      "uso_por_usuario": 2,
      "usos_realizados": 15,
      "data_inicio": "2025-12-01",
      "data_inicio_formatada": "01/12/2025",
      "data_fim": "2025-12-31",
      "data_fim_formatada": "31/12/2025",
      "categorias": "1,2,3",
      "categorias_array": ["1", "2", "3"],
      "ativo": 1
    }
  }
]
```

---

## Uso de Cupons (Cliente)

### Listar Cupons Disponíveis

Lista cupons públicos disponíveis para um anúncio.

**Endpoint:** `POST /apiv3/user/cupons/disponiveis`

**Payload:**
```json
{
  "token": "Qd721n2E",
  "id_anuncio": 13
}
```

**Retorno:**
```json
[
  {
    "codigo": "NATAL2025",
    "descricao": "Desconto de Natal - 20% em todas as reservas",
    "tipo_desconto": 1,
    "tipo_desconto_label": "percentual",
    "valor_desconto": "20.00",
    "valor_minimo": "150.00",
    "data_fim": "31/12/2025"
  },
  {
    "codigo": "PROMO50",
    "descricao": "R$ 50 de desconto",
    "tipo_desconto": 2,
    "tipo_desconto_label": "valor_fixo",
    "valor_desconto": "50.00",
    "valor_minimo": "200.00",
    "data_fim": "15/12/2025"
  }
]
```

---

### Validar Cupom

Valida um cupom antes de aplicar na reserva.

**Endpoint:** `POST /apiv3/user/cupons/validar`

**Payload:**
```json
{
  "token": "Qd721n2E",
  "codigo": "NATAL2025",
  "id_user": 334,
  "id_anuncio": 13,
  "id_categoria": 1,
  "valor": 500
}
```

| Campo | Tipo | Obrigatório | Descrição |
|-------|------|-------------|-----------|
| token | string | Sim | Token de autenticação |
| codigo | string | Sim | Código do cupom |
| id_user | int | Sim | ID do cliente |
| id_anuncio | int | Sim | ID do anúncio |
| id_categoria | int | Sim | Categoria do anúncio |
| valor | decimal | Sim | Valor total da reserva |

**Retorno Sucesso:**
```json
[
  {
    "status": "01",
    "valido": true,
    "msg": "Cupom válido!",
    "cupom": {
      "id": 5,
      "codigo": "NATAL2025",
      "descricao": "Desconto de Natal - 20% em todas as reservas",
      "tipo_desconto": 1,
      "tipo_desconto_label": "percentual",
      "valor_desconto_config": "20.00"
    },
    "valores": {
      "valor_original": "500.00",
      "valor_desconto": "100.00",
      "valor_final": "400.00"
    }
  }
]
```

**Retorno Erro - Cupom expirado:**
```json
[
  {
    "status": "02",
    "valido": false,
    "msg": "Este cupom expirou em 31/12/2024"
  }
]
```

**Retorno Erro - Valor mínimo:**
```json
[
  {
    "status": "02",
    "valido": false,
    "msg": "Valor mínimo para usar este cupom é R$ 150,00"
  }
]
```

**Retorno Erro - Limite de uso:**
```json
[
  {
    "status": "02",
    "valido": false,
    "msg": "Você já utilizou este cupom o número máximo de vezes permitido."
  }
]
```

**Retorno Erro - Categoria inválida:**
```json
[
  {
    "status": "02",
    "valido": false,
    "msg": "Este cupom é válido apenas para: hospedagens, experiências"
  }
]
```

---

## Integração com Reservas

### Reserva com Cupom

Para aplicar um cupom na reserva, adicione o campo `codigo_cupom` no payload.

**Endpoint:** `POST /apiv3/user/reservas/iniciar`

**Payload com Cupom:**
```json
{
  "token": "Qd721n2E",
  "id_user": 334,
  "id_anuncio": 13,
  "id_anuncio_type": 5,
  "id_carrinho": 12,
  "id_categoria": 1,
  "adultos": 2,
  "criancas": 0,
  "data_de": "20/12/2025",
  "data_ate": "25/12/2025",
  "valor": 500,
  "obs": "",
  "tipo_pagamento": 1,
  "cartao_id": 15,
  "cpf": "12345678900",
  "codigo_cupom": "NATAL2025"
}
```

| Campo | Tipo | Obrigatório | Descrição |
|-------|------|-------------|-----------|
| codigo_cupom | string | Não | Código do cupom de desconto |
| (demais campos) | - | - | Campos normais da reserva |

**Retorno Sucesso com Cupom:**
```json
[
  {
    "status": "01",
    "tipo_pagamento": "1",
    "id_pagamento": 89,
    "id_reserva": 156,
    "payment_id": "pay_123456789",
    "status": "CONFIRMED",
    "msg": "Pagamento efetuado!",
    "cupom_aplicado": true,
    "valor_original": 500,
    "valor_desconto": 100,
    "valor_final": 400
  }
]
```

**Retorno Erro - Cupom Inválido:**

Se o cupom for inválido, a reserva **NÃO é criada** e retorna o erro de validação:

```json
[
  {
    "status": "02",
    "valido": false,
    "msg": "Este cupom expirou em 31/12/2024"
  }
]
```

### Fluxo de Desconto 100%

Se o desconto cobrir 100% do valor da reserva, ela é tratada como **cortesia**:

```json
{
  "token": "Qd721n2E",
  "id_user": 334,
  "id_anuncio": 13,
  "valor": 50,
  "codigo_cupom": "PROMO50"
}
```

**Retorno:**
```json
[
  {
    "status": "01",
    "tipo_pagamento": "4",
    "cortesia": true,
    "msg": "Reserva cortesia confirmada!",
    "cupom_aplicado": true,
    "valor_original": 50,
    "valor_desconto": 50,
    "valor_final": 0
  }
]
```

---

## Histórico e Estatísticas

### Histórico de Uso (Parceiro)

Lista todos os usos dos cupons do parceiro.

**Endpoint:** `POST /apiv3/user/cupons/historico`

**Payload:**
```json
{
  "token": "Qd721n2E",
  "id_user": 10
}
```

**Retorno:**
```json
[
  {
    "id": 25,
    "app_cupons_id": 5,
    "app_users_id": 334,
    "app_reservas_id": 156,
    "valor_original": "500.00",
    "valor_desconto": "100.00",
    "valor_final": "400.00",
    "data_uso": "2025-12-10 14:30:00",
    "data_uso_formatada": "10/12/2025 14:30",
    "codigo": "NATAL2025",
    "cupom_descricao": "Desconto de Natal",
    "nome_cliente": "João Silva",
    "email_cliente": "joao@email.com",
    "nome_anuncio": "Casa de Praia"
  }
]
```

---

### Meus Cupons Usados (Cliente)

Lista cupons usados pelo cliente.

**Endpoint:** `POST /apiv3/user/cupons/meus-cupons`

**Payload:**
```json
{
  "token": "Qd721n2E",
  "id_user": 334
}
```

**Retorno:**
```json
[
  {
    "id": 25,
    "valor_original": "500.00",
    "valor_desconto": "100.00",
    "valor_final": "400.00",
    "data_uso": "2025-12-10 14:30:00",
    "data_uso_formatada": "10/12/2025 14:30",
    "codigo": "NATAL2025",
    "cupom_descricao": "Desconto de Natal",
    "nome_anuncio": "Casa de Praia"
  }
]
```

---

### Estatísticas de Cupons (Parceiro)

Resumo estatístico dos cupons do parceiro.

**Endpoint:** `POST /apiv3/user/cupons/estatisticas`

**Payload:**
```json
{
  "token": "Qd721n2E",
  "id_user": 10
}
```

**Retorno:**
```json
[
  {
    "status": "01",
    "estatisticas": {
      "total_cupons": 5,
      "cupons_ativos": 3,
      "total_usos": 45,
      "total_desconto_concedido": "4500.00",
      "total_desconto_formatado": "R$ 4.500,00"
    }
  }
]
```

---

## Exemplos de Uso

### cURL - Criar Cupom Percentual

```bash
curl -X POST "https://seudominio.com/apiv3/user/cupons/criar" \
  -H "Content-Type: application/json" \
  -d '{
    "token": "Qd721n2E",
    "id_user": 10,
    "codigo": "VERAO10",
    "descricao": "10% de desconto no verão",
    "tipo_desconto": 1,
    "valor_desconto": 10,
    "data_inicio": "2025-12-01",
    "data_fim": "2026-02-28",
    "categorias": [1]
  }'
```

### cURL - Criar Cupom Valor Fixo

```bash
curl -X POST "https://seudominio.com/apiv3/user/cupons/criar" \
  -H "Content-Type: application/json" \
  -d '{
    "token": "Qd721n2E",
    "id_user": 10,
    "codigo": "DESC50",
    "descricao": "R$ 50 de desconto",
    "tipo_desconto": 2,
    "valor_desconto": 50,
    "valor_minimo": 200,
    "uso_maximo": 100,
    "data_inicio": "2025-12-01",
    "data_fim": "2025-12-31"
  }'
```

### cURL - Validar Cupom

```bash
curl -X POST "https://seudominio.com/apiv3/user/cupons/validar" \
  -H "Content-Type: application/json" \
  -d '{
    "token": "Qd721n2E",
    "codigo": "VERAO10",
    "id_user": 334,
    "id_anuncio": 13,
    "id_categoria": 1,
    "valor": 1000
  }'
```

### cURL - Reserva com Cupom

```bash
curl -X POST "https://seudominio.com/apiv3/user/reservas/iniciar" \
  -H "Content-Type: application/json" \
  -d '{
    "token": "Qd721n2E",
    "id_user": 334,
    "id_anuncio": 13,
    "id_anuncio_type": 5,
    "id_carrinho": 12,
    "id_categoria": 1,
    "adultos": 2,
    "criancas": 0,
    "data_de": "20/12/2025",
    "data_ate": "25/12/2025",
    "valor": 1000,
    "obs": "",
    "tipo_pagamento": 3,
    "cpf": "12345678900",
    "codigo_cupom": "VERAO10"
  }'
```

---

## Alterações no Banco de Dados

```sql
-- Tabela principal de cupons
CREATE TABLE app_cupons (
    id INT AUTO_INCREMENT PRIMARY KEY,
    app_users_id INT NOT NULL COMMENT 'ID do parceiro/anunciante',
    app_anuncios_id INT DEFAULT NULL COMMENT 'NULL = válido para todos os anúncios do parceiro',
    codigo VARCHAR(50) NOT NULL COMMENT 'Código do cupom',
    descricao VARCHAR(255) DEFAULT NULL COMMENT 'Descrição do cupom',
    tipo_desconto TINYINT(1) NOT NULL DEFAULT 1 COMMENT '1=percentual, 2=valor fixo',
    valor_desconto DECIMAL(10,2) NOT NULL COMMENT 'Valor ou percentual de desconto',
    valor_minimo DECIMAL(10,2) DEFAULT 0.00 COMMENT 'Valor mínimo da reserva para usar o cupom',
    uso_maximo INT DEFAULT NULL COMMENT 'Limite de usos totais (NULL = ilimitado)',
    uso_por_usuario INT DEFAULT 1 COMMENT 'Limite de usos por usuário',
    usos_realizados INT DEFAULT 0 COMMENT 'Contador de usos',
    data_inicio DATE NOT NULL COMMENT 'Data início de validade',
    data_fim DATE NOT NULL COMMENT 'Data fim de validade',
    categorias VARCHAR(50) DEFAULT NULL COMMENT 'Categorias permitidas (1,2,3) ou NULL para todas',
    ativo TINYINT(1) DEFAULT 1 COMMENT '1=ativo, 0=inativo',
    data_cadastro DATETIME DEFAULT CURRENT_TIMESTAMP,
    UNIQUE KEY unique_codigo (codigo),
    INDEX idx_users (app_users_id),
    INDEX idx_anuncios (app_anuncios_id),
    INDEX idx_codigo_ativo (codigo, ativo),
    INDEX idx_datas (data_inicio, data_fim)
);

-- Tabela de histórico de uso
CREATE TABLE app_cupons_uso (
    id INT AUTO_INCREMENT PRIMARY KEY,
    app_cupons_id INT NOT NULL COMMENT 'ID do cupom',
    app_users_id INT NOT NULL COMMENT 'ID do usuário que usou',
    app_reservas_id INT NOT NULL COMMENT 'ID da reserva',
    valor_original DECIMAL(10,2) NOT NULL COMMENT 'Valor original da reserva',
    valor_desconto DECIMAL(10,2) NOT NULL COMMENT 'Valor do desconto aplicado',
    valor_final DECIMAL(10,2) NOT NULL COMMENT 'Valor final após desconto',
    data_uso DATETIME DEFAULT CURRENT_TIMESTAMP,
    INDEX idx_cupom (app_cupons_id),
    INDEX idx_user (app_users_id),
    INDEX idx_reserva (app_reservas_id)
);
```

---

## Arquivos Criados/Modificados

| Arquivo | Descrição |
|---------|-----------|
| `models/Cupons/Cupons.class.php` | Model com CRUD e validação de cupons |
| `controllers/Cupons/Cupons.controller.php` | Controller com endpoints de cupons |
| `controllers/Reservas/Reservas.controller.php` | Modificado para integrar cupons |

---

## Changelog

| Data | Versão | Descrição |
|------|--------|-----------|
| 10/12/2025 | 1.0.0 | Implementação inicial do sistema de cupons |

---

*Documentação gerada em 10 de dezembro de 2025*
