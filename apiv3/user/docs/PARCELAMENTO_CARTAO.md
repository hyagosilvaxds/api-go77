# API de Pagamentos Parcelados - Cartão de Crédito

## Descrição
Permite realizar compras parceladas no cartão de crédito. Suporta parcelamento de 2 a 12 parcelas (ou até 21x para cartões Visa/Master). Pagamentos à vista continuam funcionando normalmente.

---

## Endpoints Disponíveis

### 1. Iniciar Reserva/Pagamento (Com Parcelamento)

Endpoint principal para realizar compras, agora com suporte a parcelamento.

**Endpoint:**
```
POST /apiv3/user/reservas/iniciar
```

**Headers:**
```
Content-Type: application/json
```

**Payload de Requisição - Compra Parcelada:**
```json
{
    "token": "Qd721n2E",
    "id_user": 334,
    "id_anuncio": 115,
    "id_anuncio_type": 9,
    "id_carrinho": 45,
    "id_categoria": 3,
    "tipo_pagamento": 1,
    "cartao_id": 12,
    "valor": 300.00,
    "parcelas": 3,
    "adultos": 2,
    "criancas": 0,
    "data_de": "20/12/2025",
    "data_ate": "20/12/2025",
    "obs": ""
}
```

**Payload de Requisição - Compra à Vista:**
```json
{
    "token": "Qd721n2E",
    "id_user": 334,
    "id_anuncio": 115,
    "id_anuncio_type": 9,
    "id_carrinho": 45,
    "id_categoria": 3,
    "tipo_pagamento": 1,
    "cartao_id": 12,
    "valor": 300.00,
    "adultos": 2,
    "criancas": 0,
    "data_de": "20/12/2025",
    "data_ate": "20/12/2025",
    "obs": ""
}
```

> **Nota**: Para compras à vista, basta omitir o campo `parcelas` ou enviar `parcelas: 1`

---

## Parâmetros da Requisição

| Campo | Tipo | Obrigatório | Descrição |
|-------|------|-------------|-----------|
| token | string | Sim | Token de autenticação do app |
| id_user | integer | Sim | ID do usuário comprador |
| id_anuncio | integer | Sim | ID do anúncio/evento |
| id_anuncio_type | integer | Sim* | ID do tipo de ingresso (*opcional para cortesia) |
| id_carrinho | integer | Sim | ID do carrinho de compras |
| id_categoria | integer | Sim | Categoria: 1=Imóveis, 3=Eventos |
| tipo_pagamento | integer | Sim | 1=Cartão, 3=PIX, 4=Cortesia |
| cartao_id | integer | Condicional | ID do cartão salvo (obrigatório quando tipo_pagamento=1) |
| valor | decimal | Sim | Valor total da compra em reais |
| **parcelas** | integer | **Não** | **Número de parcelas (1-12). Padrão: 1** |
| adultos | integer | Sim* | Quantidade de adultos |
| criancas | integer | Sim* | Quantidade de crianças |
| data_de | string | Sim* | Data início no formato DD/MM/YYYY |
| data_ate | string | Sim* | Data fim no formato DD/MM/YYYY |
| obs | string | Não | Observações adicionais |
| codigo_cupom | string | Não | Código do cupom de desconto (se houver) |

---

## Respostas da API

### Sucesso - Pagamento Aprovado
```json
{
    "status": "01",
    "msg": "Reserva efetuada com sucesso.",
    "id": 45,
    "id_reserva": 123,
    "parcelas": 3,
    "valor_parcela": 100.00
}
```

| Campo | Tipo | Descrição |
|-------|------|-----------|
| status | string | "01" indica sucesso |
| msg | string | Mensagem de confirmação |
| id | integer | ID do pagamento criado |
| id_reserva | integer | ID da reserva criada |
| parcelas | integer | Número de parcelas processadas |
| valor_parcela | decimal | Valor de cada parcela |

### Sucesso - Pagamento à Vista
```json
{
    "status": "01",
    "msg": "Reserva efetuada com sucesso.",
    "id": 45,
    "id_reserva": 123,
    "parcelas": 1,
    "valor_parcela": 300.00
}
```

### Erro - Cartão Recusado
```json
{
    "status": "02",
    "msg": "Transação não autorizada. Verifique os dados do cartão de crédito e tente novamente."
}
```

### Erro - Cartão Não Encontrado
```json
{
    "status": "02",
    "msg": "Cartão não encontrado."
}
```

### Erro - Saldo Insuficiente
```json
{
    "status": "02",
    "msg": "Limite de crédito insuficiente."
}
```

### Erro - Valor Mínimo
```json
{
    "status": "02",
    "msg": "O valor mínimo por parcela é de R$ 5,00."
}
```

---

## Regras de Parcelamento

### Limites
| Bandeira | Parcelas Máximas |
|----------|------------------|
| Visa | 21x |
| Mastercard | 21x |
| Outras bandeiras | 12x |

> **Nota**: A API limita automaticamente a 12 parcelas por segurança. Para habilitar até 21x, solicite ajuste no backend.

### Validações Automáticas

```
1. Se parcelas < 1 → Define como 1 (à vista)
2. Se parcelas > 12 → Limita a 12 parcelas
3. Valor mínimo por parcela: R$ 5,00 (regra do Asaas)
```

### Cálculo do Valor da Parcela

O valor da parcela é calculado automaticamente:
```
valor_parcela = valor_total / numero_parcelas
```

Quando a divisão não é exata, o Asaas ajusta a última parcela:
```
Exemplo: R$ 100,00 em 3x
- Parcelas 1 e 2: R$ 33,33
- Parcela 3: R$ 33,34
- Total: R$ 100,00
```

---

## Tipos de Pagamento Suportados

| Código | Tipo | Suporta Parcelamento |
|--------|------|---------------------|
| 1 | Cartão de Crédito | ✅ Sim (2-12x) |
| 3 | PIX | ❌ Não |
| 4 | Cortesia | ❌ Não |

---

## Exemplos de Uso no Flutter

### Service de Pagamento
```dart
import 'dart:convert';
import 'package:http/http.dart' as http;

class PagamentoService {
  final String baseUrl = 'https://api.go77app.com/apiv3/user';
  final String token;
  final int userId;

  PagamentoService({required this.token, required this.userId});

  /// Realiza pagamento à vista
  Future<Map<String, dynamic>> pagarAVista({
    required int idAnuncio,
    required int idAnuncioType,
    required int idCarrinho,
    required int idCategoria,
    required int cartaoId,
    required double valor,
    required int adultos,
    required int criancas,
    required String dataInicio,
    required String dataFim,
    String obs = '',
  }) async {
    return await _realizarPagamento(
      idAnuncio: idAnuncio,
      idAnuncioType: idAnuncioType,
      idCarrinho: idCarrinho,
      idCategoria: idCategoria,
      cartaoId: cartaoId,
      valor: valor,
      parcelas: 1, // À vista
      adultos: adultos,
      criancas: criancas,
      dataInicio: dataInicio,
      dataFim: dataFim,
      obs: obs,
    );
  }

  /// Realiza pagamento parcelado
  Future<Map<String, dynamic>> pagarParcelado({
    required int idAnuncio,
    required int idAnuncioType,
    required int idCarrinho,
    required int idCategoria,
    required int cartaoId,
    required double valor,
    required int parcelas,
    required int adultos,
    required int criancas,
    required String dataInicio,
    required String dataFim,
    String obs = '',
  }) async {
    // Validação no cliente
    if (parcelas < 2 || parcelas > 12) {
      throw Exception('Número de parcelas deve ser entre 2 e 12');
    }
    
    double valorParcela = valor / parcelas;
    if (valorParcela < 5.0) {
      throw Exception('Valor mínimo por parcela é R\$ 5,00');
    }

    return await _realizarPagamento(
      idAnuncio: idAnuncio,
      idAnuncioType: idAnuncioType,
      idCarrinho: idCarrinho,
      idCategoria: idCategoria,
      cartaoId: cartaoId,
      valor: valor,
      parcelas: parcelas,
      adultos: adultos,
      criancas: criancas,
      dataInicio: dataInicio,
      dataFim: dataFim,
      obs: obs,
    );
  }

  Future<Map<String, dynamic>> _realizarPagamento({
    required int idAnuncio,
    required int idAnuncioType,
    required int idCarrinho,
    required int idCategoria,
    required int cartaoId,
    required double valor,
    required int parcelas,
    required int adultos,
    required int criancas,
    required String dataInicio,
    required String dataFim,
    required String obs,
  }) async {
    final response = await http.post(
      Uri.parse('$baseUrl/reservas/iniciar'),
      headers: {'Content-Type': 'application/json'},
      body: jsonEncode({
        'token': token,
        'id_user': userId,
        'id_anuncio': idAnuncio,
        'id_anuncio_type': idAnuncioType,
        'id_carrinho': idCarrinho,
        'id_categoria': idCategoria,
        'tipo_pagamento': 1, // Cartão de crédito
        'cartao_id': cartaoId,
        'valor': valor,
        'parcelas': parcelas,
        'adultos': adultos,
        'criancas': criancas,
        'data_de': dataInicio,
        'data_ate': dataFim,
        'obs': obs,
      }),
    );

    final data = jsonDecode(response.body);
    
    if (data is List && data.isNotEmpty) {
      return data[0];
    }
    return data;
  }
}
```

### Widget de Seleção de Parcelas
```dart
import 'package:flutter/material.dart';

class SeletorParcelas extends StatefulWidget {
  final double valorTotal;
  final Function(int parcelas, double valorParcela) onChanged;
  final int maxParcelas;
  final double valorMinimoParcela;

  const SeletorParcelas({
    Key? key,
    required this.valorTotal,
    required this.onChanged,
    this.maxParcelas = 12,
    this.valorMinimoParcela = 5.0,
  }) : super(key: key);

  @override
  State<SeletorParcelas> createState() => _SeletorParcelasState();
}

class _SeletorParcelasState extends State<SeletorParcelas> {
  int _parcelasSelecionadas = 1;

  int get _maxParcelasDisponiveis {
    int max = widget.maxParcelas;
    // Limita baseado no valor mínimo por parcela
    int maxPorValor = (widget.valorTotal / widget.valorMinimoParcela).floor();
    return max < maxPorValor ? max : maxPorValor;
  }

  List<DropdownMenuItem<int>> _buildOpcoes() {
    List<DropdownMenuItem<int>> opcoes = [];
    
    for (int i = 1; i <= _maxParcelasDisponiveis; i++) {
      double valorParcela = widget.valorTotal / i;
      String texto;
      
      if (i == 1) {
        texto = 'À vista - R\$ ${valorParcela.toStringAsFixed(2)}';
      } else {
        texto = '${i}x de R\$ ${valorParcela.toStringAsFixed(2)} sem juros';
      }
      
      opcoes.add(DropdownMenuItem(
        value: i,
        child: Text(texto),
      ));
    }
    
    return opcoes;
  }

  @override
  Widget build(BuildContext context) {
    return Column(
      crossAxisAlignment: CrossAxisAlignment.start,
      children: [
        Text(
          'Forma de Pagamento',
          style: TextStyle(
            fontSize: 14,
            fontWeight: FontWeight.w500,
            color: Colors.grey[700],
          ),
        ),
        SizedBox(height: 8),
        Container(
          padding: EdgeInsets.symmetric(horizontal: 12),
          decoration: BoxDecoration(
            border: Border.all(color: Colors.grey[300]!),
            borderRadius: BorderRadius.circular(8),
          ),
          child: DropdownButtonHideUnderline(
            child: DropdownButton<int>(
              isExpanded: true,
              value: _parcelasSelecionadas,
              items: _buildOpcoes(),
              onChanged: (value) {
                setState(() {
                  _parcelasSelecionadas = value ?? 1;
                });
                double valorParcela = widget.valorTotal / _parcelasSelecionadas;
                widget.onChanged(_parcelasSelecionadas, valorParcela);
              },
            ),
          ),
        ),
        if (_parcelasSelecionadas > 1) ...[
          SizedBox(height: 8),
          Text(
            'Total: R\$ ${widget.valorTotal.toStringAsFixed(2)} em ${_parcelasSelecionadas}x',
            style: TextStyle(
              fontSize: 12,
              color: Colors.grey[600],
            ),
          ),
        ],
      ],
    );
  }
}
```

### Exemplo de Tela de Checkout
```dart
import 'package:flutter/material.dart';

class CheckoutScreen extends StatefulWidget {
  final double valorTotal;
  final int idAnuncio;
  final int idAnuncioType;
  final int idCarrinho;
  final int cartaoId;

  const CheckoutScreen({
    Key? key,
    required this.valorTotal,
    required this.idAnuncio,
    required this.idAnuncioType,
    required this.idCarrinho,
    required this.cartaoId,
  }) : super(key: key);

  @override
  State<CheckoutScreen> createState() => _CheckoutScreenState();
}

class _CheckoutScreenState extends State<CheckoutScreen> {
  int _parcelas = 1;
  double _valorParcela = 0;
  bool _loading = false;

  @override
  void initState() {
    super.initState();
    _valorParcela = widget.valorTotal;
  }

  Future<void> _finalizarCompra() async {
    setState(() => _loading = true);

    try {
      final pagamentoService = PagamentoService(
        token: 'SEU_TOKEN',
        userId: 334,
      );

      Map<String, dynamic> resultado;

      if (_parcelas == 1) {
        resultado = await pagamentoService.pagarAVista(
          idAnuncio: widget.idAnuncio,
          idAnuncioType: widget.idAnuncioType,
          idCarrinho: widget.idCarrinho,
          idCategoria: 3,
          cartaoId: widget.cartaoId,
          valor: widget.valorTotal,
          adultos: 1,
          criancas: 0,
          dataInicio: '20/12/2025',
          dataFim: '20/12/2025',
        );
      } else {
        resultado = await pagamentoService.pagarParcelado(
          idAnuncio: widget.idAnuncio,
          idAnuncioType: widget.idAnuncioType,
          idCarrinho: widget.idCarrinho,
          idCategoria: 3,
          cartaoId: widget.cartaoId,
          valor: widget.valorTotal,
          parcelas: _parcelas,
          adultos: 1,
          criancas: 0,
          dataInicio: '20/12/2025',
          dataFim: '20/12/2025',
        );
      }

      if (resultado['status'] == '01') {
        // Sucesso
        ScaffoldMessenger.of(context).showSnackBar(
          SnackBar(
            content: Text('Pagamento aprovado! ${_parcelas}x de R\$ ${_valorParcela.toStringAsFixed(2)}'),
            backgroundColor: Colors.green,
          ),
        );
        Navigator.pop(context, true);
      } else {
        // Erro
        ScaffoldMessenger.of(context).showSnackBar(
          SnackBar(
            content: Text(resultado['msg'] ?? 'Erro ao processar pagamento'),
            backgroundColor: Colors.red,
          ),
        );
      }
    } catch (e) {
      ScaffoldMessenger.of(context).showSnackBar(
        SnackBar(
          content: Text('Erro: $e'),
          backgroundColor: Colors.red,
        ),
      );
    } finally {
      setState(() => _loading = false);
    }
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      appBar: AppBar(title: Text('Finalizar Compra')),
      body: Padding(
        padding: EdgeInsets.all(16),
        child: Column(
          crossAxisAlignment: CrossAxisAlignment.stretch,
          children: [
            Card(
              child: Padding(
                padding: EdgeInsets.all(16),
                child: Column(
                  crossAxisAlignment: CrossAxisAlignment.start,
                  children: [
                    Text(
                      'Resumo do Pedido',
                      style: TextStyle(
                        fontSize: 18,
                        fontWeight: FontWeight.bold,
                      ),
                    ),
                    SizedBox(height: 16),
                    Row(
                      mainAxisAlignment: MainAxisAlignment.spaceBetween,
                      children: [
                        Text('Valor Total:'),
                        Text(
                          'R\$ ${widget.valorTotal.toStringAsFixed(2)}',
                          style: TextStyle(
                            fontSize: 20,
                            fontWeight: FontWeight.bold,
                            color: Colors.green[700],
                          ),
                        ),
                      ],
                    ),
                  ],
                ),
              ),
            ),
            SizedBox(height: 24),
            SeletorParcelas(
              valorTotal: widget.valorTotal,
              onChanged: (parcelas, valorParcela) {
                setState(() {
                  _parcelas = parcelas;
                  _valorParcela = valorParcela;
                });
              },
            ),
            Spacer(),
            ElevatedButton(
              onPressed: _loading ? null : _finalizarCompra,
              style: ElevatedButton.styleFrom(
                padding: EdgeInsets.symmetric(vertical: 16),
                backgroundColor: Colors.green,
              ),
              child: _loading
                  ? CircularProgressIndicator(color: Colors.white)
                  : Text(
                      _parcelas == 1
                          ? 'Pagar R\$ ${widget.valorTotal.toStringAsFixed(2)}'
                          : 'Pagar ${_parcelas}x de R\$ ${_valorParcela.toStringAsFixed(2)}',
                      style: TextStyle(fontSize: 16, color: Colors.white),
                    ),
            ),
          ],
        ),
      ),
    );
  }
}
```

---

## Dados Armazenados

### Tabela `app_pagamentos`

| Campo | Tipo | Descrição |
|-------|------|-----------|
| id | INT | ID do pagamento |
| app_users_id | INT | ID do usuário |
| app_anuncios_id | INT | ID do anúncio |
| tipo_pagamento | INT | 1=Cartão, 3=PIX, 4=Cortesia |
| valor_final | DECIMAL(10,2) | Valor total da compra |
| valor_anunciante | DECIMAL(10,2) | Valor a receber pelo anunciante |
| valor_admin | DECIMAL(10,2) | Taxa administrativa |
| **parcelas** | INT | Número de parcelas (default: 1) |
| **valor_parcela** | DECIMAL(10,2) | Valor de cada parcela |
| **installment_id** | VARCHAR(100) | ID do parcelamento no Asaas |
| cartao_id | VARCHAR(50) | ID do cartão utilizado |
| token | TEXT | Token do pagamento no Asaas |
| status | VARCHAR(20) | CONFIRMED, PENDING, etc |
| data | DATETIME | Data/hora do pagamento |

---

## Notas Importantes

1. **Parcelamento exclusivo para cartão de crédito** - Apenas `tipo_pagamento: 1` aceita parcelamento

2. **PIX e Cortesia ignoram o campo parcelas** - Sempre processados como pagamento único

3. **Valor mínimo por parcela** - O Asaas exige mínimo de R$ 5,00 por parcela

4. **Sem juros** - O parcelamento é sem juros para o cliente. Taxas do Asaas são cobradas do vendedor

5. **Divisão automática** - Quando o valor não divide exatamente, a última parcela é ajustada

6. **Compatibilidade retroativa** - Chamadas antigas sem o campo `parcelas` continuam funcionando como à vista

---

## Códigos de Erro Comuns

| Código | Mensagem | Causa |
|--------|----------|-------|
| 02 | Cartão não encontrado | cartao_id inválido ou não pertence ao usuário |
| 02 | Transação não autorizada | Cartão recusado pela operadora |
| 02 | Limite insuficiente | Sem limite disponível no cartão |
| 02 | Cartão vencido | Cartão expirado |
| 02 | CVV inválido | Código de segurança incorreto |

---

## Referências

- [Documentação Asaas - Cobrança Parcelada](https://docs.asaas.com/docs/criar-uma-cobranca-parcelada)
- [Referência API Asaas - Payments](https://docs.asaas.com/reference/criar-nova-cobranca)

---

## Changelog

| Data | Versão | Descrição |
|------|--------|-----------|
| 11/12/2025 | 1.0.0 | Implementação inicial do parcelamento no cartão de crédito |
