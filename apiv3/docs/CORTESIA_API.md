# API de Cortesia (Ingressos e Reservas Gratuitas)

> Documentação para gerenciamento de ingressos, hospedagens, eventos e experiências sem custo.

---

## Índice

1. [Visão Geral](#visão-geral)
2. [Tipos de Ingressos Cortesia](#tipos-de-ingressos-cortesia)
3. [Períodos de Hospedagem Cortesia](#períodos-de-hospedagem-cortesia)
4. [Reservas Cortesia](#reservas-cortesia)
5. [Listagem com Campo Cortesia](#listagem-com-campo-cortesia)

---

## Visão Geral

O sistema de cortesia permite criar ingressos, hospedagens e experiências **gratuitas**. Quando um item é marcado como cortesia:

- **Valor:** Pode ser 0 ou qualquer valor (o campo `cortesia` sobrescreve)
- **Pagamento:** Não é processado (tipo_pagamento = 4)
- **Reserva:** É confirmada automaticamente (status = 1)
- **QR Code:** Gerado automaticamente para eventos

### Tipos de Pagamento

| tipo_pagamento | Descrição |
|----------------|-----------|
| 1 | Cartão de Crédito |
| 2 | Boleto |
| 3 | PIX |
| **4** | **Cortesia (Gratuito)** |

---

## Tipos de Ingressos Cortesia

### Criar Tipo de Ingresso Cortesia

Cria um novo tipo de ingresso gratuito para eventos.

**Endpoint:** `POST /apiv3/user/anuncios/addTypeIng`

**Headers:**
```
Content-Type: application/json
```

**Payload:**
```json
{
  "token": "Qd721n2E",
  "id_anuncio": 13,
  "tipo": 1,
  "nome": "Ingresso VIP Cortesia",
  "valor": 0,
  "qtd": 50,
  "cortesia": 1
}
```

| Campo | Tipo | Obrigatório | Descrição |
|-------|------|-------------|-----------|
| token | string | Sim | Token de autenticação do app |
| id_anuncio | int | Sim | ID do anúncio/evento |
| tipo | int | Sim | Tipo do ingresso (1=inteira, 2=meia, etc) |
| nome | string | Sim | Nome do tipo de ingresso |
| valor | decimal | Sim | Valor (use 0 para cortesia) |
| qtd | int | Sim | Quantidade disponível |
| **cortesia** | int | Não | 1 = gratuito, 0 = pago (default: 0) |

**Retorno Sucesso:**
```json
[
  {
    "status": "01",
    "id": 25,
    "msg": "Tipo adicionado com sucesso."
  }
]
```

**Retorno Erro:**
```json
[
  {
    "status": "02",
    "msg": "Erro ao adicionar tipo."
  }
]
```

---

### Atualizar Tipo de Ingresso para Cortesia

**Endpoint:** `POST /apiv3/user/anuncios/updateTypeIng`

**Payload:**
```json
{
  "token": "Qd721n2E",
  "id": 25,
  "tipo": 1,
  "nome": "Ingresso VIP Cortesia Atualizado",
  "valor": 0,
  "qtd": 100,
  "cortesia": 1
}
```

| Campo | Tipo | Obrigatório | Descrição |
|-------|------|-------------|-----------|
| token | string | Sim | Token de autenticação do app |
| id | int | Sim | ID do tipo de ingresso |
| tipo | int | Sim | Tipo do ingresso |
| nome | string | Sim | Nome do tipo de ingresso |
| valor | decimal | Sim | Valor |
| qtd | int | Sim | Quantidade disponível |
| **cortesia** | int | Não | 1 = gratuito, 0 = pago |

**Retorno Sucesso:**
```json
[
  {
    "status": "01",
    "msg": "Tipo atualizado com sucesso."
  }
]
```

---

## Períodos de Hospedagem Cortesia

### Criar Período de Hospedagem Cortesia

Cria um período de hospedagem gratuita.

**Endpoint:** `POST /apiv3/user/anuncios/adicionar_periodos`

**Payload:**
```json
{
  "token": "Qd721n2E",
  "id_type": 5,
  "nome": "Estadia Cortesia Dezembro",
  "data_de": "2025-12-20",
  "data_ate": "2025-12-25",
  "valor": 0,
  "taxa_limpeza": 0,
  "qtd": 1,
  "cortesia": 1
}
```

| Campo | Tipo | Obrigatório | Descrição |
|-------|------|-------------|-----------|
| token | string | Sim | Token de autenticação do app |
| id_type | int | Sim | ID do tipo de anúncio |
| nome | string | Sim | Nome do período |
| data_de | date | Sim | Data início (YYYY-MM-DD) |
| data_ate | date | Sim | Data fim (YYYY-MM-DD) |
| valor | decimal | Sim | Valor da diária (use 0 para cortesia) |
| taxa_limpeza | decimal | Não | Taxa de limpeza |
| qtd | int | Sim | Quantidade de unidades |
| **cortesia** | int | Não | 1 = gratuito, 0 = pago (default: 0) |

**Retorno Sucesso:**
```json
[
  {
    "status": "01",
    "id": 18,
    "msg": "Período adicionado com sucesso."
  }
]
```

---

### Atualizar Período para Cortesia

**Endpoint:** `POST /apiv3/user/anuncios/update_periodos`

**Payload:**
```json
{
  "token": "Qd721n2E",
  "id": 18,
  "nome": "Estadia Cortesia Atualizada",
  "data_de": "2025-12-20",
  "data_ate": "2025-12-27",
  "valor": 0,
  "taxa_limpeza": 0,
  "qtd": 2,
  "cortesia": 1
}
```

**Retorno Sucesso:**
```json
[
  {
    "status": "01",
    "msg": "Período atualizado com sucesso."
  }
]
```

---

### Adicionar Tipo com Períodos (Bulk)

Cria um tipo de anúncio com múltiplos períodos, incluindo cortesia.

**Endpoint:** `POST /apiv3/user/anuncios/adicionarType`

**Payload:**
```json
{
  "token": "Qd721n2E",
  "id_anuncio": 1,
  "nome": "Suíte Master",
  "hospedes": 4,
  "qtd_quartos": 2,
  "qtd_camas": 2,
  "qtd_banheiros": 1,
  "periodos": [
    {
      "nome": "Alta Temporada",
      "data_de": "2025-12-20",
      "data_ate": "2025-12-31",
      "valor": 500.00,
      "taxa_limpeza": 100.00,
      "qtd": 5,
      "cortesia": 0
    },
    {
      "nome": "Período Cortesia",
      "data_de": "2026-01-10",
      "data_ate": "2026-01-15",
      "valor": 0,
      "taxa_limpeza": 0,
      "qtd": 2,
      "cortesia": 1
    }
  ]
}
```

---

## Reservas Cortesia

### Iniciar Reserva Cortesia

Cria uma reserva gratuita (sem processamento de pagamento).

**Endpoint:** `POST /apiv3/user/reservas/iniciar`

**Payload:**
```json
{
  "token": "Qd721n2E",
  "id_user": 334,
  "id_anuncio": 13,
  "id_anuncio_type": 5,
  "id_carrinho": 12,
  "id_categoria": 3,
  "adultos": 2,
  "criancas": 0,
  "data_de": "20/12/2025",
  "data_ate": "25/12/2025",
  "valor": 0,
  "obs": "Reserva cortesia para evento especial",
  "tipo_pagamento": 4,
  "cortesia": 1
}
```

| Campo | Tipo | Obrigatório | Descrição |
|-------|------|-------------|-----------|
| token | string | Sim | Token de autenticação do app |
| id_user | int | Sim | ID do usuário |
| id_anuncio | int | Sim | ID do anúncio |
| id_anuncio_type | int | Sim | ID do tipo de anúncio |
| id_carrinho | int | Sim | ID do carrinho |
| id_categoria | int | Sim | 1=Hospedagem, 2=Experiência, 3=Evento |
| adultos | int | Sim | Número de adultos |
| criancas | int | Não | Número de crianças |
| data_de | string | Sim | Data início (DD/MM/YYYY) |
| data_ate | string | Sim | Data fim (DD/MM/YYYY) |
| valor | decimal | Sim | Valor total (use 0 para cortesia) |
| obs | string | Não | Observações |
| **tipo_pagamento** | int | Sim | Use **4** para cortesia |
| **cortesia** | int | Não | 1 = reserva gratuita |

> **Nota:** A reserva será tratada como cortesia se qualquer uma dessas condições for verdadeira:
> - `tipo_pagamento = 4`
> - `valor = 0`
> - `cortesia = 1`

**Retorno Sucesso:**
```json
[
  {
    "status": "01",
    "tipo_pagamento": "4",
    "id_pagamento": 89,
    "id_reserva": 156,
    "payment_id": "CORTESIA_A7B3C9D2E5F1G8H4",
    "status": "CONFIRMED",
    "cortesia": true,
    "msg": "Reserva cortesia confirmada!"
  }
]
```

| Campo | Descrição |
|-------|-----------|
| status | "01" = sucesso |
| tipo_pagamento | "4" = cortesia |
| id_pagamento | ID do registro de pagamento (valor zero) |
| id_reserva | ID da reserva criada |
| payment_id | Token único da transação (prefixo CORTESIA_) |
| status | "CONFIRMED" = confirmado automaticamente |
| cortesia | true = é uma reserva gratuita |
| msg | Mensagem de confirmação |

---

### Reserva Cortesia para Eventos (com QR Code)

Para eventos (id_categoria = 3), os QR codes dos ingressos são gerados automaticamente.

**Payload:**
```json
{
  "token": "Qd721n2E",
  "id_user": 334,
  "id_anuncio": 13,
  "id_anuncio_type": 5,
  "id_carrinho": 15,
  "id_categoria": 3,
  "adultos": 4,
  "criancas": 0,
  "data_de": "20/12/2025",
  "data_ate": "20/12/2025",
  "valor": 0,
  "obs": "4 ingressos cortesia para o evento",
  "tipo_pagamento": 4,
  "cortesia": 1
}
```

**Retorno:**
```json
[
  {
    "status": "01",
    "tipo_pagamento": "4",
    "id_pagamento": 90,
    "id_reserva": 157,
    "payment_id": "CORTESIA_X9Y2Z5W8V1U4T7S3",
    "status": "CONFIRMED",
    "cortesia": true,
    "msg": "Reserva cortesia confirmada!"
  }
]
```

> Os QR codes dos ingressos podem ser consultados via endpoint de carrinho/ingressos.

---

## Listagem com Campo Cortesia

### Listar Tipos de Ingressos

**Endpoint:** `POST /apiv3/user/anuncios/listtiposIng`

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
    "id": 24,
    "tipo": "1",
    "nome": "Ingresso Pista",
    "valor": "150.00",
    "qtd": "100",
    "cortesia": false
  },
  {
    "id": 25,
    "tipo": "1",
    "nome": "Ingresso VIP Cortesia",
    "valor": "0.00",
    "qtd": "50",
    "cortesia": true
  }
]
```

---

### Listar Períodos/Valores

**Endpoint:** `POST /apiv3/user/anuncios/listtiposValor`

**Payload:**
```json
{
  "token": "Qd721n2E",
  "id_anuncio": 1,
  "data_de": "2025-12-01",
  "data_ate": "2025-12-31"
}
```

**Retorno:**
```json
[
  {
    "id": 17,
    "nome": "Alta Temporada",
    "data_de": "20/12/2025",
    "data_ate": "31/12/2025",
    "valor": "500.00",
    "taxa_limpeza": "100.00",
    "qtd": "5",
    "cortesia": false
  },
  {
    "id": 18,
    "nome": "Período Cortesia",
    "data_de": "10/01/2026",
    "data_ate": "15/01/2026",
    "valor": "0.00",
    "taxa_limpeza": "0.00",
    "qtd": "2",
    "cortesia": true
  }
]
```

---

### Listar Períodos por ID

**Endpoint:** `POST /apiv3/user/anuncios/listperiodosID`

**Payload:**
```json
{
  "token": "Qd721n2E",
  "id_type": 5
}
```

**Retorno:**
```json
[
  {
    "id": 17,
    "nome": "Alta Temporada",
    "data_de": "20/12/2025",
    "data_ate": "31/12/2025",
    "valor": "500.00",
    "desc_min_diarias": "3",
    "taxa_limpeza": "100.00",
    "qtd": "5",
    "cortesia": false
  },
  {
    "id": 18,
    "nome": "Período Cortesia",
    "data_de": "10/01/2026",
    "data_ate": "15/01/2026",
    "valor": "0.00",
    "desc_min_diarias": "0",
    "taxa_limpeza": "0.00",
    "qtd": "2",
    "cortesia": true
  }
]
```

---

## Notificações

Quando uma reserva cortesia é criada, o anfitrião recebe uma notificação:

| Tipo | Título | Descrição |
|------|--------|-----------|
| `reserva-cortesia-anfitriao` | Nova Reserva Cortesia | Você recebeu uma nova reserva cortesia (gratuita) no anúncio: {nome_anuncio} |

---

## Códigos de Status

| Código | Descrição |
|--------|-----------|
| 01 | Sucesso |
| 02 | Erro |

---

## Exemplos de Uso

### cURL - Criar Ingresso Cortesia

```bash
curl -X POST "https://seudominio.com/apiv3/user/anuncios/addTypeIng" \
  -H "Content-Type: application/json" \
  -d '{
    "token": "Qd721n2E",
    "id_anuncio": 13,
    "tipo": 1,
    "nome": "Ingresso Cortesia",
    "valor": 0,
    "qtd": 20,
    "cortesia": 1
  }'
```

### cURL - Reserva Cortesia

```bash
curl -X POST "https://seudominio.com/apiv3/user/reservas/iniciar" \
  -H "Content-Type: application/json" \
  -d '{
    "token": "Qd721n2E",
    "id_user": 334,
    "id_anuncio": 13,
    "id_anuncio_type": 5,
    "id_carrinho": 12,
    "id_categoria": 3,
    "adultos": 2,
    "criancas": 0,
    "data_de": "20/12/2025",
    "data_ate": "20/12/2025",
    "valor": 0,
    "obs": "",
    "tipo_pagamento": 4,
    "cortesia": 1
  }'
```

---

## Alterações no Banco de Dados

```sql
-- Coluna cortesia na tabela de tipos de ingressos
ALTER TABLE app_anuncios_ing_types ADD COLUMN cortesia TINYINT(1) DEFAULT 0;

-- Coluna cortesia na tabela de valores/períodos
ALTER TABLE app_anuncios_valor ADD COLUMN cortesia TINYINT(1) DEFAULT 0;
```

---

## Changelog

| Data | Versão | Descrição |
|------|--------|-----------|
| 10/12/2025 | 1.0.0 | Implementação inicial da funcionalidade de cortesia |

---

*Documentação gerada em 10 de dezembro de 2025*
