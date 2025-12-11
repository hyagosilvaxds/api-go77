# API de Croqui de Eventos - GO77 Destinos

## Visão Geral

Esta documentação descreve os endpoints para gerenciamento de **croqui** (planta/mapa do local) em anúncios do tipo **Evento** (categoria 3).

O croqui é uma imagem que mostra a disposição do local do evento, como áreas VIP, palco, banheiros, saídas de emergência, etc.

---

## Sumário

1. [Adicionar Croqui](#1-adicionar-croqui)
2. [Obter Croqui](#2-obter-croqui)
3. [Remover Croqui](#3-remover-croqui)
4. [Croqui na Listagem de Anúncios](#4-croqui-na-listagem-de-anúncios)

---

## Base URL

```
http://localhost:8888/www/apiv3/user/anuncios/
```

Para produção:
```
https://api.go77app.com/apiv3/user/anuncios/
```

---

## 1. Adicionar Croqui

Adiciona ou atualiza o croqui de um anúncio de evento.

### Endpoint

```
POST /anuncios/adicionarCroqui/
```

### Content-Type

```
multipart/form-data
```

### Parâmetros (Form Data)

| Campo | Tipo | Obrigatório | Descrição |
|-------|------|-------------|-----------|
| id_anuncio | integer | Sim | ID do anúncio (deve ser do tipo Evento) |
| id_user | integer | Sim | ID do usuário (deve ser o dono do anúncio) |
| token | string | Sim | Token de autenticação da API |
| croqui | file | Sim | Arquivo de imagem (jpg, png, gif, webp) |

### Exemplo de Requisição

```bash
curl -X POST http://localhost:8888/www/apiv3/user/anuncios/adicionarCroqui/ \
  -F "id_anuncio=102" \
  -F "id_user=303" \
  -F "token=Qd721n2E" \
  -F "croqui=@/caminho/para/croqui.png"
```

### Resposta de Sucesso

```json
{
    "status": "01",
    "msg": "Croqui adicionado com sucesso",
    "croqui": "croqui_102_1764592495.png",
    "url": "http://localhost:8888/www/uploads/anuncios/croqui/croqui_102_1764592495.png"
}
```

### Erros Possíveis

| Status | Mensagem | Causa |
|--------|----------|-------|
| 00 | Parâmetros obrigatórios: id_anuncio, id_user | Faltam parâmetros |
| 00 | Anúncio não encontrado | ID do anúncio não existe |
| 00 | Você não tem permissão para editar este anúncio | Usuário não é o dono |
| 00 | Croqui só pode ser adicionado a anúncios do tipo Evento | Anúncio não é evento (categoria 3) |
| 00 | Arquivo de croqui não enviado ou inválido | Arquivo não foi enviado |
| 00 | Extensão não permitida | Extensão do arquivo não é jpg, png, gif ou webp |

### Exemplo Flutter/Dart

```dart
import 'package:http/http.dart' as http;

Future<Map<String, dynamic>> adicionarCroqui({
  required int idAnuncio,
  required int idUser,
  required String token,
  required File imagemCroqui,
}) async {
  var request = http.MultipartRequest(
    'POST',
    Uri.parse('https://api.go77app.com/apiv3/user/anuncios/adicionarCroqui/'),
  );

  request.fields['id_anuncio'] = idAnuncio.toString();
  request.fields['id_user'] = idUser.toString();
  request.fields['token'] = token;

  request.files.add(await http.MultipartFile.fromPath(
    'croqui',
    imagemCroqui.path,
  ));

  var response = await request.send();
  var responseBody = await response.stream.bytesToString();
  return json.decode(responseBody);
}
```

---

## 2. Obter Croqui

Retorna as informações do croqui de um anúncio.

### Endpoint

```
POST /anuncios/obterCroqui/
```

### Headers

```
Content-Type: application/json
```

### Parâmetros (Body JSON)

| Campo | Tipo | Obrigatório | Descrição |
|-------|------|-------------|-----------|
| id_anuncio | integer | Sim | ID do anúncio |
| token | string | Sim | Token de autenticação da API |

### Exemplo de Requisição

```bash
curl -X POST http://localhost:8888/www/apiv3/user/anuncios/obterCroqui/ \
  -H "Content-Type: application/json" \
  -d '{
    "id_anuncio": "102",
    "token": "Qd721n2E"
  }'
```

### Resposta - Com Croqui

```json
{
    "status": "01",
    "tem_croqui": true,
    "croqui": "croqui_102_1764592495.png",
    "url": "http://localhost:8888/www/uploads/anuncios/croqui/croqui_102_1764592495.png"
}
```

### Resposta - Sem Croqui

```json
{
    "status": "01",
    "tem_croqui": false,
    "croqui": null,
    "url": null
}
```

---

## 3. Remover Croqui

Remove o croqui de um anúncio de evento.

### Endpoint

```
POST /anuncios/removerCroqui/
```

### Headers

```
Content-Type: application/json
```

### Parâmetros (Body JSON)

| Campo | Tipo | Obrigatório | Descrição |
|-------|------|-------------|-----------|
| id_anuncio | integer | Sim | ID do anúncio |
| id_user | integer | Sim | ID do usuário (deve ser o dono do anúncio) |
| token | string | Sim | Token de autenticação da API |

### Exemplo de Requisição

```bash
curl -X POST http://localhost:8888/www/apiv3/user/anuncios/removerCroqui/ \
  -H "Content-Type: application/json" \
  -d '{
    "id_anuncio": "102",
    "id_user": "303",
    "token": "Qd721n2E"
  }'
```

### Resposta de Sucesso

```json
{
    "status": "01",
    "msg": "Croqui removido com sucesso"
}
```

### Erros Possíveis

| Status | Mensagem | Causa |
|--------|----------|-------|
| 00 | Parâmetros obrigatórios: id_anuncio, id_user | Faltam parâmetros |
| 00 | Anúncio não encontrado | ID do anúncio não existe |
| 00 | Você não tem permissão para editar este anúncio | Usuário não é o dono |
| 00 | Este anúncio não possui croqui | Não há croqui para remover |

---

## 4. Croqui na Listagem de Anúncios

Quando o anúncio é do tipo **Evento** (categoria 3), os endpoints de listagem incluem automaticamente os campos de croqui.

### Endpoints que Retornam Croqui

- `POST /anuncios/lista/` - Detalhes de um anúncio específico
- `POST /anuncios/listaFilter/` - Listagem filtrada

### Campos Adicionados

Para anúncios da categoria 3 (Eventos), os seguintes campos são incluídos:

| Campo | Tipo | Descrição |
|-------|------|-----------|
| croqui | string/null | Nome do arquivo do croqui |
| croqui_url | string/null | URL completa para acessar a imagem |

### Exemplo de Resposta

```json
{
    "id": 102,
    "id_user": 303,
    "id_categoria": 3,
    "nome_categoria": "Eventos",
    "nome": "Show do Artista",
    "descricao": "Descrição do evento",
    "data_in": "30/10/2025",
    "data_out": "30/10/2025",
    "croqui": "croqui_102_1764592495.png",
    "croqui_url": "http://localhost:8888/www/uploads/anuncios/croqui/croqui_102_1764592495.png",
    "ingressos": [...],
    ...
}
```

---

## Fluxo de Uso

```
┌─────────────────────────────────────────────────────────────────┐
│                    FLUXO DE GERENCIAMENTO DE CROQUI              │
├─────────────────────────────────────────────────────────────────┤
│                                                                   │
│  1. Criar anúncio do tipo Evento                                 │
│     ┌─────────────────────────────────────────────────────┐      │
│     │ POST /anuncios/adicionar/                           │      │
│     │ Body: { id_categoria: 3, ... }                      │      │
│     └─────────────────────────────────────────────────────┘      │
│                              │                                    │
│                              ▼                                    │
│  2. Adicionar croqui (imagem do local)                           │
│     ┌─────────────────────────────────────────────────────┐      │
│     │ POST /anuncios/adicionarCroqui/                     │      │
│     │ Form: id_anuncio, id_user, token, croqui (file)     │      │
│     └─────────────────────────────────────────────────────┘      │
│                              │                                    │
│                              ▼                                    │
│  3. O croqui aparece nos detalhes do evento                      │
│     ┌─────────────────────────────────────────────────────┐      │
│     │ "croqui": "croqui_102.png",                         │      │
│     │ "croqui_url": "http://.../croqui/croqui_102.png"    │      │
│     └─────────────────────────────────────────────────────┘      │
│                              │                                    │
│                              ▼                                    │
│  4. Para atualizar: enviar novo arquivo                          │
│     (o antigo é removido automaticamente)                        │
│                              │                                    │
│                              ▼                                    │
│  5. Para remover:                                                │
│     ┌─────────────────────────────────────────────────────┐      │
│     │ POST /anuncios/removerCroqui/                       │      │
│     │ Body: { id_anuncio, id_user, token }                │      │
│     └─────────────────────────────────────────────────────┘      │
│                                                                   │
└─────────────────────────────────────────────────────────────────┘
```

---

## Notas Importantes

### Armazenamento

- Os arquivos são salvos em: `/uploads/anuncios/croqui/`
- Nome do arquivo: `croqui_{id_anuncio}_{timestamp}.{extensao}`
- Extensões permitidas: jpg, jpeg, png, gif, webp

### Permissões

- Apenas o **dono do anúncio** pode adicionar/remover croqui
- Qualquer usuário autenticado pode **visualizar** o croqui

### Substituição

- Ao adicionar um novo croqui, o anterior é **automaticamente removido**
- Não há necessidade de chamar `removerCroqui` antes de atualizar

### Categoria

- Croqui só pode ser adicionado a anúncios da **categoria 3** (Eventos)
- Para outras categorias, o endpoint retorna erro

---

## Histórico de Alterações

| Data | Versão | Descrição |
|------|--------|-----------|
| 30/11/2025 | 1.0.0 | Criação inicial da API de croqui |

---

## Suporte

Para dúvidas ou problemas:
- Email: suporte@go77app.com
