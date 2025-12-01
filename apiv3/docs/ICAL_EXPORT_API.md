# API de Exportação iCal - GO77 Destinos

## Visão Geral

Esta documentação descreve os endpoints para **EXPORTAÇÃO** de calendários iCal. Esses links podem ser adicionados no Airbnb, Booking e outras plataformas para sincronizar o calendário do GO77 com elas.

### Diferença entre Importação e Exportação

| Ação | Descrição | Exemplo |
|------|-----------|---------|
| **Importação** | GO77 lê calendários de outras plataformas | Adicionar link do Airbnb no GO77 |
| **Exportação** | Outras plataformas leem o calendário do GO77 | Adicionar link do GO77 no Airbnb |

Esta documentação trata da **EXPORTAÇÃO**.

---

## Sumário

1. [Obter Links de Exportação](#1-obter-links-de-exportação)
2. [Acessar Calendário iCal de Unidade](#2-acessar-calendário-ical-de-unidade)
3. [Acessar Calendário iCal Único do Anúncio](#3-acessar-calendário-ical-único-do-anúncio)
4. [Fluxo de Integração](#4-fluxo-de-integração)
5. [Exemplos Práticos](#5-exemplos-práticos)

---

## Base URL

```
http://localhost:8888/www/apiv3/user/anuncios/
```

Para produção, substituir por:
```
https://api.go77app.com/apiv3/user/anuncios/
```

---

## 1. Obter Links de Exportação

Retorna todos os links iCal de exportação para um anúncio. Para anúncios com quartos/tipos, retorna um link por cada unidade.

### Endpoint

```
POST /anuncios/listarLinksIcalExportacao/
```

### Headers

```
Content-Type: application/json
```

### Parâmetros (Body JSON)

| Campo | Tipo | Obrigatório | Descrição |
|-------|------|-------------|-----------|
| id_user | integer | Sim | ID do usuário proprietário |
| id_anuncio | integer | Sim | ID do anúncio |
| token | string | Sim | Token de autenticação da API |

### Exemplo de Requisição

```bash
curl -X POST http://localhost:8888/www/apiv3/user/anuncios/listarLinksIcalExportacao/ \
  -H "Content-Type: application/json" \
  -d '{
    "id_user": "334",
    "id_anuncio": "108",
    "token": "Qd721n2E"
  }'
```

### Resposta - Anúncio COM Quartos/Tipos

```json
{
    "status": "01",
    "tem_quartos": true,
    "msg": "Use estes links para exportar o calendário de cada unidade para outras plataformas (Airbnb, Booking, etc).",
    "anuncio": {
        "id": 108,
        "nome": "Pousada Beira Mar"
    },
    "link_unico": "http://localhost:8888/www/apiv3/user/anuncios/ical/108_d9f10d77ca950103/",
    "total_unidades": 4,
    "links_por_unidade": [
        {
            "id_type": 89,
            "nome_type": "Suíte Standard",
            "id_unidade": 14,
            "numero_unidade": 1,
            "nome_unidade": "Suite 101",
            "url": "http://localhost:8888/www/apiv3/user/anuncios/icalUnidade/108_89_14_3fabbfedaac82e3b/"
        },
        {
            "id_type": 89,
            "nome_type": "Suíte Standard",
            "id_unidade": 15,
            "numero_unidade": 2,
            "nome_unidade": "Suite 102",
            "url": "http://localhost:8888/www/apiv3/user/anuncios/icalUnidade/108_89_15_af11b6a2f1481ae7/"
        },
        {
            "id_type": 89,
            "nome_type": "Suíte Standard",
            "id_unidade": 16,
            "numero_unidade": 3,
            "nome_unidade": "Suite 103",
            "url": "http://localhost:8888/www/apiv3/user/anuncios/icalUnidade/108_89_16_9e29e1d0112c950c/"
        },
        {
            "id_type": 89,
            "nome_type": "Suíte Standard",
            "id_unidade": 17,
            "numero_unidade": 4,
            "nome_unidade": "Suite 104",
            "url": "http://localhost:8888/www/apiv3/user/anuncios/icalUnidade/108_89_17_846c41732760de7f/"
        }
    ]
}
```

### Resposta - Anúncio SEM Quartos/Tipos

```json
{
    "status": "01",
    "tem_quartos": false,
    "msg": "Este anúncio não possui quartos. Use o link único abaixo.",
    "anuncio": {
        "id": 50,
        "nome": "Casa de Praia"
    },
    "link_unico": "http://localhost:8888/www/apiv3/user/anuncios/ical/50_abc123def456/",
    "links_por_unidade": []
}
```

### Campos da Resposta

| Campo | Tipo | Descrição |
|-------|------|-----------|
| status | string | "01" = sucesso, "00" = erro |
| tem_quartos | boolean | Indica se o anúncio possui quartos/tipos |
| msg | string | Mensagem explicativa |
| anuncio | object | Dados básicos do anúncio |
| link_unico | string | Link iCal consolidado (todas as reservas) |
| total_unidades | integer | Quantidade de unidades (só para anúncios com quartos) |
| links_por_unidade | array | Lista de links individuais por unidade |

### Campos de cada Unidade

| Campo | Tipo | Descrição |
|-------|------|-----------|
| id_type | integer | ID do tipo de quarto |
| nome_type | string | Nome do tipo (ex: "Suíte Standard") |
| id_unidade | integer | ID da unidade |
| numero_unidade | integer | Número sequencial da unidade |
| nome_unidade | string | Nome/identificação da unidade |
| url | string | **URL iCal para adicionar no Airbnb/Booking** |

---

## 2. Acessar Calendário iCal de Unidade

Retorna o arquivo iCal com as reservas e bloqueios de uma unidade específica.

### Endpoint

```
GET /anuncios/icalUnidade/{id_anuncio}_{id_type}_{id_unidade}_{token}/
```

### Parâmetros (URL)

O parâmetro é composto por 4 valores separados por underscore (`_`):

| Posição | Campo | Descrição |
|---------|-------|-----------|
| 1 | id_anuncio | ID do anúncio |
| 2 | id_type | ID do tipo de quarto |
| 3 | id_unidade | ID da unidade |
| 4 | token | Token de segurança (gerado automaticamente) |

### Exemplo de Requisição

```bash
curl http://localhost:8888/www/apiv3/user/anuncios/icalUnidade/108_89_17_846c41732760de7f/
```

### Resposta

O endpoint retorna um arquivo iCal válido com Content-Type `text/calendar`:

```ical
BEGIN:VCALENDAR
VERSION:2.0
PRODID:-//GO77 Destinos//Calendario por Unidade//PT
CALSCALE:GREGORIAN
METHOD:PUBLISH
X-WR-CALNAME:Pousada Beira Mar - Suíte Standard - Suite 104
X-WR-TIMEZONE:America/Sao_Paulo
BEGIN:VTIMEZONE
TZID:America/Sao_Paulo
BEGIN:STANDARD
DTSTART:19700101T000000
TZOFFSETFROM:-0300
TZOFFSETTO:-0300
END:STANDARD
END:VTIMEZONE
BEGIN:VEVENT
UID:reserva-123-u17@go77app.com
DTSTAMP:20251130T233115Z
DTSTART;VALUE=DATE:20251215
DTEND;VALUE=DATE:20251220
SUMMARY:Reserva - Suite 104
DESCRIPTION:Reserva confirmada\nUnidade: Suite 104\nAdultos: 2\nCrianças: 1\nValor: R$ 1.500,00
STATUS:CONFIRMED
TRANSP:OPAQUE
END:VEVENT
BEGIN:VEVENT
UID:bloqueio-45@go77app.com
DTSTAMP:20251130T233115Z
DTSTART;VALUE=DATE:20251220
DTEND;VALUE=DATE:20251227
SUMMARY:Reserva - João Silva
DESCRIPTION:Importado de: Airbnb
STATUS:CONFIRMED
TRANSP:OPAQUE
END:VEVENT
END:VCALENDAR
```

### Tipos de Eventos no iCal

| Tipo | UID Pattern | Descrição |
|------|-------------|-----------|
| Reserva GO77 | `reserva-{id}-u{unidade}@go77app.com` | Reservas feitas diretamente no GO77 |
| Bloqueio Importado | `bloqueio-{id}@go77app.com` | Bloqueios importados de outras plataformas |

### Erros Possíveis

| HTTP Status | Mensagem | Causa |
|-------------|----------|-------|
| 404 | Parâmetros inválidos | Formato do parâmetro incorreto |
| 404 | Anúncio não encontrado | ID do anúncio não existe |
| 403 | Token inválido | Token de segurança incorreto |
| 404 | Tipo ou unidade não encontrada | Type ou unidade não existe |

---

## 3. Acessar Calendário iCal Único do Anúncio

Para anúncios sem quartos, ou para obter uma visão consolidada de todas as reservas.

### Endpoint

```
GET /anuncios/ical/{id_anuncio}_{token}/
```

### Exemplo

```bash
curl http://localhost:8888/www/apiv3/user/anuncios/ical/108_d9f10d77ca950103/
```

### Resposta

Retorna arquivo iCal com todas as reservas do anúncio consolidadas.

---

## 4. Fluxo de Integração

### Como integrar o calendário GO77 no Airbnb

```
┌─────────────────────────────────────────────────────────────────────┐
│                    FLUXO DE INTEGRAÇÃO AIRBNB                        │
├─────────────────────────────────────────────────────────────────────┤
│                                                                       │
│  1. App GO77 chama listarLinksIcalExportacao                         │
│     ┌─────────────────────────────────────────────────────────┐      │
│     │ POST /anuncios/listarLinksIcalExportacao/               │      │
│     │ Body: { id_user, id_anuncio, token }                    │      │
│     └─────────────────────────────────────────────────────────┘      │
│                              │                                        │
│                              ▼                                        │
│  2. API retorna links por unidade                                    │
│     ┌─────────────────────────────────────────────────────────┐      │
│     │ Suite 101: http://.../icalUnidade/108_89_14_abc123/     │      │
│     │ Suite 102: http://.../icalUnidade/108_89_15_def456/     │      │
│     │ Suite 103: http://.../icalUnidade/108_89_16_ghi789/     │      │
│     └─────────────────────────────────────────────────────────┘      │
│                              │                                        │
│                              ▼                                        │
│  3. Usuário copia o link da unidade específica                       │
│                              │                                        │
│                              ▼                                        │
│  4. No Airbnb: Calendário → Importar calendário                      │
│     ┌─────────────────────────────────────────────────────────┐      │
│     │ [Cole a URL do calendário externo]                      │      │
│     │ http://.../icalUnidade/108_89_14_abc123/                │      │
│     │                                                          │      │
│     │ Nome: GO77 - Suite 101                                   │      │
│     │                                                          │      │
│     │ [Importar]                                               │      │
│     └─────────────────────────────────────────────────────────┘      │
│                              │                                        │
│                              ▼                                        │
│  5. Airbnb busca calendário via HTTP GET                             │
│     ┌─────────────────────────────────────────────────────────┐      │
│     │ GET http://.../icalUnidade/108_89_14_abc123/            │      │
│     │                                                          │      │
│     │ Response: BEGIN:VCALENDAR...                             │      │
│     └─────────────────────────────────────────────────────────┘      │
│                              │                                        │
│                              ▼                                        │
│  6. Airbnb atualiza automaticamente a cada 3-24 horas               │
│                                                                       │
└─────────────────────────────────────────────────────────────────────┘
```

### Sincronização Bidirecional

Para sincronização completa:

1. **GO77 → Airbnb**: Use os links desta documentação (EXPORTAÇÃO)
2. **Airbnb → GO77**: Use a API de IMPORTAÇÃO (ver ICAL_IMPORT_API.md)

```
┌──────────────────────────────────────────────────────────────────┐
│                 SINCRONIZAÇÃO BIDIRECIONAL                        │
├──────────────────────────────────────────────────────────────────┤
│                                                                    │
│    ┌──────────┐                              ┌──────────┐         │
│    │   GO77   │                              │  AIRBNB  │         │
│    │          │                              │          │         │
│    │ Suite101 │  ─── EXPORTAÇÃO (iCal) ───>  │ Anúncio  │         │
│    │          │                              │          │         │
│    │ Suite101 │  <── IMPORTAÇÃO (iCal) ───   │ Anúncio  │         │
│    │          │                              │          │         │
│    └──────────┘                              └──────────┘         │
│                                                                    │
│    Resultado: Calendários sincronizados automaticamente           │
│                                                                    │
└──────────────────────────────────────────────────────────────────┘
```

---

## 5. Exemplos Práticos

### 5.1 Listar Links para UI do App

```javascript
// React Native / Flutter
async function carregarLinksExportacao(userId, anuncioId) {
    const response = await fetch('https://api.go77app.com/apiv3/user/anuncios/listarLinksIcalExportacao/', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({
            id_user: userId,
            id_anuncio: anuncioId,
            token: 'Qd721n2E'
        })
    });
    
    const data = await response.json();
    
    if (data.status === '01') {
        if (data.tem_quartos) {
            // Exibe lista de unidades com botão de copiar
            data.links_por_unidade.forEach(unidade => {
                console.log(`${unidade.nome_unidade}: ${unidade.url}`);
            });
        } else {
            // Exibe link único
            console.log(`Link único: ${data.link_unico}`);
        }
    }
}
```

### 5.2 Widget de Cópia no App

```dart
// Flutter
Widget buildLinkCard(Map unidade) {
  return Card(
    child: ListTile(
      title: Text(unidade['nome_unidade']),
      subtitle: Text(unidade['nome_type']),
      trailing: IconButton(
        icon: Icon(Icons.copy),
        onPressed: () {
          Clipboard.setData(ClipboardData(text: unidade['url']));
          ScaffoldMessenger.of(context).showSnackBar(
            SnackBar(content: Text('Link copiado!')),
          );
        },
      ),
    ),
  );
}
```

### 5.3 Teste via cURL

```bash
# 1. Obter links de exportação
curl -X POST http://localhost:8888/www/apiv3/user/anuncios/listarLinksIcalExportacao/ \
  -H "Content-Type: application/json" \
  -d '{"id_user":"334","id_anuncio":"108","token":"Qd721n2E"}' | jq

# 2. Acessar iCal de uma unidade específica
curl http://localhost:8888/www/apiv3/user/anuncios/icalUnidade/108_89_17_846c41732760de7f/

# 3. Salvar como arquivo .ics
curl -o calendario.ics http://localhost:8888/www/apiv3/user/anuncios/icalUnidade/108_89_17_846c41732760de7f/
```

---

## Notas Importantes

### Segurança dos Links

- Cada link possui um **token único** gerado a partir dos IDs
- Os tokens são fixos (não expiram) para permitir sincronização contínua
- Os links podem ser compartilhados com plataformas externas

### Atualização Automática

- O Airbnb/Booking sincroniza os calendários iCal periodicamente (3-24h)
- Qualquer nova reserva no GO77 aparecerá na próxima sincronização
- Não é necessário atualizar o link manualmente

### Conteúdo Exportado

O iCal exportado inclui:
- ✅ Reservas confirmadas do GO77
- ✅ Bloqueios importados de outras plataformas (iCal)
- ❌ Reservas canceladas
- ❌ Reservas pendentes de pagamento

### Compatibilidade

Os arquivos iCal gerados são compatíveis com:
- ✅ Airbnb
- ✅ Booking.com
- ✅ VRBO
- ✅ Google Calendar
- ✅ Apple Calendar
- ✅ Outlook

---

## Histórico de Alterações

| Data | Versão | Descrição |
|------|--------|-----------|
| 30/11/2025 | 1.0.0 | Criação inicial da API de exportação por unidade |

---

## Suporte

Para dúvidas ou problemas:
- Email: suporte@go77app.com
- Documentação de Importação: [ICAL_IMPORT_API.md](./ICAL_IMPORT_API.md)
