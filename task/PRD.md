# PRD — MVP de Software para Madeireiras, Construtoras e Lojas de Materiais de Construção

## 1. Visão geral do produto

### 1.1 Nome provisório
Plataforma de Orçamentos e Gestão de Obras para Madeireiras e Materiais de Construção.

### 1.2 Objetivo
Desenvolver um software complementar ao sistema atual da empresa, com foco em duas frentes principais:

1. Geração e gestão de orçamentos
2. Gestão visual de obras em andamento

O produto não pretende substituir o ERP/sistema existente, mas sim atuar como uma camada operacional e comercial que acelera a elaboração de orçamentos e melhora o acompanhamento das obras.

### 1.3 Problema
Empresas do setor frequentemente enfrentam:

- lentidão na elaboração de orçamentos;
- dependência de operadores experientes para interpretar projetos;
- dificuldade de padronizar listas de materiais;
- retrabalho ao transformar projeto em orçamento comercial;
- pouca visibilidade consolidada sobre obras em andamento.

### 1.4 Proposta de valor
A solução deverá permitir que o usuário:

- importe a base de produtos da empresa via XLS/XLSX;
- envie um projeto em PDF ou imagem;
- obtenha um rascunho automático de orçamento com materiais e quantidades estimadas;
- revise e edite o orçamento antes da finalização;
- acompanhe obras em mapa com status, progresso e filtros.

---

## 2. Contexto e premissas

### 2.1 Premissas do negócio
- O sistema atual da empresa não será substituído.
- A nova solução será complementar.
- A empresa fornecerá:
  - planilha XLS/XLSX de produtos;
  - projetos em PDF;
  - exemplos de orçamentos atuais.
- O orçamento gerado deve ser editável.
- O sistema deve funcionar também em dispositivos móveis.
- O maior desafio técnico do produto é a interpretação de projetos para geração de orçamento.

### 2.2 Hipótese principal
Se a empresa conseguir transformar projetos em rascunhos de orçamento mais rapidamente, com menos retrabalho e com possibilidade de revisão humana, então haverá ganho de produtividade comercial e operacional.

### 2.3 Estratégia de MVP
O MVP deve ser posicionado como um sistema de **orçamento assistido**, e não como uma automação perfeita para qualquer tipo de projeto.

---

## 3. Objetivos do produto

### 3.1 Objetivos de negócio
- reduzir o tempo de elaboração de orçamentos;
- aumentar a velocidade de resposta comercial;
- diminuir retrabalho manual;
- melhorar a organização e visualização de obras;
- validar aderência do produto em ambiente real.

### 3.2 Objetivos do usuário
- subir projeto e receber um rascunho de orçamento;
- revisar rapidamente itens sugeridos;
- ajustar produtos e quantidades manualmente;
- acompanhar obras em andamento de forma visual e simples.

### 3.3 Métricas de sucesso do MVP
- tempo médio para gerar orçamento inicial;
- taxa de uso da geração automática;
- percentual de orçamentos que exigem apenas ajustes leves;
- tempo médio até finalização do orçamento;
- número de obras cadastradas e atualizadas;
- frequência de uso mobile.

---

## 4. Perfis de usuário

### 4.1 Administrador
Responsável por configurar usuários, permissões e catálogo de produtos.

### 4.2 Orçamentista / vendedor
Responsável por enviar projetos, revisar sugestões, ajustar itens e finalizar orçamentos.

### 4.3 Gestor de obras
Responsável por acompanhar obras, atualizar progresso, status e visualizar mapa.

### 4.4 Direção / gestão
Usuário que precisa de visão resumida sobre andamento das obras e pipeline de orçamentos.

---

## 5. Escopo do MVP

### 5.1 Funcionalidade 1 — Gestão de orçamentos

#### 5.1.1 Requisitos funcionais
- permitir upload de projeto em PDF, JPG e PNG;
- permitir cadastro/importação de produtos via XLS/XLSX;
- processar o projeto para extrair informações relevantes;
- sugerir materiais e quantidades estimadas;
- relacionar materiais sugeridos com produtos reais da base;
- gerar orçamento com:
  - produto;
  - quantidade;
  - unidade;
  - preço unitário;
  - subtotal;
  - total geral;
- permitir edição manual completa do orçamento;
- permitir salvar em rascunho;
- permitir versionamento de orçamento;
- permitir exportação do orçamento.

#### 5.1.2 Requisitos não funcionais
- o processamento deve ser auditável;
- o sistema deve indicar confiança baixa quando a leitura do projeto for incerta;
- o orçamento nunca deve ser considerado fechado sem revisão humana no MVP;
- o sistema deve suportar diferentes estruturas de planilha, via mapeamento de colunas.

### 5.2 Funcionalidade 2 — Gestão de obras

#### 5.2.1 Requisitos funcionais
- cadastrar obra com nome, cliente, endereço e responsável;
- geocodificar endereço ou aceitar coordenadas;
- exibir obras em mapa;
- registrar percentual de progresso;
- registrar status da obra;
- permitir filtros por:
  - responsável;
  - status;
  - progresso;
  - região;
- visualizar detalhes da obra;
- permitir atualização em mobile.

#### 5.2.2 Status sugeridos
- não iniciada;
- em andamento;
- atrasada;
- concluída;
- pausada.

---

## 6. Fora de escopo no MVP

- substituição do ERP atual;
- emissão fiscal;
- financeiro completo;
- compras e estoque avançado;
- leitura universal de qualquer disciplina de projeto;
- suporte robusto a DWG/IFC/BIM;
- cálculo estrutural avançado;
- automação total sem revisão humana;
- aplicativo nativo obrigatório já na primeira versão.

---

## 7. Fluxos principais

### 7.1 Fluxo de importação de produtos
1. Usuário acessa módulo de produtos.
2. Usuário envia arquivo XLS/XLSX.
3. Sistema apresenta mapeamento de colunas.
4. Usuário confirma importação.
5. Sistema valida e grava produtos.
6. Sistema exibe resumo da importação.

### 7.2 Fluxo de geração de orçamento
1. Usuário cria novo orçamento.
2. Usuário envia projeto em PDF ou imagem.
3. Sistema processa o documento.
4. Sistema extrai elementos relevantes.
5. Sistema sugere materiais e quantidades.
6. Sistema associa materiais à base de produtos.
7. Sistema gera rascunho do orçamento.
8. Usuário revisa e edita.
9. Usuário salva, aprova ou exporta.

### 7.3 Fluxo de gestão de obras
1. Usuário cadastra obra.
2. Usuário informa endereço ou coordenadas.
3. Sistema posiciona obra no mapa.
4. Usuário atualiza status e percentual.
5. Usuário utiliza filtros para acompanhar carteira de obras.

---

## 8. Requisitos detalhados por módulo

### 8.1 Autenticação e permissões
- login por e-mail e senha;
- perfis com permissões básicas;
- controle de acesso por módulo.

### 8.2 Catálogo de produtos
- cadastro via importação;
- atualização em lote;
- campos mínimos:
  - código interno, se houver;
  - nome;
  - unidade;
  - preço;
  - categoria opcional;
  - observações opcionais.

### 8.3 Projetos e documentos
- upload de arquivos;
- armazenamento seguro;
- histórico por orçamento;
- identificação do tipo de arquivo.

### 8.4 Processamento documental
- classificar documento;
- identificar se é PDF vetorial, PDF escaneado ou imagem;
- aplicar OCR quando necessário;
- extrair texto, áreas, ambientes, dimensões e anotações relevantes.

### 8.5 Motor de geração de orçamento
- transformar dados extraídos em itens de material;
- calcular quantidades estimadas;
- aplicar regras de consumo/perda;
- gerar evidência ou justificativa por item sempre que possível.

### 8.6 Match material → produto
- usar regras por categoria;
- usar sinônimos;
- usar busca aproximada;
- permitir troca manual do SKU/produto pelo usuário.

### 8.7 Editor de orçamento
- adicionar item manual;
- remover item;
- substituir produto;
- editar quantidade;
- editar preço;
- recalcular total;
- salvar versão.

### 8.8 Gestão de obras
- cadastro da obra;
- exibição em lista e mapa;
- status;
- progresso percentual;
- filtros;
- observações.

---

## 9. Requisitos técnicos da automação de orçamento

### 9.1 Princípio de funcionamento
A geração automática deverá seguir o conceito de **orçamento assistido**.

O sistema deve:
- tentar interpretar o projeto;
- sugerir quantitativos e materiais;
- casar com o catálogo da empresa;
- permitir revisão humana antes da finalização.

### 9.2 Papel do OCR
OCR será usado principalmente quando:
- o PDF não tiver texto selecionável;
- o arquivo for imagem;
- o projeto vier escaneado.

### 9.3 Papel da IA
IA poderá ser usada para:
- classificar tipo de documento;
- identificar padrões e entidades do projeto;
- sugerir categorias de materiais;
- desambiguar textos e anotações;
- ajudar no casamento entre descrição técnica e catálogo.

### 9.4 Papel das regras determinísticas
As regras determinísticas devem ser responsáveis por:
- cálculo de quantitativos;
- aplicação de perdas;
- conversão de unidade;
- montagem final do orçamento.

### 9.5 Diretriz técnica importante
A IA não deve ser a única fonte de decisão para fechar o orçamento. O orçamento do MVP deve permanecer editável e revisável.

---

## 10. Restrições e limitações esperadas

- projetos podem ter layouts muito diferentes;
- imagens escaneadas terão menor confiabilidade;
- alguns projetos não terão informação suficiente para cálculo completo;
- nem todo material poderá ser inferido automaticamente no MVP;
- o catálogo pode vir com nomenclaturas inconsistentes;
- o casamento entre material genérico e produto específico será uma das partes mais sensíveis do sistema.

---

## 11. Arquitetura recomendada

### 11.1 Arquitetura funcional
Módulos principais:
- autenticação e permissões;
- importação de produtos;
- gestão de catálogo;
- upload de projetos;
- processamento documental;
- motor de orçamento;
- editor de orçamento;
- gestão de obras;
- mapa e geolocalização;
- exportações.

### 11.2 Arquitetura técnica sugerida
- backend principal em Laravel;
- painel administrativo com Filament;
- banco PostgreSQL;
- filas com Redis;
- storage para documentos e anexos;
- worker separado para processamento de documentos e IA.

---

## 12. Stack recomendada

### 12.1 Recomendação principal para o MVP
- Laravel
- Filament
- PostgreSQL
- Redis
- armazenamento de arquivos em objeto/storage
- interface web responsiva

### 12.2 Mobile
Para o MVP, priorizar:
- web responsivo com boa experiência em celular;
- eventual evolução para app nativo em fase posterior.

### 12.3 Observação sobre NativePHP
NativePHP pode ser avaliado futuramente, mas não deve ser dependência obrigatória da primeira versão caso isso aumente risco, manutenção ou prazo.

---

## 13. UX e usabilidade

### 13.1 Princípios
- fluxo simples e rápido;
- revisão humana facilitada;
- baixa fricção para importação;
- visualização clara dos itens sugeridos;
- uso confortável em desktop e mobile.

### 13.2 Requisitos de interface
- tabela de orçamento com edição inline;
- filtros rápidos;
- indicadores visuais de confiança/sugestão;
- mapa com marcadores e legenda por status;
- telas responsivas.

---

## 14. Critérios de aceite do MVP

### 14.1 Critérios para orçamento
- usuário consegue importar catálogo com sucesso;
- usuário consegue subir projeto em PDF ou imagem;
- sistema gera rascunho com itens sugeridos;
- usuário consegue editar livremente o orçamento;
- usuário consegue salvar e exportar orçamento.

### 14.2 Critérios para obras
- usuário consegue cadastrar obra;
- usuário consegue visualizar obra no mapa;
- usuário consegue atualizar status e progresso;
- usuário consegue filtrar obras por critérios principais.

---

## 15. Roadmap sugerido

### 15.1 Fase 1 — MVP
- autenticação;
- importação de produtos via XLS/XLSX;
- upload de projetos;
- geração assistida de orçamento;
- edição manual;
- exportação;
- cadastro e mapa de obras.

### 15.2 Fase 2
- melhoria do processamento de projetos;
- score de confiança por item;
- integração com sistema atual via exportação/API;
- anexos/fotos de obra;
- notificações;
- múltiplas tabelas de preço.

### 15.3 Fase 3
- leitura de formatos mais avançados;
- inteligência incremental com base nas correções do usuário;
- analytics de conversão e produtividade;
- previsão de compra e consumo;
- app nativo, se validado.

---

## 16. Dependências para validação

### 16.1 Dependências do negócio
- acesso contínuo à empresa parceira;
- envio de projetos reais;
- envio de planilhas reais de produtos;
- acesso a exemplos de orçamento manual para benchmark.

### 16.2 Dependências do produto
- definição de categorias iniciais de material;
- definição do recorte inicial de projetos suportados;
- definição de regras de cálculo mais importantes;
- definição do formato de exportação esperado.

---

## 17. Riscos principais

### 17.1 Riscos de produto
- tentar cobrir escopo amplo demais no MVP;
- prometer automação total cedo demais;
- não recortar os tipos de obra suportados.

### 17.2 Riscos técnicos
- baixa qualidade dos documentos recebidos;
- dificuldade de interpretar projetos heterogêneos;
- inconsistência no catálogo de produtos;
- baixa precisão no match entre material e SKU;
- aumento de complexidade caso mobile nativo seja antecipado.

### 17.3 Mitigações
- começar com escopo estreito;
- tratar saída como sugestão editável;
- manter cálculo auditável;
- registrar feedback do usuário nas correções;
- adotar mobile web inicialmente.

---

## 18. Definição de sucesso do PRD

Este PRD será considerado bem-sucedido se orientar a construção de uma primeira versão que:

- gere valor real para a empresa parceira;
- reduza o esforço manual de orçamento;
- permita validação em ambiente real;
- abra caminho para evolução gradual da automação;
- comprove viabilidade comercial e técnica do produto.
