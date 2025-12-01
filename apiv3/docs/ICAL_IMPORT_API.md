# API de Importação de iCal Externo - GO77 Destinos

## Visão Geral

Esta API permite importar calendários de plataformas externas (Airbnb, Booking, etc) para sincronizar automaticamente os períodos ocupados com o sistema GO77.

### Características Principais

- ✅ **Suporte por Unidade**: Cada unidade física de um quarto pode ter seu próprio link iCal
- ✅ **Múltiplos Links por Unidade**: Uma unidade pode ter links de várias plataformas (Airbnb + Booking)
- ✅ **Sincronização Automática**: Cron de 6 em 6 horas
- ✅ **Sincronização Manual**: Endpoint para forçar atualização imediata
- ✅ **Gestão de Erros**: Links com 5+ erros são desativados automaticamente

---

## Estrutura Hierárquica

```
Anúncio (Pousada Vila 4 Ventos)
├── Tipo de Quarto (Suíte Standard)
│   ├── Unidade 1 (Suíte 101) → Link Airbnb + Link Booking
│   ├── Unidade 2 (Suíte 102) → Link Airbnb
│   ├── Unidade 3 (Suíte 103) → Link Booking
│   └── Unidade 4 (Suíte 104) → (sem links)
└── Tipo de Quarto (Suíte Master)
    ├── Unidade 1 (Suíte 201) → Link Airbnb
    └── Unidade 2 (Suíte 202) → Link Airbnb + Link Booking
```

---

## Autenticação

Todos os endpoints requerem:
- `id_user`: ID do usuário logado
- `token`: Token de autenticação da API (`Qd721n2E`)

---

## Ciclo de Vida das Unidades

### Como as Unidades São Criadas?

As unidades são **criadas automaticamente** pelo sistema quando você acessa os endpoints `listarUnidadesParaIcal` ou `listarUnidadesTipo`. A quantidade de unidades é baseada no campo `qtd` da tabela `app_anuncios_valor` (quantidade de quartos disponíveis daquele tipo).

### Nomenclatura Padrão

| Número | Nome Padrão |
|--------|-------------|
| 1 | "Unidade 1" |
| 2 | "Unidade 2" |
| 3 | "Unidade 3" |
| ... | ... |

### Personalizando os Nomes

Use o endpoint `atualizarNomeUnidade` para dar nomes significativos:

```
Antes (nome padrão)          →  Depois (personalizado)
─────────────────────────────────────────────────────
Unidade 1                    →  Suíte 101 - Vista Jardim
Unidade 2                    →  Suíte 102 - Vista Piscina
Unidade 3                    →  Suíte 103 - Vista Mar
```

### Exemplo de Fluxo

```json
// 1. Listar unidades (nomes padrão)
{
  "unidades": [
    { "id": 1, "numero": 1, "nome": "Unidade 1" },
    { "id": 2, "numero": 2, "nome": "Unidade 2" }
  ]
}

// 2. Renomear unidade 1
POST /atualizarNomeUnidade/
{ "id_unidade": 1, "nome": "Suíte 101 - Vista Jardim" }

// 3. Adicionar iCal (agora com nome legível)
POST /adicionarIcalExterno/
{ "id_unidade": 1, "nome": "Airbnb - Suíte 101" }
```

---

## Endpoints

### 1. Listar Tipos e Unidades para iCal

Lista todos os tipos de quarto e suas unidades disponíveis para configurar importação de iCal.

**Use este endpoint ANTES de adicionar um link iCal.**

```
POST /apiv3/user/anuncios/listarUnidadesParaIcal/
Content-Type: application/json
```

#### Payload

```json
{
  "id_user": "316",
  "id_anuncio": "65",
  "token": "Qd721n2E"
}
```

| Campo | Tipo | Obrigatório | Descrição |
|-------|------|-------------|-----------|
| `id_user` | string | Sim | ID do usuário logado |
| `id_anuncio` | string | Sim | ID do anúncio |
| `token` | string | Sim | Token de autenticação |

#### Response - Anúncio COM Quartos

```json
{
  "status": "01",
  "tem_quartos": true,
  "total_types": 2,
  "msg": "Selecione o tipo de quarto e a unidade específica para vincular o iCal.",
  "anuncio": {
    "id": 65,
    "nome": "Pousada Vila 4 Ventos"
  },
  "types": [
    {
      "id": 43,
      "nome_type": "Suíte Standard",
      "descricao": "Suíte com cama casal e vista para o jardim",
      "qtd_unidades": 4,
      "unidades": [
        {
          "id": 1,
          "app_anuncios_types_id": 43,
          "numero": 1,
          "nome": "Suíte 101",
          "status": 1,
          "created_at": "2025-11-30 18:08:24",
          "links_ical": 2
        },
        {
          "id": 2,
          "app_anuncios_types_id": 43,
          "numero": 2,
          "nome": "Suíte 102",
          "status": 1,
          "created_at": "2025-11-30 18:08:24",
          "links_ical": 1
        },
        {
          "id": 3,
          "app_anuncios_types_id": 43,
          "numero": 3,
          "nome": "Suíte 103",
          "status": 1,
          "created_at": "2025-11-30 18:08:24",
          "links_ical": 0
        },
        {
          "id": 4,
          "app_anuncios_types_id": 43,
          "numero": 4,
          "nome": "Suíte 104",
          "status": 1,
          "created_at": "2025-11-30 18:08:24",
          "links_ical": 0
        }
      ]
    },
    {
      "id": 44,
      "nome_type": "Suíte Master",
      "descricao": "Suíte luxo com hidromassagem",
      "qtd_unidades": 2,
      "unidades": [
        {
          "id": 5,
          "app_anuncios_types_id": 44,
          "numero": 1,
          "nome": "Suíte 201",
          "status": 1,
          "created_at": "2025-11-30 18:08:24",
          "links_ical": 1
        },
        {
          "id": 6,
          "app_anuncios_types_id": 44,
          "numero": 2,
          "nome": "Suíte 202",
          "status": 1,
          "created_at": "2025-11-30 18:08:24",
          "links_ical": 0
        }
      ]
    }
  ]
}
```

#### Response - Anúncio SEM Quartos

```json
{
  "status": "01",
  "tem_quartos": false,
  "msg": "Este anúncio não possui quartos. O iCal será vinculado ao anúncio inteiro.",
  "anuncio": {
    "id": 104,
    "nome": "Casa na Praia"
  },
  "types": []
}
```

#### Response - Erro (anúncio não pertence ao usuário)

```json
{
  "status": "00",
  "msg": "Anúncio não encontrado ou não pertence ao usuário"
}
```

---

### 2. Listar Unidades de um Tipo Específico

Lista apenas as unidades de um tipo de quarto específico.

```
POST /apiv3/user/anuncios/listarUnidadesTipo/
Content-Type: application/json
```

#### Payload

```json
{
  "id_user": "316",
  "id_anuncio": "65",
  "id_type": 43,
  "token": "Qd721n2E"
}
```

| Campo | Tipo | Obrigatório | Descrição |
|-------|------|-------------|-----------|
| `id_user` | string | Sim | ID do usuário logado |
| `id_anuncio` | string | Sim | ID do anúncio |
| `id_type` | int | Sim | ID do tipo de quarto |
| `token` | string | Sim | Token de autenticação |

#### Response - Sucesso

```json
{
  "status": "01",
  "id_type": 43,
  "total": 4,
  "unidades": [
    {
      "id": 1,
      "app_anuncios_types_id": 43,
      "numero": 1,
      "nome": "Suíte 101",
      "status": 1,
      "created_at": "2025-11-30 18:08:24",
      "links_ical": 2
    },
    {
      "id": 2,
      "app_anuncios_types_id": 43,
      "numero": 2,
      "nome": "Suíte 102",
      "status": 1,
      "created_at": "2025-11-30 18:08:24",
      "links_ical": 1
    },
    {
      "id": 3,
      "app_anuncios_types_id": 43,
      "numero": 3,
      "nome": "Suíte 103",
      "status": 1,
      "created_at": "2025-11-30 18:08:24",
      "links_ical": 1
    },
    {
      "id": 4,
      "app_anuncios_types_id": 43,
      "numero": 4,
      "nome": "Suíte 104",
      "status": 1,
      "created_at": "2025-11-30 18:08:24",
      "links_ical": 1
    }
  ]
}
```

#### Response - Erro (tipo não encontrado)

```json
{
  "status": "00",
  "msg": "Tipo não encontrado ou não pertence a este anúncio"
}
```

#### Response - Erro (id_type não informado)

```json
{
  "status": "00",
  "msg": "ID do tipo é obrigatório"
}
```

---

### 3. Atualizar Nome de uma Unidade

Permite personalizar o nome de uma unidade.

**Por padrão, as unidades são criadas automaticamente com nomes genéricos** ("Unidade 1", "Unidade 2", etc). Use este endpoint para dar nomes mais significativos como:
- "Suíte 101 - Vista Jardim"
- "Quarto Azul"
- "Chalé da Montanha"

> 💡 **Dica**: Renomear as unidades facilita a identificação ao vincular calendários iCal de cada plataforma.

```
POST /apiv3/user/anuncios/atualizarNomeUnidade/
Content-Type: application/json
```

#### Payload

```json
{
  "id_user": "316",
  "id_anuncio": "65",
  "id_type": 43,
  "id_unidade": 1,
  "nome": "Suíte 101 - Vista Jardim",
  "token": "Qd721n2E"
}
```

| Campo | Tipo | Obrigatório | Descrição |
|-------|------|-------------|-----------|
| `id_user` | string | Sim | ID do usuário logado |
| `id_anuncio` | string | Sim | ID do anúncio |
| `id_type` | int | Sim | ID do tipo de quarto |
| `id_unidade` | int | Sim | ID da unidade |
| `nome` | string | Sim | Novo nome da unidade |
| `token` | string | Sim | Token de autenticação |

#### Response - Sucesso

```json
{
  "status": "01",
  "msg": "Nome da unidade atualizado com sucesso"
}
```

#### Response - Erro (unidade não encontrada)

```json
{
  "status": "00",
  "msg": "Unidade não encontrada ou não pertence a este tipo"
}
```

#### Response - Erro (nome vazio)

```json
{
  "status": "00",
  "msg": "Nome da unidade é obrigatório"
}
```

---

### 4. Adicionar Link iCal Externo

Adiciona um link de calendário iCal de uma plataforma externa (Airbnb, Booking, etc).

```
POST /apiv3/user/anuncios/adicionarIcalExterno/
Content-Type: application/json
```

#### Payload - Anúncio SEM Quartos

```json
{
  "id_user": "334",
  "id_anuncio": "104",
  "nome": "Airbnb",
  "url": "https://www.airbnb.com.br/calendar/ical/12345678.ics?s=abc123",
  "token": "Qd721n2E"
}
```

#### Payload - Anúncio COM Quartos (Múltiplas Unidades)

```json
{
  "id_user": "316",
  "id_anuncio": "65",
  "id_type": 43,
  "id_unidade": 1,
  "nome": "Airbnb - Suíte 101",
  "url": "https://www.airbnb.com.br/calendar/ical/99999999.ics?s=xyz789",
  "token": "Qd721n2E"
}
```

| Campo | Tipo | Obrigatório | Descrição |
|-------|------|-------------|-----------|
| `id_user` | string | Sim | ID do usuário (dono do anúncio) |
| `id_anuncio` | string | Sim | ID do anúncio |
| `id_type` | int | **Condicional** | ID do tipo. **Obrigatório se o anúncio tiver quartos.** |
| `id_unidade` | int | **Condicional** | ID da unidade. **Obrigatório se o tipo tiver mais de 1 unidade.** |
| `nome` | string | Sim | Nome identificador (ex: "Airbnb", "Booking") |
| `url` | string | Sim | URL completa do calendário iCal |
| `token` | string | Sim | Token de autenticação |

#### Regras de Negócio

| Cenário | `id_type` | `id_unidade` |
|---------|-----------|--------------|
| Anúncio **sem quartos** | Opcional (ignora) | Opcional (ignora) |
| Anúncio **com quartos** | **Obrigatório** | Depende da qtd de unidades |
| Tipo com **1 unidade** | Obrigatório | Auto-preenchido |
| Tipo com **múltiplas unidades** | Obrigatório | **Obrigatório** |

#### Response - Sucesso

```json
{
  "status": "01",
  "id": 4,
  "id_type": 43,
  "id_unidade": 1,
  "msg": "Link iCal adicionado com sucesso para a unidade."
}
```

#### Response - Erro (anúncio com quartos, sem id_type)

```json
{
  "status": "00",
  "msg": "Este anúncio possui quartos. Informe o id_type do quarto."
}
```

#### Response - Erro (tipo com múltiplas unidades, sem id_unidade)

```json
{
  "status": "00",
  "msg": "Este tipo possui 4 unidades. Informe o id_unidade.",
  "unidades_disponiveis": [
    {
      "id": 1,
      "app_anuncios_types_id": 43,
      "numero": 1,
      "nome": "Suíte 101",
      "status": 1,
      "created_at": "2025-11-30 18:08:24",
      "links_ical": 2
    },
    {
      "id": 2,
      "app_anuncios_types_id": 43,
      "numero": 2,
      "nome": "Suíte 102",
      "status": 1,
      "created_at": "2025-11-30 18:08:24",
      "links_ical": 1
    },
    {
      "id": 3,
      "app_anuncios_types_id": 43,
      "numero": 3,
      "nome": "Suíte 103",
      "status": 1,
      "created_at": "2025-11-30 18:08:24",
      "links_ical": 0
    },
    {
      "id": 4,
      "app_anuncios_types_id": 43,
      "numero": 4,
      "nome": "Suíte 104",
      "status": 1,
      "created_at": "2025-11-30 18:08:24",
      "links_ical": 0
    }
  ]
}
```

#### Response - Erro (tipo não pertence ao anúncio)

```json
{
  "status": "00",
  "msg": "Quarto não encontrado ou não pertence a este anúncio"
}
```

#### Response - Erro (unidade não pertence ao tipo)

```json
{
  "status": "00",
  "msg": "Unidade não encontrada ou não pertence a este tipo"
}
```

#### Response - Erro (URL inválida)

```json
{
  "status": "00",
  "msg": "URL inválida"
}
```

#### Response - Erro (nome vazio)

```json
{
  "status": "00",
  "msg": "Nome da plataforma é obrigatório"
}
```

---

### 5. Listar Links iCal Externos

Lista todos os links iCal externos cadastrados, com opção de filtro por tipo ou unidade.

```
POST /apiv3/user/anuncios/listarIcalExterno/
Content-Type: application/json
```

#### Payload - Todos os Links do Anúncio

```json
{
  "id_user": "316",
  "id_anuncio": "65",
  "token": "Qd721n2E"
}
```

#### Payload - Filtrar por Tipo

```json
{
  "id_user": "316",
  "id_anuncio": "65",
  "id_type": 43,
  "token": "Qd721n2E"
}
```

#### Payload - Filtrar por Unidade

```json
{
  "id_user": "316",
  "id_anuncio": "65",
  "id_type": 43,
  "id_unidade": 1,
  "token": "Qd721n2E"
}
```

| Campo | Tipo | Obrigatório | Descrição |
|-------|------|-------------|-----------|
| `id_user` | string | Sim | ID do usuário logado |
| `id_anuncio` | string | Sim | ID do anúncio |
| `id_type` | int | Não | Filtrar por tipo de quarto |
| `id_unidade` | int | Não | Filtrar por unidade específica |
| `token` | string | Sim | Token de autenticação |

#### Response - Sucesso (todos os links)

```json
{
  "status": "01",
  "total": 7,
  "id_type": null,
  "id_unidade": null,
  "links": [
    {
      "id": 4,
      "app_anuncios_id": 65,
      "app_anuncios_types_id": 43,
      "app_anuncios_types_unidades_id": 1,
      "nome": "Airbnb - Suíte 101",
      "url": "https://www.airbnb.com.br/calendar/ical/suite101.ics",
      "ultima_sincronizacao": "2025-11-30 12:00:00",
      "status": 1,
      "erros": 0,
      "ultimo_erro": null,
      "data_cadastro": "2025-11-30 10:00:00",
      "nome_type": "Suíte Standard",
      "numero_unidade": 1,
      "nome_unidade": "Suíte 101"
    },
    {
      "id": 5,
      "app_anuncios_id": 65,
      "app_anuncios_types_id": 43,
      "app_anuncios_types_unidades_id": 1,
      "nome": "Booking - Suíte 101",
      "url": "https://admin.booking.com/calendar/suite101.ics",
      "ultima_sincronizacao": "2025-11-30 12:00:00",
      "status": 1,
      "erros": 0,
      "ultimo_erro": null,
      "data_cadastro": "2025-11-30 10:30:00",
      "nome_type": "Suíte Standard",
      "numero_unidade": 1,
      "nome_unidade": "Suíte 101"
    },
    {
      "id": 6,
      "app_anuncios_id": 65,
      "app_anuncios_types_id": 43,
      "app_anuncios_types_unidades_id": 2,
      "nome": "Airbnb - Suíte 102",
      "url": "https://www.airbnb.com.br/calendar/ical/suite102.ics",
      "ultima_sincronizacao": "2025-11-30 12:00:00",
      "status": 1,
      "erros": 0,
      "ultimo_erro": null,
      "data_cadastro": "2025-11-30 11:00:00",
      "nome_type": "Suíte Standard",
      "numero_unidade": 2,
      "nome_unidade": "Suíte 102"
    }
  ]
}
```

#### Response - Sucesso (filtrado por unidade)

```json
{
  "status": "01",
  "total": 2,
  "id_type": 43,
  "id_unidade": 1,
  "links": [
    {
      "id": 4,
      "app_anuncios_id": 65,
      "app_anuncios_types_id": 43,
      "app_anuncios_types_unidades_id": 1,
      "nome": "Airbnb - Suíte 101",
      "url": "https://www.airbnb.com.br/calendar/ical/suite101.ics",
      "ultima_sincronizacao": "2025-11-30 12:00:00",
      "status": 1,
      "erros": 0,
      "ultimo_erro": null,
      "data_cadastro": "2025-11-30 10:00:00",
      "nome_type": "Suíte Standard",
      "numero_unidade": 1,
      "nome_unidade": "Suíte 101"
    },
    {
      "id": 5,
      "app_anuncios_id": 65,
      "app_anuncios_types_id": 43,
      "app_anuncios_types_unidades_id": 1,
      "nome": "Booking - Suíte 101",
      "url": "https://admin.booking.com/calendar/suite101.ics",
      "ultima_sincronizacao": "2025-11-30 12:00:00",
      "status": 1,
      "erros": 0,
      "ultimo_erro": null,
      "data_cadastro": "2025-11-30 10:30:00",
      "nome_type": "Suíte Standard",
      "numero_unidade": 1,
      "nome_unidade": "Suíte 101"
    }
  ]
}
```

#### Response - Erro

```json
{
  "status": "00",
  "msg": "Anúncio não encontrado ou não pertence ao usuário"
}
```

---

### 6. Remover Link iCal Externo

Remove um link iCal externo cadastrado.

```
POST /apiv3/user/anuncios/removerIcalExterno/
Content-Type: application/json
```

#### Payload

```json
{
  "id_user": "316",
  "id_anuncio": "65",
  "id_link": 4,
  "token": "Qd721n2E"
}
```

| Campo | Tipo | Obrigatório | Descrição |
|-------|------|-------------|-----------|
| `id_user` | string | Sim | ID do usuário logado |
| `id_anuncio` | string | Sim | ID do anúncio |
| `id_link` | int | Sim | ID do link iCal a remover |
| `token` | string | Sim | Token de autenticação |

#### Response - Sucesso

```json
{
  "status": "01",
  "msg": "Link iCal removido com sucesso."
}
```

#### Response - Erro (link não encontrado)

```json
{
  "status": "00",
  "msg": "Link não encontrado ou não pertence a este anúncio"
}
```

---

### 7. Listar Bloqueios Importados

Lista os bloqueios de datas importados via iCal externo.

```
POST /apiv3/user/anuncios/listarBloqueiosIcal/
Content-Type: application/json
```

#### Payload - Todos os Bloqueios

```json
{
  "id_user": "316",
  "id_anuncio": "65",
  "token": "Qd721n2E"
}
```

#### Payload - Filtrar por Tipo

```json
{
  "id_user": "316",
  "id_anuncio": "65",
  "id_type": 43,
  "token": "Qd721n2E"
}
```

| Campo | Tipo | Obrigatório | Descrição |
|-------|------|-------------|-----------|
| `id_user` | string | Sim | ID do usuário logado |
| `id_anuncio` | string | Sim | ID do anúncio |
| `id_type` | int | Não | Filtrar por tipo de quarto |
| `token` | string | Sim | Token de autenticação |

#### Response - Sucesso

```json
{
  "status": "01",
  "id_type": 43,
  "total": 5,
  "bloqueios": [
    {
      "id": 1,
      "app_anuncios_id": 65,
      "app_anuncios_types_id": 43,
      "app_anuncios_types_unidades_id": 1,
      "app_ical_links_id": 4,
      "uid": "airbnb-reservation-12345@airbnb.com",
      "data_inicio": "2025-12-20",
      "data_fim": "2025-12-26",
      "resumo": "Reserva - João Silva",
      "plataforma": "Airbnb - Suíte 101",
      "id_type": 43,
      "nome_type": "Suíte Standard",
      "numero_unidade": 1,
      "nome_unidade": "Suíte 101"
    },
    {
      "id": 2,
      "app_anuncios_id": 65,
      "app_anuncios_types_id": 43,
      "app_anuncios_types_unidades_id": 1,
      "app_ical_links_id": 5,
      "uid": "booking-12345678",
      "data_inicio": "2025-12-28",
      "data_fim": "2026-01-02",
      "resumo": "Blocked",
      "plataforma": "Booking - Suíte 101",
      "id_type": 43,
      "nome_type": "Suíte Standard",
      "numero_unidade": 1,
      "nome_unidade": "Suíte 101"
    },
    {
      "id": 3,
      "app_anuncios_id": 65,
      "app_anuncios_types_id": 43,
      "app_anuncios_types_unidades_id": 2,
      "app_ical_links_id": 6,
      "uid": "airbnb-reservation-67890@airbnb.com",
      "data_inicio": "2025-12-15",
      "data_fim": "2025-12-18",
      "resumo": "Reserva - Maria Santos",
      "plataforma": "Airbnb - Suíte 102",
      "id_type": 43,
      "nome_type": "Suíte Standard",
      "numero_unidade": 2,
      "nome_unidade": "Suíte 102"
    }
  ]
}
```

#### Response - Nenhum Bloqueio

```json
{
  "status": "01",
  "id_type": null,
  "total": 0,
  "bloqueios": []
}
```

---

### 8. Sincronizar Manualmente

Força sincronização imediata dos links iCal externos, sem aguardar o cron.

```
POST /apiv3/user/anuncios/sincronizarIcalExterno/
Content-Type: application/json
```

#### Payload - Sincronizar Todos

```json
{
  "id_user": "316",
  "id_anuncio": "65",
  "token": "Qd721n2E"
}
```

#### Payload - Sincronizar por Tipo

```json
{
  "id_user": "316",
  "id_anuncio": "65",
  "id_type": 43,
  "token": "Qd721n2E"
}
```

#### Payload - Sincronizar Link Específico

```json
{
  "id_user": "316",
  "id_anuncio": "65",
  "id_link": 4,
  "token": "Qd721n2E"
}
```

| Campo | Tipo | Obrigatório | Descrição |
|-------|------|-------------|-----------|
| `id_user` | string | Sim | ID do usuário logado |
| `id_anuncio` | string | Sim | ID do anúncio |
| `id_type` | int | Não | Sincronizar apenas links deste tipo |
| `id_link` | int | Não | Sincronizar apenas este link específico |
| `token` | string | Sim | Token de autenticação |

#### Response - Sucesso

```json
{
  "status": "01",
  "msg": "Sincronização concluída",
  "id_type": 43,
  "resultados": [
    {
      "id_link": 4,
      "nome": "Airbnb - Suíte 101",
      "sucesso": true,
      "eventos_importados": 3,
      "erro": null
    },
    {
      "id_link": 5,
      "nome": "Booking - Suíte 101",
      "sucesso": true,
      "eventos_importados": 2,
      "erro": null
    },
    {
      "id_link": 6,
      "nome": "Airbnb - Suíte 102",
      "sucesso": false,
      "eventos_importados": 0,
      "erro": "Timeout ao baixar calendário"
    }
  ]
}
```

#### Response - Nenhum Link Cadastrado

```json
{
  "status": "00",
  "msg": "Nenhum link iCal cadastrado para este anúncio/tipo"
}
```

---

## Onde Obter URLs iCal

### Airbnb
1. Acesse o calendário do seu anúncio no Airbnb
2. Clique em **Disponibilidade** → **Sincronizar calendários**
3. Copie o **"Link para exportar calendário"**

### Booking.com
1. Acesse a extranet do Booking.com
2. Vá em **Calendário** → **Sincronização**
3. Copie o link de exportação iCal

### VRBO/HomeAway
1. Acesse o painel do proprietário
2. Vá em **Calendário** → **Exportar**
3. Copie o link iCal

---

## Fluxo de Uso Recomendado

### Passo 1: Listar Unidades Disponíveis
```bash
curl -X POST http://localhost:8888/www/apiv3/user/anuncios/listarUnidadesParaIcal/ \
  -H "Content-Type: application/json" \
  -d '{"id_user": "316", "id_anuncio": "65", "token": "Qd721n2E"}'
```

### Passo 2: (Opcional) Renomear Unidades
```bash
curl -X POST http://localhost:8888/www/apiv3/user/anuncios/atualizarNomeUnidade/ \
  -H "Content-Type: application/json" \
  -d '{"id_user": "316", "id_anuncio": "65", "id_type": 43, "id_unidade": 1, "nome": "Suíte 101 - Vista Jardim", "token": "Qd721n2E"}'
```

### Passo 3: Adicionar Links iCal para Cada Unidade
```bash
# Unidade 1 - Airbnb
curl -X POST http://localhost:8888/www/apiv3/user/anuncios/adicionarIcalExterno/ \
  -H "Content-Type: application/json" \
  -d '{"id_user": "316", "id_anuncio": "65", "id_type": 43, "id_unidade": 1, "nome": "Airbnb", "url": "https://airbnb.com/calendar/ical/xxx.ics", "token": "Qd721n2E"}'

# Unidade 1 - Booking
curl -X POST http://localhost:8888/www/apiv3/user/anuncios/adicionarIcalExterno/ \
  -H "Content-Type: application/json" \
  -d '{"id_user": "316", "id_anuncio": "65", "id_type": 43, "id_unidade": 1, "nome": "Booking", "url": "https://booking.com/calendar/xxx.ics", "token": "Qd721n2E"}'

# Unidade 2 - Airbnb
curl -X POST http://localhost:8888/www/apiv3/user/anuncios/adicionarIcalExterno/ \
  -H "Content-Type: application/json" \
  -d '{"id_user": "316", "id_anuncio": "65", "id_type": 43, "id_unidade": 2, "nome": "Airbnb", "url": "https://airbnb.com/calendar/ical/yyy.ics", "token": "Qd721n2E"}'
```

### Passo 4: Verificar Links Cadastrados
```bash
curl -X POST http://localhost:8888/www/apiv3/user/anuncios/listarIcalExterno/ \
  -H "Content-Type: application/json" \
  -d '{"id_user": "316", "id_anuncio": "65", "token": "Qd721n2E"}'
```

### Passo 5: Forçar Sincronização (Opcional)
```bash
curl -X POST http://localhost:8888/www/apiv3/user/anuncios/sincronizarIcalExterno/ \
  -H "Content-Type: application/json" \
  -d '{"id_user": "316", "id_anuncio": "65", "token": "Qd721n2E"}'
```

### Passo 6: Verificar Bloqueios Importados
```bash
curl -X POST http://localhost:8888/www/apiv3/user/anuncios/listarBloqueiosIcal/ \
  -H "Content-Type: application/json" \
  -d '{"id_user": "316", "id_anuncio": "65", "token": "Qd721n2E"}'
```

---

## Sincronização Automática (Cron)

O sistema sincroniza automaticamente os calendários a cada 6 horas.

### Configurar no Crontab

```bash
# Editar crontab
crontab -e

# Adicionar linha (roda a cada 6 horas: 0h, 6h, 12h, 18h)
0 */6 * * * /usr/bin/php /caminho/para/www/apiv3/cron/sincronizar_ical.php >> /var/log/ical_sync.log 2>&1
```

### MAMP (macOS)

```bash
0 */6 * * * /Applications/MAMP/bin/php/php8.3.14/bin/php /Applications/MAMP/htdocs/www/apiv3/cron/sincronizar_ical.php >> /tmp/ical_sync.log 2>&1
```

---

## Tabelas do Banco de Dados

### app_anuncios_types_unidades

| Campo | Tipo | Descrição |
|-------|------|-----------|
| `id` | INT | ID único da unidade |
| `app_anuncios_types_id` | INT | ID do tipo de quarto |
| `numero` | INT | Número sequencial (1, 2, 3...) |
| `nome` | VARCHAR(100) | Nome personalizado |
| `status` | TINYINT | 1=ativo, 0=inativo |
| `created_at` | TIMESTAMP | Data de criação |

### app_ical_links

| Campo | Tipo | Descrição |
|-------|------|-----------|
| `id` | INT | ID único do link |
| `app_anuncios_id` | INT | ID do anúncio |
| `app_anuncios_types_id` | INT | ID do tipo (NULL se sem quartos) |
| `app_anuncios_types_unidades_id` | INT | ID da unidade (NULL se tipo único) |
| `nome` | VARCHAR(100) | Nome da plataforma |
| `url` | TEXT | URL do calendário iCal |
| `ultima_sincronizacao` | DATETIME | Data/hora da última sync |
| `status` | TINYINT | 1=ativo, 0=desativado |
| `erros` | INT | Contador de erros (desativa com 5+) |
| `ultimo_erro` | TEXT | Mensagem do último erro |
| `data_cadastro` | DATETIME | Data de cadastro |

### app_ical_bloqueios

| Campo | Tipo | Descrição |
|-------|------|-----------|
| `id` | INT | ID único do bloqueio |
| `app_anuncios_id` | INT | ID do anúncio |
| `app_anuncios_types_id` | INT | ID do tipo |
| `app_anuncios_types_unidades_id` | INT | ID da unidade |
| `app_ical_links_id` | INT | ID do link que importou |
| `uid` | VARCHAR(255) | UID único do evento iCal |
| `data_inicio` | DATE | Data de início do bloqueio |
| `data_fim` | DATE | Data de fim do bloqueio |
| `resumo` | VARCHAR(255) | Título/resumo do evento |

---

## Códigos de Erro

| Status | Mensagem | Causa |
|--------|----------|-------|
| `00` | Anúncio não encontrado ou não pertence ao usuário | ID inválido ou sem permissão |
| `00` | Este anúncio possui quartos. Informe o id_type do quarto. | Falta id_type |
| `00` | Este tipo possui N unidades. Informe o id_unidade. | Falta id_unidade |
| `00` | Quarto não encontrado ou não pertence a este anúncio | id_type inválido |
| `00` | Unidade não encontrada ou não pertence a este tipo | id_unidade inválido |
| `00` | URL inválida | URL não é válida |
| `00` | Nome da plataforma é obrigatório | Campo nome vazio |
| `00` | Link não encontrado ou não pertence a este anúncio | id_link inválido |
| `00` | Nenhum link iCal cadastrado para este anúncio/tipo | Não há links |

---

## Changelog

### v3.1.0 (30/11/2025)
- **Suporte por Unidade**: Cada unidade física pode ter seus próprios links iCal
- Novos endpoints: `listarUnidadesParaIcal`, `listarUnidadesTipo`, `atualizarNomeUnidade`
- Tabela `app_anuncios_types_unidades` para gerenciar unidades
- Criação automática de unidades baseada na quantidade do tipo
- Campo `id_unidade` nos endpoints de iCal

### v3.0.0 (30/11/2025)
- Implementação inicial da importação de iCal externo
- Suporte por tipo de quarto
- Sincronização automática via cron
