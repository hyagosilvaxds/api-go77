# API de Exportação de Lista de Compradores

## Descrição
Permite que o dono de um anúncio (evento ou experiência) exporte a lista de pessoas que compraram ingressos. Útil para controle de acesso na portaria do evento.

---

## Endpoints Disponíveis

### 1. Listar Compradores (JSON)

Retorna a lista de compradores em formato JSON para exibição no aplicativo.

**Endpoint:**
```
POST /apiv3/user/anuncios/listarCompradores
```

**Headers:**
```
Content-Type: application/json
```

**Payload de Requisição:**
```json
{
    "token": "Qd721n2E",
    "id_user": 334,
    "id_anuncio": 115
}
```

| Campo | Tipo | Obrigatório | Descrição |
|-------|------|-------------|-----------|
| token | string | Sim | Token de autenticação do app |
| id_user | integer | Sim | ID do usuário dono do anúncio |
| id_anuncio | integer | Sim | ID do anúncio/evento |

**Payload de Resposta - Sucesso:**
```json
{
    "status": "01",
    "anuncio_id": 115,
    "anuncio_nome": "Palestra gratuita",
    "categoria_id": 3,
    "total_compradores": 5,
    "compradores": [
        {
            "reserva_id": 21,
            "ingresso_id": 9,
            "nome": "Carlos Silva",
            "email": "carlos@email.com",
            "celular": "38999999999",
            "tipo_ingresso": "Ingresso VIP",
            "valor_ingresso": "150.00",
            "data_compra": "2025-12-11 11:07:29",
            "data_evento_de": "2025-12-20",
            "data_evento_ate": "2025-12-20",
            "status_reserva": 1,
            "status_reserva_texto": "Confirmada",
            "status_pagamento": "CONFIRMED",
            "tipo_pagamento": "PIX",
            "qrcode": "Z4kG7VgOVjx6+jEpVn6L8j52u5s0L1Se...",
            "checkin_realizado": "Não"
        }
    ]
}
```

**Payload de Resposta - Erro (Sem permissão):**
```json
{
    "status": "00",
    "msg": "Anúncio não encontrado ou você não tem permissão para acessar"
}
```

**Payload de Resposta - Erro (Parâmetros faltando):**
```json
{
    "status": "00",
    "msg": "Parâmetros obrigatórios: id_user, id_anuncio"
}
```

---

### 2. Gerar Link de Exportação CSV

Gera e retorna a URL para download do arquivo CSV.

**Endpoint:**
```
POST /apiv3/user/anuncios/gerarLinkExportacao
```

**Headers:**
```
Content-Type: application/json
```

**Payload de Requisição:**
```json
{
    "token": "Qd721n2E",
    "id_user": 334,
    "id_anuncio": 115
}
```

| Campo | Tipo | Obrigatório | Descrição |
|-------|------|-------------|-----------|
| token | string | Sim | Token de autenticação do app |
| id_user | integer | Sim | ID do usuário dono do anúncio |
| id_anuncio | integer | Sim | ID do anúncio/evento |

**Payload de Resposta - Sucesso:**
```json
{
    "status": "01",
    "msg": "Link de exportação gerado com sucesso",
    "anuncio_nome": "Palestra gratuita",
    "total_compradores": 5,
    "url_download": "http://api.go77app.com/apiv3/user/anuncios/exportarCompradoresCsv?token=Qd721n2E&id_user=334&id_anuncio=115"
}
```

**Payload de Resposta - Erro:**
```json
{
    "status": "00",
    "msg": "Anúncio não encontrado ou você não tem permissão para acessar"
}
```

---

### 3. Download do CSV

Faz o download direto do arquivo CSV. Use a URL retornada pelo endpoint anterior.

**Endpoint:**
```
GET /apiv3/user/anuncios/exportarCompradoresCsv
```

**Query Parameters:**
```
?token=Qd721n2E&id_user=334&id_anuncio=115
```

| Parâmetro | Tipo | Obrigatório | Descrição |
|-----------|------|-------------|-----------|
| token | string | Sim | Token de autenticação do app |
| id_user | integer | Sim | ID do usuário dono do anúncio |
| id_anuncio | integer | Sim | ID do anúncio/evento |

**Resposta - Sucesso:**
- Content-Type: `text/csv; charset=utf-8`
- Content-Disposition: `attachment; filename="compradores_Palestra_gratuita_2025-12-11_13-29.csv"`

**Conteúdo do CSV:**
```csv
Nº;Nome;Email;Celular;Tipo Ingresso;Valor (R$);Data Compra;Data Evento;Status Pagamento;Tipo Pagamento;Check-in Realizado;ID Reserva;ID Ingresso
1;Carlos Silva;carlos@email.com;38999999999;Ingresso VIP;150,00;11/12/2025;20/12/2025;CONFIRMED;PIX;Não;21;9
2;Maria Santos;maria@email.com;31988888888;Ingresso Pista;80,00;10/12/2025;20/12/2025;CONFIRMED;Cartão;Sim;20;10

RESUMO
Evento/Experiência:;Palestra gratuita
Total de Ingressos:;5
Data de Exportação:;11/12/2025 13:29:33
```

**Resposta - Erro:**
```json
{
    "status": "00",
    "msg": "Anúncio não encontrado ou você não tem permissão para acessar"
}
```

---

## Campos do Comprador

| Campo | Tipo | Descrição |
|-------|------|-----------|
| reserva_id | integer | ID único da reserva |
| ingresso_id | integer | ID único do ingresso no carrinho |
| nome | string | Nome do comprador |
| email | string | Email do comprador |
| celular | string | Celular do comprador |
| tipo_ingresso | string | Nome do tipo de ingresso (VIP, Pista, etc) |
| valor_ingresso | decimal | Valor pago pelo ingresso |
| data_compra | datetime | Data e hora da compra |
| data_evento_de | date | Data de início do evento (pode ser null) |
| data_evento_ate | date | Data de fim do evento (pode ser null) |
| status_reserva | integer | Status numérico (1=Confirmada, 2=Pendente, 3=Cancelada) |
| status_reserva_texto | string | Status por extenso |
| status_pagamento | string | Status do pagamento (CONFIRMED, PENDING, etc) |
| tipo_pagamento | string | Forma de pagamento (Cartão, PIX, Cortesia) |
| qrcode | string | QR Code criptografado do ingresso |
| checkin_realizado | string | "Sim" ou "Não" |

---

## Status de Reserva

| Código | Descrição |
|--------|-----------|
| 1 | Confirmada |
| 2 | Pendente |
| 3 | Cancelada |

---

## Tipos de Pagamento

| Código | Descrição |
|--------|-----------|
| 1 | Cartão de Crédito |
| 2 | Dinheiro |
| 3 | PIX |
| 4 | Cortesia |

---

## Exemplo de Uso no Flutter

### Listar Compradores
```dart
Future<Map<String, dynamic>> listarCompradores(int idAnuncio) async {
  final response = await http.post(
    Uri.parse('$baseUrl/anuncios/listarCompradores'),
    headers: {'Content-Type': 'application/json'},
    body: jsonEncode({
      'token': token,
      'id_user': userId,
      'id_anuncio': idAnuncio,
    }),
  );
  
  return jsonDecode(response.body);
}
```

### Gerar Link e Abrir Download
```dart
Future<void> exportarCSV(int idAnuncio) async {
  final response = await http.post(
    Uri.parse('$baseUrl/anuncios/gerarLinkExportacao'),
    headers: {'Content-Type': 'application/json'},
    body: jsonEncode({
      'token': token,
      'id_user': userId,
      'id_anuncio': idAnuncio,
    }),
  );
  
  final data = jsonDecode(response.body);
  
  if (data['status'] == '01') {
    // Abrir URL no navegador para download
    final url = data['url_download'];
    if (await canLaunchUrl(Uri.parse(url))) {
      await launchUrl(Uri.parse(url), mode: LaunchMode.externalApplication);
    }
  } else {
    // Tratar erro
    showError(data['msg']);
  }
}
```

### Download Direto com Compartilhamento
```dart
Future<void> compartilharCSV(int idAnuncio) async {
  // Primeiro gera o link
  final response = await http.post(
    Uri.parse('$baseUrl/anuncios/gerarLinkExportacao'),
    headers: {'Content-Type': 'application/json'},
    body: jsonEncode({
      'token': token,
      'id_user': userId,
      'id_anuncio': idAnuncio,
    }),
  );
  
  final data = jsonDecode(response.body);
  
  if (data['status'] == '01') {
    // Baixar o arquivo
    final csvResponse = await http.get(Uri.parse(data['url_download']));
    
    // Salvar temporariamente
    final directory = await getTemporaryDirectory();
    final file = File('${directory.path}/compradores_${idAnuncio}.csv');
    await file.writeAsBytes(csvResponse.bodyBytes);
    
    // Compartilhar
    await Share.shareXFiles([XFile(file.path)], text: 'Lista de compradores');
  }
}
```

---

## Notas Importantes

1. **Segurança**: Apenas o dono do anúncio pode acessar a lista de compradores.

2. **Dados Criptografados**: Os dados pessoais (nome, email, celular) são armazenados criptografados no banco e descriptografados apenas no momento da exportação.

3. **Formato CSV**: O arquivo usa ponto-e-vírgula (;) como separador, compatível com Excel em português.

4. **Codificação**: O arquivo CSV é gerado em UTF-8 com BOM para correta exibição de acentos no Excel.

5. **Filtros Recomendados**: A listagem inclui reservas com status 1 (Confirmada) e 2 (Pendente). Reservas canceladas não são incluídas.

---

## Changelog

| Data | Versão | Descrição |
|------|--------|-----------|
| 11/12/2025 | 1.0.0 | Implementação inicial da exportação de compradores |
