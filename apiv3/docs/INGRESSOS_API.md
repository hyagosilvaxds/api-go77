# API de Ingressos - Nomenclatura e Entrega por Email

> Documentação para o sistema de nomenclatura de ingressos e entrega por email para eventos.

---

## Índice

1. [Visão Geral](#visão-geral)
2. [Endpoints](#endpoints)
3. [Fluxo de Uso](#fluxo-de-uso)
4. [Template de Email](#template-de-email)

---

## Visão Geral

O sistema permite que parceiros nomeiem os ingressos comprados, associando:
- **Nome do portador**
- **Email do portador**
- **Celular do portador**

Ao nomear um ingresso, o sistema envia automaticamente um email com o ingresso digital contendo:
- Dados do evento
- Dados do portador
- QR Code para validação na entrada

---

## Endpoints

### 1. Listar Ingressos de uma Reserva

Lista todos os ingressos de um carrinho/reserva com status de nomeação.

**Endpoint:** `POST /apiv3/user/carrinho/listar-ingressos`

**Payload:**
```json
{
  "token": "Qd721n2E",
  "id_carrinho": 3
}
```

**Retorno:**
```json
[
  {
    "id": 2,
    "tipo_ingresso": "Ingresso VIP",
    "nome_evento": "Show de Rock",
    "valor": "150,00",
    "nomeado": true,
    "nome_portador": "João Silva",
    "email_portador": "joao@email.com",
    "celular_portador": "51999998888",
    "validado": false,
    "qrcode": "ABC123XYZ..."
  },
  {
    "id": 3,
    "tipo_ingresso": "Ingresso Pista",
    "nome_evento": "Show de Rock",
    "valor": "80,00",
    "nomeado": false,
    "nome_portador": null,
    "email_portador": null,
    "celular_portador": null,
    "validado": false,
    "qrcode": null
  }
]
```

| Campo | Tipo | Descrição |
|-------|------|-----------|
| id | int | ID do ingresso |
| tipo_ingresso | string | Tipo/categoria do ingresso |
| nome_evento | string | Nome do evento |
| valor | string | Valor formatado |
| nomeado | bool | Se o ingresso foi nomeado |
| nome_portador | string/null | Nome do portador |
| email_portador | string/null | Email do portador |
| celular_portador | string/null | Celular do portador |
| validado | bool | Se o ingresso já foi usado/validado |
| qrcode | string/null | QR Code para validação |

---

### 2. Nomear Ingresso (Simples)

Nomeia um ingresso sem enviar email.

**Endpoint:** `POST /apiv3/user/carrinho/nomear`

**Payload:**
```json
{
  "token": "Qd721n2E",
  "id": 2,
  "nome": "João Silva",
  "email": "joao@email.com",
  "celular": "51999998888"
}
```

**Retorno Sucesso:**
```json
[
  {
    "status": 1,
    "nome": "João Silva",
    "email": "joao@email.com",
    "celular": "51999998888",
    "msg": "Ingresso nomeado com sucesso."
  }
]
```

---

### 3. Nomear Ingresso com Envio de Email

Nomeia um ingresso E envia automaticamente o ingresso por email para o portador.

**Endpoint:** `POST /apiv3/user/carrinho/nomear-com-email`

**Payload:**
```json
{
  "token": "Qd721n2E",
  "id": 2,
  "nome": "João Silva",
  "email": "joao@email.com",
  "celular": "51999998888"
}
```

| Campo | Tipo | Obrigatório | Descrição |
|-------|------|-------------|-----------|
| token | string | Sim | Token de autenticação |
| id | int | Sim | ID do ingresso (app_carrinho_conteudo.id) |
| nome | string | Sim | Nome completo do portador |
| email | string | Sim | Email do portador (para envio do ingresso) |
| celular | string | Sim | Celular do portador |

**Retorno Sucesso:**
```json
[
  {
    "status": 1,
    "nome": "João Silva",
    "email": "joao@email.com",
    "celular": "51999998888",
    "msg": "Ingresso nomeado com sucesso.",
    "email_enviado": true
  }
]
```

**Retorno com Falha no Email:**
```json
[
  {
    "status": 1,
    "nome": "João Silva",
    "email": "joao@email.com",
    "celular": "51999998888",
    "msg": "Ingresso nomeado com sucesso.",
    "email_enviado": false,
    "email_erro": "Ingresso sem QRCode"
  }
]
```

---

### 4. Reenviar Ingresso por Email

Reenvia o ingresso por email para um ingresso já nomeado.

**Endpoint:** `POST /apiv3/user/carrinho/reenviar-ingresso`

**Payload:**
```json
{
  "token": "Qd721n2E",
  "id": 2
}
```

**Retorno Sucesso:**
```json
[
  {
    "status": "01",
    "msg": "Ingresso reenviado com sucesso."
  }
]
```

**Retorno Erro - Ingresso não nomeado:**
```json
[
  {
    "status": "02",
    "msg": "Ingresso não nomeado. Nomeie o ingresso antes de reenviar."
  }
]
```

---

## Fluxo de Uso

### Fluxo Completo do Parceiro

```
1. Cliente compra ingressos
   └── Reserva criada com status pendente/confirmado
       └── Ingressos criados em app_carrinho_conteudo

2. Parceiro lista ingressos da reserva
   └── POST /carrinho/listar-ingressos
       └── Identifica ingressos não nomeados (nomeado: false)

3. Parceiro nomeia cada ingresso
   └── POST /carrinho/nomear-com-email
       └── Ingresso nomeado + Email enviado ao portador

4. Portador recebe email com ingresso digital
   └── Email contém QR Code para entrada

5. No dia do evento
   └── POST /carrinho/leitura (validação do QR Code)
       └── Ingresso marcado como validado
```

### Diagrama de Sequência

```
┌──────────┐     ┌─────────┐     ┌──────────┐     ┌─────────┐
│ Cliente  │     │ Parceiro│     │   API    │     │ Portador│
└────┬─────┘     └────┬────┘     └────┬─────┘     └────┬────┘
     │                │               │                │
     │ Compra ingresso│               │                │
     │───────────────>│               │                │
     │                │               │                │
     │                │ Lista ingressos                │
     │                │──────────────>│                │
     │                │               │                │
     │                │ Nomeia + Email│                │
     │                │──────────────>│                │
     │                │               │                │
     │                │               │ Envia email    │
     │                │               │───────────────>│
     │                │               │                │
     │                │               │    No evento   │
     │                │               │<───────────────│
     │                │               │  (QR Code)     │
     │                │               │                │
```

---

## Template de Email

O email enviado contém um template HTML responsivo com:

### Estrutura Visual

```
┌─────────────────────────────────────┐
│         🎫 NOME DO EVENTO           │
│           Ingresso Digital          │
├─────────────────────────────────────┤
│                                     │
│  PORTADOR DO INGRESSO               │
│  ▓ JOÃO SILVA                       │
│                                     │
│  📅 Data: 25/12/2025 às 20:00       │
│  📍 Local: Arena Show               │
│  🎟️ Tipo: VIP                       │
│  💰 Valor: R$ 150,00                │
│                                     │
│        ┌─────────────┐              │
│        │             │              │
│        │   QR CODE   │              │
│        │             │              │
│        └─────────────┘              │
│   Apresente este QR Code            │
│      na entrada do evento           │
│                                     │
├─────────────────────────────────────┤
│  Este ingresso é pessoal e          │
│  intransferível.                    │
└─────────────────────────────────────┘
```

### Cores do Template

- **Header:** Gradiente roxo (#667eea → #764ba2)
- **Destaque portador:** Verde claro (#e8f5e9) com borda verde (#4caf50)
- **QR Code:** Fundo cinza claro (#f9f9f9)

---

## Exemplos de Uso

### cURL - Listar Ingressos

```bash
curl -X POST "https://seudominio.com/apiv3/user/carrinho/listar-ingressos" \
  -H "Content-Type: application/json" \
  -d '{
    "token": "Qd721n2E",
    "id_carrinho": 3
  }'
```

### cURL - Nomear com Email

```bash
curl -X POST "https://seudominio.com/apiv3/user/carrinho/nomear-com-email" \
  -H "Content-Type: application/json" \
  -d '{
    "token": "Qd721n2E",
    "id": 2,
    "nome": "Maria Santos",
    "email": "maria@email.com",
    "celular": "11988887777"
  }'
```

### cURL - Reenviar Ingresso

```bash
curl -X POST "https://seudominio.com/apiv3/user/carrinho/reenviar-ingresso" \
  -H "Content-Type: application/json" \
  -d '{
    "token": "Qd721n2E",
    "id": 2
  }'
```

---

## Tabelas Relacionadas

### app_carrinho_conteudo

| Campo | Tipo | Descrição |
|-------|------|-----------|
| id | int | ID do ingresso |
| app_carrinho_id | int | ID do carrinho |
| app_anuncios_ing_types_id | int | Tipo de ingresso |
| valor | decimal | Valor do ingresso |
| qrcode | text | QR Code (criptografado) |
| nome | text | Nome do portador (criptografado) |
| email | text | Email do portador (criptografado) |
| celular | text | Celular do portador (criptografado) |
| lido | int | 1=validado, 2=não validado |

---

## Arquivos Modificados

| Arquivo | Descrição |
|---------|-----------|
| `models/Carrinho/Carrinho.class.php` | Adicionado nomearComEmail(), reenviarIngresso(), listarIngressosReserva(), getDadosIngressoCompleto() |
| `controllers/Carrinho/Carrinho.controller.php` | Adicionado nomear_com_email(), reenviar_ingresso(), listar_ingressos() |
| `models/Emails/Emails.class.php` | Adicionado enviarIngresso() com template HTML |

---

## Changelog

| Data | Versão | Descrição |
|------|--------|-----------|
| 11/12/2025 | 1.0.0 | Implementação inicial da nomenclatura e envio de ingressos por email |

---

*Documentação gerada em 11 de dezembro de 2025*
