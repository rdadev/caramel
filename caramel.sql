-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 19/11/2023 às 21:48
-- Versão do servidor: 10.4.28-MariaDB
-- Versão do PHP: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `caramel`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `tbl_avaliacoes`
--

CREATE TABLE `tbl_avaliacoes` (
  `ID_AVALIACAO` int(30) NOT NULL,
  `ID_USUARIO` int(11) NOT NULL,
  `ID_PEDIDO` int(11) NOT NULL,
  `TX_AVALIACAO` int(1) NOT NULL,
  `DT_POSTAGEM_AVALIACAO` date NOT NULL,
  `DS_COMENTARIO_AVALIACAO` varchar(500) NOT NULL,
  `ID_LOJA` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `tbl_avaliacoes`
--

INSERT INTO `tbl_avaliacoes` (`ID_AVALIACAO`, `ID_USUARIO`, `ID_PEDIDO`, `TX_AVALIACAO`, `DT_POSTAGEM_AVALIACAO`, `DS_COMENTARIO_AVALIACAO`, `ID_LOJA`) VALUES
(5, 1050, 124053496, 4, '2023-11-19', 'Eurotester', 1660549009),
(6, 1050, 664125171, 4, '2023-11-19', 'AAAAAAAAAAA', 1660549009);

-- --------------------------------------------------------

--
-- Estrutura para tabela `tbl_avisos`
--

CREATE TABLE `tbl_avisos` (
  `ID_AVISO` int(30) NOT NULL,
  `NM_AVISO` varchar(50) NOT NULL,
  `DS_AVISO` varchar(300) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `tbl_avisos`
--

INSERT INTO `tbl_avisos` (`ID_AVISO`, `NM_AVISO`, `DS_AVISO`) VALUES
(1, 'Bem vindo(a)!', 'Bem vindo(a) ao sistema de delivery para petshops mais amado do Brasil. É um prazer ter você conosco. Para começar selecione uma opção no menu lateral.');

-- --------------------------------------------------------

--
-- Estrutura para tabela `tbl_bancos`
--

CREATE TABLE `tbl_bancos` (
  `ID_BANCO` int(5) NOT NULL,
  `NM_BANCO` varchar(50) NOT NULL,
  `NR_BANCO` varchar(6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `tbl_bancos`
--

INSERT INTO `tbl_bancos` (`ID_BANCO`, `NM_BANCO`, `NR_BANCO`) VALUES
(1, 'Banco Santander S.A.', '033'),
(2, 'Banco do Brasil', '001'),
(3, 'Banco Itaú', '012'),
(4, 'Banco Inter', '802'),
(5, 'Nubank Pagamentos IP', '401');

-- --------------------------------------------------------

--
-- Estrutura para tabela `tbl_carrinho`
--

CREATE TABLE `tbl_carrinho` (
  `ID_CARRINHO` int(11) NOT NULL,
  `ID_PRODUTO` int(30) NOT NULL,
  `ID_LOJA` int(30) NOT NULL,
  `ID_USUARIO` int(30) NOT NULL,
  `QT_CARRINHO` int(3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `tbl_lojas`
--

CREATE TABLE `tbl_lojas` (
  `ID_LOJA` int(30) NOT NULL,
  `NM_LOJA` varchar(80) NOT NULL,
  `NR_TELEFONE_LOJA` varchar(11) NOT NULL,
  `DS_EMAIL_LOJA` varchar(80) NOT NULL,
  `DS_LOJA` text NOT NULL,
  `NR_CNPJ_LOJA` varchar(14) NOT NULL,
  `DS_RAZAO_LOJA` varchar(80) NOT NULL,
  `DS_CAMINHO_IMAGEM_LOJA` varchar(100) NOT NULL,
  `DS_CAMINHO_CAPA_LOJA` varchar(100) NOT NULL,
  `NR_CEP_LOJA` varchar(8) NOT NULL,
  `NM_CIDADE_LOJA` varchar(50) NOT NULL,
  `SG_UF_LOJA` varchar(2) NOT NULL,
  `NM_BAIRRO_LOJA` varchar(50) NOT NULL,
  `DS_LOGRADOURO_LOJA` varchar(80) NOT NULL,
  `NR_CONFIRMACAO_LOJA` varchar(6) DEFAULT NULL,
  `DS_TEMPMAIL_LOJA` varchar(80) DEFAULT NULL,
  `ST_TEMPMAIL_LOJA` tinyint(1) NOT NULL,
  `ST_TURNO_LOJA` tinyint(1) NOT NULL DEFAULT 0,
  `NR_AGENCIA_LOJA` int(11) NOT NULL,
  `NR_CONTA_LOJA` int(11) NOT NULL,
  `ID_BANCO` int(5) DEFAULT NULL,
  `ST_MARKETING_LOJA` tinyint(1) NOT NULL,
  `DS_CHAVE_PIX_LOJA` varchar(30) NOT NULL,
  `HR_TEMPO_ENTREGA_LOJA` int(2) NOT NULL,
  `VL_TAXA_ENTREGA_LOJA` float(4,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `tbl_lojas`
--

INSERT INTO `tbl_lojas` (`ID_LOJA`, `NM_LOJA`, `NR_TELEFONE_LOJA`, `DS_EMAIL_LOJA`, `DS_LOJA`, `NR_CNPJ_LOJA`, `DS_RAZAO_LOJA`, `DS_CAMINHO_IMAGEM_LOJA`, `DS_CAMINHO_CAPA_LOJA`, `NR_CEP_LOJA`, `NM_CIDADE_LOJA`, `SG_UF_LOJA`, `NM_BAIRRO_LOJA`, `DS_LOGRADOURO_LOJA`, `NR_CONFIRMACAO_LOJA`, `DS_TEMPMAIL_LOJA`, `ST_TEMPMAIL_LOJA`, `ST_TURNO_LOJA`, `NR_AGENCIA_LOJA`, `NR_CONTA_LOJA`, `ID_BANCO`, `ST_MARKETING_LOJA`, `DS_CHAVE_PIX_LOJA`, `HR_TEMPO_ENTREGA_LOJA`, `VL_TAXA_ENTREGA_LOJA`) VALUES
(339201344, 'TESTE', '41000000000', 'rafael@amplesoft.com.br', '-', '00000000000099', 'TESTE', '../uploads/petshops/perfil_padrao.jpg', '../uploads/petshops/capa_padrao.jpg', '80230000', 'Curitiba', 'PR', 'Rebouças', 'Avenida Silva Jardim, 994', NULL, NULL, 0, 1, 0, 0, NULL, 0, '', 0, 0.00),
(1660549009, 'PETSHOP DA ALEGRIA', '41991187470', 'rafitoand@gmail.com', 'Somos a maior rede de petshop do Brasil.\r\nFaça seu pedido agora mesmo!', '15593000000099', 'PETSHOP LEGALIZADINHO LTDA', '../uploads/petshops/pf_8bea9270eac3a260cfccede90d3b1b19.jpg', '../uploads/petshops/cp_8bea9270eac3a260cfccede90d3b1b19.png', '80230000', 'Curitiba', 'PR', 'Rebouças', 'Avenida Silva Jardim, 994', NULL, NULL, 0, 0, 5023, 78020, NULL, 1, '', 35, 6.20);

-- --------------------------------------------------------

--
-- Estrutura para tabela `tbl_lojistas`
--

CREATE TABLE `tbl_lojistas` (
  `ID_LOJISTA` int(30) NOT NULL,
  `NM_LOJISTA` varchar(80) NOT NULL,
  `DS_SENHA_LOJISTA` varchar(150) NOT NULL,
  `NR_CPF_LOJISTA` varchar(11) NOT NULL,
  `DS_EMAIL_LOJISTA` varchar(50) NOT NULL,
  `ID_LOJA` int(40) NOT NULL,
  `ID_PERMISSAO_LOJISTA` int(1) NOT NULL,
  `ST_CONFIRMACAO_LOJISTA` tinyint(1) NOT NULL,
  `NR_CONFIRMACAO_LOJISTA` varchar(6) DEFAULT NULL,
  `ST_ATIVIDADE_LOJISTA` tinyint(1) NOT NULL,
  `DS_TEMPMAIL_LOJISTA` varchar(80) DEFAULT NULL,
  `ST_TEMPMAIL_LOJISTA` tinyint(1) NOT NULL,
  `ST_MASTER_LOJISTA` tinyint(1) NOT NULL,
  `DT_CADASTRO_LOJISTA` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `tbl_lojistas`
--

INSERT INTO `tbl_lojistas` (`ID_LOJISTA`, `NM_LOJISTA`, `DS_SENHA_LOJISTA`, `NR_CPF_LOJISTA`, `DS_EMAIL_LOJISTA`, `ID_LOJA`, `ID_PERMISSAO_LOJISTA`, `ST_CONFIRMACAO_LOJISTA`, `NR_CONFIRMACAO_LOJISTA`, `ST_ATIVIDADE_LOJISTA`, `DS_TEMPMAIL_LOJISTA`, `ST_TEMPMAIL_LOJISTA`, `ST_MASTER_LOJISTA`, `DT_CADASTRO_LOJISTA`) VALUES
(21, 'RAFAEL DE ANDRADE', '6db1f36d1089a5242e9ae5f96684d61b', '11000000099', 'rafitoand@gmail.com', 1660549009, 1, 1, NULL, 1, NULL, 0, 1, '2023-11-05'),
(22, 'ATENDENTE', '25d55ad283aa400af464c76d713c07ad', '99999999999', 'rafael@rda.dev.br', 1660549009, 4, 1, NULL, 1, NULL, 0, 0, '2023-11-05'),
(23, 'RAFAEL DE ANDRADE', '6db1f36d1089a5242e9ae5f96684d61b', '10000000999', 'rafael@amplesoft.com.br', 339201344, 1, 1, NULL, 1, NULL, 0, 1, '2023-11-13');

-- --------------------------------------------------------

--
-- Estrutura para tabela `tbl_medidas`
--

CREATE TABLE `tbl_medidas` (
  `ID_MEDIDA` int(5) NOT NULL,
  `SG_MEDIDA` varchar(2) NOT NULL,
  `NM_MEDIDA` varchar(20) NOT NULL,
  `DS_NOMENCLATURA_MEDIDA` varchar(35) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `tbl_medidas`
--

INSERT INTO `tbl_medidas` (`ID_MEDIDA`, `SG_MEDIDA`, `NM_MEDIDA`, `DS_NOMENCLATURA_MEDIDA`) VALUES
(1, 'UN', 'Unidade', 'Quantidade'),
(2, 'KG', 'Kilograma', 'Peso'),
(3, 'CX', 'Caixa', 'Quantidade'),
(4, 'DP', 'Display', 'Quantidade'),
(5, 'FD', 'Fardo', 'Quantidade'),
(6, 'GR', 'Gramas', 'Peso'),
(7, 'MT', 'Metro', 'Tamanho'),
(8, 'PC', 'Pacote', 'Quantidade'),
(9, 'VD', 'Vidro', 'Quantidade');

-- --------------------------------------------------------

--
-- Estrutura para tabela `tbl_pedidos`
--

CREATE TABLE `tbl_pedidos` (
  `ID_PEDIDO` int(50) NOT NULL,
  `ID_USUARIO` int(30) NOT NULL,
  `DT_TRANSACAO_PEDIDO` datetime NOT NULL,
  `DT_ENTREGA_PEDIDO` datetime NOT NULL,
  `ST_PEDIDO` int(1) NOT NULL,
  `ID_LOJISTA` int(30) DEFAULT NULL,
  `NR_TIPO_ENTREGA_PEDIDO` int(1) NOT NULL,
  `VL_TOTAL_PEDIDO` float(4,2) NOT NULL,
  `DS_OBSERVACAO_PEDIDO` varchar(100) NOT NULL,
  `ID_LOJA` int(30) NOT NULL,
  `NR_CEP_PEDIDO` varchar(8) NOT NULL,
  `NM_CIDADE_PEDIDO` varchar(60) NOT NULL,
  `SG_UF_PEDIDO` varchar(2) NOT NULL,
  `NM_BAIRRO_PEDIDO` varchar(40) NOT NULL,
  `DS_LOGRADOURO_PEDIDO` varchar(150) NOT NULL,
  `DS_COMPLEMENTO_PEDIDO` varchar(100) NOT NULL,
  `ST_RECUSA_PEDIDO` tinyint(1) NOT NULL,
  `ID_PAGAMENTO` int(11) NOT NULL,
  `ST_AVALIACAO_PEDIDO` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `tbl_pedidos`
--

INSERT INTO `tbl_pedidos` (`ID_PEDIDO`, `ID_USUARIO`, `DT_TRANSACAO_PEDIDO`, `DT_ENTREGA_PEDIDO`, `ST_PEDIDO`, `ID_LOJISTA`, `NR_TIPO_ENTREGA_PEDIDO`, `VL_TOTAL_PEDIDO`, `DS_OBSERVACAO_PEDIDO`, `ID_LOJA`, `NR_CEP_PEDIDO`, `NM_CIDADE_PEDIDO`, `SG_UF_PEDIDO`, `NM_BAIRRO_PEDIDO`, `DS_LOGRADOURO_PEDIDO`, `DS_COMPLEMENTO_PEDIDO`, `ST_RECUSA_PEDIDO`, `ID_PAGAMENTO`, `ST_AVALIACAO_PEDIDO`) VALUES
(124053496, 1050, '2023-11-19 01:00:00', '0000-00-00 00:00:00', 4, 23, 1, 30.00, '', 1660549009, '00000000', 'PR', 'Ru', 'Centro', 'Rua Alferes Poli, 802', 'Bloco S', 0, 4, 1),
(181920262, 1050, '2023-11-19 01:49:21', '0000-00-00 00:00:00', 4, 23, 1, 50.00, '', 1660549009, '00000000', 'Curitiba', 'PR', 'Centro', 'Rua Alferes Poli, 802', 'Bloco S', 0, 4, 0),
(296462774, 1050, '2023-11-19 01:00:00', '0000-00-00 00:00:00', 4, 23, 2, 31.70, 'Obs de teste', 339201344, '00000000', 'Curitiba', 'PR', 'Centro', 'Rua Alferes Poli, 802', 'Bloco S', 0, 1, 0),
(394365065, 1050, '2023-11-19 21:46:49', '0000-00-00 00:00:00', 4, 23, 2, 50.00, '', 1660549009, '00000000', 'Curitiba', 'PR', 'Centro', 'Rua Alferes Poli, 802', 'Bloco S', 0, 1, 0),
(552846175, 1050, '2023-11-19 01:45:37', '0000-00-00 00:00:00', 4, 23, 2, 59.90, '', 1660549009, '00000000', 'Curitiba', 'PR', 'Centro', 'Rua Alferes Poli, 802', 'Bloco S', 0, 2, 0),
(561882545, 1050, '2023-11-18 22:02:51', '0000-00-00 00:00:00', 1, 23, 1, 65.00, '', 1660549009, '00000000', 'Curitiba', 'PR', 'Centro', 'Rua Alferes Poli, 802', 'Bloco S', 1, 4, 0),
(664125171, 1050, '2023-11-18 21:50:37', '0000-00-00 00:00:00', 4, 23, 1, 50.00, '', 1660549009, '00000000', 'Curitiba', 'PR', 'Centro', 'Rua Alferes Poli, 802', 'Bloco S', 0, 4, 1),
(738547495, 1050, '2023-11-19 01:00:00', '0000-00-00 00:00:00', 4, 23, 1, 95.10, '', 339201344, '00000000', 'Curitiba', 'PR', 'Centro', 'Rua Alferes Poli, 802', 'Bloco S', 0, 4, 0),
(1266307947, 1050, '2023-11-18 23:06:23', '0000-00-00 00:00:00', 3, 23, 1, 31.70, '', 339201344, '00000000', 'Curitiba', 'PR', 'Centro', 'Rua Alferes Poli, 802', 'Bloco S', 1, 4, 0),
(1270776303, 1050, '2023-11-19 01:00:00', '0000-00-00 00:00:00', 4, 21, 1, 50.00, '', 1660549009, '00000000', 'Curitiba', 'PR', 'Centro', 'Rua Alferes Poli, 802', 'Bloco S', 0, 4, 0),
(1413470157, 1050, '2023-11-19 01:00:00', '0000-00-00 00:00:00', 4, 21, 1, 50.00, '', 1660549009, '00000000', 'PR', 'Ru', 'Centro', 'Rua Alferes Poli, 802', 'Bloco S', 0, 2, 0),
(1493491094, 1050, '2023-11-19 01:00:00', '0000-00-00 00:00:00', 4, 23, 1, 31.70, '', 339201344, '00000000', 'PR', 'Ru', 'Centro', 'Rua Alferes Poli, 802', 'Bloco S', 1, 4, 0),
(1895888884, 1050, '2023-11-18 22:44:11', '0000-00-00 00:00:00', 3, 21, 1, 74.90, '', 1660549009, '00000000', 'Curitiba', 'PR', 'Centro', 'Rua Alferes Poli, 802', 'Bloco S', 1, 4, 0),
(1908483846, 1050, '2023-11-19 00:12:01', '2023-11-19 11:10:14', 4, 21, 2, 30.00, '', 1660549009, '00000000', 'Curitiba', 'PR', 'Centro', 'Rua Alferes Poli, 802', 'Bloco S', 0, 1, 0);

-- --------------------------------------------------------

--
-- Estrutura para tabela `tbl_permissoes`
--

CREATE TABLE `tbl_permissoes` (
  `ID_PERMISSAO_LOJISTA` int(1) NOT NULL,
  `NM_PERMISSAO_LOJISTA` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `tbl_permissoes`
--

INSERT INTO `tbl_permissoes` (`ID_PERMISSAO_LOJISTA`, `NM_PERMISSAO_LOJISTA`) VALUES
(1, 'Administrador'),
(2, 'Gerente'),
(3, 'Operacional'),
(4, 'Atendente');

-- --------------------------------------------------------

--
-- Estrutura para tabela `tbl_produtos`
--

CREATE TABLE `tbl_produtos` (
  `ID_PRODUTO` int(11) NOT NULL,
  `ID_SECAO` int(11) NOT NULL,
  `ID_LOJA` int(11) NOT NULL,
  `NM_PRODUTO` varchar(90) NOT NULL,
  `DS_PRODUTO` varchar(500) NOT NULL,
  `NR_CODIGO_PRODUTO` varchar(15) NOT NULL,
  `ID_MEDIDA` int(11) NOT NULL,
  `VL_VENDA_PRODUTO` decimal(6,2) NOT NULL,
  `ST_ESTOQUE_PRODUTO` tinyint(1) NOT NULL,
  `QT_ESTOQUE_PRODUTO` decimal(5,3) NOT NULL,
  `VL_PROMOCAO_PRODUTO` decimal(6,2) NOT NULL,
  `DS_CAMINHO_IMAGEM_PRODUTO` varchar(130) NOT NULL,
  `ST_ATIVIDADE_PRODUTO` tinyint(1) NOT NULL,
  `QT_UNIDADE_PRODUTO` decimal(4,2) NOT NULL,
  `ST_EXCLUIDO_PRODUTO` tinyint(1) NOT NULL,
  `ST_PROMOCAO_PRODUTO` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `tbl_produtos`
--

INSERT INTO `tbl_produtos` (`ID_PRODUTO`, `ID_SECAO`, `ID_LOJA`, `NM_PRODUTO`, `DS_PRODUTO`, `NR_CODIGO_PRODUTO`, `ID_MEDIDA`, `VL_VENDA_PRODUTO`, `ST_ESTOQUE_PRODUTO`, `QT_ESTOQUE_PRODUTO`, `VL_PROMOCAO_PRODUTO`, `DS_CAMINHO_IMAGEM_PRODUTO`, `ST_ATIVIDADE_PRODUTO`, `QT_UNIDADE_PRODUTO`, `ST_EXCLUIDO_PRODUTO`, `ST_PROMOCAO_PRODUTO`) VALUES
(19, 18, 339201344, 'Biscoito Pedigree Biscrok Para Cães Adultos Multi 1 kg', 'Deliciosos biscoitos assados e crocantes com cálcio para o fortalecimento de ossos/dentes.Proteínas para o desenvolvimento muscular.Vitamina e mais sabor para seu cachorro com Ômega 6 para pelos mais brilhantes.Sabor irresistível que seu cão vai adorar.Momentos de carinho e conexão com o seu cachorro.', '', 2, 31.70, 1, 0.000, 0.00, '../uploads/produtos/pr_1293cfad89706918a5d1878c0070500b.jpg', 1, 1.00, 0, 0),
(20, 16, 1660549009, 'Ração Golden Special Adultos Sabor Frango Pacote 50Kg', 'Descrição legal aqui', '', 2, 89.90, 1, 11.000, 0.00, '../uploads/produtos/blank.svg', 1, 50.00, 0, 0),
(21, 1, 1660549009, 'Banho Promocional', 'Teste', '', 1, 50.00, 1, 5.000, 0.00, '../uploads/produtos/blank.svg', 1, 1.00, 0, 0),
(22, 20, 1660549009, 'Produtinho Legal', 'Teste descrição do produto.', '', 2, 15.00, 0, 0.000, 0.00, '../uploads/produtos/blank.svg', 1, 2.00, 1, 0),
(23, 16, 1660549009, 'Ração Special Dog Gold 25Kg', 'A ração tal tem tais benefícios e lalala.', '', 2, 59.90, 1, 0.000, 0.00, '../uploads/produtos/pr_565a1d1aab321434d6d0cd422a4c6084.png', 1, 25.00, 0, 0);

-- --------------------------------------------------------

--
-- Estrutura para tabela `tbl_produtos_pedidos`
--

CREATE TABLE `tbl_produtos_pedidos` (
  `ID_PRPEDIDO` int(11) NOT NULL,
  `ID_PRODUTO` int(30) NOT NULL,
  `ID_PEDIDO` int(30) NOT NULL,
  `QT_PRODUTO_PEDIDO` int(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `tbl_produtos_pedidos`
--

INSERT INTO `tbl_produtos_pedidos` (`ID_PRPEDIDO`, `ID_PRODUTO`, `ID_PEDIDO`, `QT_PRODUTO_PEDIDO`) VALUES
(10, 21, 1413470157, 1),
(11, 22, 124053496, 2),
(12, 19, 1493491094, 1),
(13, 21, 1270776303, 1),
(14, 19, 296462774, 1),
(15, 19, 738547495, 3),
(16, 23, 552846175, 1),
(17, 21, 394365065, 1),
(18, 21, 181920262, 1),
(19, 21, 664125171, 1),
(20, 22, 561882545, 1),
(21, 21, 561882545, 1),
(22, 23, 1895888884, 1),
(23, 22, 1895888884, 1),
(24, 19, 1266307947, 1),
(25, 22, 1908483846, 2);

-- --------------------------------------------------------

--
-- Estrutura para tabela `tbl_secoes`
--

CREATE TABLE `tbl_secoes` (
  `ID_SECAO` int(10) NOT NULL,
  `NM_SECAO` varchar(40) NOT NULL,
  `ID_LOJA` int(40) NOT NULL,
  `ID_TIPO_SECAO` int(5) NOT NULL,
  `ST_EXCLUIDO_SECAO` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `tbl_secoes`
--

INSERT INTO `tbl_secoes` (`ID_SECAO`, `NM_SECAO`, `ID_LOJA`, `ID_TIPO_SECAO`, `ST_EXCLUIDO_SECAO`) VALUES
(1, 'Banho e Tosa', 1660549009, 2, 0),
(3, 'Rações e Petiscos', 1660549009, 1, 1),
(5, 'Combo', 1660549009, 3, 1),
(6, 'Banho + Hidratatação', 1660549009, 3, 1),
(7, 'Banhinhos', 1660549009, 1, 1),
(8, 'Tester', 1660549009, 1, 1),
(9, 'Seção teste', 1660549009, 1, 1),
(10, 'Seção teste', 1660549009, 1, 1),
(11, 'Promoção do Rafa', 1660549009, 1, 1),
(12, 'Demonstração', 1660549009, 1, 1),
(13, 'Demonstração', 1660549009, 1, 1),
(14, 'seção tester', 1660549009, 1, 1),
(15, 'Seção tester', 1660549009, 2, 1),
(16, 'Rações', 1660549009, 1, 0),
(17, 'Rações', 339201344, 1, 0),
(18, 'Petiscos', 339201344, 1, 0),
(19, 'Brinquedos', 339201344, 1, 0),
(20, 'Legalizadinha', 1660549009, 1, 1),
(21, 'Promoções TESTER', 1660549009, 1, 1);

-- --------------------------------------------------------

--
-- Estrutura para tabela `tbl_tipos_secoes`
--

CREATE TABLE `tbl_tipos_secoes` (
  `ID_TIPO_SECAO` int(5) NOT NULL,
  `NM_TIPO_SECAO` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `tbl_tipos_secoes`
--

INSERT INTO `tbl_tipos_secoes` (`ID_TIPO_SECAO`, `NM_TIPO_SECAO`) VALUES
(1, 'Produtos'),
(2, 'Serviços'),
(3, 'Combo');

-- --------------------------------------------------------

--
-- Estrutura para tabela `tbl_tipo_pagamentos`
--

CREATE TABLE `tbl_tipo_pagamentos` (
  `ID_PAGAMENTO` int(11) NOT NULL,
  `NM_PAGAMENTO` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `tbl_tipo_pagamentos`
--

INSERT INTO `tbl_tipo_pagamentos` (`ID_PAGAMENTO`, `NM_PAGAMENTO`) VALUES
(1, 'Dinheiro'),
(2, 'Cartão de Crédito'),
(3, 'Cartão de Débito'),
(4, 'PIX');

-- --------------------------------------------------------

--
-- Estrutura para tabela `tbl_usuarios`
--

CREATE TABLE `tbl_usuarios` (
  `ID_USUARIO` int(30) NOT NULL,
  `NM_USUARIO` varchar(80) NOT NULL,
  `DS_SENHA_USUARIO` varchar(60) NOT NULL,
  `NR_CPF_USUARIO` varchar(11) NOT NULL,
  `DS_EMAIL_USUARIO` varchar(80) NOT NULL,
  `NR_TELEFONE_USUARIO` varchar(11) DEFAULT NULL,
  `ST_CONFIRMACAO_USUARIO` tinyint(1) NOT NULL,
  `NR_CONFIRMACAO_USUARIO` varchar(6) DEFAULT NULL,
  `NR_CEP_USUARIO` varchar(8) NOT NULL,
  `NM_CIDADE_USUARIO` varchar(50) NOT NULL,
  `SG_UF_USUARIO` varchar(2) NOT NULL,
  `NM_BAIRRO_USUARIO` varchar(50) NOT NULL,
  `DS_LOGRADOURO_USUARIO` varchar(65) NOT NULL,
  `DS_COMPLEMENTO_USUARIO` varchar(30) NOT NULL,
  `DS_TEMPMAIL_USUARIO` varchar(80) DEFAULT NULL,
  `ST_TEMPMAIL_USUARIO` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `tbl_usuarios`
--

INSERT INTO `tbl_usuarios` (`ID_USUARIO`, `NM_USUARIO`, `DS_SENHA_USUARIO`, `NR_CPF_USUARIO`, `DS_EMAIL_USUARIO`, `NR_TELEFONE_USUARIO`, `ST_CONFIRMACAO_USUARIO`, `NR_CONFIRMACAO_USUARIO`, `NR_CEP_USUARIO`, `NM_CIDADE_USUARIO`, `SG_UF_USUARIO`, `NM_BAIRRO_USUARIO`, `DS_LOGRADOURO_USUARIO`, `DS_COMPLEMENTO_USUARIO`, `DS_TEMPMAIL_USUARIO`, `ST_TEMPMAIL_USUARIO`) VALUES
(1043, 'RAFAEL DE ANDRADE', '6db1f36d1089a5242e9ae5f96684d61b', '00000000099', 'rafael@amplesoft.com.br', '41984689060', 1, NULL, '80230000', 'Curitiba', 'PR', 'Rebouças', 'Avenida Silva Jardim, 994', 'Apto 403', NULL, 0),
(1044, 'ANE ANDRADE', '670f8574bd93dd78bd568dab84c6733a', '06100000099', 'rafael@rda.dev.br', '41991187470', 1, NULL, '80230040', 'Curitiba', 'PR', 'Rebouças', 'Rua Engenheiros Rebouças', '123455', NULL, 0),
(1047, 'CONTATO AMPLESOFT', '6db1f36d1089a5242e9ae5f96684d61b', '99999999900', 'contato@amplesoft.com.br', '', 1, NULL, '83215100', 'Paranaguá', 'PR', 'Vila dos Comerciários', 'Rua Paulino Pioli', '', NULL, 0),
(1050, 'RAFAEL DE ANDRADE', '6db1f36d1089a5242e9ae5f96684d61b', '11099990000', 'rafitoand@gmail.com', '', 1, NULL, '00000000', 'Curitiba', 'PR', 'Centro', 'Rua Alferes Poli, 802', 'Bloco S', NULL, 0);

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `tbl_avaliacoes`
--
ALTER TABLE `tbl_avaliacoes`
  ADD PRIMARY KEY (`ID_AVALIACAO`),
  ADD KEY `LOJA` (`ID_LOJA`),
  ADD KEY `PEDIDO` (`ID_PEDIDO`),
  ADD KEY `USUARIO` (`ID_USUARIO`);

--
-- Índices de tabela `tbl_avisos`
--
ALTER TABLE `tbl_avisos`
  ADD PRIMARY KEY (`ID_AVISO`);

--
-- Índices de tabela `tbl_bancos`
--
ALTER TABLE `tbl_bancos`
  ADD PRIMARY KEY (`ID_BANCO`);

--
-- Índices de tabela `tbl_carrinho`
--
ALTER TABLE `tbl_carrinho`
  ADD PRIMARY KEY (`ID_CARRINHO`),
  ADD KEY `PRODUTO` (`ID_PRODUTO`),
  ADD KEY `2ID_LOJA` (`ID_LOJA`),
  ADD KEY `2ID_USUARIO` (`ID_USUARIO`);

--
-- Índices de tabela `tbl_lojas`
--
ALTER TABLE `tbl_lojas`
  ADD PRIMARY KEY (`ID_LOJA`),
  ADD UNIQUE KEY `NR_CNPJ_LOJA` (`NR_CNPJ_LOJA`),
  ADD UNIQUE KEY `DS_EMAIL_LOJA` (`DS_EMAIL_LOJA`),
  ADD KEY `BANCO_LOJA` (`ID_BANCO`);

--
-- Índices de tabela `tbl_lojistas`
--
ALTER TABLE `tbl_lojistas`
  ADD PRIMARY KEY (`ID_LOJISTA`),
  ADD KEY `ID_LOJA` (`ID_LOJA`),
  ADD KEY `ID_PERMISSAO` (`ID_PERMISSAO_LOJISTA`);

--
-- Índices de tabela `tbl_medidas`
--
ALTER TABLE `tbl_medidas`
  ADD PRIMARY KEY (`ID_MEDIDA`);

--
-- Índices de tabela `tbl_pedidos`
--
ALTER TABLE `tbl_pedidos`
  ADD PRIMARY KEY (`ID_PEDIDO`),
  ADD KEY `PEDIDO_LOJA` (`ID_LOJA`),
  ADD KEY `PEDIDO_LOJISTA` (`ID_LOJISTA`),
  ADD KEY `PEDIDO_USUARIO` (`ID_USUARIO`),
  ADD KEY `PEDIDO_PAGAMENTO` (`ID_PAGAMENTO`);

--
-- Índices de tabela `tbl_permissoes`
--
ALTER TABLE `tbl_permissoes`
  ADD PRIMARY KEY (`ID_PERMISSAO_LOJISTA`);

--
-- Índices de tabela `tbl_produtos`
--
ALTER TABLE `tbl_produtos`
  ADD PRIMARY KEY (`ID_PRODUTO`),
  ADD KEY `ID_SECAO` (`ID_SECAO`),
  ADD KEY `ID_LOJA_PRODUTO` (`ID_LOJA`),
  ADD KEY `ID_MEDIDA` (`ID_MEDIDA`);

--
-- Índices de tabela `tbl_produtos_pedidos`
--
ALTER TABLE `tbl_produtos_pedidos`
  ADD PRIMARY KEY (`ID_PRPEDIDO`),
  ADD KEY `PEDIDO_PRODUTO` (`ID_PRODUTO`),
  ADD KEY `PEDIDO_PEDIDO` (`ID_PEDIDO`);

--
-- Índices de tabela `tbl_secoes`
--
ALTER TABLE `tbl_secoes`
  ADD PRIMARY KEY (`ID_SECAO`),
  ADD KEY `ID_TIPO_SECAO` (`ID_TIPO_SECAO`),
  ADD KEY `ID_LOJAS` (`ID_LOJA`);

--
-- Índices de tabela `tbl_tipos_secoes`
--
ALTER TABLE `tbl_tipos_secoes`
  ADD PRIMARY KEY (`ID_TIPO_SECAO`);

--
-- Índices de tabela `tbl_tipo_pagamentos`
--
ALTER TABLE `tbl_tipo_pagamentos`
  ADD PRIMARY KEY (`ID_PAGAMENTO`);

--
-- Índices de tabela `tbl_usuarios`
--
ALTER TABLE `tbl_usuarios`
  ADD PRIMARY KEY (`ID_USUARIO`),
  ADD UNIQUE KEY `EMAIL` (`DS_EMAIL_USUARIO`) USING BTREE,
  ADD UNIQUE KEY `CPF` (`NR_CPF_USUARIO`);

--
-- AUTO_INCREMENT para tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `tbl_avaliacoes`
--
ALTER TABLE `tbl_avaliacoes`
  MODIFY `ID_AVALIACAO` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de tabela `tbl_avisos`
--
ALTER TABLE `tbl_avisos`
  MODIFY `ID_AVISO` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de tabela `tbl_bancos`
--
ALTER TABLE `tbl_bancos`
  MODIFY `ID_BANCO` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de tabela `tbl_carrinho`
--
ALTER TABLE `tbl_carrinho`
  MODIFY `ID_CARRINHO` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=63;

--
-- AUTO_INCREMENT de tabela `tbl_lojistas`
--
ALTER TABLE `tbl_lojistas`
  MODIFY `ID_LOJISTA` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT de tabela `tbl_medidas`
--
ALTER TABLE `tbl_medidas`
  MODIFY `ID_MEDIDA` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de tabela `tbl_pedidos`
--
ALTER TABLE `tbl_pedidos`
  MODIFY `ID_PEDIDO` int(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2072280077;

--
-- AUTO_INCREMENT de tabela `tbl_permissoes`
--
ALTER TABLE `tbl_permissoes`
  MODIFY `ID_PERMISSAO_LOJISTA` int(1) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de tabela `tbl_produtos`
--
ALTER TABLE `tbl_produtos`
  MODIFY `ID_PRODUTO` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT de tabela `tbl_produtos_pedidos`
--
ALTER TABLE `tbl_produtos_pedidos`
  MODIFY `ID_PRPEDIDO` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT de tabela `tbl_secoes`
--
ALTER TABLE `tbl_secoes`
  MODIFY `ID_SECAO` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT de tabela `tbl_tipos_secoes`
--
ALTER TABLE `tbl_tipos_secoes`
  MODIFY `ID_TIPO_SECAO` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de tabela `tbl_tipo_pagamentos`
--
ALTER TABLE `tbl_tipo_pagamentos`
  MODIFY `ID_PAGAMENTO` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de tabela `tbl_usuarios`
--
ALTER TABLE `tbl_usuarios`
  MODIFY `ID_USUARIO` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1053;

--
-- Restrições para tabelas despejadas
--

--
-- Restrições para tabelas `tbl_avaliacoes`
--
ALTER TABLE `tbl_avaliacoes`
  ADD CONSTRAINT `LOJA` FOREIGN KEY (`ID_LOJA`) REFERENCES `tbl_lojas` (`ID_LOJA`),
  ADD CONSTRAINT `PEDIDO` FOREIGN KEY (`ID_PEDIDO`) REFERENCES `tbl_pedidos` (`ID_PEDIDO`),
  ADD CONSTRAINT `USUARIO` FOREIGN KEY (`ID_USUARIO`) REFERENCES `tbl_usuarios` (`ID_USUARIO`);

--
-- Restrições para tabelas `tbl_carrinho`
--
ALTER TABLE `tbl_carrinho`
  ADD CONSTRAINT `2ID_LOJA` FOREIGN KEY (`ID_LOJA`) REFERENCES `tbl_lojas` (`ID_LOJA`),
  ADD CONSTRAINT `2ID_USUARIO` FOREIGN KEY (`ID_USUARIO`) REFERENCES `tbl_usuarios` (`ID_USUARIO`),
  ADD CONSTRAINT `PRODUTO` FOREIGN KEY (`ID_PRODUTO`) REFERENCES `tbl_produtos` (`ID_PRODUTO`);

--
-- Restrições para tabelas `tbl_lojas`
--
ALTER TABLE `tbl_lojas`
  ADD CONSTRAINT `BANCO_LOJA` FOREIGN KEY (`ID_BANCO`) REFERENCES `tbl_bancos` (`ID_BANCO`);

--
-- Restrições para tabelas `tbl_lojistas`
--
ALTER TABLE `tbl_lojistas`
  ADD CONSTRAINT `ID_LOJA` FOREIGN KEY (`ID_LOJA`) REFERENCES `tbl_lojas` (`ID_LOJA`),
  ADD CONSTRAINT `ID_PERMISSAO` FOREIGN KEY (`ID_PERMISSAO_LOJISTA`) REFERENCES `tbl_permissoes` (`ID_PERMISSAO_LOJISTA`);

--
-- Restrições para tabelas `tbl_pedidos`
--
ALTER TABLE `tbl_pedidos`
  ADD CONSTRAINT `PEDIDO_LOJA` FOREIGN KEY (`ID_LOJA`) REFERENCES `tbl_lojas` (`ID_LOJA`),
  ADD CONSTRAINT `PEDIDO_LOJISTA` FOREIGN KEY (`ID_LOJISTA`) REFERENCES `tbl_lojistas` (`ID_LOJISTA`),
  ADD CONSTRAINT `PEDIDO_PAGAMENTO` FOREIGN KEY (`ID_PAGAMENTO`) REFERENCES `tbl_tipo_pagamentos` (`ID_PAGAMENTO`),
  ADD CONSTRAINT `PEDIDO_USUARIO` FOREIGN KEY (`ID_USUARIO`) REFERENCES `tbl_usuarios` (`ID_USUARIO`);

--
-- Restrições para tabelas `tbl_produtos`
--
ALTER TABLE `tbl_produtos`
  ADD CONSTRAINT `ID_LOJA_PRODUTO` FOREIGN KEY (`ID_LOJA`) REFERENCES `tbl_lojas` (`ID_LOJA`),
  ADD CONSTRAINT `ID_MEDIDA` FOREIGN KEY (`ID_MEDIDA`) REFERENCES `tbl_medidas` (`ID_MEDIDA`),
  ADD CONSTRAINT `ID_SECAO` FOREIGN KEY (`ID_SECAO`) REFERENCES `tbl_secoes` (`ID_SECAO`);

--
-- Restrições para tabelas `tbl_produtos_pedidos`
--
ALTER TABLE `tbl_produtos_pedidos`
  ADD CONSTRAINT `PEDIDO_PEDIDO` FOREIGN KEY (`ID_PEDIDO`) REFERENCES `tbl_pedidos` (`ID_PEDIDO`),
  ADD CONSTRAINT `PEDIDO_PRODUTO` FOREIGN KEY (`ID_PRODUTO`) REFERENCES `tbl_produtos` (`ID_PRODUTO`);

--
-- Restrições para tabelas `tbl_secoes`
--
ALTER TABLE `tbl_secoes`
  ADD CONSTRAINT `ID_LOJAS` FOREIGN KEY (`ID_LOJA`) REFERENCES `tbl_lojas` (`ID_LOJA`),
  ADD CONSTRAINT `ID_TIPO_SECAO` FOREIGN KEY (`ID_TIPO_SECAO`) REFERENCES `tbl_tipos_secoes` (`ID_TIPO_SECAO`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
