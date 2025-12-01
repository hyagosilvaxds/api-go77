# API de Exportação de Calendário iCal - GO77 Destinos

## Visão Geral

A API de exportação iCal permite que os usuários sincronizem as reservas de seus anúncios com serviços externos como **Airbnb**, **Booking.com**, **Google Calendar**, **Apple Calendar**, **Outlook** e outros.

### Características Principais

- ✅ **Link permanente**: Cada anúncio possui um link iCal fixo que nunca muda
- ✅ **Sempre atualizado**: O link sempre retorna as reservas mais recentes em tempo real
- ✅ **Compatível com cron**: Serviços como Airbnb podem consumir o link periodicamente (ex: a cada 3h)
- ✅ **Acesso restrito**: Apenas o dono do anúncio pode ver o link iCal
- ✅ **Importação de iCal externo**: Sincronize calendários de outras plataformas (Airbnb, Booking, etc)
- ✅ **Sincronização automática**: Cron de 6 em 6 horas para importar bloqueios externos

---

## Sumário

1. [Exportação iCal](#endpoints) - Exportar suas reservas para outras plataformas
2. [Importação iCal Externo](#importação-de-ical-externo) - Importar calendários de outras plataformas
3. [Endpoints do Admin](#endpoints-do-admin)
4. [Cron de Sincronização](#configuração-do-cron)

---

## Como Funciona

### Exportação (suas reservas → outras plataformas)
1. O dono do anúncio acessa o endpoint `/anuncios/getLinkIcal/` ou `/anuncios/getMeusLinksIcal/`
2. Recebe o link iCal permanente do(s) seu(s) anúncio(s)
3. Usa esse link em serviços como Airbnb, Booking, Google Calendar, etc.
4. Quando o serviço acessa o link, recebe sempre os dados atualizados

### Importação (outras plataformas → seu anúncio)
1. O dono adiciona o link iCal de outra plataforma via `/anuncios/adicionarIcalExterno/`
2. O sistema sincroniza automaticamente a cada 6 horas via cron
3. Os períodos bloqueados nas outras plataformas são importados e marcados como indisponíveis

---

## Endpoints

### 1. Obter Link iCal de um Anúncio Específico

Retorna o link iCal de um anúncio. **Disponível apenas para o dono do anúncio.**

#### Request

```
POST /apiv3/user/anuncios/getLinkIcal/
Content-Type: application/json
```

#### Payload

| Campo | Tipo | Obrigatório | Descrição |
|-------|------|-------------|-----------|
| `id_user` | string | Sim | ID do usuário logado (deve ser o dono do anúncio) |
| `id_anuncio` | string | Sim | ID do anúncio |
| `token` | string | Sim | Token de autenticação da API |

#### Exemplo de Request

```json
{
  "id_user": "334",
  "id_anuncio": "104",
  "token": "Qd721n2E"
}
```

#### Response - Sucesso

```json
{
  "status": "01",
  "id_anuncio": "104",
  "nome": "Casa na Praia",
  "link_ical": "http://go77app.com/apiv3/user/anuncios/ical/104_ce846b3e99e78ca6/",
  "instrucoes": "Use este link para sincronizar com Airbnb, Booking, Google Calendar, etc. O link é permanente e sempre retorna as reservas atualizadas."
}
```

#### Response - Erro (não é o dono)

```json
{
  "status": "00",
  "msg": "Você não tem permissão para acessar o calendário deste anúncio"
}
```

#### Response - Erro (anúncio não existe)

```json
{
  "status": "00",
  "msg": "Anúncio não encontrado"
}
```

---

### 2. Obter Links iCal de Todos os Meus Anúncios

Retorna os links iCal de todos os anúncios do usuário logado.

#### Request

```
POST /apiv3/user/anuncios/getMeusLinksIcal/
Content-Type: application/json
```

#### Payload

| Campo | Tipo | Obrigatório | Descrição |
|-------|------|-------------|-----------|
| `id_user` | string | Sim | ID do usuário logado |
| `token` | string | Sim | Token de autenticação da API |

#### Exemplo de Request

```json
{
  "id_user": "334",
  "token": "Qd721n2E"
}
```

#### Response - Sucesso

```json
{
  "status": "01",
  "total": 3,
  "anuncios": [
    {
      "id_anuncio": 104,
      "nome": "Casa na Praia",
      "status": 1,
      "status_aprovado": 1,
      "link_ical": "http://go77app.com/apiv3/user/anuncios/ical/104_ce846b3e99e78ca6/"
    },
    {
      "id_anuncio": 105,
      "nome": "Chalé na Serra",
      "status": 1,
      "status_aprovado": 1,
      "link_ical": "http://go77app.com/apiv3/user/anuncios/ical/105_3802e5c4ce941d17/"
    }
  ],
  "instrucoes": "Use estes links para sincronizar seus anúncios com Airbnb, Booking, Google Calendar, etc."
}
```

---

### 3. Acessar Calendário iCal (Endpoint Público)

Endpoint acessado por serviços externos (Airbnb, Booking, Google Calendar, etc.).

**Importante**: Este endpoint é público e não requer token de API. A segurança é garantida pelo token embutido na URL, que só o dono do anúncio conhece.

#### Request

```
GET /apiv3/user/anuncios/ical/{id_anuncio}_{token}/
```

#### Exemplo de URL

```
http://go77app.com/apiv3/user/anuncios/ical/104_ce846b3e99e78ca6/
```

#### Response - Sucesso

Retorna arquivo `.ics` com as reservas atualizadas:

```ics
BEGIN:VCALENDAR
VERSION:2.0
PRODID:-//GO77 Destinos//Calendario de Reservas//PT
CALSCALE:GREGORIAN
METHOD:PUBLISH
X-WR-CALNAME:Casa na Praia
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
UID:reserva-13@go77app.com
DTSTAMP:20251130T140021Z
DTSTART;VALUE=DATE:20251220
DTEND;VALUE=DATE:20251226
SUMMARY:Reserva - Casa na Praia
DESCRIPTION:Reserva confirmada\nAdultos: 2\nCrianças: 1\nValor: R$ 1.500,00
STATUS:CONFIRMED
TRANSP:OPAQUE
END:VEVENT
END:VCALENDAR
```

#### Headers de Resposta

```
Content-Type: text/calendar; charset=utf-8
Content-Disposition: inline; filename="calendario_Casa_na_Praia.ics"
Cache-Control: no-cache, no-store, must-revalidate
Pragma: no-cache
Expires: 0
```

#### Response - Erro 403

```
Token inválido
```

#### Response - Erro 404

```
Anúncio não encontrado
```

---

## Integrações com Plataformas Externas

### Airbnb

1. No app, acesse **Meus Anúncios** → **Calendário iCal**
2. Copie o link do anúncio desejado
3. No Airbnb, vá em **Calendário** → **Disponibilidade** → **Importar calendário**
4. Cole o link copiado
5. O Airbnb sincronizará automaticamente a cada 3 horas

### Booking.com

1. Obtenha o link iCal do anúncio
2. Na extranet do Booking.com, vá em **Calendário** → **Sincronização**
3. Adicione o link como "Importar calendário"
4. Configure a frequência de atualização

### Google Calendar

1. Obtenha o link iCal do anúncio
2. No Google Calendar, clique em **+** ao lado de "Outros calendários"
3. Selecione **A partir do URL**
4. Cole o link

### Apple Calendar (macOS/iOS)

1. Obtenha o link iCal do anúncio
2. Vá em **Arquivo** → **Nova Assinatura de Calendário**
3. Cole o link
4. Configure a frequência de atualização

---

## Implementação no Cliente Flutter

```dart
import 'dart:convert';
import 'package:http/http.dart' as http;
import 'package:flutter/services.dart';
import 'package:share_plus/share_plus.dart';

class ICalService {
  static const String baseUrl = 'http://10.0.2.2:8888/www/apiv3/user';
  static const String token = 'Qd721n2E';

  /// Obtém o link iCal de um anúncio específico
  static Future<Map<String, dynamic>?> getLinkIcal({
    required String idUser,
    required String idAnuncio,
  }) async {
    try {
      final response = await http.post(
        Uri.parse('$baseUrl/anuncios/getLinkIcal/'),
        headers: {'Content-Type': 'application/json'},
        body: jsonEncode({
          'id_user': idUser,
          'id_anuncio': idAnuncio,
          'token': token,
        }),
      );

      final data = jsonDecode(response.body);
      
      if (data['status'] == '01') {
        return data;
      } else {
        throw Exception(data['msg']);
      }
    } catch (e) {
      print('Erro ao obter link iCal: $e');
      return null;
    }
  }

  /// Obtém os links iCal de todos os anúncios do usuário
  static Future<List<Map<String, dynamic>>> getMeusLinksIcal({
    required String idUser,
  }) async {
    try {
      final response = await http.post(
        Uri.parse('$baseUrl/anuncios/getMeusLinksIcal/'),
        headers: {'Content-Type': 'application/json'},
        body: jsonEncode({
          'id_user': idUser,
          'token': token,
        }),
      );

      final data = jsonDecode(response.body);
      
      if (data['status'] == '01') {
        return List<Map<String, dynamic>>.from(data['anuncios']);
      }
      return [];
    } catch (e) {
      print('Erro ao obter links iCal: $e');
      return [];
    }
  }
}

// Widget para exibir e compartilhar o link iCal
class ICalLinkWidget extends StatelessWidget {
  final String idUser;
  final String idAnuncio;
  final String nomeAnuncio;
  
  const ICalLinkWidget({
    required this.idUser,
    required this.idAnuncio,
    required this.nomeAnuncio,
  });
  
  @override
  Widget build(BuildContext context) {
    return Card(
      child: ListTile(
        leading: Icon(Icons.calendar_month, color: Colors.blue),
        title: Text('Calendário iCal'),
        subtitle: Text('Sincronize com Airbnb, Booking, etc.'),
        trailing: Icon(Icons.arrow_forward_ios),
        onTap: () async {
          final result = await ICalService.getLinkIcal(
            idUser: idUser,
            idAnuncio: idAnuncio,
          );
          
          if (result != null) {
            _showIcalOptions(context, result['link_ical'], nomeAnuncio);
          } else {
            ScaffoldMessenger.of(context).showSnackBar(
              SnackBar(content: Text('Erro ao obter link do calendário')),
            );
          }
        },
      ),
    );
  }
  
  void _showIcalOptions(BuildContext context, String link, String nome) {
    showModalBottomSheet(
      context: context,
      builder: (context) => Padding(
        padding: EdgeInsets.all(16),
        child: Column(
          mainAxisSize: MainAxisSize.min,
          crossAxisAlignment: CrossAxisAlignment.start,
          children: [
            Text(
              'Link iCal - $nome',
              style: TextStyle(fontSize: 18, fontWeight: FontWeight.bold),
            ),
            SizedBox(height: 8),
            Text(
              'Use este link para sincronizar suas reservas com outros serviços.',
              style: TextStyle(color: Colors.grey[600]),
            ),
            SizedBox(height: 16),
            Container(
              padding: EdgeInsets.all(12),
              decoration: BoxDecoration(
                color: Colors.grey[100],
                borderRadius: BorderRadius.circular(8),
              ),
              child: Text(
                link,
                style: TextStyle(fontFamily: 'monospace', fontSize: 12),
              ),
            ),
            SizedBox(height: 16),
            Row(
              children: [
                Expanded(
                  child: ElevatedButton.icon(
                    icon: Icon(Icons.copy),
                    label: Text('Copiar'),
                    onPressed: () {
                      Clipboard.setData(ClipboardData(text: link));
                      Navigator.pop(context);
                      ScaffoldMessenger.of(context).showSnackBar(
                        SnackBar(content: Text('Link copiado!')),
                      );
                    },
                  ),
                ),
                SizedBox(width: 12),
                Expanded(
                  child: OutlinedButton.icon(
                    icon: Icon(Icons.share),
                    label: Text('Compartilhar'),
                    onPressed: () {
                      Share.share('Link iCal - $nome:\n$link');
                      Navigator.pop(context);
                    },
                  ),
                ),
              ],
            ),
          ],
        ),
      ),
    );
  }
}
```

---

## Como o Dono do Anúncio Faz Download do Arquivo .ics

O dono do anúncio pode baixar o arquivo `.ics` de duas formas:

### Método 1: Via Link Permanente (Recomendado)

1. Obtenha o link iCal usando o endpoint `getLinkIcal` ou `getMeusLinksIcal`
2. Acesse o link diretamente no navegador
3. O arquivo `.ics` será baixado automaticamente

```bash
# Passo 1: Obter o link
curl -X POST http://localhost:8888/www/apiv3/user/anuncios/getLinkIcal/ \
  -H "Content-Type: application/json" \
  -d '{"id_user": "334", "id_anuncio": "104", "token": "Qd721n2E"}'

# Resposta:
# {
#   "status": "01",
#   "link_ical": "http://localhost:8888/www/apiv3/user/anuncios/ical/104_ce846b3e99e78ca6/"
# }

# Passo 2: Baixar o arquivo .ics
curl -o meu_calendario.ics "http://localhost:8888/www/apiv3/user/anuncios/ical/104_ce846b3e99e78ca6/"
```

### Método 2: Via Endpoint exportarIcal

Use o endpoint `exportarIcal` para obter o link de download:

```bash
curl -X POST http://localhost:8888/www/apiv3/user/anuncios/exportarIcal/ \
  -H "Content-Type: application/json" \
  -d '{"id_user": "334", "id_anuncio": "104", "token": "Qd721n2E"}'

# Resposta:
# {
#   "status": "01",
#   "link": "http://localhost:8888/www/apiv3/user/anuncios/ical/104_ce846b3e99e78ca6/",
#   "msg": "Link do calendário gerado com sucesso"
# }
```

### No App Flutter

```dart
// Obter link e abrir no navegador para download
final result = await ICalService.getLinkIcal(
  idUser: '334',
  idAnuncio: '104',
);

if (result != null) {
  final link = result['link_ical'];
  
  // Opção 1: Abrir no navegador (baixa automaticamente)
  await launchUrl(Uri.parse(link));
  
  // Opção 2: Copiar link para área de transferência
  await Clipboard.setData(ClipboardData(text: link));
}
```

---

## Exemplo com cURL

```bash
# 1. Obter link iCal de um anúncio específico (apenas dono)
curl -X POST http://localhost:8888/www/apiv3/user/anuncios/getLinkIcal/ \
  -H "Content-Type: application/json" \
  -d '{"id_user": "334", "id_anuncio": "104", "token": "Qd721n2E"}'

# 2. Obter links iCal de todos os meus anúncios
curl -X POST http://localhost:8888/www/apiv3/user/anuncios/getMeusLinksIcal/ \
  -H "Content-Type: application/json" \
  -d '{"id_user": "334", "token": "Qd721n2E"}'

# 3. Acessar o calendário iCal (como o Airbnb faria)
curl "http://localhost:8888/www/apiv3/user/anuncios/ical/104_ce846b3e99e78ca6/"

# 4. Baixar o arquivo .ics diretamente
curl -o calendario.ics "http://localhost:8888/www/apiv3/user/anuncios/ical/104_ce846b3e99e78ca6/"
```

---

## Segurança

- ✅ O link iCal só é visível para o dono do anúncio
- ✅ O token é gerado usando hash MD5 com salt fixo
- ✅ O link é permanente e baseado apenas no ID do anúncio
- ✅ Apenas quem tem o link pode acessar o calendário
- ✅ O link não aparece na listagem pública de anúncios

---

## Estrutura do Evento iCal

| Campo | Descrição |
|-------|-----------|
| `UID` | Identificador único: `reserva-{id}@go77app.com` |
| `DTSTAMP` | Data/hora de geração (sempre atual) |
| `DTSTART` | Data de check-in |
| `DTEND` | Data de check-out + 1 dia |
| `SUMMARY` | "Reserva - {nome do anúncio}" |
| `DESCRIPTION` | Detalhes: adultos, crianças, valor, observações |
| `STATUS` | CONFIRMED |
| `TRANSP` | OPAQUE (bloqueia o horário) |

---

## Códigos de Erro

| Código HTTP | Mensagem | Causa |
|-------------|----------|-------|
| 200 | (arquivo .ics) | Sucesso |
| 200 | `{"status":"00",...}` | Erro de permissão ou anúncio não encontrado |
| 403 | "Token inválido" | Token incorreto na URL do iCal |
| 404 | "Anúncio não encontrado" | ID do anúncio inválido |

---


## FAQ

### Quem pode ver o link iCal?
Apenas o dono do anúncio pode ver e obter o link iCal. Administradores também podem acessar qualquer link via painel admin.

### O link muda se eu editar o anúncio?
Não. O link é permanente e baseado apenas no ID do anúncio.

### Com que frequência o Airbnb atualiza?
O Airbnb consulta os links iCal a cada 3 horas aproximadamente.

### O calendário mostra reservas canceladas?
Não. Apenas reservas com status ativo (status = 1) são exibidas.

### Posso usar o mesmo link em vários lugares?
Sim! O link pode ser usado simultaneamente no Airbnb, Booking, Google Calendar, etc.

---

## Endpoints do Admin

Os endpoints abaixo estão disponíveis apenas para administradores do sistema.

### 1. Obter Link iCal de Qualquer Anúncio (Admin)

Permite ao admin obter o link iCal de qualquer anúncio, independente do dono.

#### Request

```
POST /admin/apiv3/user/anuncios/getLinkIcal/
Content-Type: application/json
```

#### Payload

| Campo | Tipo | Obrigatório | Descrição |
|-------|------|-------------|-----------|
| `id_anuncio` | string | Sim | ID do anúncio |
| `token` | string | Sim | Token de autenticação do admin |

#### Exemplo de Request

```json
{
  "id_anuncio": "104",
  "token": "96J95vTx"
}
```

#### Response - Sucesso

```json
{
  "status": "01",
  "id_anuncio": "104",
  "nome_anuncio": "Casa na Praia",
  "link_ical": "http://go77app.com/apiv3/user/anuncios/ical/104_ce846b3e99e78ca6/",
  "msg": "Link iCal obtido com sucesso."
}
```

---

### 2. Obter Links iCal de Todos os Anúncios (Admin)

Retorna os links iCal de todos os anúncios cadastrados no sistema.

#### Request

```
POST /admin/apiv3/user/anuncios/getTodosLinksIcal/
Content-Type: application/json
```

#### Payload

| Campo | Tipo | Obrigatório | Descrição |
|-------|------|-------------|-----------|
| `token` | string | Sim | Token de autenticação do admin |

#### Exemplo de Request

```json
{
  "token": "96J95vTx"
}
```

#### Response - Sucesso

```json
{
  "status": "01",
  "total": 15,
  "anuncios": [
    {
      "id_anuncio": "104",
      "nome": "Casa na Praia",
      "id_user": "334",
      "link_ical": "http://go77app.com/apiv3/user/anuncios/ical/104_ce846b3e99e78ca6/"
    },
    {
      "id_anuncio": "105",
      "nome": "Chalé na Serra",
      "id_user": "335",
      "link_ical": "http://go77app.com/apiv3/user/anuncios/ical/105_3802e5c4ce941d17/"
    }
  ],
  "msg": "Links iCal obtidos com sucesso."
}
```

---

### 3. Exportar Arquivo iCal (Admin)

Permite ao admin baixar diretamente o arquivo .ics de qualquer anúncio.

#### Request

```
POST /admin/apiv3/user/anuncios/exportarIcal/
Content-Type: application/json
```

#### Payload

| Campo | Tipo | Obrigatório | Descrição |
|-------|------|-------------|-----------|
| `id_anuncio` | string | Sim | ID do anúncio |
| `token` | string | Sim | Token de autenticação do admin |

#### Exemplo de Request

```json
{
  "id_anuncio": "104",
  "token": "96J95vTx"
}
```

#### Response - Sucesso

Retorna arquivo `.ics` para download com headers:

```
Content-Type: text/calendar; charset=utf-8
Content-Disposition: attachment; filename="anuncio_104.ics"
```

---

## Importação de iCal Externo

Permite importar calendários de outras plataformas (Airbnb, Booking, etc) para bloquear automaticamente os períodos ocupados.

### ⭐ Suporte por Quarto/Tipo e Unidade

A importação de iCal suporta configuração **por unidade específica** de cada quarto/tipo. Isso é essencial quando você tem múltiplas unidades do mesmo tipo de quarto (ex: 4 suítes standard) e cada uma está listada separadamente no Airbnb ou Booking.

**Hierarquia:**
- **Anúncio** → pode ter múltiplos **Tipos de Quarto** → cada tipo pode ter múltiplas **Unidades**

**Exemplo:**
- Pousada Vila 4 Ventos (Anúncio)
  - Suíte Standard (Tipo) → 4 unidades (Suíte 101, 102, 103, 104)
  - Suíte Master (Tipo) → 2 unidades (Suíte 201, 202)

Cada unidade pode ter seu próprio link iCal do Airbnb/Booking.

### Fluxo de Sincronização

1. Usuário lista as unidades disponíveis via `listarUnidadesParaIcal`
2. Usuário adiciona URL do calendário iCal especificando a unidade
3. Sistema baixa e parseia o arquivo iCal
4. Eventos são salvos como bloqueios (vinculados à unidade específica)
5. Cron roda a cada 6 horas para manter atualizado
6. Links com 5+ erros são desativados automaticamente

---

### 0. Listar Unidades Disponíveis para iCal (NOVO)

**Use este endpoint ANTES de adicionar um link iCal** para obter a lista de tipos e unidades disponíveis.

```
POST /apiv3/user/anuncios/listarUnidadesParaIcal/
Content-Type: application/json
```

#### Payload

| Campo | Tipo | Obrigatório | Descrição |
|-------|------|-------------|-----------|
| `id_user` | string | Sim | ID do usuário |
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
      "descricao": "Suíte com cama casal",
      "qtd_unidades": 4,
      "unidades": [
        {
          "id": 1,
          "numero": 1,
          "nome": "Suíte 101",
          "links_ical": 1
        },
        {
          "id": 2,
          "numero": 2,
          "nome": "Suíte 102",
          "links_ical": 0
        },
        {
          "id": 3,
          "numero": 3,
          "nome": "Suíte 103",
          "links_ical": 0
        },
        {
          "id": 4,
          "numero": 4,
          "nome": "Suíte 104",
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

---

### 0.1 Listar Unidades de um Tipo Específico

```
POST /apiv3/user/anuncios/listarUnidadesTipo/
Content-Type: application/json
```

#### Payload

| Campo | Tipo | Obrigatório | Descrição |
|-------|------|-------------|-----------|
| `id_user` | string | Sim | ID do usuário |
| `id_anuncio` | string | Sim | ID do anúncio |
| `id_type` | int | Sim | ID do tipo de quarto |
| `token` | string | Sim | Token de autenticação |

---

### 0.2 Atualizar Nome de uma Unidade

Permite personalizar o nome da unidade (ex: "Suíte 101", "Quarto Azul").

```
POST /apiv3/user/anuncios/atualizarNomeUnidade/
Content-Type: application/json
```

#### Payload

| Campo | Tipo | Obrigatório | Descrição |
|-------|------|-------------|-----------|
| `id_user` | string | Sim | ID do usuário |
| `id_anuncio` | string | Sim | ID do anúncio |
| `id_type` | int | Sim | ID do tipo |
| `id_unidade` | int | Sim | ID da unidade |
| `nome` | string | Sim | Novo nome da unidade |
| `token` | string | Sim | Token de autenticação |

---

### 1. Adicionar Link iCal Externo

```
POST /apiv3/user/anuncios/adicionarIcalExterno/
Content-Type: application/json
```

#### Payload

| Campo | Tipo | Obrigatório | Descrição |
|-------|------|-------------|-----------|
| `id_user` | string | Sim | ID do usuário (dono do anúncio) |
| `id_anuncio` | string | Sim | ID do anúncio |
| `id_type` | int | **Condicional** | ID do quarto/tipo. **Obrigatório se o anúncio tiver quartos.** |
| `id_unidade` | int | **Condicional** | ID da unidade. **Obrigatório se o tipo tiver mais de 1 unidade.** |
| `nome` | string | Sim | Nome da plataforma (Airbnb, Booking, etc) |
| `url` | string | Sim | URL do calendário iCal |
| `token` | string | Sim | Token de autenticação |

> **Regras de Negócio**: 
> - Se o anúncio **NÃO** possui quartos: `id_type` e `id_unidade` podem ser omitidos
> - Se o anúncio **possui quartos**: `id_type` é obrigatório
> - Se o tipo possui **mais de 1 unidade**: `id_unidade` é obrigatório
> - Se o tipo possui **apenas 1 unidade**: `id_unidade` é preenchido automaticamente

#### Exemplo - Anúncio Sem Quartos

```json
{
  "id_user": "334",
  "id_anuncio": "104",
  "nome": "Airbnb",
  "url": "https://www.airbnb.com.br/calendar/ical/12345678.ics?s=abc123",
  "token": "Qd721n2E"
}
```

#### Exemplo - Anúncio Com Quartos e Múltiplas Unidades

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

#### Response - Erro (tipo com múltiplas unidades, sem id_unidade)

```json
{
  "status": "00",
  "msg": "Este tipo possui 4 unidades. Informe o id_unidade.",
  "unidades_disponiveis": [
    {"id": 1, "numero": 1, "nome": "Suíte 101", "links_ical": 0},
    {"id": 2, "numero": 2, "nome": "Suíte 102", "links_ical": 0},
    {"id": 3, "numero": 3, "nome": "Suíte 103", "links_ical": 0},
    {"id": 4, "numero": 4, "nome": "Suíte 104", "links_ical": 0}
  ]
}
```

#### Response - Erro (anúncio com quartos, sem id_type)

```json
{
  "status": "00",
  "msg": "Este anúncio possui quartos. Informe o id_type do quarto."
}
```

---

### 2. Listar Links iCal Externos

```
POST /apiv3/user/anuncios/listarIcalExterno/
Content-Type: application/json
```

#### Payload

| Campo | Tipo | Obrigatório | Descrição |
|-------|------|-------------|-----------|
| `id_user` | string | Sim | ID do usuário |
| `id_anuncio` | string | Sim | ID do anúncio |
| `id_type` | int | **Não** | Filtrar por quarto/tipo (omitir = lista todos) |
| `id_unidade` | int | **Não** | Filtrar por unidade específica |
| `token` | string | Sim | Token de autenticação |

#### Exemplo - Todos os Links

```json
{
  "id_user": "316",
  "id_anuncio": "65",
  "token": "Qd721n2E"
}
```

#### Exemplo - Links de um Tipo Específico

```json
{
  "id_user": "316",
  "id_anuncio": "65",
  "id_type": 43,
  "token": "Qd721n2E"
}
```

#### Exemplo - Links de uma Unidade Específica

```json
{
  "id_user": "316",
  "id_anuncio": "65",
  "id_type": 43,
  "id_unidade": 1,
  "token": "Qd721n2E"
}
```

#### Response

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
      "nome": "Airbnb Suite 431",
      "url": "https://www.airbnb.com.br/calendar/ical/suite431.ics",
      "ultima_sincronizacao": "2025-11-30 12:00:00",
      "status": 1,
      "erros": 0,
      "ultimo_erro": null,
      "data_cadastro": "2025-11-30 10:00:00",
      "nome_type": "Suíte Standard",
      "numero_unidade": 1,
      "nome_unidade": "Suíte 431"
    },
    {
      "id": 6,
      "id_type": 5,
      "nome_type": "Suite Master",
      "nome": "Airbnb - Suite Master",
      "url": "https://www.airbnb.com.br/calendar/ical/99999999.ics",
      "ultima_sincronizacao": "2025-11-30 12:00:00",
      "status": 1,
      "erros": 0,
      "ultimo_erro": null,
      "data_cadastro": "2025-11-30 11:00:00"
    },
    {
      "id": 3,
      "id_type": 6,
      "nome_type": "Quarto Duplo",
      "nome": "Booking - Quarto Duplo",
      "url": "https://admin.booking.com/hotel/hoteladmin/ical.html?t=abc",
      "ultima_sincronizacao": "2025-11-30 12:00:00",
      "status": 1,
      "erros": 0,
      "ultimo_erro": null,
      "data_cadastro": "2025-11-30 11:30:00"
    }
  ]
}
```

---

### 3. Remover Link iCal Externo

```
POST /apiv3/user/anuncios/removerIcalExterno/
Content-Type: application/json
```

#### Payload

```json
{
  "id_user": "334",
  "id_anuncio": "104",
  "id_link": 1,
  "token": "Qd721n2E"
}
```

#### Response

```json
{
  "status": "01",
  "msg": "Link iCal removido com sucesso."
}
```

---

### 4. Listar Bloqueios Importados

```
POST /apiv3/user/anuncios/listarBloqueiosIcal/
Content-Type: application/json
```

#### Payload

| Campo | Tipo | Obrigatório | Descrição |
|-------|------|-------------|-----------|
| `id_user` | string | Sim | ID do usuário |
| `id_anuncio` | string | Sim | ID do anúncio |
| `id_type` | int | **Não** | Filtrar por quarto/tipo (omitir = todos) |
| `token` | string | Sim | Token de autenticação |

#### Exemplo - Todos os Bloqueios

```json
{
  "id_user": "334",
  "id_anuncio": "104",
  "token": "Qd721n2E"
}
```

#### Exemplo - Bloqueios de um Quarto

```json
{
  "id_user": "334",
  "id_anuncio": "104",
  "id_type": 5,
  "token": "Qd721n2E"
}
```

#### Response

```json
{
  "status": "01",
  "id_type": null,
  "total": 3,
  "bloqueios": [
    {
      "id": 1,
      "id_type": null,
      "nome_type": null,
      "data_inicio": "2025-12-20",
      "data_fim": "2025-12-26",
      "resumo": "Reserva - Airbnb",
      "plataforma": "Airbnb",
      "data_importacao": "2025-11-30 12:00:00"
    },
    {
      "id": 2,
      "id_type": 5,
      "nome_type": "Suite Master",
      "data_inicio": "2025-12-28",
      "data_fim": "2026-01-02",
      "resumo": "Blocked",
      "plataforma": "Airbnb - Suite Master",
      "data_importacao": "2025-11-30 12:00:00"
    }
  ]
}
```

---

### 5. Sincronizar Manualmente

Força sincronização imediata dos links iCal externos.

```
POST /apiv3/user/anuncios/sincronizarIcalExterno/
Content-Type: application/json
```

#### Payload

| Campo | Tipo | Obrigatório | Descrição |
|-------|------|-------------|-----------|
| `id_user` | string | Sim | ID do usuário |
| `id_anuncio` | string | Sim | ID do anúncio |
| `id_type` | int | **Não** | Sincronizar apenas links de um quarto/tipo |
| `id_link` | int | **Não** | Sincronizar apenas um link específico |
| `token` | string | Sim | Token de autenticação |

#### Exemplo - Todos os Links

```json
{
  "id_user": "334",
  "id_anuncio": "104",
  "token": "Qd721n2E"
}
```

#### Exemplo - Links de um Quarto

```json
{
  "id_user": "334",
  "id_anuncio": "104",
  "id_type": 5,
  "token": "Qd721n2E"
}
```

#### Exemplo - Link Específico

```json
{
  "id_user": "334",
  "id_anuncio": "104",
  "id_link": 1,
  "token": "Qd721n2E"
}
```

#### Response

```json
{
  "status": "01",
  "msg": "Sincronização concluída",
  "id_type": 5,
  "resultados": [
    {
      "id_link": 2,
      "nome": "Airbnb - Suite Master",
      "sucesso": true,
      "eventos_importados": 5,
      "erro": null
    }
  ]
}
```

---

## Configuração do Cron

O script de sincronização automática deve ser configurado para rodar a cada 6 horas.

### Comando para Crontab

```bash
# Editar crontab
crontab -e

# Adicionar linha (roda a cada 6 horas: 0h, 6h, 12h, 18h)
0 */6 * * * /usr/bin/php /caminho/para/www/apiv3/cron/sincronizar_ical.php >> /var/log/ical_sync.log 2>&1
```

### No MAMP (macOS)

```bash
0 */6 * * * /Applications/MAMP/bin/php/php8.3.14/bin/php /Applications/MAMP/htdocs/www/apiv3/cron/sincronizar_ical.php >> /tmp/ical_sync.log 2>&1
```

### Executar Manualmente

```bash
php /Applications/MAMP/htdocs/www/apiv3/cron/sincronizar_ical.php
```

### Saída do Cron

```
[2025-11-30 12:00:00] ========================================
[2025-11-30 12:00:00] Iniciando sincronização de calendários iCal
[2025-11-30 12:00:00] ========================================
[2025-11-30 12:00:00] Links encontrados: 5
[2025-11-30 12:00:01] Processando: Airbnb (Anúncio: Casa na Praia)
[2025-11-30 12:00:02] ✅ Sucesso! Eventos importados: 3
[2025-11-30 12:00:03] Processando: Booking (Anúncio: Casa na Praia)
[2025-11-30 12:00:04] ✅ Sucesso! Eventos importados: 2
[2025-11-30 12:00:05] ========================================
[2025-11-30 12:00:05] Sincronização concluída!
[2025-11-30 12:00:05] Sucesso: 5 | Erros: 0
[2025-11-30 12:00:05] Total de eventos importados: 12
```

---

## Onde Obter URLs iCal

### Airbnb
1. Acesse o calendário do seu anúncio no Airbnb
2. Clique em "Disponibilidade" → "Sincronizar calendários"
3. Copie o "Link para exportar calendário"

### Booking.com
1. Acesse a extranet do Booking.com
2. Vá em "Calendário" → "Sincronização"
3. Copie o link de exportação iCal

### VRBO/HomeAway
1. Acesse o painel do proprietário
2. Vá em "Calendário" → "Exportar"
3. Copie o link iCal

---

## Changelog

### v3.0.0 (30/11/2025)
- **Importação de iCal externo**: Sincronize calendários de outras plataformas
- Endpoints: `adicionarIcalExterno`, `removerIcalExterno`, `listarIcalExterno`, `listarBloqueiosIcal`, `sincronizarIcalExterno`
- Script de cron para sincronização automática a cada 6 horas
- Tabelas: `app_ical_links`, `app_ical_bloqueios`
- Links com 5+ erros são desativados automaticamente

### v2.2.0 (30/11/2025)
- Adicionados endpoints de admin para iCal
- `getLinkIcal` - Admin pode obter link de qualquer anúncio
- `getTodosLinksIcal` - Admin pode listar todos os links iCal
- `exportarIcal` - Admin pode baixar arquivo .ics de qualquer anúncio

### v2.1.0 (30/11/2025)
- Link iCal agora é restrito ao dono do anúncio
- Novo endpoint `getMeusLinksIcal` para listar todos os links do usuário
- Removido link_ical da listagem pública de anúncios

### v2.0.0 (30/11/2025)
- Link iCal permanente
- Headers anti-cache
- Compatibilidade com Airbnb, Booking, etc.

### v1.0.0 (30/11/2025)
- Implementação inicial
