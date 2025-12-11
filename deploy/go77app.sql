-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:8889
-- Tempo de geração: 11/12/2025 às 17:50
-- Versão do servidor: 8.0.40
-- Versão do PHP: 8.3.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `go77app`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `app_anuncios`
--

CREATE TABLE `app_anuncios` (
  `id` int NOT NULL,
  `app_users_id` int NOT NULL,
  `app_categorias_id` int NOT NULL,
  `app_subcategorias_id` int NOT NULL,
  `nome` varchar(60) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL,
  `descricao` text CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci,
  `croqui` text,
  `data_cadastro` datetime DEFAULT NULL,
  `checkin` time DEFAULT NULL,
  `checkout` time DEFAULT NULL,
  `data_in` date DEFAULT NULL,
  `data_out` date DEFAULT NULL,
  `status` int DEFAULT NULL,
  `status_aprovado` int DEFAULT NULL,
  `finalizado` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Despejando dados para a tabela `app_anuncios`
--

INSERT INTO `app_anuncios` (`id`, `app_users_id`, `app_categorias_id`, `app_subcategorias_id`, `nome`, `descricao`, `croqui`, `data_cadastro`, `checkin`, `checkout`, `data_in`, `data_out`, `status`, `status_aprovado`, `finalizado`) VALUES
(65, 316, 1, 3, 'vila4ventos', 'uma vila temática com suítes para casais ou família sobrado.capela .carruagem .cavalos pesca hotel para seu Cao junto  e muito mais ', NULL, '2025-08-06 12:53:16', '00:00:00', '00:00:00', '0000-00-00', '0000-00-00', 1, 1, 1),
(78, 313, 1, 5, 'PROMOÇÃO Dias de Semana - Casa da Montanha', 'Promoção válida de Segunda à Quinta até Outubro de 2025. Design único, ambiente confortável e aconchegante. Quarto privativo com opção de sofá cama, cozinha, banheiro com chuveiro e lareira (para sua segurança é proibido juntar lenha no local, temos lenha apropriada para venda). Lugar calmo e retirado com trilhas e paisagens encantadoras às margens do rio do Bispo. Sala de Jogos, Bar, espaço para acampar. Venha se conectar com a natureza e desligar da rotina agitada aqui no Refúgio Terras do Sul.', NULL, '2025-08-29 12:56:45', '00:00:00', '00:00:00', '0000-00-00', '0000-00-00', 1, 1, 1),
(80, 313, 1, 5, 'PROMOÇÃO Fins de Semana - Casa da Montanha', 'Promoção válida de Sexta à Domingo até Outubro de 2025. Design único, ambiente confortável e aconchegante. Quarto privativo com opção de sofá cama, cozinha, banheiro com chuveiro e lareira (para sua segurança é proibido juntar lenha no local, temos lenha apropriada para venda). Lugar calmo e retirado com trilhas e paisagens encantadoras às margens do rio do Bispo. Sala de Jogos, Bar, espaço para acampar. Venha se conectar com a natureza e desligar da rotina agitada aqui no Refúgio Terras do Sul.', NULL, '2025-08-29 13:23:19', '00:00:00', '00:00:00', '0000-00-00', '0000-00-00', 1, 1, 1),
(82, 313, 1, 1, ' PROMOÇÃO Dias de Semana - Casa Alta', 'Promoção válida de Segunda a Quinta até Outubro de 2025. Design único, ambiente confortável e aconchegante. Quarto privativo, sala de estar, sacada com uma vista mágica, cozinha ao ar livre com fogão a lenha (para sua segurança é proibido juntar lenha no local, temos lenha apropriada para venda), banheiro com chuveiro. Lugar calmo e retirado com trilhas e paisagens encantadoras às margens do rio do Bispo. Sala de Jogos, Bar, espaço para acampar. Venha se conectar com a natureza e desligar da rotina agitada aqui no Refúgio Terras do Sul.', NULL, '2025-08-30 16:47:23', '00:00:00', '00:00:00', '0000-00-00', '0000-00-00', 1, 1, 1),
(83, 313, 1, 5, 'PROMOÇÃO Fins de Semana - Casa Alta', 'Promoção válida de Sexta à Domingo até Outubro de 2025. Design único, ambiente confortável e aconchegante. Quarto privativo, sala de estar, sacada com uma vista mágica, cozinha ao ar livre com fogão a lenha (para sua segurança é proibido juntar lenha no local, temos lenha apropriada para venda), banheiro com chuveiro. Lugar calmo e retirado com trilhas e paisagens encantadoras às margens do rio do Bispo. Sala de Jogos, Bar, espaço para acampar. Venha se conectar com a natureza e desligar da rotina agitada aqui no Refúgio Terras do Sul.', NULL, '2025-08-30 18:13:00', '00:00:00', '00:00:00', '0000-00-00', '0000-00-00', 1, 1, 1),
(84, 313, 1, 1, 'PROMOÇÃO Fins de Semana - Cabana Cogumelo ', 'Promoção válida de Sexta à Domingo até Outubro de 2025. Design único, ambiente confortável e aconchegante, cozinha com conexão com a natureza, lareira(para sua segurança é proibido juntar lenha no local, temos lenha apropriada para venda), banheiro como nunca visto igual. Lugar calmo e retirado com trilhas e paisagens encantadoras às margens do rio do Bispo. Sala de Jogos, Bar, espaço para acampar. Venha se conectar com a natureza e desligar da rotina agitada aqui no Refúgio Terras do Sul.', NULL, '2025-08-30 18:50:15', '00:00:00', '00:00:00', '0000-00-00', '0000-00-00', 1, 1, 1),
(86, 313, 1, 1, 'PROMOÇÃO Dias de Semana - Cabana Cogumelo ', 'Promoção válida de Segunda a Quinta, até Outubro de 2025. Design único, ambiente confortável e aconchegante, cozinha com conexão com a natureza, lareira(para sua segurança é proibido juntar lenha no local, temos lenha apropriada para venda), banheiro como nunca visto igual. Lugar calmo e retirado com trilhas e paisagens encantadoras às margens do rio do Bispo. Sala de Jogos, Bar, espaço para acampar. Venha se conectar com a natureza e desligar da rotina agitada aqui no Refúgio Terras do Sul.', NULL, '2025-08-31 15:56:13', '00:00:00', '00:00:00', '0000-00-00', '0000-00-00', 1, 1, 1),
(87, 313, 1, 1, 'PROMOÇÃO Fins de Semana - Cabana Triângulo', 'Promoção válida de Sexta a Domingo, até Outubro de 2025. Design único, ambiente aconchegante e intimista, design único, banheiro fora da cabana, cabana às margens do rio do Bispo. Lugar calmo e retirado com trilhas e paisagens encantadoras. Sala de Jogos, Bar, espaço para acampar. Venha se conectar com a natureza e desligar da rotina agitada aqui no Refúgio Terras do Sul.', NULL, '2025-08-31 16:26:54', '00:00:00', '00:00:00', '0000-00-00', '0000-00-00', 1, 1, 1),
(88, 313, 1, 1, ' PROMOÇÃO Dias de Semana - Cabana Triângulo', ' Promoção válida de Quinta a Domingo, até Outubro de 2025. Design único, ambiente aconchegante e intimista, design único, banheiro fora da cabana, cabana às margens do rio do Bispo. Lugar calmo e retirado com trilhas e paisagens encantadoras. Sala de Jogos, Bar, espaço para acampar. Venha se conectar com a natureza e desligar da rotina agitada aqui no Refúgio Terras do Sul.', NULL, '2025-08-31 16:53:39', '00:00:00', '00:00:00', '0000-00-00', '0000-00-00', 1, 1, 1),
(89, 313, 1, 1, 'Cabana Triângulo - Refúgio Terras do Sul', 'Estadias válidas de Quinta a Domingo. Design único, ambiente aconchegante e intimista, design único, banheiro fora da cabana, cabana às margens do rio do Bispo. Lugar calmo e retirado com trilhas e paisagens encantadoras. Sala de Jogos, Bar, espaço para acampar. Venha se conectar com a natureza e desligar da rotina agitada aqui no Refúgio Terras do Sul.', NULL, '2025-08-31 18:05:37', '00:00:00', '00:00:00', '0000-00-00', '0000-00-00', 1, 1, 1),
(90, 313, 1, 5, 'Casa Alta - Refúgio Terras do Sul', 'Design único, ambiente confortável e aconchegante. Quarto privativo, sala de estar, sacada com uma vista mágica, cozinha ao ar livre com fogão a lenha (para sua segurança é proibido juntar lenha no local, temos lenha apropriada para venda), banheiro com chuveiro. Lugar calmo e retirado com trilhas e paisagens encantadoras às margens do rio do Bispo. Sala de Jogos, Bar, espaço para acampar. Venha se conectar com a natureza e desligar da rotina agitada aqui no Refúgio Terras do Sul.', NULL, '2025-09-01 13:58:27', '00:00:00', '00:00:00', '0000-00-00', '0000-00-00', 1, 1, 1),
(91, 313, 1, 1, 'Cabana Cogumelo - Refúgio Terras do Sul', 'Design único, ambiente confortável e aconchegante, cozinha com conexão com a natureza, lareira(para sua segurança é proibido juntar lenha no local, temos lenha apropriada para venda), banheiro como nunca visto igual. Lugar calmo e retirado com trilhas e paisagens encantadoras às margens do rio do Bispo. Sala de Jogos, Bar, espaço para acampar. Venha se conectar com a natureza e desligar da rotina agitada aqui no Refúgio Terras do Sul.', NULL, '2025-09-01 17:39:12', '00:00:00', '00:00:00', '0000-00-00', '0000-00-00', 1, 1, 1),
(92, 313, 1, 1, 'Casa da Montanha - Refúgio Terras do Sul', 'Design único, ambiente confortável e aconchegante. Quarto privativo com opção de sofá cama, cozinha, banheiro com chuveiro e lareira (para sua segurança é proibido juntar lenha no local, temos lenha apropriada para venda). Lugar calmo e retirado com trilhas e paisagens encantadoras às margens do rio do Bispo. Sala de Jogos, Bar, espaço para acampar. Venha se conectar com a natureza e desligar da rotina agitada aqui no Refúgio Terras do Sul.', NULL, '2025-09-01 18:46:36', '00:00:00', '00:00:00', '0000-00-00', '0000-00-00', 1, 1, 1),
(94, 313, 2, 27, 'Camping - Refúgio Terras do Sul', 'Camping R$ 60,00 por pessoa/dia  Nossa área de camping é ampla e comporta barracas de diversos tamanhos às margens do Rio do Bispo. Disponibilizamos mesas, espaços para fogueira e locais para adaptação de churrasqueira, garantindo privacidade, respeito ao silêncio e o descanso dos campistas.  O valor das diárias é referente à estadia por pessoa, e não por barraca.  Além do camping tradicional, também dispomos de espaço para motorhomes, trailers e barracas automotivas, em área demarcada e organizada. É importante observar que o acesso comporta motorhomes com até 2,1 metros de largura.  Oferecemos ainda infraestrutura com cozinha compartilhada, locais para banho no rio, mesas de jogos (cartas, dominó e ping pong), sala de boxe, pequeno restaurante com café da manhã e crepes, internet via Starlink, chuveiros quentes e banheiros.  Vale ressaltar que o material de camping é de responsabilidade do campista.  Lenha A coleta de lenha nas áreas de camping é proibida. Disponibilizamos lenha seca em tamanho adequado para venda.', NULL, '2025-09-02 16:10:18', '08:00:00', '18:00:00', '0000-00-00', '0000-00-00', 1, 1, 1),
(95, 303, 2, 24, 'Morro da Cruz: Um Olhar do Alto sobre a História de Lages', 'O Morro da Cruz não é apenas o ponto mais alto de Lages; é um portal que conecta os visitantes à história, à fé e à deslumbrante paisagem da cidade. Localizado no bairro Copacabana, este marco é uma parada obrigatória para quem busca entender a essência da \"Capital da Serra Catarinense\" de uma perspectiva única.  Acessibilidade e a Vista que Revela a Cidade Chegar ao Morro da Cruz é simples. A estrada asfaltada leva diretamente ao topo, onde há estacionamento e mirantes para apreciar a vista de 360 graus. Do alto, é possível identificar os principais pontos da cidade, as rodovias que a conectam e, em dias claros, até mesmo as montanhas da Serra Geral, como o Pico do Capão. A vista muda com as estações, oferecendo paisagens distintas: o verde exuberante do verão, as cores alaranjadas do outono, a geada branca no inverno e o desabrochar da primavera.  Um Símbolo de Fé e Devoção A história do Morro da Cruz como ponto de referência religiosa começou em 1957. Naquele ano, 300 fiéis de Lages e Curitibanos subiram o morro em uma peregrinação, instalando uma cruz de madeira no topo. Três anos depois, em 1960, a cruz foi substituída pela estrutura de concreto atual, que tem 15 metros de altura. O local se tornou um centro de peregrinação, especialmente durante a Semana Santa, quando a Via Sacra é encenada por centenas de fiéis. Ao longo de todo o percurso da subida, 14 cruzes simbolizam as estações da Paixão de Cristo, transformando o trajeto em um convite permanente à reflexão.  Um Ponto de Encontro para Todos Embora tenha sua origem na religiosidade, o Morro da Cruz atrai uma diversidade de pessoas. Fotógrafos buscam o nascer e o pôr do sol, considerados os mais belos da região. Ciclistas e amantes da natureza utilizam a estrada para a prática de esportes e atividades ao ar livre. Para os moradores, é um espaço de encontro, um local para um passeio tranquilo, para apreciar a paisagem e se reconectar com a cidade. É um convite para desacelerar e observar Lages de uma nova perspectiva.', NULL, '2025-09-15 13:57:16', '00:00:00', '00:00:00', '0000-00-00', '0000-00-00', 1, 1, 1),
(96, 303, 2, 24, 'Basílica Santuário do Sagrado Coração Misericordioso de Jesu', 'Santuário de Içara: Um Olhar sobre a Fé e a Arquitetura no Sul de Santa Catarina No coração de Içara, a cerca de 15 km de Criciúma, ergue-se uma das construções religiosas mais imponentes e fascinantes de Santa Catarina: a Basílica Santuário do Sagrado Coração Misericordioso de Jesus. Mais que um templo, é uma obra de fé, arte e grandiosidade que atrai peregrinos, turistas e curiosos de todo o país.  Onde e como encontrar esta grandiosa obra? Localizada no bairro Morro Bonito, a Basílica Santuário está a poucos minutos da BR-101, facilitando o acesso para quem vem de carro. O trajeto até lá já é uma experiência, com sinalização que guia os visitantes rumo a uma das maiores igrejas do Brasil. Ao chegar, a imponência da construção é a primeira coisa que salta aos olhos. A igreja fica em uma área ampla, com estacionamento e uma vista privilegiada da paisagem rural ao redor, oferecendo um ambiente de paz e reflexão.  Quem e o porquê de sua construção? A história do Santuário começa com um sonho. Inspirado em sua própria experiência de fé e com o apoio de doadores, o Padre Antônio Vander da Silveira idealizou a construção deste templo. O objetivo era criar um espaço que não apenas acolhesse fiéis, mas que também fosse um farol de espiritualidade e um centro de peregrinação. A pedra fundamental foi lançada em 2011, e a igreja, ainda em obras, já acolhia missas e eventos religiosos. Em 2021, o Papa Francisco a elevou à categoria de Basílica Menor, um reconhecimento de sua importância espiritual e de sua crescente influência no turismo religioso.  Curiosidades que Encantam Arquitetura Imponente: Com 80 metros de comprimento, 40 metros de largura e 53 metros de altura, a Basílica tem uma arquitetura que impressiona. O estilo neoclássico, com colunas e arcos, remete às grandes catedrais europeias.  O Sagrado Coração que Brilha: A imagem de Jesus, com 13 metros de altura, está no topo da fachada e é uma das maiores do mundo. À noite, a iluminação especial faz com que o Sagrado Coração pareça brilhar, podendo ser visto a quilômetros de distância, servindo como um guia para os peregrinos.  O Carillon Neerlandês: As 22 toneladas de sinos, importados da Holanda, são um espetáculo à parte. O carillon é o maior da América Latina, com 48 sinos que tocam melodias e hinos em horários específicos, ecoando por toda a região e criando uma atmosfera celestial.  Detalhes que Falam de Fé: O interior da igreja é um espetáculo de arte. Os 33 painéis de mosaico, que retratam a vida de Jesus, foram criados por uma artista eslovena. A cúpula, com 48 metros de altura, é adornada com anjos e santos, e o chão, feito de mármore italiano, reflete a luz de forma singular, convidando à contemplação.  A Basílica Santuário do Sagrado Coração Misericordioso de Jesus transcende a ideia de uma simples igreja. É um convite para uma jornada de fé, história e beleza, que mostra o poder da devoção humana e a capacidade de transformar um sonho em uma realidade monumental. Curiosidade. Qual a diferença de uma Igreja e uma Basílica? Toda basílica é uma igreja, mas nem toda igreja é uma basílica. O título de basílica é um reconhecimento especial concedido pelo Papa a uma igreja que possui grande importância histórica, espiritual ou arquitetônica, servindo como um centro de peregrinação ou um lugar de adoração especial.  Em resumo:  Igreja: É o termo geral para qualquer templo de adoração cristã.  Basílica: É uma igreja que recebeu um título honorífico do Papa, destacando sua relevância.', NULL, '2025-09-16 13:22:22', '00:00:00', '00:00:00', '0000-00-00', '0000-00-00', 1, 1, 1),
(97, 303, 2, 6, 'Morro da Igreja - Urubici SC ', 'O Morro da Igreja: um espetáculo natural em Urubici, SC Se você busca uma experiência inesquecível na serra catarinense, o Morro da Igreja é um destino imperdível. Localizado no município de Urubici, em Santa Catarina, este é um dos pontos turísticos mais famosos e de maior altitude do sul do Brasil, oferecendo uma vista panorâmica de tirar o fôlego.  O que é e por que visitá-lo? O Morro da Igreja é uma elevação de 1.822 metros que abriga a base da Força Aérea Brasileira (FAB) e um radar de controle de tráfego aéreo. Mas o que realmente atrai os visitantes é a sua paisagem deslumbrante e o fato de ser o ponto mais frio e mais alto habitado da região sul do país. A partir do mirante, você pode contemplar uma vista espetacular, incluindo a icônica Pedra Furada, uma formação rochosa esculpida pela natureza ao longo de milhares de anos.  O local é um refúgio para quem busca contato com a natureza e paisagens deslumbrantes. Durante o inverno, não é incomum ver a paisagem coberta de gelo ou até neve, o que transforma o local em um cenário ainda mais especial. Já em outras estações, a neblina e as nuvens baixas criam um mar de nuvens, um espetáculo que encanta a todos.  Como e onde chegar? O acesso ao Morro da Igreja se dá pela rodovia SC-370, a partir do centro de Urubici. A estrada de 28 km, que mescla trechos asfaltados e de terra, é bem sinalizada, mas requer atenção, especialmente em dias de chuva ou neblina. Recomenda-se um carro com tração 4x4, embora carros de passeio consigam fazer o trajeto com cuidado.  É importante ressaltar que o local faz parte do Parque Nacional de São Joaquim. Por isso, a visitação é controlada e limitada a um número diário de pessoas para a preservação do meio ambiente.  Quem pode visitar e o que fazer? Quem pode ir? Qualquer pessoa pode visitar, desde crianças até idosos, desde que tenham disposição para o percurso de carro. O local não exige trilhas ou caminhadas difíceis. A visita é ideal para famílias, casais e aventureiros que buscam belas paisagens.  O que fazer? Além de apreciar a vista, você pode tirar fotos incríveis, sentir o clima gelado e observar a Pedra Furada de perto. O local é perfeito para quem gosta de fotografia de paisagem e para quem busca um momento de paz e contemplação.  Dicas importantes para sua visita Agendamento: Devido à limitação de visitantes, é obrigatório o agendamento prévio no site do Instituto Chico Mendes de Conservação da Biodiversão (ICMBio). Sem a autorização, você não conseguirá acesso.  Melhor horário: O nascer e o pôr do sol são os momentos mais procurados, pois oferecem um espetáculo de cores no céu.  Vestuário: Mesmo no verão, o clima no alto do morro é frio e ventoso. Leve sempre agasalhos, gorro e luvas, especialmente se for visitar cedo pela manhã ou no final da tarde.  Condição da estrada: Verifique a previsão do tempo antes de ir. Em dias de chuva forte, a estrada de terra pode ficar escorregadia.  Infraestrutura: Não há banheiros ou lanchonetes no local, então vá preparado.  Visitar o Morro da Igreja é uma experiência que conecta você com a grandiosidade da natureza. Com paisagens que parecem de outro mundo, ele se firma como um dos principais cartões-postais de Santa Catarina.', NULL, '2025-09-17 16:26:59', '10:00:00', '15:00:00', '0000-00-00', '0000-00-00', 1, 1, 1),
(98, 303, 2, 24, 'Gruta Nossa Senhora de Lourdes - Urubici SC', 'A Gruta de Nossa Senhora de Lourdes, em Urubici, Santa Catarina, é um local de peregrinação e fé que atrai visitantes de todo o Brasil. O espaço oferece uma experiência de paz e contemplação em meio à natureza exuberante da Serra Catarinense, unindo o turismo religioso e a beleza natural da região.  A História e o Significado da Gruta O que: A Gruta de Nossa Senhora de Lourdes, como o próprio nome indica, é um santuário dedicado à Virgem Maria sob o título de Nossa Senhora de Lourdes. Sua história está intrinsecamente ligada à fé e devoção de um grupo de pioneiros da região, que, em 1948, ergueram um pequeno altar em uma gruta natural. A inspiração veio da Gruta de Massabielle, na cidade de Lourdes, na França, onde a Virgem Maria teria aparecido a Santa Bernadette Soubirous em 1858.  Quem: A iniciativa de transformar o local em um espaço de fé partiu de moradores e devotos. A gruta, inicialmente rústica, foi gradualmente transformada em um santuário de peregrinação por meio do esforço comunitário. Mais tarde, foi assumida pela igreja e se tornou um destino formal de turismo religioso.  Por que: A gruta foi construída com o propósito de ser um espaço de oração e reflexão, onde os fiéis pudessem renovar sua fé e fazer seus pedidos. Ao longo das décadas, o local se tornou um refúgio para quem busca paz e conexão espiritual, atraindo não apenas peregrinos, mas também turistas interessados na beleza natural e na tranquilidade do ambiente.  Informações Essenciais para o Turista Onde: A gruta está localizada em Urubici, no coração da Serra Catarinense, a cerca de 10 km do centro da cidade. A região é conhecida por suas paisagens montanhosas, cachoeiras e florestas de araucárias, que compõem um cenário de tirar o fôlego e tornam a visita ainda mais especial.  Como: O acesso à gruta é relativamente fácil. Partindo do centro de Urubici, o trajeto é feito por estrada asfaltada e em boas condições. No local, há uma área de estacionamento e uma pequena trilha que leva os visitantes até a gruta. O caminho é sinalizado e conta com degraus e corrimãos para garantir a segurança.  Horário de Visitação e Ingresso: A Gruta de Nossa Senhora de Lourdes recebe visitantes diariamente, das 8h às 18h. A entrada para o santuário tem uma taxa simbólica de R$ 10,00 por pessoa, que é usada para a manutenção do local. A visita não exige reserva e pode ser realizada por qualquer pessoa.  Dica para o Turista: Para uma experiência completa, combine a visita à gruta com a exploração de outras atrações próximas. A região da Serra do Corvo Branco e a Cascata do Avencal estão a poucos quilômetros e oferecem paisagens impressionantes. Considerar um roteiro de um dia que inclua a gruta, a natureza exuberante e talvez um almoço em um dos restaurantes típicos da região pode transformar o passeio em uma experiência inesquecível.  Visitar a Gruta de Nossa Senhora de Lourdes é uma jornada que une fé, história e natureza. É um local onde a espiritualidade se encontra com a beleza da Serra Catarinense, proporcionando um momento de paz e renovação para todos que a visitam.', NULL, '2025-09-19 13:09:34', '00:00:00', '00:00:00', '0000-00-00', '0000-00-00', 1, 1, 1),
(99, 303, 2, 24, 'Paróquia Nossa Senhora Mãe dos Homens - Urubici', 'Urubici: Uma jornada de fé e história na Igreja Matriz Nossa Senhora Mãe dos Homens Seja bem-vindo a Urubici, a \"Capital das Hortaliças\" de Santa Catarina. Uma cidade que, apesar de conhecida por suas paisagens de tirar o fôlego, esconde tesouros que tocam a alma. Um desses tesouros é a Igreja Matriz Nossa Senhora Mãe dos Homens, que se ergue imponente no coração da cidade, testemunha silenciosa da fé e da história local. Para o peregrino, o turista ou mesmo o curioso, esta igreja não é apenas um prédio, mas um livro aberto de devoção e resiliência. O Que: Um farol de fé e arte A Igreja Matriz Nossa Senhora Mãe dos Homens é mais do que um local de oração; é um santuário de devoção e arte. Sua arquitetura, que evoca um estilo europeu clássico, com elementos de tijolo à vista e telhados pontiagudos, contrasta harmoniosamente com a paisagem serrana. O que realmente a distingue, porém, é a história de sua construção, um ato de profunda fé e comunidade. A igreja atual, que data de meados do século XX, foi construída sobre as fundações da antiga capela, que já não suportava o crescimento da cidade. Cada tijolo, cada pedra, parece carregar a marca do esforço e da crença dos primeiros moradores de Urubici. Quem: A comunidade e seus ancestrais A história da igreja é a história de seu povo. A comunidade de Urubici, composta majoritariamente por descendentes de imigrantes europeus, dedicou-se com afinco à sua construção. O nome da padroeira, Nossa Senhora Mãe dos Homens, reflete a profunda reverência a Maria e a crença de que ela intercede por todos, independentemente de sua origem. A igreja é um símbolo da identidade local, um ponto de encontro onde gerações de famílias se uniram para celebrar batismos, casamentos e funerais. Porquê: Devotando-se à padroeira A devoção a Nossa Senhora Mãe dos Homens é a razão de ser deste templo. Em um período de grande dificuldade e incerteza, os moradores de Urubici buscaram a proteção e a intercessão da Virgem Maria. A escolha do nome da padroeira foi um ato de fé e esperança, e a igreja se tornou o coração espiritual da cidade. A história de Urubici se confunde com a história da igreja, e a devoção continua forte, atraindo visitantes de toda a região e do país. Onde e Como: Chegando ao santuário A Igreja Matriz está localizada na Praça Caetano Vieira de Medeiros, no centro de Urubici. A praça é o ponto de encontro da cidade e a igreja se destaca em meio à paisagem urbana. ________________________________________ Acesso e Horários: Sua visita à Igreja Matriz •	Endereço: Praça Caetano Vieira de Medeiros, Centro, Urubici - SC. •	Acesso: A igreja é de fácil acesso, mesmo para quem chega de carro. Existem estacionamentos disponíveis na área, mas a melhor forma de explorar o local é a pé, caminhando pelas ruas arborizadas da cidade. •	Horários de Celebrações: As missas são realizadas regularmente. Os horários podem variar, por isso é importante verificar a agenda da paróquia. No entanto, de forma geral, as celebrações ocorrem nos seguintes horários: o	Terça-feira: 19h o	Quarta-feira: 19h o	Quinta-feira: 19h o	Sexta-feira: 19h o	Sábado: 19h o	Domingo: 8h30 e 19h A Igreja Matriz Nossa Senhora Mãe dos Homens é mais do que um local de peregrinação religiosa; é um testemunho da fé inabalável e da força da comunidade de Urubici. Para o viajante que busca não apenas belas paisagens, mas também uma conexão profunda com a história e a cultura local, uma visita a este santuário é uma experiência inesquecível.', NULL, '2025-09-23 13:39:46', '08:00:00', '17:00:00', '0000-00-00', '0000-00-00', 1, 1, 1),
(100, 303, 2, 24, 'Gruta do Poço Certo - Alfredo Wagner', 'Alfredo Wagner: Uma jornada de fé e milagres na Gruta do Poço Certo Aninhada nas belezas de Alfredo Wagner, a serra catarinense revela um local de profunda devoção e paz: a Gruta do Poço Certo. Diferente dos templos urbanos, este santuário natural oferece uma experiência de fé mais íntima, em total sintonia com a natureza. Para quem busca uma conexão espiritual fora das paredes de uma igreja, a Gruta do Poço Certo é o destino perfeito. ________________________________________ O Que: A Gruta e a Água Milagrosa A Gruta do Poço Certo é um santuário dedicado a Nossa Senhora de Lourdes, famosa por suas curas e milagres na França. A réplica da imagem de Nossa Senhora de Lourdes, entronizada na gruta, e o poço de água natural ao seu pé, tornam este local único. A água do poço, considerada milagrosa pelos fiéis, é a razão principal de peregrinação. Muitos visitantes relatam curas e graças alcançadas após beberem da água ou lavarem o corpo com ela, o que reforça a crença popular e a tradição oral de milagres. A gruta é um convite à reflexão e à esperança, onde a fé e a natureza se unem para tocar o coração. Quem: Os Devotos e a Devoção à Virgem de Lourdes A história da gruta é a história de seu povo, em particular de seus devotos mais antigos. A devoção a Nossa Senhora de Lourdes remonta aos primeiros colonizadores da região, que trouxeram a fé em Maria e a crença em suas curas. Ao longo dos anos, a gruta se tornou o ponto de encontro de famílias, de viajantes e de fiéis que buscam um refúgio para suas preces e um local para agradecer pelas graças alcançadas. Porquê: A Fé em Meio à Natureza A Gruta do Poço Certo nasceu da fé inabalável e da crença nos milagres. A proximidade com a natureza, em meio às rochas e à floresta, proporciona um ambiente de introspecção e serenidade. A devoção a Nossa Senhora de Lourdes e a certeza de que a água do poço tem poder de cura atraem fiéis de todo o Brasil. A peregrinação à gruta é uma forma de renovar a fé e de se reconectar com o sagrado. ________________________________________ Onde e Como: Chegando ao Santuário Natural A Gruta do Poço Certo está localizada no Poço Certo, uma comunidade rural de Alfredo Wagner. O acesso é pela BR-282, no sentido litorâneo. Para os viajantes, o acesso é feito por uma estrada de terra, que leva diretamente à gruta. Endereço: SC-350, Alfredo Wagner, SC - Brasil ________________________________________ Visita e Celebrações O acesso à Gruta do Poço Certo tem um valor simbólico de R$ 10,00 por pessoa, e a visitação é aberta das 8h às 18h todos os dias. Embora não haja um templo, celebrações especiais são realizadas em datas comemorativas, como o Dia de Nossa Senhora de Lourdes, em 11 de fevereiro. Nessas ocasiões, a gruta se enche de fiéis, que participam de missas, procissões e vigílias. É um momento de grande comoção e devoção. Para o peregrino que busca uma experiência de fé autêntica, fora dos templos tradicionais, a Gruta do Poço Certo em Alfredo Wagner é um destino imperdível.', NULL, '2025-09-25 15:57:39', '08:00:00', '18:00:00', '0000-00-00', '0000-00-00', 1, 1, 1),
(101, 303, 2, 7, 'Cachoeira do Pirata - São Joaquim', ' São Joaquim: A Fé e a Natureza se Encontram na Cachoeira do Pirata.  Em meio ao frio cortante e às paisagens de tirar o fôlego de São Joaquim, na Serra Catarinense, existe um local que, embora não seja um templo tradicional, se tornou um verdadeiro santuário de paz e contemplação: a Cachoeira do Pirata. Este destino, procurado tanto por amantes da natureza quanto por aqueles que buscam um momento de fé e reflexão em um cenário grandioso, oferece uma experiência única onde o sagrado se manifesta na beleza da criação, com a calorosa hospitalidade da família proprietária.  O Que: Um Refúgio Natural para a Alma  A Cachoeira do Pirata é um espetáculo da natureza que não possui uma igreja ou capela em suas margens, mas a majestade de sua queda d’água e a imponência da paisagem a tornam um **templo natural**. O que atrai o peregrino não é a arquitetura, mas a sensação de **paz e renovação** que o contato com a natureza proporciona. É um local para meditar, agradecer e sentir a presença do sagrado na força da água e no verde da mata. O caminho até a base da cascata, com cerca de 300 metros, é acompanhado pela melodia dos pássaros da fauna local.  ### Quem: A Família Pirata, Seus Valores e a Verdade do Acesso  A história do local é contada pela própria comunidade, mais especificamente pela **Família Pereira**. O nome \"Pirata\" não tem nada a ver com lendas de tesouros escondidos, mas sim com o apelido carinhoso de seu antigo proprietário, **Rogério Pereira**, que foi dono da propriedade por mais de 50 anos e amava que os turistas visitassem o lugar.  **Hoje**, a propriedade é de seus filhos, **Marcelo, Rejane e Hanna**, que mantêm viva a tradição de acolhimento e partilha. Em um ponto crucial, a família faz questão de desmentir informações de cobrança encontradas em alguns canais: **\"Não é e nunca foi cobrado pela visita na Cachoeira do Sítio do Pirata!!!\"** e reforçam que os turistas **\"serão sempre bem vindos!\"**  Essa **generosidade e gratuidade** no acesso reforçam o espírito de partilha e a ideia de que a natureza e a espiritualidade devem ser acessíveis a todos, honrando o desejo de Rogério de ser um grande divulgador das belezas da terra.  ### Porquê: A Busca por Paz e a Gratuidade do Encontro  A razão da visita é a **beleza cênica** e a **gratuidade da experiência** oferecida pela Família Pirata. Em épocas de chuva, o espetáculo da água é **\"espectacular\"**, tornando a visita um momento de forte conexão com as forças da natureza. Para o turismo religioso, o local é um convite à **contemplação** e à **humildade**, onde a grandiosidade da natureza nos lembra da nossa pequenez e da beleza da criação.  ---  ### Onde e Como: Acesso e Regras de Ouro  A Cachoeira do Pirata está localizada na zona rural de São Joaquim.  * **Local:** Sítio do Pirata, São Joaquim, SC. É necessário percorrer estradas rurais, por isso, procure informações detalhadas sobre o acesso na cidade antes de se aventurar. * **Acesso:** O local é acessível de carro, mas as condições da estrada de terra podem exigir atenção, especialmente após períodos de chuva. * **Regras e Restrições:** Para manter a segurança e o caráter contemplativo do local, a família adverte: **\"Não é permitido fazer rafting ou qualquer outro esporte na Cachoeira.\"** O respeito à propriedade e à natureza é a única \"taxa\" exigida.  ### Horários e Celebrações  * **Visitação:** O local é de visitação **livre e gratuita**, durante o dia. Como se trata de uma propriedade particular, o respeito aos horários de luz natural e a preservação do ambiente são essenciais. * **Celebrações:** Não há missas ou cultos formais na cachoeira, mas o local se presta perfeitamente para a oração individual, meditação e retiros espirituais informais, sendo o horário de visita a oportunidade para a sua própria celebração da vida e da fé.  A Cachoeira do Pirata é, portanto, mais que um ponto turístico; é um legado de amor à terra e de hospitalidade, onde o visitante é convidado a celebrar a vida na sua forma mais pura e natural, mantendo viva a memória de Rogério \"Pirata\" Pereira.', NULL, '2025-09-30 15:01:35', '09:00:00', '16:00:00', '0000-00-00', '0000-00-00', 1, 1, 1),
(102, 303, 3, 26, 'Pirisca Grecco - Raiosul', 'cadastro teste', 'croqui_102_1764592868.png', '2025-10-15 11:18:48', '19:00:00', '02:00:00', '2025-10-30', '2025-10-30', 1, 2, 1),
(103, 303, 3, 26, 'Perisca Grecco', 'teste', NULL, '2025-10-15 11:20:56', '19:00:00', '02:00:00', '2025-10-30', '2025-10-30', 1, 2, 1),
(104, 334, 3, 19, 'Evento 123', 'Evento teste', 'croqui_104_1764599930.jpg', '2025-11-26 21:52:53', '14:00:00', '15:00:00', '2025-11-05', '2025-11-06', 1, 1, 1),
(105, 334, 1, 1, 'teste 123', 'teste12', NULL, '2025-11-26 22:31:53', '00:00:00', '16:29:00', NULL, NULL, 1, 2, 1),
(106, 334, 1, 1, 'asdfasd', 'asdfas', NULL, '2025-11-26 22:38:48', '00:38:00', '15:38:00', NULL, NULL, 1, 1, 1),
(107, 334, 2, 25, 'Espaco da trilha', 'bao ue', NULL, '2025-11-30 11:58:16', '00:55:00', '15:57:00', NULL, NULL, 1, 2, 1),
(108, 334, 1, 1, 'teste de quantidade de quartos', 'espao 123', NULL, '2025-11-30 18:02:29', '15:01:00', '16:01:00', NULL, NULL, 1, 2, 1),
(109, 334, 3, 21, 'Vevetim', 'vevequim', 'croqui_109_1764600669.jpg', '2025-12-01 11:50:37', '11:00:00', '15:50:00', '2025-12-01', '2026-01-31', 1, 1, 1),
(110, 334, 2, 23, 'bao', 'espaco tp', NULL, '2025-12-01 11:52:45', '11:00:00', '16:00:00', NULL, NULL, 1, 1, 1),
(111, 334, 2, 6, 'Trilha diferenciada', 'trilha', NULL, '2025-12-10 11:06:53', '11:00:00', '00:25:00', NULL, NULL, 1, 1, 1),
(112, 334, 2, 6, 'titulo ba', 'asdf', NULL, '2025-12-10 17:41:28', '00:00:00', '01:00:00', NULL, NULL, 1, 1, 1),
(113, 334, 2, 6, 'titulo 1', 'espao', NULL, '2025-12-10 18:05:17', '18:00:00', '19:00:00', NULL, NULL, 1, 1, 1),
(114, 334, 3, 18, 'moc bao', 'cumida bao', NULL, '2025-12-10 18:07:24', '00:00:00', '00:30:00', '2025-12-01', '2026-01-31', 1, 1, 1),
(115, 334, 3, 19, 'Palestra gratuita', 'teste', NULL, '2025-12-11 10:22:47', '00:00:00', '10:00:00', '2025-12-01', '2025-12-31', 1, 1, 1);

-- --------------------------------------------------------

--
-- Estrutura para tabela `app_anuncios_camas`
--

CREATE TABLE `app_anuncios_camas` (
  `id` int NOT NULL,
  `app_anuncios_types_id` int NOT NULL,
  `app_camas_id` int NOT NULL,
  `qtd` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Despejando dados para a tabela `app_anuncios_camas`
--

INSERT INTO `app_anuncios_camas` (`id`, `app_anuncios_types_id`, `app_camas_id`, `qtd`) VALUES
(41, 43, 1, 1),
(42, 43, 3, 1),
(43, 44, 1, 1),
(44, 44, 3, 1),
(58, 55, 3, 1),
(60, 57, 3, 1),
(62, 59, 3, 1),
(63, 60, 3, 1),
(64, 61, 4, 1),
(65, 62, 4, 1),
(66, 63, 3, 1),
(67, 64, 3, 1),
(68, 65, 3, 1),
(69, 66, 3, 1),
(70, 67, 3, 1),
(71, 68, 3, 1),
(72, 69, 3, 1),
(73, 70, 3, 1),
(74, 71, 3, 1),
(75, 72, 3, 1),
(77, 83, 1, 1),
(78, 84, 1, 1),
(79, 84, 2, 1),
(80, 89, 1, 1);

-- --------------------------------------------------------

--
-- Estrutura para tabela `app_anuncios_carac`
--

CREATE TABLE `app_anuncios_carac` (
  `id` int NOT NULL,
  `app_anuncios_id` int NOT NULL,
  `app_caracteristicas_id` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Despejando dados para a tabela `app_anuncios_carac`
--

INSERT INTO `app_anuncios_carac` (`id`, `app_anuncios_id`, `app_caracteristicas_id`) VALUES
(177, 65, 7),
(501, 94, 25),
(502, 94, 27),
(581, 78, 1),
(582, 78, 4),
(583, 78, 5),
(584, 78, 12),
(585, 78, 13),
(586, 78, 8),
(677, 80, 1),
(678, 80, 4),
(679, 80, 5),
(680, 80, 12),
(681, 80, 13),
(682, 80, 8),
(725, 82, 1),
(726, 82, 4),
(727, 82, 5),
(728, 82, 8),
(729, 82, 13),
(730, 82, 12),
(749, 83, 1),
(750, 83, 4),
(751, 83, 12),
(752, 83, 5),
(753, 83, 13),
(754, 83, 8),
(776, 84, 1),
(777, 84, 9),
(778, 84, 4),
(779, 84, 5),
(780, 84, 12),
(781, 84, 13),
(782, 84, 8),
(804, 86, 1),
(805, 86, 4),
(806, 86, 5),
(807, 86, 8),
(808, 86, 13),
(809, 86, 12),
(810, 86, 9),
(823, 87, 1),
(824, 87, 4),
(825, 87, 5),
(826, 87, 12),
(847, 88, 1),
(848, 88, 4),
(849, 88, 5),
(850, 88, 13),
(851, 88, 12),
(872, 89, 1),
(873, 89, 4),
(874, 89, 5),
(875, 89, 12),
(876, 89, 13),
(895, 90, 1),
(896, 90, 4),
(897, 90, 5),
(898, 90, 8),
(899, 90, 12),
(900, 90, 13),
(929, 91, 1),
(930, 91, 4),
(931, 91, 5),
(932, 91, 8),
(933, 91, 13),
(934, 91, 12),
(935, 91, 9),
(960, 92, 1),
(961, 92, 4),
(962, 92, 5),
(963, 92, 8),
(964, 92, 12),
(965, 92, 13),
(967, 95, 18),
(971, 96, 18),
(972, 97, 18),
(974, 98, 18),
(975, 99, 18),
(976, 100, 18),
(977, 101, 18),
(978, 102, 19),
(979, 102, 20),
(980, 103, 19),
(981, 103, 20),
(982, 104, 23),
(983, 106, 1),
(984, 106, 4),
(985, 106, 5),
(986, 106, 6),
(987, 106, 7),
(988, 106, 8),
(989, 106, 9),
(990, 106, 10),
(991, 106, 12),
(992, 106, 13),
(993, 106, 15),
(994, 107, 14),
(995, 107, 16),
(996, 108, 1),
(997, 108, 4),
(998, 109, 17),
(999, 109, 19),
(1000, 110, 22),
(1001, 110, 21),
(1002, 111, 16),
(1003, 111, 14),
(1004, 111, 18),
(1005, 112, 14),
(1006, 113, 14),
(1007, 114, 17),
(1008, 114, 19),
(1009, 115, 17),
(1010, 115, 19),
(1011, 115, 20);

-- --------------------------------------------------------

--
-- Estrutura para tabela `app_anuncios_fotos`
--

CREATE TABLE `app_anuncios_fotos` (
  `id` int NOT NULL,
  `app_anuncios_id` int NOT NULL,
  `capa` int DEFAULT NULL,
  `url` text CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Despejando dados para a tabela `app_anuncios_fotos`
--

INSERT INTO `app_anuncios_fotos` (`id`, `app_anuncios_id`, `capa`, `url`) VALUES
(99, 65, 2, '54eba9a585033668cf60583fbeca922e.jpg'),
(100, 65, 2, '98d13acc59bfec7123bb61ec28f7b456.jpg'),
(101, 65, 2, '37e01052337bcef8cb5d56bd756a12c1.jpg'),
(103, 65, 2, '45492975d6ab15b9a5423a917f89864b.jpg'),
(104, 65, 2, '8e94062d4a42d376fb112e5ee6190625.jpg'),
(105, 65, 2, '3b21fd499b21190026acfdd0cb5d59f1.jpg'),
(198, 78, 2, 'ee758b82b9e32b25d4410af7fd740bb6.png'),
(199, 78, 2, '73b9416c4ee9e43ae3660a65155f9d55.png'),
(200, 78, 2, '05aa8bb4fa1016f3869949712f054de9.png'),
(201, 78, 2, 'fe2fc7289ccebb2dab85162df8d2eb5e.png'),
(202, 78, 2, 'baedcf10a55fa905dbb014cc24facde9.png'),
(203, 78, 2, 'cc009a64f1e1c4fccd266819d6d66e46.png'),
(204, 78, 2, 'd47afd4a599b352511146ff6a0a0f699.png'),
(205, 78, 2, '378c7c1b2cf6e01f06a8e2b37bb6e5fb.png'),
(206, 78, 2, '4778a179dbecff148307876b515bca32.png'),
(207, 78, 2, '02945d94458f2c304b1001e4f6f05976.png'),
(208, 78, 2, '9282625502bc52b1b38e42733f354bd2.png'),
(209, 78, 2, '0083d21875697061638cf2bb72480cd5.png'),
(210, 78, 2, '4ff94d5d149a06e84bc06116619fbfba.png'),
(211, 78, 2, '966f1eda580ef78f57c596603b421562.png'),
(213, 80, 2, '26459ab54ebb7dafffe4f83cd6fcb23c.png'),
(214, 80, 2, 'f8708d0f4d745bd1160ade5a4b044830.png'),
(215, 80, 2, '5c1b240f098d6ec4fb798c8c7e15ce88.png'),
(216, 80, 2, '031286e4a89c280e93380f8951b81b99.png'),
(217, 80, 2, '44516577e0bf09cdeda0807925f80a98.png'),
(218, 80, 2, '8da98aa8bac2ef713b8a68194c2418a8.png'),
(219, 80, 2, 'e4b2e737df4a6d30b7f0b637ac9763bc.png'),
(220, 80, 2, '3fe1b201d87130e5df19756d86500be7.png'),
(221, 80, 2, 'd1954ed6525a003dac30ab445a46853e.png'),
(222, 80, 2, 'b54beef03e1cca962c1d455677fb18e8.png'),
(223, 80, 2, '402d210fa64bda25f314db47182c1a58.png'),
(224, 80, 2, '5288fc9eb84d5c9ba8f920f4dfbdb817.png'),
(225, 80, 2, '143122849d3686b47ea989879a5cd56a.png'),
(228, 82, 2, '0f3a7f2a9362dbd737871c938c3d1642.png'),
(229, 82, 1, '2e78cfda2acccc85a1416790517f9b24.png'),
(230, 82, 2, '69924ef436c41069ebd3d6648386ec70.png'),
(231, 82, 2, '756b6d239ae31d9514aaa3c0a45d45ef.png'),
(232, 82, 2, 'bfe45de0bd61e22f185fbc77ade2704e.png'),
(233, 82, 2, 'ff7452e9ff513a32f857a0e21a64f62f.png'),
(234, 82, 2, '9d79abbfc375780629f7c244ac8b6f14.png'),
(235, 82, 2, 'accdeba26d10ff52654dc71632d23bb1.png'),
(236, 82, 2, '980ba04250e375201cdb1a843aa92b34.png'),
(237, 82, 2, '5fd92797390fb9ef8679603a02ebed78.png'),
(238, 82, 2, '244fbb878a7f5c1c105537768be0651d.png'),
(239, 82, 2, '279ae61d4a71d0a5fba984574e9358d1.png'),
(240, 82, 2, 'a93d9cd27107ddb5184aafd990f84e54.png'),
(241, 82, 2, 'c7b32ea9f2d3d2114eefdf509574801f.png'),
(242, 82, 2, '35e9ae887876eb85695da99b0f753a9b.png'),
(243, 82, 2, 'e608abd415a4fb949c05b47adf62930f.png'),
(244, 82, 2, 'fe7156af492f9460de15c9cf80bf513f.png'),
(245, 82, 2, '0cce1b8d4fcd48b4ff8afbda60f8d5f2.png'),
(246, 82, 2, '9f4b0806cfc1fb91293adf5284c2c505.png'),
(247, 83, 2, '10f7b43e27ec25c29d236d92123c3d7d.png'),
(248, 83, 2, '08df6a6d126850deb9f430e0081dfd36.png'),
(249, 83, 2, 'af974605ce47ec55c3e895e66392085a.png'),
(250, 83, 2, '88e85847a66a2166336fb9ce228e4ed0.png'),
(251, 83, 2, '9aa1054f3a3190122af4ecdf0683934c.png'),
(252, 83, 2, '20d6f9bde05038b72c9b479212c81c3b.png'),
(253, 83, 2, '34a232d8bcf393665f002a38149da4c5.png'),
(254, 83, 2, '304db3ee646336422a6d841fdf22b89e.png'),
(255, 83, 2, '42d0fb7d4dbd8cdc3edf02f8615c3e17.png'),
(256, 83, 2, '4af06cfa1e6be9af3ee8300f663a6731.png'),
(257, 83, 2, '0325350e1816dcceadb69d36c09119a8.png'),
(258, 83, 2, '68da4c22655d19baf3e8f0e5a010e12a.png'),
(259, 83, 2, 'f169e51fc78f433be5f72341b0c7db2e.png'),
(260, 83, 2, '26fa7f053624d8c1756e688bd3066e81.png'),
(261, 83, 2, '88b688f774224b1c25197d8ab7c129b5.png'),
(262, 83, 2, '9dd9597b42beabb6653288ddd21308ba.png'),
(263, 83, 2, 'd7161162271a2944cdef867456c2d75e.png'),
(264, 83, 2, 'e4ea812a0519ee2d5744aa8ca16f8941.png'),
(265, 83, 2, '81b2ab3d6b1ceaf3670e84a3de7228be.png'),
(266, 83, 2, '4864fdcb9890373f153e9daf44cf253f.png'),
(304, 84, 2, '16b1c52aa3b70de8e4c399c2e26ebd41.png'),
(305, 84, 2, '70131cc076d1e1972e10cf30ad2c0742.png'),
(306, 84, 2, '719a256911cef41ec88d2a26776f3b84.png'),
(307, 84, 2, 'fbcae218456025c19688bc7879bcb6cc.png'),
(308, 84, 2, '068b8e883a6e18f0d746ba2db8d6ad8a.png'),
(309, 84, 2, '67cec4ecd49aa90783d1efa794b664c6.png'),
(310, 84, 2, '834f7329e8ab6a9ac4d3563f8e6194be.png'),
(311, 84, 2, 'bb01e09876bb2774c50f32081abf2054.png'),
(312, 84, 2, '522596ff47357d4264a49a50ffd71bb5.png'),
(313, 84, 2, 'a8a6f668449854c7e72793d80d29707d.png'),
(314, 84, 2, 'b18f877ccf2383d0e548f5352ad2f841.png'),
(315, 84, 2, '59569adb36c3ea9ab49cc4f4ed709b1f.png'),
(316, 84, 2, '1455fa170350024d2ca6801d0c640ce9.png'),
(317, 84, 2, '20c3b3c8511cc8b18e648bc20f254a0e.png'),
(318, 84, 2, '3046623e1d6d5a1683552e749bb4db38.png'),
(335, 86, 2, 'cf20ebbf04e96712e162e444d3aad1b6.png'),
(336, 86, 2, '69c54d5f2566adb3e22bf393d3ffedcd.png'),
(337, 86, 2, 'bfd2eeb16f0fc8d198df595c9b60d6f0.png'),
(338, 86, 2, '1a1843c594e1ae03e4138b12887c6bd0.png'),
(339, 86, 2, '9173af361e13baa2501fa7dd85ad7bc6.png'),
(340, 86, 2, 'cdb63ba39e70067f4b0fb14e48c5aac3.png'),
(341, 86, 2, '441bb0e0fdf01c283826d5852b0442d4.png'),
(342, 86, 2, 'ea1a5bb21922fa02c73a0ada04222ad9.png'),
(343, 86, 2, '0bca732bfdd3a63e8dbd2a65ab2b82f9.png'),
(344, 86, 2, '9e8c982a77d72ca2fe183b1ccadf7b89.png'),
(345, 86, 2, '62f43fb439f5422fa93ee07e9c309929.png'),
(346, 86, 2, '7091eed29dcd634482e65bfa4f2cec24.png'),
(347, 86, 2, '147c27e33bcead8b607ede7ed8ae4d6a.png'),
(348, 86, 2, '8e7617d5fc540402a215efd1d96bf89f.png'),
(349, 86, 2, 'ec0304d94c39572d2604e7c096b9dad9.png'),
(350, 86, 2, 'e1c6eb556b0c3d330f45dc3c1a6bffa3.png'),
(351, 87, 2, '9b9af6eda5ba29fd862c4842cc899f58.png'),
(352, 87, 2, '9863acaa2e996f2956a7ae24d08ab7ce.png'),
(353, 87, 2, '37ed9604e24f8822c46e2e1a4ad1ce97.png'),
(354, 87, 2, '7ab6fc652f3884a48d0a49f33b472efa.png'),
(355, 87, 2, '1bd10b77edce6b7e3deb9751abb1abaa.png'),
(356, 87, 2, 'e0325d7d387c94caa68570aa26ad9b4e.png'),
(357, 87, 2, '759eedecbeaec2c1e9433846a070ac9e.png'),
(358, 87, 2, '0628ab30cbb8fa4e92209a5abec643ea.png'),
(359, 87, 2, '42656f2587e599f3681aae5897c08c8e.png'),
(360, 87, 2, 'f375182a7558fd0ee47dd8b7e66fb827.png'),
(361, 87, 2, '9200aafb1402ebd867a8a95eee859774.png'),
(362, 87, 2, 'b0a6444e3bde78773afbf28b8d859efc.png'),
(363, 88, 2, '09ca5b1a6f4599d39864e58c102a4f5e.png'),
(364, 88, 2, 'b9de48d603d57852c2c3dfaa5673a6dd.png'),
(365, 88, 2, 'a17e81be930e9d158a2967ee0eabd26c.png'),
(366, 88, 2, 'a0884a9b4c47990589f0f82fc85847b9.png'),
(367, 88, 2, '1f3708764913c2ad14133fb85941b78a.png'),
(368, 88, 2, '139dc24e8eee3b6282c6f2ab7a01d18f.png'),
(369, 88, 2, 'bc4f2c403ed3998201fde69cd4a98291.png'),
(370, 88, 2, 'dc81d4108cde3404e425350c9538cc70.png'),
(371, 88, 2, '3d4485795d9d650ecbf6e849ae7c38d9.png'),
(372, 88, 2, '7d364358815ad92b73d6438bea60e5eb.png'),
(373, 88, 2, '91da9d4b9ba8b4cd8e69cc4850004442.png'),
(374, 89, 2, 'a9675e3bb91e38b0b7e87263fa825d69.png'),
(375, 89, 2, '6d1fb2fff17bc6eb098572bd79e5d73f.png'),
(376, 89, 2, '2c2c582c3687e295e38d7a2070ab88d7.png'),
(377, 89, 2, 'ea662fe631cc2b570e8d754e80e52906.png'),
(378, 89, 2, '84bd53b5a15894c9ecb8e0ba33737edd.png'),
(379, 89, 2, '44cbcf9a32824e3ececcd457fa1bbd6d.png'),
(380, 89, 2, 'a8bca2df109b83d386d71221c2a86539.png'),
(381, 89, 2, '9a64d28ce8bc1fcf7bfd49e0e8e31012.png'),
(382, 89, 2, 'ad3dfbceea82f1afd1bdd81ec1137009.png'),
(383, 89, 2, '5053a96c776cb15da2f62992399bbdb8.png'),
(384, 90, 2, '197fb6d1566c6342184a57b509b7538b.png'),
(385, 90, 2, 'b76a23a8802e260301c774fbb9e77726.png'),
(386, 90, 2, '1329ff09160630658db3192a2323bfff.png'),
(387, 90, 2, '7ee62ce4a4b45a1acf7fa60b387dc4f7.png'),
(388, 90, 2, 'a82877523d5bd4cd0bc35310fe9b45cc.png'),
(389, 90, 2, '33948205ffbb2ba3fb3636a39f40110f.png'),
(390, 90, 2, '6143fa47f8f537c45cf12cb70dfc2198.png'),
(391, 90, 2, '02ca601571dda2310deb98b038ce1eb9.png'),
(392, 90, 2, '4f8389367e34105686f468a70aeb82ec.png'),
(393, 90, 2, '7251875f8d22ad66f4f53f306211312e.png'),
(394, 90, 2, '344306b46d428a9f6bb4622cee568504.png'),
(395, 90, 2, 'cc42cddbe62b6e74b70057456c487189.png'),
(396, 90, 2, '25160ee30ae753984e7c2c030a731613.png'),
(397, 90, 2, '94a8f19b991dae8f011850259186e65a.png'),
(398, 90, 2, '6fc3c25f83e05e4bf0480a4365598363.png'),
(399, 90, 2, '4bc7308242ba615b4f5e3d98b687ed40.png'),
(400, 91, 2, 'a8bcd2611bf9de81331a01cb78757f01.png'),
(401, 91, 2, '86155bb73940646ed1a71542aa7b8901.png'),
(402, 91, 2, 'f3040204bb99f10cb3c3db108a0ee94a.png'),
(403, 91, 2, '1414a91a788d7c46ddfd15f42ad1aa88.png'),
(404, 91, 2, 'ea0edbfe9503d07b369390832e52faff.png'),
(405, 91, 2, '166a2d4bea89f21a6bd7ffb940dca63c.png'),
(406, 91, 2, 'c2fe297f73f52aa459e64636180e96f4.png'),
(407, 91, 2, '47c7eeb748f9e499aa4291807eb5833b.png'),
(408, 91, 2, '46d7767d1855f38d3e0d3158813fafde.png'),
(409, 91, 2, '491efd444517cbb4fbed7e85e368b6de.png'),
(410, 91, 2, 'a4342618f35fe8605830c94e1cdb6542.png'),
(411, 91, 2, '9a4ba61ad433ac6206123024a5301e28.png'),
(412, 91, 2, 'b0e1a7dd7822e76cd89da83c40f1ba09.png'),
(413, 91, 2, '3836388caa50382abb39ad238b80d3fe.png'),
(414, 91, 2, '55f691530ebd00ffca673c719486c93b.png'),
(415, 91, 2, 'a7831160cb5fca675d6b6e8c321ac97d.png'),
(416, 92, 2, 'a5485478fe01947682aee1f5708e66c9.png'),
(417, 92, 2, '748b5b687f7656ce44a555c4ab381c73.png'),
(418, 92, 2, 'fdbba4309ff269fb225ada484ca009c5.png'),
(419, 92, 2, 'dba1e1aeb94a6bace4d2cb908242302a.png'),
(420, 92, 2, 'bd6c375a2954bbf965dd450d7163baf0.png'),
(421, 92, 2, 'c9127936fe7750d5b9a60d1a2146b188.png'),
(422, 92, 2, 'e9c66b36e21a1adceb5f669cc6abba4f.png'),
(423, 92, 2, 'aedc54ea2cbedd9c7a4af7f209ab928f.png'),
(424, 92, 2, '682a8ac978eb43611738e64da41b77e4.png'),
(425, 92, 2, '80fbf905fc53c2a3a076ec33db84794c.png'),
(426, 92, 2, '1c22768103ad3e1528e77825c2fd7696.png'),
(427, 92, 2, '5c477e050e0a00c22b5fa1e0cc1f97d8.png'),
(428, 92, 2, '88ce1d7f1c7c22a69c8ae08fae6dad94.png'),
(429, 92, 2, 'd3006fe0d9a9f022d38c99e5831aac77.png'),
(432, 94, 2, '7d089fdb8294ca78dca3363415f9d8ec.png'),
(433, 94, 2, 'dad44150d8566685317c6ce9b1b47b5c.png'),
(434, 94, 2, '6de5e608d0fac62d5a8f4e3ffaa8cdb0.png'),
(435, 94, 2, 'dea6fcee58d35df084f0434c4a3581ec.png'),
(436, 94, 2, '9a672420ff3f9f92e878c68ccf99a01f.png'),
(437, 94, 2, '9c0537348eae8aebc23d35e1d0872e51.png'),
(438, 94, 2, 'd6c15f75c849407adf138ac2582baf4c.png'),
(439, 94, 2, '7a58a2e33f6db1a2f2b8e0a32199755c.png'),
(440, 94, 2, '772e73327a51a196ee5a7195dde29b71.png'),
(441, 94, 2, '8aea756ecd3920796e24234fefb0974d.png'),
(442, 94, 2, '4121b601b5c3ab41fe6ea76f20680d93.png'),
(443, 94, 2, '20e0e0101cef55f9de3b4635ffbc58fb.png'),
(444, 94, 2, '4e8d4f8415e2e6b4bab834a2525cbfbb.png'),
(445, 94, 2, '15df53722bbf49ae8a06d04c2dd059f2.png'),
(446, 94, 2, '69ec4f3d365e4868522627751c823688.png'),
(447, 94, 2, '7e113e11da6bd71c61f01be044e2446c.png'),
(448, 94, 2, 'cef0176f5f62950ed34ea9120c3ffddf.png'),
(449, 94, 2, '61cde6b4ac347cbba975aee9bba413c9.png'),
(450, 94, 2, '7da6dcd7e9425ecb7537da18480fcf17.png'),
(451, 78, 2, 'b0349221d6454995655536a190beb08d.png'),
(452, 78, 2, 'b90249d326378f04724b4174a41d165e.png'),
(453, 78, 2, 'e53248f7e61e34cc8d522e56bfffcbdf.png'),
(454, 78, 2, 'dfe17008545c2c9ecc55bacdbe567926.png'),
(455, 78, 2, '1d08d9998f471f6ffe3094f555e61896.png'),
(456, 78, 2, '4827ddac41d55eec489796e653c381ba.png'),
(457, 78, 2, '9a0aef2562e2932cefa93961d24e78f7.png'),
(458, 78, 2, 'd19913b77fd2ec92593f647263f6df28.png'),
(459, 78, 2, '389d2c5939203d7a12cf7b24b0d3b507.png'),
(460, 78, 2, 'cb28aeef9f2e4f9298e6f1c755e1462d.png'),
(461, 78, 2, '344a29f54219ac0c61220c2baf6ca5f7.png'),
(462, 78, 2, '5435dbce207cb716e8c9282533d6c6b8.png'),
(463, 78, 2, 'be26b23bf18125005f4e862dc53ee90c.png'),
(464, 78, 2, '825f7a8799b4ceaceefb429e65206fc9.png'),
(465, 78, 2, '06e254cac9d87d153ea0ceea70daa6f3.png'),
(466, 78, 2, 'f5ed46c29617584aada6c883f283b6c9.png'),
(467, 78, 2, '1242953bd536019c67125b9927ba28b2.png'),
(468, 78, 2, 'fdfedec2af25647ef96bdb3b97b4d655.png'),
(469, 78, 2, 'eed0125006957a3438f0cee4d67ddeb0.png'),
(470, 78, 2, '64f5c208c32c44d1790a5c517ef70f2b.png'),
(471, 78, 2, '2c2bc031781552e703b80f4c361b1881.png'),
(472, 78, 2, '0775818ed3e1adb369dd7a25a38d8ad5.png'),
(473, 78, 2, 'a62ac36cea24d4f6027c58c21a78c6f6.png'),
(474, 78, 2, 'a4055a0d9fb3d1afedb5d353be151b28.png'),
(475, 78, 2, '38beb963269ada90aae48ada4c9f468d.png'),
(476, 78, 2, '4b58e239d6eb2df16a79ad0a54ad8af5.png'),
(477, 78, 2, '22120991fe5c448459998bf7da1fda47.png'),
(478, 78, 2, '068a930af0076d7013f85f2ddce1d7f3.png'),
(479, 78, 2, '44c2ee9b07bfa2eda1e18bee78ed45b7.png'),
(480, 78, 2, 'ff3e4c2e5e35d07f3151c8ed0127f857.png'),
(481, 78, 2, '71b2d9e231a43a4f77f45f7501702d3f.png'),
(482, 78, 2, 'd2500d5bee8985c4e63d081791934c03.png'),
(483, 78, 2, '56f93407b3fed8885164aa2715a7e56c.png'),
(484, 78, 2, '3537b68e6341c9bf704901b66b5510e6.png'),
(485, 78, 2, 'e45112f8b2d3e5b275c7c280c498fdf5.png'),
(486, 78, 2, '33ffe6a9fc0d193c91d1bb6d34e3a43a.png'),
(487, 80, 2, '038229d343645c9094946c294d245343.png'),
(488, 80, 2, '4874fb9a7817c0b38c43ce91540ff317.png'),
(489, 80, 2, 'c36fb2423c712d1089e0f0f149a7126a.png'),
(490, 80, 2, '61165fa539fbd7ed374777aaaad3c0ba.png'),
(491, 80, 2, 'fc0e1f7588a5e7d8ec7f3d67f8c88345.png'),
(492, 80, 2, 'cfb6d9f28b19e3494be8d8f6e7de6cf0.png'),
(493, 80, 2, 'd7e9cddaadd61286a2ceed32de93ec40.png'),
(494, 80, 2, '96152e6de1cb0abe659ced48adb83022.png'),
(495, 80, 2, '63a3d8fa30acbcedb6bd90a5dffb67df.png'),
(496, 80, 2, 'faace92e46a653148c2d95f525e16c1b.png'),
(497, 80, 2, '5497a523438204e531300c1dd856cb24.png'),
(498, 80, 2, 'a6deef44c2f1d85298b6579a9981c245.png'),
(499, 80, 2, 'b8eecced3ab67c729a2f6289509d3332.png'),
(500, 80, 2, 'bbf5e73d625f4f52831815613e0da8ce.png'),
(501, 80, 2, '37d67ff562919d0e8c03dff0f59e8b10.png'),
(502, 80, 2, '42e1592b835771dabe1f0c09d0aac51a.png'),
(503, 80, 2, '438c7f26441c497b9dfd709f52b740af.png'),
(504, 80, 2, 'c1ef8df5e4c5e65fa32964a06fb7d170.png'),
(505, 80, 2, 'a0559cdb5c41661b6d2cf1e6e8489be3.png'),
(506, 80, 2, 'a45bf7198d7029b426f6b778cf54bcc1.png'),
(507, 80, 2, '519d2990e065fb0f319b8c646c4939c0.png'),
(508, 80, 2, '892067fa9e5040ffdae56dc9c2422d50.png'),
(509, 80, 2, '5afe39296188cc1d2e58d2e785070259.png'),
(510, 80, 2, 'ee7f8cecdbaae1b13033a505301c7da0.png'),
(511, 80, 2, '309ca8b14b901a4dd6f56dbf29cc6f9d.png'),
(512, 80, 2, '03c6a0563229e7de3f319a3e4bf8d8a0.png'),
(513, 80, 2, '70b9b7c623ca2397517c2af79e91507b.png'),
(514, 80, 2, 'ce1f9f97dff52e22630f4485190333e7.png'),
(515, 80, 2, '745d67fd7d3e8b9c97fb25b1cb59fbd2.png'),
(516, 80, 2, 'ecaa45a4c372c6934e6548e20ebc6a28.png'),
(517, 80, 2, '454936b80bfce6a2061a5877b83823ca.png'),
(518, 80, 2, 'd55fac61fd92795dfc03a72dc7a59fcc.png'),
(519, 80, 2, 'c6f7164f5f1110be9075593d98be8ada.png'),
(520, 80, 2, '780ef254e06b518156d77bbbeec823b3.png'),
(521, 80, 2, '655d68be6a1fd5f52c19159aa2336e68.png'),
(522, 80, 2, '175f36736ac31366c2005d23643f13bb.png'),
(523, 80, 2, '33340a602cfb1f921c1cd3d6e1fc08cb.png'),
(524, 80, 2, '8b193a358bc9e23f3fc6e769ab3aea21.png'),
(525, 80, 2, 'bbc60a455bbade4fe7377ac1306a0008.png'),
(526, 80, 2, 'a0e716efa0af37b49d9e7d9fcc707703.png'),
(527, 80, 2, 'a3cbe19b300d90b1bffe7388125d09f8.png'),
(528, 80, 2, '5bc567dc3d7efedfbac1d05323a41573.png'),
(529, 80, 2, '5be73a0c6bd711d788e4af11e869eaf8.png'),
(530, 80, 2, '520b8c2a4262727376593e98477040da.png'),
(531, 80, 2, '833bd347ef1e44984c8cfc203e15aab0.png'),
(532, 80, 2, '37780ef11cc07658ffb53adde19d9c62.png'),
(533, 80, 2, 'd86ed38b2da10ad21454566702ad750a.png'),
(534, 80, 2, 'f055fe3425d4e096817d5b84a32b66aa.png'),
(535, 80, 2, 'c9dfd7498cd646ef0597f700d242a5ce.png'),
(536, 80, 2, '965c4bd425aafdfed6b265be5e745f6a.png'),
(537, 80, 2, '1512e152403a98d187cc001bf5803dd7.png'),
(538, 80, 2, '1e56817eb8a03f60a766ce6d89f7c582.png'),
(539, 80, 2, 'e7b6be94f0e0b43b67c19772357e68a0.png'),
(540, 80, 2, 'c774992167b344b9b918a5d87f4a64eb.png'),
(541, 80, 2, '1b787abb1cb0b81b3b2bdacf60271cbb.png'),
(542, 80, 2, 'f2f05b4912ca2ebce67e8d0626ee5b98.png'),
(543, 80, 2, '0110246de8c7ff523934c26ba42a9c19.png'),
(544, 80, 2, '7967c91c39c58dd8e0a75e2793ab562f.png'),
(545, 80, 2, 'b39458a2d15e69b9ace4a7c7bd8b37d4.png'),
(546, 80, 2, 'a1b3eb8222a99a689eda521f482160e8.png'),
(547, 80, 2, '83ac0a1fd508e3e3b4439fd7c5814de6.png'),
(548, 80, 2, '43554d6e64dff517c0e308e14349900f.png'),
(549, 80, 2, '845ef4ea89d9e29577d32c99ad7ed899.png'),
(550, 80, 2, '79fdc28b546cff7439db2e46de65232d.png'),
(551, 80, 2, '35ba9ccc209e79730fc903ce10b4d790.png'),
(552, 80, 2, 'bccbbcc410479b758c387fb66d407350.png'),
(553, 80, 2, 'b0b6d3881dbb97b90a508a80d8991c10.png'),
(554, 80, 2, '2379792c41347fecc49b1d295ccdc881.png'),
(555, 80, 2, '6eb41a9401c8f04dc861d815243e032a.png'),
(556, 80, 2, '0acb372620859872a97a425b1da719d7.png'),
(557, 80, 2, 'fb3ca2c7d65a182d92dd78ea3ebd0a05.png'),
(558, 80, 2, '716d20d86f51c2507b27d41068a6e9da.png'),
(559, 80, 2, 'e9d4c4f815aa00364b1b8e8f245fd264.png'),
(560, 80, 2, '9eb78e752d8d628ae87d281b35850584.png'),
(561, 80, 2, '52ecf8834f0c22fafc8f38187d81a5fa.png'),
(562, 80, 2, '58b89921332822cddc4eb0b76d149a3a.png'),
(563, 80, 2, '38f6045608c05b4d0f737de58d5000f9.png'),
(564, 80, 2, '91c9d9b8903fe32e795beb0d22458e12.png'),
(565, 80, 2, '73557ecb5ea06fbe64189d32eb553455.png'),
(566, 80, 2, '3a1a4d5a1821b6e572c163b6da849479.png'),
(567, 80, 2, '70545b0882c061f0cc6f4d66712f184e.png'),
(568, 80, 2, 'be956f993aee2a89642f9f7f3f6def5b.png'),
(569, 80, 2, '0148ea2b4890273917e8c4186df041c5.png'),
(570, 80, 2, '3db6e19c3e71d7465f9c5c78db7a51c0.png'),
(571, 80, 2, 'fd563d83f53e919c891260584a0e60fb.png'),
(572, 80, 2, '5687b120b6dbcfd63f989177d7fe7867.png'),
(573, 80, 2, 'c63a979b4959043c3972e64a874f0bb5.png'),
(574, 80, 2, '701a9499d93ccb9d3fc5d00447d3172d.png'),
(575, 80, 2, '6592552bdf31769b9a8726da527484e0.png'),
(576, 80, 2, '45b684091e3d76b098ff2325799b8d12.png'),
(577, 80, 2, '4e97389aae44e0871078fb2a5b153a0c.png'),
(578, 80, 2, 'b3ec3b0cb2dc96f770be34fb4f68763b.png'),
(579, 80, 2, '124e04d6fb2467589da65852cc0110a5.png'),
(580, 80, 2, 'e40df874362f4b5aa510be6fcf246720.png'),
(581, 80, 2, '6c763cb2d900d7b39d048178aacd72e3.png'),
(582, 80, 2, 'e09e670f6f4e53680ea1f979e95361ea.png'),
(583, 80, 2, 'e895336093eada274d700f6a6b3ad105.png'),
(584, 80, 2, 'b795ece328718961e8296d7673667eec.png'),
(585, 80, 2, '6884429fea69c4b151d327ae2b8a4c46.png'),
(586, 80, 2, '8b2b83f797854392791936a5dfbbd696.png'),
(587, 80, 2, 'd3d2512a05d8ffb6105b1705e8803a44.png'),
(588, 80, 2, 'c883cc42d2595109960e8dec37463485.png'),
(589, 80, 2, 'a60fefcc7d3f95d7fe29af97babea7dd.png'),
(590, 80, 2, '371547fe5e3b2772315a3afe4cff694f.png'),
(591, 80, 2, 'ac62c536970afd631aa06bebfe45372e.png'),
(592, 80, 2, '1ce9f3aa48c08e10515d0bab9456c819.png'),
(593, 80, 2, '7103b0131712b1f9fb07fc13b15df303.png'),
(594, 80, 2, '61344959fbabdfe7cc91857d03ae0085.png'),
(595, 80, 2, 'c1348411af5cfed10606dc18437c3759.png'),
(596, 80, 2, '7ca8ae796ed1bdc19d3732707383b7df.png'),
(597, 80, 2, '4d2c4e5051a89cd5748f7801a1f58e48.png'),
(598, 80, 2, 'b30b54ce688891f898145efcf0b90138.png'),
(599, 80, 2, '55c6726395d6d3135a9d4a481d229896.png'),
(600, 80, 2, 'b3557a3596eec7d0d4e140ab9ceb1165.png'),
(601, 80, 2, '70e031912463bcf75f9a295ccef48ab8.png'),
(602, 80, 2, '89e755c54e10da3c8332d42a6a439fb9.png'),
(603, 80, 2, '455d1072db77099db790021a8faf1f3d.png'),
(604, 80, 2, 'd97b3a764044f2d694ce23458b4d2679.png'),
(605, 80, 2, '075adfd81175a3b22573aad03f5a590d.png'),
(606, 80, 2, '1d64e370588ed65a6c6ee20f4fe9a542.png'),
(607, 80, 2, 'c9405cfa129e8ae9c5f2457d7466e0a9.png'),
(608, 80, 2, '07d1b7146d77b061fa9a535c7ed4895d.png'),
(609, 80, 2, 'c1060121305297df572b2396b38b29bf.png'),
(610, 80, 2, 'dced2c9449b44225d6655f9f563586f5.png'),
(611, 80, 2, '8dd2c5cfe0570f450ee85ffc07bf8869.png'),
(612, 80, 2, 'f386be930cebd9bcbce2dc994a6e6b18.png'),
(613, 80, 2, 'bbb682572b5a6c17c76001c1af1b3a4c.png'),
(614, 80, 2, 'f8b0590769f81f35ce705aa9d56c67b5.png'),
(615, 80, 2, '3d0579fe5c8102318f57d752e662e078.png'),
(616, 80, 2, 'e9ef811b8d62af056de7f901a54efcb2.png'),
(617, 80, 2, 'a8dd6a7ee5c639893d8038da36b5a465.png'),
(618, 80, 2, '8f0582328ca3ef662438bcf693ce1b48.png'),
(619, 80, 2, 'd66a61264f398eb05f73ef55c3a80ddd.png'),
(620, 80, 2, '21e9a2a55efd00962975a4213a6d13d3.png'),
(621, 80, 2, '784d569582fb2fff16e62c177ed6fd2d.png'),
(622, 80, 2, '21700a8356eb3172ee3f6eae1f789bef.png'),
(623, 80, 2, '4fcc4ae79fe629f858f5b8c58a7075dd.png'),
(624, 80, 2, 'e0ac915b665db1080fe8df7cc556adc0.png'),
(625, 80, 2, '25a3b5c772fdad37c1a9bda4465aee3f.png'),
(626, 80, 2, 'b98b7ac1b1e1bb852240d4a41ee637a7.png'),
(627, 80, 2, '2ea95a4ef5494b34e89701b689a29390.png'),
(628, 80, 2, '001f61b5ae91b8986b3bbd32ef56684f.png'),
(629, 80, 2, 'f5c82654f326a5cdf8a87df1b41ffdad.png'),
(630, 80, 2, 'bdc260031764e68d4c8e0fe0e3263b0c.png'),
(631, 80, 2, '18446d626a5db7703d870d7d4c47a98f.png'),
(632, 80, 2, '92cd2bd544c88f8b39fdf7c98eb8e7c2.png'),
(633, 80, 2, '888300235752ad0ae5cb892344ece1cf.png'),
(634, 80, 2, '7dbf407061ea37ed9321191e3a93a425.png'),
(635, 80, 2, '87d64afd7772598c5b353a46ce33d8f2.png'),
(636, 80, 2, '7a21f47295c6ad01db99ebad892d0dd6.png'),
(637, 80, 2, '424097bd49f7d15b47b52cdaf165dd6c.png'),
(638, 80, 2, 'a60d19a58629281f60066ed7fce017ea.png'),
(639, 80, 2, '8cffc07627d644a130ae43db7c07e667.png'),
(640, 82, 2, '9b92d76e5d5090ae7d4dec9680886494.png'),
(641, 82, 2, '771f09e6561723a64120e6219cd6458f.png'),
(642, 82, 2, '2cd4cbcffaaba0d5daad6759c59f67fd.png'),
(643, 82, 2, 'b8e19beb9f266dcdab4c4b06ca7c30eb.png'),
(644, 82, 2, 'b53735a4acc397eff0014e138328e3d5.png'),
(645, 82, 2, '14cefcc950568552805e4e6036f20055.png'),
(646, 82, 2, '28892e11e564119070c69b5527df92a1.png'),
(647, 82, 2, '8b0f5e358cb5aa820b512d72bfca015d.png'),
(648, 82, 2, 'f3a8146b849abea6331ab051896a3313.png'),
(649, 82, 2, '6306b3522aedce00916071f41a98fc1a.png'),
(650, 82, 2, 'e390ce5f44cff78b90af02880d6befd3.png'),
(651, 82, 2, '35aeb0f36708b0c894bea1a224e5b22a.png'),
(652, 82, 2, 'd9f2604742a179ab934f49fc16d4539b.png'),
(653, 82, 2, '3a07c8af8daa9d96dfaad3f3106630bf.png'),
(654, 82, 2, '407b14cc771ca97e59d72492f4e62354.png'),
(655, 82, 2, '7ed5aa3123465c2f0c7c098ac5442cf8.png'),
(656, 82, 2, 'c4d99002e75b9138bbd136628b950cca.png'),
(657, 82, 2, '01080df3d5d09a956382e1a72894e92c.png'),
(658, 82, 2, '23cc5dc079a50bd9b1544915ec8c7fff.png'),
(659, 82, 2, '8ed884ddf5e5518ba87c0124f56299e4.png'),
(660, 82, 2, 'ff0e43e2008ee8c5695869f790cbd123.png'),
(661, 82, 2, 'f89dd7e698344695e3f96111fbf2f738.png'),
(662, 82, 2, 'becf76390deb09605368bd39691e0bb3.png'),
(663, 82, 2, 'c88cdb32a43775d832a7361bcd9bafc5.png'),
(664, 82, 2, '520286a496f71639a7c19b62e808d565.png'),
(665, 82, 2, 'ef8a80cc851ed04e326b8ef796fc8741.png'),
(666, 82, 2, '9ddb75c15bdf493a3337adf4a1fce493.png'),
(667, 82, 2, '51d12a7da1903b43cb52102bb00e9c0d.png'),
(668, 82, 2, '2d66ff72ea5d3c76a9fe428822b1dbd5.png'),
(669, 82, 2, 'b677c4ec9218d050b8214dc259cd7008.png'),
(670, 82, 2, 'ed23ee03ae16f50a0308a7afc3bb96f9.png'),
(671, 82, 2, '220809c508ce80851e77fd92a556a8df.png'),
(672, 82, 2, '7eb379920e3cf7ff2061d779787f35ec.png'),
(673, 82, 2, 'c59089784f8660b09ea67728fe00d506.png'),
(674, 82, 2, '1f72567ee4ba219a8293a9912f46f158.png'),
(675, 82, 2, '83781d2cdc3d70479f3d8874687d24ab.png'),
(676, 82, 2, '877317ac2b7f813ad95ea9e288c85080.png'),
(677, 82, 2, 'c99f2d60cde3207d2f6af09585d9888d.png'),
(678, 82, 2, 'b7459cdb3266256b9f04b09fb7404d21.png'),
(679, 82, 2, '4926cf9ad5ea72e9a9ca12f228b677ed.png'),
(680, 82, 2, '11500426f21650befa7b937dd1702154.png'),
(681, 82, 2, '326f750d7e85f437c99e3f96e762f08e.png'),
(682, 82, 2, 'd55b0b19adadf7063f8ac79fc8af89ce.png'),
(683, 83, 2, 'c70620fbd193c0751231e4d1438d625e.png'),
(684, 83, 2, 'bb6bf28245ff62042536b3cb2b4c4afb.png'),
(685, 83, 2, 'b6c9666b50dcd7c2de505322c4d33e0e.png'),
(686, 83, 2, '63cde6d3f617df1d8dc4c03b7e2aac1c.png'),
(687, 83, 2, '4260ed87bd71d1d68a1f4121cdbc84da.png'),
(688, 83, 2, 'f4df7ad673ea0f809434f0c67c92d694.png'),
(689, 83, 2, 'fef1d18f74c82cc277ac1766bfa771a7.png'),
(690, 83, 2, '4cc90dd8c87e0fcd871cde188d55f72e.png'),
(691, 83, 2, 'c416d3012e88fc6de03246fb6b49007a.png'),
(692, 83, 2, '3f3ccdf26be805d35e2bf9d9ac990762.png'),
(693, 83, 2, 'b61acf77b84fda2d4f4208bc3be071b5.png'),
(694, 83, 2, 'b9ffb1e373e026060cc816ff81608200.png'),
(695, 83, 2, '53b4f905a4d78ad55509eeb7ecf4dba7.png'),
(696, 83, 2, '9ecb3a7c6870146adbce3f5a44253d28.png'),
(697, 83, 2, '2293e2cdf6bf567cd13af46b6f270114.png'),
(698, 83, 2, '8a89d8de74dcd1b9701cf74354610628.png'),
(699, 83, 2, '688ac703dade51b5750027892476f319.png'),
(700, 83, 2, '10e3a0d37856929d01f1f33252f6780c.png'),
(701, 83, 2, 'f9515127606a5981c17a2583c073f61c.png'),
(702, 83, 2, 'd675b0387c8feb36028eeb5ec14dd9dc.png'),
(703, 83, 2, '6138a3dddd6cf5e83598dff905eda391.png'),
(704, 83, 2, 'ecf8454ec6ab4dd90573751efb89790a.png'),
(705, 83, 2, 'fbec06a8aa5851113a584e47ec76e528.png'),
(706, 83, 2, '053e9c0807c75efb95a26cdf3aba865f.png'),
(707, 83, 2, '9f25044e1cde5e4b0694f3b398697443.png'),
(708, 83, 2, '8fe789f85a04bc3756ad2d5cc3af4159.png'),
(709, 83, 2, '8482a8345a5abc2d6ce6b4ecc65a3bfd.png'),
(710, 83, 2, 'a59ac388918723ac743a7237dd2888dc.png'),
(711, 83, 2, 'f9e9de29af85cc3b59888cf1527484a3.png'),
(712, 83, 2, '69c2e34b44cbe0412d94ef0e64659e73.png'),
(713, 83, 2, 'f505cc1e90ba62e33bde868e9a8d807b.png'),
(714, 83, 2, 'd4c61ccf3bd32a4f8b3828436fbc5ddb.png'),
(715, 83, 2, 'dc46296d38e50e01e50eb75df11b009f.png'),
(716, 83, 2, '44f8ee206040b7cfaaaa5e41d452a9b4.png'),
(717, 83, 2, 'a7881891279e4b9091e465ab86e15cce.png'),
(718, 83, 2, 'c53dc3426b8e81ffaad8ef6a7914a5cf.png'),
(719, 84, 2, '489654870dd67d8328fdd2d8fa84b025.png'),
(720, 84, 2, 'd13933e3949ae1948aa5880f71ee9da9.png'),
(721, 84, 2, 'ad6cb32dc7b8b0a9b07b5b0266ed119d.png'),
(722, 84, 2, '3074c0e9616219b7344c19123e5a1ac6.png'),
(723, 84, 2, 'b8889aee77c35f9b248a144eac8ce4cd.png'),
(724, 84, 2, '9d2032db99ddf8c0ad22306c00b81e26.png'),
(725, 84, 2, '027a5074ddc5794da312b5c2b644201e.png'),
(726, 84, 2, 'f596b07bb8abfa85ec2fff9fd8386c8f.png'),
(727, 84, 2, '309e8bb026028ac2b7763c95e26b74f6.png'),
(728, 84, 2, '40b3d6bdcc3268d8b84085bb7ebae45b.png'),
(729, 84, 2, '5bd6e9f93fc8a071c19efa1fa48a9bb5.png'),
(730, 84, 2, '6681b2584baa2fbbd6b4026ce95713e4.png'),
(731, 84, 2, '395971ba64834ca130d16950a3fdc349.png'),
(732, 84, 2, 'ef69f38b8f5f6a4ace33a1976fae0e9a.png'),
(733, 84, 2, 'c62930edbbc5cafd54480c81d315b65f.png'),
(734, 84, 2, '4222dd57c9d95867c655899bb0d3a6b0.png'),
(735, 84, 2, '3d44e3629337e72465a313cd552bdb09.png'),
(736, 84, 2, 'b3238463eaf6a9e869e3b3ec7eb3f370.png'),
(737, 84, 2, '871bdf148f128969b9aff2c0d365900d.png'),
(738, 84, 2, '951fa5af5595085bb7de5182f5e81896.png'),
(739, 84, 2, 'd3f6c5ab0bf191e7987486e2c4c9adee.png'),
(740, 84, 2, '61317fcfe35193a590ed70af0c0b33f7.png'),
(741, 84, 2, 'fb8ad57e3de385f2bdd30d01f77c6d88.png'),
(742, 84, 2, 'e6503d51436dec2c69c2bc77664989b1.png'),
(743, 84, 2, 'f4f8f58d54300876c3a3ec9c0c347e95.png'),
(744, 84, 2, 'c9bf40a9e360b8fcdf95d8aaf332b2b9.png'),
(745, 84, 2, 'c4de698b19d43573975ca67bd5c9e150.png'),
(746, 84, 2, 'fa82e94fa7434baa8b8486a220e2ba8e.png'),
(747, 84, 2, 'b06061811a57223262eb35a356638405.png'),
(748, 84, 2, '79cc49002f1ffee763ff38683b112a75.png'),
(749, 84, 2, 'cb930648f2590ccbd38fb3d96a027155.png'),
(750, 84, 2, 'a1d5d894537337f0febd7b43ae325845.png'),
(751, 84, 2, '29a4e0620dd63c76bf58ba9810ea92f4.png'),
(752, 84, 2, '7148cffa4e8cdf13cbc0e2f645270c08.png'),
(753, 84, 2, '7f84a23024eff0de222fdaee270fb560.png'),
(754, 84, 2, 'a3aeac9107df89abc610efd4d9bb0a30.png'),
(755, 86, 2, '003201e54c19826c8992a2d3cfac4ff5.png'),
(756, 86, 2, 'e5d08955e3ed02709db4557cc4aef1d8.png'),
(757, 86, 2, '95bf1ec5affa454c772192fcb19d95e5.png'),
(758, 86, 2, '4504a1936b947397c172b65c08e9d701.png'),
(759, 86, 2, '638e96b5a53dd03a5baa405de7490f4b.png'),
(760, 86, 2, 'e519c1ea170ebec3bf4d79283c32d168.png'),
(761, 86, 2, '3498b3aedb8f5c0154036308237e41d7.png'),
(762, 86, 2, '5dba5e9f27e2279ecea6ff7b87d39f63.png'),
(763, 86, 2, '5464b68454493baacd4e681a05697771.png'),
(764, 86, 2, '2c22667a2f8143ce23e3b1adbc2dc684.png'),
(765, 86, 2, 'be2b7a78799371508513129c39dcccea.png'),
(766, 86, 2, 'af600d0e8df6032e10a255b5890b9eda.png'),
(767, 86, 2, '27af220cfab9f40cc6122fc3a4a939ae.png'),
(768, 86, 2, '76682b42b8a72ff70e3b31b35f596d18.png'),
(769, 86, 2, '9f5a82ff51cb9ce237e8d1a834fa05ae.png'),
(770, 86, 2, 'c1dc04e6c9d7219014754fe16ab54ced.png'),
(771, 86, 2, '8758b6ecc5e65f94f7d3491b892bb7fb.png'),
(772, 86, 2, '352459f91c69f4c9fe6952e91e17a967.png'),
(773, 86, 2, 'b07ef2df26c888ee307293ab01f0156d.png'),
(774, 86, 2, '9517cb6e67169bb63bf9597ec5e11f85.png'),
(775, 86, 2, 'c3080c42026813b7be697a699e075b42.png'),
(776, 86, 2, '63e43cda8f9cb2f5bf144bb070c672c0.png'),
(777, 86, 2, 'fc88cbe0b2b79d13e0373633c6d7c79e.png'),
(778, 86, 2, '418a8f1b95e5a7ba2ab27d5d932e3a34.png'),
(779, 86, 2, 'a5288b2fc11601ce4793899cb7ec3909.png'),
(780, 86, 2, 'b36eba42f7d3de6cb3a33529d4161b15.png'),
(781, 86, 2, '615188eb8bf99e4d7ed8b9d1b2d21571.png'),
(782, 86, 2, '82c162b536b950668a113ef9b0fe851e.png'),
(783, 86, 2, '5636bfb953da797cdda4ec7288ca77d0.png'),
(784, 86, 2, 'cad4be67da49b414c468cce87eb8815b.png'),
(785, 86, 2, '99ce7235b9f7b08092cf508b45af10b0.png'),
(786, 86, 2, 'a19674b5f039c9815bdebaf365592590.png'),
(787, 86, 2, 'c6f34dab61c82a588e456c784e1e434f.png'),
(788, 86, 2, '341fd43cc01b4fa5637fd4b8e38310b2.png'),
(789, 86, 2, 'd64c611e7fe82ef9ae37d4f25cfd6812.png'),
(790, 86, 2, '4a54c8f2d00c51789292e6fc65725700.png'),
(791, 86, 2, 'd1af1670d679f374ffdb909060465bf5.png'),
(792, 86, 2, '2976d93f998eb9292fd80c4aaf6ad8ff.png'),
(793, 86, 2, 'e77b41821136c1191ca9430685583d54.png'),
(794, 86, 2, 'ab776119c5ae72175a52b69e856876d6.png'),
(795, 86, 2, '1f1ea365b496905e7bd773dc5223e23e.png'),
(796, 86, 2, '272e23a49ccf0b72fe90212452b3b7a8.png'),
(797, 86, 2, 'eebbad06d1889401aecd1e06c0bf016e.png'),
(798, 86, 2, 'da4ae84fa577a463754126896e1345ef.png'),
(799, 86, 2, 'cdeb14314b5414c8cd6764604cca0470.png'),
(800, 86, 2, '3978bf525e782dab15781f106942b0eb.png'),
(801, 86, 2, '78d2c0e8475382a64c461c2108037efd.png'),
(802, 86, 2, 'c0a273966158cd3a7dfb0398a0465303.png'),
(803, 87, 2, '5b85567519e69d9ca3fe2e6f5873d698.png'),
(804, 87, 2, '405855a2940bfec71a952c2406826062.png'),
(805, 87, 2, 'acb102dd44dd62c5148603815d596e3a.png'),
(806, 87, 2, 'b39c9b0056a6ba7eef746efe9ad319a3.png'),
(807, 87, 2, 'ba1506cefe8da07222595157cf32f253.png'),
(808, 87, 2, 'd7b923611653ab143e579e3723b6f47e.png'),
(809, 87, 2, '3150eadf720c7412beba9dd105ee7aaa.png'),
(810, 87, 2, '8c45ab476422ce0f0cfdeaca632bf887.png'),
(811, 87, 2, '4d81ac6106c1849adf59a45a69113262.png'),
(812, 87, 2, '57f02fdd7cde2ed82ecdb30fc9f8cd53.png'),
(813, 87, 2, 'dfa8b41fe690898b44f83d6628571467.png'),
(814, 87, 2, 'e5641595a20211ba09dfa89029a7f6ab.png'),
(815, 87, 2, '9abb912a446a8cd37e3980f549935e06.png'),
(816, 87, 2, '78d5c7aa5081f3cfe8cb7bcde0740927.png'),
(817, 87, 2, '903c100245f7735a256bd1e79aad4c8a.png'),
(818, 87, 2, '9bb5cf7fce852fce8192dc5c9cba2e23.png'),
(819, 87, 2, '8664642a5add802e3cc48ef1286b9820.png'),
(820, 87, 2, '732fb6de58f6efd0db7eadf2692fb3ef.png'),
(821, 87, 2, '14f1058a08f805a5d788318771f48e0c.png'),
(822, 87, 2, '9ce345f582742bb7b84a701185fb604a.png'),
(823, 87, 2, 'fb69a4dcf65ca9d6a08922acba8a4493.png'),
(824, 87, 2, 'dc3ba25c6871f8d863b89e882f42e4de.png'),
(825, 87, 2, '0ca7c6e24b79e1720a4cb8a656b21ab2.png'),
(826, 87, 2, '8ef283322e89dadf3e01592d5907795f.png'),
(827, 87, 2, 'f599671828fd61278889b049d7da84ea.png'),
(828, 87, 2, '66b7e7b421d11fa8a76ef23ffcca8f3f.png'),
(829, 87, 2, '5850ff68bed709796864672695235730.png'),
(830, 87, 2, 'dfff58340616ef7c7cef08ebc684cf99.png'),
(831, 87, 2, '01fe90b4da1761f4169329ea71fbf4c4.png'),
(832, 87, 2, '38b6c672da54068c624cf475cc33e043.png'),
(833, 87, 2, '91c2e0404e09c7e1b8fdfd9dad9b3f60.png'),
(834, 87, 2, '098f86724107831718dc995234ecf093.png'),
(835, 87, 2, '343c04c0096537e32c87832eef098585.png'),
(836, 87, 2, 'aa8c5f8e8e21b5cef4ab61d4e025e5c1.png'),
(837, 87, 2, 'ab8ec97c73ab62f214f8053e54877d5c.png'),
(838, 87, 2, 'bad6d1ba54f2c29e707d00196c69bbda.png'),
(839, 88, 2, '021112c04b1529305e6ad7043e6d0a29.png'),
(840, 88, 2, '7b0e027acfdb2015078f3ca4da426b8d.png'),
(841, 88, 2, 'f835060d89a397bf0fda10945ec30705.png'),
(842, 88, 2, '987b19a2568020c0d46ebcb66c93a912.png'),
(843, 88, 2, '9fc2a6e7890583f7cee45d77aca89cd2.png'),
(844, 88, 2, 'df9338afb13638a0d17496cb51225208.png'),
(845, 88, 2, '9fa6277f57fd89e525374e85aa19a893.png'),
(846, 88, 2, '301bc9ef1a31df168f422d7c4fd89d6c.png'),
(847, 88, 2, '60de6d31233ebf2f1816c0f37ab96f74.png'),
(848, 88, 2, '3a2e2611aa5a8d9c2562d1cdc7cf78ab.png'),
(849, 88, 2, '076b308043e3b3e0ee0a49490ab1e4b2.png'),
(850, 88, 2, '87224ff48a0d8bf5e412c67071eb6532.png'),
(851, 88, 2, '469f4db744d4d6fdb8b14d42b408ade3.png'),
(852, 88, 2, '9c1d6443fee737ca45d623065058324f.png'),
(853, 88, 2, '491921cff0881735fe060f204491958b.png'),
(854, 88, 2, '2e979ed28e0a3beb88ef6570ed6d94c1.png'),
(855, 88, 2, '6b3e639c3e3046e7af3c9210cf8effcd.png'),
(856, 88, 2, 'a8c28509dc57b0f2a93e116b2a0dfd53.png'),
(857, 88, 2, '29e90fd43a7e8ce425c82740af2253f8.png'),
(858, 88, 2, 'b2464ebda3ef9b019846d0df04387754.png'),
(859, 88, 2, '55dcd65603920eabbb2de72ff047814c.png'),
(860, 88, 2, 'f642c82ca98c69a71d08597587803cb0.png'),
(861, 88, 2, '11cc405298150be5cdd5e3d67f22cf93.png'),
(862, 88, 2, '22abbf193a198f10224e94a16beba13c.png'),
(863, 88, 2, 'bd3c816d495e83b38e875271e3a0f522.png'),
(864, 88, 2, '0ff7103ae36df7545c19f32d77bfc551.png'),
(865, 88, 2, 'ceb3a581ee18bb006dfaf16461f8a0ae.png'),
(866, 88, 2, '2110d6d6f5a03aaf5132fb67141a43be.png'),
(867, 88, 2, '7b2f922469b48c9cebaf40ece627732d.png'),
(868, 88, 2, '49477182ff244f67d931ae434c1fb4a6.png'),
(869, 88, 2, '200fd3b0f15b5ccb8a83f8da923c98dd.png'),
(870, 88, 2, 'e49b7347095649e50b1edec8663a91b0.png'),
(871, 88, 2, 'a2958bc46182accb684b1dd76cb9740e.png'),
(872, 88, 2, '7f43d0c8dbb1444b638030ea14f2b4f2.png'),
(873, 88, 2, '32cff4909ed0242153b5d2c2ff5d733a.png'),
(874, 88, 2, 'b42578d36966930c28b6ad8384b19488.png'),
(875, 88, 2, '5f0f6d917ccd928409eeade4d64bd3bb.png'),
(876, 89, 2, '7f3eb84d9b08d9ad4d7862045534bca4.png'),
(877, 89, 2, '87d7be9cf5f88cc18d1449b233af682f.png'),
(878, 89, 2, 'da964ecf6787853761f5cd518aa639fc.png'),
(879, 89, 2, 'e31ec54f6bc1b003512c36c667d37675.png'),
(880, 89, 2, '303e2b9730b5b7b414ccdcc9cfe920ed.png'),
(881, 89, 2, '3c86687f4288e79af7429c5662399d0f.png'),
(882, 89, 2, 'fe93582982d62e78887a926ab7eaba2c.png'),
(883, 89, 2, '4815c81d61ba0c99c72cd5b650071540.png'),
(884, 89, 2, '500f83472731df0f9713f09d17ac6ed6.png'),
(885, 89, 2, '148a9ae358a9f65bf2afff21d303cfac.png'),
(886, 89, 2, 'f35ee93fb25c9f8526069430c6b4b0a9.png'),
(887, 89, 2, '90c8c9fd2731823bb48a8d3c29bef76a.png'),
(888, 89, 2, '55be50ffd675d7c96ef427fabba275e9.png'),
(889, 89, 2, 'fd8543934126d78d06c97f7dba837eea.png'),
(890, 89, 2, '1e50788110093abe27fa139d206f83c0.png'),
(891, 89, 2, '8d561fc58765f9b765b5f659570d2263.png'),
(892, 89, 2, '15777b329459b55393f33f0e6a2e2ca7.png'),
(893, 89, 2, '30a60d23af68019843fecee35a43415b.png'),
(894, 89, 2, '22a30f80a8cd98044aaa631770fcb68f.png'),
(895, 89, 2, '6539108ae26c1d152eac0391cb0e7ab0.png'),
(896, 89, 2, '60a0884113568e56bc2d010bdafb73b0.png'),
(897, 89, 2, 'b66ec0160d0d35b6b84737397c521140.png'),
(898, 89, 2, '3ce0cf827ea33d233ff01f68ae85aaf0.png'),
(899, 89, 2, 'b036ac29d121cd2064125f418cc9d0e2.png'),
(900, 89, 2, '3e29c3e79ff96bedc6f56a302c6629df.png'),
(901, 89, 2, '7029275ed2f13ae523eb2ea4b453c507.png'),
(902, 89, 2, '0a747e10719744310a38ba891c4fc798.png'),
(903, 89, 2, 'a0baae052eb2e6fbb8cc3814a6f74c8b.png'),
(904, 89, 2, '6398ffff50bdde6513319d5d445d2949.png'),
(905, 89, 2, '6a4618fbab7233c965ff3568e117aaeb.png'),
(906, 89, 2, 'f50cb32102e7f14fe586c4dbca8c7618.png'),
(907, 89, 2, '82bd55a6df09ed1542bd2876431497aa.png'),
(908, 89, 2, 'a29d9353eb66c380eaab59a385ab835b.png'),
(909, 89, 2, 'f5c168218ba388824ba656d9c15660e9.png'),
(910, 89, 2, '72f36ecc0a8d19fdb4cef00243a0c028.png'),
(911, 89, 2, '37963d477c82fba73e472f21946be536.png'),
(912, 89, 2, '83afbb259cd90706306af5b5191e529d.png'),
(913, 89, 2, '4d9e4185ec6828fb5d10d29bf1604ebd.png'),
(914, 89, 2, '5f0c8c373c7bb48becd67e61612f2e8b.png'),
(915, 90, 2, '4e5c8b6f6956ce56a57d7e9527861ea9.png'),
(916, 90, 2, '52ef21c3e2df1d5ceae8cf819170627a.png'),
(917, 90, 2, '510ff2e6f89f524f101ef7cff9168556.png'),
(918, 90, 2, '731f1f2b496a6ca92d57ddcdbee9a79f.png'),
(919, 90, 2, '51dcdcaa215151f7c1223e7d30f4bfdb.png'),
(920, 90, 2, '65ba8e9af0ae0c05cb495e6afce59582.png'),
(921, 90, 2, '112b8fea9afd2a6ea0007a023907b9b2.png'),
(922, 90, 2, '64a5d571263fe393a0db3ab390a0f331.png'),
(923, 90, 2, '165c50b71dbd8df31ebe8384cb6937ba.png'),
(924, 90, 2, '748ad25fe775e4fdd30cccd41a52bb01.png'),
(925, 90, 2, '4aec1e0ee8a25c48e1b2286787eb8ae8.png'),
(926, 90, 2, '0479dd885c80ba2aed9a92b8b05f0c95.png'),
(927, 90, 2, '46ecad2e1f498979d3d3ee9c75979767.png'),
(928, 90, 2, '1803bad6ff51675c08e35cbf22de5ee9.png'),
(929, 90, 2, '433e60423e020ae1f99b4f8dbdb6ac9e.png'),
(930, 90, 2, '4f959cb4f4b2822ab757626eaff7db50.png'),
(931, 90, 2, 'e4cfb1a708dc35556720c052193746b4.png'),
(932, 90, 2, '249c1f38e4faffbd5381692228755274.png'),
(933, 90, 2, 'ec3e2bb4c939b3168dbbd2c1435cc9c5.png'),
(934, 90, 2, '039fb8ccc4d00b7ed292d08dd115fb8c.png'),
(935, 90, 2, '5a0dc6e894b9a8df9d5af7da4b7f5c80.png'),
(936, 90, 2, 'e275ca2e1c6bfd4e434a88eb2a0c428b.png'),
(937, 90, 2, '06e703beaced0f80f5109fc67e70a439.png'),
(938, 90, 2, 'dd46369af2e76d666522d423dbde9e74.png'),
(939, 90, 2, 'f19cd6f523b877bc27a265640e1b30e5.png'),
(940, 90, 2, 'a5f6e6c6711b294d271a3b026e0f24f8.png'),
(941, 90, 2, '34c1201fb31bca41857216c913882fa8.png'),
(942, 90, 2, 'b0c3166f731cc13dd3df00a0785c44d0.png'),
(943, 90, 2, '9b30ff17ee243689d8fdd71e48de1151.png'),
(944, 90, 2, '36019ad6cd02ee392d7d7cabbf94bf67.png'),
(945, 90, 2, '0d467984ee3c7173e2e707173fae7502.png'),
(946, 90, 2, 'd83660eb1bf190f73af4cd2c0d00284d.png'),
(947, 90, 2, '0016b4f6c62cc5fb82a55c63c54a4dcc.png'),
(948, 90, 2, '71cb9c9ea2a2ec8e2ea37e3990d47c2a.png'),
(949, 90, 2, '4a5ab6259f44039b070598201c3e7ec4.png'),
(950, 90, 2, '811e4f74f0240564f2132970977a26dd.png'),
(951, 90, 2, '9d12adf82d7228eb46fcde985f388ca0.png'),
(952, 90, 2, '5cbe237ae2d4474a20bb343b4c2147be.png'),
(953, 90, 2, '739b93d95c2a25adc9a84c1465cbb93f.png'),
(954, 90, 2, 'bd3e581a1398a4e4bdd581bfafbaa993.png'),
(955, 90, 2, 'ba985362ec5023475d8f38220c74d3dc.png'),
(956, 90, 2, '593c8cc51115e1460469a67fca5b1413.png'),
(957, 90, 2, 'a1e489f7b00b558e94abcd0e7aa07e2e.png'),
(958, 90, 2, 'a83cf71cf00bca34ca398c24ff3e0fab.png'),
(959, 90, 2, 'ba64264f9ca9fde41e724e8f9590d71b.png'),
(960, 90, 2, '697dda27eec89f2d7ba0ae740194ac11.png'),
(961, 90, 2, '2f516003b570db322d98027575f663a4.png'),
(962, 90, 2, 'a68d3ae71ddaa3f73f513f4b5830d3eb.png'),
(963, 91, 2, 'b8c6c426bcf8fe5e9d0533bd3b1cf370.png'),
(964, 91, 2, '374afcb2ccc79bdb48ae7b6d3ca46fcf.png'),
(965, 91, 2, 'de2df244937f12ce0609c65cb4b4c75c.png'),
(966, 91, 2, '81e175958f0f9ecc6cee3c00c44b6831.png'),
(967, 91, 2, '834d5c20240eac7929769dd06cf38b40.png'),
(968, 91, 2, 'f09eb0bafe212f0b75394de86ebd8b6e.png'),
(969, 91, 2, 'c88fa0975ee2c8a251869c5788551cab.png'),
(970, 91, 2, '6c51d5da12c818a3091204f00f5419e0.png'),
(971, 91, 2, '56231268eae72935874046ab158b0948.png'),
(972, 91, 2, '81126935e91d89f09bda82a3b6d8159c.png'),
(973, 91, 2, 'fb44f8b5fa0498b4aee2ff6edd08ebb2.png'),
(974, 91, 2, 'd1fba2262545605d766f1be0fc27e332.png'),
(975, 91, 2, '33b005d03912d0c302d6c7194a6e996e.png'),
(976, 91, 2, '8e031e839eda093b6dcb73d020011fb5.png'),
(977, 91, 2, 'e1c7ef5c520977a4d7c3581c82110aaa.png'),
(978, 91, 2, 'cef841bb50604b6844d2a1be5d50362a.png'),
(979, 91, 2, '3247cb9497c971b65d47794cb81956d5.png'),
(980, 91, 2, '0de934ab07a27a90952d5dda2db3cf0b.png'),
(981, 91, 2, 'f9ca610f785f20c0914c5c3803f26c2f.png'),
(982, 91, 2, '71ee0e6eecb09a5c2b3e878a856ee186.png'),
(983, 91, 2, '8bd0dcadb97c85a9c0ba17d93ce7cdb0.png'),
(984, 91, 2, '63fa108677a081b773962636a052278d.png'),
(985, 91, 2, '1c868f7e22bf86ac25b9134a9549cf64.png'),
(986, 91, 2, 'cf769a4154415605abbedb74a6486353.png'),
(987, 91, 2, 'c12003e9b5ee052635264f4f8426dff9.png'),
(988, 91, 2, '984feb5a094d83b16a339ddcb21e07c2.png'),
(989, 91, 2, 'b0139178160f74268cf7b028f7a09922.png'),
(990, 91, 2, '17bf907675db951b330201e42d5e0323.png'),
(991, 91, 2, 'afcfca90867098af12f59af0b7b82d5a.png'),
(992, 91, 2, 'e1603b2539e29cceef7c9d4372e894d8.png'),
(993, 91, 2, '28a3424bc0c07b1d96777129f3b28cf6.png'),
(994, 91, 2, '98739775441e4ea2f7b3da61ba40a063.png'),
(995, 91, 2, 'dd1f43a1a64221ef2ddb38dd5e73a47a.png'),
(996, 91, 2, '47698ac7ffe2e9daa3d0f485a8248595.png'),
(997, 91, 2, 'd5f7aafde60fd5da4790e93f2d5f35d3.png'),
(998, 91, 2, 'e3bef39b75dfd7f7861b246ed699429f.png'),
(999, 92, 2, '43b9e5a296b2d7ce30ca956207d580e5.png'),
(1000, 92, 2, 'ee020df1ef1665b62dc9c99eb65cc71a.png'),
(1001, 92, 2, 'c2e63dbadecd2d5300ef9dca80c4670b.png'),
(1002, 92, 2, '16d619e61276e3e73a5f2adf561e0906.png'),
(1003, 92, 2, 'a75b1d0d37381b0c5f245ea995e7932c.png'),
(1004, 92, 2, 'c1339ddc350b5275e423b0288bb8963c.png'),
(1005, 92, 2, '3c3e46ecabfe61579d24a6a5a3e69c38.png'),
(1006, 92, 2, '353e6eecdbebb6e0ae6816d94520830f.png'),
(1007, 92, 2, 'de4a669a5cf652ac8df806617ed8dcdc.png'),
(1008, 92, 2, '2c3bfac683e1eebe6c31ec8fe4daec93.png'),
(1009, 92, 2, '0df73ca9dffdac405714551ccbab6bd2.png'),
(1010, 92, 2, 'dbca52e36c4ab4c2139cc35f3c311861.png'),
(1011, 92, 2, '2a0d057ea25ee4318cbb1835671c97b9.png'),
(1012, 92, 2, 'e1f37f7c8705854646bdc6e8e9e25bc0.png'),
(1013, 92, 2, '2b0fb514c34bd64adfea630b774d98fa.png'),
(1014, 92, 2, 'c9bc5779d5ff89978fe13fb39cf78fce.png'),
(1015, 92, 2, '855baf1238e86e86962fe416d2dfec67.png'),
(1016, 92, 2, 'e6adf23f343652ee68fdcae82ba42aa6.png'),
(1017, 92, 2, '65a31c3344d0c232fcb1284eeec158d2.png'),
(1018, 92, 2, '08cbcbe3b28030ad828e59c67ba99be4.png'),
(1019, 92, 2, '734554237ee0df38619c05284afc50da.png'),
(1020, 92, 2, '98788f005e08a87e5c03a84384d63f91.png'),
(1021, 92, 2, 'cb4dbc7d72f7c8688e3a16406c681420.png'),
(1022, 92, 2, '96fccc3f2ffb860db55e767c443ff9e1.png'),
(1023, 92, 2, 'dfdccec45f0fee154038c6544a4cfaed.png'),
(1024, 92, 2, '37f5ebc45505bf188f827a8abacabadc.png'),
(1025, 92, 2, '708c15860659f7468dd7ddc13c3291dd.png'),
(1026, 92, 2, '7b9fe5ed432cfb7aa3ca84b9ba671805.png'),
(1027, 92, 2, '26a694641b6e8ab40d0f17cee57d8219.png'),
(1028, 92, 2, 'b7190ae0a084eea1ffee816dc40bfa6e.png'),
(1029, 92, 2, 'e81c1acd895f07fc7641e3a630cffdd7.png'),
(1030, 92, 2, 'd04c085b501126c1f6df409796d035b0.png'),
(1031, 92, 2, '6bff8c7419927c3ae4420edcac284a52.png'),
(1032, 95, 2, 'bf04dce5491f6c020632d24de53dafb0.png'),
(1033, 95, 2, '48991301b48b553f915944ba8a5cffaa.png'),
(1034, 95, 2, '256d94b05dcdec188e8205d2efc04c31.png'),
(1035, 95, 2, '0af91083c8ee615dc3c6081ce89312e7.png'),
(1036, 95, 2, '4e39bdf62bf7ec8d9fe854bf95999329.png'),
(1037, 95, 2, 'f2e8b16b4c1f2f3df5bf8f64aa93c902.png'),
(1038, 95, 2, '977b5dc91b70306ead165a07b057cf25.png'),
(1039, 95, 2, 'bc6c770d6e3213dca186036e09fa2a15.png'),
(1040, 95, 2, '37d1808354846f7476888570d93f7254.png'),
(1041, 96, 2, '5b40dce580c3faf1eb3a93f569a2dea5.png'),
(1042, 96, 2, '2e90253f48ed5cd2374e9a959a21f34b.png'),
(1043, 96, 2, 'bc8eb1d5f0365e2459b9a5cd34fafb62.png'),
(1044, 96, 2, '4ba59bc0263b76d327086af4feb3b025.png'),
(1045, 96, 2, '2df05569225b7342d37e8046bbc51056.png'),
(1046, 96, 2, '1222fe64f054238d78d6abbf0196e785.png'),
(1047, 96, 2, 'c0eedf2e056e6703b7e8514998c4272e.png'),
(1048, 96, 2, '38b9719f28299fac3231d82ca1fcd885.png'),
(1049, 96, 2, '2df6b4e6b8f019a4555ae36b9a7b1daf.png'),
(1050, 96, 2, '89c514d08db9312af712f4e150503b23.png'),
(1051, 96, 2, '13c2eac3f765c2f257a143e99a87e290.png'),
(1052, 96, 2, 'c39b86af064c76d909618b31ecc6a0c0.png'),
(1053, 96, 2, '531f065e89c89f58a6438dd118cad0e6.png'),
(1054, 96, 2, '6bca366d8edc2e30466712e7121ea7be.png'),
(1055, 96, 2, 'fc8fbd06faca5a7aa16ca158e91525d6.png'),
(1056, 96, 2, '7a17a1fc7283af9bb73b269f67f87662.png'),
(1057, 96, 2, '7854c964c7bf0475e0b96343e0a4baeb.png'),
(1058, 96, 2, 'ae513a224b6fab07dfff68ab8dec9d69.png'),
(1059, 96, 2, 'e5d8a1e0e507a249545fa5892f33bdcd.png'),
(1060, 96, 2, 'c11ad3ac642341f5fc80814e0724a617.png'),
(1061, 96, 2, '4ffc9e704af961782444eb0b114e2d36.png'),
(1062, 96, 2, 'affdd25bff6b5d176acc9faf30d1d9d8.png'),
(1063, 96, 2, '0b3080c9ce2e522b2dca224d9fa20620.png'),
(1064, 96, 2, 'c330299fb8c3c900adfe349062b1ac42.png'),
(1065, 96, 2, '49730e95306061b5f0040e00a7a90e5a.png'),
(1066, 96, 2, 'cd558053abd503bbaa0f1e011025ecc1.png'),
(1067, 97, 2, 'b0f6824ff00147ac8879cd329131d83c.png'),
(1068, 97, 2, 'f2dc57ff889e76f4dbf754ac5ad2c855.png'),
(1069, 97, 2, '9d959fe3f8a5b1c96c39c48d2844b1cc.png'),
(1070, 97, 2, '32aa7e59007f17b7b34a96da7886a863.png'),
(1071, 97, 2, 'db98b62f6aaf062a5523f47ed0e48c25.png'),
(1072, 97, 2, '31f1cb11f55a501972c3b3263653979e.png'),
(1073, 97, 2, '816ec8478dacd2779450d1f63bb5ba56.png'),
(1074, 97, 2, '393eb6b4eff78d31c152b74027fe8aac.png'),
(1075, 97, 2, '6d09afd228437aa671135b98ca853c42.png'),
(1076, 98, 2, 'dee2910e801bd29f299c1df84d6f3253.png'),
(1077, 98, 2, 'feff964cad018b1e19147756c5edf504.png'),
(1078, 98, 2, '22dcf4dc3ed0ed1d267dd146f3dacd7f.png'),
(1079, 98, 2, '9fc50552976d7aedb3d0021190b42b06.png'),
(1080, 98, 2, '4954dffb5bba06ea7382750390d5e558.png'),
(1081, 98, 2, 'd788e51ca2455e2286dd44c4293ad358.png'),
(1082, 98, 2, '62a9a54efd59c6b516d15ab202982547.png'),
(1083, 98, 2, 'fd9c99ef0f20eede609d38742652b4cd.png'),
(1084, 98, 2, '6993f647c94897a36e1f7b267984dcf3.png'),
(1085, 99, 2, 'fbb7ab8a419ef422b6a1f442c8f010cc.png'),
(1086, 100, 2, 'c86143cf32e9f42569e681fa520550f0.png'),
(1087, 100, 2, '4cf59e1a3d692efa7af57b8aa16e601b.png'),
(1088, 100, 2, '9aea0585c2aaca53c9e1666cdb22deed.png'),
(1089, 100, 2, '2e95aae5285ab8ae7e8bb834d4001464.png'),
(1090, 100, 2, 'f3904fbfbc12b2a9771eb00e23f75caa.png'),
(1091, 101, 2, 'd0b9ad94889deed933be2f45f99578fd.png'),
(1092, 101, 2, 'dfc9b42c74be9e2d22164a6206d81c58.png'),
(1093, 101, 2, '3264598fa7cd46aeec152541957feaae.png'),
(1094, 101, 2, 'c6b491f84cf861f8d76a483aaf80c724.png'),
(1095, 102, 2, '4b5d930c079071dd8b91a9af92e5a8ce.jpg'),
(1096, 103, 2, '3e5195d85e118e5e119a76bceaa9531b.jpg'),
(1097, 104, 2, '72a6de545488e812926174b7e5cc5a5d.jpg'),
(1098, 106, 2, '1afe80ada3bf639cb7bc7c82e5ad6e2d.jpg'),
(1099, 107, 2, '31889712cc77d09ef017485162292252.jpg'),
(1100, 108, 2, '670d53ba89b71abc5def64fc3dccac98.jpg'),
(1101, 109, 2, 'a2adb01f2235c7719073ba8022bd954e.jpg'),
(1102, 110, 2, 'd919a0d10c02b551afb89415979f95ff.jpg'),
(1103, 111, 2, '4bf4471309d551312503da15b5e3387c.jpg'),
(1104, 112, 2, 'd90b30721e99c7b09140a02c733a4b69.jpg'),
(1105, 113, 2, 'af45d762e83b9d816dc44ac560209777.jpg'),
(1106, 114, 2, '26d60f48af705568d7f73d84c57fafa7.jpg'),
(1107, 115, 2, '43755e7bb4d12f4c72e2a99d8570a6de.jpg');

-- --------------------------------------------------------

--
-- Estrutura para tabela `app_anuncios_info`
--

CREATE TABLE `app_anuncios_info` (
  `id` int NOT NULL,
  `app_anuncios_types_id` int NOT NULL,
  `adultos` int DEFAULT NULL,
  `criancas` int DEFAULT NULL,
  `quartos` int DEFAULT NULL,
  `banheiros` int DEFAULT NULL,
  `pets` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Despejando dados para a tabela `app_anuncios_info`
--

INSERT INTO `app_anuncios_info` (`id`, `app_anuncios_types_id`, `adultos`, `criancas`, `quartos`, `banheiros`, `pets`) VALUES
(43, 43, 8, 0, 5, 4, 1),
(44, 44, 8, 0, 5, 4, 1),
(55, 55, 2, 1, 1, 1, 2),
(57, 57, 2, 1, 1, 1, 1),
(59, 59, 2, 1, 1, 1, 2),
(60, 60, 2, 1, 1, 1, 1),
(61, 61, 2, 0, 1, 1, 1),
(62, 62, 2, 0, 1, 1, 2),
(63, 63, 2, 0, 1, 1, 1),
(64, 64, 2, 0, 1, 1, 1),
(65, 65, 2, 0, 1, 1, 2),
(66, 66, 2, 0, 1, 1, 2),
(67, 67, 2, 0, 1, 1, 2),
(68, 68, 2, 0, 1, 1, 2),
(69, 69, 2, 0, 1, 1, 2),
(70, 70, 2, 0, 1, 1, 2),
(71, 71, 4, 1, 1, 1, 1),
(72, 72, 4, 1, 1, 1, 1),
(74, 74, 20, 20, 0, 1, 1),
(75, 75, 1, 1, 0, 2, 1),
(76, 76, 2, 1, 0, 1, 2),
(77, 77, 2, 1, 0, 0, 2),
(79, 79, 2, 1, 0, 0, 2),
(80, 80, 2, 1, 0, 1, 2),
(81, 81, 3, 1, 0, 1, 2),
(82, 82, 2, 1, 0, 0, 1),
(83, 83, 2, 1, 1, 1, 1),
(84, 84, 2, 1, 2, 0, 1),
(85, 86, 2, 1, 0, 0, 2),
(86, 87, 2, 1, 0, 0, 2),
(87, 88, 2, 1, 0, 0, 2),
(88, 89, 2, 0, 1, 0, 2),
(89, 90, 1, 1, 0, 0, 2),
(90, 91, 1, 1, 0, 0, 0),
(91, 92, 1, 0, 0, 0, 0),
(92, 93, 1, 0, 0, 0, 0),
(93, 94, 1, 0, 0, 0, 0);

-- --------------------------------------------------------

--
-- Estrutura para tabela `app_anuncios_ing_types`
--

CREATE TABLE `app_anuncios_ing_types` (
  `id` int NOT NULL,
  `app_anuncios_id` int NOT NULL,
  `tipo` int DEFAULT NULL COMMENT '1 - masc\n2 - fem\n3 - ambos\n',
  `nome` varchar(60) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL,
  `valor` decimal(10,2) DEFAULT NULL,
  `cortesia` tinyint(1) DEFAULT '0' COMMENT '0=pago, 1=cortesia/gratuito',
  `qtd` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Despejando dados para a tabela `app_anuncios_ing_types`
--

INSERT INTO `app_anuncios_ing_types` (`id`, `app_anuncios_id`, `tipo`, `nome`, `valor`, `cortesia`, `qtd`) VALUES
(16, 102, 3, 'Ingresso 2 pessoas', 1.00, 0, 5),
(17, 103, 3, 'Ingresso Mesa 2 pessoas ', 1.00, 0, 5),
(18, 103, 3, 'Ingresso Mesa 3 pessoas', 1.00, 0, 5),
(19, 103, 3, 'Ingresso mesa 4 pessoas', 1.00, 0, 5),
(20, 104, 3, 'Ingresso full', 29.00, 0, 50),
(21, 109, 3, '99', 99.99, 0, 30),
(22, 114, 1, 'Cortesia', 0.00, 1, 20),
(23, 115, 1, 'Ingresso bao', 0.00, 1, 10);

-- --------------------------------------------------------

--
-- Estrutura para tabela `app_anuncios_location`
--

CREATE TABLE `app_anuncios_location` (
  `id` int NOT NULL,
  `app_anuncios_id` int NOT NULL,
  `latitude` varchar(50) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL,
  `longitude` varchar(50) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL,
  `end` text CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci,
  `rua` varchar(100) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL,
  `bairro` varchar(60) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL,
  `cidade` varchar(60) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL,
  `estado` varchar(60) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL,
  `numero` varchar(30) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL,
  `complemento` varchar(30) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL,
  `referencia` varchar(60) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Despejando dados para a tabela `app_anuncios_location`
--

INSERT INTO `app_anuncios_location` (`id`, `app_anuncios_id`, `latitude`, `longitude`, `end`, `rua`, `bairro`, `cidade`, `estado`, `numero`, `complemento`, `referencia`) VALUES
(95, 65, '-30.2134574', '-51.1285325', 'Avenida do Lami, 5192 - Belém Novo, Porto Alegre - RS, Brazil', 'Avenida do Lami', 'Belém Novo', 'Porto Alegre', 'RS', '5192', 'vila4ventos ', ''),
(120, 78, '-28.0149981', '-49.5929509', 'Refúgio Terras do Sul - Camping e Hostel - EST GERAL RIO DO BISPO - RIO DO BISPO, Urubici - Santa Catarina, Brazil', 'Rua Agemiro Ferreira', '', 'Urubici', 'SC', '1', '', ''),
(124, 80, '-28.0149981', '-49.5929509', 'Refúgio Terras do Sul - Camping e Hostel - EST GERAL RIO DO BISPO - RIO DO BISPO, Urubici - Santa Catarina, Brazil', 'Rua Agemiro Ferreira', '', 'Urubici', 'SC', '1', '', ''),
(128, 82, '-28.0739855', '-49.4195662', 'Refúgio Terras do Sul - Camping e Hostel - EST GERAL RIO DO BISPO - RIO DO BISPO, Urubici - Santa Catarina, Brazil', '', '', 'Urubici', 'SC', '1', '', ''),
(130, 83, '-28.0149981', '-49.5929509', 'Refúgio Terras do Sul - Camping e Hostel - EST GERAL RIO DO BISPO - RIO DO BISPO, Urubici - Santa Catarina, Brazil', 'Rua Agemiro Ferreira', '', 'Urubici', 'SC', '1', '', ''),
(132, 84, '-28.0149981', '-49.5929509', 'Refúgio Terras do Sul - Camping e Hostel - EST GERAL RIO DO BISPO - RIO DO BISPO, Urubici - Santa Catarina, Brazil', 'Rua Agemiro Ferreira', '', 'Urubici', 'SC', '1', '', ''),
(135, 86, '-28.0739855', '-49.4195662', 'Refúgio Terras do Sul - Camping e Hostel - EST GERAL RIO DO BISPO - RIO DO BISPO, Urubici - Santa Catarina, Brazil', '', '', 'Urubici', 'SC', '1', '', ''),
(137, 87, '-28.0739855', '-49.4195662', 'Refúgio Terras do Sul - Camping e Hostel - EST GERAL RIO DO BISPO - RIO DO BISPO, Urubici - Santa Catarina, Brazil', '', '', 'Urubici', 'SC', '1', '', ''),
(139, 88, '-28.0739855', '-49.4195662', 'Refúgio Terras do Sul - Camping e Hostel - EST GERAL RIO DO BISPO - RIO DO BISPO, Urubici - Santa Catarina, Brazil', '', '', 'Urubici', 'SC', '1', '', ''),
(141, 89, '-28.0739855', '-49.4195662', 'Refúgio Terras do Sul - Camping e Hostel - EST GERAL RIO DO BISPO - RIO DO BISPO, Urubici - Santa Catarina, Brazil', '', '', 'Urubici', 'SC', '1', '', ''),
(142, 65, '', '', '', '', '', '', '', '', '', ''),
(144, 90, '-28.0739855', '-49.4195662', 'Refúgio Terras do Sul - Camping e Hostel - EST GERAL RIO DO BISPO - RIO DO BISPO, Urubici - Santa Catarina, Brazil', '', '', 'Urubici', 'SC', '1', '', ''),
(147, 91, '-28.0739855', '-49.4195662', 'Refúgio Terras do Sul - Camping e Hostel - EST GERAL RIO DO BISPO - RIO DO BISPO, Urubici - Santa Catarina, Brazil', '', '', 'Urubici', 'SC', '1', '', ''),
(150, 92, '-28.0739855', '-49.4195662', 'Refúgio Terras do Sul - Camping e Hostel - EST GERAL RIO DO BISPO - RIO DO BISPO, Urubici - Santa Catarina, Brazil', '', '', 'Urubici', 'SC', '1', '', ''),
(155, 94, '-28.0739855', '-49.4195662', 'Refúgio Terras do Sul - Camping e Hostel - EST GERAL RIO DO BISPO - RIO DO BISPO, Urubici - Santa Catarina, Brazil', '', '', 'Urubici', 'SC', '1', '', ''),
(157, 95, '-27.8347952', '-50.3296264', 'Morro da Cruz - Lages SC - Morro Grande, Lages - Santa Catarina, Brazil', 'Rua João Odilo Madruga', 'Morro Grande', 'Lages', 'SC', '1', '', ''),
(159, 96, '-28.7284888', '-49.3290106', 'Basílica Santuário do Sagrado Coração Misericordioso de Jesus, ICR-253 - Bairro Morro Bonito, Içara - Santa Catarina, Brazil', '', '', 'Içara', 'SC', '253', '', ''),
(161, 97, '-28.0409358', '-49.4846977', 'Acesso ao Morro da Igreja - Santa Teresinha, Urubici - Santa Catarina, Brazil', '', '', 'Urubici', 'SC', 'SC 370', '', ''),
(163, 98, '-28.0268515', '-49.5020043', 'Gruta Nossa Senhora de Lourdes - Antidio Warmling - Santa Teresinha, Urubici - SC, 88650-000, Brazil', 'Antidio Warmling', '', 'Urubici', 'SC', '1', '', ''),
(164, 78, '', '', '', '', '', '', '', '', '', ''),
(166, 99, '-28.0154622', '-49.5919968', 'Paróquia Nossa Senhora Mãe dos Homens - Rua Policarpo de Souza Costa, Urubici - Santa Catarina, Brazil', 'Rua Policarpo de Souza Costa', '', 'Urubici', 'SC', '1176', '', ''),
(167, 80, '', '', '', '', '', '', '', '', '', ''),
(168, 100, '-27.7128548', '-49.393274', 'Gruta do Poço Certo - Lomba Alta - Zona Rural, Alfredo Wagner - SC, 88450-000, Brazil', '', '', 'Alfredo Wagner', 'SC', '1', '', ''),
(170, 101, '-28.2664685', '-49.8441898', 'Cachoeira do Pirata - São Joaquim, Santa Catarina, Brazil', '', '', 'São Joaquim', 'SC', '1', '', ''),
(171, 82, '', '', '', '', '', '', '', '', '', ''),
(172, 102, '-30.0322449', '-51.2075081', 'Casa Radiosul - Rua Vasco da Gama - Bom Fim, Porto Alegre - RS, Brazil', 'Rua Vasco da Gama', 'Rio Branco', 'Porto Alegre', 'RS', '460', '', ''),
(173, 103, '-30.02889175466407', '-51.20412848889828', 'Rua Mostardeiro, 287, Rio Branco, Porto Alegre', 'Rua Mostardeiro', 'Moinhos de Vento', 'Porto Alegre', 'RS', '460', '', ''),
(174, 104, '-18.8751182954586', '-41.96957319974899', 'Av. Eng. Humberto Tavares das Chagas, Jardim Pérola, ', 'Avenida Engenheiro Humberto Tavares das Chagas', 'Jardim Pérola', 'Governador Valadares', 'MG', '231', '', ''),
(175, 105, '', '', '', '', '', '', '', '', '', ''),
(176, 83, '', '', '', '', '', '', '', '', '', ''),
(177, 106, '-16.69316308133497', '-43.86930204927921', 'Av. Comendador Antonio Loureiro Ramos, Distrito Industrial, ', 'Avenida Comendador Antonio Loureiro Ramos', 'Distrito Industrial', 'Montes Claros', 'MG', '999', '', ''),
(178, 84, '', '', '', '', '', '', '', '', '', ''),
(179, 107, '-16.6908668', '-43.8403889', 'Av. Rui de Albuquerque - Planalto, Montes Claros - Minas Gerais, Brazil', 'Avenida Rui de Albuquerque', 'Jk II', 'Montes Claros', 'MG', '9999', '', ''),
(180, 108, '-16.7291552', '-43.8670745', 'Montes Claros, Minas Gerais, Brazil', 'Jardim Europa 2', 'Centro', 'Montes Claros', 'MG', '9999', '', ''),
(181, 109, '-16.7291552', '-43.8670745', 'Montes Claros, MG, Brazil', 'Jardim Europa 2', 'Centro', 'Montes Claros', 'MG', '999', '', ''),
(182, 110, '-16.7291552', '-43.8670745', 'Montes Claros, Minas Gerais, Brazil', 'Jardim Europa 2', 'Centro', 'Montes Claros', 'MG', '9999', '', ''),
(183, 111, '-16.1272436', '-45.7388957', 'Avenida Moc, 999, Urucuia - Minas Gerais, Brazil', 'Av. Antônio Esteves Dos Anjos', '', 'Urucuia', 'MG', 'moc9', 'asdf', 'asdf'),
(184, 112, '-9.6498597', '-35.7089506', 'Maceió, Alagoas, Brazil', 'Avenida Empresário Carlos da Silva Nogueira', 'Jatiúca', 'Maceió', 'AL', '999', '', ''),
(185, 113, '-16.4443537', '-39.0653656', 'Porto Seguro, Bahia, Brazil', 'Avenida dos Navegantes', 'Centro', 'Porto Seguro', 'BA', '99', '', ''),
(186, 114, '-16.7291552', '-43.8670745', 'Montes Claros, Minas Gerais, Brazil', 'Jardim Europa 2', 'Centro', 'Montes Claros', 'MG', '99', '', ''),
(187, 115, '-16.7291552', '-43.8670745', 'Montes Claros, Minas Gerais, Brazil', 'Jardim Europa 2', 'Centro', 'Montes Claros', 'MG', '999', '', '');

-- --------------------------------------------------------

--
-- Estrutura para tabela `app_anuncios_types`
--

CREATE TABLE `app_anuncios_types` (
  `id` int NOT NULL,
  `app_anuncios_id` int NOT NULL,
  `nome` varchar(60) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL,
  `descricao` text CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci,
  `status` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Despejando dados para a tabela `app_anuncios_types`
--

INSERT INTO `app_anuncios_types` (`id`, `app_anuncios_id`, `nome`, `descricao`, `status`) VALUES
(43, 65, '431 432 433 434', 'suítes retro com  cama casal com vista ', 1),
(44, 65, '431 432 433 434', 'suítes retro com  cama casal com vista ', 1),
(55, 78, 'Quarto Casal ', 'Quarto casal com opção de sofá cama.', 0),
(57, 80, 'Quarto Casal', 'Cama de casal com opção de sofá cama ', 1),
(59, 82, 'Quarto Casal', 'Cama de casal ', 0),
(60, 83, 'Quarto casal', 'Cama de casal', 1),
(61, 84, 'Quarto para casal', 'Casal', 1),
(62, 86, 'Quarto para casal', 'Casal', 0),
(63, 87, 'Estadia Casal', 'Casal para sofá cama', 1),
(64, 88, 'Estadia Casal', 'Quarto com sofá cama.', 1),
(65, 89, 'Estadia Dias de Semana', 'Cabana com sofá cama. Estadias válidas de Segunda a Quinta', 0),
(66, 89, 'Estadia Fins de Semana', 'Cabana com sofá cama. Estadias válidas de Sexta a Domingo', 0),
(67, 90, 'Estadia Dias de semana', 'Quarto Casal, valores válos de Segunda a Quinta', 0),
(68, 90, 'Estadia Fins de Semana', 'Quarto Casal, valores válos de Sexta a Domingo.', 0),
(69, 91, 'Estadia Dias de Semana', 'Estadias válidas se Seguda a Quinta', 0),
(70, 91, 'Estadia Fins de Semana', 'Estadias válidas de Sexta à Domingo', 0),
(71, 92, 'Estadia Dias de Semana ', 'Cama de casal com opção de sofá cama. Estadias válidas de Segunda a Quinta. Valor Casal.', 1),
(72, 92, 'Estadia Fins de Semana', 'Cama de casal com opção de sofá cama. Estadias válidas de Sexta a Domingo', 1),
(74, 94, 'Day Use', 'Valor por pessoa.', 1),
(75, 95, 'Visita Gratuita', 'Aberto 24h', 1),
(76, 96, 'Missas e visitações', 'Entrada gratuita', 1),
(77, 97, 'Visitação ', 'Entrada Gratuita ', 1),
(79, 98, 'Visitação', 'Valor simbólico.', 0),
(80, 99, 'Visitação', 'Entrada Gratuita.', 1),
(81, 100, 'Visitação', 'Valor Simbólico de R$10,00 a entrada', 1),
(82, 101, 'Visitação', 'Acesso Gratuito', 1),
(83, 105, 'asdfasd', 'asdfsad', 1),
(84, 106, 'bao', 'sadfsad', 1),
(85, 107, 'Pacote bao', 'bao', 1),
(86, 107, 'Pacote bao', 'bao', 1),
(87, 107, 'Pacote bao', 'bao', 1),
(88, 107, 'Pacote teste', 'teste', 1),
(89, 108, 'Quarto 2', 'teste', 1),
(90, 110, 'Pacote bao', 'asdfasdf', 1),
(91, 110, 'Experiencia', 'pacote bao', 1),
(92, 111, 'pacote 1', 'teste', 1),
(93, 112, 'Pacote bao', '123', 1),
(94, 113, 'pacote bao', '123', 1);

-- --------------------------------------------------------

--
-- Estrutura para tabela `app_anuncios_types_fotos`
--

CREATE TABLE `app_anuncios_types_fotos` (
  `id` int NOT NULL,
  `app_anuncios_types_id` int NOT NULL,
  `capa` int DEFAULT NULL,
  `url` text CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Despejando dados para a tabela `app_anuncios_types_fotos`
--

INSERT INTO `app_anuncios_types_fotos` (`id`, `app_anuncios_types_id`, `capa`, `url`) VALUES
(64, 43, 2, 'e9451dc9e8a6bf639a12b499e82f47b6.jpg'),
(65, 43, 2, '11f03e4c63f6cdbb938fa8bfffa58d39.jpg'),
(66, 43, 2, 'c5ffbfed37b76c643ff059a611773607.jpg'),
(67, 44, 2, '90340baa7268ddee2d859e6621ec0cc8.jpg'),
(68, 44, 2, 'ea673c07c892bea53a26ad6650b12159.jpg'),
(69, 44, 2, '4e4e978f256bd1a671bb982a5c2c0a4e.jpg'),
(105, 55, 2, '7c010edfd515b1d4681b177148f95ccc.png'),
(107, 57, 2, '4b9e263f32c2ade967fb8e88cc83d1b5.png'),
(109, 59, 2, '0ba2e470a67f1d84b6141882c8c63c1f.png'),
(110, 59, 2, 'e0863f4d9cc78170b2e0d42540a499e8.png'),
(111, 59, 2, 'e412840c78c6b081bd7f5a438a172064.png'),
(112, 60, 2, 'bc15049cab8d90eb6fb62c28cfe8cdb8.png'),
(113, 60, 2, '1232b81af16b791ee4d8b918d6287630.png'),
(114, 60, 2, 'b73ee5e2a4d19d7a6bb7c32bc3190cc6.png'),
(115, 61, 2, '67f804f5cecf321319ace9c54fca04eb.png'),
(116, 62, 2, '842ec7f0c9ad0dc6d20916eb1bb6c879.png'),
(117, 63, 2, 'ba007027cae8812f80f9718ffec77762.png'),
(118, 64, 2, '732221ebc2f3e04ed6a5a01c2c1ecb30.png'),
(119, 65, 2, 'a4a2841f1918616cf611cc9b789d7e53.png'),
(120, 66, 2, '9d282a45c0160f88c48511e1b90e9fae.png'),
(121, 67, 2, 'e71598a817796a6bce101fe1e575d411.png'),
(122, 67, 2, 'bc1a270569d2a11925e369f021b66c43.png'),
(123, 67, 2, '1d18e134a3a7b68a430ea46f1d8f40b4.png'),
(124, 68, 2, '23203b459dd555286ab2fc307ad7381a.png'),
(125, 68, 2, '578eaf40534b796ec78c5f0f23978c5e.png'),
(126, 68, 2, '487b95890bd82564c7b0912cd35d1e29.png'),
(127, 69, 2, '1f7c355b1fce6a1ce8144c54d216c7ad.png'),
(128, 70, 2, '54eacf2c7c576121aeb03ca51a04746d.png'),
(129, 71, 2, 'c51867d677e2214b0f3643a6bd648b3d.png'),
(130, 72, 2, 'c594958ad35461e51037a86a43641289.png'),
(132, 74, 2, '1d6b4bd86ef744c7097a0d9f8156fca3.png'),
(133, 75, 2, '197938a2ce98ca3946c907fb25909ac3.png'),
(134, 76, 2, 'fecea950fe5d478bf66cbde9f9b855e6.png'),
(135, 77, 2, 'c0466797802322092ddb022e0b5b4e7b.png'),
(137, 79, 2, 'd8362056cdc8d4e0b53ecdac983ddd44.png'),
(138, 80, 2, '032f948718b16cce4bb845f22a9bb806.png'),
(139, 81, 2, '539a59bb9d6675ffd8edd1d8b3b44cf7.png'),
(140, 82, 2, '7f61c3666e59efefe769358240e86e14.png'),
(141, 83, 2, '4b45fc50e7cec9e6f2d51ffc8b2b01b0.jpg'),
(142, 84, 2, '3b18dc2d27f9d5c21e93b6f00e09e97d.jpg'),
(143, 89, 2, '4ca1ca281a71596233de89d22c172cf7.jpg'),
(144, 91, 2, 'dbc57d346804628d2d278877a43551f5.jpg'),
(145, 92, 2, '1877f73ebd3815c749d809224321c710.jpg'),
(146, 93, 2, '492b3c13322fa4dadf24470797844ba6.jpg'),
(147, 94, 2, 'ce721fd7a8cdc765b5f43841c70975a7.jpg');

-- --------------------------------------------------------

--
-- Estrutura para tabela `app_anuncios_types_unidades`
--

CREATE TABLE `app_anuncios_types_unidades` (
  `id` int NOT NULL,
  `app_anuncios_types_id` int NOT NULL,
  `numero` int NOT NULL COMMENT 'Número da unidade (1, 2, 3...)',
  `nome` varchar(100) DEFAULT NULL COMMENT 'Nome opcional da unidade (ex: Quarto 101, Suíte A)',
  `status` tinyint DEFAULT '1' COMMENT '1=ativo, 0=inativo',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci COMMENT='Unidades físicas de cada tipo de quarto';

--
-- Despejando dados para a tabela `app_anuncios_types_unidades`
--

INSERT INTO `app_anuncios_types_unidades` (`id`, `app_anuncios_types_id`, `numero`, `nome`, `status`, `created_at`) VALUES
(1, 43, 1, 'Suíte 431', 1, '2025-11-30 21:08:24'),
(2, 43, 2, 'Unidade 2', 1, '2025-11-30 21:08:24'),
(3, 43, 3, 'Unidade 3', 1, '2025-11-30 21:08:24'),
(4, 43, 4, 'Unidade 4', 1, '2025-11-30 21:08:24'),
(5, 44, 1, 'Unidade 1', 1, '2025-11-30 21:08:24'),
(6, 44, 2, 'Unidade 2', 1, '2025-11-30 21:08:24'),
(7, 44, 3, 'Unidade 3', 1, '2025-11-30 21:08:24'),
(8, 44, 4, 'Unidade 4', 1, '2025-11-30 21:08:24'),
(9, 83, 1, 'Unidade 1', 1, '2025-11-30 21:48:37'),
(10, 83, 2, 'Unidade 2', 1, '2025-11-30 21:48:37'),
(11, 83, 3, 'Unidade 3', 1, '2025-11-30 21:48:37'),
(12, 83, 4, 'Unidade 4', 1, '2025-11-30 21:48:37'),
(13, 83, 5, 'Unidade 5', 1, '2025-11-30 21:48:37'),
(14, 89, 1, 'suite 101', 1, '2025-11-30 21:52:17'),
(15, 89, 2, 'Unidade 2', 1, '2025-11-30 21:52:17'),
(16, 89, 3, 'Unidade 3', 1, '2025-11-30 21:52:17'),
(17, 89, 4, 'suite 102', 1, '2025-11-30 21:52:17');

-- --------------------------------------------------------

--
-- Estrutura para tabela `app_anuncios_valor`
--

CREATE TABLE `app_anuncios_valor` (
  `id` int NOT NULL,
  `app_anuncios_types_id` int NOT NULL,
  `nome` varchar(60) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL,
  `data_de` date DEFAULT NULL,
  `data_ate` date DEFAULT NULL,
  `valor` decimal(10,2) DEFAULT NULL,
  `cortesia` tinyint(1) DEFAULT '0' COMMENT '0=pago, 1=cortesia/gratuito',
  `desc_min_diarias` int DEFAULT NULL,
  `taxa_limpeza` decimal(10,2) DEFAULT NULL,
  `qtd` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Despejando dados para a tabela `app_anuncios_valor`
--

INSERT INTO `app_anuncios_valor` (`id`, `app_anuncios_types_id`, `nome`, `data_de`, `data_ate`, `valor`, `cortesia`, `desc_min_diarias`, `taxa_limpeza`, `qtd`) VALUES
(46, 43, '', '2025-08-15', '2025-08-15', 480.00, 0, 0, 120.00, 4),
(47, 44, '', '2025-08-15', '2025-08-15', 480.00, 0, 0, 120.00, 4),
(64, 55, '', '2025-09-01', '2025-09-04', 250.00, 0, 0, 0.00, 4),
(65, 55, '', '2025-09-08', '2025-09-11', 250.00, 0, 0, 0.00, 4),
(66, 55, '', '2025-09-15', '2025-09-18', 250.00, 0, 0, 0.00, 4),
(67, 55, '', '2025-09-22', '2025-09-25', 250.00, 0, 0, 0.00, 4),
(68, 55, '', '2025-09-29', '2025-10-02', 250.00, 0, 0, 0.00, 4),
(69, 55, '', '2025-10-06', '2025-10-09', 250.00, 0, 0, 0.00, 4),
(70, 55, '', '2025-10-13', '2025-10-16', 250.00, 0, 0, 0.00, 4),
(71, 55, '', '2025-10-20', '2025-10-23', 250.00, 0, 0, 0.00, 4),
(73, 57, '', '2025-08-29', '2025-08-31', 350.00, 0, 0, 0.00, 3),
(74, 57, '', '2025-09-05', '2025-09-07', 350.00, 0, 0, 0.00, 3),
(75, 57, '', '2025-09-12', '2025-09-14', 350.00, 0, 0, 0.00, 3),
(76, 57, '', '2025-09-19', '2025-09-21', 350.00, 0, 0, 0.00, 3),
(77, 57, '', '2025-09-26', '2025-09-28', 350.00, 0, 0, 0.00, 3),
(78, 57, '', '2025-10-03', '2025-10-05', 350.00, 0, 0, 0.00, 3),
(79, 57, '', '2025-10-10', '2025-10-12', 350.00, 0, 0, 0.00, 3),
(80, 57, '', '2025-10-17', '2025-10-19', 350.00, 0, 0, 0.00, 3),
(81, 57, '', '2025-10-24', '2025-10-26', 350.00, 0, 0, 0.00, 3),
(82, 57, '', '2025-10-31', '2025-10-31', 350.00, 0, 0, 0.00, 1),
(84, 59, '', '2025-09-01', '2025-09-04', 250.00, 0, 0, 0.00, 4),
(85, 59, '', '2025-09-08', '2025-09-11', 250.00, 0, 0, 0.00, 4),
(86, 59, '', '2025-09-15', '2025-09-18', 250.00, 0, 0, 0.00, 4),
(87, 59, '', '2025-09-22', '2025-09-25', 250.00, 0, 0, 0.00, 4),
(88, 59, '', '2025-09-29', '2025-10-02', 250.00, 0, 0, 0.00, 4),
(89, 59, '', '2025-10-06', '2025-10-09', 250.00, 0, 0, 0.00, 4),
(90, 59, '', '2025-10-13', '2025-10-16', 250.00, 0, 0, 0.00, 4),
(91, 59, '', '2025-10-20', '2025-10-23', 250.00, 0, 0, 0.00, 4),
(92, 59, '', '2025-10-27', '2025-10-30', 250.00, 0, 0, 0.00, 4),
(93, 60, '', '2025-09-05', '2025-09-07', 350.00, 0, 0, 0.00, 3),
(94, 60, '', '2025-09-12', '2025-09-14', 350.00, 0, 0, 0.00, 3),
(95, 60, '', '2025-09-19', '2025-09-21', 350.00, 0, 0, 0.00, 3),
(96, 60, '', '2025-09-26', '2025-09-28', 350.00, 0, 0, 0.00, 3),
(97, 60, '', '2025-10-03', '2025-10-05', 350.00, 0, 0, 0.00, 3),
(98, 60, '', '2025-10-10', '2025-10-12', 350.00, 0, 0, 0.00, 3),
(99, 60, '', '2025-10-17', '2025-10-19', 350.00, 0, 0, 0.00, 3),
(100, 60, '', '2025-10-24', '2025-10-26', 350.00, 0, 0, 0.00, 3),
(101, 60, '', '2025-10-31', '2025-10-31', 350.00, 0, 0, 0.00, 1),
(102, 61, '', '2025-09-05', '2025-09-07', 350.00, 0, 0, 0.00, 3),
(103, 61, '', '2025-09-12', '2025-09-14', 350.00, 0, 0, 0.00, 3),
(104, 61, '', '2025-09-19', '2025-09-21', 350.00, 0, 0, 0.00, 3),
(105, 61, '', '2025-09-26', '2025-09-28', 350.00, 0, 0, 0.00, 3),
(106, 61, '', '2025-10-03', '2025-10-05', 350.00, 0, 0, 0.00, 3),
(107, 61, '', '2025-10-10', '2025-10-12', 350.00, 0, 0, 0.00, 3),
(108, 61, '', '2025-10-17', '2025-10-19', 350.00, 0, 0, 0.00, 3),
(109, 61, '', '2025-10-24', '2025-10-26', 350.00, 0, 0, 0.00, 3),
(110, 61, '', '2025-10-31', '2025-10-31', 350.00, 0, 0, 0.00, 1),
(111, 55, '', '2025-10-27', '2025-10-30', 250.00, 0, 0, 0.00, 4),
(112, 62, '', '2025-09-01', '2025-09-04', 250.00, 0, 0, 0.00, 4),
(113, 62, '', '2025-09-08', '2025-09-11', 250.00, 0, 0, 0.00, 4),
(114, 62, '', '2025-09-15', '2025-09-18', 250.00, 0, 0, 0.00, 4),
(115, 62, '', '2025-09-22', '2025-09-25', 250.00, 0, 0, 0.00, 4),
(116, 62, '', '2025-09-29', '2025-10-02', 250.00, 0, 0, 0.00, 4),
(117, 62, '', '2025-10-06', '2025-10-09', 250.00, 0, 0, 0.00, 4),
(118, 62, '', '2025-10-13', '2025-10-16', 250.00, 0, 0, 0.00, 4),
(119, 62, '', '2025-10-20', '2025-10-23', 250.00, 0, 0, 0.00, 4),
(120, 62, '', '2025-10-27', '2025-10-30', 250.00, 0, 0, 0.00, 4),
(121, 63, '', '2025-09-05', '2025-09-07', 250.00, 0, 0, 0.00, 3),
(122, 63, '', '2025-09-12', '2025-09-14', 250.00, 0, 0, 0.00, 3),
(123, 63, '', '2025-09-19', '2025-09-21', 250.00, 0, 0, 0.00, 3),
(124, 63, '', '2025-09-26', '2025-09-28', 250.00, 0, 0, 0.00, 3),
(125, 63, '', '2025-10-03', '2025-10-05', 250.00, 0, 0, 0.00, 3),
(126, 63, '', '2025-10-10', '2025-10-12', 250.00, 0, 0, 0.00, 3),
(127, 63, '', '2025-10-17', '2025-10-19', 250.00, 0, 0, 0.00, 3),
(128, 63, '', '2025-10-24', '2025-10-26', 250.00, 0, 0, 0.00, 3),
(129, 63, '', '2025-10-31', '2025-10-31', 250.00, 0, 0, 0.00, 3),
(130, 64, '', '2025-09-01', '2025-09-04', 200.00, 0, 0, 0.00, 4),
(131, 64, '', '2025-09-08', '2025-09-11', 200.00, 0, 0, 0.00, 4),
(132, 64, '', '2025-09-15', '2025-09-18', 200.00, 0, 0, 0.00, 4),
(133, 64, '', '2025-09-22', '2025-09-25', 200.00, 0, 0, 0.00, 4),
(134, 64, '', '2025-09-29', '2025-10-02', 200.00, 0, 0, 0.00, 4),
(135, 64, '', '2025-10-06', '2025-10-09', 200.00, 0, 0, 0.00, 4),
(136, 64, '', '2025-10-13', '2025-10-16', 200.00, 0, 0, 0.00, 4),
(137, 64, '', '2025-10-20', '2025-10-23', 200.00, 0, 0, 0.00, 4),
(138, 64, '', '2025-10-27', '2025-10-30', 200.00, 0, 0, 0.00, 4),
(139, 65, '', '2025-11-03', '2025-11-06', 230.00, 0, 0, 0.00, 4),
(140, 65, '', '2025-11-10', '2025-11-13', 230.00, 0, 0, 0.00, 4),
(141, 65, '', '2025-09-17', '2025-09-18', 230.00, 0, 0, 0.00, 4),
(142, 65, '', '2025-11-24', '2025-11-27', 230.00, 0, 0, 0.00, 4),
(143, 65, '', '2025-11-24', '2025-11-27', 230.00, 0, 0, 0.00, 4),
(144, 65, '', '2025-12-01', '2025-12-04', 230.00, 0, 0, 0.00, 4),
(145, 65, '', '2025-12-08', '2025-12-11', 230.00, 0, 0, 0.00, 4),
(146, 65, '', '2025-12-15', '2025-12-18', 230.00, 0, 0, 0.00, 4),
(147, 65, '', '2025-12-22', '2025-12-25', 230.00, 0, 0, 0.00, 4),
(148, 65, '', '2025-12-29', '2026-01-01', 230.00, 0, 0, 0.00, 4),
(149, 65, '', '2026-01-05', '2026-01-08', 230.00, 0, 0, 0.00, 4),
(150, 65, '', '2026-01-12', '2026-01-15', 230.00, 0, 0, 0.00, 4),
(151, 65, '', '2026-01-19', '2026-01-22', 230.00, 0, 0, 0.00, 4),
(152, 65, '', '2026-01-26', '2026-01-29', 230.00, 0, 0, 0.00, 4),
(153, 66, '', '2025-11-07', '2025-11-09', 280.00, 0, 0, 0.00, 3),
(154, 66, '', '2025-11-14', '2025-11-16', 280.00, 0, 0, 0.00, 3),
(155, 66, '', '2025-11-21', '2025-11-23', 280.00, 0, 0, 0.00, 3),
(156, 66, '', '2025-11-28', '2025-11-30', 280.00, 0, 0, 0.00, 3),
(157, 66, '', '2025-12-05', '2025-12-07', 280.00, 0, 0, 0.00, 3),
(158, 66, '', '2025-12-12', '2025-12-14', 280.00, 0, 0, 0.00, 3),
(159, 66, '', '2025-12-19', '2025-12-21', 280.00, 0, 0, 0.00, 3),
(160, 66, '', '2025-12-26', '2025-12-28', 280.00, 0, 0, 0.00, 3),
(161, 66, '', '2026-01-02', '2026-01-04', 280.00, 0, 0, 0.00, 3),
(162, 66, '', '2026-01-09', '2026-01-11', 280.00, 0, 0, 0.00, 3),
(163, 66, '', '2026-01-16', '2026-01-18', 280.00, 0, 0, 0.00, 3),
(164, 66, '', '2026-01-23', '2026-01-25', 280.00, 0, 0, 0.00, 3),
(165, 66, '', '2026-01-30', '2026-02-01', 280.00, 0, 0, 0.00, 3),
(166, 67, '', '2025-11-03', '2025-11-06', 280.00, 0, 0, 0.00, 4),
(167, 67, '', '2025-11-10', '2025-11-13', 280.00, 0, 0, 0.00, 4),
(168, 67, '', '2025-11-17', '2025-11-20', 280.00, 0, 0, 0.00, 4),
(169, 67, '', '2025-12-01', '2025-12-04', 280.00, 0, 0, 0.00, 4),
(170, 68, '', '2025-11-07', '2025-11-09', 380.00, 0, 0, 0.00, 3),
(171, 68, '', '2025-11-14', '2025-11-16', 380.00, 0, 0, 0.00, 4),
(172, 68, '', '2025-11-28', '2025-11-30', 380.00, 0, 0, 0.00, 4),
(173, 67, '', '2025-12-29', '2026-01-01', 280.00, 0, 0, 0.00, 4),
(174, 67, '', '2025-12-22', '2025-12-25', 280.00, 0, 0, 0.00, 4),
(175, 67, '', '2026-01-26', '2026-01-29', 280.00, 0, 0, 0.00, 4),
(176, 67, '', '2026-01-05', '2026-01-08', 280.00, 0, 0, 0.00, 4),
(177, 67, '', '2026-01-19', '2026-01-22', 280.00, 0, 0, 0.00, 4),
(178, 67, '', '2026-01-12', '2026-01-15', 280.00, 0, 0, 0.00, 4),
(179, 67, '', '2025-12-15', '2025-12-18', 280.00, 0, 0, 0.00, 4),
(180, 67, '', '2025-12-08', '2025-12-11', 280.00, 0, 0, 0.00, 4),
(181, 68, '', '2025-12-05', '2025-12-07', 380.00, 0, 0, 0.00, 4),
(182, 68, '', '2025-12-12', '2025-12-14', 380.00, 0, 0, 0.00, 4),
(183, 68, '', '2026-01-02', '2026-01-04', 380.00, 0, 0, 0.00, 4),
(184, 68, '', '2026-01-23', '2026-01-25', 380.00, 0, 0, 0.00, 4),
(185, 68, '', '2026-01-16', '2026-01-18', 380.00, 0, 0, 0.00, 4),
(186, 68, '', '2026-01-30', '2026-02-01', 380.00, 0, 0, 0.00, 4),
(187, 68, '', '2025-12-26', '2025-12-28', 380.00, 0, 0, 0.00, 4),
(188, 68, '', '2025-10-09', '2025-10-10', 380.00, 0, 0, 0.00, 4),
(189, 68, '', '2025-12-19', '2025-12-21', 380.00, 0, 0, 0.00, 4),
(190, 69, '', '2025-11-03', '2025-11-06', 280.00, 0, 0, 0.00, 4),
(191, 69, '', '2025-11-10', '2025-11-13', 280.00, 0, 0, 0.00, 4),
(192, 69, '', '2025-11-24', '2025-11-27', 280.00, 0, 0, 0.00, 4),
(193, 69, '', '2025-11-17', '2025-11-20', 280.00, 0, 0, 0.00, 4),
(194, 69, '', '2025-12-08', '2025-12-11', 280.00, 0, 0, 0.00, 4),
(195, 69, '', '2025-12-15', '2025-12-18', 280.00, 0, 0, 0.00, 4),
(196, 69, '', '2025-12-22', '2025-12-25', 280.00, 0, 0, 0.00, 4),
(197, 69, '', '2025-12-29', '2026-01-01', 280.00, 0, 0, 0.00, 4),
(198, 69, '', '2026-01-05', '2026-01-08', 280.00, 0, 0, 0.00, 4),
(199, 69, '', '2026-01-12', '2026-01-15', 280.00, 0, 0, 0.00, 4),
(200, 69, '', '2026-01-19', '2026-01-22', 280.00, 0, 0, 0.00, 4),
(201, 69, '', '2026-01-26', '2026-01-29', 0.00, 0, 0, 0.00, 4),
(202, 69, '', '2026-03-02', '2026-03-05', 280.00, 0, 0, 0.00, 4),
(203, 69, '', '2026-02-09', '2026-02-12', 280.00, 0, 0, 0.00, 4),
(204, 69, '', '2026-02-16', '2026-02-19', 280.00, 0, 0, 0.00, 4),
(205, 69, '', '2026-02-23', '2026-02-26', 280.00, 0, 0, 0.00, 4),
(206, 70, '', '2025-11-07', '2025-11-09', 380.00, 0, 0, 0.00, 3),
(207, 70, '', '2025-11-14', '2025-11-16', 380.00, 0, 0, 0.00, 3),
(208, 70, '', '2025-11-21', '2025-11-23', 380.00, 0, 0, 0.00, 3),
(209, 70, '', '2025-11-28', '2025-11-30', 380.00, 0, 0, 0.00, 3),
(210, 70, '', '2025-12-05', '2025-12-07', 380.00, 0, 0, 0.00, 3),
(211, 70, '', '2025-12-12', '2025-12-14', 380.00, 0, 0, 0.00, 3),
(212, 70, '', '2025-12-19', '2025-12-21', 380.00, 0, 0, 0.00, 4),
(213, 70, '', '2025-12-26', '2025-12-28', 380.00, 0, 0, 0.00, 3),
(214, 70, '', '2026-01-02', '2026-01-04', 380.00, 0, 0, 0.00, 3),
(215, 70, '', '2026-01-09', '2026-01-11', 380.00, 0, 0, 0.00, 3),
(216, 70, '', '2026-01-16', '2026-01-18', 380.00, 0, 0, 0.00, 3),
(217, 70, '', '2026-01-23', '2026-01-25', 380.00, 0, 0, 0.00, 3),
(218, 70, '', '2026-01-30', '2026-02-01', 380.00, 0, 0, 0.00, 3),
(219, 71, '', '2025-11-03', '2025-11-06', 280.00, 0, 0, 0.00, 4),
(220, 71, '', '2025-11-10', '2025-11-13', 280.00, 0, 0, 0.00, 4),
(221, 71, '', '2025-11-17', '2025-11-20', 280.00, 0, 0, 0.00, 4),
(222, 71, '', '2025-11-24', '2025-11-27', 280.00, 0, 0, 0.00, 4),
(223, 71, '', '2025-12-01', '2025-12-04', 280.00, 0, 0, 0.00, 4),
(224, 71, '', '2025-12-08', '2025-12-11', 280.00, 0, 0, 0.00, 4),
(225, 71, '', '2025-12-15', '2025-12-18', 380.00, 0, 0, 0.00, 4),
(226, 71, '', '2025-12-22', '2025-12-25', 280.00, 0, 0, 0.00, 4),
(227, 71, '', '2025-12-29', '2026-01-01', 280.00, 0, 0, 0.00, 4),
(228, 71, '', '2026-01-05', '2026-01-08', 280.00, 0, 0, 0.00, 4),
(229, 71, '', '2026-01-12', '2026-01-15', 280.00, 0, 0, 0.00, 4),
(230, 71, '', '2026-01-19', '2026-01-22', 280.00, 0, 0, 0.00, 4),
(231, 71, '', '2026-01-26', '2026-01-29', 280.00, 0, 0, 0.00, 4),
(232, 72, '', '2025-11-07', '2025-11-09', 380.00, 0, 0, 0.00, 3),
(233, 72, '', '2025-11-21', '2025-11-23', 380.00, 0, 0, 0.00, 3),
(234, 72, '', '2025-11-14', '2025-11-16', 380.00, 0, 0, 0.00, 3),
(235, 72, '', '2025-11-28', '2025-11-30', 380.00, 0, 0, 0.00, 3),
(236, 72, '', '2025-12-05', '2025-12-07', 380.00, 0, 0, 0.00, 3),
(237, 72, '', '2025-12-12', '2025-12-14', 380.00, 0, 0, 0.00, 3),
(238, 72, '', '2025-12-19', '2025-12-21', 380.00, 0, 0, 0.00, 3),
(239, 72, '', '2025-12-26', '2025-12-28', 380.00, 0, 0, 0.00, 3),
(240, 72, '', '2026-01-02', '2026-01-04', 380.00, 0, 0, 0.00, 3),
(241, 72, '', '2026-01-08', '2026-01-11', 380.00, 0, 0, 0.00, 3),
(242, 72, '', '2026-01-16', '2026-01-18', 380.00, 0, 0, 0.00, 3),
(243, 72, '', '2026-01-23', '2026-01-25', 380.00, 0, 0, 0.00, 3),
(244, 72, '', '2026-01-30', '2026-02-01', 380.00, 0, 0, 0.00, 3),
(246, 74, '', '2025-09-02', '2026-02-28', 60.00, 0, 0, 0.00, 300),
(247, 75, '', '2025-09-15', '2027-01-01', 0.01, 0, 0, 0.00, 1),
(248, 76, '', '2025-09-16', '2027-07-14', 0.01, 0, 0, 0.00, 1),
(249, 77, '', '2025-09-17', '2029-11-30', 0.00, 0, 0, 0.00, 1),
(251, 79, '', '2025-09-19', '2030-01-31', 10.00, 0, 0, 0.00, 1),
(252, 80, '', '2025-09-23', '2030-09-23', 0.01, 0, 0, 0.00, 1),
(253, 81, '', '2025-09-25', '2030-09-25', 0.01, 0, 0, 0.00, 1),
(254, 82, '', '2025-09-30', '2030-09-30', 0.01, 0, 0, 0.00, 1),
(255, 83, '', '2025-11-04', '2025-11-29', 299.99, 0, 0, 29.90, 5),
(256, 84, '', '2025-11-02', '2025-12-31', 399.99, 0, 0, 29.90, 5),
(257, 88, '', '2025-11-06', '2025-12-31', 399.99, 0, 0, 0.00, 6),
(258, 89, '', '2025-11-30', '2025-12-31', 299.99, 0, 0, 29.99, 4),
(259, 91, '', '2025-12-01', '2026-01-31', 2.99, 0, 0, 0.00, 1),
(260, 92, '', '2025-12-01', '2026-01-31', 2.99, 0, 0, 0.00, 1),
(261, 93, '', '2025-12-01', '2026-01-31', 0.00, 0, 0, 0.00, 1),
(262, 94, '', '2025-12-01', '2026-01-31', 0.00, 0, 0, 0.00, 1);

-- --------------------------------------------------------

--
-- Estrutura para tabela `app_avaliacoes`
--

CREATE TABLE `app_avaliacoes` (
  `id` int NOT NULL,
  `app_anuncios_id` int NOT NULL,
  `app_users_id` int NOT NULL,
  `descricao` text CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci,
  `estrelas` int DEFAULT NULL,
  `data_cadastro` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estrutura para tabela `app_avaliacoes_ofc`
--

CREATE TABLE `app_avaliacoes_ofc` (
  `id` int NOT NULL,
  `app_reservas_id` int NOT NULL,
  `app_users_id` int NOT NULL,
  `app_anuncios_id` int NOT NULL,
  `descricao` text,
  `estrelas` int DEFAULT NULL,
  `data_cadastro` datetime DEFAULT NULL,
  `avaliou` int DEFAULT NULL COMMENT '1 - sim\n2 - nao'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estrutura para tabela `app_camas`
--

CREATE TABLE `app_camas` (
  `id` int NOT NULL,
  `nome` varchar(60) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL,
  `url` text CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci,
  `status` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Despejando dados para a tabela `app_camas`
--

INSERT INTO `app_camas` (`id`, `nome`, `url`, `status`) VALUES
(1, 'Cama de Solteiro', '80564b5322c7da024e6ac0f057e3f364.png', 1),
(2, 'Cama King', '95f864ba319602fd21d88c02c3e0ea98.png', 1),
(3, 'Cama Queen', 'ac0d387c28027d3a1af6748ef22385bc.png', 1),
(4, 'Colchão de casal', '8ca40323b6d429d581b2994db561c203.png', 1),
(5, 'Sofá cama', 'e9bb83a1a3da1970712bd152a80c1226.png', 1);

-- --------------------------------------------------------

--
-- Estrutura para tabela `app_cancelamentos`
--

CREATE TABLE `app_cancelamentos` (
  `id` int NOT NULL,
  `tipo` int DEFAULT NULL COMMENT '1 - usuario\n2 - anunciante\n',
  `nome` varchar(100) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL,
  `taxado` int DEFAULT NULL,
  `taxa_perc` int DEFAULT NULL,
  `status` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Despejando dados para a tabela `app_cancelamentos`
--

INSERT INTO `app_cancelamentos` (`id`, `tipo`, `nome`, `taxado`, `taxa_perc`, `status`) VALUES
(1, 2, 'Adversidade Climática', 2, 0, 1),
(2, 1, 'Imprevisto', 2, 0, 1),
(3, 2, 'Imprevisto', 2, 0, 1);

-- --------------------------------------------------------

--
-- Estrutura para tabela `app_caracteristicas`
--

CREATE TABLE `app_caracteristicas` (
  `id` int NOT NULL,
  `app_categorias_id` int NOT NULL,
  `nome` varchar(60) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL,
  `url` text CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci,
  `status` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Despejando dados para a tabela `app_caracteristicas`
--

INSERT INTO `app_caracteristicas` (`id`, `app_categorias_id`, `nome`, `url`, `status`) VALUES
(1, 1, 'Wi-fi ', 'cfeea4df00ea3341ea4330e6f5e217af.png', 1),
(4, 1, 'Café da Manhã', '3f489292e3137556dff793ca2f5fa627.png', 1),
(5, 1, 'Pet Friendly', '6690e5b1f60b4b8e71831a308bccf84e.png', 1),
(6, 1, 'Almoço', 'bf4da35dd8628b4e88d19ebe3cbfc610.png', 1),
(7, 1, 'Estacionamento Coberto', '2230c0c5255477adb096484b71fb25e5.png', 1),
(8, 1, 'Frigobar', '90ddd743b3493aad099ca4406fc2eea4.png', 1),
(9, 1, 'Banheira', 'c69f33c983a586134c42644d9e2de72b.png', 1),
(10, 1, 'Geladeira', '95624cc3fed3a2f0866e14625bcd636f.png', 1),
(12, 1, 'Banheiro Privativo', '172ed444dd3fb40a2436dfdd8ac2647b.png', 1),
(13, 1, 'Quarto Privativo', '67dc1b43249be5a64847f4645ac20e1c.png', 1),
(14, 2, 'Seguro Incluso', 'a351d5e2a18d5b3d5cffc621f15d4643.png', 1),
(15, 1, 'Próximo à Praia ', '0d07218de14b5b01d0dc8ac75a04f71e.png', 1),
(16, 2, 'Cancelamento por Mau Tempo', '8d38bd741b7b47003aa0192514fa7935.png', 1),
(17, 3, 'Área para Fumantes', '050f563a51334b1696d1b9de218950e2.png', 1),
(18, 2, 'Acessibilidade ', '7473acfd5001dd0cece11a4198c75cec.png', 1),
(19, 3, 'Acessibilidade ', 'f50b976fe6eb8f5cb5a6b6be54da88bb.png', 1),
(20, 3, 'Surança no Local', 'cbf522726ff32aa79d33975a152bcfca.png', 1),
(21, 2, 'Refeição no Local', '85c8e77f3eb0c7eb225c459ff67799c6.png', 1),
(22, 2, 'Bebida no Local', 'b2c1f5a18bd8b54c3ff287810def4a32.png', 1),
(23, 3, 'Refeição no Local', '854be5fc109cac67b20a94381174929e.png', 1),
(24, 2, 'Seguro Incluso', '7c798efe93e1aafbfb573a9c817c6778.png', 1),
(25, 2, 'Acampar', '0543a1f64679e29fdfa4de3d61af4281.png', 1),
(27, 2, 'Estacionamento para Motorhome', 'db9f0139d59ed80cdaa2f16aefe11cfa.png', 1);

-- --------------------------------------------------------

--
-- Estrutura para tabela `app_carrinho`
--

CREATE TABLE `app_carrinho` (
  `id` int NOT NULL,
  `app_users_id` int NOT NULL,
  `data` datetime DEFAULT NULL,
  `status` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Despejando dados para a tabela `app_carrinho`
--

INSERT INTO `app_carrinho` (`id`, `app_users_id`, `data`, `status`) VALUES
(2, 303, '2025-08-08 11:10:20', 1),
(3, 334, '2025-12-11 08:22:35', 2),
(4, 334, '2025-12-11 09:20:17', 2);

-- --------------------------------------------------------

--
-- Estrutura para tabela `app_carrinho_conteudo`
--

CREATE TABLE `app_carrinho_conteudo` (
  `id` int NOT NULL,
  `app_carrinho_id` int NOT NULL,
  `app_anuncios_ing_types_id` int NOT NULL,
  `valor` decimal(10,2) DEFAULT NULL,
  `qrcode` text CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci,
  `nome` text CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci,
  `email` text CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci,
  `celular` text CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci,
  `lido` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Despejando dados para a tabela `app_carrinho_conteudo`
--

INSERT INTO `app_carrinho_conteudo` (`id`, `app_carrinho_id`, `app_anuncios_ing_types_id`, `valor`, `qrcode`, `nome`, `email`, `celular`, `lido`) VALUES
(2, 3, 20, 29.00, 'INGRESSO_TESTE_QRCODE_123456', '6JnRtNKYzpdwHLbmH8yYAQ==', 'zVG7r6LW9ketSogA9g4ZDtKllEkpa4JYTBJZLDADrjE=', 'BFL37/hRatSVKJpSCONrsw==', 2),
(9, 4, 23, 0.00, 'Z4kG7VgOVjx6+jEpVn6L8j52u5s0L1Se21Jw5mzNcifHTC5RTs4md3JlddICp1Zq', 'dBQZ9Bi7Zr7NqLrFzgYIbA==', 'zbZqFSre7ypV8czJq5Rr7K2urGZOSiw8P8tbNcQlr7E=', 'BVx4QeMyS88uJkYKrgXniQ==', 2);

-- --------------------------------------------------------

--
-- Estrutura para tabela `app_cartoes`
--

CREATE TABLE `app_cartoes` (
  `id` int NOT NULL,
  `app_users_id` int DEFAULT NULL,
  `customer` varchar(30) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `final` text CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci,
  `bandeira` text CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `token` text CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci,
  `card_number` text CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `month` text CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `year` text CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `cvv` text CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `nome` text CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `cpf` text CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `cep` text CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `numero` text CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `status_favorito` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Despejando dados para a tabela `app_cartoes`
--

INSERT INTO `app_cartoes` (`id`, `app_users_id`, `customer`, `final`, `bandeira`, `token`, `card_number`, `month`, `year`, `cvv`, `nome`, `cpf`, `cep`, `numero`, `status_favorito`) VALUES
(1, 303, 'cus_000127072504', '6151', 'MASTERCARD', 'b7cb34cf-872b-46d0-840b-8801b20b1efa', '', '', '', '', 'J8izHQ2wrf4yeKohYFbjiccYW0W13XebqBhMiXeXs3w=', 'jM405IZYgDwBvS/FfLj3kA==', 'WAlq/rqc64lkWHilzqb6fA==', 'DIqmcceJ7JOde4DKHSgYXA==', 2),
(2, 303, 'cus_000127072511', '6151', 'MASTERCARD', 'a2111c35-a6e8-47fb-aecf-48094890a380', '', '', '', '', 'J8izHQ2wrf4yeKohYFbjiccYW0W13XebqBhMiXeXs3w=', 'jM405IZYgDwBvS/FfLj3kA==', 'WAlq/rqc64lkWHilzqb6fA==', 'DIqmcceJ7JOde4DKHSgYXA==', 1),
(4, 334, 'cus_000152195093', '0463', 'MASTERCARD', '', 'Wu0IRiRnBcieB9jxEiECL7m4XbiaRdh6QjOgSklkA4c=', 'g/8Sc3HvQs6tBWOiFpMNDw==', 'a9/WWokJpdtrKNsfGQJvqQ==', 'Gl5fbvxv0mdBZpitosPo3w==', 'zOGbAGkPn+6jq3bvZLz7HA==', 'BUaDGX4JpIdSKS7SLxpBNg==', 'E2SddmR0v6T4BuFL0giF6A==', 'mfOvUQw571BzKWuGBwiL6g==', 1);

-- --------------------------------------------------------

--
-- Estrutura para tabela `app_categorias`
--

CREATE TABLE `app_categorias` (
  `id` int NOT NULL,
  `nome` varchar(60) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL,
  `url` text CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci,
  `status` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Despejando dados para a tabela `app_categorias`
--

INSERT INTO `app_categorias` (`id`, `nome`, `url`, `status`) VALUES
(1, 'Hospedagens', NULL, 1),
(2, 'Experiências', NULL, 1),
(3, 'Eventos', NULL, 1);

-- --------------------------------------------------------

--
-- Estrutura para tabela `app_chat`
--

CREATE TABLE `app_chat` (
  `id` int NOT NULL,
  `id_de` int DEFAULT NULL,
  `id_para` int DEFAULT NULL,
  `tipo` int DEFAULT NULL COMMENT '1 - mensagem\\n2 - imagem\\n3 - audio\\n4 - documento',
  `url` text CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci,
  `mensagem` text CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci,
  `deleteby` int DEFAULT NULL,
  `data` datetime DEFAULT NULL,
  `lida` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Despejando dados para a tabela `app_chat`
--

INSERT INTO `app_chat` (`id`, `id_de`, `id_para`, `tipo`, `url`, `mensagem`, `deleteby`, `data`, `lida`) VALUES
(42, 232, 224, 1, '', 'teste', 2, '2025-02-16 22:32:07', 2),
(43, 263, 233, 1, '', 'Oi', 2, '2025-02-17 11:10:57', 2),
(44, 273, 263, 1, '', 'Oi tudo bem', 2, '2025-02-17 11:11:44', 1),
(45, 273, 263, 1, '', 'Oi tudo bem?', 2, '2025-02-18 09:11:18', 1),
(46, 263, 273, 1, '', 'Tudo bem e você?', 2, '2025-02-18 09:11:34', 1),
(47, 263, 265, 1, '', 'oii', 2, '2025-05-15 11:45:26', 1),
(48, 265, 263, 1, '', 'ola', 2, '2025-05-15 11:45:33', 1);

-- --------------------------------------------------------

--
-- Estrutura para tabela `app_config`
--

CREATE TABLE `app_config` (
  `id` int NOT NULL,
  `whatsapp` varchar(15) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL,
  `facebook` text NOT NULL,
  `instagram` text NOT NULL,
  `manutencao` int NOT NULL COMMENT '1-sim 2-nao',
  `credito` int NOT NULL COMMENT '1-ativo 2-inativo',
  `dinheiro` int NOT NULL COMMENT '1-ativo 2-inativo',
  `pix` int NOT NULL COMMENT '1-ativo 2-inativo',
  `raio_km` int DEFAULT NULL,
  `perc_imoveis` decimal(10,2) DEFAULT NULL,
  `perc_eventos` decimal(10,2) DEFAULT NULL,
  `tempo_cancelamento` int DEFAULT NULL COMMENT 'minutos',
  `perc_cartao` decimal(10,2) DEFAULT NULL,
  `perc_pix` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Despejando dados para a tabela `app_config`
--

INSERT INTO `app_config` (`id`, `whatsapp`, `facebook`, `instagram`, `manutencao`, `credito`, `dinheiro`, `pix`, `raio_km`, `perc_imoveis`, `perc_eventos`, `tempo_cancelamento`, `perc_cartao`, `perc_pix`) VALUES
(1, '(51) 98432-5228', 'www.facebook.com.br', '', 2, 1, 1, 1, 10000, 7.00, 7.00, 60, 3.05, 2.49);

-- --------------------------------------------------------

--
-- Estrutura para tabela `app_cupons`
--

CREATE TABLE `app_cupons` (
  `id` int NOT NULL,
  `app_users_id` int NOT NULL COMMENT 'ID do parceiro/anunciante',
  `app_anuncios_id` int DEFAULT NULL COMMENT 'NULL = válido para todos os anúncios do parceiro',
  `codigo` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Código do cupom',
  `descricao` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Descrição do cupom',
  `tipo_desconto` tinyint(1) NOT NULL DEFAULT '1' COMMENT '1=percentual, 2=valor fixo',
  `valor_desconto` decimal(10,2) NOT NULL COMMENT 'Valor ou percentual de desconto',
  `valor_minimo` decimal(10,2) DEFAULT '0.00' COMMENT 'Valor mínimo da reserva para usar o cupom',
  `uso_maximo` int DEFAULT NULL COMMENT 'Limite de usos totais (NULL = ilimitado)',
  `uso_por_usuario` int DEFAULT '1' COMMENT 'Limite de usos por usuário',
  `usos_realizados` int DEFAULT '0' COMMENT 'Contador de usos',
  `data_inicio` date NOT NULL COMMENT 'Data início de validade',
  `data_fim` date NOT NULL COMMENT 'Data fim de validade',
  `categorias` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Categorias permitidas (1,2,3) ou NULL para todas',
  `ativo` tinyint(1) DEFAULT '1' COMMENT '1=ativo, 0=inativo',
  `data_cadastro` datetime DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Cupons de desconto dos parceiros';

--
-- Despejando dados para a tabela `app_cupons`
--

INSERT INTO `app_cupons` (`id`, `app_users_id`, `app_anuncios_id`, `codigo`, `descricao`, `tipo_desconto`, `valor_desconto`, `valor_minimo`, `uso_maximo`, `uso_por_usuario`, `usos_realizados`, `data_inicio`, `data_fim`, `categorias`, `ativo`, `data_cadastro`) VALUES
(1, 334, NULL, 'NATAL25', 'Descontao de natal', 1, 10.00, 0.00, NULL, 1, 1, '2025-12-10', '2026-01-31', '1,2,3', 1, '2025-12-10 20:41:08');

-- --------------------------------------------------------

--
-- Estrutura para tabela `app_cupons_uso`
--

CREATE TABLE `app_cupons_uso` (
  `id` int NOT NULL,
  `app_cupons_id` int NOT NULL COMMENT 'ID do cupom',
  `app_users_id` int NOT NULL COMMENT 'ID do usuário que usou',
  `app_reservas_id` int NOT NULL COMMENT 'ID da reserva',
  `valor_original` decimal(10,2) NOT NULL COMMENT 'Valor original da reserva',
  `valor_desconto` decimal(10,2) NOT NULL COMMENT 'Valor do desconto aplicado',
  `valor_final` decimal(10,2) NOT NULL COMMENT 'Valor final após desconto',
  `data_uso` datetime DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Histórico de uso dos cupons';

--
-- Despejando dados para a tabela `app_cupons_uso`
--

INSERT INTO `app_cupons_uso` (`id`, `app_cupons_id`, `app_users_id`, `app_reservas_id`, `valor_original`, `valor_desconto`, `valor_final`, `data_uso`) VALUES
(1, 1, 334, 18, 161.49, 16.15, 145.34, '2025-12-11 11:06:22');

-- --------------------------------------------------------

--
-- Estrutura para tabela `app_favoritos`
--

CREATE TABLE `app_favoritos` (
  `id` int NOT NULL,
  `app_users_id` int NOT NULL,
  `app_anuncios_id` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Despejando dados para a tabela `app_favoritos`
--

INSERT INTO `app_favoritos` (`id`, `app_users_id`, `app_anuncios_id`) VALUES
(33, 317, 87),
(34, 334, 106),
(35, 334, 82);

-- --------------------------------------------------------

--
-- Estrutura para tabela `app_fcm`
--

CREATE TABLE `app_fcm` (
  `id` int NOT NULL,
  `app_users_id` int NOT NULL,
  `type` int DEFAULT NULL,
  `registration_id` text CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Despejando dados para a tabela `app_fcm`
--

INSERT INTO `app_fcm` (`id`, `app_users_id`, `type`, `registration_id`) VALUES
(1, 301, 2, 'f84ywBIKE02Bkm6DsoWrvy:APA91bFbBBA7VllZjKXBHACeaWlxhTxny8fVhhacsg8YfxyOpT-0NjuDoLQ-Adb3TWjGam7OlkUqa8XSHzcAfnWp0RBfYUJCUnNYzv4n998vFhRXDT6RFBs'),
(2, 304, 1, 'c2StAkp1Qqqp_MSaVpL_2Z:APA91bGIEr7svP45KP1vB0nL5ULERhyx1kJ9Dm52eEvE3ZP0AuOdGEF9fqhZL3hRLb7jKOQISGcuy8TNWQ7iOQyhKQHIyZLaq7-3fHhkqVBBe-_hIaM45as'),
(3, 313, 1, 'emOfpkNhTIiH_7Y7Iwyj3V:APA91bFcMfKTHUJwXjoboOPgMriIhpwlZpLXMp61Ecc-5eRPIMchjhSShYRml-NLQLIDo2H5MNIy5vxzClfGjJcmX8tbOJ5HiD55zbFuqTND-A8H__gZWhA'),
(4, 315, 2, 'ei6TPC2MS0SMlA-P28bDfq:APA91bGY537ntst5eSES0qx3Ep7isGYJEXQsfU6fHmGnkpp3woqaNOu1dH0a4XeFRi6N4eVWqrm98TYbeMWUhk0onjzVgZcISkLlXI0gFc5196vzcArV7Ls'),
(5, 317, 2, 'dCfJU_QpCU91qlrEQ4lKPf:APA91bF3PEptFvSNNjHVN925elg1g18D-UowgUXAVdpzIxT5ENbwvO1eiHP-4u2C78LjUPN99THbB0i4BkmzQwLyBS8L65YE4lVmRXJdAAV3Uzivn81KfEk'),
(6, 319, 2, 'd8e8IP8lK0cfi06eXu0oPJ:APA91bEAORVIflk0aUJ_5lxFbSsuimVE5XWBuYj_W-b_rI1sRkTLfHeZRmdksBH61tdfT8VibnXSKUXGItNq4drftNhu6wOw5TGg-UutGHW6oJ9NZvp-Xvc'),
(7, 322, 2, 'cm0La0g3uEPcumbEt6eTGt:APA91bE_aa9VykLREIgrvPjpLQRkoAyGG4AmU73SLlDme6PeHAQjUtLQGG-kURj-hLUVUKGDiMZKdxHRqj-RN21RWlVaNVKyUalweD-nl1grpChT4gxZv7Y'),
(8, 323, 1, 'fJun91DYQ4OXssUXpymmdO:APA91bGzqOmXSjmNlrAjdc-u2hRr-F7-WNJOqmb7e1Fhb-IAquu-JzXtTvIWbx6HyFk4_neylPz00ysunAmA1bvaqSW7VtrRh99mUQzni6BO5TYz0XLzIv4'),
(9, 324, 1, 'eBqH4_YgTWGbWm6rnx7cu1:APA91bFX959SNrvpmzPsNb0IyE0BxWhdRH-EAomzhFcmXW03JhhXhmT71JOTPbmmAvkhg-5gAmcCAvanqJCT7A8-mdSrwy0zef1P7vfNbVg-7PLK8mvNgWA'),
(10, 328, 2, 'f4VQBg_ON0WiufOjtiUAFd:APA91bFEo360EM5lIudae_dIB8V55yADfpCFvNwZ0e3MhjdQ6d71oZWwHyHxjYx9ERkxcRa9bcpOAL_hLAbCVOj23SMSC3N84NOkchjgWxaz8h0Ejde4H0k'),
(12, 334, 1, 'dF1FXnmqS9-ILTZaKI9qB1:APA91bH9kfyyXtET07Tm2s1jDzokkvHECKNoi3x2WemDSe-XWde808-EKM0dm6mO2j39A2RbrviryUUi8ADhj9Z2_uappCQs-lkrcUXerZjEGciXgkaa8g8');

-- --------------------------------------------------------

--
-- Estrutura para tabela `app_ical_bloqueios`
--

CREATE TABLE `app_ical_bloqueios` (
  `id` int NOT NULL,
  `app_anuncios_id` int NOT NULL,
  `app_anuncios_types_id` int DEFAULT NULL,
  `app_anuncios_types_unidades_id` int DEFAULT NULL,
  `app_ical_links_id` int NOT NULL,
  `uid` varchar(255) NOT NULL,
  `data_inicio` date NOT NULL,
  `data_fim` date NOT NULL,
  `resumo` varchar(255) DEFAULT NULL,
  `data_importacao` datetime DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Despejando dados para a tabela `app_ical_bloqueios`
--

INSERT INTO `app_ical_bloqueios` (`id`, `app_anuncios_id`, `app_anuncios_types_id`, `app_anuncios_types_unidades_id`, `app_ical_links_id`, `uid`, `data_inicio`, `data_fim`, `resumo`, `data_importacao`) VALUES
(64, 108, 89, 14, 13, 'demo-102-res001@airbnb.com', '2025-12-13', '2025-12-17', 'Reserva - João Silva', '2025-12-10 10:07:14'),
(65, 108, 89, 14, 13, 'demo-102-res002@booking.com', '2025-12-20', '2025-12-22', 'Reserva - Maria Santos', '2025-12-10 10:07:14'),
(66, 108, 89, 14, 13, 'demo-102-res003@airbnb.com', '2025-12-20', '2025-12-27', 'Reserva - Família Oliveira', '2025-12-10 10:07:14'),
(67, 108, 89, 14, 13, 'demo-102-res004@airbnb.com', '2025-12-28', '2026-01-02', 'Reserva - Pedro Almeida', '2025-12-10 10:07:14'),
(68, 108, 89, 14, 13, 'demo-102-res005@booking.com', '2026-01-05', '2026-01-10', 'Reserva - Ana Costa', '2025-12-10 10:07:14'),
(69, 108, 89, 14, 13, 'demo-102-block001@go77.com.br', '2026-01-12', '2026-01-14', 'Blocked - Manutenção', '2025-12-10 10:07:14'),
(70, 108, 89, 14, 13, 'demo-102-res006@airbnb.com', '2026-01-15', '2026-01-20', 'Reserva - Roberto Lima', '2025-12-10 10:07:14'),
(71, 108, 89, 14, 13, 'demo-102-res007@vrbo.com', '2026-01-25', '2026-01-31', 'Reserva - Fernanda Souza', '2025-12-10 10:07:14'),
(72, 108, 89, 14, 13, 'demo-102-res008@booking.com', '2026-02-01', '2026-02-05', 'Reserva - Lucas Mendes', '2025-12-10 10:07:14'),
(73, 108, 89, 14, 13, 'demo-102-res009@airbnb.com', '2026-02-12', '2026-02-15', 'Reserva - Casal Romântico', '2025-12-10 10:07:14'),
(74, 108, 89, 14, 13, 'demo-102-res010@airbnb.com', '2026-02-14', '2026-02-19', 'Reserva - Grupo Carnaval', '2025-12-10 10:07:14'),
(75, 108, 89, 14, 13, 'demo-102-res011@booking.com', '2026-02-20', '2026-02-25', 'Reserva - Patricia Gomes', '2025-12-10 10:07:14'),
(76, 108, 89, 14, 13, 'demo-102-res012@airbnb.com', '2026-03-02', '2026-03-06', 'Reserva - Empresa Tech Corp', '2025-12-10 10:07:14'),
(77, 108, 89, 14, 13, 'demo-102-block002@go77.com.br', '2026-03-10', '2026-03-13', 'Blocked - Pintura', '2025-12-10 10:07:14'),
(78, 108, 89, 14, 13, 'demo-102-res013@booking.com', '2026-03-15', '2026-03-22', 'Reserva - Juliana Martins', '2025-12-10 10:07:14'),
(79, 108, 89, 14, 13, 'demo-102-res014@airbnb.com', '2026-03-28', '2026-04-02', 'Reserva - Família Pereira', '2025-12-10 10:07:14'),
(80, 108, 89, 17, 11, 'demo-102-res001@airbnb.com', '2025-12-13', '2025-12-17', 'Reserva - João Silva', '2025-12-10 10:07:14'),
(81, 108, 89, 17, 11, 'demo-102-res002@booking.com', '2025-12-20', '2025-12-22', 'Reserva - Maria Santos', '2025-12-10 10:07:14'),
(82, 108, 89, 17, 11, 'demo-102-res003@airbnb.com', '2025-12-20', '2025-12-27', 'Reserva - Família Oliveira', '2025-12-10 10:07:14'),
(83, 108, 89, 17, 11, 'demo-102-res004@airbnb.com', '2025-12-28', '2026-01-02', 'Reserva - Pedro Almeida', '2025-12-10 10:07:14'),
(84, 108, 89, 17, 11, 'demo-102-res005@booking.com', '2026-01-05', '2026-01-10', 'Reserva - Ana Costa', '2025-12-10 10:07:14'),
(85, 108, 89, 17, 11, 'demo-102-block001@go77.com.br', '2026-01-12', '2026-01-14', 'Blocked - Manutenção', '2025-12-10 10:07:14'),
(86, 108, 89, 17, 11, 'demo-102-res006@airbnb.com', '2026-01-15', '2026-01-20', 'Reserva - Roberto Lima', '2025-12-10 10:07:14'),
(87, 108, 89, 17, 11, 'demo-102-res007@vrbo.com', '2026-01-25', '2026-01-31', 'Reserva - Fernanda Souza', '2025-12-10 10:07:14'),
(88, 108, 89, 17, 11, 'demo-102-res008@booking.com', '2026-02-01', '2026-02-05', 'Reserva - Lucas Mendes', '2025-12-10 10:07:14'),
(89, 108, 89, 17, 11, 'demo-102-res009@airbnb.com', '2026-02-12', '2026-02-15', 'Reserva - Casal Romântico', '2025-12-10 10:07:14'),
(90, 108, 89, 17, 11, 'demo-102-res010@airbnb.com', '2026-02-14', '2026-02-19', 'Reserva - Grupo Carnaval', '2025-12-10 10:07:14'),
(91, 108, 89, 17, 11, 'demo-102-res011@booking.com', '2026-02-20', '2026-02-25', 'Reserva - Patricia Gomes', '2025-12-10 10:07:14'),
(92, 108, 89, 17, 11, 'demo-102-res012@airbnb.com', '2026-03-02', '2026-03-06', 'Reserva - Empresa Tech Corp', '2025-12-10 10:07:14'),
(93, 108, 89, 17, 11, 'demo-102-block002@go77.com.br', '2026-03-10', '2026-03-13', 'Blocked - Pintura', '2025-12-10 10:07:14'),
(94, 108, 89, 17, 11, 'demo-102-res013@booking.com', '2026-03-15', '2026-03-22', 'Reserva - Juliana Martins', '2025-12-10 10:07:14'),
(95, 108, 89, 17, 11, 'demo-102-res014@airbnb.com', '2026-03-28', '2026-04-02', 'Reserva - Família Pereira', '2025-12-10 10:07:14');

-- --------------------------------------------------------

--
-- Estrutura para tabela `app_ical_links`
--

CREATE TABLE `app_ical_links` (
  `id` int NOT NULL,
  `app_anuncios_id` int NOT NULL,
  `app_anuncios_types_id` int DEFAULT NULL,
  `app_anuncios_types_unidades_id` int DEFAULT NULL,
  `nome` varchar(100) NOT NULL,
  `url` text NOT NULL,
  `ultima_sincronizacao` datetime DEFAULT NULL,
  `status` tinyint(1) DEFAULT '1',
  `erros` int DEFAULT '0',
  `ultimo_erro` text,
  `data_cadastro` datetime DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Despejando dados para a tabela `app_ical_links`
--

INSERT INTO `app_ical_links` (`id`, `app_anuncios_id`, `app_anuncios_types_id`, `app_anuncios_types_unidades_id`, `nome`, `url`, `ultima_sincronizacao`, `status`, `erros`, `ultimo_erro`, `data_cadastro`) VALUES
(1, 104, NULL, NULL, 'Airbnb', 'https://www.airbnb.com.br/calendar/ical/example.ics', NULL, 1, 0, NULL, '2025-11-30 12:33:48'),
(2, 104, 0, NULL, 'Airbnb Geral', 'https://www.airbnb.com.br/calendar/ical/12345.ics', NULL, 1, 0, NULL, '2025-11-30 13:12:44'),
(3, 65, 43, NULL, 'Airbnb Quarto 1', 'https://www.airbnb.com.br/calendar/ical/12345.ics', NULL, 1, 0, NULL, '2025-11-30 17:59:04'),
(4, 65, 43, 1, 'Airbnb Unidade 1', 'https://www.airbnb.com.br/calendar/ical/unidade1.ics', NULL, 1, 0, NULL, '2025-11-30 18:09:06'),
(5, 65, 43, 2, 'Booking Unidade 2', 'https://www.booking.com/calendar/ical/unit2.ics', NULL, 1, 0, NULL, '2025-11-30 18:12:35'),
(6, 65, 43, 1, 'Airbnb Suite 431', 'https://www.airbnb.com.br/calendar/ical/suite431.ics', NULL, 1, 0, NULL, '2025-11-30 18:56:35'),
(7, 65, 43, 2, 'Airbnb Suite 432', 'https://www.airbnb.com.br/calendar/ical/suite432.ics', NULL, 1, 0, NULL, '2025-11-30 18:56:35'),
(8, 65, 43, 3, 'Booking Suite 433', 'https://admin.booking.com/calendar/suite433.ics', NULL, 1, 0, NULL, '2025-11-30 18:56:36'),
(9, 65, 43, 4, 'Booking Suite 434', 'https://admin.booking.com/calendar/suite434.ics', NULL, 1, 0, NULL, '2025-11-30 18:56:36'),
(11, 108, 89, 17, 'Airbnb', 'http://localhost:8888/www/apiv3/test/ical_demo.php?room=102', '2025-12-10 10:07:14', 1, 0, NULL, '2025-11-30 19:41:37'),
(13, 108, 89, 14, 'Airbnb', 'http://localhost:8888/www/apiv3/test/ical_demo.php?room=102', '2025-12-10 10:07:14', 1, 0, NULL, '2025-11-30 21:25:07');

-- --------------------------------------------------------

--
-- Estrutura para tabela `app_notificacoes`
--

CREATE TABLE `app_notificacoes` (
  `id` int NOT NULL,
  `app_users_id` int DEFAULT NULL,
  `titulo` varchar(60) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL,
  `descricao` varchar(155) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL,
  `data` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Despejando dados para a tabela `app_notificacoes`
--

INSERT INTO `app_notificacoes` (`id`, `app_users_id`, `titulo`, `descricao`, `data`) VALUES
(1, 303, 'Cadastro aprovado!', 'A partir de agora sua empresa vai atender novos clientes.', '2025-07-25 14:08:27'),
(2, 0, 'Pagamento Confirmado', 'Pagamento confirmado da sua reserva no imóvel: ', '2025-07-25 18:36:26'),
(3, 0, '', '', '2025-07-25 18:36:26'),
(4, 0, 'Pagamento Confirmado', 'Pagamento confirmado da sua reserva no imóvel: ', '2025-08-01 00:12:54'),
(5, 0, '', '', '2025-08-01 00:12:54'),
(6, 0, 'Pagamento Confirmado', 'Pagamento confirmado da sua reserva no imóvel: ', '2025-08-01 00:12:57'),
(7, 0, '', '', '2025-08-01 00:12:57'),
(8, 0, 'Pagamento Confirmado', 'Pagamento confirmado da sua reserva no imóvel: ', '2025-09-08 10:21:59'),
(9, 0, '', '', '2025-09-08 10:21:59'),
(10, 334, 'Nova Reserva Cortesia', 'Você recebeu uma nova reserva cortesia (gratuita) no anúncio: Palestra gratuita', '2025-12-11 11:05:35'),
(11, 334, 'Nova Reserva Cortesia', 'Você recebeu uma nova reserva cortesia (gratuita) no anúncio: Palestra gratuita', '2025-12-11 11:07:29');

-- --------------------------------------------------------

--
-- Estrutura para tabela `app_pagamentos`
--

CREATE TABLE `app_pagamentos` (
  `id` int NOT NULL,
  `app_users_id` int NOT NULL,
  `app_anuncios_id` int NOT NULL,
  `tipo_pagamento` int DEFAULT NULL COMMENT '1 - cartão\n2 - dinheiro\n3 - pix',
  `valor_final` decimal(10,2) DEFAULT NULL,
  `valor_anunciante` decimal(10,2) DEFAULT NULL,
  `valor_admin` decimal(10,2) DEFAULT NULL,
  `parcelas` int DEFAULT '1',
  `valor_parcela` decimal(10,2) DEFAULT NULL,
  `installment_id` varchar(100) DEFAULT NULL,
  `cartao_id` varchar(50) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL,
  `qrcode` text CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci,
  `data` datetime DEFAULT NULL,
  `token` text CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci,
  `status` varchar(20) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Despejando dados para a tabela `app_pagamentos`
--

INSERT INTO `app_pagamentos` (`id`, `app_users_id`, `app_anuncios_id`, `tipo_pagamento`, `valor_final`, `valor_anunciante`, `valor_admin`, `parcelas`, `valor_parcela`, `installment_id`, `cartao_id`, `qrcode`, `data`, `token`, `status`) VALUES
(9, 331, 82, 3, 1361.18, 0.00, 0.00, 1, NULL, NULL, '', '00020101021226800014br.gov.bcb.pix2558pix.asaas.com/qr/cobv/44a4776c-adaf-421c-b3fb-6a1cff42ad8f5204000053039865802BR5925TOURSETE SOLUCOES TURISTI6005Lages61088850640062070503***6304F855', '2025-10-09 14:47:48', 'pay_vz06f8f9fco9u1gf', 'PENDING'),
(10, 334, 104, 3, 63.50, 4.45, 59.06, 1, NULL, NULL, '', '00020101021226800014br.gov.bcb.pix2558pix.asaas.com/qr/cobv/881cdf21-15b5-4bdf-86f3-151d3d973aba5204000053039865802BR5925TOURSETE SOLUCOES TURISTI6005Lages61088850640062070503***6304F119', '2025-12-11 09:21:15', 'pay_9td8crvk5f3k3c87', 'PENDING'),
(11, 334, 65, 3, 100.00, 7.00, 93.00, 1, NULL, NULL, '', '', '2025-12-11 09:45:51', '', 'PENDING'),
(12, 334, 65, 3, 100.00, 7.00, 93.00, 1, NULL, NULL, '', '', '2025-12-11 09:46:01', '', 'PENDING'),
(13, 334, 110, 3, 145.34, 10.17, 135.17, 1, NULL, NULL, '', '00020101021226800014br.gov.bcb.pix2558pix.asaas.com/qr/cobv/9ad0e911-46aa-4e52-be8f-69cf1dc3c4405204000053039865802BR5925TOURSETE SOLUCOES TURISTI6005Lages61088850640062070503***630499BF', '2025-12-11 10:19:48', 'pay_jeir89nk695v7kxr', 'PENDING'),
(14, 334, 110, 3, 145.34, 10.17, 135.17, 1, NULL, NULL, '', '00020101021226800014br.gov.bcb.pix2558pix.asaas.com/qr/cobv/4c12915f-0bf3-4f38-b74d-d6f165f17d345204000053039865802BR5925TOURSETE SOLUCOES TURISTI6005Lages61088850640062070503***6304F259', '2025-12-11 10:25:54', 'pay_15zi4dah1xe6foy5', 'PENDING'),
(15, 334, 115, 4, 0.00, 0.00, 0.00, 1, NULL, NULL, '', '', '2025-12-11 10:55:49', 'CORTESIA_6PUkwTLNEbgsI8eZ', 'CONFIRMED'),
(16, 334, 115, 4, 0.00, 0.00, 0.00, 1, NULL, NULL, '', '', '2025-12-11 10:55:50', 'CORTESIA_T4XcDPgeNTR1Goks', 'CONFIRMED'),
(17, 334, 115, 4, 0.00, 0.00, 0.00, 1, NULL, NULL, '', '', '2025-12-11 10:57:38', 'CORTESIA_e42YeExJ8Tgb06l1', 'CONFIRMED'),
(18, 334, 115, 4, 0.00, 0.00, 0.00, 1, NULL, NULL, '', '', '2025-12-11 10:58:51', 'CORTESIA_HOEK3b4etCPcwxdQ', 'CONFIRMED'),
(19, 334, 115, 4, 0.00, 0.00, 0.00, 1, NULL, NULL, '', '', '2025-12-11 10:59:50', 'CORTESIA_pQosIpsioKk8zE2x', 'CONFIRMED'),
(20, 334, 115, 4, 0.00, 0.00, 0.00, 1, NULL, NULL, '', '', '2025-12-11 11:02:44', 'CORTESIA_dwHXrNY5Jm1tiC4M', 'CONFIRMED'),
(21, 334, 115, 4, 0.00, 0.00, 0.00, 1, NULL, NULL, '', '', '2025-12-11 11:02:52', 'CORTESIA_wS59HYbqN1eQuJ52', 'CONFIRMED'),
(22, 334, 115, 4, 0.00, 0.00, 0.00, 1, NULL, NULL, '', '', '2025-12-11 11:03:20', 'CORTESIA_iNJT4u2ZgfXBjm5G', 'CONFIRMED'),
(23, 334, 115, 4, 0.00, 0.00, 0.00, 1, NULL, NULL, '', '', '2025-12-11 11:05:35', 'CORTESIA_pD7ie1XsMa0Cc6Ou', 'CONFIRMED'),
(24, 334, 115, 3, 145.34, 10.17, 135.17, 1, NULL, NULL, '', '00020101021226800014br.gov.bcb.pix2558pix.asaas.com/qr/cobv/2a8fa93d-84a8-4e4c-858d-fce9189db5d95204000053039865802BR5925TOURSETE SOLUCOES TURISTI6005Lages61088850640062070503***6304C57F', '2025-12-11 11:06:22', 'pay_6xgz9i9je9wfed4f', 'PENDING'),
(25, 334, 115, 3, 161.49, 11.30, 150.19, 1, NULL, NULL, '', '00020101021226800014br.gov.bcb.pix2558pix.asaas.com/qr/cobv/f9b4b5ad-90ea-46fb-9729-28b25cdeb7215204000053039865802BR5925TOURSETE SOLUCOES TURISTI6005Lages61088850640062070503***630439C1', '2025-12-11 11:06:45', 'pay_cs1gd6hlbyyiaw6m', 'PENDING'),
(26, 334, 115, 3, 161.49, 11.30, 150.19, 1, NULL, NULL, '', '00020101021226800014br.gov.bcb.pix2558pix.asaas.com/qr/cobv/469caa9e-dad8-4044-ab59-6bf1c220bf9e5204000053039865802BR5925TOURSETE SOLUCOES TURISTI6005Lages61088850640062070503***63049863', '2025-12-11 11:06:56', 'pay_oa2p7bqbx6xqdlgw', 'PENDING'),
(27, 334, 115, 4, 0.00, 0.00, 0.00, 1, NULL, NULL, '', '', '2025-12-11 11:07:29', 'CORTESIA_eo4r6FrAWmHoMdSZ', 'CONFIRMED');

-- --------------------------------------------------------

--
-- Estrutura para tabela `app_reservas`
--

CREATE TABLE `app_reservas` (
  `id` int NOT NULL,
  `app_pagamentos_id` int NOT NULL,
  `app_users_id` int NOT NULL,
  `app_anuncios_id` int NOT NULL,
  `id_anuncio_type` int DEFAULT NULL,
  `id_carrinho` int DEFAULT NULL,
  `adultos` int DEFAULT NULL,
  `criancas` int DEFAULT NULL,
  `data_de` date DEFAULT NULL,
  `data_ate` date DEFAULT NULL,
  `valor_final` decimal(10,2) DEFAULT NULL,
  `taxa_limpeza` decimal(10,2) DEFAULT NULL,
  `data_cadastro` datetime DEFAULT NULL,
  `obs` text CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci,
  `status` int DEFAULT NULL COMMENT '1 - confirmado\n2 - pendente\n3 - cancelado'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Despejando dados para a tabela `app_reservas`
--

INSERT INTO `app_reservas` (`id`, `app_pagamentos_id`, `app_users_id`, `app_anuncios_id`, `id_anuncio_type`, `id_carrinho`, `adultos`, `criancas`, `data_de`, `data_ate`, `valor_final`, `taxa_limpeza`, `data_cadastro`, `obs`, `status`) VALUES
(9, 9, 331, 82, 59, 0, 1, 0, '2025-09-22', '2025-09-25', 1361.18, 0.00, '2025-10-09 14:47:48', '', 2),
(13, 9, 334, 104, 1, NULL, 2, 1, '2025-12-20', '2025-12-25', 1500.00, 100.00, '2025-11-30 10:51:50', 'Reserva de teste', 1),
(14, 9, 334, 104, 1, NULL, 2, 1, '2025-12-20', '2025-12-25', 1500.00, 100.00, '2025-11-30 10:51:58', 'Reserva de teste', 1),
(15, 11, 334, 65, 1, 0, 2, 0, '2025-12-20', '2025-12-22', 100.00, 0.00, '2025-12-11 09:45:51', 'Teste PIX', 2),
(16, 12, 334, 65, 1, 0, 2, 0, '2025-12-20', '2025-12-22', 100.00, 0.00, '2025-12-11 09:46:01', 'Teste PIX', 2),
(17, 23, 334, 115, NULL, 4, 0, 0, NULL, NULL, 0.00, 0.00, '2025-12-11 11:05:35', '', 1),
(18, 24, 334, 115, NULL, 4, NULL, NULL, NULL, NULL, 145.34, 0.00, '2025-12-11 11:06:22', '', 2),
(19, 25, 334, 115, NULL, 4, NULL, NULL, NULL, NULL, 161.49, 0.00, '2025-12-11 11:06:45', '', 2),
(20, 26, 334, 115, NULL, 4, NULL, NULL, NULL, NULL, 161.49, 0.00, '2025-12-11 11:06:56', '', 2),
(21, 27, 334, 115, NULL, 4, 0, 0, NULL, NULL, 0.00, 0.00, '2025-12-11 11:07:29', '', 1);

-- --------------------------------------------------------

--
-- Estrutura para tabela `app_reservas_cancelamentos`
--

CREATE TABLE `app_reservas_cancelamentos` (
  `id` int NOT NULL,
  `app_reservas_id` int NOT NULL,
  `app_users_id` int NOT NULL,
  `app_cancelamentos_id` int NOT NULL,
  `obs` text CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci,
  `status` int DEFAULT NULL COMMENT '1 - solicitado\n2 - estornado\n3 - não estornado'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estrutura para tabela `app_saldo_pagamentos`
--

CREATE TABLE `app_saldo_pagamentos` (
  `id` int NOT NULL,
  `app_users_id` int NOT NULL,
  `valor` decimal(10,2) DEFAULT NULL,
  `data` datetime DEFAULT NULL,
  `status` int NOT NULL COMMENT '1 - pago 2 - pendente'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estrutura para tabela `app_subcategorias`
--

CREATE TABLE `app_subcategorias` (
  `id` int NOT NULL,
  `app_categorias_id` int NOT NULL,
  `nome` varchar(60) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL,
  `url` text CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci,
  `status` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Despejando dados para a tabela `app_subcategorias`
--

INSERT INTO `app_subcategorias` (`id`, `app_categorias_id`, `nome`, `url`, `status`) VALUES
(1, 1, 'Cabana', 'c005e42b40a354b9e54f4c28718b58a3.png', 1),
(2, 1, 'Hotel', '98d7eccd07e0f62ec3832d311ac8f201.png', 1),
(3, 1, 'Pousada', '470b88f3f5379b891ae96e6c5b751b2d.png', 1),
(4, 1, 'Apartamento', 'a92015cb0a6093be3ed4778d36d2fc79.png', 1),
(5, 1, 'Casa', 'cec4303a5d0e36a65e9aa72271bfdd77.png', 1),
(6, 2, 'Parque Turístico', 'aa6f6bcccf8721e733d0330b5c76b2d5.png', 1),
(7, 2, 'Trilha', 'a03193285cdcb574c3f6fde9d7419fe7.png', 1),
(8, 2, 'Passeio de Quadriciclo', 'e75685d879ac300fc84d7a417524f8a0.png', 1),
(9, 2, 'Passeio de UTV', '1727210deb7ff5ed43b907270854daf2.png', 1),
(10, 2, 'Cavalgada ', 'ba71244e9096a7340b9fefc31d8634ea.png', 1),
(11, 2, 'Passeio de Balão', 'b75548ea4ff3fddbbb56e0815c03e32f.png', 1),
(12, 2, 'Passeio de Helicóptero ', '44b2ef1e0778502ffd18c157b6277124.png', 1),
(13, 2, 'Vinícola ', '841cedc46dd86ae4fcb1fda493fd479b.png', 1),
(14, 2, 'Passeio de Lancha', 'bb0231de57e2b42bfdd7002c0d27f0e8.png', 1),
(15, 2, 'Vôo de Asa Delta', 'bfab0b87a95050603029d42a2ce6f63c.png', 1),
(16, 2, 'Vôo de Parapente', '886fb9f1c40f802da36765459e375c4a.png', 1),
(17, 2, 'Tour com Degustação', '694e13efe34e015b6c7e61230d055da2.png', 1),
(18, 3, 'Off-Road', '93d9a40b4c2928d290684facdfdcef96.png', 1),
(19, 3, 'Palestra', '2e8fedbfdaf3c2ee8e05a011d6cb77ef.png', 1),
(20, 3, 'Simpósio de Gastronomia e Turismo', 'c05ef1676918492bf054954d1d1c2dc0.png', 1),
(21, 3, 'Workshop ', '95510331fce25f7556cf81a7f1d0c29f.png', 1),
(22, 3, 'Imersão', 'bef0acacf7428aa5b249813728d9aae1.png', 1),
(23, 2, 'Excursão', '5031e09790803c09c7207f9a63eecff7.png', 1),
(24, 2, 'Turismo Religioso', '162b006af83fcd576299bf04b1007267.png', 1),
(25, 2, 'Tirolesa', 'a63c59f55c94fcd2d79f105e0c337377.png', 1),
(26, 3, 'Show', '6ed0aa778ae3db746f8ca316845b8bb0.png', 1),
(27, 2, 'Camping', '194a6c2001825e9750904271a7ffa090.png', 1);

-- --------------------------------------------------------

--
-- Estrutura para tabela `app_users`
--

CREATE TABLE `app_users` (
  `id` int NOT NULL,
  `id_grupo` int NOT NULL,
  `tipo_pessoa` int NOT NULL COMMENT '1 - fisica 2 - juridica',
  `nome` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  `email` text CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci,
  `password` text CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci,
  `documento` text CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci,
  `cnpj` text CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `razao_social` text CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `nome_fantasia` text CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `ie` text CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `celular` text CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci,
  `avatar` text CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci,
  `data_nascimento` text CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci,
  `data_cadastro` datetime DEFAULT NULL,
  `u_login` datetime DEFAULT NULL,
  `token_senha` varchar(32) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL,
  `token_cadastro` varchar(32) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL,
  `perc_imoveis` decimal(10,2) DEFAULT NULL,
  `perc_eventos` decimal(10,2) DEFAULT NULL,
  `status` int DEFAULT NULL,
  `status_aprovado` int DEFAULT NULL COMMENT '1-ok 2-doc pendente',
  `online` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Despejando dados para a tabela `app_users`
--

INSERT INTO `app_users` (`id`, `id_grupo`, `tipo_pessoa`, `nome`, `email`, `password`, `documento`, `cnpj`, `razao_social`, `nome_fantasia`, `ie`, `celular`, `avatar`, `data_nascimento`, `data_cadastro`, `u_login`, `token_senha`, `token_cadastro`, `perc_imoveis`, `perc_eventos`, `status`, `status_aprovado`, `online`) VALUES
(280, 1, 1, 'ogpGbr9X7Ops7Syo1MibCxRAyUv5gIWdwjdBaEg46is=', '7BWjCKRslaRoQj541N45h0a0gijWxBVQZrLw5oJ2+mo=', '$2a$08$MTtyR1y4GK4MJrgV7FziSuK2LjvWUIaMI2mC9Rkf9xMEsMWdnuAp2', NULL, '', '', '', '', 'twrnozQ3JWPdRUfPGBcVmQ==', NULL, NULL, '2025-05-17 17:41:30', '2025-09-15 15:58:56', '8a9c8ac001d3ef9e4ce39b1177295e03', NULL, NULL, NULL, 1, 1, 0),
(300, 4, 1, 'kvLkiUeHSC83kFo9o7bY7A==', 'kc/Mc+llrQ4QNScGvoYm1A==', '$2a$08$545oNirFfbnXMmARlWCUxeiyYDXMa1oYo0nyvm52vkUp4OOD5OLO6', NULL, '', '', '', '', '1ueVJX4x7tQx78Gzng9j3w==', 'avatar.png', NULL, '2025-07-22 10:59:09', '2025-07-22 10:59:24', NULL, 'd6dabcc412981d56c8733b52586a9d44', 0.00, 0.00, 1, 1, 2),
(301, 4, 1, 'ogpGbr9X7Ops7Syo1MibCxRAyUv5gIWdwjdBaEg46is=', '7BWjCKRslaRoQj541N45h0a0gijWxBVQZrLw5oJ2+mo=', '$2a$08$QsCBytREvdcaRvVqelGMdeoNtZ66vqzG4pS1N7PLmlgdg/pzE3rYa', 'Yy1zX3w5u5giqWRtVp3VQQ==', 't/3C+Y9ESUx2Y/J81osnoQ==', 't/3C+Y9ESUx2Y/J81osnoQ==', 't/3C+Y9ESUx2Y/J81osnoQ==', 't/3C+Y9ESUx2Y/J81osnoQ==', 'twrnozQ3JWPdRUfPGBcVmQ==', 'avatar.png', 'rnCvyBPbsucQojIeFUpRDw==', '2025-07-22 15:06:45', '2025-07-22 15:27:01', '8a9c8ac001d3ef9e4ce39b1177295e03', '154f596a0e4aec4cf23ee4b76ae3d34a', 0.00, 0.00, 1, 1, 2),
(302, 4, 1, 'UrWyM2QMYD+VEW88SId588QaC4zTtdvHiC2CBcRc0yY=', '8QT0aH4XGEYlabvw1a6BfKzIn6RcBLMSgwMTISjuQRA=', '$2a$08$kaStXYPFqKAJ0itrmYiCbeT0VMvOM5Y7VFshaVJIvWtVpEjH8/Ap2', 'WxuTFtloEaY7AosvkqrQbg==', 't/3C+Y9ESUx2Y/J81osnoQ==', 't/3C+Y9ESUx2Y/J81osnoQ==', 't/3C+Y9ESUx2Y/J81osnoQ==', 't/3C+Y9ESUx2Y/J81osnoQ==', 'JZdlRelQ03K87rSqZxZgVQ==', 'avatar.png', 'Qjt89+eMziGZzcxHYWJt3Q==', '2025-07-22 15:09:04', '2025-07-22 15:09:34', '6f8caa0e6413027cb7a12f945151cb8d', 'fa3060edb66e6ff4507886f9912e1ab9', 0.00, 0.00, 1, 1, 2),
(303, 4, 1, 'J8izHQ2wrf4yeKohYFbjiccYW0W13XebqBhMiXeXs3w=', 'B1/frRivEkg8G0USruwca9OtGjhrJ1z30I9BdDZQBBU=', '$2a$08$Vq41a0AXsbK7fMytYaeGGOqMKCdPxPmrjMORpSkk9h/Y3sAsOr69u', 'Fl7PamqjshFnUQKqpbO9dQ==', 't/3C+Y9ESUx2Y/J81osnoQ==', 't/3C+Y9ESUx2Y/J81osnoQ==', 't/3C+Y9ESUx2Y/J81osnoQ==', 't/3C+Y9ESUx2Y/J81osnoQ==', 'qn5KY9XqStIMRe8dsXB/Sg==', 'avatar.png', '+XxldWMRyBLQ/K3CBk++9Q==', '2025-07-22 15:12:02', '2025-09-30 14:23:25', '1b8df7db8a335c9096e43973615601d8', '4fbe073f17f161810fdf3dab1307b30f', 7.00, 7.00, 1, 1, 2),
(304, 4, 1, '5y5lMnNKfGjE4J2OH+lbWQ==', '5QNpGHBIz/e49gH5aAdYFjn4phpyPUjG5L9MtUhhv58=', '$2a$08$oE6Yu4a3tYTsoRu92aygh.ev8HoS7o.brVZzEi/I0YdBK1iHe3CYq', 'Wu9uJrdJvWjxVNmlTf3+8g==', 't/3C+Y9ESUx2Y/J81osnoQ==', 't/3C+Y9ESUx2Y/J81osnoQ==', 't/3C+Y9ESUx2Y/J81osnoQ==', 't/3C+Y9ESUx2Y/J81osnoQ==', 'Q3ZdkYn4tCKJOWRepWMmDQ==', '6943a042439b5fcb4c562c00b68e7056.png', 'ZHmxRmJZqr5HHDcLghydIA==', '2025-07-22 15:29:13', '2025-09-02 10:06:02', '548f45be9b6c68f10bed527bce14246e', '878a0658e652765c4979dba411787e43', 0.00, 0.00, 1, 1, 2),
(305, 4, 1, 'Sht265mdUCXwmBka5xPUwA==', 'LjVdxYzofflikHEPdqzUFw==', '$2a$08$oIb5ebQRtdj5ZPAm2VN9W.TR6EQ5iCs3Zb6IFLrd91.5MfYE2nDre', 'Wu9uJrdJvWjxVNmlTf3+8g==', 't/3C+Y9ESUx2Y/J81osnoQ==', 't/3C+Y9ESUx2Y/J81osnoQ==', 't/3C+Y9ESUx2Y/J81osnoQ==', 't/3C+Y9ESUx2Y/J81osnoQ==', 'PdsmBPKrgZyagtWwlegHZA==', 'avatar.png', '3Vf8Lwp7GDjbz09ym8UJ3A==', '2025-07-22 16:06:56', '2025-07-22 16:07:08', NULL, 'f1efa5d88238b08b7d0d285f2909295b', 0.00, 0.00, 1, 1, 2),
(306, 4, 1, '55ONQFdPmi11mV/e1edBuQ==', 'hsiZs09mJmVJn4EiU3ySAg==', '$2a$08$z7wgutm8tbz5OSvZOUhalu7anB1f7e2PDj/SUGoOPt1OkPmFe25hG', 'Wu9uJrdJvWjxVNmlTf3+8g==', 't/3C+Y9ESUx2Y/J81osnoQ==', 't/3C+Y9ESUx2Y/J81osnoQ==', 't/3C+Y9ESUx2Y/J81osnoQ==', 't/3C+Y9ESUx2Y/J81osnoQ==', 'Gc5mhBSpXLBaYp9K6MwY+w==', 'avatar.png', '3Vf8Lwp7GDjbz09ym8UJ3A==', '2025-07-22 16:09:00', '2025-07-22 16:09:21', NULL, 'd77314b5c23c087d9b5ed587e88800d2', 0.00, 0.00, 1, 1, 2),
(307, 4, 1, 'ZLhP0Ikn6QsPBnzC0EixRQ==', 'jr/8hm2i0DBuDKAHnojSiQ==', '$2a$08$QZhbPod8WQwkWhYFqukpIu187s4Dxhojjunx6FpoU7yD7Z4mcxc9y', 'Wu9uJrdJvWjxVNmlTf3+8g==', 't/3C+Y9ESUx2Y/J81osnoQ==', 't/3C+Y9ESUx2Y/J81osnoQ==', 't/3C+Y9ESUx2Y/J81osnoQ==', 't/3C+Y9ESUx2Y/J81osnoQ==', 'yJiCaraO/7e5uMaT3FC2kg==', 'avatar.png', '2/R8txqc4olY1iJAQPKt2A==', '2025-07-22 16:36:45', '2025-07-22 16:36:58', NULL, 'e17a886efc21fa45b9dc49a17c29dcf1', 0.00, 0.00, 1, 1, 2),
(308, 1, 0, 'QdD3WxQFN1gfGJcWeGBBwg==', 'aW3XPWbR4EbRz56HB6PYJObFPwSD0yFhRkxlYtYox7o=', '$2a$08$lDpZLyax0lyTGbvtqigqkuejGlUo2L7iwDx2EfLQ9Ur29LCUm6rFy', NULL, '', '', '', '', '5IcRDHnFqDfczZAjwNPrXg==', NULL, NULL, '2025-07-23 10:19:57', '2025-12-11 13:49:41', '548f45be9b6c68f10bed527bce14246e', NULL, NULL, NULL, 1, 1, 0),
(309, 4, 1, 'zeSqV0m1F/7KnOGah4Z2Bw==', 'zeSqV0m1F/7KnOGah4Z2Bw==', '$2a$08$WsSDOUvl4cFg18Lgzt2SXeE0G2vlT4ecjeuhkK3nj50wH5UtCpce6', NULL, '', '', '', '', 'n1FEX+cH0WoexZBjWLbYEA==', 'avatar.png', NULL, '2025-07-23 10:29:28', '2025-07-23 10:30:54', NULL, '146f7dd4c91bc9d80cf4458ad6d6cd1b', 0.00, 0.00, 1, 1, 2),
(310, 4, 2, 'wUIDDi9J55Zge2VMK/QLFg==', 'xKxJX7fu1gd2dJKeq9/uv3NeqeE9AGZhb7kRdr3HY6k=', '$2a$08$uNP8uwlzEJDYnmqx54pJoek4tRAroImcJZ3n39j/cze9g3dNHo1OS', 't/3C+Y9ESUx2Y/J81osnoQ==', 'HzeTyZ1ji2CpExs2qNOPvhBef0jqIkCmyUUEP6C5nTc=', 'RC3JXPUeFqehBkYH8nX6tjNJ3L0Lr2CXQ0dV7pLFTBVIKfiGQHxqik3s9Hq79+yE', '981pyRMBglfIsEfUJGjSpQ==', 'mIXTTzvGKNCMvYJ4LP3Pgg==', '8necMPu3j7ot9PG1otdXnQ==', 'avatar.png', 't/3C+Y9ESUx2Y/J81osnoQ==', '2025-07-26 12:56:28', '2025-08-08 10:56:28', NULL, '0babdd954699df097833f3d27e01d03d', 0.00, 0.00, 1, 1, 2),
(311, 4, 1, 'jc9eJhLbD2EkoqBR8IT0bAIkeOpuzSQTj3g38wZ74js=', 'U9bHuCoREnoTmpIrOjaCy+DXzXBUHTHWNbumGFWIBVs=', '$2a$08$MPv4ldX4wyl98ZVVzWMhve6tjgQUSdoCE6k8FcMJeP4KPHXfSLrNu', NULL, '', '', '', '', '4tmo7n/6euTkme5bxaAnsw==', 'avatar.png', NULL, '2025-07-29 11:29:12', NULL, NULL, 'c034642a2ae7547082484627da30f1fd', 0.00, 0.00, 1, 1, 0),
(312, 4, 1, 'jc9eJhLbD2EkoqBR8IT0bAIkeOpuzSQTj3g38wZ74js=', 'U9bHuCoREnoTmpIrOjaCyxI1/anRO8rWIU/LxRIuAjA=', '$2a$08$nkoT0RXHXR02QlZgEKtsz.2ZUT9fuXFQvoc03usDMGFfzqdTmdNQy', NULL, '', '', '', '', '4tmo7n/6euTkme5bxaAnsw==', 'avatar.png', NULL, '2025-07-29 11:33:02', '2025-07-29 12:03:08', NULL, 'a88aeeec495b4cbe092b4bcfd15b9d9c', 0.00, 0.00, 1, 1, 2),
(313, 4, 2, '95XDbP8P8+fvaWmgUKGrtQ==', 'f1fixn5TUCoKOczQ0XEAUwXegO/easThbapZkBM0Scs=', '$2a$08$M8Ux7VDfQWhG7sO4sgEvyeutLxea6Mmx4y4ZDOcOqJ9hOhKH.IGT2', 'I9TtCJLLjEVLl8dq2X03bw==', '62LZ/Wf7IXuUzBmYpbJJT7coIyyhtWYj5dxn4kYeiBc=', 'SHrdVFtwjic+SfRfukszn2lg8LoQkd2l9b8QYbhwrxM=', 'o0/ym7owfys/xjbOgVacRA==', 'D0wIVRkayViQ0me8Kii8iw==', 'bMJ+6DHeDXNnmmuzrtizHQ==', 'avatar.png', 't/3C+Y9ESUx2Y/J81osnoQ==', '2025-08-01 15:24:12', '2025-09-09 19:49:39', NULL, 'd65862e5c9c83c81bb456b82791a198c', 14.00, 14.00, 1, 0, 2),
(315, 4, 1, '/sn7+qDkhdt1h868zZCst8GTu12ftEIs1gldGC6MvXo=', 'OXfjeKLlgitWZcACbhO917R7NGousT5wxIHL9bV7osY=', '$2a$08$xlc7hgIWZTN9WnVXx7t0M.DLwalS9CPtHQmPxepN3D113QnJI278C', NULL, '', '', '', '', 'sG86/c9D1yaeR/gTdqgrDQ==', 'avatar.png', NULL, '2025-08-03 19:53:39', '2025-08-03 19:54:10', NULL, 'd1d5923fc822531bbfd9d87d4760914b', 0.00, 0.00, 1, 1, 2),
(316, 4, 0, 'MsHQwvQLPRg6n1DfPk92hg25qjDJm7azv3Kp6JSWPr0=', 'cJh1M6cUxjFoSYLefMRb+FUeQBH+2xkBOyRGCZ8Bu28=', '$2a$08$E2MJpPn2bBwLQwHesfXP8.YkRXInVZPhXqkh8hNW3pnNOiLHI9Bya', 'roo1wRq3Bfhek+eFrpiX8g==', 't/3C+Y9ESUx2Y/J81osnoQ==', 't/3C+Y9ESUx2Y/J81osnoQ==', 't/3C+Y9ESUx2Y/J81osnoQ==', 't/3C+Y9ESUx2Y/J81osnoQ==', 'NMSRFv856gnY/oiV9oDPdg==', 'd314083b26eb619eee0173a40406baa2.jpg', 't/3C+Y9ESUx2Y/J81osnoQ==', '2025-08-06 10:29:16', '2025-08-06 10:29:56', NULL, '14c4f36143b4b09cbc320d7c95a50ee7', 0.00, 0.00, 1, 1, 2),
(317, 4, 1, 'TJfdAnHz5ABEPrQrmKOmaA==', 'FOkBcXt81niSW11nVhLl960ZWcs0kurfEgNUp8EnL7o=', '$2a$08$HChSdHSXST7kUZRPU4MBz.M.5HTGkq34NfT2HBw2L9IfLKJFH3gEy', NULL, '', '', '', '', 'gsjhiWZLsyBN5kXdi+X33A==', 'avatar.png', NULL, '2025-08-06 23:05:47', '2025-10-03 19:15:10', NULL, '9313f5e96e48503b676b16e2e0d41455', 0.00, 0.00, 1, 1, 2),
(318, 4, 1, 'zU9xy9KZw2BE+64WQxtmwg==', '6YmLHS09CFEpDPMnp3WlgnnB7zAzq845ElDjzxpW5GI=', '$2a$08$eFcJehMPQlnv3CXNfSqt9.ak/ARKx/1Rtesju96fPlCu5dvjYmwwm', NULL, '', '', '', '', 'WiRFUEsb3UNh5h9xhyIRfA==', 'avatar.png', NULL, '2025-08-08 11:02:56', NULL, NULL, '81a6f51d90af2c00dfc715c5dc5fe88d', 0.00, 0.00, 1, 1, 0),
(319, 4, 1, 'zU9xy9KZw2BE+64WQxtmwg==', 'NpTPbzxZDqwDsm4e0tdQjmW9Y6+ztqNutq1Dp2EIV+o=', '$2a$08$4lq2LqXm8GDAte6z6kFpNOXjRLY28xQ0Inc2eTGyugwLOcMJVIiBa', NULL, '', '', '', '', 'WiRFUEsb3UNh5h9xhyIRfA==', 'avatar.png', NULL, '2025-08-08 11:07:50', '2025-08-08 11:08:55', NULL, 'a3c788c57e423fa9c177544a4d5d1239', 0.00, 0.00, 1, 1, 2),
(320, 4, 1, 'KR/OPHhLJ0BxXQnEzsefnQ==', 'fNBxPCrR+mep+3GaUtvHog==', '$2a$08$6Rss2tqnh9kBDrMR6EWmE.DKVYNH3CkwGXOIksU2a3uuy.16GkszO', 'Wu9uJrdJvWjxVNmlTf3+8g==', 't/3C+Y9ESUx2Y/J81osnoQ==', 't/3C+Y9ESUx2Y/J81osnoQ==', 't/3C+Y9ESUx2Y/J81osnoQ==', 't/3C+Y9ESUx2Y/J81osnoQ==', 'MKaR1C5zZeI7+f/utN27lA==', 'avatar.png', 'ZHmxRmJZqr5HHDcLghydIA==', '2025-08-08 11:11:40', '2025-08-08 11:11:54', NULL, '3000311ca56a1cb93397bc676c0b7fff', 0.00, 0.00, 1, 1, 2),
(321, 4, 1, 'KR/OPHhLJ0BxXQnEzsefnQ==', 'jTo2X/4+kTSuu6vPiphMWA==', '$2a$08$UoXivM07Nhxv1JvACXI6c.qB0ahmkKUcTbt/YAPxRByY8DCPlQi/y', 'Wu9uJrdJvWjxVNmlTf3+8g==', 't/3C+Y9ESUx2Y/J81osnoQ==', 't/3C+Y9ESUx2Y/J81osnoQ==', 't/3C+Y9ESUx2Y/J81osnoQ==', 't/3C+Y9ESUx2Y/J81osnoQ==', 'GOSSFTynLRJyx4JNtxlwEA==', 'avatar.png', 'waSha7k3wI6RU2uxnIW80A==', '2025-08-08 11:22:07', '2025-08-08 11:22:37', NULL, 'efb534de6f86b9996e556b05ddf72357', 0.00, 0.00, 1, 1, 2),
(322, 4, 1, 'uFMFWRMRfq9zvNTPb+XGlPXQoJDJy5De/SExjotPmkc=', 'MZa7GIkn82IJtEB04evmMCkBDzmMH28BuajtV5Z/sDk=', '$2a$08$GlCbWgar1Yn0mZKbrrZ8C.vhXwuqgSX4GZ8lBpa3KSeaur73zRdqe', NULL, '', '', '', '', '4L0CjgkTY6g4XVFAGsRwVQ==', 'avatar.png', NULL, '2025-08-11 21:50:02', '2025-08-11 21:50:39', NULL, 'a1b63b36ba67b15d2f47da55cdb8018d', 0.00, 0.00, 1, 1, 2),
(323, 4, 1, 'uPhhTAPT1Pjb97efKLa4yKF67/mamDQ37K6eG1Tu2WXn27/zOKBXTgyVRKMSb4oS', 'M/9Oj2Q7XgxIyBHgHImP+zQ8NVhwjVb/YH8O/gXxa94=', '$2a$08$1CAK4WAN8c2rUFMqDAJR7.vd1QT2AvnAZTlM7pmBYcbXFdOoCiFsa', NULL, '', '', '', '', 'yNLLtYwcPMVEWYWUuICPvw==', 'avatar.png', NULL, '2025-09-04 13:20:23', '2025-09-04 13:20:48', NULL, 'a7b0d547ea892113ec47dc262675fc7b', 0.00, 0.00, 1, 1, 2),
(324, 4, 1, 'p0BlovSJVH9Ikh2OzhQ4nQ==', 'awJLBBQITsQ1Dj6TXtd7XePS82A0QOvGak9rG4JIhL0=', '$2a$08$VDMFnA6DDova8zP4WeMNJe4NkcX1IWPzjCMqSAGFnGnCZGbo7jjjC', NULL, '', '', '', '', 'A6tCDXxZex5jAZCqT8kwtw==', 'avatar.png', NULL, '2025-09-08 22:37:23', '2025-09-08 22:48:04', NULL, '482db0ecc10b8a9984ae850c9ada9899', 0.00, 0.00, 1, 1, 2),
(325, 4, 1, 'VRVSjyuG90QBEEGYGd+Kzv2xLKgFAkqgkWLPygV9VeI=', 'fyAf0hyy57+VO8RAZWILKWxKn+d4rtejyTnby37S+K0=', '$2a$08$OvBJh117fQjboUANkKsiTeIY4aYl8.U6wBSg7m32tOwcf8kYFZ2jy', NULL, '', '', '', '', 'My5gUXhQFobTJ7TTkI6OlA==', 'avatar.png', NULL, '2025-09-12 09:43:45', NULL, NULL, '8dbdbf0cedc89e9a82967a7d983c11ca', 0.00, 0.00, 1, 1, 0),
(326, 1, 0, 'hHHYyPySWVcwfPjFAnfvXw==', 'B1/frRivEkg8G0USruwca9OtGjhrJ1z30I9BdDZQBBU=', '$2a$08$iERUXQBZ1UT9xhKAFQtNF.HPZoeCDlfCj15D95acdGOQPoLbRC/9i', NULL, '', '', '', '', '5OJ53Tw0gXyZofcjqgxmTg==', NULL, NULL, '2025-09-15 14:19:26', '2025-09-30 15:06:11', NULL, NULL, NULL, NULL, 1, 1, 0),
(327, 1, 0, 'Hnj8dD5RKP5y63eyCRfFJ0v/J5yeRps5ywldfwQmIfg=', '8QT0aH4XGEYlabvw1a6BfKzIn6RcBLMSgwMTISjuQRA=', '$2a$08$2dopkahzAMqMc0FjhnN4y.bbSkFbvj9fDrdUf0Ll9aSVu.hGzopRm', NULL, '', '', '', '', 'ETIy0++6Eu7ZijPhtSE6YA==', NULL, NULL, '2025-09-15 14:19:45', '2025-09-15 14:21:18', NULL, NULL, NULL, NULL, 1, 1, 0),
(328, 4, 1, 'skW9h+VFp3/oy2ItfIyDXQ==', '5zjMiKQWRxf9uXzbkXE4bq8Xr/GDOkQam2zvZrWseAE=', '$2a$08$rRMV3YKhjio8AYQFHWyvfetHka8uFRq9FI.LQbmiN73tKykwKpfc.', NULL, '', '', '', '', 'OOE03ZaDtW/wxmh4rwjoDQ==', 'avatar.png', NULL, '2025-09-15 21:38:53', '2025-09-15 21:39:23', NULL, '9cd3598a91516950427c605ae29cff68', 0.00, 0.00, 1, 1, 2),
(329, 4, 1, '5Sf9F+/AF370f/JbgKpYFHkPL8kZ0SSddo6I9NpX0h8ZCiFprppNiiRD67/7DCXY', 'v13XWZSN+3Wr/pRVf9QmUGlQlWGqyOOcx8kVmqtfzMI=', '$2a$08$hOYdYASJeJqZzvT8NRlrm.Q0YEwKDFmdHnXGDcyr4Fg1sOvqz/FPG', NULL, '', '', '', '', '9VrbAcXHtku0aKLC5aRDAw==', 'avatar.png', NULL, '2025-09-23 18:43:24', '2025-09-23 18:44:35', NULL, 'f4cc4b9bf4dc2237cb88718132e9fb7c', 0.00, 0.00, 1, 1, 2),
(330, 4, 1, 'eVvncqjaV7MweHND29s7Xg==', 'iTLmzXYwgovPNapybGo3lbVyYzfMNgNagPWouj8QWB8=', '$2a$08$HOaNGF2gG7MmJHdcqd96zehpsEP6LBNPV1e/rSEXb4m0uHXyk02SC', NULL, '', '', '', '', 'gcsKB6pBEkZ3yAvVBeowZA==', 'avatar.png', NULL, '2025-10-01 16:21:56', '2025-10-01 16:25:28', NULL, '3bc71faebe42e1639eb6fded38d714cd', 0.00, 0.00, 1, 1, 2),
(331, 4, 1, '59yo1wBxnwGhfz4g8P9ckg==', 'NPf5K0bZwysq+7Lw39dEPPDC13dk63ghwavpPX3y0mk=', '$2a$08$dj7rb2t2OOVSI6IpsL7g3Oh/4jkMCQNBnxqJk4F6PifR3dnlG7fB.', NULL, '', '', '', '', 'rn6rjUXGTFU17np5iYbuPg==', 'avatar.png', NULL, '2025-10-09 14:45:35', '2025-10-09 14:46:03', NULL, 'fbad057973f18db4d1045d3538e69c50', 0.00, 0.00, 1, 1, 2),
(332, 1, 1, 'Administrador', 'admin@go77app.com', '$2a$08$HyH0kOwtQxTZ4ZwtysUU5ueWBlfOBfHYND4yPitKwt/uL0WqYnpcG', '', '', '', '', '', '', NULL, NULL, '2025-11-26 18:10:37', NULL, NULL, NULL, NULL, NULL, 1, 1, 0),
(333, 1, 1, 'QdD3WxQFN1gfGJcWeGBBwg==', 'aW3XPWbR4EbRz56HB6PYJObFPwSD0yFhRkxlYtYox7o=', '$2a$08$XaVY6qYFLA/RV14UJypj0OTA/EphC5CPi2GTiO.XgBk4iNYkS3gDy', '', '', '', '', '', '', NULL, NULL, '2025-11-26 18:15:35', '2025-12-11 13:49:41', NULL, NULL, NULL, NULL, 1, 1, 0),
(334, 4, 1, '5f4sd2O2hNFk61AiD1U1hA==', '4lrripEdCOH2ix/JR9zVDIu5b0sXUbHNrnyCxv5sViA=', '$2a$08$bb4w47Zz94ey1DnMx8Jok.Sa1lbZ683DQMVORa0M9OX9amNvuiJNW', 'Pa59bNW+ZhxQSGJuuwMjAg==', 't/3C+Y9ESUx2Y/J81osnoQ==', 't/3C+Y9ESUx2Y/J81osnoQ==', 't/3C+Y9ESUx2Y/J81osnoQ==', 't/3C+Y9ESUx2Y/J81osnoQ==', 't/3C+Y9ESUx2Y/J81osnoQ==', NULL, '6ZWmVtM7P33OpQu0PlIwFw==', '2025-11-26 21:44:49', '2025-12-11 12:55:18', NULL, NULL, NULL, NULL, 1, 1, 2);

-- --------------------------------------------------------

--
-- Estrutura para tabela `app_users_endereco`
--

CREATE TABLE `app_users_endereco` (
  `id` int NOT NULL,
  `app_users_id` int NOT NULL,
  `nome` text CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci,
  `end_completo` text CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci,
  `latitude` text NOT NULL,
  `longitude` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estrutura para tabela `app_users_location`
--

CREATE TABLE `app_users_location` (
  `id` int NOT NULL,
  `app_users_id` int NOT NULL,
  `latitude` varchar(50) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL,
  `longitude` varchar(50) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL,
  `data` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Despejando dados para a tabela `app_users_location`
--

INSERT INTO `app_users_location` (`id`, `app_users_id`, `latitude`, `longitude`, `data`) VALUES
(1, 300, '-16.3339928', '-39.571768', '2025-07-22 10:59:09'),
(2, 301, '', '', '2025-07-22 15:06:45'),
(3, 302, '', '', '2025-07-22 15:09:04'),
(4, 303, '', '', '2025-07-22 15:12:02'),
(5, 304, '-16.374308909975657', '-39.58487123211263', '2025-07-22 15:29:13'),
(6, 305, '-16.3339928', '-39.571768', '2025-07-22 16:06:56'),
(7, 306, '-16.3339928', '-39.571768', '2025-07-22 16:09:00'),
(8, 307, '-16.3339928', '-39.571768', '2025-07-22 16:36:45'),
(9, 309, '-16.36500630145179', '-39.54076574001109', '2025-07-23 10:29:28'),
(10, 310, '-27.7763835', '-50.2896933', '2025-07-26 12:56:28'),
(11, 311, '', '', '2025-07-29 11:29:12'),
(12, 312, '', '', '2025-07-29 11:33:02'),
(13, 313, '-28.0739632', '-49.4194304', '2025-08-01 15:24:12'),
(15, 315, '-27.99414982754619', '-49.585788436851786', '2025-08-03 19:53:39'),
(16, 316, '-30.2120275', '-51.1279333', '2025-08-06 10:29:16'),
(17, 317, '-28.679102204548244', '-49.38004823345785', '2025-08-06 23:05:47'),
(18, 318, '-27.046131732729794', '-52.635000715605585', '2025-08-08 11:02:56'),
(19, 319, '-27.04613174378982', '-52.6350007085394', '2025-08-08 11:07:50'),
(20, 320, '-16.365113', '-39.540897', '2025-08-08 11:11:40'),
(21, 321, '-16.4757504', '-39.0791168', '2025-08-08 11:22:07'),
(22, 322, '-28.68228022748285', '-49.39493692963102', '2025-08-11 21:50:02'),
(23, 323, '-28.7546126', '-49.4402524', '2025-09-04 13:20:23'),
(24, 324, '-27.8149743', '-50.3471393', '2025-09-08 22:37:23'),
(25, 325, '-26.962686064561236', '-52.54836627424386', '2025-09-12 09:43:45'),
(26, 328, '-28.75436203091289', '-49.43767759953573', '2025-09-15 21:38:53'),
(27, 329, '-28.7468044', '-49.4448782', '2025-09-23 18:43:24'),
(28, 330, '-27.80034832717449', '-50.3184656805384', '2025-10-01 16:21:56'),
(29, 331, '', '', '2025-10-09 14:45:35');

-- --------------------------------------------------------

--
-- Estrutura para tabela `app_users_pix`
--

CREATE TABLE `app_users_pix` (
  `id` int NOT NULL,
  `app_users_id` int NOT NULL,
  `tipo_chave` int DEFAULT NULL COMMENT '1 - cpf 2 - celular3 - email 4 - aleatorio 5 - cnpj',
  `chave` varchar(100) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Despejando dados para a tabela `app_users_pix`
--

INSERT INTO `app_users_pix` (`id`, `app_users_id`, `tipo_chave`, `chave`) VALUES
(2, 302, 2, '(11) 94980-9383'),
(3, 303, 2, '(49) 99188-1512'),
(4, 301, 1, '855.708.260-68'),
(5, 304, 1, '043.276.785-11'),
(6, 305, 1, '312.322.123-11'),
(7, 306, 1, '312.321.123-21'),
(9, 309, 1, '043.276.785-11'),
(10, 313, 2, '(48) 99684-6782'),
(11, 316, 3, 'vila4ventos@gmail.com'),
(12, 321, 5, '23.032.030/3000-00'),
(14, 307, 5, '58.804.210/0001-12'),
(18, 334, 1, '123.123.123-13');

-- --------------------------------------------------------

--
-- Estrutura para tabela `app_users_saldo`
--

CREATE TABLE `app_users_saldo` (
  `id` int NOT NULL,
  `app_users_id` int NOT NULL,
  `saldo` decimal(10,2) DEFAULT NULL,
  `data` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Despejando dados para a tabela `app_users_saldo`
--

INSERT INTO `app_users_saldo` (`id`, `app_users_id`, `saldo`, `data`) VALUES
(1, 300, 0.00, '2025-07-22 10:59:09'),
(2, 301, 0.00, '2025-07-22 15:06:45'),
(3, 302, 0.00, '2025-07-22 15:09:04'),
(4, 303, 0.00, '2025-07-22 15:12:02'),
(5, 304, 0.00, '2025-07-22 15:29:13'),
(6, 305, 0.00, '2025-07-22 16:06:56'),
(7, 306, 0.00, '2025-07-22 16:09:00'),
(8, 307, 0.00, '2025-07-22 16:36:45'),
(9, 309, 0.00, '2025-07-23 10:29:28'),
(10, 310, 0.00, '2025-07-26 12:56:28'),
(11, 311, 0.00, '2025-07-29 11:29:12'),
(12, 312, 0.00, '2025-07-29 11:33:02'),
(13, 313, 0.00, '2025-08-01 15:24:12'),
(15, 315, 0.00, '2025-08-03 19:53:39'),
(16, 316, 0.00, '2025-08-06 10:29:16'),
(17, 317, 0.00, '2025-08-06 23:05:47'),
(18, 318, 0.00, '2025-08-08 11:02:56'),
(19, 319, 0.00, '2025-08-08 11:07:50'),
(20, 320, 0.00, '2025-08-08 11:11:40'),
(21, 321, 0.00, '2025-08-08 11:22:07'),
(22, 322, 0.00, '2025-08-11 21:50:02'),
(23, 323, 0.00, '2025-09-04 13:20:23'),
(24, 324, 0.00, '2025-09-08 22:37:23'),
(25, 325, 0.00, '2025-09-12 09:43:45'),
(26, 328, 0.00, '2025-09-15 21:38:53'),
(27, 329, 0.00, '2025-09-23 18:43:24'),
(28, 330, 0.00, '2025-10-01 16:21:56'),
(29, 331, 0.00, '2025-10-09 14:45:35');

-- --------------------------------------------------------

--
-- Estrutura para tabela `app_users_two`
--

CREATE TABLE `app_users_two` (
  `id` int NOT NULL,
  `app_users_id` int DEFAULT NULL,
  `code` varchar(4) DEFAULT NULL,
  `data_cadastro` datetime DEFAULT NULL,
  `latitude` varchar(50) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL,
  `longitude` varchar(50) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL,
  `status` int DEFAULT NULL COMMENT '1 - confirmado\n2 - pendente\n'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Despejando dados para a tabela `app_users_two`
--

INSERT INTO `app_users_two` (`id`, `app_users_id`, `code`, `data_cadastro`, `latitude`, `longitude`, `status`) VALUES
(1, 284, '1940', '2025-07-18 14:57:15', '', '', 1),
(2, 284, '8362', '2025-07-18 14:58:15', '', '', 1),
(3, 284, '2287', '2025-07-19 19:31:57', '', '', 1),
(4, 300, '7806', '2025-07-22 10:59:09', '-16.3339928', '-39.571768', 1),
(5, 284, '5036', '2025-07-22 14:52:31', '', '', 1),
(6, 301, '3222', '2025-07-22 15:06:45', '', '', 1),
(7, 302, '1856', '2025-07-22 15:09:04', '', '', 1),
(8, 301, '5137', '2025-07-22 15:09:26', '', '', 1),
(9, 301, '1526', '2025-07-22 15:10:46', '', '', 1),
(10, 303, '1435', '2025-07-22 15:12:02', '', '', 1),
(11, 303, '1291', '2025-07-22 15:13:47', '', '', 1),
(12, 301, '4332', '2025-07-22 15:26:50', '-30.194178941938286', '-51.16620168961872', 1),
(13, 304, '1124', '2025-07-22 15:29:13', '-16.374308909975657', '-39.58487123211263', 1),
(14, 304, '9614', '2025-07-22 16:00:33', '', '', 1),
(15, 304, '3619', '2025-07-22 16:04:17', '-16.3339928', '-39.571768', 1),
(16, 305, '6272', '2025-07-22 16:06:56', '-16.3339928', '-39.571768', 1),
(17, 306, '4604', '2025-07-22 16:09:00', '-16.3339928', '-39.571768', 1),
(18, 304, '7413', '2025-07-22 16:14:56', '-30.19422332087106', '-51.16627663590146', 1),
(19, 304, '8759', '2025-07-22 16:17:04', '-30.19426150500416', '-51.16604404292065', 1),
(20, 304, '3549', '2025-07-22 16:21:35', '-16.3339928', '-39.571768', 1),
(21, 284, '7004', '2025-07-22 16:25:20', '', '', 1),
(22, 307, '9134', '2025-07-22 16:36:45', '-16.3339928', '-39.571768', 1),
(23, 304, '5597', '2025-07-22 16:39:07', '', '', 1),
(24, 284, '3431', '2025-07-23 07:54:56', '', '', 1),
(25, 303, '1942', '2025-07-23 08:00:54', '', '', 1),
(26, 280, '8835', '2025-07-23 09:07:53', '', '', 1),
(27, 280, '9547', '2025-07-23 09:11:15', '', '', 1),
(28, 280, '9228', '2025-07-23 09:36:05', '', '', 1),
(29, 304, '1193', '2025-07-23 10:11:14', '', '', 1),
(30, 280, '4798', '2025-07-23 10:14:43', '', '', 1),
(31, 308, '7438', '2025-07-23 10:20:23', '', '', 1),
(32, 309, '7776', '2025-07-23 10:29:28', '-16.36500630145179', '-39.54076574001109', 1),
(33, 309, '7908', '2025-07-23 10:30:48', '', '', 1),
(34, 304, '6517', '2025-07-23 10:48:49', '-16.3339928', '-39.571768', 1),
(35, 280, '8831', '2025-07-23 11:16:06', '', '', 1),
(36, 304, '8525', '2025-07-23 12:01:58', '-16.365113', '-39.540897', 1),
(37, 280, '2962', '2025-07-23 13:11:04', '', '', 1),
(38, 284, '3264', '2025-07-23 13:28:44', '', '', 1),
(39, 308, '5349', '2025-07-23 15:06:16', '', '', 1),
(40, 304, '1899', '2025-07-23 15:21:06', '-16.3339928', '-39.571768', 1),
(41, 304, '1136', '2025-07-23 20:49:30', '', '', 1),
(42, 304, '6954', '2025-07-23 20:57:07', '-16.3339928', '-39.571768', 1),
(43, 304, '9953', '2025-07-24 09:56:30', '-30.19416349385878', '-51.166248317449416', 1),
(44, 280, '6949', '2025-07-24 10:01:40', '', '', 1),
(45, 308, '5945', '2025-07-24 10:13:29', '', '', 1),
(46, 303, '2007', '2025-07-24 12:23:47', '-27.7764151', '-50.28966', 1),
(47, 303, '5586', '2025-07-24 12:35:40', '-27.7844768', '-50.2966046', 1),
(48, 303, '2830', '2025-07-24 12:44:20', '-27.776544780982846', '-50.28964049358648', 1),
(49, 303, '3887', '2025-07-24 12:48:00', '-27.7764219', '-50.2896696', 1),
(50, 284, '6511', '2025-07-24 12:48:38', '', '', 1),
(51, 303, '2320', '2025-07-24 13:02:28', '-27.7844768', '-50.2966046', 1),
(52, 303, '8130', '2025-07-24 13:07:46', '-27.7844768', '-50.2966046', 1),
(53, 303, '4041', '2025-07-24 16:01:36', '', '', 1),
(54, 280, '5732', '2025-07-25 09:16:20', '', '', 1),
(55, 308, '4186', '2025-07-25 11:15:38', '', '', 1),
(56, 280, '6010', '2025-07-25 11:45:57', '', '', 1),
(57, 284, '7096', '2025-07-25 14:04:34', '', '', 1),
(58, 303, '1916', '2025-07-25 14:10:26', '-27.7763912', '-50.2896858', 1),
(59, 284, '4175', '2025-07-25 14:19:04', '', '', 1),
(60, 303, '5254', '2025-07-25 14:29:02', '-27.7763733', '-50.2897023', 1),
(61, 284, '8534', '2025-07-25 14:32:55', '', '', 1),
(62, 303, '4433', '2025-07-25 14:35:30', '-27.776419', '-50.2896735', 1),
(63, 284, '6752', '2025-07-25 17:11:52', '', '', 1),
(64, 284, '5406', '2025-07-25 17:22:05', '', '', 1),
(65, 308, '5111', '2025-07-25 18:49:30', '', '', 1),
(66, 310, '5999', '2025-07-26 12:56:28', '-27.7763835', '-50.2896933', 1),
(67, 311, '9734', '2025-07-29 11:29:12', '', '', 2),
(68, 311, '8370', '2025-07-29 11:32:25', '', '', 2),
(69, 312, '5000', '2025-07-29 11:33:02', '', '', 1),
(70, 312, '3441', '2025-07-29 12:02:38', '', '', 1),
(71, 284, '3211', '2025-07-29 12:50:22', '', '', 1),
(72, 303, '2644', '2025-07-29 12:51:40', '-27.8102016', '-50.3218176', 1),
(73, 303, '7191', '2025-07-29 12:56:07', '-27.585126', '-50.362937', 1),
(74, 284, '4733', '2025-07-29 12:56:28', '', '', 1),
(75, 303, '5644', '2025-07-29 15:25:12', '', '', 1),
(76, 280, '3246', '2025-07-30 10:29:31', '', '', 1),
(77, 284, '2519', '2025-07-30 17:59:17', '', '', 1),
(78, 303, '5048', '2025-07-30 18:01:35', '-27.7868439', '-50.29596', 1),
(79, 284, '6913', '2025-07-31 10:43:14', '', '', 1),
(80, 284, '7450', '2025-07-31 10:59:18', '', '', 1),
(81, 313, '1237', '2025-08-01 15:24:12', '-28.0739632', '-49.4194304', 1),
(82, 313, '5051', '2025-08-01 15:24:12', '-28.0739632', '-49.4194304', 1),
(83, 284, '2506', '2025-08-01 15:45:38', '', '', 1),
(84, 315, '2607', '2025-08-03 19:53:39', '-27.99414982754619', '-49.585788436851786', 1),
(85, 284, '5792', '2025-08-05 16:05:14', '', '', 1),
(86, 316, '2839', '2025-08-06 10:29:16', '-30.2120275', '-51.1279333', 1),
(87, 284, '9232', '2025-08-06 13:25:18', '', '', 1),
(88, 284, '6561', '2025-08-06 13:30:08', '', '', 1),
(89, 317, '8898', '2025-08-06 23:05:47', '-28.679102204548244', '-49.38004823345785', 1),
(90, 313, '7082', '2025-08-07 18:05:19', '-27.7840453', '-50.29596', 1),
(91, 313, '3159', '2025-08-07 18:06:36', '-27.7840453', '-50.29596', 1),
(92, 284, '7135', '2025-08-07 18:08:05', '', '', 1),
(93, 310, '6353', '2025-08-08 10:56:07', '-27.7763855', '-50.2896574', 1),
(94, 284, '6532', '2025-08-08 11:01:26', '', '', 1),
(95, 318, '9366', '2025-08-08 11:02:57', '-27.046131732729794', '-52.635000715605585', 2),
(96, 318, '9997', '2025-08-08 11:04:35', '-27.046131732729794', '-52.635000715605585', 2),
(97, 318, '2083', '2025-08-08 11:05:36', '-27.046131732729794', '-52.635000715605585', 2),
(98, 319, '6744', '2025-08-08 11:07:50', '-27.04613174378982', '-52.6350007085394', 1),
(99, 303, '9387', '2025-08-08 11:09:52', '-27.776383', '-50.2896939', 1),
(100, 320, '2984', '2025-08-08 11:11:41', '-16.365113', '-39.540897', 1),
(101, 321, '4699', '2025-08-08 11:22:08', '-16.4757504', '-39.0791168', 1),
(102, 284, '3381', '2025-08-10 09:21:10', '', '', 1),
(103, 313, '1978', '2025-08-10 09:22:11', '-27.7876781', '-50.2966046', 1),
(104, 304, '5274', '2025-08-11 21:31:48', '-16.36493031895686', '-39.540787741636365', 1),
(105, 308, '3148', '2025-08-11 21:33:06', '', '', 1),
(106, 304, '8783', '2025-08-11 21:39:56', '-16.3648951', '-39.5403782', 1),
(107, 322, '6364', '2025-08-11 21:50:02', '-28.68228022748285', '-49.39493692963102', 1),
(108, 304, '6861', '2025-08-12 16:25:19', '-30.040104', '-51.198006', 1),
(109, 284, '3151', '2025-08-22 18:51:02', '', '', 1),
(110, 303, '3019', '2025-08-23 18:16:18', '-27.7763906', '-50.2896864', 1),
(111, 284, '6706', '2025-08-23 18:33:45', '', '', 1),
(112, 303, '3423', '2025-08-23 18:35:22', '-27.7763885', '-50.2896859', 1),
(113, 313, '3603', '2025-08-28 17:59:15', '-27.769026', '-50.2966046', 1),
(114, 284, '1709', '2025-08-28 19:48:55', '', '', 1),
(115, 284, '5662', '2025-08-29 13:10:10', '', '', 1),
(116, 303, '8353', '2025-08-29 13:41:15', '-27.7680483', '-50.2966046', 1),
(117, 284, '3059', '2025-08-30 16:03:21', '', '', 1),
(118, 284, '6368', '2025-08-30 17:39:50', '', '', 1),
(119, 284, '7657', '2025-08-31 15:41:01', '', '', 1),
(120, 284, '5578', '2025-09-01 13:33:56', '', '', 1),
(121, 304, '5813', '2025-09-02 10:05:56', '-30.040104', '-51.198006', 1),
(122, 284, '5059', '2025-09-02 14:00:58', '', '', 1),
(123, 280, '1146', '2025-09-02 14:10:44', '', '', 1),
(124, 280, '7208', '2025-09-02 14:32:16', '', '', 1),
(125, 284, '2429', '2025-09-02 16:17:45', '', '', 1),
(126, 323, '6844', '2025-09-04 13:20:24', '-28.7546126', '-49.4402524', 1),
(127, 324, '1560', '2025-09-08 22:37:24', '-27.8149743', '-50.3471393', 1),
(128, 324, '5467', '2025-09-08 22:47:23', '-27.8149743', '-50.3471393', 1),
(129, 313, '3746', '2025-09-09 19:46:05', '', '', 1),
(130, 313, '3431', '2025-09-09 19:49:17', '-28.07393264770507', '-49.419425964355455', 1),
(131, 325, '6301', '2025-09-12 09:43:46', '-26.962686064561236', '-52.54836627424386', 2),
(132, 303, '1962', '2025-09-15 12:28:54', '-27.7680483', '-50.2966046', 1),
(133, 303, '1516', '2025-09-15 12:32:32', '-27.7680483', '-50.2966046', 1),
(134, 280, '8639', '2025-09-15 14:11:45', '', '', 1),
(135, 327, '9645', '2025-09-15 14:20:54', '', '', 1),
(136, 326, '4339', '2025-09-15 14:21:48', '', '', 1),
(137, 326, '6260', '2025-09-15 14:36:31', '', '', 1),
(138, 280, '1585', '2025-09-15 15:58:42', '', '', 1),
(139, 328, '6001', '2025-09-15 21:38:53', '-28.75436203091289', '-49.43767759953573', 1),
(140, 303, '4811', '2025-09-16 12:48:22', '-27.7680385', '-50.29596', 1),
(141, 326, '8643', '2025-09-16 13:48:32', '', '', 1),
(142, 303, '3948', '2025-09-17 16:04:09', '-27.785961', '-50.2933817', 1),
(143, 326, '9314', '2025-09-17 16:34:19', '', '', 1),
(144, 303, '8369', '2025-09-19 12:59:48', '-27.7762385', '-50.2898101', 1),
(145, 326, '1273', '2025-09-19 14:07:22', '', '', 1),
(146, 303, '6775', '2025-09-23 13:35:48', '-27.7762374', '-50.2898264', 1),
(147, 326, '8264', '2025-09-23 13:43:44', '', '', 1),
(148, 329, '5101', '2025-09-23 18:43:24', '-28.7468044', '-49.4448782', 1),
(149, 303, '4138', '2025-09-24 16:32:14', '-27.776361', '-50.2896978', 1),
(150, 326, '7209', '2025-09-25 16:01:13', '', '', 1),
(151, 326, '8592', '2025-09-29 08:22:28', '', '', 1),
(152, 326, '7923', '2025-09-29 21:50:55', '', '', 1),
(153, 326, '1488', '2025-09-30 08:34:43', '', '', 1),
(154, 303, '1709', '2025-09-30 14:23:01', '-27.7763541', '-50.2897085', 1),
(155, 326, '7085', '2025-09-30 15:05:53', '', '', 1),
(156, 330, '9686', '2025-10-01 16:21:57', '-27.80034832717449', '-50.3184656805384', 1),
(157, 317, '2663', '2025-10-03 19:14:47', '', '', 1),
(158, 331, '5575', '2025-10-09 14:45:35', '', '', 1),
(159, 308, '4672', '2025-11-26 18:17:48', '', '', 1),
(160, 308, '9586', '2025-11-26 18:19:09', '', '', 1),
(161, 334, '9994', '2025-11-26 21:45:18', '', '', 1),
(162, 334, '9889', '2025-11-26 21:48:14', '', '', 1),
(163, 334, '5782', '2025-11-26 22:28:16', '', '', 1),
(164, 308, '3103', '2025-12-11 10:09:36', '', '', 1),
(165, 334, '3442', '2025-12-11 12:54:57', '37.4219983', '-122.084', 1),
(166, 308, '9794', '2025-12-11 13:48:08', '', '', 1),
(167, 308, '8803', '2025-12-11 13:49:33', '', '', 1);

-- --------------------------------------------------------

--
-- Estrutura para tabela `tb_agenda`
--

CREATE TABLE `tb_agenda` (
  `id` int NOT NULL,
  `cliente` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL,
  `data` date DEFAULT NULL,
  `horario` varchar(5) DEFAULT NULL,
  `cep` varchar(9) DEFAULT NULL,
  `estado` varchar(2) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL,
  `cidade` varchar(100) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL,
  `bairro` varchar(100) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL,
  `endereco` text CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci,
  `numero` varchar(100) DEFAULT NULL,
  `texto` text CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci,
  `ativo` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estrutura para tabela `tb_arquivos`
--

CREATE TABLE `tb_arquivos` (
  `id` int NOT NULL,
  `nome` varchar(200) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL,
  `url` text CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci,
  `texto` text CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci,
  `ativo` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estrutura para tabela `tb_chat`
--

CREATE TABLE `tb_chat` (
  `id` int NOT NULL,
  `tb_users_id` int NOT NULL,
  `data` date DEFAULT NULL,
  `horario` varchar(5) DEFAULT NULL,
  `texto` text CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estrutura para tabela `tb_clientes`
--

CREATE TABLE `tb_clientes` (
  `id` int NOT NULL,
  `nome` varchar(155) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL,
  `email` varchar(155) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL,
  `tipo_pessoa` varchar(8) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL,
  `documento` varchar(50) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL,
  `telefone` varchar(20) DEFAULT NULL,
  `celular` varchar(20) DEFAULT NULL,
  `cep` varchar(9) DEFAULT NULL,
  `estado` varchar(2) DEFAULT NULL,
  `cidade` varchar(100) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL,
  `bairro` varchar(100) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL,
  `endereco` text CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci,
  `numero` varchar(50) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL,
  `obs` text CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci,
  `anexo` text
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estrutura para tabela `tb_config`
--

CREATE TABLE `tb_config` (
  `id` int NOT NULL,
  `email` varchar(50) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL,
  `telefone` varchar(20) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL,
  `cep` varchar(9) DEFAULT NULL,
  `estado` varchar(2) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL,
  `cidade` varchar(100) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL,
  `bairro` varchar(100) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL,
  `endereco` text CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci,
  `numero` varchar(50) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL,
  `facebook` text CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci,
  `twitter` text CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci,
  `instagram` text CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci,
  `google` text CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci,
  `senha_saldo` varchar(60) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Despejando dados para a tabela `tb_config`
--

INSERT INTO `tb_config` (`id`, `email`, `telefone`, `cep`, `estado`, `cidade`, `bairro`, `endereco`, `numero`, `facebook`, `twitter`, `instagram`, `google`, `senha_saldo`) VALUES
(1, NULL, '11990915555', '12425-210', 'SP', 'São Paulo', 'centro', 'centro', '111', NULL, NULL, NULL, NULL, '$2a$08$KwqZurLqRMAGKhQy6tx3uuPUE5Ywx5s6YlB3V/DKQk5kmsFyMI/qe'),
(1, NULL, '11990915555', '12425-210', 'SP', 'São Paulo', 'centro', 'centro', '111', NULL, NULL, NULL, NULL, '$2a$08$KwqZurLqRMAGKhQy6tx3uuPUE5Ywx5s6YlB3V/DKQk5kmsFyMI/qe');

-- --------------------------------------------------------

--
-- Estrutura para tabela `tb_contatos`
--

CREATE TABLE `tb_contatos` (
  `id` int NOT NULL,
  `nome` varchar(155) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL,
  `email` varchar(100) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL,
  `telefone` varchar(16) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL,
  `assunto` text CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci,
  `mensagem` text CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci,
  `data` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estrutura para tabela `tb_depoimentos`
--

CREATE TABLE `tb_depoimentos` (
  `id` int NOT NULL,
  `nome` varchar(45) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL,
  `texto` text CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci,
  `data` date DEFAULT NULL,
  `url` text CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci,
  `ativo` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estrutura para tabela `tb_equipes`
--

CREATE TABLE `tb_equipes` (
  `id` int NOT NULL,
  `tb_equipes_categoria_id` int NOT NULL,
  `nome` varchar(155) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL,
  `cargo` varchar(155) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL,
  `anexo` text CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci,
  `url` text CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci,
  `texto` text CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci,
  `ativo` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estrutura para tabela `tb_equipes_categoria`
--

CREATE TABLE `tb_equipes_categoria` (
  `id` int NOT NULL,
  `nome` varchar(155) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estrutura para tabela `tb_galerias`
--

CREATE TABLE `tb_galerias` (
  `id` int NOT NULL,
  `tb_galerias_categorias_id` int NOT NULL,
  `nome` varchar(200) DEFAULT NULL,
  `texto` text CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci,
  `ativo` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estrutura para tabela `tb_galerias_categorias`
--

CREATE TABLE `tb_galerias_categorias` (
  `id` int NOT NULL,
  `nome` varchar(155) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estrutura para tabela `tb_galerias_fotos`
--

CREATE TABLE `tb_galerias_fotos` (
  `id` int NOT NULL,
  `tb_galerias_id` int NOT NULL,
  `url` text CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci,
  `legenda` varchar(155) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL,
  `dest` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estrutura para tabela `tb_geral`
--

CREATE TABLE `tb_geral` (
  `id` int NOT NULL,
  `title` varchar(50) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL,
  `url_link` text CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci,
  `tb_geral_categorias_id` int NOT NULL,
  `nome` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL,
  `descricao` text CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci,
  `description` text CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci,
  `keywords` text CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci,
  `dest` int DEFAULT NULL,
  `pos` int DEFAULT NULL,
  `ativo` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Despejando dados para a tabela `tb_geral`
--

INSERT INTO `tb_geral` (`id`, `title`, `url_link`, `tb_geral_categorias_id`, `nome`, `descricao`, `description`, `keywords`, `dest`, `pos`, `ativo`) VALUES
(1, 'asadasas', 'asasa', 2, 'asasa', '<p>assasa</p>\r\n', 'asasa', 'asas', 2, 0, 1),
(1, 'asadasas', 'asasa', 2, 'asasa', '<p>assasa</p>\r\n', 'asasa', 'asas', 2, 0, 1);

-- --------------------------------------------------------

--
-- Estrutura para tabela `tb_geral_categorias`
--

CREATE TABLE `tb_geral_categorias` (
  `id` int NOT NULL,
  `nome` varchar(155) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Despejando dados para a tabela `tb_geral_categorias`
--

INSERT INTO `tb_geral_categorias` (`id`, `nome`) VALUES
(2, 'teste'),
(2, 'teste');

-- --------------------------------------------------------

--
-- Estrutura para tabela `tb_geral_fotos`
--

CREATE TABLE `tb_geral_fotos` (
  `id` int NOT NULL,
  `tb_geral_id` int NOT NULL,
  `url` text CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci,
  `legenda` varchar(155) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL,
  `dest` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estrutura para tabela `tb_menus`
--

CREATE TABLE `tb_menus` (
  `id` int NOT NULL,
  `nome` varchar(50) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL,
  `link` varchar(50) DEFAULT NULL,
  `ativo` int DEFAULT NULL,
  `icone` text
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Despejando dados para a tabela `tb_menus`
--

INSERT INTO `tb_menus` (`id`, `nome`, `link`, `ativo`, `icone`) VALUES
(1, 'Dashboard', 'dashboard', 1, 'hp-text-color-dark-0 iconly-Light-Chart'),
(2, 'Cadastros', 'cadastros', 1, 'hp-text-color-dark-0 iconly-Light-TwoUsers'),
(3, 'Anúncios', 'anuncios', 1, 'hp-text-color-dark-0 iconly-Light-Category'),
(4, 'Reservas', 'reservas', 1, 'hp-text-color-dark-0 iconly-Light-Bag'),
(11, 'Comissões', 'comissoes', 1, 'hp-text-color-dark-0 iconly-Light-Document'),
(12, 'Financeiro', 'financeiro', 1, 'hp-text-color-dark-0 iconly-Light-Document'),
(15, 'Estatísticas', 'estatisticas', 1, 'hp-text-color-dark-0 iconly-Broken-Activity'),
(16, 'Notificações', 'notificacoes', 1, 'hp-text-color-dark-0 iconly-Broken-InfoCircle'),
(17, 'Configurações', 'configuracoes', 1, 'hp-text-color-dark-0 iconly-Light-Setting'),
(18, 'Agendamentos', 'agendamentos', 2, 'hp-text-color-dark-0 iconly-Curved-Calendar'),
(19, 'Shop', 'shop', 2, 'hp-text-color-dark-0 iconly-Light-Buy'),
(21, 'Pagamentos', 'pagamentos', 2, 'hp-text-color-dark-0 iconly-Curved-Wallet'),
(23, 'Usuários', 'usuarios', 1, 'hp-text-color-dark-0 iconly-Light-User');

-- --------------------------------------------------------

--
-- Estrutura para tabela `tb_noticias`
--

CREATE TABLE `tb_noticias` (
  `id` int NOT NULL,
  `tb_noticias_categorias_id` int NOT NULL,
  `url_link` text CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci,
  `titulo` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL,
  `texto` text CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci,
  `data` date DEFAULT NULL,
  `horario` varchar(10) DEFAULT NULL,
  `url` text CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci,
  `dest` int DEFAULT NULL,
  `ativo` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estrutura para tabela `tb_noticias_categorias`
--

CREATE TABLE `tb_noticias_categorias` (
  `id` int NOT NULL,
  `nome` varchar(155) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estrutura para tabela `tb_noticias_fotos`
--

CREATE TABLE `tb_noticias_fotos` (
  `id` int NOT NULL,
  `tb_noticias_id` int NOT NULL,
  `url` text CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci,
  `legenda` varchar(155) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estrutura para tabela `tb_paginas`
--

CREATE TABLE `tb_paginas` (
  `id` int NOT NULL,
  `url_link` varchar(50) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL,
  `title` varchar(50) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL,
  `titulo` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL,
  `texto` text CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci,
  `description` varchar(160) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL,
  `keywords` text CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estrutura para tabela `tb_paginas_fotos`
--

CREATE TABLE `tb_paginas_fotos` (
  `id` int NOT NULL,
  `tb_paginas_id` int NOT NULL,
  `url` text CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci,
  `legenda` varchar(155) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estrutura para tabela `tb_sliders`
--

CREATE TABLE `tb_sliders` (
  `id` int NOT NULL,
  `url` text CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci,
  `legenda` varchar(155) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Despejando dados para a tabela `tb_sliders`
--

INSERT INTO `tb_sliders` (`id`, `url`, `legenda`) VALUES
(3, '9fb84110d9e7557f64adf6266fc515ad.png', 'legenda teste22'),
(4, '45be4642781a6f781583fba1303289e4.png', 'teste'),
(5, '8ef7d8ff46db6c8e62954b68d5ae2546.png', 'CAPÃO DA CANOA'),
(6, '11efe89e7e1f47b91d9fafc988bf467b.png', 'CAPÃO DA CANOA'),
(3, '9fb84110d9e7557f64adf6266fc515ad.png', 'legenda teste22'),
(4, '45be4642781a6f781583fba1303289e4.png', 'teste'),
(5, '8ef7d8ff46db6c8e62954b68d5ae2546.png', 'CAPÃO DA CANOA'),
(6, '11efe89e7e1f47b91d9fafc988bf467b.png', 'CAPÃO DA CANOA');

-- --------------------------------------------------------

--
-- Estrutura para tabela `tb_users`
--

CREATE TABLE `tb_users` (
  `id` int NOT NULL,
  `permissao` varchar(10) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL,
  `nome` varchar(155) DEFAULT NULL,
  `email` varchar(155) DEFAULT NULL,
  `user` varchar(30) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL,
  `password` varchar(60) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL,
  `dica` varchar(20) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL,
  `operador` int DEFAULT NULL,
  `ativo` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Despejando dados para a tabela `tb_users`
--

INSERT INTO `tb_users` (`id`, `permissao`, `nome`, `email`, `user`, `password`, `dica`, `operador`, `ativo`) VALUES
(1, 'superadmin', 'App5M', 'contato@app5m.com.br', 'admin', '$2a$08$O1JPvbNmyQWGIkfsXJpch.PuJweCx7cwIf9foYSALhWpcoc0q0DN.', 'guilila', 1, 1),
(9, 'admin', 'Carlos Lins', 'carlos@app5m.com.br', 'carlos', '$2a$08$L2DKa3c0GkmVe3bWu0DcSeEgIwO4avnIT5bcMP7wuhjwXWSbzLzc2', 'carlos14', 1, 1),
(11, 'admin', 'Moto Taxi Alves', 'contato@mototaxialves.com.br', 'mototaxialves', '$2a$08$CTaZW35PFaco43siAzdybeacmDQgpb8KLAwF6CuRFSVVKESbqKU4G', 'mototaxialves14', 1, 1);

-- --------------------------------------------------------

--
-- Estrutura para tabela `tb_videos`
--

CREATE TABLE `tb_videos` (
  `id` int NOT NULL,
  `tipo` varchar(7) DEFAULT NULL,
  `titulo` varchar(100) DEFAULT NULL,
  `url` text,
  `ativo` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `app_anuncios`
--
ALTER TABLE `app_anuncios`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_app_anuncios_app_categorias1_idx` (`app_categorias_id`),
  ADD KEY `fk_app_anuncios_app_subcategorias1_idx` (`app_subcategorias_id`),
  ADD KEY `fk_app_anuncios_app_users1_idx` (`app_users_id`);

--
-- Índices de tabela `app_anuncios_camas`
--
ALTER TABLE `app_anuncios_camas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_app_anuncios_camas_app_anuncios_types1_idx` (`app_anuncios_types_id`),
  ADD KEY `fk_app_anuncios_camas_app_camas1_idx` (`app_camas_id`);

--
-- Índices de tabela `app_anuncios_carac`
--
ALTER TABLE `app_anuncios_carac`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_app_anuncios_carac_app_anuncios1_idx` (`app_anuncios_id`),
  ADD KEY `fk_app_anuncios_carac_app_caracteristicas1_idx` (`app_caracteristicas_id`);

--
-- Índices de tabela `app_anuncios_fotos`
--
ALTER TABLE `app_anuncios_fotos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_app_anuncios_fotos_app_anuncios1_idx` (`app_anuncios_id`);

--
-- Índices de tabela `app_anuncios_info`
--
ALTER TABLE `app_anuncios_info`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_app_anuncios_info_app_anuncios_types1_idx` (`app_anuncios_types_id`);

--
-- Índices de tabela `app_anuncios_ing_types`
--
ALTER TABLE `app_anuncios_ing_types`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_app_anuncios_ing_types_app_anuncios1_idx` (`app_anuncios_id`);

--
-- Índices de tabela `app_anuncios_location`
--
ALTER TABLE `app_anuncios_location`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_app_anuncios_location_app_anuncios1_idx` (`app_anuncios_id`);

--
-- Índices de tabela `app_anuncios_types`
--
ALTER TABLE `app_anuncios_types`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_app_anuncios_types_app_anuncios1_idx` (`app_anuncios_id`);

--
-- Índices de tabela `app_anuncios_types_fotos`
--
ALTER TABLE `app_anuncios_types_fotos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_app_anuncios_fotos_app_anuncios_types2_idx` (`app_anuncios_types_id`);

--
-- Índices de tabela `app_anuncios_types_unidades`
--
ALTER TABLE `app_anuncios_types_unidades`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_type_numero` (`app_anuncios_types_id`,`numero`),
  ADD KEY `idx_type` (`app_anuncios_types_id`);

--
-- Índices de tabela `app_anuncios_valor`
--
ALTER TABLE `app_anuncios_valor`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_app_anuncios_valor_app_anuncios_types1_idx` (`app_anuncios_types_id`);

--
-- Índices de tabela `app_avaliacoes`
--
ALTER TABLE `app_avaliacoes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_app_avaliacoes_app_users1_idx` (`app_users_id`),
  ADD KEY `fk_app_avaliacoes_app_anuncios1_idx` (`app_anuncios_id`);

--
-- Índices de tabela `app_avaliacoes_ofc`
--
ALTER TABLE `app_avaliacoes_ofc`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_app_avaliacoes_app_users2_idx` (`app_users_id`),
  ADD KEY `fk_app_avaliacoes_app_anuncios2_idx` (`app_anuncios_id`),
  ADD KEY `fk_app_avaliacoes_ofc_app_reservas1_idx` (`app_reservas_id`);

--
-- Índices de tabela `app_camas`
--
ALTER TABLE `app_camas`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `app_cancelamentos`
--
ALTER TABLE `app_cancelamentos`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `app_caracteristicas`
--
ALTER TABLE `app_caracteristicas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_app_caracteristicas_app_categorias1_idx` (`app_categorias_id`);

--
-- Índices de tabela `app_carrinho`
--
ALTER TABLE `app_carrinho`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_app_carrinho_app_users1_idx` (`app_users_id`);

--
-- Índices de tabela `app_carrinho_conteudo`
--
ALTER TABLE `app_carrinho_conteudo`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_app_carrinho_conteudo_app_carrinho1_idx` (`app_carrinho_id`),
  ADD KEY `fk_app_carrinho_conteudo_app_anuncios_ing_types1_idx` (`app_anuncios_ing_types_id`);

--
-- Índices de tabela `app_cartoes`
--
ALTER TABLE `app_cartoes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `app_cartoes_ibfk_1` (`app_users_id`);

--
-- Índices de tabela `app_categorias`
--
ALTER TABLE `app_categorias`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `app_chat`
--
ALTER TABLE `app_chat`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `app_config`
--
ALTER TABLE `app_config`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `app_cupons`
--
ALTER TABLE `app_cupons`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_codigo` (`codigo`),
  ADD KEY `idx_users` (`app_users_id`),
  ADD KEY `idx_anuncios` (`app_anuncios_id`),
  ADD KEY `idx_codigo_ativo` (`codigo`,`ativo`),
  ADD KEY `idx_datas` (`data_inicio`,`data_fim`);

--
-- Índices de tabela `app_cupons_uso`
--
ALTER TABLE `app_cupons_uso`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_cupom` (`app_cupons_id`),
  ADD KEY `idx_user` (`app_users_id`),
  ADD KEY `idx_reserva` (`app_reservas_id`);

--
-- Índices de tabela `app_favoritos`
--
ALTER TABLE `app_favoritos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_app_favoritos_app_users1_idx` (`app_users_id`),
  ADD KEY `fk_app_favoritos_app_anuncios1_idx` (`app_anuncios_id`);

--
-- Índices de tabela `app_fcm`
--
ALTER TABLE `app_fcm`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_app_fcm_app_users1_idx` (`app_users_id`);

--
-- Índices de tabela `app_ical_bloqueios`
--
ALTER TABLE `app_ical_bloqueios`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_anuncio` (`app_anuncios_id`),
  ADD KEY `idx_link` (`app_ical_links_id`),
  ADD KEY `idx_datas` (`data_inicio`,`data_fim`),
  ADD KEY `idx_type` (`app_anuncios_types_id`),
  ADD KEY `idx_unidade` (`app_anuncios_types_unidades_id`);

--
-- Índices de tabela `app_ical_links`
--
ALTER TABLE `app_ical_links`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_anuncio` (`app_anuncios_id`),
  ADD KEY `idx_status` (`status`),
  ADD KEY `idx_type` (`app_anuncios_types_id`),
  ADD KEY `idx_unidade` (`app_anuncios_types_unidades_id`);

--
-- Índices de tabela `app_notificacoes`
--
ALTER TABLE `app_notificacoes`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `app_pagamentos`
--
ALTER TABLE `app_pagamentos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_app_pagamentos_app_users1_idx` (`app_users_id`),
  ADD KEY `fk_app_pagamentos_app_anuncios1_idx` (`app_anuncios_id`);

--
-- Índices de tabela `app_reservas`
--
ALTER TABLE `app_reservas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_app_reservas_app_users1_idx` (`app_users_id`),
  ADD KEY `fk_app_reservas_app_anuncios1_idx` (`app_anuncios_id`),
  ADD KEY `fk_app_reservas_app_pagamentos1_idx` (`app_pagamentos_id`);

--
-- Índices de tabela `app_reservas_cancelamentos`
--
ALTER TABLE `app_reservas_cancelamentos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_app_reservas_cancelamentos_app_reservas1_idx` (`app_reservas_id`),
  ADD KEY `fk_app_reservas_cancelamentos_app_users1_idx` (`app_users_id`),
  ADD KEY `fk_app_reservas_cancelamentos_app_cancelamentos1_idx` (`app_cancelamentos_id`);

--
-- Índices de tabela `app_saldo_pagamentos`
--
ALTER TABLE `app_saldo_pagamentos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_app_saldo_pagamentos_app_users1_idx` (`app_users_id`);

--
-- Índices de tabela `app_subcategorias`
--
ALTER TABLE `app_subcategorias`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_app_subcategorias_app_categorias1_idx` (`app_categorias_id`);

--
-- Índices de tabela `app_users`
--
ALTER TABLE `app_users`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `app_users_endereco`
--
ALTER TABLE `app_users_endereco`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_app_users_endereco_app_users1_idx` (`app_users_id`);

--
-- Índices de tabela `app_users_location`
--
ALTER TABLE `app_users_location`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_app_users_location_app_users1_idx` (`app_users_id`);

--
-- Índices de tabela `app_users_pix`
--
ALTER TABLE `app_users_pix`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_app_users_pix_app_users1_idx` (`app_users_id`);

--
-- Índices de tabela `app_users_saldo`
--
ALTER TABLE `app_users_saldo`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_app_users_saldo_app_users1_idx` (`app_users_id`);

--
-- Índices de tabela `app_users_two`
--
ALTER TABLE `app_users_two`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `tb_agenda`
--
ALTER TABLE `tb_agenda`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `tb_arquivos`
--
ALTER TABLE `tb_arquivos`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `tb_chat`
--
ALTER TABLE `tb_chat`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_tb_chat_tb_users1_idx` (`tb_users_id`);

--
-- Índices de tabela `tb_clientes`
--
ALTER TABLE `tb_clientes`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `tb_menus`
--
ALTER TABLE `tb_menus`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `tb_users`
--
ALTER TABLE `tb_users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT para tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `app_anuncios`
--
ALTER TABLE `app_anuncios`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=116;

--
-- AUTO_INCREMENT de tabela `app_anuncios_camas`
--
ALTER TABLE `app_anuncios_camas`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=81;

--
-- AUTO_INCREMENT de tabela `app_anuncios_carac`
--
ALTER TABLE `app_anuncios_carac`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1012;

--
-- AUTO_INCREMENT de tabela `app_anuncios_fotos`
--
ALTER TABLE `app_anuncios_fotos`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1108;

--
-- AUTO_INCREMENT de tabela `app_anuncios_info`
--
ALTER TABLE `app_anuncios_info`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=94;

--
-- AUTO_INCREMENT de tabela `app_anuncios_ing_types`
--
ALTER TABLE `app_anuncios_ing_types`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT de tabela `app_anuncios_location`
--
ALTER TABLE `app_anuncios_location`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=188;

--
-- AUTO_INCREMENT de tabela `app_anuncios_types`
--
ALTER TABLE `app_anuncios_types`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=95;

--
-- AUTO_INCREMENT de tabela `app_anuncios_types_fotos`
--
ALTER TABLE `app_anuncios_types_fotos`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=148;

--
-- AUTO_INCREMENT de tabela `app_anuncios_types_unidades`
--
ALTER TABLE `app_anuncios_types_unidades`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT de tabela `app_anuncios_valor`
--
ALTER TABLE `app_anuncios_valor`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=263;

--
-- AUTO_INCREMENT de tabela `app_avaliacoes`
--
ALTER TABLE `app_avaliacoes`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `app_avaliacoes_ofc`
--
ALTER TABLE `app_avaliacoes_ofc`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `app_camas`
--
ALTER TABLE `app_camas`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de tabela `app_cancelamentos`
--
ALTER TABLE `app_cancelamentos`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de tabela `app_caracteristicas`
--
ALTER TABLE `app_caracteristicas`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT de tabela `app_carrinho`
--
ALTER TABLE `app_carrinho`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de tabela `app_carrinho_conteudo`
--
ALTER TABLE `app_carrinho_conteudo`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de tabela `app_cartoes`
--
ALTER TABLE `app_cartoes`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de tabela `app_categorias`
--
ALTER TABLE `app_categorias`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de tabela `app_chat`
--
ALTER TABLE `app_chat`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49;

--
-- AUTO_INCREMENT de tabela `app_config`
--
ALTER TABLE `app_config`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de tabela `app_cupons`
--
ALTER TABLE `app_cupons`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de tabela `app_cupons_uso`
--
ALTER TABLE `app_cupons_uso`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de tabela `app_favoritos`
--
ALTER TABLE `app_favoritos`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT de tabela `app_fcm`
--
ALTER TABLE `app_fcm`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT de tabela `app_ical_bloqueios`
--
ALTER TABLE `app_ical_bloqueios`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=96;

--
-- AUTO_INCREMENT de tabela `app_ical_links`
--
ALTER TABLE `app_ical_links`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT de tabela `app_notificacoes`
--
ALTER TABLE `app_notificacoes`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT de tabela `app_pagamentos`
--
ALTER TABLE `app_pagamentos`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT de tabela `app_reservas`
--
ALTER TABLE `app_reservas`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT de tabela `app_reservas_cancelamentos`
--
ALTER TABLE `app_reservas_cancelamentos`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT de tabela `app_saldo_pagamentos`
--
ALTER TABLE `app_saldo_pagamentos`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

--
-- AUTO_INCREMENT de tabela `app_subcategorias`
--
ALTER TABLE `app_subcategorias`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT de tabela `app_users`
--
ALTER TABLE `app_users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=335;

--
-- AUTO_INCREMENT de tabela `app_users_endereco`
--
ALTER TABLE `app_users_endereco`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `app_users_location`
--
ALTER TABLE `app_users_location`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT de tabela `app_users_pix`
--
ALTER TABLE `app_users_pix`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT de tabela `app_users_saldo`
--
ALTER TABLE `app_users_saldo`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT de tabela `app_users_two`
--
ALTER TABLE `app_users_two`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=168;

--
-- AUTO_INCREMENT de tabela `tb_menus`
--
ALTER TABLE `tb_menus`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4456;

--
-- AUTO_INCREMENT de tabela `tb_users`
--
ALTER TABLE `tb_users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- Restrições para tabelas despejadas
--

--
-- Restrições para tabelas `app_anuncios`
--
ALTER TABLE `app_anuncios`
  ADD CONSTRAINT `fk_app_anuncios_app_categorias1` FOREIGN KEY (`app_categorias_id`) REFERENCES `app_categorias` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_app_anuncios_app_subcategorias1` FOREIGN KEY (`app_subcategorias_id`) REFERENCES `app_subcategorias` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_app_anuncios_app_users1` FOREIGN KEY (`app_users_id`) REFERENCES `app_users` (`id`) ON DELETE CASCADE;

--
-- Restrições para tabelas `app_anuncios_camas`
--
ALTER TABLE `app_anuncios_camas`
  ADD CONSTRAINT `fk_app_anuncios_camas_app_anuncios_types1` FOREIGN KEY (`app_anuncios_types_id`) REFERENCES `app_anuncios_types` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_app_anuncios_camas_app_camas1` FOREIGN KEY (`app_camas_id`) REFERENCES `app_camas` (`id`) ON DELETE CASCADE;

--
-- Restrições para tabelas `app_anuncios_carac`
--
ALTER TABLE `app_anuncios_carac`
  ADD CONSTRAINT `fk_app_anuncios_carac_app_anuncios1` FOREIGN KEY (`app_anuncios_id`) REFERENCES `app_anuncios` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_app_anuncios_carac_app_caracteristicas1` FOREIGN KEY (`app_caracteristicas_id`) REFERENCES `app_caracteristicas` (`id`) ON DELETE CASCADE;

--
-- Restrições para tabelas `app_anuncios_fotos`
--
ALTER TABLE `app_anuncios_fotos`
  ADD CONSTRAINT `fk_app_anuncios_fotos_app_anuncios1` FOREIGN KEY (`app_anuncios_id`) REFERENCES `app_anuncios` (`id`) ON DELETE CASCADE;

--
-- Restrições para tabelas `app_anuncios_info`
--
ALTER TABLE `app_anuncios_info`
  ADD CONSTRAINT `fk_app_anuncios_info_app_anuncios_types1` FOREIGN KEY (`app_anuncios_types_id`) REFERENCES `app_anuncios_types` (`id`) ON DELETE CASCADE;

--
-- Restrições para tabelas `app_anuncios_ing_types`
--
ALTER TABLE `app_anuncios_ing_types`
  ADD CONSTRAINT `fk_app_anuncios_ing_types_app_anuncios1` FOREIGN KEY (`app_anuncios_id`) REFERENCES `app_anuncios` (`id`) ON DELETE CASCADE;

--
-- Restrições para tabelas `app_anuncios_location`
--
ALTER TABLE `app_anuncios_location`
  ADD CONSTRAINT `fk_app_anuncios_location_app_anuncios1` FOREIGN KEY (`app_anuncios_id`) REFERENCES `app_anuncios` (`id`) ON DELETE CASCADE;

--
-- Restrições para tabelas `app_anuncios_types`
--
ALTER TABLE `app_anuncios_types`
  ADD CONSTRAINT `fk_app_anuncios_types_app_anuncios1` FOREIGN KEY (`app_anuncios_id`) REFERENCES `app_anuncios` (`id`) ON DELETE CASCADE;

--
-- Restrições para tabelas `app_anuncios_types_fotos`
--
ALTER TABLE `app_anuncios_types_fotos`
  ADD CONSTRAINT `fk_app_anuncios_fotos_app_anuncios_types2` FOREIGN KEY (`app_anuncios_types_id`) REFERENCES `app_anuncios_types` (`id`) ON DELETE CASCADE;

--
-- Restrições para tabelas `app_anuncios_valor`
--
ALTER TABLE `app_anuncios_valor`
  ADD CONSTRAINT `fk_app_anuncios_valor_app_anuncios_types1` FOREIGN KEY (`app_anuncios_types_id`) REFERENCES `app_anuncios_types` (`id`) ON DELETE CASCADE;

--
-- Restrições para tabelas `app_avaliacoes`
--
ALTER TABLE `app_avaliacoes`
  ADD CONSTRAINT `fk_app_avaliacoes_app_anuncios1` FOREIGN KEY (`app_anuncios_id`) REFERENCES `app_anuncios` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_app_avaliacoes_app_users1` FOREIGN KEY (`app_users_id`) REFERENCES `app_users` (`id`) ON DELETE CASCADE;

--
-- Restrições para tabelas `app_avaliacoes_ofc`
--
ALTER TABLE `app_avaliacoes_ofc`
  ADD CONSTRAINT `fk_app_avaliacoes_app_anuncios2` FOREIGN KEY (`app_anuncios_id`) REFERENCES `app_anuncios` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_app_avaliacoes_app_users2` FOREIGN KEY (`app_users_id`) REFERENCES `app_users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_app_avaliacoes_ofc_app_reservas1` FOREIGN KEY (`app_reservas_id`) REFERENCES `app_reservas` (`id`) ON DELETE CASCADE;

--
-- Restrições para tabelas `app_caracteristicas`
--
ALTER TABLE `app_caracteristicas`
  ADD CONSTRAINT `fk_app_caracteristicas_app_categorias1` FOREIGN KEY (`app_categorias_id`) REFERENCES `app_categorias` (`id`) ON DELETE CASCADE;

--
-- Restrições para tabelas `app_carrinho`
--
ALTER TABLE `app_carrinho`
  ADD CONSTRAINT `fk_app_carrinho_app_users1` FOREIGN KEY (`app_users_id`) REFERENCES `app_users` (`id`) ON DELETE CASCADE;

--
-- Restrições para tabelas `app_carrinho_conteudo`
--
ALTER TABLE `app_carrinho_conteudo`
  ADD CONSTRAINT `fk_app_carrinho_conteudo_app_anuncios_ing_types1` FOREIGN KEY (`app_anuncios_ing_types_id`) REFERENCES `app_anuncios_ing_types` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_app_carrinho_conteudo_app_carrinho1` FOREIGN KEY (`app_carrinho_id`) REFERENCES `app_carrinho` (`id`) ON DELETE CASCADE;

--
-- Restrições para tabelas `app_cartoes`
--
ALTER TABLE `app_cartoes`
  ADD CONSTRAINT `app_cartoes_ibfk_1` FOREIGN KEY (`app_users_id`) REFERENCES `app_users` (`id`) ON DELETE CASCADE;

--
-- Restrições para tabelas `app_favoritos`
--
ALTER TABLE `app_favoritos`
  ADD CONSTRAINT `fk_app_favoritos_app_anuncios1` FOREIGN KEY (`app_anuncios_id`) REFERENCES `app_anuncios` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_app_favoritos_app_users1` FOREIGN KEY (`app_users_id`) REFERENCES `app_users` (`id`) ON DELETE CASCADE;

--
-- Restrições para tabelas `app_fcm`
--
ALTER TABLE `app_fcm`
  ADD CONSTRAINT `fk_app_fcm_app_users1` FOREIGN KEY (`app_users_id`) REFERENCES `app_users` (`id`) ON DELETE CASCADE;

--
-- Restrições para tabelas `app_pagamentos`
--
ALTER TABLE `app_pagamentos`
  ADD CONSTRAINT `fk_app_pagamentos_app_anuncios1` FOREIGN KEY (`app_anuncios_id`) REFERENCES `app_anuncios` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_app_pagamentos_app_users1` FOREIGN KEY (`app_users_id`) REFERENCES `app_users` (`id`) ON DELETE CASCADE;

--
-- Restrições para tabelas `app_reservas`
--
ALTER TABLE `app_reservas`
  ADD CONSTRAINT `fk_app_reservas_app_anuncios1` FOREIGN KEY (`app_anuncios_id`) REFERENCES `app_anuncios` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_app_reservas_app_pagamentos1` FOREIGN KEY (`app_pagamentos_id`) REFERENCES `app_pagamentos` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_app_reservas_app_users1` FOREIGN KEY (`app_users_id`) REFERENCES `app_users` (`id`) ON DELETE CASCADE;

--
-- Restrições para tabelas `app_reservas_cancelamentos`
--
ALTER TABLE `app_reservas_cancelamentos`
  ADD CONSTRAINT `fk_app_reservas_cancelamentos_app_cancelamentos1` FOREIGN KEY (`app_cancelamentos_id`) REFERENCES `app_cancelamentos` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_app_reservas_cancelamentos_app_reservas1` FOREIGN KEY (`app_reservas_id`) REFERENCES `app_reservas` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_app_reservas_cancelamentos_app_users1` FOREIGN KEY (`app_users_id`) REFERENCES `app_users` (`id`) ON DELETE CASCADE;

--
-- Restrições para tabelas `app_saldo_pagamentos`
--
ALTER TABLE `app_saldo_pagamentos`
  ADD CONSTRAINT `fk_app_saldo_pagamentos_app_users1` FOREIGN KEY (`app_users_id`) REFERENCES `app_users` (`id`) ON DELETE CASCADE;

--
-- Restrições para tabelas `app_subcategorias`
--
ALTER TABLE `app_subcategorias`
  ADD CONSTRAINT `fk_app_subcategorias_app_categorias1` FOREIGN KEY (`app_categorias_id`) REFERENCES `app_categorias` (`id`) ON DELETE CASCADE;

--
-- Restrições para tabelas `app_users_endereco`
--
ALTER TABLE `app_users_endereco`
  ADD CONSTRAINT `fk_app_users_endereco_app_users1` FOREIGN KEY (`app_users_id`) REFERENCES `app_users` (`id`) ON DELETE CASCADE;

--
-- Restrições para tabelas `app_users_location`
--
ALTER TABLE `app_users_location`
  ADD CONSTRAINT `fk_app_users_location_app_users1` FOREIGN KEY (`app_users_id`) REFERENCES `app_users` (`id`) ON DELETE CASCADE;

--
-- Restrições para tabelas `app_users_pix`
--
ALTER TABLE `app_users_pix`
  ADD CONSTRAINT `fk_app_users_pix_app_users1` FOREIGN KEY (`app_users_id`) REFERENCES `app_users` (`id`) ON DELETE CASCADE;

--
-- Restrições para tabelas `app_users_saldo`
--
ALTER TABLE `app_users_saldo`
  ADD CONSTRAINT `fk_app_users_saldo_app_users1` FOREIGN KEY (`app_users_id`) REFERENCES `app_users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
